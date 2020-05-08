<?php
//category_fetch.php
include('app_code/amc_mstr.php');
include_once('session.php');
$query = '';

$output = array();

	$obj = new AmcMstr();
	$obj->openConnection();
	$obj->setWhere("user_id = $user_id");
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	
	
if(isset($_POST["search"]["value"]))
{
	$query .= ' and ( amc_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR amc_status LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR amc_type LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY amc_id DESC ';
}
if($_POST['length'] != -1)
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
	if($row['amc_status'] == 'active')
	{
		$status = "<span class='label label-success'>Active</span>";
	}
	else
	{
		$status = "<span class='label label-danger'>Inactive</span>";
	}
	$sub_array = array();
	$sub_array[] = $row['amc_id'];
	$sub_array[] = $row['amc_name'];
	$sub_array[] = $row['amc_type'];
	$sub_array[] = $row['amc_service_year'];
	$sub_array[] = $row['n_of_service'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["amc_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["amc_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["amc_status"].'">Delete</button>';
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
	$obj = new AmcMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>