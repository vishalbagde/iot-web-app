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
                            	<h3 class="panel-title">Complain List</h3>
                            </div>           
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="complain_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Complain Date</th>
                                    <th>Customer Name</th>
                                    <th>Phone No.</th>
                                    <th>Complain INFO</th>
                                    <th>Complain Type</th>
                                    <th>Complain Status</th>
                             
                                    <th></th>
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
		
        <div id="complainModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="complain_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Complain</h4>
                        </div>
                        <div class="modal-body">
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
											<label>Complain Date</label>
											<input type="text" name="complain_date" id="complain_date" class="form-control"value='<?php echo getTodayDate();?>' required />
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label>Complain Type</label>
									<select name="complain_type" id="complain_type" class="form-control " required>
										<option value="">Select</option>
										<option value="service">Service</option>
										<option value="repair">Repair</option>
										<option value="amc">AMC</option>
										<option value="installation">Installation</option>
										</select>
								</div>
								
								
								<div class="form-group">
								<label>Complain Info</label>
								<textarea name="complain_info" id="complain_info" class="form-control" ></textarea>
								</div>
								
							<div class="form-group">
                                <label>Received By </label>
                                <select name="received_by" id="received_by" class="form-control" required>
                                    <option value="">Select Employee</option>
									<?php echo fill_emp_list();?>
                                </select>
                            </div>			
                    </div>
                        <div class="modal-footer">
                            <input type="hidden" name="complain_id" id="complain_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		
		
		
		
		<div id="complainAllocateModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="complain_allocate_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Allocate Complain</h4>
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
											<label>Complain Remark</label>
											<textarea name="complain_remark" id="complain_remark" class="form-control" ></textarea>
										</div>							
									</div>	
									
											
							</div>
							
                        <div class="modal-footer">
                            <input type="hidden" name="complain_allocate_id" id="complain_allocate_id" />
                            <input type="hidden" name="btn_allocate_action" id="btn_allocate_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
		
		
		<div id="complainResolveModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="complain_resolve_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i>Complain Resolve</h4>
                        </div>
						
						
                        <div class="modal-body">
								<div class="col-md-12">
									<div class="form-group">
										<label>Resolve Date</label>
										<input type="text" name="resolve_date" id="resolve_date" class="form-control"value='<?php echo getTodayDate();?>' required />
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Work INFO</label>
										<textarea name="work_info" id="work_info" class="form-control" required ></textarea>
									</div>
								</div>
								
								<div class="col-md-12">
									<div class="form-group">
										<label>Resoved Remark</label>
										<textarea name="resolve_remark" id="resolve_remark" class="form-control" required ></textarea>
									</div>							
								</div>
								
								<div class="col-md-12">
									<div class="form-group">
										<label>Amount Charge (optional)</label>
										<input type="text" name="amount_charge" id="amount_charge" class="form-control" value="0" />
									</div>
								</div>
								
				
                        <div class="modal-footer">
                            <input type="hidden" name="complain_resolve_id" id="complain_resolve_id" />
                            <input type="hidden" name="btn_resolve_action" id="btn_resolve_action" />
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
	
	var amc_year;
	$('.selectpicker').selectpicker();
	
	$("#amc_id").change(function(){
		var amc_id = $(this).children("option:selected").val();
			$.ajax({
				async: false,
				url:"function.php",
				method:"POST",
				data:{amc_id:amc_id,get_amc_year:1},
				dataType:"json",
				success:function(data)
				{
					amc_year=data.amc_service_year;
					var d = new Date($("#from_date").val());
					var year = d.getFullYear();
					var month = d.getMonth();
					var day = d.getDate();
					var to_date = new Date(Number(year)+Number(amc_year),month,day);
					$("#to_date").val(to_date.getFullYear()+'-'+to_date.getMonth()+'-'+to_date.getDate());
					
				}
			})        
		
    });
	
	$("#from_date").change(function(){

					var d = new Date($("#from_date").val());
					var year = d.getFullYear();
					var month = d.getMonth();
					var day = d.getDate();
					var to_date = new Date(Number(year)+Number(amc_year),month,day);
					$("#to_date").val(to_date.getFullYear()+'-'+to_date.getMonth()+'-'+to_date.getDate());		     
		
    });
	
	var complaindataTable = $('#complain_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"complain_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[7,8,9,10,11],
				"orderable":false,
			},
		],
		"pageLength": 10
	});
	
    $('#add_button').click(function(){
        $('#complainModal').modal('show');
        $('#complain_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Complain");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });
	
	
	
	
	$(document).on('click', '.allocate', function(){
		$('#complainAllocateModal').modal('show');
        var complain_id = $(this).attr("id");
		$('#complain_allocate_id').val(complain_id);
		$('#btn_allocate_action').val("complain_allocate");
    });
	
	$(document).on('submit', '#complain_allocate_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"complain_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#complain_allocate_form')[0].reset();
                $('#complainAllocateModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                complaindataTable.ajax.reload();
            }
        })
    });
	
	
	
	$(document).on('click', '.resolve', function(){
		$('#complainResolveModal').modal('show');
        var complain_id = $(this).attr("id");
		$('#complain_resolve_id').val(complain_id);
		$('#btn_resolve_action').val("complain_resolve");
    });
	
	$(document).on('submit', '#complain_resolve_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"complain_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#complain_resolve_form')[0].reset();
                $('#complainResolveModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                complaindataTable.ajax.reload();
            }
        })
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

	
    $(document).on('submit', '#complain_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"complain_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#complain_form')[0].reset();
                $('#complainModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                complaindataTable.ajax.reload();
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
		
        var complain_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"complain_action.php",
            method:"POST",
            data:{complain_id:complain_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
				$('#complain_form')[0].reset();
                $('#complainModal').modal('show');
                //$('#customer_id').removeClass("selectpicker");
                $('#customer_id').val(data.customer_id);
				$('.selectpicker').selectpicker('refresh')
                $('#complain_date').val(data.complain_date);
                $('#complain_type').val(data.complain_type);
                $('#complain_info').val(data.complain_info);
                $('#received_by').val(data.received_by);
                $('#complain_id').val(complain_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");

            }
        })
    });

    $(document).on('click', '.delete', function(){
        var complain_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"complain_action.php",
                method:"POST",
                data:{complain_id:complain_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    complaindataTable.ajax.reload();
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
