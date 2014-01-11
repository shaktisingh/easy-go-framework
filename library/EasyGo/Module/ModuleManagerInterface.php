<?php
/**
*	Plugin Manager Interface.
*
*	
*/
namespace EasyGo\Module;

interface ModuleManagerInterface 
{
	/**
	*	Register a Module
	*/
	public function registerModule($moduleName);
	
	/**
	*	Un-Register a Module
	*/
	public function unRegisterModule($moduleName);
	/**
	*	Load Module 
	*/
	public function loadModule();		
}
?>