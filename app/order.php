<?php
//order.php
include('function.php');
include('header.php');

?>
	<link rel="stylesheet" href="css/datepicker.css">
	<script src="js/bootstrap-datepicker1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
	<script>
	$(document).ready(function(){
		var date = new Date();
		$('#inventory_order_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			minDate:new Date(),
			defaultDate: new Date()	
		});
		$('#inventory_order_date').val("test");
	});
	
	</script>
	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">

			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                    	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            <h3 class="panel-title">Order List</h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                	<table id="order_data" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>Order Date</th>
								<th>Order No</th>
								<th>Customer_name</th>
								<th>Payment Status</th>
								<th>Order Status</th>
								<th>NetAmt</th>
								<th>Tax</th>
								<th>TotalAmt</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div id="orderModal" class="modal fade">

    	<div class="modal-dialog">
    		<form method="post" id="order_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Create Order</h4>
    				</div>
    				<div class="modal-body">
					<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<label>Order Type</label>
								<select name="order_type" id="order_type" class="form-control">
								<option value="">Select Order Type</option>
								<option value="no_gst">No Gst</option>
								<option value="gst">Gst</option>
								</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Order No</label>
									<input type="text" name="order_no" id="order_no" class="form-control" required />
								</div>
							</div>
						</div>
					
    					<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Enter Customer Name</label>
									<select name="customer_id" id="customer_id" class="form-control selectpicker" data-live-search="true" required>
									<option value="">Select Customer</option>
									<?php echo fill_customer_list_in_order(); ?>						
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Date</label>
									<input type="text" name="inventory_order_date" id="inventory_order_date" class="form-control"value='<?php echo getTodayDate();?>' required />
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Enter Receiver Address(optional)</label>
							<textarea name="inventory_order_address" id="inventory_order_address" class="form-control" ></textarea>
						</div>
						
						<div class="form-group">
							<label>Enter Product Details</label>
							<span >
								<div class="row">
								<div class="col-md-6">
								<span><b>Product Name</b></span>
								</div>
								<div class="col-md-2">
								<span><b>Qty</b></span>
								</div>
								<div class="col-md-3">
								<span><b>Price</b></span>
								</div>
								
								</div>
							</span>
							
							<span id="span_product_details"></span>
							<hr />
						</div>
						
						<div class="row">
								<div class="col-md-6">
								<span><b>Total </b></span>
								</div>
								<div class="col-md-2">
								<b><span id='tqty'></span></b>
								</div>
								<div class="col-md-3">
								<b><span id='tprice'></span></b>
								</div>
						</div>
						<hr />
						
						<div class="row">
							<div class="container">
								<div class="col-md-3">
									left side
								</div>
								<div class="col-md-6">
								
									<div class="row">
										<div class="col-md-3">
										<span><b>Net Total: </b></span>
										</div>
										<div class="col-md-3">
										<b><span id='fnettotal'>0.0</span></b>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-3">
										<span><b>GST : </b></span>
										
											<div class="row">
												<div class="col-md-6">
													<span id='cgst'><b> </b></span>
												</div>
												<div class="col-md-6">
														<b><span id='cgstvalue'></span></b>
												</div>							
											</div>
											<div class="row">
												<div class="col-md-6">
													<span id='sgst'><b></b></span>
												</div>
												<div class="col-md-6">
														<b><span id='sgstvalue'></span></b>
												</div>							
											</div>
										</div>
										
								
										<div class="col-md-3">
										<b><span id='fgst'>0.0</span></b>
										</div>									
									</div>
									
									<div class="row">
										<div class="col-md-3">
										<span><b>Total : </b></span>
										</div>
										<div class="col-md-3">
										<b><span id='ftotal'>0.0</span></b>
										</div>									
									</div>
									
									
								</div>
							
							</div>
						
						</div>
						
						<hr />
						
						<div class="form-group">
							<label>Order Note(optional)</label>
							<textarea name="order_desc" id="order_desc" class="form-control" ></textarea>
						</div>
						
						<hr />
											
						
						<div class="form-group">
							<label>Select Payment Status</label>
							<select name="payment_type" id="payment_type" class="form-control">
								<option value="cash">Cash</option>
								<option value="credit">Credit</option>
							</select>
						</div>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="inventory_order_id" id="inventory_order_id" />
    					<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    				</div>
    			</div>
    		</form>
    	</div>

    </div>

<script type="text/javascript">

$(document).ready(function(){
	
	var gst_type = "";
	var order_t = '';
	var gst_rate;
	
	 $("#order_type").change(function(){
        var order_type = $(this).children("option:selected").val();
		order_t = order_type;
		var get_order_no=1;
			$.ajax({
				url:"function.php",
				method:"POST",
				data:{order_type:order_type,get_order_no:get_order_no},
				dataType:"json",
				success:function(data)
				{
					$('#order_no').val(data.order_id);
				}
			})        
    });
	$("#customer_id").change(function(){
        var customer_id = $(this).children("option:selected").val();
		var check_customer_gst_type=1;
		if(order_t=='gst')
		{
			$.ajax({
				async: false,
				url:"function.php",
				method:"POST",
				data:{customer_id:customer_id,check_customer_gst_type:check_customer_gst_type},
				dataType:"json",
				success:function(data)
				{
					gst_type = data.gst_type;
					
				}
			})        
		}
    });
	
	
    	var orderdataTable = $('#order_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"order_fetch.php",
				type:"POST"
			},
			"columnDefs":[
				{
					"targets":[8,9, 10, 11],
					"orderable":false,
				},
			],
			
			"pageLength": 10
		});
	

		$('#add_button').click(function(){
			$('#orderModal').modal('show');
			$('#order_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Create Order");
			$('#action').val('Add');
			$('#btn_action').val('Add');
			$('#span_product_details').html('');
			add_product_row();
			
		});
		
		
		function add_product_row(count = '')
		{
			var html = '';
			html += '<span id="row'+count+'"><div class="row">';
			html += '<div class="col-md-6">';
			html += '<select name="product_id[]" id="product_id'+count+'" class="form-control selectpicker" data-live-search="true" required>';
			html += '<?php echo fill_product_list(); ?>';
			html += '</select><input type="hidden" name="hidden_product_id[]" id="hidden_product_id'+count+'" />';
			html += '</div>';
			html += '<div class="col-md-2">';
			html += '<input type="text" name="quantity[]" class="form-control" required />';
			html += '</div>';
			html += '<div class="col-md-3">';
			html += '<input type="text" name="price[]" class="form-control" required />';
			html += '</div>';
			html += '<div class="col-md-1">';
			if(count == '')
			{
				html += '<button type="button btn-sm" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			}
			else
			{
				html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">-</button>';
			}
			html += '</div>';
			html += '</div></div><br /></span>';
			$('#span_product_details').append(html);

			$('.selectpicker').selectpicker();
		}

		var count = 0;
		function setPriceQtyInLabel()
		{
			var tqtysum=0;
			var tpricesum=0;
			var ttotal=0;
			var gstTotal = 0;	
			var tqty = document.getElementsByName('quantity[]');
			var tprice = document.getElementsByName('price[]');
			
			
			for (var i = 0, len = tqty.length; i < len; i++) {
				
				tqtysum=Number(tqtysum)+Number(tqty[i].value);
				var sum = Number(tqty[i].value)*Number(tprice[i].value);
				ttotal = Number(ttotal)+Number(sum);
			}
			$('#tqty').html(tqtysum);
			$('#tprice').html(ttotal.toFixed(2));
			
			$('#fnettotal').html(Number(ttotal).toFixed(2));	
			if(order_t=='gst')
			{
				var pidarray = document.getElementsByName('product_id[]');
		
				plen = pidarray.length; 
				for (var i = 0;i < plen; i++) {
					product_id = pidarray[i].value;
					gst_rate =get_gst_rate_ajax(product_id);							
					var sum = Number(tqty[i].value)*Number(tprice[i].value);
					var gst_amt = Number(sum)*Number(gst_rate/100);
					gstTotal = Number(gstTotal)+Number(gst_amt);
				}
				
				if(gst_type=='sgst')
				{
					var cgst = Number(gstTotal)/2;
					var sgst = Number(gstTotal)/2;
					$('#cgst').html('CGST');	
					$('#cgstvalue').html(cgst.toFixed(2));	
					$('#sgst').html('SGST');	
					$('#sgstvalue').html(sgst.toFixed(2));	
					$('#fgst').html(gstTotal.toFixed(2));	
				}
				else if(gst_type=='igst')
				{
					$('#fgst').html(gstTotal.toFixed(2));	
					$('#cgst').html('IGST');	
					$('#cgstvalue').html(gstTotal.toFixed(2));	
					
					$('#sgst').html('');	
					$('#sgstvalue').html('');	
					
				}
				
				
				var s = Number(sum)+Number(gstTotal.toFixed(2));
				$('#ftotal').html(s.toFixed(2));
			}	
			else
			{
				$('#ftotal').html(Number(ttotal).toFixed(2));
			}
			
		
		}
		
		function get_gst_rate_ajax(product_id)
		{
			var result;
			$.ajax({
					async: false,
					url:"function.php",
					method:"POST",
					data:{product_id:product_id,get_product_gst_rate:1},
					dataType:"json",
					success:function(data){
						result = data.gst_rate;
					}
					});
			return result;
		}
		$(document).on('click', '#add_more', function(){
			setPriceQtyInLabel();
			count = count + 1;
			add_product_row(count);
			
			
			/*
			var tqtysum=0;
			var tpricesum=0;
			var ttotal=0;
			var tqty = document.getElementsByName('quantity[]');
			var tprice = document.getElementsByName('price[]');
			for (var i = 0, len = tqty.length; i < len; i++) {
				
				tqtysum=Number(tqtysum)+Number(tqty[i].value);
				var sum = Number(tqty[i].value)*Number(tprice[i].value);
				ttotal = Number(ttotal)+Number(sum);
			}
			$('#tqty').html(tqtysum);
			$('#tprice').html(ttotal.toFixed(2));
			*/
		
			
		});
		$(document).on('click', '.remove', function(){
			var row_no = $(this).attr("id");
			$('#row'+row_no).remove();
			count = count - 1;
			setPriceQtyInLabel();
			
		});

		$(document).on('submit', '#order_form', function(event){
			event.preventDefault();
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"order_action.php",
				method:"POST",
				data:form_data,
				success:function(data){
					$('#order_form')[0].reset();
					$('#orderModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
					$('#action').attr('disabled', false);
					orderdataTable.ajax.reload();
				}
			});
		});
		
		$(document).on('click', '.update', function(){
			
			var sales_id = $(this).attr("id");
			
			var btn_action = 'fetch_single';
			$.ajax({
				async: false,
				url:"order_action.php",
				method:"POST",
				data:{sales_id:sales_id, btn_action:btn_action},
				dataType:"json",
				success:function(data)
				{
					$('#orderModal').modal('show');
					$('#order_type').val(data.gst_type);
					$('#order_no').val(data.order_no);
					$('#customer_id').val(data.customer_id);
					$('.selectpicker').selectpicker('refresh')
					$('#order_date').val(data.order_date);
					$('#inventory_order_address').val(data.ship_address);
					$('#span_product_details').html(data.product_details);
					setPriceQtyInLabel();
					$('#order_desc').html(data.order_desc);
					$('#payment_type').val(data.payment_type);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Order");
					$('#inventory_order_id').val(sales_id);
					$('#action').val('Edit');
					$('#btn_action').val('Edit');	
					
					count=data.count;
					
					
					if(data.gst_type == 'gst')
					{
						order_t = 'gst';
						gst_type=data.state_gst_type;
					}
					else
					{
						order_t='no_gst';
					}
		
				}
			})
		});

		$(document).on('click', '.delete', function(){
			var inventory_order_id = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "delete";
			if(confirm("Are you sure you want to change status?"))
			{
				$.ajax({
					url:"order_action.php",
					method:"POST",
					data:{inventory_order_id:inventory_order_id, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						orderdataTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		});
    });

</script>
