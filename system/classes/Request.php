<?php
class Request {
	
	//请求协议
	private	$protocol = 'http';
	
	//请求方法
	private $methods = array('get', 'post');
	
	public static function factory() {
		return	new Request();
	}
	
	/**
	* 定义http协议请求方式,请求方式必须包含在$this->methods属性内
	* @param String $method 请求方式
	*/
	public function method($method) {
		return $this;
	}

	/**
	* 根据uri是否包含http，确定执行内部或者外部请求
	* @param Void
	* @return Ref
	*/
	public function execute() {
	
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
}