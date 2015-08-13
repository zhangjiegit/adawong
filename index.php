<?php
define('DS',DIRECTORY_SEPARATOR);
define('APPPATH', dirname(__FILE__).DS.'app'.DS);
define('ADAPATH', dirname(__FILE__).DS.'system'.DS);
include	ADAPATH.DS.'classes'.DS.'Ada'.DS.'Wong.php';
spl_autoload_register(array('Ada_Wong','autoload'));
header('content-type:text/html;charset="utf-8"');
echo Request::factory()->execute();
echo time();
echo date();