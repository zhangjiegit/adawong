<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库访问操作类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Database {
	
	//保存单例对象
	private static $instance = NULL;

	/**
	* 获取一个数据驱动实例
	*/
	public static function factory($name='default', $config=NULL) {
		if (self::$instance === NULL){
			if ($config === NULL) {
				$config = Config::load('database');
			}
			if (isset($config[$name], $config[$name]['driver'])) {
				$driver = 'Ada_Database_Driver_'.$config[$name]['driver'];
				self::$instance = new $driver($config[$name]);
			} else {
				throw new Ada_Exception('No database configuration file specified');
			}
		}
		return self::$instance;
	}
}
