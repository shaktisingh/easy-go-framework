<?php
/**
*	Initialize and run Application
*	
*/
namespace EasyGo;

use EasyGo\Router\Router ;
use EasyGo\Router\RouterInterface ;
use EasyGo\Http\RequestAbstract;
use EasyGo\Http\Request ;
use EasyGo\Config\ApplicationConfig;
use EasyGo\Registry;
use EasyGo\Plugin\PluginManager;
use EasyGo\Module\ModuleManager;
use EasyGo\Config\ModuleConfig;
use EasyGo\Exception\EasyException;


use EasyGo\Parser\XmlParser;

class Application 
{
	/**
	*
	*/
	public $diContainer ; 
	/**
	*
	*/
	public $router;
	/**
	*
	*/
	protected static $instance;
	/**
	* @var array
	*/
	public $request ;
	/**
	*
	*/
	public $response; 
	/**
	*
	*/
	public $config;
	/**
	*
	*/
	public $defaultController;
	/**
	*
	*/
	public $defaultAction ;
	/**
	*
	*/
	public $appName;
	
	/**
	*
	*/
	public $exception; 
	
	/**
	*	Application Constructor
	*/
	public function __construct()
	{
		
	}
	public static function getInstance()
	{
		if (self::$instance == null)
		{
		  self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	*	initialize required objects 
	*/
	public function init()
	{				
		
		$this->config = Registry::getInstance()->config = ApplicationConfig::getInstance();
		$request = Registry::getInstance()->request = new Request;	
		
		
		
		$this->setAppName($this->config->appName);
		
		$this->setRouter(Router::getInstance())						
						->setRequest($request)
						->setRawRoute()
						->setDefaultModule('site')
						->setDefaultController('site')
						->setDefaultAction('index')						
						->setBasePath(dirname(dirname(dirname(__FILE__))))
						->setModule()
						->setController()
						->setAction();				
		
		// load module (modules which are in extension folders ) configuration 
		ModuleManager::getInstance()->loadModuleConfig();
		
		//set application configurations config.ini
		// Load system configuration system.xml
		
		$this->config->setConfigFile($this->getConfigFile())
					 ->setSystemConfigFile($this->getSystemConfigFile())					 
					 ->loadConfiguration();	;
		
		// load the userspace bootstrap class and run init method 	
		$initialize =  Registry::getInstance()->request->getBasePath() . DS . Registry::getInstance()->config->appDir . DS . 'initializer.php';
		
		if (file_exists($initialize))
		{			
			$initializer = new \initializer();
			$initializer->init();
		}
		// Module specific configuration file <module>.xml
		ModuleConfig::getInstance()->loadConfiguration();
			
					
		// load plugin configurations		
		PluginManager::getInstance()->loadPluginConfig();
		
		
			
		
		// load plugins 
		PluginManager::getInstance()->loadPlugins();
		
		$this->exception = new EasyException(null);
		return $this;
	}
	
	public function setRequest(RequestAbstract $request)
	{
		//var_dump($request);
		$this->request = $request;
		return $this->request;
	}
	/**
	*
	*/
	public function getRequest()
	{
		return $this->request;
	}
	/**
	*	Dependency here resolve by setting a Dependency Container
	*	Class should depend on abstraction not on concrete classes
	*/
	public function setRouter(RouterInterface $router)
	{
		if (null == $this->router)
		{
			$this->router = $router;
		}	
		return $this;
	}	
	/**
	*	Set Application Name
	*/
	public function setAppName($appName)
	{
		$this->appName = $appName; 
		return $this;
	}
	/**
	*	Return the application directory name
	*/
	public function getAppDir()
	{
		return $this->config->appDir;
	}
	/**
	*
	*/
	public function getRouter()
	{
		return $this->router ;
	}
	
	/**
	* Get Config file path 
	*/
	public function getConfigFile()
	{	
		return $this->request->getBasePath() . DS . 'config' . DS . 'config.ini';
	}
	
	/**
	*	Get System config file 
	*/
	public function getSystemConfigFile()
	{
		return $this->request->getBasePath() . DS . 'config' . DS . 'modules' . DS . 'system.xml';
	}
	
	public function run()
	{
		$this->router->dispatch();
	}
}
?>