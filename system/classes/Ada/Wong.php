<?php
abstract	class	Ada_Wong {
	
	private	static $loadPaths = array(APPPATH, ADAPATH);
	
	/**
	* 查找文件
	* @param String $file 文件名
	* @param String $directory 目录
	* @param String	$ext 扩展名
	* @return Mixed
	*/
	public static function findFile($file, $directory, $ext=NULL) {
		$file = $directory.DIRECTORY_SEPARATOR.$file.$ext;
		if (is_file($file) && is_readable($file)) {
			return	realpath($file);
		}
		return	NULL;
	}

	/**
	* 载入文件
	* @param String $file 文件名
	* @param String $directory 目录
	* @param String	$ext 扩展名
	* @return Boolean
	*/
	public static function loadFile($file, $directory, $ext=NULL) {
		if (isset(self::$filePaths[$directory],self::$filePaths[$directory][$file])) {
			return	TRUE;
		}
		$file = self::findFile($file, $directory, $ext);
		if ($file && is_writeable($file)) {
			if (!isset(self::$filePaths[$directory])) {
				self::$filePaths[$directory] = array();
			}
			self::$filePaths[$directory][] = basename($file);
			include $file;
			return	TRUE;
		}
		return	FALSE;
	}

	/**
	* 自动载入文件
	* spl_autoload_register(array('Ada_Wong','autoload')); //注册自动载入文件
	* @param String $class 类名
	* @return Boolean
	*/
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
			//遍历目录，载入类文件
			foreach (self::$loadPaths as $directory) {
				$incfile = self::findFile($file, $directory.'classes'.DIRECTORY_SEPARATOR.$path,'.php');
				if (!class_exists($class) && $incfile && is_writeable($incfile)) {
					return	include $incfile;
				}
			}
		}
		if (!$found) {
			throw	new	Ada_Exception('Class '.$class.' not found');
		}
		
	}
}