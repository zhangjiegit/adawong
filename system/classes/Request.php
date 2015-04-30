<?php
class Request {
	
	//请求报文
	private $headers = array(
		'method'=>'get',	
	);

	//请求协议
	private	$protocol = 'http';
	
	//定义允许的请求方法
	private $methods = array('GET', 'POST');
	
	//Singleton pattern
	private	$instance = NULL;
	
	public static function factory() {
		if (self::$instance === NULL) {
			self::$instance = new Request();
		}
		return	self::$instance;
	}
	
	/**
	* 定义http协议请求方式,请求方式必须是包含在$this->methods属性内
	* @param String $method 请求方式
	*/
	public function method($method) {
		$method = strtoupper($method);
		if (!in_array($method, $this->methods)) {
			throw new Ada_Exception('Request method error');
		}
		$this->headers['method'] = $method;
		return	self::$instance;
	}

	/**
	* 根据uri是否包含http，确定执行内部或者外部请求
	* @param Void
	* @return Ref
	*/
	public function execute() {
		return	self::$instance;
	}

	/**
	* 内部请求,请求系统内部uri
	* request::factory('welcome/say')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function internal () {
	
	}

	/**
	* 外部请求,请求指定uri
	* request::factory('http://www.baidu.com')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function external () {
	
	}
	
	private	function __construct() {}
}