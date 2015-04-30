<?php
class	Ada_Route {

	//路由规则表
	private $routes = array();

	/**
	* @param Request $request Request对象实例
	*/
	public function __construct(Request &$request) {
	
	}

	/**
	* 设置路由信息
	* @param Array	$routes 路由规则
	* $this->routes(
	*	array(' 
	*		array( #匹配 http://localhost/index.php/a-b-c
	*			(<directory>)-(<controller>)-(<action>)',
	*			array(
	*				'directory'=>'[a-z]+',
	*				'controller'=>'[a-z]+',
	*				'action'=>'[a-z]+'
	*			),
	*			array( //默认模块、控制器、action
	*				'directory'=>'front'
	*				'controller'=>'welcome',
	*				'action'=>'index'
	*			)
	*		),
	*		array( #匹配 http://localhost/index.php/list/3/1.html
	*			(<action>)/(<category>)/(id).html',
	*			array(
	*				'controller'=>'(product)',
	*				'action'=>'(list)'
	*               'category'=>'[1-9][0-9]*'
	*				'id'=>'[1-9][0-9]*'
	*			),
	*			array( //默认控制器、action
	*				'controller'=>'product',
	*				'action'=>'list'
	*			)
	*		)
	*	)
	* );
	* @return Self
	*/
	public function routes($routes = array()) {
		if(is_array($routes)) {
			$this->routes = $routes;
		}
		return $this;
	}

	public function matchs() {
		if ($this->routes) {
			
		}
	}
}