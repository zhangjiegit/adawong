<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 外部请求处理具体实现类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Request_External extends Ada_Request {
	
	public function __construct() {
		if (extension_loaded('curl')) {
			$this->curl();
		} else if (function_exists('fsockopen')) {
			$this->fsoc();
		} else {
			$this->head();
		}
	}

	/**
	* curl处理方式
	*/
	private	function curl() {
		$ch = curl_init(self::$uri);
		if (self::$method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, is_array(self::$params) ? self::$params : array());
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		self::$body = curl_exec($ch);
		curl_close($ch);
	}
	
	/**
	* socket处理方式
	*/
	private	function fsoc() {
		$uri = str_ireplace('http://', '' , self::$uri);
		preg_match('/(?<uri>(?:http:\/\/)?.+\.(?:com|cn))(?<url>\/.+)?/', $uri, $matchs);
		$data = '';
		if (self::$method == 'POST' && is_array(self::$params)) {
			$data = http_build_query(self::$params);
		}
		$fp = fsockopen($matchs['uri'], self::$port);
		$out = self::$method." ".$matchs['url']." HTTP/1.0 \r\n";
		$out.= "Host:".$matchs['uri']."\r\n";
		$out.= "Content-length:".strlen($data)."\r\n";
		$out.= "\r\n";
		if (self::$method == 'POST' && !empty($data)) {
			$out.= $data;
		}
		fwrite($fp, $out);
		while(!feof($fp)) {
			self::$body.=fgets($fp);
		}
		fclose($fp);
	}
	
	/**
	* 自定义处理方式
	*/
	private function head() {
		
	}
}