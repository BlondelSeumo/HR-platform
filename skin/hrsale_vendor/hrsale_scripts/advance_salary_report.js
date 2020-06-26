$(document).ready(function() {
	
	 var xin_table_report = $('#xin_table_report').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+'/advance_salary_report_list/',
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
		
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var employee_id = button.data('employee_id');
		var modal = $(this);
	$.ajax({
		url :  base_url+"/advance_salary_report_read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_advance_salary_report&employee_id='+employee_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});