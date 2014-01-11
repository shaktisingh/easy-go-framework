<?php
/**
* View  Base
*
* 
* 
*/
namespace EasyGo\Mvc\View;

use EasyGo\Session\Session;
use EasyGo\Registry;
use EasyGo\Exception\EasyException;
class CoreView extends ViewAbstract 
{
	/**
	*
	*/
	public $layout;
	/**
	*
	*/
	public $actionView;
	/**
	*
	*/
	public $theme;

	/**
	*	
	*/
	public $vars = array();
	/**
	*
	*/
	public $content;
	/**
	*
	*/
	public $request ; 
	
	public function __construct()
	{
		$this->request = Registry::getInstance()->request;
	}
	/**
	* Render View
	* 
	* Logic here to render the view
	*
	*/
	public function render()
	{	
		/** Get Layout Path  */
		$layoutPath =  $this->getLayoutPath();
		/** Get view Path */		
		$this->setViewContent($this->getViewPath());		
		if (!file_exists($layoutPath))
		{
			throw new EasyException('Layout file not found in ' . $layoutPath ); 			
		}
		
		//ob_start();
		include_once $layoutPath ;
		//$this->content = ob_get_contents();
		//ob_end_clean();
		//echo '<pre>'; 
		//print_r($this);
		
	}
	
	public function setViewContent($path)
	{
		if (!file_exists($path))
		{
			throw new EasyException('View file not found in ' . $path ); 			
		}
		ob_start();
		include_once $path;
		$this->content = ob_get_contents();
		ob_end_clean();
	}
	/**
	*	Return Css and Js 
	*/
	public function getCssJs()
	{
		/*$css = new \ArrayIterator($this->css);
		$js = new \ArrayIterator($this->js);

		$iterator = new \AppendIterator;
		$iterator->append($css);
		$iterator->append($js);

		foreach ($iterator as $file) 
		{
			//echo $current;
			var_dump($fileInfo = new \SplFileInfo($file));
			echo $fileInfo->getExtension();
			if ($fileInfo->getExtension() == 'css')
			{
				
			}
		}*/
		$data = '';
		foreach (array_reverse($this->css) as $file)
		{
			$data .= '<link rel="stylesheet" type="text/css" href="' . $this->getThemeUrl() . 'css/' . $file . '" media="screen" />' . "\n" ;
		}
		foreach (array_reverse($this->js) as $file)
		{
			$data .= '<script type="text/javascript" src="' . $this->getThemeUrl() . 'js/' . $file . '" ></script>' . "\n";
		}
		//echo $this->getBaseUrl();
		return $data;
	}	
	
	/**
	*	Set View Properties.
	*	This method can be used to set view properties(variables) to be used in view file 
	*/
	public function __set($name, $value)
	{
		$this->vars[$name] = $value;
	}
	
	/**
	*	Get View Properties
	*/
	public function __get($name)
	{
		return isset($this->vars[$name]) ? : null; 
	}
	
	/**
	* Return the instance of the session class
	*/
	public function getSession()
	{
		return Session::getInstance();
	}
	
	
}