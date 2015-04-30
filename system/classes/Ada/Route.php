<?php
class	Ada_Route {

	//路由规则表
	private $routes = array();

	//
	private $request = NULL;

	/**
	* @param Request $request Request对象实例
	*/
	public function __construct(Request &$request) {
		$this->request = $request;
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
	*			(<action>)/(<category>)/(<id>).html',
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
	
	/**
	* 验证路由表规则
	* @param Void
	* @return Void
	*/
	public function matchs() {
		$matchs = array();
		if ($this->routes) {
			foreach ($this->routes as $rule) {
				//定义正则捕获组名 如:(<action>)-(<category>)变成(?<action>)-(?<category>)
				$pattern = preg_replace('/(?<=[(])(?=[<])/','?', $rule[0]);
				//定义正则表达式字符范围 如:(?<action>)-(?<category>) 变成 (?<action>[\w]+)-(?<category>[\w]+)
				if ($rule[1] && is_array($rule[1])) { //用户自定义字符
					foreach ($rule[1] as $k => $v) {
						$pattern = preg_replace('/(?<='.$k.'[>])(?=[)])/', $v, $pattern);
					}
				} else { //默认[\w]+
					$pattern = preg_replace('/(?<=[>])(?=[)])/','[\w]+',$pattern);
				}
				//将当前路由规格与请求uri进行匹配，如果成功直接返回
				if(preg_match("/^{$pattern}$/u", $this->request->headers['uri'], $matchs)) {
					$this->request->route = $matchs;
					break;
				}
			}
		}
		//都没有匹配，抛出异常
		if (!$matchs) {
			throw	new	Ada_Exception('Unable to find a route to match');
		}
	}
}