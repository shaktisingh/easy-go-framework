<?php
/**
*	Extension to override default country module behaiour.
*
*	
*/
namespace Extension\Country\Controller;

use EasyGo\Mvc\Controller\CoreController;
use Country\Model\Country;
/**
*	SystemCountryController is the main controller which is defined in app/modules/Country/Controller 
*	we call it System<...> because it is defined in the core system of online-exam.
*/
use Country\Controller\CountryController as SystemCountryController;

class CountryController extends SystemCountryController
{
	
	public function addAction()
	{
		echo 'I got extended'; 
		if ($this->request->isPost())
		{
			
			
		}
	}
}