$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"reports/employee_leave_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_employees_att/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});	
	/* attendance datewise report */
	$("#training_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var user_id = $('#employee_id').val();
		var company_id = $('#aj_company').val();
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"reports/employee_leave_list/"+start_date+"/"+end_date+"/"+user_id+"/"+company_id,
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		xin_table2.api().ajax.reload(function(){
			Ladda.stopAll();
		}, true);
	});
	$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var employee_id = button.data('employee_id');
	var leave_opt = button.data('leave_opt');
	var modal = $(this);
	$.ajax({
		url :  base_url+"/read_leave_details/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&type=leave_status&employee_id='+employee_id+'&leave_opt='+leave_opt,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
});