<?php
/*
*	Entry point for all requests
*
*	@author  Shakti Singh <shakti.blevel@gmail.com>
*	@package EasyGo
*	@since version 1.0
*/
 
// Define directory separator
define('DS', DIRECTORY_SEPARATOR);

// set include path

set_include_path(dirname(__DIR__) . DS . 'library');

// include loader
require dirname(__DIR__) . DS . 'library/EasyGo/Loader/Loader.php' ;

EasyGo\Loader\Loader::init();

require dirname(__DIR__) . DS . 'library/EasyGo/Application.php';

//


// initialize and run application 

EasyGo\Application::getInstance()->init()->run();


