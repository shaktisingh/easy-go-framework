<?php
/**
*	Plugin Manager.
*
*	Load plugins
*/

namespace EasyGo\Plugin;

use EasyGo\Event\EventDispatcher ; 
use EasyGo\Parser\XmlParser;
use EasyGo\Registry;

class PluginManager implements PluginManagerInterface 
{
	
	/**
	*	@array  Registered plugins 
	*/
	public $plugins = array();
	
	/**
	*	Plugin Loader Instance 
	*/
	public $pluginLoader;
	
	/**
	*	Plugin Manager Instance 
	*/
	private static $_instance ;
	
	/**
	*	Plugin Path
	*
	*/
	public $pluginPath; 
	
	/**
	*	Crete and return the instance of plugin manager
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
	*	Load Plugin Configuration 
	*	
	*/
	public function loadPluginConfig()
	{
		$parser = new XmlParser();
		
		$this->setPluginLoader();
		$pluginPath = $this->pluginLoader->setPluginPath()->getPluginPath();
		
		$configFile = $pluginPath . DS . 'plugins.xml';
		//if plugin config file does not exists, do nothing 
		if (!file_exists($configFile))
		{
			
			return ;
		}
		$nodes = $parser->parse($configFile)->getSimpleXml();
		
		/** Register plugins **/
		foreach($nodes as $node)
		{
			$pluginName = (string )$node->name;
			$pluginClass = (string)$node->class;
			$this->registerPlugin($pluginName, $pluginClass);
		}
	}
	
	/**
	*	Register a Plugin.
	*
	*	Store plugin name and namespace of plugin.
	*/
	public function registerPlugin($pluginName, $class)
	{
		if (!isset($this->plugins[$pluginName]))
		{			
			$this->plugins[$pluginName] = $class ;
		}
	}
	
	/**
	*	un-register a Plugin.
	*
	*	
	*/
	public function unRegisterPlugin($pluginName)
	{
		if (isset($this->plugins[$pluginName]))
		{			
			unset($this->plugins[$pluginName]);
			return true;
		}
		return false;
	}	
	
	/**
	*	Set plugin loader.
	*
	*/
	public function setPluginLoader()
	{
		$this->pluginLoader = new PluginLoader();
		return $this;
	}
	
	/**
	*	Return the requested plugin.
	*	@return string | false Returns namespace of the plugin or false if plugin is not registered  
	*/
	public function getPlugin($pluginName)
	{
		return isset($this->plugins[$pluginName]) ? $this->plugin[$pluginName] : false;
	}
	
	/**
	*	Load Plugins.
	*
	*	
	*/
	public function loadPlugins()
	{
		//var_dump($this->plugins);
		
		
		foreach($this->plugins as $pluginName => $class)
		{
			//echo $pluginName;
			//echo $class;
			// trigger the event before.plugin.load 
			// if the listener is attached to this event, trigger the event otherwise 
			// simply load the plugin 
			if (EventDispatcher::getInstance()->hasListener('before.plugin.load'))
			{
				if (EventDispatcher::getInstance()->trigger('before.plugin.load', $pluginName) != false)
				{
					$this->pluginLoader->loadPlugin($pluginName, $class);	
				}
			}
			else
			{					
				$this->pluginLoader->loadPlugin($pluginName, $class);	
			}
				
			
		}
	}
	
}
?>