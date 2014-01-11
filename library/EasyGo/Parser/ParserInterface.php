<?php
/**
*
*/
namespace EasyGo\Parser;



interface ParserInterface
{
	/**
	*
	*/
	public function open();
	
	/**
	*
	*/	
	public function parse($file);
	
	/**
	*
	*/
	public function close();	
}