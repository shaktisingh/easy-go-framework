<?php
/**
*	Event Data class.
*
*	Object of this class can be passed to the listners. 
*	You should create object of this class and attach some data to it via properties and pass it to listners.
*	Let listners will modify this data you should send this data to view to display modified data
*	Usually you can initiate this class in your controller and attach some data. 
*/
namespace EasyGo\Event;

class Event 
{
	/**
	*	Set the property 
	*/	
	public function __set($name, $data)
	{
		$this->$name = $data;
	}
	/**
	*	Return the value of requested property
	*/
	public function __get($name)
	{
		return $this->$name;
	}
}
?>