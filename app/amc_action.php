<?php

//brand_action.php

include_once('app_code/amc_mstr.php');
include('session.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{	
		$obj = new AmcMstr();
		$obj->openConnection();
		$obj->setAmcType($_POST["amc_type"]);
		$obj->setAmcName($_POST["amc_name"]);
		$obj->setAmcPrice($_POST["amc_price"]);
		$obj->setAmcRemark($_POST["amc_remark"]);
		$obj->setNOfService($_POST["n_of_service"]);
		$obj->setAmcServiceYear($_POST["amc_service_year"]);
		$obj->setUserId($user_id);
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Amc Added';
		}
		
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		
		$obj = new amcMstr();
		$obj->openConnection();
		$obj->setWhere("amc_id =".$_POST["amc_id"]." and user_id = $user_id");
		$query = $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		$output='';
		if($row=mysqli_fetch_array($run))
		{
			$output=$row;
		}
		
		echo json_encode($output);
		
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$obj = new AmcMstr();
		$obj->openConnection();
		$obj->setWhere('amc_id ='.$_POST["amc_id"]);
		$obj->setAmcType($_POST["amc_type"]);
		$obj->setAmcName($_POST["amc_name"]);
		$obj->setAmcPrice($_POST["amc_price"]);
		$obj->setAmcRemark($_POST["amc_remark"]);
		$obj->setNOfService($_POST["n_of_service"]);
		$obj->setAmcServiceYear($_POST["amc_service_year"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Amc Updated';
		}	
	}
	
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['amc_status'] == 'active')
		{
			$status = 'deactive';	
		}
		$obj = new AmcMstr();
		$obj->openConnection();
		$obj->setAmcStatus($status);
		$obj->setWhere("amc_id =".$_POST["amc_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Amc status change to ' . $status;
		}
	}
}

?>