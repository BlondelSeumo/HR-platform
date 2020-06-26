$(document).ready(function(){	
	// get data
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var job_id = button.data('job_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/apply",
		type: "GET",
		data: 'jd=1&is_ajax=app_job&mode=modal&data=apply_job&type=apply_job&job_id='+job_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
	});
	});
});