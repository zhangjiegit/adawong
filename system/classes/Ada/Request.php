<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 请求处理实现类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Request {

	//请求uri
	protected	static $uri = '';
	//请求端口
	protected	static $port = 80;
	//响应内容
	protected	static $body = '';
	//请求方法
	protected	static $methods = array('GET', 'POST');
	//请求参数
	protected	static $params = array();
	//请求协议
	protected	static $protocol = 'http';
	//保存单例对象
	protected	static $instance = NULL;
	
	/**
	* 获取一个请求实例
	* 返回一个Request实例，根据如果没有指定uri或者uri没有包含http，则判定为内部请求，否则判定为外部请求
	* @param String $uri 请求的uri
	* @return Ref
	*/
	public static function factory($uri=NULL) {
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
		return new	Ada_Request_Internal(Route::factory()->routes(Config::load('Route'))->matchs($this->uri()));
	}
	
	/**
	* 外部请求
	* request::factory('http://www.baidu.com')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function external() {
		return new	Ada_Request_External();
	}
	
	/**
	* 获取当前请求的uri
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

	/**
	* 返回相应信息
	*/
	public function __toString(){
		return self::$body;
	}
}