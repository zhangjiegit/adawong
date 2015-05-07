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
		self::$response->body(curl_exec($ch));
		curl_close($ch);
	}
	
	/**
	* socket处理方式
	*/
	private	function fsoc() {
		$uri = parse_url(self::$uri);
		$data = '';
		if (self::$method == 'POST' && is_array(self::$params)) {
			$data = http_build_query(self::$params);
		}
		$fp = fsockopen($uri['host'], self::$port);
		$out = self::$method." ".$uri['path']." HTTP/1.0 \r\n";
		$out.= "Host:".$uri['host']."\r\n";
		$out.= "Content-length:".strlen($data)."\r\n";
		$out.= "\r\n";
		if (self::$method == 'POST' && !empty($data)) {
			$out.= $data;
			$out.="Content-type:application/x-www-form-urlencoded\r\n";
		}
		fwrite($fp, $out);
		$body = '';
		while(!feof($fp)) {
			$body= fgets($fp);
		}
		fclose($fp);
		Response::factory()->body($body);
	}

	/**
	* 自定义处理方式
	*/
	private function head() {
		
	}
}