<?php
//category_fetch.php
include('app_code/service_mstr.php');
include('session.php');
$query = '';

$output = array();

	$obj = new ServiceMstr();
	$obj->openConnection();
	//$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$query = "select s.*,c.*,cust.* from service_mstr s,contract_mstr c,customer_mstr cust where
			s.contract_id=c.contract_id AND
			cust.customer_id=c.customer_id
			AND
			s.contract_id = ".$_POST['contract_id']."
			AND	
			s.user_id=$user_id";
	
	
if(isset($_POST["search"]["value"]))
{
	$query .= ' and ( c.machine_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR c.contract_status LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR s.service_date LIKE "%'.$_POST["search"]["value"].'%" )';
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
	if($row['entry_status'] == 'active')
	{
		$status = "<span class='label label-success'>Active</span>";
	}
	else
	{
		$status = "<span class='label label-danger'>Inactive</span>";
	}
	
	
	$status_a = '';
	$resolve_status = "";
	$allocate_status = "";
	if($row['service_status'] == 'pending')
	{
		$allocate_status = "";
		$resolve_status = "disabled";
		$status_a = "<span class='label label-primary'>Pending</span>";
	}
	else if($row['service_status'] == 'allocate')
	{
		$allocate_status = "disabled";
		$resolve_status = "";
		$status_a = "<span class='label label-warning'>Allocate</span>";
	}
	else
	{
		$allocate_status = "disabled";
		$resolve_status = "";
		$status_a = "<span class='label label-success'>Resolve</span>";
	}
	
	$sub_array = array();
	$sub_array[] = $row['service_id'];
	$sub_array[] = $row['machine_name'];
	$sub_array[] = $row['service_date'];
	$sub_array[] = $status_a;
	$sub_array[] = $status;
	
	$sub_array[] = '<button type="button" name="allocate" id="'.$row["service_id"].'" class="btn btn-success btn-xs resolve '.$resolve_status.'">Resolve</button>';
	
	$sub_array[] = '<button type="button" name="allocate" id="'.$row["service_id"].'" class="btn btn-primary btn-xs allocate '.$allocate_status.'">Allocate</button>';
	$sub_array[] = '<button type="button" name="view" id="'.$row["service_id"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["service_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["service_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["entry_status"].'">Delete</button>';
	$data[] = $sub_array;
}
$totalRow = get_total_all_records();
$output = array(
	"draw"				=>  intval($_POST["draw"]),
	"recordsTotal"  	=>  $obj->getTotalRows(),
	"recordsFiltered" 	=> 	$totalRow, //$obj->getTotalRows(),
	"data"				=>	$data
);

function get_total_all_records()
{
	$obj = new ServiceMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>