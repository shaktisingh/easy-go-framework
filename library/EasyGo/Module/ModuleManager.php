<?php
/**
*	Plugin Manager.
*
*	Load plugins
*/

namespace EasyGo\Module;

use EasyGo\Event\EventDispatcher ; 
use EasyGo\Parser\XmlParser;
use EasyGo\Registry;

class ModuleManager implements ModuleManagerInterface 
{
	
	/**
	*	@array  Registered Modules 
	*/
	public $modules = array();
	
	/**
	*	Module Loader Instance 
	*/
	public $moduleLoader;
	
	/**
	*	Module Manager Instance 
	*/
	private static $_instance ;
	
	/**
	*	Module Path
	*
	*/
	public $modulePath; 
	
	/**
	*	Crete and return the instance of module manager
	*/
	public static function getInstance()
	{
		if (self::$_instance == null)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	*	Set module path 
	*/
	public function setModulePath()
	{
		$this->modulePath = Registry::getInstance('request')->getBasePath() . DS . 'extension' . DS . 'modules' ;
		return $this;
	}
	
	/**
	*	Return Module Path
	*/
	public function getModulePath()
	{
		return $this->modulePath;
	}
	
	/**
	*	Load Module Configuration 
	*	
	*/
	public function loadModuleConfig()
	{
		$parser = new XmlParser();
		
		
		$modulePath = $this->setModulePath()->getModulePath();
		
		$configFile = $modulePath . DS . 'modules.xml';
		//if module config file does not exists, do nothing 
		if (!file_exists($configFile))
		{
			
			return ;
		}
		$nodes = $parser->parse($configFile)->getSimpleXml();
		
		/** Register Modules **/
		foreach($nodes as $node)
		{
			$moduleName = (string )$node->name;
			$overrides = (isset($node->overrides) ? (string ) $node->overrides : '') ;
			//$pluginClass = (string)$node->class;
			$this->registerModule($moduleName, $overrides);			
		}
	}
	
	/**
	*	Register a Module.
	*
	*	Store module name.
	*/
	public function registerModule($moduleName, $overrides = null)
	{
		if (!isset($this->modules[$moduleName]))
		{			
			$this->modules[$moduleName] = $overrides  ;
		}
	}
	
	/**
	*	un-register a Module.
	*
	*	
	*/
	public function unRegisterModule($moduleName)
	{
		if (isset($this->modules[$moduleName]))
		{			
			unset($this->modules[$moduleName]);
			return true;
		}
		return false;
	}		
	
	/**
	*	Return the requested module.
	*	@return string | false Returns name of the module or false if module is not registered  
	*/
	public function getModule($moduleName)
	{
		return isset($this->modules[$moduleName]) ? $this->modules[$moduleName] : false;
	}
	/**
	*	Check if the module should be overridden 
	*/
	public function shouldOverridden($moduleName)
	{
		if (isset($this->modules[$moduleName]) && $this->modules[$moduleName] != null)
		{
			return true;
		}
		return false;
	}
	/**
	*	Load Modules.
	*
	*	
	*/
	public function loadModule()
	{
		//var_dump($this->plugins);
		
		
		/*foreach($this->modules as $pluginName => $class)
		{
			//echo $pluginName;
			//echo $class;
			// trigger the event before.plugin.load 
			if (EventDispatcher::getInstance()->trigger('before.module.load', $pluginName) != false)
			{
				$this->pluginLoader->loadPlugin($pluginName, $class);				
			}	
			
		}*/
	}
	
}
?>