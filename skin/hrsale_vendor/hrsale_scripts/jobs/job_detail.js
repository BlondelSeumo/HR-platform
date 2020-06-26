$(document).ready(function() {	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=login&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$(".icon-spinner3").hide();
					$('.save').prop('disabled', false);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					toastr.success(JSON.result);
					$(".icon-spinner3").hide();
					$('.save').prop('disabled', false);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					window.location = '';
				}
			}
		});
	});
	$('#cover_letter').trumbowyg();
	/* Edit data */
		$("#apply").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 6);
		fd.append("add_type", 'apply_job');
		fd.append("data", 'apply_job');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					window.location = '';
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('.save').prop('disabled', false);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			} 	        
	   });
	});
});
