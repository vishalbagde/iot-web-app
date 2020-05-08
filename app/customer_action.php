<?php

//product_action.php
include_once('app_code/customer_mstr.php');
include('function.php');
include('session.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_brand')
	{
		echo fill_brand_list($_POST['category_id']);
	}
	if($_POST['btn_action'] == 'Add')
	{	
		$obj = new CustomerMstr();
		$obj->openConnection();
		$obj->setCustomerType($_POST['customer_type']);
		$obj->setCustomerName($_POST['customer_name']);
		$obj->setAddress($_POST['address']);
		$obj->setAreaName($_POST['area_name']);
		$obj->setCity($_POST['city']);
		$obj->setState($_POST['state']);
		$obj->setPincode($_POST['pincode']);
		$obj->setPhoneNo1($_POST['phone_no1']);
		$obj->setPhoneNo2($_POST['phone_no2']);
		$obj->setGstNo($_POST['gst_no']);
		$obj->setPanNo($_POST['pan_no']);
		$obj->setStatus('active');
		$obj->setUserId($user_id);
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Product Insert success";
		}
	}
	if($_POST['btn_action'] == 'customer_details')
	{
		$obj = new CustomerMstr();
		$obj->openConnection();
		$query = "select * from customer_mstr where customer_id =". $_POST['customer_id'];	
		$obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		while($row=mysqli_fetch_array($run))
		{
			$status = '';
			if($row['status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Deactive</span>';
			}
			$output .= '
			<tr>
				<td>Customer Type</td>
				<td>'.$row["customer_type"].'</td>
			</tr>
			
			<tr>
				<td>Customer Name</td>
				<td>'.$row["customer_name"].'</td>
			</tr>
			
			<tr>
				<td>Address</td>
				<td>'.$row["address"].'</td>
			</tr>
			
			<tr>
				<td>Area Name</td>
				<td>'.$row["area_name"].'</td>
			</tr>
			
			<tr>
				<td>City Name</td>
				<td>'.$row["city"].'</td>
			</tr>
			
			<tr>
				<td>Pincode</td>
				<td>'.$row["pincode"].'</td>
			</tr>
			
			<tr>
				<td>Phone No1</td>
				<td>'.$row["phone_no1"].'</td>
			</tr>
			<tr>
				<td>Phone No2</td>
				<td>'.$row["phone_no2"].'</td>
			</tr>
			
			<tr>
				<td>Gst No.</td>
				<td>'.$row["gst_no"].'</td>
			</tr>
			
			<tr>
				<td>Pan No.</td>
				<td>'.$row["pan_no"].'</td>
			</tr>
		
		
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
			</tr>
			';
		}
		$output .= '
			</table>
		</div>
		';
		echo $output;
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$obj = new CustomerMstr();
		$obj->openConnection();
		$obj->setWhere("customer_id = ".$_POST["customer_id"]." and status = 'active'");
		//$obj->setProduId($_POST["customer_id"]);
		$query =  $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		
		
		while($row=mysqli_fetch_array($run))
		{
			$output['customer_id']=$row['customer_id'];
			$output['customer_type']=$row['customer_type'];
			$output['customer_name']=$row['customer_name'];
			$output['address']=$row['address'];
			$output['area_name']=$row['area_name'];
			$output['city']=$row['city'];
			$output['state']=$row['state'];
			$output['pincode']=$row['pincode'];
			$output['phone_no1']=$row['phone_no1'];
			$output['gst_no']=$row['gst_no'];
			$output['pan_no']=$row['pan_no'];
			$output['active']=$row['status'];
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		
		$obj = new CustomerMstr();
		$obj->openConnection();
		$obj->setCustomerType($_POST['customer_type']);
		$obj->setCustomerName($_POST['customer_name']);
		$obj->setAddress($_POST['address']);
		$obj->setAreaName($_POST['area_name']);
		$obj->setCity($_POST['city']);
		$obj->setState($_POST['state']);
		$obj->setPincode($_POST['pincode']);
		$obj->setPhoneNo1($_POST['phone_no1']);
		$obj->setPhoneNo2($_POST['phone_no2']);
		$obj->setGstNo($_POST['gst_no']);
		$obj->setPanNo($_POST['pan_no']);
		$obj->setStatus('active');
		$obj->setUserId($user_id);
		$obj->setWhere('customer_id ='.$_POST["customer_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Customer success Updated";
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';
		}
		$obj = new CustomerMstr();
		$obj->openConnection();
		$obj->setStatus($status);
		$obj->setWhere('customer_id = '. $_POST["customer_id"]);
		$query =  $obj->preparedExecuteNoneQuery(Common::$update);
		$run = $obj->executeNoneQuery($query);
		if($run)
		{
			echo 'Customer status change to ' . $status;
		}
	}
	
	if($_POST['btn_action'] == 'status_change')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';
		}
		$obj = new CustomerMstr();
		$obj->openConnection();
		$obj->setStatus($status);
		$obj->setWhere('customer_id = '. $_POST["customer_id"]);
		$query =  $obj->preparedExecuteNoneQuery(Common::$update);
		$run = $obj->executeNoneQuery($query);
		if($run)
		{
			echo 'Customer status change to ' . $status;
		}
	}
}


?>