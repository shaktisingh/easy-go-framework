<?php
/**
*	Initialize Class.
*	This class will initialize resources in user space code. 
*	@author  Shakti Singh <shakti.blevel@gmail.com>
*/
use EasyGo\Event\EventDispatcher;
use Site\Model\Site;

class initializer
{
	
	/**
	*
	*/
	public $eventDispatcher;
	
	/**
	*
	*/
	public $session;
	
	/**
	*	Add the resource objects which you will be using in the init() method, 
	*	additionally add property for the resource object.
	*/	
	public function __construct()
	{
		$this->session = \EasyGo\Session\Session::getInstance( new \EasyGo\Session\Handlers\FileHandler());
		$this->eventDispatcher = EventDispatcher::getInstance();
	}
	
	/**
	*	Initialize Resources.
	*	This method will be called before each request.
	*/
	public function init()
	{
				
		//start the session.		
		$this->session->start();		
		
		/**
		*	add the listner to the plugin loader event which will be called before loading any plugin 
		*	The listner should check if the the plugin for this user should be loaded or not and should return 
		*   TRUE or FALSE
		*   
		*/
		// get the model object, pass as a callback and use it to check if the plugin is registered and active 
		// for this user(customer)
		$siteModel = Site::getInstance();
		
		$this->eventDispatcher->attach('before.plugin.load', array($siteModel, 'validatePlugin'));
		
		/**
		*	Add a listner to the module loader(that load modules from user space, extension directory) 
		*	This listner should return TRUE or FALSE whether we need to load the Module or not 
		*	if no listner is attached to this event, default behaviour is to override the module if it is configured
		*	to override
		*/
		$this->eventDispatcher->attach('before.module.load', array($siteModel, 'validateModule'));
	}	
}

