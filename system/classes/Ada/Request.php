<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http请求处理实现类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Request {

	//请求uri
	protected static $uri = '';
	//请求端口
	protected static $port = 80;
	//定义允许的请求方法
	protected static $methods = array('GET', 'POST');
	//请求方法
	protected static $method = 'get';
	//请求参数
	protected static $params = array();
	//请求协议
	protected static $protocol = 'http';
	//保存单例对象
	protected static $instance = NULL;
	//请求响应对象
	protected static $response = NULL;
	
	/**
	* 获取一个请求实例
	* 返回一个Request实例
	* @param String $uri Http请求的uri
	* @return Ref
	*/
	public static function factory($uri=NULL) {
		if (self::$instance === NULL) {
			self::$instance = new Request($uri);
		}
		self::$uri = $uri;
		self::$response = new Response();
		return	self::$instance;
	}
	
	/**
	* 设置Http请求方法,该方法是允许的请求方法内
	* use $this->methods 属性
	* @param String $method 请求方式
	* @param Mixed	$params	请求参数
	* @return Ref
	*/
	public function method($method='get', $params = NULL) {
		$method = strtoupper($method);
		if (!in_array($method, self::$methods)) {
			throw new Ada_Exception('Request method error');
		}
		self::$method = $method;
		self::$params = $params;
		return	self::$instance;
	}

	/**
	* 执行Http请求,根据设置的请求uri是否包含‘Http’,来判定是内部请求还是外部请求
	* @param Void
	* @return Respnse实例
	*/
	public function execute() {
		if (stripos(self::$uri, self::$protocol) !== FALSE) {
			$this->external(); //外部请求
		} else {
			$this->internal(); //内部请求
		}
		return self::$response;
	}

	/**
	* 执行内部请求
	* request::factory('welcome/say')->method()->execute();
	* @param Void
	* @return Void
	*/
	private function internal() {
		return new	Ada_Request_Internal(Route::factory()->routes(Config::load('Route'))->matchs($this->uri()));
	}
	
	/**
	* 执行外部请求
	* request::factory('http://www.baidu.com')->method()->execute();
	* @param Void
	* @return Void
	*/
	private function external() {
		return new	Ada_Request_External();
	}
	
	/**
	* 在没有设置http请求uri时,系统判定为内部请求
	* @param Void
	* @return String
	*/
	private function uri() {
		if (self::$uri != NULL) {
			return	self::$uri;
		} else {
			$uri = $_SERVER['REQUEST_URI'];
			$uri =  preg_replace(array('~'.$_SERVER['SCRIPT_NAME'].'~', '~(?<=[?]).*~'), '' , $uri);
			return trim($uri,'/?');
		}
	}

	/**
	* 构造方法
	* @param String $uri 请求的uri
	*/
	private	function __construct($uri) {
		self::$uri = $uri;
	}
}