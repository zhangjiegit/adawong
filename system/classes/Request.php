<?php
class Request {

	//定义允许的请求方法
	private $methods = array('GET', 'POST');

	//请求报文
	private $headers = array(
		'uri' => '',
		'method' => 'get',
		'params' => NULL,
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
	* @param Mixed	$params	请求参数
	* @return Ref
	*/
	public function method($method='get', $params = NULL) {
		$method = strtoupper($method);
		if (!in_array($method, $this->methods)) {
			throw new Ada_Exception('Request method error');
		}
		$this->headers['method'] = $method;
		$this->headers['params'] = $params;
		return	self::$instance;
	}

	/**
	* 根据uri是否包含http，确定执行内部或者外部请求
	* @param Void
	* @return Ref
	*/
	public function execute() {
		if (strpos($this->headers['uri'], $this->protocol) !== FALSE) {
			return	$this->external(); //外部请求
		} else {
			return	$this->internal(); //内部请求
		}
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
		$route->routes(array(
			array('(<action>)-(<category>).html',array(
				'action'=>'(list)',
				'category'=>'[\d]+'
			),array())	
		))->matchs();
		$this->dispatch();
	}

	/**
	* 外部请求
	* request::factory('http://www.baidu.com')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function external() {
		if (extension_loaded('curl')) {  //curl
			$ch = curl_init($this->headers['uri']);
			if ($this->headers['method'] === 'POST') {
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->headers['params']);
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$content = curl_exec($ch);
			curl_close($ch);
		} else {
			$header = array(
					'method' => $this->headers['method'],
			);
			if ($this->headers['method'] === 'POST') { //post方式
				$header['header'] = 'Content-type:application/x-www-form-urlencoded'; 
			}
			if (is_array($this->headers['params'])) {
				$header['content'] = http_build_query($this->headers['params']);
			}
			$stream = stream_context_create(
				array('http' => $header)
			);
			$content = file_get_contents($this->headers['uri'], FALSE, $stream);
		}
		return	$content;
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