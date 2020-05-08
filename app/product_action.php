<?php

//product_action.php
include_once('app_code/product_mstr.php');
include('function.php');
include('session.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_brand')
	{
		echo fill_brand_list($_POST['category_id']);
	}
	if($_POST['btn_action'] == 'Add')
	{	
		$obj = new ProductMstr();
		$obj->openConnection();
		$obj->setCategoryId($_POST['category_id']);
		$obj->setBrandId($_POST['brand_id']);
		$obj->setProductName($_POST['product_name']);
		$obj->setProductQty($_POST['product_quantity']);
		$obj->setProductUnit($_POST['product_unit']);
		$obj->setProductBasePrice($_POST['product_base_price']);
		$obj->setTaxId($_POST['tax_id']);
		$obj->setTaxRate($_POST['tax_rate']);
		$obj->setProductEnterBy($_SESSION["user_id"]);
		$obj->setUserId($_SESSION["user_id"]);
		$obj->setStatus('active');
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if($check)
		{
			echo "Product Insert success";
		}
	}
	if($_POST['btn_action'] == 'product_details')
	{
		$obj = new ProductMstr();
		$obj->openConnection();
		$query = "select p.*,c.category_name,b.brand_name,u.user_name,t.tax_name 
			from category_mstr c,product_mstr p,brand_mstr b,user_mstr u,tax_mstr t
			where c.category_id=p.category_id 
			and b.brand_id = p.brand_id 
			and u.user_id=p.user_id 
			and t.tax_id=p.tax_id  and p.product_id =". $_POST['product_id'];	
		$obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		while($row=mysqli_fetch_array($run))
		{
			$status = '';
			if($row['status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Deactive</span>';
			}
			$output .= '
			<tr>
				<td>Product Name</td>
				<td>'.$row["product_name"].'</td>
			</tr>
		
			<tr>
				<td>Category</td>
				<td>'.$row["category_name"].'</td>
			</tr>
			<tr>
				<td>Brand</td>
				<td>'.$row["brand_name"].'</td>
			</tr>
			<tr>
				<td>Available Quantity</td>
				<td>'.$row["product_qty"].' '.$row["product_unit"].'</td>
			</tr>
			<tr>
				<td>Base Price</td>
				<td>'.$row["product_base_price"].'</td>
			</tr>
			<tr>
				<td>Tax (%)</td>
				<td>'.$row["tax_name"].'</td>
			</tr>
			<tr>
				<td>Tax Rate </td>
				<td>'.$row["tax_rate"].'</td>
			</tr>
			<tr>
				<td>Enter By</td>
				<td>'.$row["user_name"].'</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
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
		$obj = new ProductMstr();
		$obj->openConnection();
		$obj->setWhere("product_id = ".$_POST["product_id"]." and status = 'active'");
		$obj->setProductId($_POST["product_id"]);
		$query =  $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
		while($row=mysqli_fetch_array($run))
		{
			$output['category_id'] = $row['category_id'];
			$output['brand_id'] = $row['brand_id'];
			$output["brand_select_box"] = fill_brand_list($row["category_id"]);
			$output['product_name'] = $row['product_name'];
			$output['product_qty'] = $row['product_qty'];
			$output['product_unit'] = $row['product_unit'];
			$output['product_base_price'] = $row['product_base_price'];
			$output['tax_id'] = $row['tax_id'];
			$output['tax_rate'] = $row['tax_rate'];
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$obj = new ProductMstr();
		$obj->openConnection();
		$obj->setCategoryId($_POST['category_id']);
		$obj->setBrandId($_POST['brand_id']);
		$obj->setProductName($_POST['product_name']);
		$obj->setProductQty($_POST['product_quantity']);
		$obj->setProductUnit($_POST['product_unit']);
		$obj->setProductBasePrice($_POST['product_base_price']);
		$obj->setTaxId($_POST['tax_id']);
		$obj->setTaxRate($_POST['tax_rate']);
		$obj->setProductEnterBy($_SESSION["user_id"]);
		$obj->setUserId($_SESSION["user_id"]);
		$obj->setStatus('active');
		$obj->setWhere('product_id ='.$_POST["product_id"]);
		$query = $obj->preparedExecuteNoneQuery(Common::$update);
		$check = $obj->executeNoneQuery($query);		
			echo 'Product Edited Success';
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'deactive';
		}
		$obj = new ProductMstr();
		$obj->openConnection();
		$obj->setStatus($status);
		$obj->setWhere('product_id = '. $_POST["product_id"]);
		$query =  $obj->preparedExecuteNoneQuery(Common::$update);
		$run = $obj->executeNoneQuery($query);
		if($run)
		{
			echo 'Product status change to ' . $status;
		}
	}
}


?>