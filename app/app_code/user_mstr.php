<?php
include_once("tablemaster.php"); 
class UserMstr extends TableMaster 
{
	private static $id = 0;
	private static $username = 1;
	private static $name = 2;
	private static $password = 3;
	private static $status = 4;
	private static $entry_date_time = 5;
	function __construct() 
	{
		$strtblName = array("user_mstr");
		$this->setTblName($strtblName);
		$this->fields = array();
		$this->fieldsName = array();
		$this->fieldsType = array();
	}
	function setId($id)
	{
		$this->fieldsName[self::$id] = "id";
		$this->fieldsType[self::$id] = Fields::$text;
		$this->fields[self::$id] = $id;
	}
	function getId()
	{
		return $fieldsvalue[self::$id];
	}
	function setUsername($username)
	{
		$this->fieldsName[self::$username] = "username";
		$this->fieldsType[self::$username] = Fields::$text;
		$this->fields[self::$username] = $username;
	}
	function getUsername()
	{
		return $fieldsvalue[self::$username];
	}
	function setName($name)
	{
		$this->fieldsName[self::$name] = "name";
		$this->fieldsType[self::$name] = Fields::$text;
		$this->fields[self::$name] = $name;
	}
	function getName()
	{
		return $fieldsvalue[self::$name];
	}
	function setPassword($password)
	{
		$this->fieldsName[self::$password] = "password";
		$this->fieldsType[self::$password] = Fields::$text;
		$this->fields[self::$password] = $password;
	}
	function getPassword()
	{
		return $fieldsvalue[self::$password];
	}
	function setStatus($status)
	{
		$this->fieldsName[self::$status] = "status";
		$this->fieldsType[self::$status] = Fields::$text;
		$this->fields[self::$status] = $status;
	}
	function getStatus()
	{
		return $fieldsvalue[self::$status];
	}
	function setEntryDateTime($entry_date_time)
	{
		$this->fieldsName[self::$entry_date_time] = "entry_date_time";
		$this->fieldsType[self::$entry_date_time] = Fields::$text;
		$this->fields[self::$entry_date_time] = $entry_date_time;
	}
	function getEntryDateTime()
	{
		return $fieldsvalue[self::$entry_date_time];
	}
}
?>
