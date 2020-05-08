
<?php
	$con = mysqli_connect("localhost","root","","seminar");
	
	if(isset($_GET['op']))
	{
		if($_GET['op']=="insert")
		{
				$user_id =$_GET['user_id'];
				$tds = $_GET['tds'];
				$date = date("Y-m-d");
				$time = date("h:i:s");
				$insert = "insert into quality_mstr(user_id,tds,date,time) values($user_id,$tds,'".$date."','".$time."')";
				$check = mysqli_query($con,$insert);
				if($check)
				{
					
					$setting_fetch_status = getSettingFetchStatus($con,$user_id);
					if($setting_fetch_status != 0)
					{
						changeSettingStatus($con,$user_id);
					
					}
					echo $setting_fetch_status;
				}
				else
				{
					echo "-1";
				}
		}

		if($_GET['op']=="get_quality_data")
		{
				$user_id =$_GET['user_id'];
				
				$select = "select * from quality_mstr where user_id = $user_id";
				$run = mysqli_query($con,$select);
				
				$data["succ"]=true;
				$data["tds"]=array();
				while ($row=mysqli_fetch_assoc($run)) 
				{
					array_push($data["tds"],$row);
				}
				$data["mess"]="get it";
		
				// echo "<pre>";
				// print_r($data);
				echo json_encode($data);
				
		}	
		
		if($_GET['op']=="setting")
		{
			$user_id =$_GET['user_id'];
			$select = "select * from setting_mstr where user_id = $user_id";
			$run=mysqli_query($con,$select);
			$row=mysqli_fetch_array($run);
			if($row)
			{
				//changeSettingStatus($con,$user_id);
				echo $row['tds_fetch_interval'];
			}	
		}
		
		
		if($_GET['op']=="change_setting_status")
		{
			$user_id =$_GET['user_id'];
			$cur_status=  getSettingStatus($con,$user_id);
			$status=$cur_status==0?1:0;
			$select = "update setting_mstr set fetch_status = $status where user_id = $user_id";
			$run=mysqli_query($con,$select);
			echo $run;
		}
		
		if($_GET['op']=="get_setting_status")
		{
			$user_id =$_GET['user_id'];
			echo getSettingStatus($con,$user_id);
		}
		
		if($_GET['op']=="login")
		{
				$username =$_GET['username'];
				$password =$_GET['password'];
				
				$select = "select * from user_mstr where username = '$username' and password = '$password' and status = 'active'";
				$run = mysqli_query($con,$select);
				
				$data["succ"]=false;
				$data["value"]=0;
				$row=mysqli_fetch_array($run);
				if($row) 
				{
					$data['user_id']=$row['id'];
					$data["succ"]=true;
					$data["value"]=1;
					$data["name"]=$row['name'];
				}
					
				// echo "<pre>";
				// print_r($data);
				echo json_encode($data);
				
		}
		
	}
	
	function getSettingStatus($con,$user_id)
	{
		$user_id =$_GET['user_id'];
			$select = "select * from setting_mstr where user_id = $user_id";
			$run=mysqli_query($con,$select);
			$row=mysqli_fetch_array($run);
			if($row)
			{
				return $row['fetch_status'];
			}
	}
	
	function getSettingFetchStatus($con,$user_id)
	{
		$user_id =$_GET['user_id'];
			$select = "select * from setting_mstr where user_id = $user_id";
			$run=mysqli_query($con,$select);
			$row=mysqli_fetch_array($run);
			if($row)
			{
				return $row['fetch_status'];
			}
	}
	
	function changeSettingStatus($con,$user_id)
	{
			$cur_status=  getSettingStatus($con,$user_id);
			$status=$cur_status==0?1:0;
			$select = "update setting_mstr set fetch_status = $status where user_id = $user_id";
			$run=mysqli_query($con,$select);
			//echo $run;
	}
?>