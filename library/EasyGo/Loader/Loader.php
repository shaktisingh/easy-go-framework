<?php
/**
*	Auto load classes
*	
*/
namespace EasyGo\Loader;

use EasyGo\Application ;
use EasyGo\Exception\EasyException;
use EasyGo\Registry;
class Loader 
{
	
	protected static $loader;
	/**
	* @var path
	*/
	public $path ;
	
	/**
	* @var class
	*/
	public $class;
	
	/**
	*	Set Auto Loader
	*/
	public function __construct()
	{
		//spl_autoload_register(array($this, 'load'));
	}
	
	//create the loader object and decalre autoloader method
	public static function init()
	{
		if(null == self::$loader)
		{
			self::$loader = new self();
			// self::$_instance = new self();
		}			
		//spl_autoload_register(array(self::$loader, 'load'));
		spl_autoload_register(array(self::$loader, 'loadLibrary'));
		spl_autoload_register(array(self::$loader, 'loadExtendsModules'));
		spl_autoload_register(array(self::$loader, 'loadAppModules'));
		spl_autoload_register(array(self::$loader, 'loadApp'));	
		
	}
	
	//Load Classes 
	/*public function load($namespace)
	{		
		$pathChunks = explode('\\', $namespace);
		// set class name
		$this->class = array_pop($pathChunks);
		// construct platform independent path
		$this->path = $this->constructPath($pathChunks);
		$path = dirname(dirname(__DIR__)) . DS . $this->path . DS . $this->class . '.php';
		//load class file from Library directory, check if exists
		if (file_exists($path))
		{
			require_once $path;
			return;
		}
		else
		{
			
			//echo $path;
			//if file does not exists in Library folder, look up in application folder
			$appDir = Application::getInstance()->getAppDir();
			//replace library with app name
			$path = str_replace('library', $appDir . DS. 'modules', $path);
			if (file_exists($path)) //check if file exists in application's module directory
			{
				require_once $path;
				return;
			}
			//try to load from application's directory
			$path = str_replace('modules','', $path);
			
			if (file_exists($path))
			{
				require_once $path;
				return;
			}
			//set header http status code here before throwing exception and get and send header where catching exception
			
			throw new EasyException('404 Not Found.' . $path);
			
		}	
		
	}*/
	/**
	*	Load classes from library directory 
	*
	*/
	public function loadLibrary($namespace)
	{
		$pathChunks = explode('\\', $namespace);
		// set class name
		$this->class = array_pop($pathChunks);
		// construct platform independent path
		$this->path = $this->constructPath($pathChunks);
		$path = dirname(dirname(__DIR__)) . DS . $this->path . DS . $this->class . '.php';
		
		if (file_exists($path))
		{
			require_once $path;
			return;
		}
		
		
	}
	
	/**
	*	Load modules from extends directory
	*/
	public function loadExtendsModules($namespace)
	{
		
		$pathChunks = explode('\\', $namespace);
		
		$this->class = array_pop($pathChunks);
		
		$extension = strtolower(array_shift($pathChunks));
		$parts = implode(DS, $pathChunks);
		
		$path = Registry::getInstance('request')->getBasePath() 						
						. DS . $extension . DS . 'modules' . DS . $parts . DS . $this->class . '.php' ;
		if (file_exists($path)) //check if file exists in extends's module directory
		{
			require_once $path;
			return;
		}
	}
	
	/**
	*	Load modules from application modules directory 
	*/
	public function loadAppModules($namespace)
	{
		//if file does not exists in Library folder, look up in application folder
		$appDir = Application::getInstance()->getAppDir();
		//replace library with app name
		$path = Registry::getInstance('request')->getBasePath() 
						. DS . Application::getInstance()->getAppDir() 
						. DS . 'modules' . DS . $this->path . DS . $this->class . '.php' ;
		if (file_exists($path)) //check if file exists in application's module directory
		{
			require_once $path;
			return;
		}
		
	}
	
	/**
	*	Load classes from application directory 
	*/
	public function loadApp($namespace)
	{
		$path = Registry::getInstance('request')->getBasePath() 
							. DS . Application::getInstance()->getAppDir() 
							. DS . $this->path . DS . $this->class . '.php';
	
		if (file_exists($path))
		{
			require_once $path;
			return;
		}
		throw new EasyException('404 Not Found. Could not found "' . $namespace . '"');
	}
	
	/**
	*
	*/
	public function setPath($path)
	{
		$this->path = $path;
	}
	
	public function setClass($class)
	{
		$this->class = $class;
	}
	
	public function constructPath($path)
	{
		return implode(DS, $path);
	}
}
?>