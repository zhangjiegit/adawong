<?php
abstract	class	Ada_Wong {
	
	private	static $loadPaths = array(APPPATH, ADAPATH);
	
	public static function findFile($file, $directory, $ext=NULL) {
		$file = $directory.DIRECTORY_SEPARATOR.$file.$ext;
		if (is_file($file) && is_readable($file)) {
			return	realpath($file);
		}
		return	NULL;
	}

	public static function autoLoad($class) {
		$found = FALSE;
		if (preg_match('/^(?:[a-z]+(?:_[a-z])*)+$/i', $class)) {
			//$class = a_b_c, $path = a/b; $file=c.php
			if(preg_match('/(?<path>(?:[a-z]+[_])+)(?<file>[a-z]+)/i', $class, $matchs)) {
				$path = rtrim(str_replace('_', DIRECTORY_SEPARATOR, $matchs['path']),DIRECTORY_SEPARATOR);
				$file = $matchs['file'];
			} else {
				$path = '.';
				$file = $class;
			}
			//遍历自动载入目录
			foreach (self::$loadPaths as $directory) {
				$incfile = self::findFile($file, $directory.'classes'.DIRECTORY_SEPARATOR.$path,'.php');
				if (!class_exists($class) && $incfile) {
					return	include $incfile;
				}
			}
		}
		if (!$found) {
			throw	new	Ada_Exception('Class '.$class.' not found');
		}
		
	}
}