<?php
/*
* @author: Shakti Singh
* @date: 20-02-2013
* @desc: Auth Model class : Save & Retrieve Token
*/
class Auth extends Model 
{
	public $table = 'token';
	
	/**
	*	Call Parent constructor
	*/	
	public function __construct()
	{
		parent::__construct();
	}
	/**
	*
	*/
	public function save(Array $data)
	{
		try
		{
			$this->db->query("INSERT INTO {$this->table} (token, user_id) VALUES(?, ?)")
				 ->bind(1, $data['token'])
				 ->bind(2, $data['user_id'])
				 ->execute();
			 
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
}
