<?php
//category_fetch.php
include('app_code/category_mstr.php');
include_once('session.php');

$query = '';

$output = array();

	$obj = new CategoryMstr();
	$obj->openConnection();
	$obj->setWhere('user_id = '.$user_id);
	$query = $obj->preparedExecuteNoneQuery(Common::$select);

if(isset($_POST["search"]["value"]))
{
	$query .= ' and (category_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY category_id DESC ';
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
	if($row['status'] == 'active')
	{
		$status = "<span class='label label-success'>Active</span>";
	}
	else
	{
		$status = "<span class='label label-danger'>Inactive</span>";
	}
	$sub_array = array();
	$sub_array[] = $row['category_id'];
	$sub_array[] = $row['category_name'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["category_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["category_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
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
	$obj = new CategoryMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>