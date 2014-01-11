<?php
/**
* Controller Insterface 
*
* 
* 
*/
namespace EasyGo\Mvc\Model;
use EasyGo\Mvc\Model\ModelAbstract;

class CoreModel extends ModelAbstract
{
	/**
	*	
	*/
	public function init($adapter, $gateway,  $sql )
	{
		$this->adapter;
		$this->gateway = $gateway;
		$this->sql = $sql;
	}
	/**
	*
	*/
	public function getAdapter()
	{
		return $this->adapter;
	}
	/**
	* Easy to Perform insert, update, select, etc. on the model database table 
	*/
	public function getGateway()
	{
		return $this->gateway;
	}
	/**
	* ORM object
	*/
	public function getSql()
	{
		return $this->sql;
	}
}