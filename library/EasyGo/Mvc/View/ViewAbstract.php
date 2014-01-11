<?php
/**
* View Abstract 
*
* 
* 
*/
namespace EasyGo\Mvc\View;

use EasyGo\Session\Session;
use EasyGo\Registry;
abstract class ViewAbstract 
{
	
	
	/**
	* @var array $css 
	*/
	public $css = array();
	/**
	* @var array $js
	*/
	public $js = array();
	
	abstract public function render();
	
	/**
	* Register CSS file.
	* @param $path Relative path, relative to css directory of theme 
	*/	
	public function registerCss($path)
	{
		if (null != $path)
		{
			$this->css[$path] = $path ;			
		}		
		return $this;
	}
	
	/**
	*	Unregister Css File 
	*/
	public function unregisterCss($path)
	{
		if (isset($this->css[$path]) && $this->css[$path] != null)
		{
			unset($this->css[$path]);
			return true;
		}
		return false;
	}
	
	/**
	* Register JS file
	*/
	public function registerJs($path)
	{
		if (null != $path)
		{
			$this->js[$path] = $path ;			
		}		
		return $this;
	}
	
	/**
	* Un-register JS file
	*/
	public function unregisterJs($path)
	{
		if (isset($this->js[$path]) && $this->js[$path] != null)
		{
			unset($this->js[$path]);
			return true;
		}
		return false;
	}
	
	/**
	*
	*/
	public function getBaseUrl()
	{
		return $this->request->getBaseUrl();
	}
	
	/**
	*	Return the current theme Directory path
	*/
	public function getThemePath()
	{
		return $this->request->getBasePath() . DS . 'themes' . DS . $this->theme;
	}
	
	/**
	*	Get the default theme directory 
	*/
	public function getDefaultThemePath()
	{
		return $this->request->getBasePath() . DS . 'themes' . DS . 'default';
	}
	
	/**
	*	Return the current theme URL
	*/
	public function getThemeUrl()
	{
		return $this->getBaseUrl() . '/themes/' . $this->theme . '/' ;
	}
	
	/** 
	*  Return the current Layout path with layout file name
	*/ 
	public function getLayoutPath()
	{	
		return $this->getThemePath() . DS . 'layouts' . DS . $this->layout; 
	}
	
	/**
	*	Return path of view according to current module, controller and action 
	*	If view not found in the configured theme it will return the path from
	*	default theme directory
	*
	*/
	public function getViewPath()
	{
		$viewPath = $this->getThemePath() . DS . 'views' . DS 
								. strtolower($this->request->getModule()) . DS 
								. strtolower($this->request->getCurrentController()) 
								. DS . $this->actionView; 
		if (!file_exists($viewPath))
		{
			$viewPath = $this->getDefaultThemePath() . DS . 'views' . DS 
								. strtolower($this->request->getModule()) . DS 
								. strtolower($this->request->getCurrentController()) 
								. DS . $this->actionView; 
		}
		return $viewPath;							
	}
	
	/**
	*	Construct and return the URL 
	*/
	public function getUrl($parameter)
	{
		return $this->getBaseUrl() . '/' . $parameter ; 
	}
}
