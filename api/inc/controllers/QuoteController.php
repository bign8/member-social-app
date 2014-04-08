<?php

class QuoteController extends ApiController {
	public function getAction() {
		$action = $this->request->getUrlElement(1);

		$data = array();
		if (preg_match('/^[0-9]+$/', $action)) {
			$sth = $this->db->prepare("SELECT * FROM quote WHERE quoteID=? LIMIT 1;");
			$sth->execute(array( (int)$action ));
			$data = $sth->fetch(PDO::FETCH_ASSOC);
		} elseif ($action == '') {
			$data = $this->db->query("SELECT * FROM quote;")->fetchAll(PDO::FETCH_ASSOC);
		} else {
			throw new Exception('Unsupported method', 405);
		}

		return $data;
	}
}
