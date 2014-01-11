<?php
/**
* Router will dispatch the request to appropriate controller
*
* 
* @package EasyGo
* @subpackage Router	
*/
namespace EasyGo\Router;

interface RouterInterface
{		
	public function setRoute();
	public function dispatch();
}	
