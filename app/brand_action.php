<?php

//brand_action.php

include_once('app_code/brand_mstr.php');
include('session.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		
		
		$obj = new BrandMstr();
		$obj->openConnection();
		$obj->setBrandName($_POST["brand_name"]);
		$obj->setCategoryId($_POST["category_id"]);
		$obj->setUserId($user_id);
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Brand Added';
		}
		
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		
		$obj = new BrandMstr();
		$obj->openConnection();
		$obj->setWhere("brand_id =".$_POST["brand_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		while($row=mysqli_fetch_array($run))
		{
			$output['category_id'] = $row['category_id'];
			$output['brand_name'] = $row['brand_name'];
		}
		
		
		echo json_encode($output);
		
	}
	if($_POST['btn_action'] == 'Edit')
	{
		
		$obj = new BrandMstr();
		$obj->openConnection();
		$obj->setBrandName($_POST["brand_name"]);
		$obj->setCategoryId($_POST["category_id"]);
		$obj->setWhere("brand_id =".$_POST["brand_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Brand Name Edited';
		}
		
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';	
		}
		$obj = new BrandMstr();
		$obj->openConnection();
		$obj->setStatus($status);
		$obj->setWhere("brand_id =".$_POST["brand_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Brand status change to ' . $status;
		}
	}
	
	
	
	
	
}

?>