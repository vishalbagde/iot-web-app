<?php
include('app_code/category_mstr.php');
include('session.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		
		$obj = new CategoryMstr();
		$obj->openConnection();
		$obj->setCategoryName($_POST["category_name"]);
		$obj->setUserId($user_id);
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Category Name Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		
		$obj = new CategoryMstr();
		$obj->openConnection();
		$obj->setWhere("category_id =".$_POST["category_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		while($row=mysqli_fetch_array($run))
		{
			$output['category_name'] = $row['category_name'];
		}
		
		echo json_encode($output);
				

	}

	if($_POST['btn_action'] == 'Edit')
	{
		
		$obj = new CategoryMstr();
		$obj->openConnection();
		$obj->setCategoryName($_POST["category_name"]);
		$obj->setWhere("category_id =".$_POST["category_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		
		if(isset($check))
		{
			echo 'Category Name Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';	
		}
		$obj = new CategoryMstr();
		$obj->openConnection();
		$obj->setStatus($status);
		$obj->setWhere("category_id =".$_POST["category_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Category status change to ' . $status;
		}
	}
}

?>