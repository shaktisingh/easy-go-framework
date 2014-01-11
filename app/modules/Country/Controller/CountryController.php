<?php
namespace Country\Controller;

use EasyGo\Mvc\Controller\CoreController;
use Country\Model\Country;
class CountryController extends CoreController
{
	
	public function __construct()
	{
		parent::__construct();
		$model = Country::getInstance();
	}
	/**
	*	List Countries
	*/
	public function indexAction()
	{
		
	}
	
	/**
	*	Add Country
	*/
	public function addAction()
	{
		
		//if ($this->request->isPost() && $this->validRequest())
		if ($this->request->isPost())
		{
			
			//$model->getGateway->insert($data)
			$this->redirect('country/country/');
		}		
		
	}	
	/*
	*	Listing of countries
	*/
	public function manageAction()
	{
		
	}
	
}