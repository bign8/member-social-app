<?php

class ApiModel {
	protected $db;

	function __construct($db = null) {
		$this->db = $db;
	}
}