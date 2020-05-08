<?php
//include_once("../connection.php");
 

class Connection
{
    private $cn;    
	private $sth;
	private $totalRows;

	public static $insert = 0;
	public static $update = 1;
	public static $delete = 2;
	public static $select = 3;
	
	private static $hostname = "localhost";
	private static $username = "root";
	private static $password = "";
	private static $select_db = "seminar";
	
	/*
	private static $hostname = "mysql.hostinger.in";
	private static $username = "u429567839_root";
	private static $password = "Rohit@1992";
	private static $select_db = "u429567839_root";
	
	*/

	public function openConnection() 
	{
		$this->cn = mysqli_connect(self::$hostname, self::$username, self::$password,self::$select_db) or die("Connection is not Done");
		//mysql_select_db(self::$select_db, $this->cn) or die("Database is not Selected");
		return $this->cn;
    }
	
	public function getConnection() 
	{
		return $this->cn;
    }
    public function closeConnection()
    {
        mysqli_close($this->cn);
    }
    public function executeNoneQuery($query)
    {
		$result = mysqli_query($this->cn,$query) or die(mysqli_error());
		return $result;
		
    }
    public function executeReader($query)
    {
		$this->sth= mysqli_query($this->cn,$query) or die(mysqli_error());
		$this->totalRows = mysqli_num_rows($this->sth);
		return $this->sth;
		
    }
    public function executeScalar($query)
    {
		$result=mysqli_query($this->cn,$query) or mysqli_error();
		
		return $result;
    }
	public function getTotalRows()
	{
		return $this->totalRows;
	}
	
}

class Fields
{
    public static $number = 0;
	public static $date = 1;
	public static $text = 2;
}



class TableMaster extends Connection
{
    protected  $tblName;
    protected  $fields;
    protected  $fieldsName;
    protected  $fieldsType;
    protected  $Where;
    protected  $Limit;
	
	
    public function preparedExecuteNoneQuery($intDMLStatement)
    {
		$query = "";
		if($intDMLStatement == Common::$insert)
		{
			$query = "";
			$query = "insert into ";
			for ($i = 0; $i < count($this->tblName); $i++)
			{
				$query .= $this->tblName[$i];
				if ($i != count($this->tblName) - 1)
					$query .= ", ";
			}
	
			$query .= " ( ";
			foreach($this->fieldsName as $i=>$value)
			{
				$flag = 0;
				$query .= $this->fieldsName[$i];
				/*for ($j = $i + 1; $j < count($this->fieldsName); $j++)
				{
					if ($this->fieldsName[$j] == NULL)
					{
						$flag = 0;
					}
					else
					{
						$flag = 1;
						break;
					}
				}
				if ($flag == 1)*/
					$query .= ", ";
			}
			$query = substr($query,0,strrpos($query,","));         
			$query .= " )";
			$query .= " VALUES(";

			foreach($this->fields as $i=>$value)
            {
				$flag = 0;
				if ($this->fieldsType[$i] == Fields::$number)
					$query .= $this->fields[$i];
				else if ($this->fieldsType[$i] == Fields::$date || $this->fieldsType[$i] == Fields::$text)
					$query .= "'" . $this->fields[$i] . "'";
				/*for ($j = $i + 1; $j < count($this->fieldsName); $j++)
				{
					if ($this->fieldsName[$j] == NULL)
					{
						$flag = 0;
					}
					else
					{
						$flag = 1;
						break;
					}
				}
				if ($flag == 1)*/
					$query .= ", ";
			}
			$query = substr($query,0,strrpos($query,","));         
			$query .= " );";
		}
		else if($intDMLStatement == Common::$update)
		{
	        $query = "update ";
            for ($i = 0; $i < count($this->tblName); $i++)
			{
				$query .= $this->tblName[$i];
				if ($i != count($this->tblName) - 1)
					$query .= ", ";
			}
			
            $query .= " set ";

			foreach($this->fields as $key=>$value)
            {
                $flag = 0;
                $query .= $this->fieldsName[$key] . " = ";
	            if ($this->fieldsType[$key] == Fields::$number)
				{
                        $query .= $this->fields[$key];
				}
				else
				{
					$query .= "'" . $this->fields[$key] . "'";
				}
                $query .= ", ";
			}
			$query = substr($query,0,strrpos($query,","));         
            if($this->Where != NULL)
            {
                $query .= " where " . $this->Where;
            }
		}

		else if($intDMLStatement == Common::$delete)
		{
	        $query = "delete from ";
            for ($i = 0; $i < count($this->tblName); $i++)
            {
                $query .= $this->tblName[$i];
                if ($i != count($this->tblName) - 1)
                    $query .= ", ";
            }
            if($this->Where[0] != NULL || $this->Where[0] != "")
            {
                $query .= " where " . $this->Where;
            }
		}
		else if($intDMLStatement == Common::$select)
		{
			$query = "select * from ";
            for ($i = 0; $i < count($this->tblName); $i++)
            {
                $query .= $this->tblName[$i];
                if ($i != count($this->tblName) - 1)
                    $query .= ", ";
            }
			if($this->Where != NULL)
            {
                if($this->Where[0] != NULL || $this->Where[0] != "")
				{
                $query .= " where " . $this->Where;
				}
			}
			
			if( $this->Limit != NULL )
			{
				$query .= " LIMIT " . $this->Limit;
			}
            
			    
		}

       	return $query;
    }
    public function setTblName($strTblName)
    {
        $this->tblName = $strTblName;
    }
    public function setWhere($strWhere)
    {
        $this->Where = $strWhere;
		//echo $this->Where;
    }
	public function setLimit($intSkip,$intRows)
    {
        $this->Limit = $intSkip . ',' .$intRows;
		//echo $this->Where;
    }
    public function setFieldsName($strFieldsName)
    {
        $this->fieldsName = $strFieldsName;
    }
}
?>

<?php
//session_start();
class Common
{
    public static $insert = 0;
	public static $update = 1;
	public static $delete = 2;
	public static $select = 3;	
	public static $pageSize = 2;
	
	
	
	public static function pagination($intTotalRows,$intPerPage)
	{
		if($intTotalRows == "")
		{
			exit();
		}
		else if($intTotalRows <= $intPerPage)
		{
			exit();
		}
		else
		{
				echo $row = $intTotalRows;
			$perPage = $intPerPage;
			$totalpage = $row / $perPage;
			echo $totalpage  = ceil($totalpage);
			
			echo " <center><nav>	<ul class='pagination'>
			 <li> 
			<a href='#' class='prev' area-label='Prev'>
			<span area-hidden='true'>&laquo</span>
			</a>
			</li> ";
	 
			for($i=1;$i <= $totalpage ;$i++)
			{
				echo "<li><a class = 'pagi' id = '$i' href='' >$i</a></li>";
			}

			echo "<li> 
			<a href='#' class='next' area-label='Next'>
			<span area-hidden='true'>&raquo</span>
			</a> </li>";
			echo "</ul>";
			echo "</nav></center>";
		}
		
		
	}
	public static function getIp()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
		{
				$ip = $_SERVER['HTTP_CLIENT_IP'];
							
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		
		return $ip;
	
	}
	
    public static function GenerateSlug($phrase)
    {
        $str = strtolower($phrase);
		$str = preg_replace("/[^a-z0-9\s-]/", "" ,$str);
		$str = trim(preg_replace("/\s+/", " ", $str));
		$str = trim(substr($str, 0, strlen($str)<=45? strlen($str):45));
		$str = preg_replace("/\s/", " " ,$str);

        return $str;
	}
	    public static function display_PageSize()
    {
		$strHTML = "";	
		if(isset($_SESSION['PageSize']))
		{
			$strHTML = "<tr align='right'>" .
				   		"<td colspan='7' align='right'>Page Size: <input type='text' size='1' align='right' id='txtPageSize' value='" . $_SESSION['PageSize'] ."' width='50px' /></td>".
				   		"</tr>";
		}
		return $strHTML;
	}
    public static function PageSize_Change_Handle($fileName)
    {
		$strHTML = 	"<script type='text/javascript'>".
						"$(document).ready(function() {".
						"$('#txtPageSize').change(function() ".
						"{".
							"var txtPageSizeval = $('#txtPageSize').val();" .
							"$.post('" . $fileName ."', { funcname : 'list_load', currentpage : 1, pagesize : txtPageSizeval}, function(data)".	
							"{" .		
								"$('#displayList').html(data);" .								   
							"});".
						"});".
					"});" .
				"</script>";
				
		return $strHTML;
	}
	
	
	public static function FillPagesCombo($totPage, $CurrentPage)
    {
		$strHTML = "<select id='cmbPages'>";

		for($i=1; $i <= $totPage; $i++)
		{
			if($i == $CurrentPage)
				$strHTML .= "<option value='" . $i . "' selected='selected'>". $i ."</option>";
			else
				$strHTML .= "<option value='" . $i . "'>". $i ."</option>";			
		}	
		$strHTML .=	"</select>";

        return $strHTML;
	}
	public static function cmbPages_Change_Handle($fileName)
    {
		$strHTML = 	"<script type='text/javascript'>".
						"$(document).ready(function() {".
						"$('#cmbPages').change(function() ".
						"{".
							"var currentpageval = $('#cmbPages').val();" .
							"$.post('" . $fileName ."', { funcname : 'list_load', currentpage : currentpageval}, function(data)".	
							"{" .		
								"$('#displayList').html(data);" .								   
							"});".
						"});".
					"});" .
				"</script>";
				
		return $strHTML;
	}
	
	public static function create_session($key,$value)
	{
		$_SESSION[$key]=$value;
	}
	
	public static function distroy_sessions()
	{
		session_destroy();
	}

}
?>			