<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库访问操作类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Database {

	/**
	* 抽象查询方法,执行一个查询语句
	*/
	abstract public	function select($sql);
	
	/**
	* 抽象插入方法,执行一个插入语句
	*/
	abstract public	function insert();
	
	/**
	* 抽象更新方法,执行一个更新语句
	*/
	abstract public	function update();
	
	/**
	* 抽象删除方法,执行一个删除语句
	*/
	abstract public	function delete();

	protected	function __construct() {}
}