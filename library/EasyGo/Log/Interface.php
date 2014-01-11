<?php
/**
* Common Interface for Logging
*
* All Logger classes should implement this interface 
* @package EasyGo
* @subpackage Logger
* @author Shakti Singh <shakti.blevel@gmail.com>	
*/
namespace EasyGo\Log;

interface Logger
{
	public function write();
}