<?php

//include_once('app_code/order_number_mstr.php');
include_once('app_code/user_mstr.php');

function get_user_in_list()
{
	
	$obj = new UserMstr();
	$obj->openConnection();
	//$obj->setWhere("status = 'active'");
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$output = '';
	
	while($row=mysqli_fetch_array($run))
	{
		//$output .= '<option value="'.$row["id"].'">'$row["name"].'</option>';
		$id = $row['id'];
		$name = $row['name'];
		$output .= "<option value='$id'>$name</option>";
	}
	
	return $output;
}

/*
if(isset($_POST['get_order_no']))
{
	$gst_type = $_POST['order_type'];
	
	$obj = new OrderNumberMstr();
	$obj->openConnection();
	$obj->setWhere("order_type='sale' and gst_type='$gst_type' and status = 'active'");
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	if($row = mysqli_fetch_array($run))
	{
			$prefix  =$row['prefix'];
			$order_no = (int)$row['order_number']+1;
			$output['order_id'] = $prefix.'-'.$order_no;
	}
	else
		$output['order_id'] = "1";
	echo json_encode($output);
}
*/

?>