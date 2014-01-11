<?php
/**
* Controller Insterface 
*
* 
* 
*/
namespace EasyGo\Mvc\Controller;

interface ControllerInterface
{
	public function getController($controller);	
	public function getModel($model);
	public function setActionView();
	public function getActionView();
	public function setLayout($layout);	
	public function getLayout();
	public function setTheme();
	public function getTheme();
	public function dispatch($action);
}