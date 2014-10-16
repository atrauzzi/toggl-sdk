<?php namespace Atrauzzi\TogglSdk\Domain\Repository {

	use Atrauzzi\TogglSdk\Domain\Workspace as WorkspaceModel;


	interface Workspace {

		/**
		 * @param int $id
		 * @return \Atrauzzi\TogglSdk\Domain\Workspace
		 */
		public function find($id);

		/**
		 * @return \Atrauzzi\TogglSdk\Domain\Workspace[]
		 */
		public function index();

		/**
		 * @param \Atrauzzi\TogglSdk\Domain\Workspace $workspace
		 */
		public function persist(WorkspaceModel $workspace);

	}

}