<?php
/**
*  core controller
*
* 
*
*/
namespace EasyGo\Mvc\Controller;
use EasyGo\Mvc\Controller\ControllerAbstract;
use EasyGo\Mvc\View\CoreView;
use EasyGo\Mvc\View\ViewAbstract;

class CoreController extends ControllerAbstract
{
	/**
	*	Redirect to requested url
	*/
	public function redirect($url)
	{
		$this->request->redirect($url);
	}
}
