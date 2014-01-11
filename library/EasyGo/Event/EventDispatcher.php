<?php
/**
*	Mediator between Subject and Observers
*	
*/
namespace EasyGo\Event;
use EasyGo\Exception\EasyException;

class EventDispatcher implements EventInterface
{
	
	/**
	*	System Events: System events are those which Framework uses for it's internal processing
	*	Plugin writer can not use or override system events to attach listners 
	*/
	private $systemEvents = array (
									
								);
	/**
	*	@var array $events User Registered events 
	*/
	protected $events = array();
	
	/**
	*
	*/
	private static $_instance;
	/**
	*
	*/
	public static function getInstance()
	{
		if (self::$_instance == null)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}	
	/**
	*	Add Event Listner
	*/	
    public function attach($eventName, $callback, $priority = 0) 
	{
        if (!isset($this->events[$eventName])) 
		{
            $this->events[$eventName] = array();
        }
        $this->events[$eventName][] = $callback;
    }
	/**
	*	remove Event listner
	*/
	public function detach($event)
	{
		if (isset($this->events[$event]))
		{
			unset($this->events[$event]);
		}
	}
	/**
	*	Check if the listners are attached to the Event
	*/
	public function hasListener($eventName)
	{
		if (isset($this->events[$eventName]))
		{
			return true;
		}
		return false;
	}
	/**
	*	trigger the event and call all listner
	*/
    public function trigger($eventName, $data = null) 
	{		
        if (isset($this->events[$eventName]))
		{
			foreach ($this->events[$eventName] as $callback) 
			{
			   // $callback($eventName, $data);			
				if (is_callable($callback))
				{
					return call_user_func($callback, $data);				
				}
				else
				{ // if the callback is not callable throw exception
					throw new EasyException('Event could not be triggered, Passed callback is not callable.');
				}
			}
		}
		throw new EasyException('Event could not be triggered, Event "'.$eventName.'" is not a valid or registered event.');
    }
	
	
	
}
?>