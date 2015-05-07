<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http请求处理实现类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Request {
	
	//请求uri
	protected $uri = '';
	//请求方法
	protected $method = 'get';
	//请求参数
	protected $params = array();
	//请求响应对象
	protected $response = NULL;
	//请求协议
	protected $protocol = 'http';
	//定义允许的请求方法
	protected $methods = array('GET', 'POST');
	
	/**
	* 获取request请求对象
	* @param String $uri 请求的uri
	* @return Request object
	*/
	public static function factory($uri=NULL) {
		return new Request($uri);
	}

	/**
	* 构造方法
	* @param String $uri 请求的uri
	*/
	public function __construct($uri=NULL) {
		$this->uri = $uri;
		$this->response = new Response();
	}

	/**
	* 设置Http请求方法
	* use $this->methods 属性
	* @param String $method 请求方式
	* @param Mixed	$params	请求参数
	* @return Ref
	*/
	public function method($method='get', $params = NULL) {
		$method = strtoupper($method);
		if (!in_array($method, $this->methods)) {
			throw new Ada_Exception('Request method error');
		}
		$this->method = $method;
		$this->params = $params;
		return $this;
	}

	/**
	* 执行Http请求,根据设置的请求uri是否包含‘Http’,
	* 来判定是内部请求还是外部请求
	* @param Void
	* @return Response实例
	*/
	public function execute() {
		if (stripos($this->uri, $this->protocol) !== FALSE) {
			$this->external(); //外部请求
		} else {
			$this->internal(); //内部请求
		}
		return $this->response;
	}

	/**
	* 执行内部请求
	* request::factory('welcome/say')->method()->execute();
	* @param Void
	* @return Void
	*/
	private function internal() {
		new	Ada_Request_Internal($this,Route::factory()
			->routes(Config::load('Route'))
			->matchs(Uri::url()));
	}
	
	/**
	* 执行外部请求
	* request::factory('http://www.baidu.com')->method()->execute();
	* @param Void
	* @return Void
	*/
	private function external() {
		new	Ada_Request_External($this);
	}
}