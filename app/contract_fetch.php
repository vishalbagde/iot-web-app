<?php
//category_fetch.php
include('app_code/contract_mstr.php');
include('session.php');
$query = '';

$output = array();

	$obj = new ContractMstr();
	$obj->openConnection();
	//$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$query = "select c.*,cust.customer_name,a.amc_name,a.n_of_service
			from contract_mstr c,amc_mstr a,customer_mstr cust
			where c.customer_id = cust.customer_id 
			AND a.amc_id=c.amc_id and c.user_id = $user_id";
	
	
if(isset($_POST["search"]["value"]))
{
	$query .= ' and ( cust.customer_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR c.contract_status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY c.contract_id DESC ';
}
if(isset($_POST['length']) && $_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
//echo $query;
$run = $obj->executeReader($query);
$filterTot = $obj->getTotalRows();
$data = array();
while($row = mysqli_fetch_array($run))
{
	$status = '';
	if($row['contract_status'] == 'active')
	{
		$status = "<span class='label label-success'>Active</span>";
	}
	else
	{
		$status = "<span class='label label-danger'>Inactive</span>";
	}
	$sub_array = array();
	$sub_array[] = $row['contract_id'];
	$sub_array[] = $row['contract_date'];
	$sub_array[] = $row['customer_name'];
	$sub_array[] = $row['amc_name'];
	$sub_array[] = $row['contract_from'];
	$sub_array[] = $row['contract_to'];
	$sub_array[] = $row['n_of_service'];
	$sub_array[] = $row['contract_status'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["contract_id"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["contract_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["contract_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["contract_status"].'">Delete</button>';
	$data[] = $sub_array;
}
$totalRow = get_total_all_records();
$output = array(
	"draw"				=>  intval($_POST["draw"]),
	"recordsTotal"  	=>  $totalRow,
	"recordsFiltered" 	=> 	$totalRow,
	"data"				=>	$data
);

function get_total_all_records()
{
	$obj = new ContractMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>