<?php
/**
* @author: Shakti Singh
* @date: 20-02-2013
* @desc: This class will be the base class for our Data Models , This class will get the databse instance and
* defines basic methods of a Database Model
*			
*/
class Model 
{
	public $db;
	public $data;
	
	public function __construct()
	{
		//get database instance
		if (!isset($this->db))
		{			
			//return $this->db = Factory::bulid('DbMysql');
			//Let's leave the Factory for now
			 $this->db = new DbMysql($host = 'localhost', $dbname ='recruitment', $username = 'root', $password = 'parakh');
		}	
		 $this->db;
	}
	/*
	* @desc:This method will create a object of the class which call this method. Usually a model will call this 
	* method ot initiate itself. This is a use of php 5.3 Late Static Binding feature.
	*/
	public static function getInstance()
	{
		return new static();    
	}
	/*
	* @desc: insert record a record, left blank intensely
	*
	*/
	public function add()
	{
		if (isset($this->data))
		{
			
		}
	}
	/*
	* @desc: update record, left blank intensely
	*/
	public function update($id)
	{
		
	}
}
