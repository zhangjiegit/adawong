<?php
class Request {
	
	//相应内容
	private	$body='';

	//定义允许的请求方法
	private $methods = array('GET', 'POST');

	//请求报文
	private $headers = array(
		'uri' => '',
		'method'=>'get',	
	);

	//请求协议
	private	$protocol = 'http';
	
	//Singleton pattern
	private	static $instance = NULL;
	
	public static function factory($uri) {
		if (self::$instance === NULL) {
			self::$instance = new Request($uri);
		}
		return	self::$instance;
	}
	
	/**
	* 定义http协议请求方式,请求方式必须是包含在$this->methods属性内
	* @param String $method 请求方式
	*/
	public function method($method='get') {
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
		if (strpos($this->headers['uri'], $this->protocol) !== FALSE) {
			$this->external(); //内部请求
		} else {
			$this->internal(); //外部请求
		}
		return	self::$instance;
	}

	/**
	* 内部请求
	* request::factory('welcome/say')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function internal() {
		//实例化一个路由
		$route = new route($this);
		$this->dispatch();
	}

	/**
	* 外部请求
	* request::factory('http://www.baidu.com')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function external() {
		$data = array();
		if (extension_loaded('curl')) {  //curl
			$ch = curl_init($this->uri);
			if ($this->headers['method'] === 'POST') {
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$this->body = curl_exec($ch);
			curl_close($ch);
		} else { //file_get_contents、fsockopen
			
		}
	}

	/**
	* 使用反射进行调度
	* @param Void
	* @return Void
	*/
	private function dispatch() {
	
	}
	
	private	function __construct($uri) {
		$this->headers['uri'] = $uri;
	}
}