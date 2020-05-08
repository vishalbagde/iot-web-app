<?php
//category_fetch.php
include('app_code/product_mstr.php');
include('session.php');
$query = '';

$output = array();

	$obj = new ProductMstr();
	$obj->openConnection();
	$status = 'active';
	//$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$query = "select p.*,c.category_name from category_mstr c,product_mstr p
			where c.category_id=p.category_id and p.user_id = $user_id";
	
	
if(isset($_POST["search"]["value"]))
{
	$query .= ' and ( product_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR p.status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY product_id DESC ';
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
		$status = "<span class='label label-success'>Active</span>";
	}
	else
	{
		$status = "<span class='label label-danger'>Inactive</span>";
	}
	$sub_array = array();
	$sub_array[] = $row['product_id'];
	$sub_array[] = $row['category_name'];
	$sub_array[] = $row['product_name'];
	$sub_array[] = $row['product_qty'];
	$sub_array[] = $row['product_base_price'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["product_id"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["product_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["product_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
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
	$obj = new ProductMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>