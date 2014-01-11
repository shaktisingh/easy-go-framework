<?php
/**
* @author: Shakti Singh
* @date: 20-02-2013
* @desc: Feedback Model class : This class will handle all the database operations for Feedback module
*/
class Feedback extends Model 
{
	public $table = 'feedback';
	
	/**
	*	Call the construct of parent model
	*/
	public function __construct()
	{
		parent::__construct();
	}
	/**
	*	Save the feedback data
	*/
	public function save($data)
	{
		//$this->db->insert($data);
	}
}
