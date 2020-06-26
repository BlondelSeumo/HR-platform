$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"employer/employer_job_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		//$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					$('.delete-modal').modal('toggle');
					toastr.success(JSON.result);	
					window.location = '';						
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'employer/delete_job/'+$(this).data('record-id'));
});
$( document ).on( "click", ".job-edit", function() {
	var id = $(this).data('record-id');
	window.location = site_url + 'employer/edit_job/'+ id;
});
$( document ).on( "click", ".job-view", function() {
	var id = $(this).data('record-id');
	window.location = site_url + 'jobs/detail/'+ id;
});