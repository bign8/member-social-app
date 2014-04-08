<?php

abstract class ApiController {
	protected $request;
	protected $db;

	public function __construct(Request $req, $db) {
		$this->request = $req;
		$this->db = $db;
		$this->user = (object) $_SESSION['user'];
		// validate session?
	}
}
