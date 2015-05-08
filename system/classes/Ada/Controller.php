<?php
class Ada_Controller {
	
	protected $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}
	//action之前调用
	public function	before() {

	}
	//action 之后调用
	public function	after(){
		
	}
}