<?php
/**
*
*
*/
namespace EasyGo\Http;
use EasyGo\Registry;

abstract class RequestAbstract
{ 
	/**
	*
	*/
	public $requestUri;
	
	public function __construct()
	{
		if (isset($_SERVER['PATH_INFO']))
		{
			$this->requestUri = explode('/', $_SERVER['PATH_INFO']);	
		}	
	}
	
	/**
	*	Raw request parameter
	*/
	public function setRawRoute()
	{
		if (isset($this->requestUri[1]) && null != $this->requestUri[1])
		{
			$this->route = $this->requestUri[1];
		}	
		if (isset($this->requestUri[2]) && null != $this->requestUri[2])
		{
			$this->route .= '_' . $this->requestUri[2];
		}
		if (isset($this->requestUri[3]) && null != $this->requestUri[3])
		{
			$this->route .= '_' . $this->requestUri[3];
		}
		return $this;
	}
	/**
	*
	*/
	public function getRawRoute()
	{
		return $this->route ;
	}
	/**
	*	Return the route for the request module/controller/action. This method can be used to get the rewritten 
	*	URL for an action to set anchor tag accordingly. 
	*
	*	@param (string) $info String containing module conroller and action <code>module/controller/action</code>
	*/
	public function getRoute($info)
	{
		if (null != $info)
		{
			return Registry::getInstance()->config->systemConfig->findRoute($info);
		}
		return false;
	}
}
