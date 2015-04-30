<?php
class	Ada_Route	extends	Ada_Wong {
	
	private	$rules = array();

	private $request = NULL;

	public	function	__construct(Request $request) {
		$this->request = $request;
	}
	/**
	* setting uri and pattern
	* $this->routes(array(
		-item-|--------------uri-----------------------|pattean|defualt
		array('(<directory>)-(<controller>)-(<action>)',array(),array()),
	* ))
	*/
	public	function	routes($routes=array()) {
	
	}

	/**
	*
	*/
	public	function	matchs() {
		$uri = $this->request->uri;
		foreach ($this->rules as $rule) {

		}
	}
}