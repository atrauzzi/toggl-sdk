<?php namespace Atrauzzi\TogglSdk\Domain\Repository\Api {

	use Atrauzzi\TogglSdk\Domain\Repository\Workspace as WorkspaceRepository;
	//
	use Atrauzzi\TogglSdk\Domain\Workspace as WorkspaceModel;


	class Workspace extends Base implements WorkspaceRepository {

		/** @var string */
		protected static $entityClass = 'Atrauzzi\TogglSdk\Domain\Workspace';

		/**
		 * @param int $id
		 * @return null|\Atrauzzi\TogglSdk\Domain\Workspace
		 */
		public function getById($id) {

			return self::togglData('workspaces/' . $id);

		}

		/**
		 * @return \Atrauzzi\TogglSdk\Domain\Workspace[]
		 */
		public function index() {
			// TODO: Implement index() method.
		}

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Workspace $workspace
		 */
		public function persist(WorkspaceModel $workspace) {
			// TODO: Implement persist() method.
		}

	}

}