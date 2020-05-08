<?php
//category_fetch.php
include('app_code/sales_mstr.php');
include('session.php');

$query = '';

$output = array();

	$obj = new SalesMstr();
	$obj->openConnection();
	//$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$query = "select s.*,c.customer_name from customer_mstr c,sales_mstr s
			where c.customer_id=s.customer_id and s.user_id = $user_id ";
			
if(isset($_POST["search"]["value"]))
{
	$query .= ' and (c.customer_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR s.status LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR s.order_no LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY sales_id DESC ';
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
	
	$payment_status = '';
	if($row['payment_type'] == 'cash')
	{
		$payment_status = '<span class="label label-primary">Cash</span>';
	}
	else
	{
		$payment_status = '<span class="label label-warning">Credit</span>';
	}
	
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
	$sub_array[] = $row['order_date'];
	$sub_array[] = $row['order_no'];
	$sub_array[] = $row['customer_name'];
	$sub_array[] = $payment_status;
	$sub_array[] = $status;
	$sub_array[] = $row['net_amount'];
	$sub_array[] = $row['total_tax'];
	$sub_array[] = $row['total_amount'];
	$sub_array[] = '<a href="view_order.php?pdf=1&sales_id='.$row["sales_id"].'" class="btn btn-info btn-xs">View PDF</a>';
	$sub_array[] = '<a href="view_order.php?pdf=2&sales_id='.$row["sales_id"].'" class="btn btn-info btn-xs">View</a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["sales_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["sales_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
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
	$obj = new SalesMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>