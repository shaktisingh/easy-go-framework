<?php
/**
*	Session Manager.
*	@author Shakti Singh <shakti.singh@sunarctechnologies.com>
*/
namespace EasyGo\Session;

use EasyGo\Session\Handlers\SessionHandlerInterface;

class Session extends SessionAbstract
{
	/**
	*	@const Default Namespace name
	*/
	const DEFAULT_NAMESPACE = 'default';
	
	/**
	*	Session handler instance
	*/
	public $handler;
	
	/**
	*
	*/
	public $namespace ; 
	
	/**
	*
	*/
	private static $_instance;
	
	/**
	*	Initialize 
	*/
	public function __construct($handler)
	{
		$this->handler = $handler;
		//var_dump($this->handler);
		session_set_save_handler(
			   array($this->handler, 'open'),
			   array($this->handler, 'close'),
			   array($this->handler, 'read'),
			   array($this->handler, 'write'),
			   array($this->handler, 'destroy'),
			   array($this->handler, 'gc')
			);
		 register_shutdown_function('session_write_close');
	}
	/**
	*	create and return the instance of session
	*/
	public static function getInstance(SessionHandlerInterface $handler = null)
	{
		if (self::$_instance == null)
		{			
			if ($handler == null)
			{
				throw new \InvalidArgumentException('Wrong parameter type passed, Session class requries an instance of SessionHandlerInterface '. gettype($handler). ' given.');
			}
			return self::$_instance = new self($handler);
		}
		return self::$_instance;
	}
	/**
	*	Start Session
	*/    
	public function start()
	{
		if (ini_get('session.use_cookies') && headers_sent()) {
            throw new \RuntimeException('Failed to start the session because headers have already been sent.');
        }

        // start the session
        if (!session_start()) {
            throw new \RuntimeException('Failed to start the session');
        }
		$this->setNamespace(self::DEFAULT_NAMESPACE);
	}
	/**
	*	Set the Session Namespace
	*/
    public function setNamespace($namespace)
	{
		if ($namespace == null)
		{
			return false;			
		}	
		$this->namespace = $namespace;
		if (!isset($_SESSION[$namespace]))
		{
			$_SESSION[$namespace] = array() ;
		}	
	}
	
	/**
	*
	*/
	public function getNamespace()
	{
		return $this->namespace;
	}
	
	/**
	*	Set the session value in $_SESSION GLOBAL
	*/
	public function set($name, $value)
	{
		if ($name == null)
		{
			return false;
		}	
		$_SESSION[$this->getNamespace()][$name] = $value;
	}
	
	/**
	*	Get the value from $_SESSION GLOBAL
	*/
	public function get($name)
	{
		return isset($_SESSION[$this->getNamespace()][$name]) ? $_SESSION[$this->getNamespace()][$name] : null;
	}
	
	/**
	*	Unset session variable from current Namespace
	*/
	public function remove($name)
	{
		if (isset($_SESSION[$this->getNamespace()][$name]))
		{
			unset($_SESSION[$this->getNamespace()][$name]);
		}
	}
	/**
	*
	*/
	public function removeNamespace($namespace)
	{
		if (isset($_SESSION[$namespace]))
		{
			unset($_SESSION[$namespace]);
		}
	}
	/**
	*	Close the session from writing when object of session class destroyed
	*/
	public function __destruct()
	{
		session_write_close();
	}
}	