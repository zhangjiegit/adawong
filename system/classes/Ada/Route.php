<?php
class	Ada_Route	extends	Ada_Wong {
	
	private	$routes = array();

	private $request = NULL;
	
	/**
	* @param	Request	$request	request类实例	
	* @return	Void
	*/
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
	* 遍历路由信息，找出匹配的directory、controller、action及参数信息
	*/
	public	function	matchs() {
		foreach ($this->rules as $rule) {

		}
	}

	public	function	__destruct() {
		unset($this->routes);
	}
}