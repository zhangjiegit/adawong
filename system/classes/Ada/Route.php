<?php
class	Ada_Route	extends	Ada_Wong {
	
	private	$rules = array();

	private $request = NULL;

	public	function	__construct(Request $request) {
		$this->request = $request;
	}
	/**
	* 设置路由uri及规则
	* $this->routes(array(
		array('(<directory>)-(<controller>)-(<action>).html',array(),array()),
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