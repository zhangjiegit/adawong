<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 内部请求处理具体实现类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class	Ada_Request_Internal	extends	Ada_Request {
	
	public	function	__construct($matchs) {
		$path = 'Controller'.DIRECTORY_SEPARATOR;
		if (isset($matchs['directory'])) {
			$path = $path.$matchs['directory'].DIRECTORY_SEPARATOR;
		}
		$path = $path.$matchs['controller'];
		$method = 'action_'.$matchs['action'];
		$class = str_replace(DIRECTORY_SEPARATOR, '_', $path);
		$refObject = new ReflectionClass($class);
		if ($refObject->getParentClass()->getName() != 'Controller') {
			throw	new	Ada_Exception("The requested URL ".self::$uri." was not found on this server");
		}
		$refMethod = new ReflectionMethod($class, $method);
		if($refMethod->ispublic()) {
			$refMethod->invokeArgs(new	$class(), isset($matchs['params']) ? $matchs['params'] : array());
		} else {
			throw	new	Ada_Exception("The requested URL ".self::$uri." was not found on this server");
		}
		unset($refMethod, $path, $method, $class);
	}
}