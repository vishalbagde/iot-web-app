<?php

$db="seminar";
$con = mysqli_connect("localhost","root","","");
 $select= "select distinct table_name from information_schema.columns where table_schema = '$db' order by table_name,ordinal_position";
  $run = mysqli_query($con,$select);
  echo "<pre>";
  $table=array();
  $tcnt=0;
  while($row=mysqli_fetch_array($run))
  {
	  $table[$tcnt++]=$row['table_name'];
  }
  $column[][]=array();
  $tcnt=0;
  foreach($table as $t)
  {
	//$column[$tcnt]=array();
	$ccnt=0;
	$select= "select table_name,column_name,data_type from information_schema.columns where table_schema = '$db' and table_name = '$t' order by table_name,ordinal_position";
	 $run = mysqli_query($con,$select);
	 echo "<pre>";
	 
	 while($row=mysqli_fetch_array($run))
	 {
		  $column[$tcnt][$ccnt++]=$row['column_name'];
	 }
	 $tcnt++; 
 
  }
 
  print_r($column);
  
	for($i=0;$i<count($column);$i++)
	{
		echo $table[$i];
		echo "<br>";
		for($j=0;$j<count($column[$i]);$j++)
		{
			echo $column[$i][$j]."<br>";
		}
		echo "<br>";

	}
	
	
	for($i=0;$i<count($table);$i++)
	{
	
	$tname = $table[$i];
	$classname="";
	
	for($j=0;$j<strlen($tname);$j++)
	{
		if($tname[$j]=='_')
		{
			$j++;
			$classname.=strtoupper($tname[$j]);
		}
		else
		{
			if($j==0)
			{
				$classname.=strtoupper($tname[$j]);
			}
			else
			{
				$classname.=$tname[$j];
			}
					
		}
	
	}
	//echo "<?php \n";
	$fp=fopen($table[$i].'.php','w');
		
	fwrite($fp,"<?php\n");
	fwrite($fp,"include_once(\"tablemaster.php\"); \n");
	fwrite($fp, "class ". $classname." extends TableMaster \n");
	fwrite($fp,"{\n");
	$vcnt=0;
	for($j=0;$j<count($column[$i]);$j++)
	{
			fwrite($fp, "\tprivate static $".$column[$i][$j]." = $vcnt;\n");
			$vcnt++;
	}
	fwrite($fp,"\tfunction __construct() \n");
	fwrite($fp,"\t{\n");
	fwrite($fp,"\t\t\$strtblName = array(\"".$table[$i]."\");\n");
	fwrite($fp,"\t\t\$this->setTblName(\$strtblName);\n");
	fwrite($fp, "\t\t\$this->fields = array();\n");
	fwrite($fp, "\t\t\$this->fieldsName = array();\n");
	fwrite($fp, "\t\t\$this->fieldsType = array();\n");
	fwrite($fp, "\t}\n");
	for($j=0;$j<count($column[$i]);$j++)
	{
	$fcname=$column[$i][$j];
	$cname="";
	for($c=0;$c<strlen($fcname);$c++)
	{
		if($fcname[$c]=='_')
		{
			$c++;
			$cname.=strtoupper($fcname[$c]);
		}
		else
		{
			if($c==0)
			{
				$cname.=strtoupper($fcname[$c]);
			}
			else
			{
				$cname.=$fcname[$c];
			}
					
		}
	
	}
	fwrite($fp,"\tfunction set$cname($".$column[$i][$j].")\n");
	fwrite($fp,"\t{\n");
	fwrite($fp,"\t\t\$this->fieldsName[self::$".$column[$i][$j]."] = \"".$column[$i][$j]."\";\n");
	fwrite($fp,"\t\t\$this->fieldsType[self::$".$column[$i][$j]."] = Fields::\$text;\n");
	fwrite($fp, "\t\t\$this->fields[self::$".$column[$i][$j]."] = \$".$column[$i][$j].";\n");
	fwrite($fp,"\t}\n");
	fwrite($fp,"\tfunction get".$cname."()\n");
	fwrite($fp,"\t{\n");
	fwrite($fp,"\t\treturn \$fieldsvalue[self::$".$column[$i][$j]."];\n");
	fwrite($fp, "\t}\n");
	
	}
	fwrite($fp,"}\n");
	fwrite($fp,"?>\n");
	fclose($fp);
	}
	
	

?> 