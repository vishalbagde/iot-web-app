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
                            	<h3 class="panel-title">Contract List</h3>
                            </div>           
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="contract_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Contract Date</th>
                                    <th>Customer Name</th>
                                    <th>AMC Name</th>
                                    <th>Contract From</th>
                                    <th>Contract To</th>
                                    <th>Total Service</th>
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
		
        <div id="contractModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="contract_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Contract</h4>
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
											<label>Date</label>
											<input type="text" name="contract_date" id="contract_date" class="form-control"value='<?php echo getTodayDate();?>' required />
										</div>
									</div>
								</div>
							
                            <div class="form-group">
                                <label>Select Contract Type</label>
                                <select name="amc_type" id="amc_type" class="form-control" required>
                                    <option value="">Select Type</option>
									<?php echo fill_amc_type();?>' 
								</select>
                            </div>
							
							<div class="form-group">
                                <label>Select Amc</label>
                                <select name="amc_id" id="amc_id" class="form-control" required>
                                    <option value="">Select Amc</option>
                                </select>
                            </div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
											<label>From Date</label>
											<input type="text" name="from_date" id="from_date" class="form-control"value='<?php echo getTodayDate();?>' required />
									</div>
								</div>
								<div class="col-md-6">
										<div class="form-group">
											<label>To Date</label>
											<input type="text" name="to_date" id="to_date" class="form-control"value='<?php echo getTodayDate();?>' required />
									</div>
								</div>
							</div>
							
							
							<div class="form-group">
                                <label>Sales Amt</label>
                                <input type="text" name="sales_amt" id="sales_amt" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
							
							
							
							<div class="form-group">
                                <label>Sales By </label>
                                <select name="sales_emp_id" id="sales_emp_id" class="form-control" required>
                                    <option value="">Select Employee</option>
									<?php echo fill_emp_list();?>' required />
                                </select>
                            </div>
							
							<div class="form-group">
                                <label>Machine Name</label>
                                <input type="text" name="machine_name" id="machine_name" class="form-control" required />
                            </div>
							
							<div class="form-group">
                                <label>Brand Name</label>
                                <input type="text" name="brand_name" id="brand_name" class="form-control" />
                            </div>
							
							<div class="form-group">
                                <label>Model No.</label>
                                <input type="text" name="model_no" id="model_no" class="form-control"/>
                            </div>
							
							<div class="form-group">
                                <label>Serial No.</label>
                                <input type="text" name="serial_no" id="serial_no" class="form-control"/>
                            </div>
							
							<div class="form-group">
							<label>Remark(optional)</label>
							<textarea name="remark" id="remark" class="form-control" ></textarea>
							</div>
						
														
							<div class="form-group">
								<label>Select Payment Status</label>
								<select name="payment_type" id="payment_type" class="form-control">
									<option value="cash">Cash</option>
									<option value="credit">Credit</option>
								</select>
							</div>
    				
                    </div>
                        <div class="modal-footer">
                            <input type="hidden" name="contract_id" id="contract_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
	
	var contractdataTable = $('#contract_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"contract_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[8,9,10,11],
				"orderable":false,
			},
		],
		"pageLength": 10
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

	
    $(document).on('submit', '#contract_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"contract_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#contract_form')[0].reset();
                $('#contractModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                contractdataTable.ajax.reload();
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
		
        var contract_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"contract_action.php",
            method:"POST",
            data:{contract_id:contract_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#contractModal').modal('show');
				
                $('#customer_id').val(data.customer_id);
                
                $('#amc_type').val(data.contract_type);
                $('#amc_id').html(data.amc_details);
                $('#amc_id').val(data.amc_id);
                $('#from_date').val(data.contract_from);
                $('#to_date').val(data.contract_to);
                $('#sales_amt').val(data.sales_amt);
                $('#sales_emp_id').val(data.sales_emp_id);
                $('#machine_name').val(data.machine_name);
                $('#brand_name').val(data.brand_name);
                $('#model_no').val(data.model_no);
                $('#serial_no').val(data.serial_no);
                $('#remark').val(data.remark);
                $('#payment_type').val(data.payment_type);
        
                $('#contract_id').val(contract_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");

            }
        })
    });

    $(document).on('click', '.delete', function(){
        var contract_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"contract_action.php",
                method:"POST",
                data:{contract_id:contract_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    contractdataTable.ajax.reload();
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
