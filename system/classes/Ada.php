<?php

class Ada	extends	Ada_Wong {
	
	public	static $configure = array();

	private static $findPaths = array(APPPATH, ADAPATH);

	private	static $loadPaths = array();

    public static function findFile($file, $directory='.', $ext=NULL) {
		$file = $directory.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR.$ext;
		if (is_file($file) &&  is_readable($file)) {
			return	realpath($file);
		}
		return	NULL;
    }

	public static function loadFile($file, $directory, $ext=NULL) {
		if (isset($loadPaths[$directory], $loadPaths[$directory][$file])) {
			return	TRUE;
		}
		$file = self::findFile($file, $directory, $ext);
		
		if ($file && is_writeable($file)) {
			if (!isset(self::$loadPaths[$directory])) {
				self::$loadPaths[$directory] = array();
			}
			include	$file;
			self::$loadPaths[$directory][] = basename($file);
			return	TRUE;
		}
		return	FALSE;
	}
	
	public static function autoLoad($class) {
		$found = FALSE;
		foreach (self::$loadPaths as $path) {
			
		}
	}

	private function __construct() {}
}
