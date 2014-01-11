<?php
/**
*
*/
namespace EasyGo\Session\Handlers;

interface SessionHandlerInterface 
{
	public function open($savePath, $sessionName);  
	public function close();    
	public function read($id);    
	public function write($id, $data);    
	public function destroy($id);
	public function gc($maxlifetime);
}
