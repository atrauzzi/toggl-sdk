<?php namespace Atrauzzi\TogglSdk\Domain\Repository\Api {

	use Symfony\Component\Serializer\Encoder\JsonEncoder;
	use Atrauzzi\TogglSdk\Domain\Repository\Api\Normalizer\GetSetMethod as GetSetMethodNormalizer;
	use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
	use Symfony\Component\Serializer\Serializer;
	//
	use Guzzle\Http\Client;
	use RuntimeException;


	/**
	 * Class Base
	 *
	 * Abstracts the toggl API lifecycle as a static utility library for repositories to use.
	 *
	 * @package Atrauzzi\TogglSdk\Repository\Api
	 */
	abstract class Base {

		/** @var \Guzzle\Http\Client */
		private static $client;

		/** @var string */
		private static $baseUrl = 'https://www.toggl.com/api/v8';

		/** @var string */
		private static $apiToken;

		/** @var string */
		private static $username;

		/** @var string */
		private static $password;

		/** @var string */
		private static $cookie;

		/** @var array */
		private static $log = [];

		//

		/** @var string */
		protected $entityClass;

		//
		//
		//

		/**
		 * Assigns the toggl API token to authenticate with.
		 *
		 * @param string $apiToken
		 */
		public static function setApiToken($apiToken) {
			self::$apiToken = $apiToken;
			self::$cookie = null;
		}

		/**
		 * Assigns the toggl username and password to authenticate with.
		 *
		 * @param string $username
		 * @param string $password
		 */
		public static function setCredentials($username, $password) {
			self::$username = $username;
			self::$password = $password;
		}

		/**
		 * Assigns a toggl-issued cookie to authenticate with.
		 *
		 * This is supported so that browser extensions can piggyback live authentication.
		 *
		 * @param $cookie
		 */
		public static function setCookie($cookie) {
			self::$cookie = $cookie;
		}

		public static function getLog() {
			return self::$log;
		}

		//
		//
		//

		/**
		 * Calls the toggl API and parses output as an array.
		 *
		 * @param string $endpoint
		 * @param string $method
		 * @param null|string $data
		 * @return null|array|bool|float|int|string
		 */
		protected final function togglArray($endpoint, $data = null, $method = 'GET') {
			return json_decode($this->togglRaw($endpoint, $data, $method), true);
		}

		/**
		 * Calls the Toggl API and attempts to deserialize the results.
		 *
		 * @param string $endpoint
		 * @param string $method
		 * @param null|mixed $data
		 * @return void|mixed
		 */
		protected final function togglData($endpoint, $data = null, $method = 'GET') {

			$data = $this->togglArray($endpoint, $data, $method);

			// Toggl returns data under a "data" key, which is not useful during deserialization.
			if(count($data) == 1 && !empty($data['data'])) {
				$data = $data['data'];
				return $this->deserialize(json_encode($data));
			}
			// Awaiting: https://github.com/symfony/symfony/pull/12066
			elseif($data) {
				return array_map(function ($entityData) {
					return $this->deserialize(json_encode($entityData));
				}, $data);
			}

		}

		//
		//
		//

		/**
		 * Plug this entire system into Serializer to support automatic mapping of JSON to domain objects.
		 *
		 * @param mixed $data
		 * @param \Symfony\Component\Serializer\Normalizer\NormalizerInterface $normalizer
		 * @return mixed
		 */
		private function deserialize($data, NormalizerInterface $normalizer = null) {
			return $this
				->getSerializer($normalizer)
				->deserialize($data, $this->getEntityClass(), 'json')
			;
		}

		/**
		 * Prepares a serializer for the current subclass.
		 *
		 * Deserialization can be customized by supplying a normalizer.
		 *
		 * @param \Symfony\Component\Serializer\Normalizer\NormalizerInterface $normalizer
		 * @return \Symfony\Component\Serializer\Serializer
		 */
		private function getSerializer(NormalizerInterface $normalizer = null) {

			if(!$normalizer)
				$normalizer = new GetSetMethodNormalizer();

			return new Serializer([$normalizer], [new JsonEncoder()]);

		}

		/**
		 * Gets the fully qualified entity class corresponding to the current repository subclass.
		 *
		 * There's an opportunity here to save some mental overhead through a convention. That said,
		 * you can always manually specify what entity class to use via the static attribute.
		 *
		 * @return string
		 */
		private function getEntityClass() {

			if(!$this->entityClass) {

				$parts = explode('\\', get_called_class());

				$class = array_pop($parts);
				while(array_pop($parts) and $parts[count($parts) - 1] != 'Domain');
				$parts[] = $class;

				$this->entityClass = implode('\\', $parts);

			}

			return $this->entityClass;

		}

		/**
		 * Creates and executes a request against the toggl API.
		 *
		 * @param string $endpoint
		 * @param string $method
		 * @param array|object $data
		 * @return string
		 */
		private function togglRaw($endpoint, $data = null, $method = 'GET') {

			if(!self::$client)
				self::$client = new Client(self::$baseUrl);

			$headers = [
				'Content-Type' => 'application/json',
			];

			if(self::$cookie) {
				$headers['Cookie'] = sprintf('toggl_api_session=%s', self::$cookie);
			}
			else {

				if(self::$apiToken)
					$token = sprintf('%s:api_token', self::$apiToken);
				elseif(self::$username && self::$password)
					$token = sprintf('%s:%s', self::$username, self::$password);
				else
					throw new RuntimeException('No toggl credentials provided.');

				$headers['Authorization'] = sprintf('Basic %s', base64_encode($token));

			}

			$response = null;
			$method = strtoupper($method);
			switch($method) {

				case 'GET':

					$request = self::$client->get($endpoint, $headers);

					if($data && is_array($data))
						foreach($data as $key => $value)
						$request->getQuery()->set($key, $value);
					self::$log[] = $request;
					break;

				case 'POST':
					$request = self::$client->post($endpoint, $headers, $data);
					break;

				default:
					throw new RuntimeException(sprintf('The HTTP method %s is not supported.', $method));
					break;

			}

			self::$log[] = $request;

			if(!$response = $request->send())
				throw new RuntimeException('There was an error communicating with toggl.');

			$status = (int)$response->getStatusCode();
			switch($status) {

				case 200:
					$responseData = $response->getBody(true);
					break;

				case 401:
					throw new RuntimeException('Authentication to the toggl API failed, verify your cookie or credentials.');
					break;

				case 404:
					throw new RuntimeException('The entity or endpoint requested does not exist.');
					break;

				case 500:
					throw new RuntimeException('The toggl API encountered an error while handling our request.');
					break;

				default:
					throw new RuntimeException(sprintf('Unsupported status code %s returned from toggl.', $status));
					break;

			}

			return $responseData;

		}

	}

}