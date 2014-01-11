<?php
/**
*	Dependency Injection Container
*	
*/
namespace EasyGo\DIC;

class Dic implements DicInterface 
{
	/**
	*@var Array
	*/
	protected $services = array();
	
	public function setService($class, $dependencies)
	{
		$this->services[$class] = $dependencies;
	}
	public function getService($class, $dependency = null)
	{
		if (null == $dependency)
		{
			return $this->services[$class];
		}
		array_search($this->
	}
}
?>