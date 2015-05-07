<?php
abstract class Ada_Uri {
	
	public static function url() {
		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === FALSE) {
			$uri.= basename($_SERVER['SCRIPT_NAME']);
		}
		$url = preg_replace('#'.$_SERVER['SCRIPT_NAME'].'#', '', $uri);
		return trim($url, '\/?');
	}

	public static function base() {
	
	}

	public static function site() {
		
	}
}