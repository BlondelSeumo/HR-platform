$(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 

		/* Edit data */
		$("#edit_user").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'user');
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
					} else {
						toastr.success(JSON.result);
						$('.save').prop('disabled', false);
					}
				},
				error: function() 
				{
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} 	        
		   });
		});
		/* Update profile picture */
	$("#profile_background").submit(function(e){
		var fd = new FormData(this);
		$('.icon-spinner3').show();
		var user_id = $('#user_id').val();
		var session_id = $('#session_id').val();
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'profile_background');
		fd.append("data", 'profile_background');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		$.ajax({
			url: site_url+'users/profile_background/',
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('#remove_file').show();
					$('.icon-spinner3').hide();
					$("#remove_profile_picture").attr('checked', false);
					$('#u_file').attr("src", JSON.img);
					if(user_id == session_id){
						$('.user_avatar').attr("src", JSON.img);
					}
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} 	        
	   });
	});
	});	