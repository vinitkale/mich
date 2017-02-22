<div class="container">
    <div class="row" style="margin-top:5%;margin-bottom:5%;">
    <div class="col-md-12">
	<table class="table table-responsive" id="customers_list">
	    <thead>
	    <th>#</th>
	    <th>First Name</th>
	    <th>Last Name</th>
	    <th>Email</th>
	    <th>Action</th>
	    </thead>
	    <tbody>
		
	    </tbody>
	</table>
    </div>
    </div>
		</div>
<script>
 $(document).ready(function(){
     
      $('#customers_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "<?php echo base_url(); ?>/home/getCustomers", "bDeferRender": true,
        "aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, $("#sAll").val()]],
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"bSortable": true, "sClass": "aligncenter", "aTargets": [1]},
            {"sClass": "name aligncenter", "aTargets": [2]},
            {"sClass": "", "aTargets": [3]},
            {"sClass": "", "aTargets": [4]},
        ]
    })
 })
</script>