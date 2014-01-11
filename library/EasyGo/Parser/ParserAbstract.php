<?php
/**
*	Abstract class for Parser
*/
namespace EasyGo\Parser;



abstract class ParserAbstract implements ParserInterface
{
	/**
	*	File open mode
	*/
	const MODE = 'r';
	
	/**
	*	File name 
	*/
	public $filename;
	
	/**
	* File ponter
	*/
	public $fp;
	
	
	
	/**
	*	Open file for read
	*/
	public function open()
	{
		$this->fp = fopen($this->filename, self::MODE);
	}	
	
	
	/**
	*	Close the file.
	*/
	public function close()
	{
		fclose($this->fp);
	}
}