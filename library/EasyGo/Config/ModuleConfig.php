<?php
/**
*	Configuration class holds configuration variables
*	
*/
namespace EasyGo\Config;

use EasyGo\Module\ModuleManager;
use EasyGo\Event\EventDispatcher;
use EasyGo\Exception\EasyException;
use EasyGo\Parser\XmlParser;
use EasyGo\Registry;

class ModuleConfig 
{
		
	/**
	* @var array holds application ini settings 
	*/
	protected  $settings = array();
	
	/**
	* XML parser instance 
	*/
	public $xmlParser;
	
	/**
	*	Instance of module configuration file 
	*/
	public static $_instance;
	
	/**
	*	Request instance
	*/
	public $request;
	
	/**
	*	Return the instance of module configuration file 
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
	*	Set Parser 
	*/
	public function setParser()
	{
		$this->xmlParser = new XmlParser;
	}
	
	/**
	*	Set Request object
	*/
	public function setRequest()
	{
		$this->request = Registry::getInstance('request');
	}
	/**
	*	Get reuqest object 
	*/
	public function getRequest()
	{
		return $this->request;
	}
	/**
	* Load module configuration file and set config class properties
	*/
	public function loadConfiguration()
	{
		$this->setParser();
		$this->setRequest();
		
		$moduleConfig = $this->getModuleConfigPath();
		// check if the files exists before loading configuration 
		if (file_exists($moduleConfig))
		{
			$configurations = $this->xmlParser->parse($moduleConfig);
		}	
		//echo '<pre>';
		//print_r($configurations);
		
	}	
	/*
	*	Return the configuration file path based on module override configuration 
	*/
	public function getModuleConfigPath()
	{ 
		$path = null ;
		if (ModuleManager::getInstance()->shouldOverridden($this->getRequest()->getModule()) == true)
		{				
			// if there is no listner attached to the module load event, default behaiour is override the module
			// and load 
			if (EventDispatcher::getInstance()->hasListener('before.module.load') == false)
			{				
				return $this->constructPath();				
			}
			// Listner is attached to this event, let's trigger the event and check if listener retrun true 
			// Override the module 
			if (EventDispatcher::getInstance()->trigger('before.module.load', $this->getRequest()->getModule()) == true)
			{				
				return $this->constructPath();
			}			
		 }
		 
		 // if current module is not configured to overridden, simply load module configuration file 
		 // from app/modules directory 
		
		 $module = $this->getRequest()->getModule();
		 return $this->getRequest()->getBasePath() . DS . Registry::getInstance('config')->appDir
												. DS .  'modules' . DS . $module . DS . strtolower($module) . '.xml' ; 
		 
	}
	/**
	*	Construct module specific configuration file path
	*/
	public function constructPath()
	{
		
		$module = $this->getRequest()->getModule();
		$path = $this->getRequest()->getBasePath() . DS . 'extension' 
												. DS .  'modules' . DS . $module . DS . strtolower($module) . '.xml' ; 
		
		/// if configuration file does not exists in user space code for this module 
		// load from default path 
		if (!file_exists($path))
		{
			 $path = $this->getRequest()->getBasePath() . DS . Registry::getInstance('config')->appDir 
										. DS .  'modules' . DS . $module . DS . strtolower($module) . '.xml' ; 
		}
		
		return $path ; 
	}
	/**
	*	Set a property 
	*/
	public function __set($name, $value)
	{
		$this->settings[$name] = $value;
	}
	/**
	*	get a property
	*/
	public function __get($name)
	{
		return $this->settings[$name];
	}
	/**
	*
	*/
	public function __call($func, $test)
	{
		echo $func;
	}
	
}
?>