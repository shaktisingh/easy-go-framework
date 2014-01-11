<?php
namespace Site\Controller;

use EasyGo\Exception\EasyException;
use EasyGo\Mvc\Controller\CoreController;
use Site\Model\Site;

class SiteController extends CoreController
{
	/**
	* 	Site home page 
	*/	
	public function indexAction()
	{
		//$this->setTheme('shakti');
		//echo '<pre>'; print_r($this);
		//echo $this->view->actionView;
		//$data = array ('username' => 'shakti', 'password' => 'sdfsdfsd', 'email' => 'shakti.blevel@gmail.com');
		//$site = Site::getInstance();
		//$site->getGateway()->insert($data);
				
		$this->event->name = 'test';
		$this->event->age = '25';
		$this->event->class = 'developer';
		$this->view->data = $this->event; 
		
		//$this->getSession()->set('Framework', 'EasyGo');
		
		
		//var_dump($site);
	}
	
	public function addAction()
	{		
	
	}
	
	/**
	*	Error Handler Method, if this is not defined here, core methods will be used to show exceptions 
	*/
	/*public static function error($exception)
	{
		if ($exception instanceof EasyException)
		{
			
			echo "Exception Message From Site Controller: " , $exception->getMessage(), "<br>";
			echo $exception->getTraceAsString();
		}
		else if ($exception instanceof \Exception)
		{
			echo "Exception Message From Site Controller: " , $exception->getMessage(), "<br>";
			echo $exception->getTraceAsString();
		}
		else
		{
			echo 'Fatal Error: '. $exception[0] . ' in file '. $exception[3] . ' at line '. $exception[4]; 
			echo '<pre>'; print_r($exception);
		}
	}*/
}