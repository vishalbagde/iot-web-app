<?php

//order_action.php
include_once('function.php');
include_once('app_code/sales_mstr.php');
include_once('app_code/order_product_mstr.php');
include_once('app_code/order_number_mstr.php');
include_once('session.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$obj = new SalesMstr();
		$obj->openConnection();
		$obj->setOrderNo($_POST["order_no"]);
		$obj->setGstType($_POST["order_type"]);
		$obj->setCustomerId($_POST["customer_id"]);
		$obj->setOrderDate($_POST["inventory_order_date"]);
		$obj->setshipAddress($_POST["inventory_order_address"]);
		$obj->setOrderDesc($_POST["order_desc"]);
		$obj->setPaymentType($_POST["payment_type"]);
		$obj->setUserId($user_id);
		$obj->setStatus('active');
		$query = $obj->preparedExecuteNoneQuery(Common::$insert);
		$check = $obj->executeNoneQuery($query);
		if(isset($check))
		{
			
			$net_amount=0;
			$total_tax=0;
			$total_amount=0;
			
			$sales_id=mysqli_insert_id($obj->getConnection());
			if(isset($sales_id))
			{
				$total_amount = 0;
				for($count = 0; $count<count($_POST["product_id"]); $count++)
				{
					$product_details=fetch_product_details($_POST["product_id"][$count]);
					$obj = new OrderProductMstr();
					$obj->openConnection();
					$obj->setSalesId($sales_id);
					$obj->setOrderNo($_POST["order_no"]);
					$obj->setProductId($_POST["product_id"][$count]);
					$obj->setProductQty($_POST["quantity"][$count]);
					$obj->setProductPrice($_POST["price"][$count]);
					$obj->setGstId($product_details['tax_id']);
					$obj->setGstRate($product_details['tax_rate']);
					$obj->setUserId($user_id);
					$obj->setStatus('active');
					$query = $obj->preparedExecuteNoneQuery(Common::$insert);
					$check = $obj->executeNoneQuery($query);			

					$net_amount+=$_POST["price"][$count]*$_POST["quantity"][$count];
					
					if($_POST["order_type"]=='gst')
					{
						$tax_rate = get_product_gst_rate($_POST["product_id"][$count]);
						$tax = $_POST["price"][$count]*$tax_rate/100;
						$total_tax+=$tax;
					}
					if($check)
					{
						$obj = new OrderProductMstr();
						$obj->openConnection();
						echo $query = "update product_mstr set product_qty = product_qty - ".$_POST['quantity'][$count]." where product_id = ".$_POST["product_id"][$count];
						$check = $obj->executeNoneQuery($query);			
						if($check)
						{
							echo "update qty";
						}
					}		
				}
				
				$total_amount=$net_amount+$total_tax;
				
				$obj = new SalesMstr();
				$obj->openConnection();
				$query = "update sales_mstr set net_amount=$net_amount ,total_tax=$total_tax,total_amount  = $total_amount  where sales_id = $sales_id";
				$check = $obj->executeNoneQuery($query);
				if($check)
				{
					echo  "Sales Order Generated Successful";
				}
				
				
				$obj = new OrderNumberMstr();
				$obj->openConnection();
				$query = "update order_number_mstr set order_number = order_number+1 where order_type = 'sale' and gst_type = '".$_POST["order_type"]."'";
				$check = $obj->executeNoneQuery($query);
				if($check)
				{
					echo  "Sales Order Generated Successful";
				}
								
			}			
		}
		/*
		$statement = $connect->query("SELECT LAST_INSERT_ID()");
		$inventory_order_id = $statement->fetchColumn();
		if(isset($inventory_order_id))
		{
			$total_amount = 0;
			for($count = 0; $count<count($_POST["product_id"]); $count++)
			{
				$product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				$sub_query = "
				INSERT INTO inventory_order_product (inventory_order_id, product_id, quantity, price, tax) VALUES (:inventory_order_id, :product_id, :quantity, :price, :tax)
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute(
					array(
						':inventory_order_id'	=>	$inventory_order_id,
						':product_id'			=>	$_POST["product_id"][$count],
						':quantity'				=>	$_POST["quantity"][$count],
						':price'				=>	$product_details['price'],
						':tax'					=>	$product_details['tax']
					)
				);
				$base_price = $product_details['price'] * $_POST["quantity"][$count];
				$tax = ($base_price/100)*$product_details['tax'];
				$total_amount = $total_amount + ($base_price + $tax);
			}
			
			$update_query = "
			UPDATE inventory_order 
			SET inventory_order_total = '".$total_amount."' 
			WHERE inventory_order_id = '".$inventory_order_id."'
			";
			$statement = $connect->prepare($update_query);
			$statement->execute();
			$result = $statement->fetchAll();
			if(isset($result))
			{
				echo 'Order Created...';
				echo '<br />';
				echo $total_amount;
				echo '<br />';
				echo $inventory_order_id;
			}
		}
		
	*/
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		
		
		$sales_id=$_POST["sales_id"];
		$obj = new SalesMstr();
		$obj->openConnection();
		$obj->setWhere("sales_id = $sales_id");
		$query = $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);
				
		while($row=mysqli_fetch_array($run))
		{
			$output['sales_id'] = $row['sales_id'];
			$output['order_no'] = $row['order_no'];
			$output['gst_type'] = $row['gst_type'];
			$output['customer_id'] = $row['customer_id'];
			$output['order_date'] = $row['order_date'];
			$output['ship_address'] = $row['ship_address'];
			$output['order_desc'] = $row['order_desc'];
			$output['payment_type'] = $row['payment_type'];
		}
		
		
			$obj1 = new OrderProductMstr();
			$obj1->openConnection();
			$obj1->setWhere("sales_id = $sales_id");
			$query_product = $obj1->preparedExecuteNoneQuery(Common::$select);
			$run_product = $obj1->executeNoneQuery($query_product);					
		
			$count ='';
			$product_details='';
			while($sub_row=mysqli_fetch_array($run_product))
			{
				$product_details .= '
				<script>
				$(document).ready(function(){
					$("#product_id'.$count.'").selectpicker("val", '.$sub_row["product_id"].');
					$(".selectpicker").selectpicker();
				});
				</script>
				<span id="row'.$count.'">
					<div class="row">
						<div class="col-md-6">
							<select name="product_id[]" id="product_id'.$count.'" class="form-control selectpicker" data-live-search="true" required>
								'.fill_product_list().'
							</select>
							<input type="hidden" name="hidden_product_id[]" id="hidden_product_id'.$count.'" value="'.$sub_row["product_id"].'" />
						</div>
						<div class="col-md-2">
							<input type="text" name="quantity[]" class="form-control" value="'.$sub_row["product_qty"].'" required />
						</div>
						<div class="col-md-2">
							<input type="text" name="price[]" class="form-control" value="'.$sub_row["product_price"].'" required />
						</div>
						<div class="col-md-1">
				';

				if($count == '')
				{
					$product_details .= '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
				}
				else
				{
					$product_details .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove">-</button>';
				}
				$product_details .= '
							</div>
						</div>
					</div><br />
				</span>
				';
				$count = (int)$count + 1;
			}
			$output['count']=$count;
			$output['product_details'] = $product_details;
			$output['state_gst_type']= get_customer_gst_type($output['customer_id']);
		
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$delete_query = "
		DELETE FROM inventory_order_product 
		WHERE inventory_order_id = '".$_POST["inventory_order_id"]."'
		";
		$statement = $connect->prepare($delete_query);
		$statement->execute();
		$delete_result = $statement->fetchAll();
		if(isset($delete_result))
		{
			$total_amount = 0;
			for($count = 0; $count < count($_POST["product_id"]); $count++)
			{
				$product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				$sub_query = "
				INSERT INTO inventory_order_product (inventory_order_id, product_id, quantity, price, tax) VALUES (:inventory_order_id, :product_id, :quantity, :price, :tax)
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute(
					array(
						':inventory_order_id'	=>	$_POST["inventory_order_id"],
						':product_id'			=>	$_POST["product_id"][$count],
						':quantity'				=>	$_POST["quantity"][$count],
						':price'				=>	$product_details['price'],
						':tax'					=>	$product_details['tax']
					)
				);
				$base_price = $product_details['price'] * $_POST["quantity"][$count];
				$tax = ($base_price/100)*$product_details['tax'];
				$total_amount = $total_amount + ($base_price + $tax);
			}
			$update_query = "
			UPDATE inventory_order 
			SET inventory_order_name = :inventory_order_name, 
			inventory_order_date = :inventory_order_date, 
			inventory_order_address = :inventory_order_address, 
			inventory_order_total = :inventory_order_total, 
			payment_status = :payment_status
			WHERE inventory_order_id = :inventory_order_id
			";
			$statement = $connect->prepare($update_query);
			$statement->execute(
				array(
					':inventory_order_name'			=>	$_POST["inventory_order_name"],
					':inventory_order_date'			=>	$_POST["inventory_order_date"],
					':inventory_order_address'		=>	$_POST["inventory_order_address"],
					':inventory_order_total'		=>	$total_amount,
					':payment_status'				=>	$_POST["payment_status"],
					':inventory_order_id'			=>	$_POST["inventory_order_id"]
				)
			);
			$result = $statement->fetchAll();
			if(isset($result))
			{
				echo 'Order Edited...';
			}
		}
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE inventory_order 
		SET inventory_order_status = :inventory_order_status 
		WHERE inventory_order_id = :inventory_order_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':inventory_order_status'	=>	$status,
				':inventory_order_id'		=>	$_POST["inventory_order_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Order status change to ' . $status;
		}
	}
}

?>