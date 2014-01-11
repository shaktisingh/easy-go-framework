<?php
/**
*	Configuration class holds configuration variables
*	
*	This class holds the system.xml configuration settings.
*/
namespace EasyGo\Config;

use EasyGo\Parser\XmlParser;
use EasyGo\Parser\ParserAbstract;
use EasyGo\Exception\EasyException;

class SystemConfig 
{
		
	/**
	* @var array holds application ini settings 
	*/
	protected  $routes = array();
	/**
	* Instance of Xml Parser
	*/
	public $xmlParser;
	
	/**
	*	
	*/
	public function setParser()
	{
		$this->xmlParser = new XmlParser;
	}
	
	/**
	* Load configuration file and set config class properties
	*/
	public function loadConfiguration($systemConfig)
	{
		$this->setParser();
		$moduleRoutes = $this->xmlParser->parse($systemConfig)->xpathQuery('module/routes/route');
		
		foreach ($moduleRoutes as $node)
		{
			
			if ($node->current != '' && $node->new != '')
			{// Replace the routing slash with underscore for array offset
				//var_dump($node->current);
				$default_route  = strtolower(str_replace('/', '_', $node->current));
				$new_route = strtolower(str_replace('/', '_', $node->new));
				
				//var_dump($node->current);
				$this->routes[$new_route] = $default_route;
			}	
		}
		
	}
	/**
	* Find the rewrite route by orginal route.
	* @param (string) $query String containing module conroller and action <code>module/controller/action</code>
	* @return string | flase Rewritten URL if found, FALSE otherwise
	*/
	public function findRoute($query)
	{
		if($query != null)
		{
			return array_search($query, $this->routes);
		}
		return false;
	}
	/**
	*	Set a property 
	*/
	public function __set($name, $value)
	{
		$this->routes[$name] = $value;
	}
	/**
	*	get a property
	*/
	public function __get($name)
	{
		return isset($this->routes[$name]) ? $this->routes[$name] : null;
	}
	/**
	*
	*/
	public function __call($func, $test)
	{
		 $func;
	}
	
}
?>