<?php

//brand_action.php

include_once('app_code/user_mstr.php');
include_once('app_code/setting_mstr.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$obj = new UserMstr();
		$obj->openConnection();
		$obj->setName($_POST["name"]);
		$obj->setUserName($_POST["username"]);
		$obj->setPassword($_POST["password"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			$user_id=mysqli_insert_id($obj->getConnection());
			echo "User Added successful User Id is $user_id";
			$obj->closeConnection();
			
			$obj = new SettingMstr();
			$obj->openConnection();
			$obj->setUserId($user_id);
			$obj->setTdsFetchInterval(10);
			$obj->setAutoModeTds(500);
			$obj->setIsAutoMode("yes");
			$obj->setFilterType("RO");
			$obj->setPower("on");
			$obj->setFetchStatus(1);
			$query = $obj->preparedExecuteNoneQuery(Common::$insert);
			$check = $obj->executeNoneQuery($query);
			
			echo "User Added successful User Id is $user_id";
			
		}	
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$obj = new UserMstr();
		$obj->openConnection();
		$obj->setWhere("id =".$_POST["id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		while($row=mysqli_fetch_array($run))
		{
			$output['id'] = $row['id'];
			$output['name'] = $row['name'];
			$output['username'] = $row['username'];
			$output['password'] = $row['password'];
		}	
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$obj = new UserMstr();
		$obj->openConnection();
		$obj->setName($_POST["name"]);
		$obj->setUserName($_POST["username"]);
		$obj->setPassword($_POST["password"]);
		$obj->setWhere("id =".$_POST["id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'User Edited';
		}	
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';	
		}
		$obj = new UserMstr();
		$obj->openConnection();
		$obj->setStatus($status);
		$obj->setWhere("id =".$_POST["id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'User status change to ' . $status;
		}
	}
}

?>