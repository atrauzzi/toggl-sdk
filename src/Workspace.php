<?php namespace Atrauzzi\TogglSdk\Domain {

	class Workspace {

		/** @var int */
		protected $id;

		/** @var string */
		protected $name;

		/** @var boolean */
		protected $premium;

		/** @var int */
		protected $defaultHourlyRate;

		/** @var string */
		protected $defaultCurrency;

		/** @var boolean */
		protected $onlyAdminsMayCreateProjects;

		/** @var boolean */
		protected $onlyAdminsSeeTeamDashboard;

		/** @var boolean */
		protected $projectsBillableByDefault;

		/** @var int */
		protected $rounding;

		/** @var int */
		protected $roundingMinutes;

		/**
		 * @return string
		 */
		public function getDefaultCurrency() {
			return $this->defaultCurrency;
		}

		/**
		 * @param string $defaultCurrency
		 */
		public function setDefaultCurrency($defaultCurrency) {
			$this->defaultCurrency = $defaultCurrency;
		}

		/**
		 * @return int
		 */
		public function getDefaultHourlyRate() {
			return $this->defaultHourlyRate;
		}

		/**
		 * @param int $defaultHourlyRate
		 */
		public function setDefaultHourlyRate($defaultHourlyRate) {
			$this->defaultHourlyRate = $defaultHourlyRate;
		}

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
		public function isOnlyAdminsMayCreateProjects() {
			return $this->onlyAdminsMayCreateProjects;
		}

		/**
		 * @param boolean $onlyAdminsMayCreateProjects
		 */
		public function setOnlyAdminsMayCreateProjects($onlyAdminsMayCreateProjects) {
			$this->onlyAdminsMayCreateProjects = $onlyAdminsMayCreateProjects;
		}

		/**
		 * @return boolean
		 */
		public function isOnlyAdminsSeeTeamDashboard() {
			return $this->onlyAdminsSeeTeamDashboard;
		}

		/**
		 * @param boolean $onlyAdminsSeeTeamDashboard
		 */
		public function setOnlyAdminsSeeTeamDashboard($onlyAdminsSeeTeamDashboard) {
			$this->onlyAdminsSeeTeamDashboard = $onlyAdminsSeeTeamDashboard;
		}

		/**
		 * @return boolean
		 */
		public function isPremium() {
			return $this->premium;
		}

		/**
		 * @param boolean $premium
		 */
		public function setPremium($premium) {
			$this->premium = $premium;
		}

		/**
		 * @return boolean
		 */
		public function isProjectsBillableByDefault() {
			return $this->projectsBillableByDefault;
		}

		/**
		 * @param boolean $projectsBillableByDefault
		 */
		public function setProjectsBillableByDefault($projectsBillableByDefault) {
			$this->projectsBillableByDefault = $projectsBillableByDefault;
		}

		/**
		 * @return int
		 */
		public function getRounding() {
			return $this->rounding;
		}

		/**
		 * @param int $rounding
		 */
		public function setRounding($rounding) {
			$this->rounding = $rounding;
		}

		/**
		 * @return int
		 */
		public function getRoundingMinutes() {
			return $this->roundingMinutes;
		}

		/**
		 * @param int $roundingMinutes
		 */
		public function setRoundingMinutes($roundingMinutes) {
			$this->roundingMinutes = $roundingMinutes;
		}

	}

}