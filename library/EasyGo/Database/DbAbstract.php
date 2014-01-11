<?php
/*
* @author Shakti Singh
* 
* @desc Dabase Abstraction. This abstract class implements the Dbbase interface for database abstraction 
* and implements only those methods which will have common (same) implementation thought all the concrete classes 
* and leave other methods for concrete classes to implement, so that these concrete classes can implement 
* those methods according to their implmentation.
*/
namespace EasyGo\Database;
use EasyGo\Database\DbInfterface;

abstract class DbAbstract implements DbInfterface
{
	protected $db;
	private $host;
	private $dbname;
	private $username;
	private $password;
	/*
	* @desc: constructor accept the databae connection parameters
	*/
	public function __construct($host = 'localhost', $dbname, $username, $password)
	{
		$this->host = $host;
		$this->dbname = $dbname;
		$this->username = $username;
		$this->password = $password;		
	}
	/*
	* @desc : Connect to database 
	* @todo : Add database driver name dynamically so that it can connect to multiple database, as it is static in code for now
	* This can easily be done by passing `driver` parameter in this class's contructor 
	*/
	public function connect()
	{
		try 
		{
			$this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{			
			echo $e->getMessage(); 
		}
	}
	
	
}