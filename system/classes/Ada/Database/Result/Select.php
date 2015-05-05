<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库查询结果具体实现类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Database_Result_Select extends Ada_Database_Result {
	
	public function __construct(Ada_Database $object) {
	
	}

	/**
	* 将数据查询结构格式化为Xml
	* @param Void
	* @return Xml
	*/
	public function toXml(){
	
	}
	
	/**
	* 将数据查询结构格式化为Xml
	* @param Void
	* @return Object
	*/
	public function toObj(){
		
	}
	
	/**
	* 直接返回数据查询结果\
	* @param Void
	* #return Array
	*/
	public function __toString() {
		return array();
	}
}