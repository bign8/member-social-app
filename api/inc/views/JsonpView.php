<?php

class JsonpView extends JsonView {
	private $_callback;

	public function __construct($callback) {
		$this->_callback = $callback;
	}

	public function render($content) {
		$this->header();
		echo $this->_callback . '(' . $this->build($content) . ');';
		return true;
	}
}
