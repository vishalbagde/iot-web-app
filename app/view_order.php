<?php

//view_order.php
include('function.php');
include('session.php');
include('app_code/sales_mstr.php');
include_once('pdf.php');
include_once('app_code/customer_mstr.php');
include_once('app_code/order_product_mstr.php');
$sales_id="0";
if(isset($_GET['pdf']))
{
	if(isset($_GET['sales_id']))
	{
		$sales_id = $_GET['sales_id'];
	}
	else
	{
		header('location:order.php');
	}
}
else
{
		header('location:order.php');
}




		$output = '';
		$obj = new SalesMstr();
		$obj->openConnection();
		$obj->setWhere("status = 'active' and sales_id = $sales_id and user_id = $user_id");
		$query = $obj->preparedExecuteNoneQuery(Common::$select);
		$run = $obj->executeReader($query);		
		
	if($row=mysqli_fetch_array($run))
	{
		
		$gst_type = $row['gst_type'];
		
		$obj1= new CustomerMstr();
		$obj1->openConnection();
		$obj1->setWhere("status = 'active' and customer_id = ".$row['customer_id']." and user_id = $user_id");
		$query_cust = $obj1->preparedExecuteNoneQuery(Common::$select);
		$run_cust = $obj1->executeReader($query_cust);
		$row_cust=mysqli_fetch_array($run_cust);
		
			
		
		$invoice_title = '';
		$width=0;
		if($row['gst_type']=='gst')
		{
			$invoice_title = 'TAX INVOICE';
			$width="100%";
		}
		else
		{
			$invoice_title = 'INVOICE';
			$width="100%";
		}
		
		
		$output .= '
			<table width="'.$width.'" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="2" align="center" style="font-size:18px"><b>'.$invoice_title.'</b></td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%" cellpadding="5">
						<tr>
							<td width="65%">
								From,<br />
								<b>'.$company_name.'</b><br />
								<b>Add </b>:'.$company_address.'<br />
								<b>GST NO. </b>'.$company_gst_no.'<br />
								<b>State. </b>'.$company_state.'<br />
							</td>
							<td width="35%">
								Order Details<br />
								Invoice No.  :  <b>'.$row["order_no"].'</b><br />
								Invoice Date : <b>'.date("d-M-Y",strtotime($row["order_date"])).'</b><br />
								
							</td>
							
						</tr>
							
						<tr>
							<td width="65%">
							<hr>
								<b>BUYER(BILL TO)</b><br />
								Name : '.strtoupper($row_cust["customer_name"]).   '<br />	
								Address : '.substr($row_cust["address"],0,20).'<br />
									'.substr($row_cust["address"],21,strlen($row_cust["address"])).'<br />
								Area Name : '.strtoupper($row_cust["area_name"]).   '<br />	
								PinCode : '.strtoupper($row_cust["pincode"]).   '<br />	
							</td>
							<td width="35%">
							</td>
						</tr>
					</table>
					<br />
			';
			
			
		if($gst_type=='gst')
		{
			
			$state_gst_type= get_customer_gst_type($row['customer_id']);
			if($state_gst_type=='sgst')
			{
			
				$output.='
						<table width="100%" border="1" cellpadding="4" cellspacing="0">
							<tr>
								<th rowspan="2" ">Sr No.</th>
								<th rowspan="2" >Product</th>
								<th rowspan="2" >HSN</th>
								<th rowspan="2" >Qty</th>
								<th rowspan="2" >Price</th>
								<th rowspan="2" >per.</th>
								<th rowspan="2" width="40%">Total</th>
								<th rowspan="2" width="10%">Tax rate</th>
								<th colspan="4" align="center">Tax Type</th>
								<th rowspan="2">Total</th>
							</tr>
							<tr>
								<th>Type</th>
								<th>Amt.</th>
								<th>Type</th>
								<th>Amt.</th>
							</tr>';	
				$query_product ="select o.*,
				p.product_name,p.product_unit,p.hsn_code,p.tax_rate
				from order_product_mstr o,product_mstr p where o.product_id = p.product_id and   o.sales_id = $sales_id";
				$sr_no=1;	
				$obj2= new ProductMstr();
				$obj2->openConnection();
				$run_p = $obj2->executeReader($query_product);
				$amount_sum = 0;
				$gstsum=0;
				$total_sum=0;
				while($row_product=mysqli_fetch_array($run_p))
				{
				
					$amount_sum+=$row_product["product_qty"]*$row_product["product_price"];
					$gstsum+=($row_product["product_qty"]*$row_product["product_price"]*$row_product["tax_rate"])/100;
					$total_sum=$amount_sum+$gstsum;
					
					$output .='
						<tr>
							<td align="right"><b>'.$sr_no++.'</b></td>
							<td>'.$row_product['product_name'].'</td>
							<td align="right">'.$row_product['hsn_code'].'</td>
							<td align="right">'.$row_product["product_qty"].'</td>
							<td align="right">'.number_format($row_product["product_price"],2).'</td>
							<td align="right">'.$row_product["product_unit"].'</td>
							<td align="right">'.number_format($row_product["product_qty"]*$row_product["product_price"], 2).'</td>
							<td align="right">'.$row_product["tax_rate"].'%</td>
									
							<td align="right">CGST '.($row_product["tax_rate"]/2).'%</td>
							<td align="right">'.number_format((($row_product["product_qty"]*$row_product["product_price"]*$row_product["tax_rate"]/2)/100),2).'</td>
							<td align="right">SGST '.($row_product["tax_rate"]/2).'%</td>
							<td align="right">'.number_format((($row_product["product_qty"]*$row_product["product_price"]*$row_product["tax_rate"]/2)/100),2).'</td>
							
							
							<td align="right">'.number_format(($row_product["product_qty"]*$row_product["product_price"])+($row_product["product_qty"]*$row_product["product_price"]*$row_product["tax_rate"])/100, 2).'</td>
						</tr>';
				
				}
						$output .= '
						<tr>
							<td align="center" colspan="6"><b>Total</b></td>
							<td align="right"><b>'.number_format($amount_sum, 2).'</b></td>
							<td>&nbsp;</td>
							<td><b>CGST</b></td>
							<td align="right"><b>'.number_format($gstsum/2, 2).'</b></td>
							<td><b>SGST</b></td>
							<td align="right"><b>'.number_format($gstsum/2, 2).'</b></td>
							<td align="right"><b>'.number_format($total_sum, 2).'</b></td>
						</tr>
						</table>';
						
						
						
						$output.='<tr>
						<td colspan="1">
						</td>
						<td colspan="1">
								
								<table  width="100%" border="1" cellpadding="1" cellspacing="0">
									<tr>
										<td align="right"><b>Amount : </b></td>
										<td align="right"><b>'.number_format($amount_sum, 2).'</b></td>
									</tr>
									<tr>
										<td align="right"><b>SGST : </b></td>
										<td align="right"><b>'.number_format($gstsum/2, 2).'</b></td>
									</tr>
									<tr>
										<td align="right"><b>CGST : </b></td>
										<td align="right"><b>'.number_format($gstsum/2, 2).'</b></td>
									</tr>
									
									<tr>
										<td align="right"><b>round : </b></td>
										<td align="right"><b>(-)'.number_format(($total_sum-floor($total_sum)),2).'</b></td>
									</tr>
									
									<tr>
										<td align="right"><b>Total : </b></td>
										<td align="right"><b>'.number_format(floor($total_sum), 2).'</b></td>
									</tr>
									
								</table>
						</td></tr>';
				
		
			}
			else if($state_gst_type=='igst')
			{
				
					$output.='
						<table width="100%" border="1" cellpadding="4" cellspacing="0">
							<tr>
								<th rowspan="2" >Sr No.</th>
								<th rowspan="2" >Product</th>
								<th rowspan="2" >HSN</th>
								<th rowspan="2" >Qty</th>
								<th rowspan="2" >Price</th>
								<th rowspan="2" >per.</th>
								<th rowspan="2" >Total</th>
								<th rowspan="2" >Tax rate</th>
								<th colspan="2" align="center">Tax Type</th>
								<th rowspan="2">Total</th>
							</tr>
							<tr>
								<th>Type</th>
								<th>Amt.</th>
							</tr>';	
				$query_product ="select o.*,
				p.product_name,p.product_unit,p.hsn_code,p.tax_rate
				from order_product_mstr o,product_mstr p where o.product_id = p.product_id and   o.sales_id = $sales_id";
				$sr_no=1;	
				$obj2= new ProductMstr();
				$obj2->openConnection();
				$run_p = $obj2->executeReader($query_product);
				$amount_sum = 0;
				$gstsum=0;
				$total_sum=0;
				while($row_product=mysqli_fetch_array($run_p))
				{
				
					$amount_sum+=$row_product["product_qty"]*$row_product["product_price"];
					$gstsum+=($row_product["product_qty"]*$row_product["product_price"]*$row_product["tax_rate"])/100;
					$total_sum=$amount_sum+$gstsum;
					
					$output .='
						<tr>
							<td>'.$sr_no++.'</td>
							<td>'.$row_product['product_name'].'</td>
							<td>'.$row_product['hsn_code'].'</td>
							<td aling="right">'.$row_product["product_qty"].'</td>
							<td aling="right">'.number_format($row_product["product_price"],2).'</td>
							<td aling="right">'.$row_product["product_unit"].'</td>
							<td align="right">'.number_format($row_product["product_qty"]*$row_product["product_price"], 2).'</td>
							<td aling="right">'.$row_product["tax_rate"].'%</td>
									
							<td aling="right">IGST '.($row_product["tax_rate"]).'%</td>
							<td aling="right">'.number_format(($row_product["product_qty"]*$row_product["product_price"]*$row_product["tax_rate"])/100,2).'</td>
							
							<td align="right">'.number_format(($row_product["product_qty"]*$row_product["product_price"])+($row_product["product_qty"]*$row_product["product_price"]*$row_product["tax_rate"])/100, 2).'</td>
						</tr>';
				}
						$output .= '
						<tr>
							<td align="center" colspan="6"><b>Total</b></td>
							<td align="right"><b>'.number_format($amount_sum, 2).'</b></td>
							<td>&nbsp;</td>
							<td><b>IGST</b></td>
							<td align="right"><b>'.number_format($gstsum, 2).'</b></td>
							<td align="right"><b>'.number_format($total_sum, 2).'</b></td>
						</tr>
						</table>';
						
						
						$output.='<tr>
						<td colspan="1">
						</td>
						<td colspan="1">
								
								<table  width="100%" border="1" cellpadding="1" cellspacing="0">
									<tr>
										<td align="right"><b>Amount : </b></td>
										<td align="right"><b>'.number_format($amount_sum, 2).'</b></td>
									</tr>
									<tr>
										<td align="right"><b>IGST : </b></td>
										<td align="right"><b>'.number_format($gstsum, 2).'</b></td>
									</tr>

									<tr>
										<td align="right"><b>Round off : </b></td>
										<td align="right"><b>(-)'.number_format(($total_sum-floor($total_sum)),2).'</b></td>
									</tr>
									
									<tr>
										<td align="right"><b>Total : </b></td>
										<td align="right"><b>'.number_format(floor($total_sum), 2).'</b></td>
									</tr>
									
								</table>
						</td></tr>';
				
				
				
			}
				
			
					$output .='
					<tr >
						<td width="50%"></td>
						<td align="right"> 
						
							<table width="100%"  cellpadding="0" cellspacing="0">
								<tr>
								<td colspan="2"><b>Company’s Bank Details</b></td>
								</tr>
								
								<tr>
								<td>Bank Name</td>
								<td><b>'.strtoupper($company_bank_name).'</b></td>
								</tr>
								
								<tr>
								<td>Account Number	</td>
								<td><b>'.$company_bank_account_number.'</b></td>
								</tr>
								<tr>
								<td>Branch&IFSC</td>
								<td><b>'.strtoupper($company_bank_branch).' & '.$company_bank_ifsc.' </b></td>
								</tr>
								
								
							
							</table>
						
						</td>
					</tr>';
		}//end if invoice is gst
		else
		{
			
					$output.='
						<table width="98%" border="1" cellpadding="4" cellspacing="0">
							<tr>
								<th  width="20%">Sr No.</th>
								<th  width="50%" >Product</th>
								<th  width="20%">HSN/HSC</th>
								<th width="40%" >Qty</th>
								<th width="40%">Price</th>
								<th width="10%">per.</th>
								<th width="20%">Total</th>
							</tr>
							';	
				$query_product ="select o.*,
				p.product_name,p.product_unit,p.hsn_code,p.tax_rate
				from order_product_mstr o,product_mstr p where o.product_id = p.product_id and   o.sales_id = $sales_id";
				$sr_no=1;	
				$obj2= new ProductMstr();
				$obj2->openConnection();
				$run_p = $obj2->executeReader($query_product);
				$amount_sum = 0;
				$gstsum=0;
				$total_sum=0;
				while($row_product=mysqli_fetch_array($run_p))
				{
				
					$amount_sum+=$row_product["product_qty"]*$row_product["product_price"];
					$total_sum=$amount_sum;
					
					$output .='
						<tr>
							<td>'.$sr_no++.'</td>
							<td>'.$row_product['product_name'].'</td>
							<td>'.$row_product['hsn_code'].'</td>
							<td aling="right">'.$row_product["product_qty"].'</td>
							<td aling="right">'.number_format($row_product["product_price"],2).'</td>
							<td aling="right">'.$row_product["product_unit"].'</td>
							<td align="right">'.number_format($row_product["product_qty"]*$row_product["product_price"], 2).'</td>
						</tr>';
				}
						$output .= '
						<tr>
							<td align="center" colspan="6"><b>Total</b></td>
							<td align="right"><b>'.number_format($amount_sum, 2).'</b></td>
						</tr>
						</table>';
						$output.='<tr>
						<td colspan="1">
						</td>
						<td colspan="1">
								
								<table  width="100%" border="1" cellpadding="1" cellspacing="0">
									<tr>
										<td align="right"><b>Amount : </b></td>
										<td align="right"><b>'.number_format($amount_sum, 2).'</b></td>
									</tr>
									<tr>
										<td align="right"><b>Round off : </b></td>
										<td align="right"><b>(-)'.number_format(($total_sum-floor($total_sum)),2).'</b></td>
									</tr>
									
									<tr>
										<td align="right"><b>Total : </b></td>
										<td align="right"><b>'.number_format(floor($total_sum), 2).'</b></td>
									</tr>
									
								</table>
						</td></tr>';
			
			
			
			
		}
					$output .='<tr>
					<td  width="50%" >
						<p><b><u>Declaration</u><b></p>
						<p>We declare that this invoice shows the actual price of
						the goods described and that all particulars are true
						and correct.</p>
					</td>
					<td> 
							<p align="right">For,<b>'.$company_name.'</b></p>
							</br>
							<p align="right">----------------------------------------<br />Authorised Signatory</p>
							
					</td>
					</tr>';
			//</table>';	
			

		$output.='</td></tr></table>';		

	//	echo $output;	
	}
	
	
	if($_GET['pdf']=="1")
	{
		$pdf = new Pdf();
		$file_name = '567'.'pdf';
		$pdf->loadHtml($output);
		$pdf->render();
		$pdf->set_paper("a4", "portrait");
		$pdf->stream($file_name, array("Attachment" => 0));	
	}
	else
	{
		echo $output;	
		
	}
	
	
	
	
	
	
	


?>