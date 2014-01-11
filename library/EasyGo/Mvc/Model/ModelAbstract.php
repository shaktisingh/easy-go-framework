<?php
/**
* 
*
* 
*/
namespace EasyGo\Mvc\Model;

use EasyGo\Mvc\Model\ModelInterface;
use EasyGo\Session\Session;
use EasyGo\Registry;
use EasyGo\Exception\EasyException ;
use \Zend\Db\Adapter\Adapter ;
use \Zend\Db\TableGateway\TableGateway as TableGateway;
use \Zend\Db\Sql\Sql;

abstract class ModelAbstract implements ModelInterface
{	
	
	/**
	*	Keep the adapter instance
	*/
	public static $adapterInstance; 
	
	/**
	*	Kep adapter instance
	*/
	public $adapter;	
	
	/**
	*	Keep the table gateway instance
	*/
	public $gateway ;
	
	/**
	*	Keep the select query instance 
	*/	
	public $sql;
	
	public $exception;
	
	public function __construct()
	{			
		//$this->exception = new EasyException(null);
		
	}
	/**
	*		
	*	Initiate the Zend DB Adapter and Return
	*/		
	public static function getAdapterInstance()
	{
		$config = Registry::getInstance()->config;
		
		if(self::$adapterInstance == null)
		{
			self::$adapterInstance = new Adapter($configArray = array('driver' =>$config->driver,
																	'database' => $config->database ,
																	'username' => $config->username,
																	'password' => $config->password
																	)
										);				
		}
		return self::$adapterInstance;
	}
	
	/*
	* Return the instance of Requested Model.
	* will be called ModelName::getInstance();
	*/
	public static function getInstance()
	{
		
		$model =  new static();		
		$model->init(self::getAdapterInstance(), new TableGateway($model->table, self::getAdapterInstance()), new Sql(self::getAdapterInstance()));
		return $model;
	}
	/**
	* Return the instance of the session class
	*/
	public function getSession()
	{
		return Session::getInstance();
	}
	
}