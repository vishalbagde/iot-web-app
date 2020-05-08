<?php
include('app_code/setting_mstr.php');

$query = '';

$output = array();

	$obj = new SettingMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);

if(isset($_POST["search"]["value"]))
{
	$query .= ' where (user_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR entry_status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY id DESC ';
}
if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

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
	$sub_array = array();
	$sub_array[] = $row['id'];
	$sub_array[] = $row['user_id'];
	$sub_array[] = $row['tds_fetch_interval'];
	$sub_array[] = $row['auto_mode_tds'];
	$sub_array[] = $row['is_auto_mode'];
	$sub_array[] = $row['filter_type'];
	$sub_array[] = $row['power'];
	$sub_array[] = $row['fetch_status'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["entry_status"].'">Delete</button>';
	$data[] = $sub_array;

}
$output = array(
	"draw"				=>  intval($_POST["draw"]),
	"recordsTotal"  	=>  get_total_all_records(),
	"recordsFiltered" 	=> 	get_total_all_records(),
	"data"				=>	$data
);

function get_total_all_records()
{
	$obj = new SettingMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>