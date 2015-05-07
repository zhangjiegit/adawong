<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Uri处理实现类
* Request::factory('welcome/say')->execute();
* Request::factory('http://www.baidu.com')->method('get')->execute();
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Uri {
	
	/**
	* 获取pathinfo,http://www.adawong.cn/a/b/c => a/b/c
	* @param Void
	* @return String
	*/
	public static function pathInfo() {
		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === FALSE) {
			$uri.= basename($_SERVER['SCRIPT_NAME']);
		}
		$url = preg_replace('#'.$_SERVER['SCRIPT_NAME'].'#', '', $uri);
		if (!empty($url)) {
			$url = trim($url, '\/');
			if (strpos($url, '?') !== FALSE) {
				return preg_replace(array('#(?<=[?]).+#', '#[?]#'), '', $url);
			} else {
				return $url;
			}
		}
		return '';
	}

	/**
	* 获取baseinfo,http://www.adawong.cn/a/b/c => http://www.adawong.cn/
	* @param Void
	* @return String
	*/
	public static function baseInfo($baseDir='/adawong') {
		return 'http://'.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']).$baseDir;
	}
	
	/**
	* 设置url
	* @param String $url 如果参数为空,返回pathinfo
	* @return String
	*/
	public static function siteInfo($url=NULL) {
		if ($url !== NULL) {
			return self::baseInfo().'/'.func_get_arg(0);
		} else {
			return self::pathinfo();
		}	
	}
}