<?php
/**
* @author Shakti Singh
* 
* 
*/
namespace Site\Model;

use EasyGo\Mvc\Model\CoreModel;

class Site extends CoreModel 
{
	public $table = 'user';
	
	/**
	*	Check if the plugin is valid for this user.
	* 
	*	@return (boolean) TRUE if the plugin is valid for the user, FALSE otherwise
	*/
	public function validatePlugin($pluginName)
	{
		//echo $pluginName;
		//echo 'I\'m Plugin Validator';
		return true;
	}
		
	/**
	*	Check if the user space module is valid for this user 
	*/
	public function validateModule($moduleName)
	{
		//echo $moduleName;
		return true;
	}
	
}
