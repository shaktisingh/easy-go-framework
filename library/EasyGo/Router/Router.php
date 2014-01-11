<?php
/**
* Router will dispatch the request to appropriate controller
*
* 
* @package EasyGo
* @subpackage Router	
*/
namespace EasyGo\Router;

use EasyGo\Exception\EasyException;
use EasyGo\Application;
use EasyGo\Registry;
use EasyGo\Module\ModuleManager;
use EasyGo\Event\EventDispatcher;
use EasyGo\Http\RequestAbstract;

class Router implements RouterInterface
{
		
	
	/**
	*
	*/
	public $controller;
	/**
	*
	*/
	public $action;
	
	/**
	*
	*/
	public $params;
	
	/**
	*
	*/
	public $request; 
	
	/**
	*
	*/
	protected static $_instance;
	
	/**
	*
	*/
	public $route = array();	
	
	/**
	*
	*/
	public function __construct()
	{			
		$this->setRequest(Registry::getInstance()->request);	
	}
	
	/**
	*	
	*/
	public static function getInstance()
	{
		if (null == self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	*
	*/
	public function setRequest(RequestAbstract $request )
	{
		$this->request = $request;
		return $this;
	}
	
	/**
	*
	*/
	public function getRequest()
	{
		return $this->request;
	}
	
	/**
	*	
	*/
	public function getSystemConfig()
	{
		return Registry::getInstance()->config->systemConfig;
	}
	
	/**
	*	Create the object of requested controller and dispatch the request
	*/		
	public function dispatch()
	{
		$this->setRoute();	
		$class = $this->getRoute();
		//echo $class;
		$controller = new $class();
	
		$controller->dispatch($this->getRequest()->getCurrentAction());		
	}
	
	
	/**
	*	Set Route according to request
	*/
	public function setRoute()
	{		
		//Check if the requested module is configured to overriden,  Set the Route to load that overrider module
		$this->matchRoute($this->getRequest()->getRawRoute());
		 //check to see if current module is configured to overridden 
		if (ModuleManager::getInstance()->shouldOverridden($this->getRequest()->getModule()) == true)
		{			
			// if there is no listner attached to the before.module.load event, default behaiour is override the module
			if (EventDispatcher::getInstance()->hasListener('before.module.load') == false)
			{
				$this->overrideModule();						
				return $this; 
			}
			// Listner is attached to this event, let's trigger the event and check if listener retruns true, 
			// Override the module 
			if (EventDispatcher::getInstance()->trigger('before.module.load', $this->getRequest()->getModule()) == true)
			{
				$this->overrideModule();
				return $this;
			}			
		 }
		 // Check to see which site this request is for 
		 
		 // if current module is not configured to overridden, simply load module from app/modules directory 
		 $namespace =   $this->getRequest()->getModule() . '\\Controller' ;		 
		 $this->class = $this->getRequest()->getCurrentController() . 'Controller';
		 $this->route = $namespace . '\\' . $this->class ;  
		
		 return $this;
	}
	
	/**
	*
	*/
	public function getRoute()
	{
		return $this->route;
	}
	
	/**
	*	Match Route
	*/
	public function matchRoute($rawRoute)
	{
		
		if (($route = $this->getSystemConfig()->$rawRoute) != null)
		{		
			//echo $route;
			$chunks = explode('_' , $route);
			$this->getRequest()->setModule(array_shift($chunks));
			$this->getRequest()->setController(array_shift($chunks));
			$this->getRequest()->setAction(array_shift($chunks));			
		}		
		
	}
	/**
	*	Set the route to new module which should overrides existing module 
	*/
	public function overrideModule()
	{
		$namespace =  'Extension\\' . $this->getRequest()->getModule() . '\\Controller' ;		 
		$this->class = $this->getRequest()->getCurrentController() . 'Controller';
		$this->route = $namespace . '\\' . $this->class ;  	
	}
}