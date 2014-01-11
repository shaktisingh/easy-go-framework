<?php
/**
*	Mediator between Subject and Observers
*	
*/
namespace EasyGo\Event;
interface EventInterface 
{
	public function attach($event, $callback, $priority);
	public function detach($event);
	public function trigger($event);
	
}
?>