$(document).ready(function() {	
	// view
	$('.view-modal-annoucement').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var announcement_id = button.data('announcement_id');
		var modal = $(this);
	$.ajax({
		url : site_url+'/announcement/read/',
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_announcement&announcement_id='+announcement_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_announcement").html(response);
			}
		}
		});
	});
});