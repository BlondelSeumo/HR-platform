$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"settings/email_template_list/",
            type : 'GET'
        },
		"iDisplayLength": 50,
		"aLengthMenu": [[50, 60, 80, 100, -1], [50, 60, 80, 100, "All"]],
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
		
	// edit
	$('#modals-slide').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var template_id = button.data('template_id');
		var modal = $(this);
	$.ajax({
		url : site_url+"settings/read_tempalte/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=email_template&template_id='+template_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});
