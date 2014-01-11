<?php
/**
*  Log exceptions 
*
* 
* @package EasyGo
* @subpackage Logger	
* @author Shakti Singh <shakti.singh@sunarctechnologies.com>
*/

namespace EasyGo\Log;

class ExceptionLog implements Logger
{
	
	protected $filename; 
	protected $fp ;
	
	/**
	*
	*/
	public function __construct()
	{
		//$this->getConfiguration
	}
	/**
	*
	*/
	public function open()
	{
		//Don't use hardcode file name here put this in configuration file
		$this->setFilename('exception.log');
		
		$file = $this->getFilename();
		// open exception log file 
		$this->fp = fopen($file, 'w');
		
	}
	/**
	*
	*/
	public function write($logMessage)
	{
		// write exception to log file 
		fwrite($this->fp, $logMessage);
	}
	/**
	*
	*/
	public function close()
	{
		// close log file 
		fclose($this->fp);
	}
	/**
	*
	*/
	public function getFilename()
	{
		return $this->filename;
	}
	/**
	*
	*/
	public function setFilename($name)
	{
		$this->filename = $name;
	}
}














