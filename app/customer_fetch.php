<?php
//category_fetch.php
include('app_code/customer_mstr.php');
include_once('session.php');
$query = '';

$output = array();

	$obj = new CustomerMstr();
	$obj->openConnection();
	$obj->setWhere("user_id = $user_id");
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	
	
if(isset($_POST["search"]["value"]))
{
	$query .= ' and ( customer_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY customer_id DESC ';
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
	if($row['status'] == 'active')
	{
		$status = '<button type="button" name="status" id="'.$row["customer_id"].'" class="btn btn-success btn-xs status" data-status="'.$row["status"].'">active</button>';
	}
	else
	{
		$status = '<button type="button" name="status" id="'.$row["customer_id"].'" class="btn btn-warning btn-xs status" data-status="'.$row["status"].'">deactive</button>';
	}
	$sub_array = array();
	$sub_array[] = $row['customer_id'];
	$sub_array[] = $row['customer_name'];
	$sub_array[] = $row['phone_no1'];
	$sub_array[] = $row['area_name'];
	$sub_array[] = $row['customer_type'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["customer_id"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["customer_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["customer_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
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
	$obj = new CustomerMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>