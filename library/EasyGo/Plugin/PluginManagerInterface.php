<?php
/**
*	Plugin Manager Interface.
*
*	
*/
namespace EasyGo\Plugin;

interface PluginManagerInterface 
{
	/**
	*	Register a Plugin 
	*/
	public function registerPlugin($pluginName, $namespace);
	
	/**
	*	Un-Register a Plugin
	*/
	public function unRegisterPlugin($pluginName);
	/**
	*	Load Plugin 
	*/
	public function loadPlugins();		
}
?>