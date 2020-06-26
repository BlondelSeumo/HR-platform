function refreshChatUsers() {
			
		  $.ajax({
			url: site_url + "chat/refresh_chat_users_msg/",
			type: 'GET',
			dataType: 'html',
			success: function(data) {
			  jQuery('#msgs_count').html(data);
						
			},
			error: function() {
			  
			}
		  });
		  $.ajax({
			url: site_url + "chat/refresh_chat_users/",
			type: 'GET',
			dataType: 'html',
			success: function(data) {
			  jQuery('#chat_users').html(data);
			  setTimeout(refreshChatUsers, 5000);
						
			},
			error: function() {
			  
			}
		  });
	}
	
	$(document).ready(function(){
	//
	$(".online-status").click(function(e){	
	
		var status_id = $(this).data('status-id');
		var status_title = $(this).data('status-title');
		var status_avatar = $(this).data('avatar-status');
		 $.ajax({
			url: site_url + "chat/change_status/?status_id="+status_id,
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				jQuery('#hr_status').html(status_title);
				jQuery('.current-status').removeClass('avatar-online avatar-busy avatar-away');
				jQuery('.current-status').addClass(status_avatar);
				
			},
			error: function() {
			  alert('error');
			}
		});
	});
	
	// chatbox > single
	$('#chatbox-single').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var from_id = button.data('from-id');
		var to_id = button.data('to-id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/chat_read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=chat&from_id='+from_id+'&to_id='+to_id,
		success: function (response) {
			if(response) {
				$("#chat_modal").html(response);
				$("#message_content").focus();
				jQuery('.chat-app-window1').animate({ scrollTop: $('.chat-app-window1').prop("scrollHeight")}, 0);
			}
		}
		});
	});
	// chatbox > department
	$('#chatbox-department-group').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var from_id = button.data('from-id');
		var chat_group_department_id = button.data('chat_group_department_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/department_chat_read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=chat&from_id='+from_id+'&chat_group_department_id='+chat_group_department_id,
		success: function (response) {
			if(response) {
				$("#chatgroup_department_modal").html(response);
				$("#dep_message_content").focus();
				jQuery('.chat-app-window1').animate({ scrollTop: $('.chat-app-window1').prop("scrollHeight")}, 0);
			}
		}
		});
	});
	// chatbox > location
	$('#chatbox-location-group').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var from_id = button.data('from-id');
		var chat_group_location_id = button.data('chat_group_location_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/location_chat_read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=chat&from_id='+from_id+'&chat_group_location_id='+chat_group_location_id,
		success: function (response) {
			if(response) {
				$("#chatgroup_location_modal").html(response);
				$("#location_message_content").focus();
				jQuery('.chat-app-window1').animate({ scrollTop: $('.chat-app-window1').prop("scrollHeight")}, 0);
			}
		}
		});
	});
	
	setTimeout(refreshChatUsers, 5000);	
	
	

});