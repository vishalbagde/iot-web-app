<?php
//product.php
include_once('header.php');
include_once('function.php');

?>
        <span id='alert_action'></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Product List</h3>
                            </div>           
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="customer_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Phone No</th>
                                    <th>Area</th>
                                    <th>Customer Type</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr></thead>
                            </table>
                        </div></div>
                    </div>
                </div>
			</div>
		</div>

        <div id="customerModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="customer_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Customer</h4>
                        </div>
                        <div class="modal-body">
						  <div class="form-group">
                                <label>Select Customer Type</label>
                                <select name="customer_type" id="customer_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="customer">customer</option>
                                    <option value="supplier">supplier</option>
                                    <option value="both">both</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Enter Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" required />
                            </div>
							
							<div class="form-group">
                                <label>Enter Phone No.</label>
                                <input type="text" name="phone_no1" id="phone_no1" class="form-control" required />
                            </div>
							
							<div class="form-group">
                                <label>Enter Phone No2.(optional)</label>
                                <input type="text" name="phone_no2" id="phone_no2" class="form-control" />
                            </div>
							
                            <div class="form-group">
                                <label>Enter Address</label>
                                <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                            </div>							
							
							<div class="form-group">
								<div class="col-xs-6">
									<label>Area Name</label>
									<input type="text" name="area_name" id="area_name" class="form-control" required />
								</div>
								<div class="col-xs-6">
									<label>Pincode</label>
									<input type="text" name="pincode" id="pincode" class="form-control" required />
								</div>
                                
                            </div>							
							
							<div class="form-group">
                                <label>Select City</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="">Select City</option>
                                    <option value="surat" selected>surat</option>
                                    <option value="navsari">navsari</option>
                                   
                                </select>
                            </div>
							
							<div class="form-group">
                                <label>Select State</label>
                                <select name="state" id="state" class="form-control" required>
                                    <option value="">Select state</option>
                                    <option value="gujarat" selected>Gujarat</option>
                                </select>
                            </div>
							
							
							<div class="form-group">
                                <label>GST No.</label>
                                <input type="text" name="gst_no" id="gst_no" class="form-control" />
                            </div>							
							
							<div class="form-group">
                                <label>PAN No.</label>
                                <input type="text" name="pan_no" id="pan_no" class="form-control" />
                            </div>		
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="customer_id" id="customer_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="customerdetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="product_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Customer Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="customer_details"></Div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<script>
$(document).ready(function(){
	
	$('#add_button').click(function(){
        $('#customerModal').modal('show');
        $('#customer_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Customer");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

	
	var customerdataTable = $('#customer_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"customer_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[4, 5],
				"orderable":false,
			},
		],
		"pageLength": 10
	});

   
 
    $('#category_id').change(function(){
        var category_id = $('#category_id').val();
        var btn_action = 'load_brand';
        $.ajax({
            url:"product_action.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
                $('#brand_id').html(data);
            }
        });
    });

	
    $(document).on('submit', '#customer_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"customer_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#customer_form')[0].reset();
                $('#customerModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                customerdataTable.ajax.reload();
            }
        })
    });
	


    $(document).on('click', '.view', function(){
        var customer_id = $(this).attr("id");
        var btn_action = 'customer_details';
        $.ajax({
            url:"customer_action.php",
            method:"POST",
            data:{customer_id:customer_id, btn_action:btn_action},
            success:function(data){
                $('#customerdetailsModal').modal('show');
                $('#customer_details').html(data);
            }
        })
    });
	
    $(document).on('click', '.update', function(){
        var customer_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"customer_action.php",
            method:"POST",
            data:{customer_id:customer_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#customerModal').modal('show');
                $('#customer_id').val(data.customer_id);
                $('#customer_type').val(data.customer_type);
                $('#customer_name').val(data.customer_name);
                $('#phone_no1').val(data.phone_no1);
                $('#phone_no2').val(data.phone_no2);
                $('#address').val(data.address);
                $('#area_name').val(data.area_name);
                $('#pincode').val(data.pincode);
                $('#city').val(data.city);
                $('#state').val(data.state);
                $('#gst_no').val(data.gst_no);
                $('#pan_no').val(data.pan_no);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
                $('#customer_id').val(customer_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });
	
	
	$(document).on('click', '.status', function(){
        var customer_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'status_change';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"customer_action.php",
                method:"POST",
                data:{customer_id:customer_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    customerdataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

    $(document).on('click', '.delete', function(){
        var customer_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"customer_action.php",
                method:"POST",
                data:{customer_id:customer_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    customerdataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

});
</script>
