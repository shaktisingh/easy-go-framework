<?php
/**
*
*/
namespace EasyGo\Plugin;

use EasyGo\Registry;
use EasyGo\Exception\EasyException;
class Pluginloader 
{
	/**
	*	@var 
	*/
	public $request;
	
	/**
	*	Set the auto loader to load the plugins from user space code 
	*/
	/*public function setAutoloader()
	{
		spl_autoload_register(array($this, 'loadPlugin'));
	}*/
	
	/**
	*	Set Plugin Directory Path
	*/
	
	public function __construct()
	{
		$this->request = Registry::getInstance('request');
	}
	public function setPluginPath()
	{
		$this->pluginPath = $this->request->getBasePath() . DS . 'extends' . DS . 'plugins' ;
		return $this;
	}
	
	/**
	*	Return Plugin Path
	*/
	public function getPluginPath()
	{
		return $this->pluginPath;
	}
	/**
	*	Plugin Auto loader
	*/
	public function loadPlugin($name, $class)
	{
		//$this->setAutoloader();
		$path = $this->getPluginPath() . DS . str_replace('\\', DS, $class) . '.php';
		
		if (file_exists($path))
		{
			require_once  $this->getPluginPath() . DS . str_replace('\\', DS, $class) . '.php';
			return ;
		}	
		throw new EasyException("Plugin '$name' could not be loaded. Plugin class not found at " .$path);
		//var_dump($pathChunks); exit;
	}
	
}