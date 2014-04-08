<?php

class NoteController extends ApiController {
	public function postAction() {

		$noteModel = new NoteModel($this->db);
		$action = $this->request->getUrlElement(1);
		if ($action == '') $action = $this->request->getParameter('noteID');
		
		$data = array();
		if (preg_match('/^[0-9]+$/', $action)) {
			$noteModel->update(
				$action,
				$this->request->getParameter('note')
			);
			$data = $action;
		} elseif ($action == '') {
			$data = $noteModel->insert(
				$this->user->accountno,                    // src
				$this->request->getParameter('accountno'), // dest
				$this->request->getParameter('note')       // note
			);
		} else {
			throw new Exception('Unsupported method', 405);
		}

		return $data;
	}
}
