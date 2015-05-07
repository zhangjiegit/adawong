<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http请求处理类
* Request::factory('welcome/say')->execute();
* Request::factory('http://www.baidu.com')->method('get')->execute();
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Request extends Ada_Request{}