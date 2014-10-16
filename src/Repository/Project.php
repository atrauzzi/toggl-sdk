<?php namespace Atrauzzi\TogglSdk\Domain\Repository {

	use Atrauzzi\TogglSdk\Domain\Project as ProjectModel;


	interface Project {

		/**
		 * @param int $id
		 * @return \Atrauzzi\TogglSdk\Domain\Project
		 */
		public function find($id);

		/**
		 * @param null|int|array $workspaceIds
		 * @return \Atrauzzi\TogglSdk\Domain\Project[]
		 */
		public function index($workspaceIds = null);

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Project $project
		 */
		public function persist(ProjectModel $project);

	}

}