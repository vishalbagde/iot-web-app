<?php

//product_action.php
include_once('app_code/contract_mstr.php');
include_once('app_code/service_mstr.php');
include('function.php');
include('session.php');


if(isset($_POST['btn_allocate_action']))
{
	if($_POST['btn_allocate_action'] == 'service_allocate')
	{
		
		$obj = new ServiceMstr();
		$obj->openConnection();
		$obj->setAllocateEmpId($_POST['emp_id']);
		$obj->setServiceRemark($_POST['complain_remark']);
		$obj->setServiceStatus('allocate');
		$obj->setAllocateDate(date('Y-m-d'));
		$obj->setWhere("service_id = ".$_POST['service_allocate_id']);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Service Allocate successful";
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
		$obj = new ContractMstr();
		$obj->openConnection();
		$obj->setCustomerId($_POST['customer_id']);
		$obj->setMachineName($_POST['machine_name']);
		$obj->setBrandName($_POST['brand_name']);
		$obj->setModelNo($_POST['brand_name']);
		$obj->setSerialNo($_POST['serial_no']);
		$obj->setContractDate($_POST['contract_date']);
		$obj->setContractType($_POST['amc_type']);
		$obj->setContractFrom($_POST['from_date']);
		$obj->setContractTo($_POST['to_date']);
		$obj->setSalesEmpId($_POST['sales_emp_id']);
		$obj->setSalesAmt($_POST['sales_amt']);
		$obj->setRemark($_POST['remark']);
		$obj->setAmcId($_POST['amc_id']);
		$obj->setPaymentType($_POST['payment_type']);
		$obj->setUserId($_SESSION["user_id"]);
		$obj->setContractStatus('active');
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			$contract_id=mysqli_insert_id($obj->getConnection());
			
			$total_service = get_amc_total_service($_POST['amc_id']);
			$from_date = date($_POST['from_date']);
			$to_date =  date($_POST['to_date']);
			$amc_year  = json_decode(get_amc_year($_POST['amc_id']));
			$amc_year = $amc_year->amc_service_year;
			
			$total_month = $amc_year*12;
			
			$month_diff = floor($total_month/$total_service);
			$start_month =0;
			for($i=0;$i<$total_service;$i++)
			{
					
				$d = new DateTime($from_date);
				$d->modify("+".$start_month."month");
				echo $d->format('Y-m-d').'<br>';
				
				$obj = new ServiceMstr();
				$obj->openConnection();
				$obj->setContractId($contract_id);
				$obj->setServiceDate($d->format('Y-m-d'));
				$obj->setServiceStatus('pending');
				$obj->setServiceTimeIn("10:00");
				$obj->setServiceTimeOut("01:00");
				$obj->setUserId($_SESSION["user_id"]);
				$query = $obj->preparedExecuteNoneQuery(Common::$insert);
				echo $check = $obj->executeNoneQuery($query);
				$obj->closeConnection();
				$start_month+=$month_diff;
				
				
				
				
				
			}
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
		$obj = new ServiceMstr();
		$obj->openConnection();
		$obj->setWhere("service_id = ".$_POST["service_id"]." ");
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
		
			$obj = new ServiceMstr();
			$obj->openConnection();
			$obj->setServiceDate($_POST['service_date']);
			$obj->setServiceTimeIn($_POST['service_time_in']);
			$obj->setServiceTimeOut($_POST['service_time_out']);
			$obj->setWorkDetails($_POST['work_details']);
			$obj->setServiceRemark($_POST['service_remark']);
			$obj->setEntryStatus($_POST['entry_status']);
			
			$obj->setWhere('service_id ='.$_POST["service_id"]);
			$query = $obj->preparedExecuteNoneQuery(Common::$update);
			$check = $obj->executeNoneQuery($query);		
			if($check)
			{
				echo 'service Details Edited';
			}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';
		}
		$obj = new ServiceMstr();
		$obj->openConnection();
		$obj->setEntryStatus($status);
		$obj->setWhere('service_id = '. $_POST["service_id"]);
		$query =  $obj->preparedExecuteNoneQuery(Common::$update);
		$run = $obj->executeNoneQuery($query);
		if($run)
		{
			echo 'Service status change to ' . $status;
		}
	}
}


?>