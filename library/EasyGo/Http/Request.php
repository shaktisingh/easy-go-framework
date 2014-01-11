<?php
/**
*
*
*/
namespace EasyGo\Http;

use EasyGo\Http\RequestAbstract;
use EasyGo\Exception\EasyException;
use EasyGo\Application;
class Request extends RequestAbstract
{       
	
	/**
	* @var string Current request URI
	*/
    public $requestUri;
	/**
	* @var string Base URL of application
	*/
	public $baseUrl;
	/**
	* @var string Base Path of application
	*/
	public $basePath;
	/**
	*
	*/
	public $route;
	/**
	*
	*/
	public $module;
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
	public function __construct()
	{
		parent::__construct();		
	}
	/**
	*	Set Module Name for current Request
	*/
	public function setModule($module = null)
	{		
		if (null != $module)
		{
			$this->module = $module;
			return $this;	
		}
		if (isset($this->requestUri[1]) && null != $this->requestUri[1])
		{
			$this->module = ucfirst($this->requestUri[1]);		
			return $this;
		}			
		$this->module = $this->getDefaultModule();
		
		return $this;
	}	
	/**
	*	Return module name for current request
	*/
	public function getModule()
	{
		return $this->module;
	}
	/**
	* Set default module
	*/
	public function setDefaultModule($defaultModule)
	{
		$this->defaultModule = $defaultModule;
		return $this;
	}
	/**
	*
	*/
	public function getDefaultModule()
	{
		return $this->defaultModule;
	}
	/**
	*	Set Requested Controller 
	*/
	public function setController($controller = null)
	{	
		if (null != $controller)
		{
			$this->controller = $controller;
			return $this;	
		}
		
		if (isset($this->requestUri[2]) && null != $this->requestUri[2])
		{
			$this->controller = ucfirst($this->requestUri[2]);		
			return $this;
		}			
		$this->controller = $this->getDefaultController();
		return $this;
	}
	/**
	*
	*/
	public function getCurrentController()
	{
		return $this->controller;
	}
	/**
	*
	*/
	public function getController()
	{
		return $this->controller;
	}
	/**
	*	Set Requested Action
	*/
	public function setAction($action = null)
	{			
		if (null != $action)
		{
			$this->action = $action;
			return $this;
		}
		if (isset($this->requestUri[3]) && null != $this->requestUri[3])
		{
			$this->action = $this->requestUri[3];		
			return $this;
		}	
		$this->action =  $this->getDefaultAction();
		
		return $this;	
	}
	/**
	*
	*/
	public function getCurrentAction()
	{
		return $this->action;
	}
	/**
	*
	*/
	public function getAction()
	{
		return $this->action;
	}
	/**
	*
	*/
	public function setDefaultController($controller)
	{
		$this->defaultController = $controller; 
		return $this;
	}
	/**
	*
	*/
	public function getDefaultController()
	{
		return $this->defaultController;
	}
	/**
	*
	*/
	public function setDefaultAction($action)
	{
		$this->defaultAction = $action;
		return $this;
	}
	/**
	*
	*/
	public function getDefaultAction()
	{
		return $this->defaultAction;
	}
	
	/**
	*	Set the Base URL of application
	*/
	public function setBaseUrl()
	{
		return $this->baseUrl();
	}
	/**
	*	Get Base URL of application
	*/
	public function getBaseUrl()
	{
		$scheme = "http://";
		$host = '';
		$baseDir = '';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
		{
			$scheme = 'https://' ;
		}
		if (isset($_SERVER['HTTP_HOST']))
		{
			$host = $_SERVER['HTTP_HOST'] . '/' ;
		}
		
		if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != null && $_SERVER['REQUEST_URI'] != '/')
		{
			
			$uriParts = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
			$baseDir = array_shift($uriParts);
		}
		
		return $this->baseUrl = $scheme . $host . $baseDir ; 
		
	}
		
	/**
	*	Redirect 
	*/
	public function redirect($url)
	{
		if (null == $url)
		{
			header('locaton:'. $this->getBaseUrl());
			die();
		}
		header('location:' . $this->getBaseUrl() . '/' . $url);
		die();
	}
	/**
	* Set base path of application.
	* @param string $path Base path of application 
	* @return object $this Object of Request class
	*/
	public function setBasePath($path)
	{
		$this->basePath = $path; 
		return $this;
	}
	/**
	*	Return the base path of application
	*/
	public function getBasePath()
	{
		return $this->basePath;
	}
	/**
	*	Return the client IP address
	*/
    public function getClientIp($checkProxy = true)
    {
        if ($checkProxy && $this->getServer('HTTP_CLIENT_IP') != null) {
            $ip = $this->getServer('HTTP_CLIENT_IP');
        } else if ($checkProxy && $this->getServer('HTTP_X_FORWARDED_FOR') != null) {
            $ip = $this->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->getServer('REMOTE_ADDR');
        }

        return $ip;
    }
	/**
	*	Check if the request is a post request 
	*/
	public function isPost()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			return true;
		}
		return false;
	}
	/**
	*	Return the data of post request.
	*	You should use this method to get the data of POST request instead of directly using $_POST
	*	@todo Modify this method to return the POST data even if it is not present in $_POST, if this is the case
	*	Check the raw post data  if it is set convert the raw post data and set in $_POST and return it.
	*	
	*/
	public function getPostData()
	{
		return $_POST;
	}
}
