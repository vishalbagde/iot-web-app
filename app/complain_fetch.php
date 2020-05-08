<?php
//category_fetch.php
include('app_code/complain_mstr.php');
include('session.php');
$query = '';

$output = array();

	$obj = new ComplainMstr();
	$obj->openConnection();
	//$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$query = "select c.*,cust.customer_name,cust.area_name,cust.phone_no1
			from customer_mstr cust,complain_mstr c
			where c.customer_id=cust.customer_id
			and c.user_id = $user_id";
	
	
if(isset($_POST["search"]["value"]))
{
	$query .= ' and ( cust.customer_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR c.complain_status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	
	$query .= ' ORDER BY '.((int)$_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY c.complain_id DESC ';
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
	if($row['complain_status'] == 'pending')
	{
		$status = "<span class='label label-primary'>Pending</span>";
	}
	else if($row['complain_status'] == 'allocate')
	{
		$status = "<span class='label label-warning'>Allocate</span>";
	}
	else
	{
		$status = "<span class='label label-success'>Resolved</span>";
	}
	
	$sub_array = array();
	$sub_array[] = $row['complain_id'];
	$sub_array[] = $row['complain_date'];
	$sub_array[] = $row['customer_name'];
	$sub_array[] = $row['phone_no1'];
	$sub_array[] = $row['complain_info'];
	$sub_array[] = $row['complain_type'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["complain_id"].'" class="btn btn-info btn-xs view">View</button>';
	
	$allocate_status = '';
	if($row['complain_status']=='pending')
	{
			$allocate_status='';
			$resolve_status='disabled';
	}
	else
	{
			$allocate_status='disabled';
			$resolve_status='';
	}
	
	$sub_array[] = '<button type="button" name="allocate" id="'.$row["complain_id"].'" class="btn btn-info btn-xs allocate" '.$allocate_status.'>Allocate</button>';
	
	$sub_array[] = '<button type="button" name="resolve" id="'.$row["complain_id"].'" class="btn btn-success btn-xs  resolve" '.$resolve_status.'>Resolve</button>';
	
	$sub_array[] = '<button type="button" name="update" id="'.$row["complain_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["complain_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["entry_status"].'">Delete</button>';
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
	$obj = new ComplainMstr();
	$obj->openConnection();
	$query = $obj->preparedExecuteNoneQuery(Common::$select);
	$run = $obj->executeReader($query);
	$obj->closeConnection();
	return $obj->getTotalRows();
}
echo json_encode($output);

?>