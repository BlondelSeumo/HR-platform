$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"reports/empdtwise_attendance_list/",
            type : 'GET'
        },
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
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
	$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var ipaddress = button.data('ipaddress');
	var modal = $(this);
	$.ajax({
		url :  site_url+"/timesheet/read_map_info/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_map&type=view_map&ipaddress='+ipaddress,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
	
	/* attendance datewise report */
	$("#attendance_datewise_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var user_id = $('#employee_id').val();
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"reports/employee_date_wise_list/?start_date="+start_date+"&end_date="+end_date+"&user_id="+user_id,
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
});