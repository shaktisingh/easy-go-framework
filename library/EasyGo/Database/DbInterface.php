<?php
/*
* @author: Shakti Singh
* @date: 21-02-2013
* @desc: Dabase Interface. This interface defines the methods which must be implemented by the classes which
* implements this inteface. These classes would be database specific like mysql, mssql, orcale etc.
* If some functionality will be same for all concrete classes then this interface can be implemented by 
* one abstract base class and concrete classes will inherit from that base class
* 
*/
namespace EasyGo\Database;
interface DbInfterface
{
	public function connect();
	public function query($sql);
	public function execute();
	public function fetch();
	public function fetchAll();	
}