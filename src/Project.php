<?php namespace Atrauzzi\TogglSdk\Domain {

	class Project {

		/** @var int */
		protected $id;

		/** @var boolean */
		protected $archived;

		/**
		 * @return int
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * @param int $id
		 */
		public function setId($id) {
			$this->id = $id;
		}

		/**
		 * @return boolean
		 */
		public function isArchived() {
			return $this->archived;
		}

		/**
		 * @param boolean $archived
		 */
		public function setArchived($archived) {
			$this->archived = $archived;
		}

	}

}