$(document).ready(function() {	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=change_password&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$(".icon-spinner3").hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$(".icon-spinner3").hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});
