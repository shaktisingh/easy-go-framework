<?php
/*
* @author: Shakti Singh
* @date: 21-02-2013
* @desc: Dabase Interface. This interface defines the methods which must be implemented by the classes which
* implements this inteface. These classes would be database specific like mysql, mssql, orcale etc.
* If some functionality will be same for all concrete classes then this interface can be implemented by 
* one abstract base class and concrete classes will inherit from that base class
* 
*/
class DbMysql extends DbAbstract
{
	protected $db;
	
	private $dso;
	private $stmt;
	
	public function __construct($host = 'localhost', $dbname, $username, $password)
	{
		parent::__construct($host , $dbname, $username, $password);
		$this->connect();
	}	
	/*
	* @param: (string) $sql SQL query
	* @desc : This method will prepare queries
	* 
	*/
	public  function query($sql)
	{
		$this->stmt = $this->db->prepare($sql);
        return $this;
	}	

	public function bind($pos, $value)
	{
		$this->stmt->bindValue($pos, $value);
		return $this;
	}
	/**
	* @desc: execute the prepared statement 
	*	
	*/		
	public  function execute(Array $parameters = array())
	{		
		if (!empty($parameters))
		{
			return $this->stmt->execute($parameters);
		}
		return $this->stmt->execute();
	}
	
	/**
	* @desc : fetch result and return; This will return single row as associative array 
	* @param: PDO::FETCH_MODE 
	*/
	public  function fetch($fetch_mode = PDO::FETCH_ASSOC)
	{
		$this->execute();      
		return $this->stmt->fetch($fetch_mode);
	}
	/**
	* @desc : fetch results and return 
	* @param: PDO::FETCH_MODE 
	*/
	public  function fetchAll($fetch_mode = PDO::FETCH_ASSOC)
	{
		$this->execute();
        return $this->stmt->fetchAll($fetch_mode);		
	}
	/**
	* @param: (int) $column : auto increment column name default to id but if you named your table's primary key
	* other than id you need to pass it. 
	* @desc : Insert Record and return last insert id
	*/	
	public function insert($column = 'id')
	{
		$this->execute();
		//return last insert id
		return $this->db->lastInsertId($column);
	}
	/**
	*	Execute the current query and return results in object format,
	*	you can off course use fetch method with  PDO::FETCH_OBJ as a parameter instead of this method
	*/
	public function fetchObject()
	{
		$this->execute();
		return $this->stmt->fetchObject();
	}
	public function update()
	{
		$this->execute();
		//
	}
	/*
	*	@desc : Insert Record and return last insert id 
	*	@todo : will work on this to make generic
	*/
	public function save($table, $data, $pk = 'id')
	{
		/*$query = 'INSERT INTO {$table} VALUES( '
		$placeholder = '';
		
		foreach($data as $key => $value)
		{
			$placeholder = ':'. $key . ',';
		}
		
		$placeholder = rtrim($placeholder, ',');
		$placeholder .= ')';
		
		$this->db->query()
		*/
	}
	
	
}