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
						<h3 class="text text-primary text-center">User Select </h3>
						</div>
					
						<div class="form-group">
							<label>User</label>
							<select name="customer_id" id="user_select_id" class="form-control selectpicker" data-live-search="true" required>
								<option value="">Select Customer</option>
								<?php echo get_user_in_list(); ?>						
							</select>
						</div>
						<div class="form-group">
                            <input type="hidden" name="user_id" id="user_id" />
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
                            	<h3 class="panel-title">Tds</h3>
                            </div>           
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="service_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>UserId</th>
									<th>TDS</th>
                                    <th>DATE</th>
                                    <th>Time</th>                                  
                                                                    
                              
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
		var user_id = $("#user_id").val();
		alert(user_id);
		
		
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
	
	

	
	
	
	
	

});
</script>
