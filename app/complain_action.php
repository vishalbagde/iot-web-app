<?php

//product_action.php
include_once('app_code/complain_mstr.php');
include('function.php');
include('session.php');




if(isset($_POST['btn_allocate_action']))
{
	if($_POST['btn_allocate_action'] == 'complain_allocate')
	{
		
		$emp_id= $_POST['emp_id'];
		$complain_id = $_POST['complain_allocate_id'];
		$obj = new ComplainMstr();
		$obj->openConnection();
		$obj->setAllocateTo($emp_id);
		$obj->setComplainRemark($_POST['complain_remark']);
		$obj->setComplainStatus('allocate');
		$obj->setWhere("complain_id = ".$complain_id);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Complaint Allocate successful";
		}	
	}
	
}
if(isset($_POST['btn_resolve_action']))
{
	if($_POST['btn_resolve_action'] == 'complain_resolve')
	{
		
		$complain_id = $_POST['complain_resolve_id'];
		$obj = new ComplainMstr();
		$obj->openConnection();
		$obj->setsolvedDate($_POST['resolve_date']);
		$obj->setAmountCharge($_POST['amount_charge']);
		$obj->setWorkInfo($_POST['work_info']);
		$obj->setResolveRemark($_POST['resolve_remark']);
		$obj->setComplainStatus('resolve');
		$obj->setWhere("complain_id = ".$complain_id);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Complaint Resolve successful";
		}	
	}
	
}
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_brand')
	{
		echo fill_brand_list($_POST['category_id']);
	}
	
	if($_POST['btn_action'] == 'load_amc')
	{
		echo fill_amc_list($_POST['amc_type']);
	}
	
	if($_POST['btn_action'] == 'Add')
	{	
		$obj = new ComplainMstr();
		$obj->openConnection();
		$obj->setCustomerId($_POST['customer_id']);
		$obj->setComplainDate($_POST['complain_date']);
		$obj->setComplainType($_POST['complain_type']);
		$obj->setComplainInfo($_POST['complain_info']);
		$obj->setReceivedBy($_POST['received_by']);
		$obj->setEntryStatus('active');
		$obj->setUserId($_SESSION['user_id']);
		echo $query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Complaint successful Added";
		}	
	}
	if($_POST['btn_action'] == 'contract_details')
	{
		$obj = new ProductMstr();
		$obj->openConnection();
		$query ="select c.*,cust.customer_name,a.amc_name,a.n_of_service,e.emp_name
				from contract_mstr c,amc_mstr a,customer_mstr cust,emp_mstr e
				where c.customer_id = cust.customer_id 
				AND a.amc_id=c.amc_id and 
				e.emp_id=c.sales_emp_id
				and
				c.user_id = $user_id   and c.contract_id =". $_POST['contract_id'];	
		$obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		if($row=mysqli_fetch_array($run))
		{
			$status = '';
			if($row['contract_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Deactive</span>';
			}
			
			$payment_type = '';
			if($row['payment_type'] == 'cash')
			{
				$payment_type = '<span class="label label-success">Cash</span>';
			}
			else
			{
				$payment_type = '<span class="label label-danger">Credit</span>';
			}
			
			$output .= '
			<tr>
				<td>Customer Name</td>
				<td>'.$row["customer_name"].'</td>
			</tr>
		
			<tr>
				<td>AMC Name</td>
				<td>'.$row["amc_name"].'</td>
			</tr>
			
			<tr>
				<td>sales Amt.</td>
				<td>'.$row["sales_amt"].'</td>
			</tr>
			
			<tr>
				<td>Contract From</td>
				<td>'.$row["contract_from"].'</td>
			</tr>
			<tr>
				<td>Contract To</td>
				<td>'.$row["contract_to"].'</td>
			</tr>
			
			<tr>
				<td>Machine Name</td>
				<td>'.$row["machine_name"].'</td>
			</tr>
			<tr>
				<td>Brand Name</td>
				<td>'.$row["brand_name"].'</td>
			</tr>
			<tr>
				<td>Model No</td>
				<td>'.$row["model_no"].'</td>
			</tr>
			<tr>
				<td>Serial No.</td>
				<td>'.$row["serial_no"].'</td>
			</tr>
			
			<tr>
				<td>Brand</td>
				<td>'.$row["brand_name"].'</td>
			</tr>
			<tr>
				<td>Sales Emp.</td>
				<td>'.$row["emp_name"].'</td>
			</tr>
			<tr>
				<td>Remark</td>
				<td>'.$row["remark"].'</td>
			</tr>
			
			
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
			</tr>
			<tr>
				<td>Payment Type</td>
				<td>'.$payment_type.'</td>
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
		$obj = new ComplainMstr();
		$obj->openConnection();
		$obj->setWhere("complain_id = ".$_POST["complain_id"]." ");
		$query =  $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		while($row=mysqli_fetch_array($run))
		{
			$output=$row;
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$obj = new ComplainMstr();
		$obj->openConnection();
		$obj->setCustomerId($_POST['customer_id']);
		$obj->setComplainDate($_POST['complain_date']);
		$obj->setComplainType($_POST['complain_type']);
		$obj->setComplainInfo($_POST['complain_info']);
		$obj->setReceivedBy($_POST['received_by']);
		$obj->setWhere("complain_id = ".$_POST['complain_id']);
		echo $query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Complaint successful Updated";
		}	
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';
		}
		$obj = new ComplainMstr();
		$obj->openConnection();
		$obj->setEntryStatus($status);
		$obj->setWhere('complain_id = '. $_POST["complain_id"]);
		$query =  $obj->preparedExecuteNoneQuery(Common::$update);
		$run = $obj->executeNoneQuery($query);
		if($run)
		{
			echo 'Complain status change to ' . $status;
		}
	}
}


?>