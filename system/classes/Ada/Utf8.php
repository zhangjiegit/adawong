<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Utf8字符处理具体类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Utf8 {
	
	//ascii字符编码范围
	const ASCII = '[\x00-\x7f]';
	
	/**
	* 判断字符是否为ascii字符
	* @param String $string	输入字符
	* @return Bool
	*/
	public static function isAscii($string) {
		return preg_match('/^'.self::ASCII.'$/', $string);
	}
}