<?php
class Request {

	private	$protocol = 'http';

	public static function factory() {
		return	new Request();
	}

	public function method() {
		return $this;
	}

	public function execute() {
	
	}
}