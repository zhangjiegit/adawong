<?php
class Ada_Config {
	
	public static function load($file){
		foreach (array(APPPATH, ADAPATH) as $path) {
			$path = $path.'configs';
			$find = Ada::findFile($file, $path, '.php');
			if ($find) {
				return include $find;
			}
		}
	}
}