<?php
//category.php
include('header.php');

?>

	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title">TAX List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#categoryModal" class="btn btn-success btn-xs">Add</button>   		
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-12 table-responsive">
                    		<table id="tax_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>GST NAME</th>
									<th>RATE</th>
									<th>Status</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr></thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="categoryModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="data_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Tax</h4>
    				</div>
    				<div class="modal-body">
    					<label>Enter Category Name</label>
						<input type="text" name="data_name" id="data_name" class="form-control" required />
    				</div>
					<div class="modal-body">
    					<label>Tax Rate</label>
						<input type="text" name="data_rate" id="data_rate" class="form-control" required />
    				</div>
					<div class="modal-footer">
    					<input type="hidden" name="data_id" id="data_id"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
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
		$('#data_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#data_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"tax_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#data_form')[0].reset();
				$('#categoryModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				categorydataTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '.update', function(){
		var tax_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"tax_action.php",
			method:"POST",
			data:{tax_id:tax_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#categoryModal').modal('show');
				$('#data_name').val(data.tax_name);
				$('#data_rate').val(data.tax_rate);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Tax");
				$('#data_id').val(tax_id);
				$('#action').val('Edit');
				$('#btn_action').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var tax_id = $(this).attr('id');
		var status = $(this).data("status");
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"tax_action.php",
				method:"POST",
				data:{tax_id:tax_id, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					categorydataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});
	
var categorydataTable = $('#tax_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"tax_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[3, 4],
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


				