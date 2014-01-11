<?php
/**
*	Registry to hold globals
*	
*/
namespace EasyGo;
class Registry 
{
		
	/**
	* @var array
	*/
	protected  $globals = array();
	/**
	*
	*/
	private static $_instance; 
	/**
	*	 Constructor
	*/
	public function __construct()
	{
		//load configuration setting in $_config property
	}
	/**
	*	Creat the instane of this class
	*/
	public static function getInstance($service = null)
	{
		if (null == self::$_instance)
		{
			self::$_instance = new self();
		}
		if (null != $service)
		{
			return self::$_instance->$service;
		}
		return self::$_instance;
	}
	/**
	*	Set a property 
	*/
	public function __set($name, $value)
	{
		$this->globals[$name] = $value;
	}
	/**
	*	get a property
	*/
	public function __get($name)
	{
		return $this->globals[$name];
	}
	
	public function __call($name, $args)
	{
			
	}
	public function setConfig()	
	{
	}
	public function getConfig()
	{
		return $globals['config'];
	}
	
}
?>