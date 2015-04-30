<?php
define('DS',DIRECTORY_SEPARATOR);
define('APPPATH', dirname(__FILE__).DS.'app'.DS);
define('ADAPATH', dirname(__FILE__).DS.'system'.DS);
include	ADAPATH.DS.'classes'.DS.'Ada'.DS.'Wong.php';
spl_autoload_register(array('Ada_Wong','autoload'));
echo request::factory('http://www.baidu.com')->method()->execute();
?>
