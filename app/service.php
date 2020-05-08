<?php
//product.php
include_once('header.php');
include_once('function.php');



?>


	
	
        <span id='alert_action'></span>
		
			<div class="row">
				<div class="col-lg-12">
	
					<div class="col-sm-6 col-md-offset-3">
					
						<div class="form-group">
						<h3 class="text text-primary text-center">Customer Service </h3>
						</div>
					
						<div class="form-group">
							<label>Customer</label>
							<select name="customer_id" id="customer_id" class="form-control selectpicker" data-live-search="true" required>
								<option value="">Select Customer</option>
								<?php echo fill_customer_list_in_order(); ?>						
							</select>
						</div>
						
						<div class="form-group">
                            <label>Select Contract</label>
                            <select name="contract_id" id="contract_id" class="form-control" required>
                                <option value="">Select Contract</option>
                            </select>
                        </div>
						
						<div class="form-group">
                            <input type="hidden" name="cust_contract_id" id="cust_contract_id" />
                            <input type="hidden" name="cust_btn_action" id="cust_btn_action" />
                            <input type="submit" name="cust_submit_action" id="cust_submit_action" class="btn btn-info" value="Search" />
                
                        </div>
						
						
						
					
	
				</div>
			</div>
	
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Contract List</h3>
                            </div>           
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="service_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Machine Name</th>
                                    <th>Service Date</th>
                                    <th>Service Status</th>                                  
                                    <th>Status</th>
                                    <th></th>
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
		
		
		
		
		
		
		
        <div id="serviceModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="service_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Contract</h4>
                        </div>
                        <div class="modal-body">
								<div class="row">
			
									<div class="col-md-6">
										<div class="form-group">
											<label>Service Date</label>
											<input type="text" name="service_date" id="service_date" class="form-control"value='' required />
										</div>
									</div>
									<div class="col-md-6">
										
									</div>
								</div>
								
								
								<div class="row">
									<div class="col-md-6">
									
										<div class="form-group">
											<label>Visit Time TO</label>
											<input type="text" name="service_time_in" id="service_time_in" class="form-control"value='' required />
										</div>
										
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Visit Time Out</label>
											<input type="text" name="service_time_out" id="service_time_out" class="form-control"value='' required />
										</div>
									</div>
								</div>
								
							<div class="form-group">
                                <label>Work Details</label>
                                <textarea name="work_details" id="work_details" class="form-control" ></textarea>
                            </div>
							
							<div class="form-group">
                                <label>Remark</label>
                                <textarea name="service_remark" id="service_remark" class="form-control" ></textarea>
                            </div>
							
							
							
						
														
							<div class="form-group">
								<label>Service Status</label>
								<select name="entry_status" id="entry_status" class="form-control">
									<option value="active">active</option>
									<option value="deactive">deactive</option>
								</select>
							</div>
    				
                    </div>
                        <div class="modal-footer">
                            <input type="hidden" name="service_id" id="service_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		
		
		<div id="serviceAllocateModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="service_allocate_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Service Allocate</h4>
                        </div>
                        <div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Enter Technician Name</label>
											<select name="emp_id" id="emp_id" class="form-control selectpicker" data-live-search="true" required>
											<option value="">Select Employee</option>
											<?php echo fill_emp_list(); ?>						
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Service Remark</label>
											<textarea name="complain_remark" id="complain_remark" class="form-control" ></textarea>
										</div>							
									</div>	
							</div>
							
                        <div class="modal-footer">
                            <input type="hidden" name="service_allocate_id" id="service_allocate_id" />
                            <input type="hidden" name="btn_allocate_action" id="btn_allocate_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
		
		
		
		

        <div id="contractdetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="contract_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Contract Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="contract_details"></Div>
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
	
	var servicedataTable;
	$('.selectpicker').selectpicker();
	
	$("#customer_id").change(function(){
		var customer_id = $(this).children("option:selected").val();
			$.ajax({
				async: false,
				url:"function.php",
				method:"POST",
				data:{customer_id:customer_id,get_amc_contract_in_list:1},
				success:function(data)
				{
					$("#contract_id").html(data);
					
				}
			})        
		
    });
	
	
	$(document).on('click', '.allocate', function(){
		$('#serviceAllocateModal').modal('show');
        var service_id = $(this).attr("id");
		$('#service_allocate_id').val(service_id);
		$('#btn_allocate_action').val("service_allocate");
    });
	
	
	$(document).on('submit', '#service_allocate_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"service_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#service_allocate_form')[0].reset();
                $('#serviceAllocateModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                contractdataTable.ajax.reload();
            }
        })
    });
	
	
	
	$('#cust_submit_action').click(function(){
        var form_data = $(this).serialize();
		var customer_id = $("#customer_id").val();
		var contract_id = $("#contract_id").val();
		
		
			contractdataTable=null;
			$("#service_data").dataTable().fnDestroy();
			contractdataTable = $('#service_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			
			"ajax":{
				url:"service_fetch.php",
				type:"POST",
				data:{customer_id:customer_id,contract_id: contract_id}
			},
			"columnDefs":[
				{
					"targets":[5,6,7],
					"orderable":false,
				},
			],
			"pageLength": 10
			});
			contractdataTable.ajax.reload();
    });
	
	

	
	
	
	
	$("#from_date").change(function(){

					var d = new Date($("#from_date").val());
					var year = d.getFullYear();
					var month = d.getMonth();
					var day = d.getDate();
					var to_date = new Date(Number(year)+Number(amc_year),month,day);
					$("#to_date").val(to_date.getFullYear()+'-'+to_date.getMonth()+'-'+to_date.getDate());		     
    });
	

	
    $('#add_button').click(function(){
        $('#contractModal').modal('show');
        $('#contract_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Product");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });
	
	
	
    $('#amc_type').change(function(){
        var amc_type = $('#amc_type').val();
        var btn_action = 'load_amc';
        $.ajax({
            url:"contract_action.php",
            method:"POST",
            data:{amc_type:amc_type, btn_action:btn_action},
            success:function(data)
            {
                $('#amc_id').html(data);
            }
        });
    });

	
	
    $(document).on('submit', '#service_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"service_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#service_form')[0].reset();
                $('#serviceModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
				servicedataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.view', function(){
        var contract_id = $(this).attr("id");
        var btn_action = 'contract_details';
        $.ajax({
            url:"contract_action.php",
            method:"POST",
            data:{contract_id:contract_id, btn_action:btn_action},
            success:function(data){
                $('#contractdetailsModal').modal('show');
                $('#contract_details').html(data);
            }
        })
    });

    $(document).on('click', '.update', function(){
		
        var service_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"service_action.php",
            method:"POST",
            data:{service_id:service_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#serviceModal').modal('show');
				
                $('#service_date').val(data.service_date);
                $('#service_time_in').val(data.service_time_in);
                $('#service_time_out').val(data.service_time_out);
                $('#work_details').val(data.work_details);
                $('#service_remark').val(data.service_remark);
                $('#entry_status').val(data.entry_status);
           
                $('#service_id').val(service_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");

            }
        })
    });

    $(document).on('click', '.delete', function(){
        var service_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"service_action.php",
                method:"POST",
                data:{service_id:service_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    servicedataTable.ajax.reload();
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
