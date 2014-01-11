<?php
/**
*
*/
namespace EasyGo\Parser;
use EasyGo\Exception\EasyException;

class XmlParser extends ParserAbstract
{
	/**
	*
	*/
	public $simpleXml;
	
	
	
	/**
	* Parse the xml file.
	*/
	public function parse($file)
	{
		if ($file == null)
		{
			throw new EasyException('Xml file could not be parsed, not a valid file '. $file .'.');
		}
		
		$this->simpleXml = new \SimpleXMLElement($file, null, true);
		
		
		return $this;
	}
	/**
	*	Run the xpath query and return result 
	*
	*/
	public function xpathQuery($query)
	{
		if ($query == null)
		{
			return false;
		}
		return $this->simpleXml->xpath($query);	
	}
	/**
	*	Set the simplexml Object.
	*/
	public function setSimpleXml()	
	{
		
	}
	/**
	*
	*/
	public function getSimpleXml()
	{
		return $this->simpleXml;
	}
	/**
	*	Get the dom object.
	*/	
	public function getSimpleDom()
	{
		
	}
}