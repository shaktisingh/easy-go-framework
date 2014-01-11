<?php
/**
*	Loader Abstract Class
*	
*/
namespace EasyGo\Loader;
abstract class LoaderAbstract
{
	/**
	* @var path
	*/
	public $path ;
	
	/**
	* @var class
	*/
	public $class;
	
	/**
	*	Set Auto Loader
	*/
	public function __construct()
	{
		spl_autoload_register(array($this, 'load'));
	}
	public function setPath($path)
	{
		$this->path = $path;
	}
	
	public function setClass($class)
	{
		$this->class = $class;
	}
	
	public function constructPath($path)
	{
		return implode(DS, $path);
	}
	/**
	*	Abstract Method	
	*
	*	Define class and file load proceduer in concrete class
	*/
	public function load($namespace);
	
}
?>