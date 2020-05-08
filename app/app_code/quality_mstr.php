<?php
include_once("tablemaster.php"); 
class QualityMstr extends TableMaster 
{
	private static $id = 0;
	private static $user_id = 1;
	private static $tds = 2;
	private static $date = 3;
	private static $time = 4;
	private static $setting_fetch_status = 5;
	private static $entry_date = 6;
	private static $status = 7;
	function __construct() 
	{
		$strtblName = array("quality_mstr");
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
	function setUserId($user_id)
	{
		$this->fieldsName[self::$user_id] = "user_id";
		$this->fieldsType[self::$user_id] = Fields::$text;
		$this->fields[self::$user_id] = $user_id;
	}
	function getUserId()
	{
		return $fieldsvalue[self::$user_id];
	}
	function setTds($tds)
	{
		$this->fieldsName[self::$tds] = "tds";
		$this->fieldsType[self::$tds] = Fields::$text;
		$this->fields[self::$tds] = $tds;
	}
	function getTds()
	{
		return $fieldsvalue[self::$tds];
	}
	function setDate($date)
	{
		$this->fieldsName[self::$date] = "date";
		$this->fieldsType[self::$date] = Fields::$text;
		$this->fields[self::$date] = $date;
	}
	function getDate()
	{
		return $fieldsvalue[self::$date];
	}
	function setTime($time)
	{
		$this->fieldsName[self::$time] = "time";
		$this->fieldsType[self::$time] = Fields::$text;
		$this->fields[self::$time] = $time;
	}
	function getTime()
	{
		return $fieldsvalue[self::$time];
	}
	function setSettingFetchStatus($setting_fetch_status)
	{
		$this->fieldsName[self::$setting_fetch_status] = "setting_fetch_status";
		$this->fieldsType[self::$setting_fetch_status] = Fields::$text;
		$this->fields[self::$setting_fetch_status] = $setting_fetch_status;
	}
	function getSettingFetchStatus()
	{
		return $fieldsvalue[self::$setting_fetch_status];
	}
	function setEntryDate($entry_date)
	{
		$this->fieldsName[self::$entry_date] = "entry_date";
		$this->fieldsType[self::$entry_date] = Fields::$text;
		$this->fields[self::$entry_date] = $entry_date;
	}
	function getEntryDate()
	{
		return $fieldsvalue[self::$entry_date];
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
}
?>
