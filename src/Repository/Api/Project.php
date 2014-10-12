<?php namespace Atrauzzi\TogglSdk\Domain\Repository\Api {

	use Atrauzzi\TogglSdk\Domain\Repository\Project as ProjectRepository;
	use Atrauzzi\TogglSdk\Domain\Project as ProjectModel;
	use Atrauzzi\TogglSdk\Domain\Workspace as WorkspaceModel;


	class Project extends Base implements ProjectRepository {

		/** @var \Atrauzzi\TogglSdk\Domain\Repository\Workspace */
		protected $workspaceRepository;

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Repository\Api\Workspace $workspaceRepository
		 */
		public function __construct(Workspace $workspaceRepository) {
			$this->workspaceRepository = $workspaceRepository;
		}

		//
		//
		//

		/**
		 * @param int $id
		 * @return \Atrauzzi\TogglSdk\Domain\Project
		 */
		public function getById($id) {
			return $this->togglData('projects/' . $id);
		}

		/**
		 * @param null|int|array $workspaceIds
		 * @return \Atrauzzi\TogglSdk\Domain\Project[]
		 */
		public function index($workspaceIds = null) {

			$workspaceIds = (array)$workspaceIds;

			if(!count($workspaceIds)) $workspaceIds = array_map(function (WorkspaceModel $workspace) {
				return $workspace->getId();
			}, $this->workspaceRepository->index())	;

			$projects = [];
			foreach($workspaceIds as $workspaceId) {
				// Regular
				$projects = array_merge($projects, (array)$this->togglData('workspaces/' . $workspaceId . '/projects', [
					'active' => 'both',
				]));
				// Templates
				$projects = array_merge($projects, (array)$this->togglData('workspaces/' . $workspaceId . '/projects', [
					'active' => 'both',
					'only_templates' => 'true'
				]));
			}

			return $projects;

		}

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Project $project
		 */
		public function persist(ProjectModel $project) {
			// TODO: Implement persist() method.
		}

	}

}