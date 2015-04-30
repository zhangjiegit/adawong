<?php
class	Ada_Route	extends	Ada_Wong {
	
	private	$routes = array();

	private $request = NULL;

	public	function	__construct(Request $request) {
		$this->request = $request;
	}
	/**
	* setting uri and pattern
	* $this->routes(array(
		array('(<directory>)-(<controller>)-(<action>)', #uri
				array(),								 #pattrean
				array()									 #defalt
		),
	* ))
	*/
	public	function	routes($routes=array()) {
		$this->routes = $routes;
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