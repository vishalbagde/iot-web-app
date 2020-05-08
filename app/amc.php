<?php
include('header.php');
?>
	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
                			<h3 class="panel-title">AMC LIST</h3>
                		</div>
                		<div class="col-md-2" align="right">
                			<button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                		</div>
                	</div>
                </div>
                <div class="panel-body">
                	<table id="amc_data" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>ID</th>
								<th>AMC Name</th>
								<th>AMC Type</th>
								<th>Service Year</th>
								<th>No Of Sevice</th>
								<th>status</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div id="amcModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="amc_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add AMC</h4>
    				</div>
    				<div class="modal-body">
    					<div class="form-group">
    						<select name="amc_type" id="amc_type" class="form-control" required>
									<option value="">Select type</option>
									<?php echo fill_amc_type(); ?>
							</select>
    					</div>
    					<div class="form-group">
							<label>Enter AMC Name</label>
							<input type="text" name="amc_name" id="amc_name" class="form-control" required />
						</div>
						
						<div class="form-group">
							<label>Enter AMC Price</label>
							<input type="text" name="amc_price" id="amc_price" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter AMC Year</label>
							<input type="text" name="amc_service_year" id="amc_service_year" class="form-control" required />
						</div>	
						<div class="form-group">
							<label>Enter Total Service</label>
							<input type="text" name="n_of_service" id="n_of_service" class="form-control" required />
						</div>
						<div class="form-group">
                                <label>Remark</label>
                                <textarea name="amc_remark" id="amc_remark" class="form-control" rows="3" required></textarea>
                            </div>							
						
					
						
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="amc_id" id="amc_id" />
    					<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>

<script>
$(document).ready(function(){
	
	$('#add_button').click(function(){
		$('#amcModal').modal('show');
		$('#amc_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add AMC");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#amc_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"amc_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#amc_form')[0].reset();
				$('#amcModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				amcdataTable.ajax.reload();
			}
		})
	});

	
	$(document).on('click', '.update', function(){
		
		var amc_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:'amc_action.php',
			method:"POST",
			data:{amc_id:amc_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#amc_form')[0].reset();
				$('#amcModal').modal('show');
				$('#amc_type').val(data.amc_type);
				$('#amc_id').val(data.amc_id);
				$('#amc_name').val(data.amc_name);
				$('#amc_price').val(data.amc_price);
				$('#amc_service_year').val(data.amc_service_year);
				$('#n_of_service').val(data.n_of_service);
				$('#amc_remark').val(data.amc_remark);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit amc");
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});
	
	

	$(document).on('click','.delete', function(){
		var amc_id = $(this).attr("id");
		var amc_status  = $(this).data('status');
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"amc_action.php",
				method:"POST",
				data:{amc_id:amc_id, amc_status:amc_status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					amcdataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});
	
	var amcdataTable = $('#amc_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"amc_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[5,6,7],
				"orderable":false,
			},
		],
		"pageLength": 10
	});

});
</script>


<?php
include('footer.php');
?>