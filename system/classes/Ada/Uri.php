<?php
abstract class Ada_Uri {
	
	public $url;

	public function __construct() {
		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === FALSE) {
			$uri.= basename($_SERVER['SCRIPT_NAME']);
		}
		preg_replace('#'.$_SERVER['SCRIPT_NAME'].'#', '', $uri);
	}

	public static function base() {
	
	}

	public static function site() {
		
	}

	public static function factory() {
		return new Uri();
	}
}