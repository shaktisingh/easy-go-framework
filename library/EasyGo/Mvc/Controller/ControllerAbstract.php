<?php
/**
* 
*
* 
*/
namespace EasyGo\Mvc\Controller;
use EasyGo\Mvc\Controller\ControllerInterface;
use EasyGo\Mvc\CoreModel;
use EasyGo\Mvc\View\CoreView;
use EasyGo\Event\Event;
use EasyGo\Event\EventDispatcher;
use EasyGo\Session\Session;
use EasyGo\Registry;
use EasyGo\Plugin\PluginManager;
use EasyGo\Exception\EasyException;

abstract class ControllerAbstract implements ControllerInterface
{
	/**
	*	Core View Object
	*/
	public $view;
	/**
	*	Registry Object
	*/
	public $registry ; 
	
	/**
	* Content of action view 
	*/
	public $content;
	
	/**
	*
	*/
	public $eventDispatcher;
	/**
	*	Object of event class
	*/
	public $event; 
	/**
	*
	*/
	public $pluginManager;
	/**
	*
	*
	*/
	public function __construct()
	{
		$this->view =  new CoreView;
		$this->registry = Registry::getInstance();
		$this->request = $this->registry->request;
		/* Set event object, Event object will be used to attach some data and will be passed to listeners */
		$this->event = new Event;
		// creat event dispatcher object
		$this->eventDispatcher = EventDispatcher::getInstance();
		// set plugin Manager instance 
		$this->setPluginManager( PluginManager::getInstance());
		/* */
		$this->setView();
	}
	
	/**
	* Create and return the instance of requested controller 
	*
	* @param  namespace $controller Full namespace of requested controller
	*/	
	public function getController($controller)
	{
		return new $controller;
	}
	
	/**
	* Create Intance of requested model 
	*
	* @param string $model Model name which should be initiated 
	* @return object $instance Instance of requested model
	*/
	public function getModel($model)
	{
		return $model::getInstance();
	}
	/**
	* Return the instance of the session class
	*/
	public function getSession()
	{
		return Session::getInstance();
	}
	/**
	*
	*/
	public function setPluginManager(\EasyGo\Plugin\PluginManagerInterface $pluginManager)
	{
		$this->pluginManager = $pluginManager;
	}
	/**
	*	Set the view for action 
	*/	
	public function setActionView($view = null)
	{
		if (null == $view)
		{
			$this->view->actionView = $this->request->getCurrentAction() . '.phtml'; //get current action and set view accordingly 
			return $this;
		}
		$this->view->actionView = $view;
		return $this;
	}
	public function getActionView()
	{
		return $this->view->actionView;
	}
	/**
	*
	*
	*/
	public function setTheme($theme = null)
	{
		if (null == $theme )
		{			
			$this->view->theme = $this->getConfig('theme');
			return $this;
		}
		$this->view->theme = $theme ;
		return $this;
	}
	/**
	*
	*/
	public function getTheme()
	{
		return $this->view->theme ;		
	}
	/**
	*
	*
	*/	
	public function setLayout($layout = null)
	{
		if (null == $layout)
		{			
			$this->view->layout = $this->getConfig('layout');			
			return $this; 
		}	
		$this->view->layout = $layout;
		return $this;
	}
	
	public function getLayout()
	{
		return $this->view->layout ;
	}
	/**
	*	Load the configuration option
	*/
	public function getConfig($option)
	{
		return $this->registry->config->$option;
	}
	/**
	*	
	*/
	public function getCurrentController()
	{
		return $this->request->getController();
		
	}
	/**
	*	Render the current view according to current theme and layout
	*/
	public function render()
	{
		$this->view->render();
	}
	/**
	*	Set view for this controller action
	*/
	public function setView()
	{
		$this->setTheme()->setLayout()->setActionView();
	}
	/**
	*	Dispactch Request to appropriate action of this controller
	*/
	
	public function dispatch($action)
	{		
		//dispatch the request to appropriate controller action
		$action = $this->constructAction($action);		
		if (! method_exists($this, $action))
		{
			throw new EasyException('Requested action does not exists.');
		}
	
		/*$this->eventDispatcher->attach('after.site.site.index', function ($data) {
																		return $data->name = 'shakti';
																		}
													);*/
		
		$this->beforeDispatch();
		// call events if any registered on before executing this action 
		if ($this->eventDispatcher->hasListener($this->getEventName($state = 'before')))
		{
			//send the POST request data do not pass  $_POST literally use another variable which should be a copy of $_POST
			$data ='';
			$this->eventDispatcher->trigger($this->getEventName($state = 'before' ), $data );
		}
		$this->$action();
		
		$this->afterDispatch();		
		//trigger events  
		if ($this->eventDispatcher->hasListener($this->getEventName($state = 'after')))
		{
			//Send the $this->event object. action method must set some data to $this->event 
			//object if they want to pass data to listners 
			$this->eventDispatcher->trigger($this->getEventName($state = 'after' ), $this->event);			
		}
		$this->render();
		//var_dump($this);
		
	}
	/**
	*	Return the event name according to current action 
	*/
	public function getEventName($state)
	{
		$event = $state . '.' . $this->request->getModule() . '.' . $this->request->getController() . '.' . $this->request->getAction();
		return strtolower($event);
	}
	/**
	*	Prepend string "Action" with the requested action
	*/
	public function constructAction($action)
	{
		return $action . 'Action';
	}
	/**
	*	Runs before dispatching any action 
	*/
	public function beforeDispatch()
	{
		//echo 'I am before dispatch';
	}
	
	/**
	*	Runs after dispatching any action
	*/
	public function afterDispatch()
	{
		//echo 'I am after dispatch';
		
	}
}