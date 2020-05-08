<?php
include_once("tablemaster.php"); 
class SettingMstr extends TableMaster 
{
	private static $id = 0;
	private static $user_id = 1;
	private static $tds_fetch_interval = 2;
	private static $auto_mode_tds = 3;
	private static $is_auto_mode = 4;
	private static $filter_type = 5;
	private static $power = 6;
	private static $fetch_status = 7;
	private static $entry_date_time = 8;
	private static $entry_status = 9;
	function __construct() 
	{
		$strtblName = array("setting_mstr");
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
	function setTdsFetchInterval($tds_fetch_interval)
	{
		$this->fieldsName[self::$tds_fetch_interval] = "tds_fetch_interval";
		$this->fieldsType[self::$tds_fetch_interval] = Fields::$text;
		$this->fields[self::$tds_fetch_interval] = $tds_fetch_interval;
	}
	function getTdsFetchInterval()
	{
		return $fieldsvalue[self::$tds_fetch_interval];
	}
	function setAutoModeTds($auto_mode_tds)
	{
		$this->fieldsName[self::$auto_mode_tds] = "auto_mode_tds";
		$this->fieldsType[self::$auto_mode_tds] = Fields::$text;
		$this->fields[self::$auto_mode_tds] = $auto_mode_tds;
	}
	function getAutoModeTds()
	{
		return $fieldsvalue[self::$auto_mode_tds];
	}
	function setIsAutoMode($is_auto_mode)
	{
		$this->fieldsName[self::$is_auto_mode] = "is_auto_mode";
		$this->fieldsType[self::$is_auto_mode] = Fields::$text;
		$this->fields[self::$is_auto_mode] = $is_auto_mode;
	}
	function getIsAutoMode()
	{
		return $fieldsvalue[self::$is_auto_mode];
	}
	function setFilterType($filter_type)
	{
		$this->fieldsName[self::$filter_type] = "filter_type";
		$this->fieldsType[self::$filter_type] = Fields::$text;
		$this->fields[self::$filter_type] = $filter_type;
	}
	function getFilterType()
	{
		return $fieldsvalue[self::$filter_type];
	}
	function setPower($power)
	{
		$this->fieldsName[self::$power] = "power";
		$this->fieldsType[self::$power] = Fields::$text;
		$this->fields[self::$power] = $power;
	}
	function getPower()
	{
		return $fieldsvalue[self::$power];
	}
	function setFetchStatus($fetch_status)
	{
		$this->fieldsName[self::$fetch_status] = "fetch_status";
		$this->fieldsType[self::$fetch_status] = Fields::$text;
		$this->fields[self::$fetch_status] = $fetch_status;
	}
	function getFetchStatus()
	{
		return $fieldsvalue[self::$fetch_status];
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
	function setEntryStatus($entry_status)
	{
		$this->fieldsName[self::$entry_status] = "entry_status";
		$this->fieldsType[self::$entry_status] = Fields::$text;
		$this->fields[self::$entry_status] = $entry_status;
	}
	function getEntryStatus()
	{
		return $fieldsvalue[self::$entry_status];
	}
}
?>
