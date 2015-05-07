<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http响应处理类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Response extends Ada_Response{

	//响应内容
	private $body = '';
	
	/**
	* 获取Http响应内容
	* @param Void
	* @return String
	*/
	public function body() {
		if(func_num_args() > 0) {
			$this->body = func_get_arg(0);
		}
		return $this->body;
	}
	
	/**
	* 获取Http响应状态码
	* @param Void
	* @return Int
	*/
	public function code() {
		return 200;
	}

	public function __toString() {
		return $this->body;
	}
}