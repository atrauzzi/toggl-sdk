<?php namespace Atrauzzi\TogglSdk\Domain\Repository\Api {

	use Symfony\Component\Serializer\Encoder\JsonEncoder;
	use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
	use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
	use Symfony\Component\Serializer\Serializer;
	//
	use Guzzle\Http\Client;
	use RuntimeException;


	/**
	 * Class Base
	 *
	 * Abstracts the toggl API lifecycle as a static utility library for repositories to communicate with.
	 *
	 * @package Atrauzzi\TogglSdk\Repository\Api
	 */
	abstract class Base {

		/** @var \Guzzle\Http\Client */
		private static $client;

		//

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

		//

		/** @var string */
		protected static $entityClass;

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
		protected final static function togglArray($endpoint, $method = 'GET', $data = null) {
			return  json_decode(self::togglRaw($endpoint, $method, $data), true);
		}

		/**
		 * Calls the Toggl API and attempts to deserialize the results.
		 *
		 * @param string $endpoint
		 * @param string $method
		 * @param null|mixed $data
		 * @return mixed
		 */
		protected final static function togglData($endpoint, $method = 'GET', $data = null) {

			$data = static::togglArray($endpoint, $method, $data);

			// Toggl returns data under a "data" key, which is not useful during deserialization.
			if(count($data) == 1 && !empty($data['data']))
				$data = $data['data'];

			return static::deserialize(json_encode($data));

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
		private static function deserialize($data, NormalizerInterface $normalizer = null) {
			return self
				::getSerializer($normalizer)
				->deserialize($data, static::$entityClass, 'json')
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
		private static function getSerializer(NormalizerInterface $normalizer = null) {
			return new Serializer([$normalizer ?: new GetSetMethodNormalizer()], [new JsonEncoder()]);
		}

		/**
		 * Creates and executes a request against the toggl API.
		 *
		 * @param string $endpoint
		 * @param string $method
		 * @param array|object $data
		 * @return string
		 */
		private static function togglRaw($endpoint, $method = 'GET', $data = null) {

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
					break;

				case 'POST':
					$request = self::$client->post($endpoint, $headers, $data);
					break;

				default:
					throw new RuntimeException(sprintf('The HTTP method %s is not supported.', $method));
					break;

			}

			if(!$response = $request->send())
				throw new RuntimeException('There was an error communicating with toggl.');

			$status = (int)$response->getStatusCode();
			switch($status) {

				case 200:
					$responseData = $response->getBody(true);
					break;

				case 401:
					throw new RuntimeException(
						'Authentication to the toggl API failed, verify your cookie or credentials.'
					);
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