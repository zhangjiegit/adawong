<?php
abstract class Ada_Uri {
	
	/**
	* 获取pathinfo
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

	public static function baseInfo() {
		
	}

	public static function siteInfo() {
		
	}
}