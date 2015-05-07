<?php
abstract class Ada_Uri {
	
	/**
	* »ñÈ¡pathinfo
	* @param Void
	* @return String
	*/
	public static function pathInfo() {
		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === FALSE) {
			$uri.= basename($_SERVER['SCRIPT_NAME']);
		}
		$url = preg_replace('#'.$_SERVER['SCRIPT_NAME'].'#', '', $uri);
		preg_match('#(?<pathinfo>(?<=\/).+(?=[?]))#', $url, $matchs);
		return (isset($matchs['pathinfo']) ? $matchs['pathinfo'] : '');
	}

	public static function baseInfo() {
	
	}

	public static function siteInfo() {
		
	}
}