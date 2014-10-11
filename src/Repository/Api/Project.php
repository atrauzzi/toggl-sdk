<?php namespace Atrauzzi\TogglSdk\Domain\Repository\Api {

	use Atrauzzi\TogglSdk\Domain\Repository\Project as ProjectRepository;
	use Atrauzzi\TogglSdk\Domain\Project as ProjectModel;


	class Project extends Base implements ProjectRepository {

		/**
		 * @param int $id
		 * @return \Atrauzzi\TogglSdk\Domain\Project
		 */
		public function getById($id) {
			// TODO: Implement getById() method.
		}

		/**
		 * @param int $limit
		 * @param int $before
		 * @param int $after
		 * @return \Atrauzzi\TogglSdk\Domain\Project[]
		 */
		public function index($limit, $before = null, $after = null) {
			// TODO: Implement index() method.
		}

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Project $project
		 */
		public function persist(ProjectModel $project) {
			// TODO: Implement persist() method.
		}

	}

}