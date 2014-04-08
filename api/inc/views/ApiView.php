<?php

abstract class ApiView {
	abstract public function render($content);
	public function error($msg) {
		$this->render(array(
			'success' => false,
			'data' => array(
				'msg' => $msg
			)
		));
	}
	public function success($data) {
		$this->render(array(
			'success' => true,
			'data' => $data
		));
	}
}
