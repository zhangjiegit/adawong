<?php
abstract class	Ada_Route {

	//路由规则表
	private $routes = array();

	//保存单例对象
	private	static	$instance = NULL;
	
	/**
	* 获取一个路由对象
	* @param Void
	* @return Void
	*/
	public static function factory() {
		if (self::$instance === NULL) {
			self::$instance = new Route();
		}
		return	self::$instance;
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
		return	self::$instance;
	}
	
	/**
	* 验证路由表规则
	* @param Void
	* @return Void
	*/
	public function matchs($uri) {
		$matchs = array();
		if ($this->routes) {
			if ($uri == '') { //uri为空，则使用默认路由规则(路由规则表最后一项)
				return $this->parse(NULL, NULL);
			} else {
				//遍历路由表规则，如果匹配其中一项，则退出
				foreach ($this->routes as $rule) {
					//定义正则捕获组名 如:(<action>)-(<category>)=>(?<action>)-(?<category>)
					$pattern = preg_replace('/(?<=[(])(?=[<])/', '?', $rule[0]);
					//定义正则表达式字符范围 如:(?<action>)-(?<category>) => (?<action>[\w]+)-(?<category>[\w]+)
					$pattern = preg_replace('/(?<=[>])(?=[)])/', '[\w]+', $pattern);
					if (isset($rule[1]) && is_array($rule[1])) { //自定义字符范围
						foreach ($rule[1] as $k => $v) {
							$pattern = preg_replace('/(?<=('.$k.')[>])\[\\\w\]\+(?=[)])/', $v, $pattern);
						}
					}
					//判断$uri是包含多字节,如果包含,则需要转码
					if (!Utf8::isAscii($uri)) {
						$uri = iconv('gb2312', 'utf-8', $uri);
					}
					//将当前路由规格与uri进行匹配
					if(preg_match("~^{$pattern}$~u", $uri, $matchs)) { //成功匹配,交由Request处理
						$default = array(); //默认路由规则
						if (isset($rule[2])) {
							$default = $rule[2];
						}
						return	$this->parse($matchs, $default);
						break;
					}
				}
			}
			
		}
		//所有路由规则匹配失败,抛出异常
		if (!$matchs) {
			throw	new	Ada_Exception('Unable to find a route to match');
		}
	}

	/**
	* 解析路由规格及参数
	* @param $matchs 路由规则
	* @param $default 默认路由
	* @return Array
	*/
	private	function parse($matchs=NULL, $default=NULL) {
		$result = array();
		if ($matchs) {
			foreach ($matchs as $k => $v) { 
				//找出directory、controller、action
				if (preg_match('/^\b(directory|controller|action)\b$/i', $k)) {
					$result[$k] =  $v;
				} else {
					//找出请求参数
					if (preg_match('/^[a-z]+$/i', $k)) {
						$result['params'][$k] = $v;
					}
				}
			}
			unset($marchs);
		}
		//默认路由
		if ($default == NULL) {
			if(isset($this->routes[count($this->routes)-1][2])) {
				$default = $this->routes[count($this->routes)-1][2];
			}
			if (!isset($default['controller'])) {
				$default['controller'] = 'index';
			}
			if (!isset($default['action'])) {
				$default['action'] = 'index';
			}
		}
		return array_merge($default, $result);
	}

	//私有构造
	private	function __construct() {}
}