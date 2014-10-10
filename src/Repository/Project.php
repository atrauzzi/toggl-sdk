<?php namespace Atrauzzi\TogglSdk\Domain\Repository {

	use Atrauzzi\TogglSdk\Domain\Project as ProjectModel;


	interface Project {

		/**
		 * @param int $id
		 * @return \Atrauzzi\TogglSdk\Domain\Project
		 */
		public function getById($id);

		/**
		 * @param int $limit
		 * @param int $before
		 * @param int $after
		 * @return \Atrauzzi\TogglSdk\Domain\Project[]
		 */
		public function index($limit, $before = null, $after = null);

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Project $project
		 */
		public function persist(ProjectModel $project);

	}

}