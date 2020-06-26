$(document).ready(function(){

// On page load: datatable
 var xin_comment_table = $('#xin_comment_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"timesheet/comments_list/"+$('#comment_task_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});

var xin_attachment_table = $('#xin_attachment_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"timesheet/attachment_list/"+$('#comment_task_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
	
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
/* update task employees */
$("#assign_task").submit(function(e){
	
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=4&type=task_user&view=user&form="+action,
		cache: false,
		success: function (JSON) {
			jQuery.get(site_url+"timesheet/task_users/"+jQuery('#task_id').val(), function(data, status){
				jQuery('#all_employees_list').html(data);
			});
			$('.save').prop('disabled', false);
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);		
				Ladda.stopAll();		
			}
		}
	});
});

/* Edit task data */
$("#update_status").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=3&type=update_status&update=1&view=task&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);		
				Ladda.stopAll();		
			}
		}
	});
});

/* Edit comment */
$("#set_comment").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=5&add_type=set_comment&update=1&view=task&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				xin_comment_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
					Ladda.stopAll();
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#xin_comment').val('');
				$('.save').prop('disabled', false);
				
			}
		}
	});
});

/* Delete ticket comment */
$("#delete_record").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=task_comment&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				$('.delete-modal').modal('toggle');
				xin_comment_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			}
		}
	});
});

/* Delete task file */
$("#delete_record_f").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=8&data=task_attachment&type=delete&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				$('.delete-modal-file').modal('toggle');
				xin_attachment_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);	
				Ladda.stopAll();			
			}
		}
	});
});

/* Edit note */
$("#add_note").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=9&type=add_note&update=2&view=note&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
				
			}
		}
	});
});
									
/* Add task file */ /*Form Submit*/
$("#add_attachment").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 7);
	fd.append("add_type", 'dfile_attachment');
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
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				xin_attachment_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#add_attachment')[0].reset(); // To reset form fields
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		},
		error: function() 
		{
			toastr.error('Bug. Something went wrong, please try again.');
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.save').prop('disabled', false);
			Ladda.stopAll();
		} 	        
   });
});	
}); // jquery load
	
/// delete a comment
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'timesheet/comment_delete/'+$(this).data('record-id'));
});
/// delete a file
$( document ).on( "click", ".delete-file", function() {
	$('input[name=_token_del_file]').val($(this).data('record-id'));
	$('#delete_record_f').attr('action',site_url+'timesheet/attachment_delete/'+$(this).data('record-id'));
});