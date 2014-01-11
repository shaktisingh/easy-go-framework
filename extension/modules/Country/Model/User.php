<?php
/*
* @author: Shakti Singh
* @date: 20-02-2013
* @desc: User Model class : This class will handle all the database operations for user table
*/
class User extends Model 
{
	public $table = 'candidate';
	
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
	/**
	*	Return the id of user by token passed 
	*/
	public function getUserByToken($token)
	{	
		return $this->db->query('SELECT user_id, token FROM token WHERE token = ? ')
				 ->bind(1, $token)
				 ->fetch();
	}
}
