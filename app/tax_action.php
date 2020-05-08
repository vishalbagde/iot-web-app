<?php
include('app_code/tax_mstr.php');
include('session.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		
		$obj = new TaxMstr();
		$obj->openConnection();
		$obj->setTaxName($_POST["data_name"]);
		$obj->setTaxRate($_POST["data_rate"]);
		$obj->setUserId($user_id);
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Tax Name Added';
		}
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		
		$obj = new TaxMstr();
		$obj->openConnection();
		$obj->setWhere("tax_id =".$_POST["tax_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		while($row=mysqli_fetch_array($run))
		{
			$output['tax_name'] = $row['tax_name'];
			$output['tax_rate'] = $row['tax_rate'];
		}
		
		echo json_encode($output);
				

	}

	if($_POST['btn_action'] == 'Edit')
	{
		
		$obj = new TaxMstr();
		$obj->openConnection();
		$obj->setTaxName($_POST["data_name"]);
		$obj->setTaxRate($_POST["data_rate"]);
		$obj->setWhere("tax_id =".$_POST["data_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		
		if(isset($check))
		{
			echo 'Tax Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';	
		}
		$obj = new TaxMstr();
		$obj->openConnection();
		$obj->setStatus($status);
		$obj->setWhere("tax_id =".$_POST["tax_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			echo 'Tax status change to ' . $status;
		}
	}
}

?>