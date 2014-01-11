<?php
/**
*	Dependency Injection Container
*	
*/
namespace EasyGo\DIC;

interface DicInterface 
{
	public function setService($class, $dependencies);
	public function getService($class, $dependency);
}