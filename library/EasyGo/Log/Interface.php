<?php
/**
* Common Interface for Logging
*
* All Logger classes should implement this interface 
* @package EasyGo
* @subpackage Logger
* @author Shakti Singh <shakti.singh@sunarctechnologies.com>	
*/
namespace EasyGo\Log;

interface Logger
{
	public function write();
}