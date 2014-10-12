<?php namespace Atrauzzi\TogglSdk\Domain\Repository\Api {

	use Atrauzzi\TogglSdk\Domain\Repository\Workspace as WorkspaceRepository;
	//
	use Atrauzzi\TogglSdk\Domain\Workspace as WorkspaceModel;


	class Workspace extends Base implements WorkspaceRepository {

		/**
		 * @param int $id
		 * @return null|\Atrauzzi\TogglSdk\Domain\Workspace
		 */
		public function getById($id) {
			return $this->togglData('workspaces/' . $id);
		}

		/**
		 * @return \Atrauzzi\TogglSdk\Domain\Workspace[]
		 */
		public function index() {
			return $this->togglData('workspaces');
		}

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Workspace $workspace
		 */
		public function persist(WorkspaceModel $workspace) {
			// TODO: Implement persist() method.
		}

	}

}