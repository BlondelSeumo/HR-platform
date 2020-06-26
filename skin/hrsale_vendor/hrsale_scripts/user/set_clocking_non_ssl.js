$(document).ready(function(){
	
	/* Clock In/Out */
	$("#set_clocking").submit(function(e){
		e.preventDefault();
		var clock_state = '';
		var obj = $(this), action = obj.attr('name');	
		// Get the coordinates of the current possition.
		var lat = 1;
		var lng = 1;
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=set_clocking&latitude="+lat+"&longitude="+lng+"&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					window.location = '';
					Ladda.stopAll();
				}
			}
		});
	});
});