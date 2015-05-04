<?php
class Request {

	//请求uri
	private	static $uri = '';
	//请求端口
	private	static $port = 80;
	//请求方法
	private static $methods = array('GET', 'POST');
	//请求参数
	private	static $params = array();
	//请求协议
	private	static $protocol = 'http';
	//Singleton pattern
	private	static $instance = NULL;
	
	public static function factory($uri) {
		if (self::$instance === NULL) {
			self::$instance = new Request($uri);
		}
		self::$uri = $uri;
		return	self::$instance;
	}
	
	/**
	* 定义http协议请求方式,方法必须是包含在$this->methods属性内
	* @param String $method 请求方式
	* @param Mixed	$params	请求参数
	* @return Ref
	*/
	public function method($method='get', $params = NULL) {
		$method = strtoupper($method);
		if (!in_array($method, self::$methods)) {
			throw new Ada_Exception('Request method error');
		}
		self::$params = $params;
		return	self::$instance;
	}

	/**
	* 根据uri是否包含http，确定执行内部或者外部请求
	* @param Void
	* @return Ref
	*/
	public function execute() {
		if (strpos(self::$uri, self::$protocol) !== FALSE) {
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
		$this->dispatch(Route::factory()->routes(array(
			array('(<action>)-(<category>).html',array(
				'action'=>'(list)',
				'category'=>'[\d]+'
			),array('controller'=>'welcome','action'=>'index','directory'=>'admin'))	
		))->matchs(self::$uri));
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
	* 调度
	* @param Void
	* @return Void
	*/
	private function dispatch($matchs) {
		$path = 'Controller'.DIRECTORY_SEPARATOR;
		if (isset($matchs['directory'])) {
			$path = $path.$matchs['directory'].DIRECTORY_SEPARATOR;
		}
		$path = $path.$matchs['controller'];
		$method = 'action_'.$matchs['action'];
		$class = str_replace(DIRECTORY_SEPARATOR, '_', $path);
		$refMethod = new ReflectionMethod($class, $method);
		if($refMethod->ispublic()) {
			$refMethod->invokeArgs(new	$class(), $matchs['params']);
		} else {
			throw	new	Ada_Exception("The requested URL ".self::$uri." was not found on this server");
		}
		unset($refMethod, $path, $method, $class);
	}
	
	private	function __construct($uri) {
		$this->headers['uri'] = $uri;
	}
}