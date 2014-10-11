<?php namespace Atrauzzi\TogglSdk\Domain\Repository\Api\Normalizer {

	use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer as Base;


	/**
	 * Class GetSetMethod
	 *
	 * For some reason, the default Symfony serializer does not support toggling underscore behaviour
	 * on all attributes.  Which, is usually the case when dealing with consistent APIs.
	 *
	 * @package Atrauzzi\TogglSdk\Domain\Repository\Api\Normalizer
	 */
	class GetSetMethod extends Base {

		/**
		 * Format attribute name to access parameters or methods
		 * As option, if attribute name is found on camelizedAttributes array
		 * returns attribute name in camelcase format
		 *
		 * @param string $attributeName
		 * @return string
		 */
		protected function formatAttribute($attributeName) {
			return preg_replace_callback(
				'/(^|_|\.)+(.)/',
				function ($match) {
					return ('.' === $match[1] ? '_' : '') . strtoupper($match[2]);
				},
				$attributeName
			);
		}

	}

}