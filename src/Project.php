<?php namespace Atrauzzi\TogglSdk\Domain {

	class Project {

		/** @var int */
		protected $id;

		/** @var int */
		protected $wid;

		/** @var int */
		protected $cid;

		/** @var string */
		protected $name;

		/** @var boolean */
		protected $billable;

		/** @var boolean */
		protected $isPrivate;

		/** @var boolean */
		protected $autoEstimates;

		/** @var boolean */
		protected $active;

		/** @var boolean */
		protected $template;

		/** @var string */
		protected $color;

		/** @var string */
		protected $at;

		/** @var string */
		protected $createdAt;

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
		 * @return int
		 */
		public function getWid() {
			return $this->wid;
		}

		/**
		 * @param int $wid
		 */
		public function setWid($wid) {
			$this->wid = $wid;
		}

		/**
		 * @return int
		 */
		public function getCid() {
			return $this->cid;
		}

		/**
		 * @param int $cid
		 */
		public function setCid($cid) {
			$this->cid = $cid;
		}

		/**
		 * @return string
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * @param string $name
		 */
		public function setName($name) {
			$this->name = $name;
		}

		/**
		 * @return boolean
		 */
		public function getBillable() {
			return $this->billable;
		}

		/**
		 * @param boolean $billable
		 */
		public function setBillable($billable) {
			$this->billable = $billable;
		}

		/**
		 * @return boolean
		 */
		public function getIsPrivate() {
			return $this->isPrivate;
		}

		/**
		 * @param boolean $isPrivate
		 */
		public function setIsPrivate($isPrivate) {
			$this->isPrivate = $isPrivate;
		}

		/**
		 * @return boolean
		 */
		public function getAutoEstimates() {
			return $this->autoEstimates;
		}

		/**
		 * @param boolean $autoEstimates
		 */
		public function setAutoEstimates($autoEstimates) {
			$this->autoEstimates = $autoEstimates;
		}

		/**
		 * @return boolean
		 */
		public function getActive() {
			return $this->active;
		}

		/**
		 * @param boolean $active
		 */
		public function setActive($active) {
			$this->active = $active;
		}

		/**
		 * @return boolean
		 */
		public function getTemplate() {
			return $this->template;
		}

		/**
		 * @param boolean $template
		 */
		public function setTemplate($template) {
			$this->template = $template;
		}

		/**
		 * @return string
		 */
		public function getColor() {
			return $this->color;
		}

		/**
		 * @param string $color
		 */
		public function setColor($color) {
			$this->color = $color;
		}

		/**
		 * @return string
		 */
		public function getAt() {
			return $this->at;
		}

		/**
		 * @param string $at
		 */
		public function setAt($at) {
			$this->at = $at;
		}

		/**
		 * @return string
		 */
		public function getCreatedAt() {
			return $this->createdAt;
		}

		/**
		 * @param string $createdAt
		 */
		public function setCreatedAt($createdAt) {
			$this->createdAt = $createdAt;
		}

	}

}