<?php
/**
*	Configuration class holds configuration variables
*	This class will also load the system configuration (system.xml) and module configuration (<module>.xml)
*	
*/
namespace EasyGo\Config;
use EasyGo\Exception\EasyException;

class ApplicationConfig 
{
		
	/**
	* @var array holds application ini settings 
	*/
	protected  $settings = array();
	
	/**
	*	System Configuration instance
	*/
	public $systemConfig;
	
	/**
	* Module Configuration instance
	*/
	public $moduleConfig; 
	
	/**
	* Instance of ApplicationConfig
	*/
	private static $_instance; 
	
	/**
	*	Config file path
	*/
	public $configFile;
	
	/**
	*	System Config file path
	*/
	public $systemConfigFile;
	
	/**
	* module config file path
	*/
	public $moduleConfigFile;
	
	/**
	*	 Constructor
	*/
	public function __construct(SystemConfig $systemConfig)
	{
		//load configuration setting in $_config property
		$this->systemConfig = $systemConfig;
		
	}
	/**
	*	Creat the instane of this class
	*/
	public static function getInstance()
	{
		if (null == self::$_instance)
		{
			self::$_instance = new self( new SystemConfig);
		}
		return self::$_instance;
	}
	/**
	* Load configuration file and set config class properties
	*/
	public function loadConfiguration()
	{
		$configFile = $this->getConfigFile();
		
		if (FALSE == is_readable($configFile))
		{
			throw new EasyException('Configuration file does not exists or not readable.');
		}		
		if((FALSE === ($config = parse_ini_file($configFile))))
		{
			throw new EasyException('Configuration file could not be parsed.');
		}
		foreach ($config as $key => $value)
		{
			$this->settings[$key] = $value;
		}
		/** load system configuration **/
		$this->loadSystemConfiguration();
		
		
		
	}
	/**
	*	Set application configuration file.
	*/
	public function setConfigFile($configFile)
	{
		$this->configFile = $configFile;
		return $this;
	}
	/**
	* Return config file path 
	*/
	public function getConfigFile()
	{
		return $this->configFile; 
	}
	/**
	*	Set system configuration file.
	*/
	public function setSystemConfigFile($systemConfig)
	{
		$this->systemConfigFile = $systemConfig;
		return $this;
	}
	
	/**
	*
	*/
	public function getSystemConfigFile()
	{
		return $this->systemConfigFile;
	}

	/**
	*
	*/
	public function loadSystemConfiguration()
	{
		$this->systemConfig->loadConfiguration($this->getSystemConfigFile());
	}
	
	
	/**
	*	Set a property 
	*/
	public function __set($name, $value)
	{
		$this->settings[$name] = $value;
	}
	/**
	*	get a property
	*/
	public function __get($name)
	{
		return isset($this->settings[$name]) ? $this->settings[$name] : null;
	}
	public function __call($func, $test)
	{
		 $func;
	}
	
}
?>