<?php
/**
*
*/
namespace EasyGo\Session\Handlers;
/**
*	Session file handler 
*/
class FileHandler implements SessionHandlerInterface
{
	private $savePath;
	
	/**
	*	Open session file save path
	*/
	public function open($savePath, $sessionName)
	{	
		$this->savePath = $savePath;
		if (!is_dir($this->savePath)) 
		{
			mkdir($this->savePath, 0777);
		}
		return true;
	}
	/**
	*
	*/
    public function close()
    {
        return true;
    }
	
	/**
	*
	*/	
    public function read($id)
    {	
		if (file_exists($this->savePath . DS . 'sess_' . $id))
		{
			return (string)@file_get_contents($this->savePath . DS . 'sess_' . $id);
		}
		return '';
    }
	
	/**
	*
	*/
    public function write($id, $data)
    {       
	   return file_put_contents($this->savePath . DS . 'sess_' . $id, $data) === false ? false : true;	   
    }
	
	/**
	*
	*/
	public function destroy($id)
    {
        $file = $this->savePath . DS . 'sess_' . DS . $id;
        if (file_exists($file)) 
		{
            unlink($file);
        }	
        return true;
    }
	
	/**
	*
	*/
    public function gc($maxlifetime)
    {
        foreach (glob("$this->savePath/sess_*") as $file) 
		{
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) 
			{
                unlink($file);
            }
        }
		return true;
	}
}	