<?php
class	Ada_Route	extends	Ada_Wong {
	
	private	$routes = array();

	private $request = NULL;

	public	function	__construct(Request $request) {
		$this->request = $request;
	}

	/**
	* 设置路由信息
	* @param	Array	$routes	路由信息
	* @return	ref
	*/
	public	function	routes($routes=array()) {
		$this->routes = $routes;
		return	$this;
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