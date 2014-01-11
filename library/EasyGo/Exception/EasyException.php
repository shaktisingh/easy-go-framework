<?php
namespace EasyGo\Exception;
use EasyGo\Registry;
class EasyException extends \Exception
{
	/**
	* @var $log logger instance
	*/
	protected $logger;
	/**
	*	
	*/
	public $userController;
	/**
	*
	*/
	public $userAction ;
	
	/**
	* Set the exception and error handler methods
	*/
	public function __construct($message)
	{
		parent::__construct($message);
		$this->setExceptionHandler();
		$this->setErrorHandler();
		$this->setUserController();
		$this->setUserAction();
	}
	public function setUserController()
	{
		$this->userController = 'Site\\Controller\\SiteController';
	}
	public function getUserController()
	{
		return $this->userController;
	}
	public function setUserAction()
	{
		$this->userAction = 'error';
	}
	public function getUserAction()
	{
		return $this->userAction;
	}
	/**
	* Initailaze EasyException Object.
	* Set Logger 
	*/
	public function init(Logger $logger)
	{
		$this->logger = $logger ;
	}
	/**
	* Set Exception Handler Method
	*/
	public function setExceptionHandler()
	{
		set_exception_handler(array($this, 'exceptionHandler'));
	}
	/**
	* Exception Handler
	*
	* Forward the exception to SiteController's error method if defined, otherwise render the exception	
	*/
	public function exceptionHandler($exception)
	{
		//var_dump($exception);
		// if the exception and error raise together in a single request we try to catch exception	
		
		try
		{			
			if (is_callable(array($this->getUserController(),$this->getUserAction())))		
			{				
				call_user_func(array($this->getUserController(),$this->getUserAction()), $exception);			
				return;
			}
			throw $exception;
		}
		catch(\Exception $e)
		{
			//render exception
			$this->renderException($exception);
			//render error
			//$this->renderException($e);
		}	
		
	}
	/**
	*	Set Error Handler
	*/
	public function setErrorHandler()
	{
		set_error_handler(array($this, "exceptionErrorHandler"));
	}
	/**
	*	Log Exception
	*/
	public function logException()
	{
		$body = $this->getBody();
		$this->logger->log($body);
	}
	public function getBody()
	{
		//return exception message
	}
	
	/**
	*	Display Formatted Exception Message
	*/	
	public function renderException($exception)
	{		
		$config = Registry::getInstance()->config;
		$appTitle = function() use ($config)
					{
						if (isset($config->appName))
						{
							return $config->appName;
						}
						return ;
					};
		
		$title = $appTitle() . ' Application Error';
        $code = $exception->getCode();
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $trace = $exception->getTraceAsString();
        $html = sprintf('<h1>%s</h1>', $title);
        $html .= '<p>The application could not run because of the following error:</p>';
        $html .= '<h2>Details</h2>';
        $html .= sprintf('<div><strong>Type:</strong> %s</div>', get_class($exception));
        if ($code) {
            $html .= sprintf('<div><strong>Code:</strong> %s</div>', $code);
        }
        if ($message) {
            $html .= sprintf('<div><strong>Message:</strong> %s</div>', $message);
        }
        if ($file) {
            $html .= sprintf('<div><strong>File:</strong> %s</div>', $file);
        }
        if ($line) {
            $html .= sprintf('<div><strong>Line:</strong> %s</div>', $line);
        }
        if ($trace) {
            $html .= '<h2>Trace</h2>';
            $html .= sprintf('<pre>%s</pre>', $trace);
        }

        echo sprintf("<html><head><title>%s</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana,sans-serif;}h1{margin:0;font-size:25px;font-weight:normal;line-height:25px;}strong{display:inline-block;width:65px;}</style></head><body>%s</body></html>", $title, $html);
 
	}
	
	/**
	*	Convert Fatal Errors in Exceptions 
	*/	
	public function exceptionErrorHandler($errno, $errstr, $errfile, $errline ) 
	{
		//print_r(func_get_args());
		if (is_callable(array($this->getUserController(),$this->getUserAction())))		
		{
			call_user_func(array($this->getUserController(),$this->getUserAction()), func_get_args());			
			return;
		}
		
		throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
	}
}
?>