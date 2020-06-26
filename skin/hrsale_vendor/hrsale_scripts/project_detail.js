function projectTotalHours() {
	var startDate = $('#start_date').val();
	var endDate = $('#end_date').val();
	var startTime = $("#start_time").val();
	var endTime = $("#end_time").val();

	var timeStart = new Date(startDate + " " + startTime);
	var timeEnd = new Date(endDate + " " + endTime);

	var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds

	var minutes = diff % 60;
	var hours = (diff - minutes) / 60;

	if (hours < 0 || minutes < 0) {
		var numberOfDaysToAdd = 1;
		timeEnd.setDate(timeEnd.getDate() + numberOfDaysToAdd);
		var dd = timeEnd.getDate();

		if (dd < 10) {
			dd = "0" + dd;
		}

		var mm = timeEnd.getMonth() + 1;

		if (mm < 10) {
			mm = "0" + mm;
		}
		projectTotalHours();
	} else {
		$('#total_time').html(hours + "Hrs " + minutes + "Mins");
		$('#total_hours').val(hours+':'+minutes);
	}
}
$(document).ready(function() {

var xin_discussion_table = $('#xin_discussion_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"project/discussion_list/"+$('#tproject_id').val(),
		type : 'GET'
	},
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});

var xin_bug_table = $('#xin_bug_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"project/bug_list/"+$('#tproject_id').val(),
		type : 'GET'
	},
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
var xin_attachment_table = $('#xin_attachment_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"project/attachment_list/"+$('#f_project_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
//$('#description').trumbowyg();
//$('#vdescription').trumbowyg();
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

/* update task employees */
$("#assign_project").submit(function(e){
	
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=4&type=project_user&view=user&form="+action,
		cache: false,
		success: function (JSON) {
			jQuery.get(site_url+"project/project_users/"+jQuery('#project_id').val(), function(data, status){
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

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('config');
		var profile_block = $(this).data('config-block');
		$('.nav-tabs-link').removeClass('active');
		$('.current-tab').hide();
		$('#pj_data_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});

$("#set_discussion").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 1);
	fd.append("add_type", 'set_discussion');
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
				xin_discussion_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#xin_message').val('');
				$('#set_discussion')[0].reset(); // To reset form fields
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.save').prop('disabled', false);
			Ladda.stopAll();
		} 	        
   });
});

$("#set_bug").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 1);
	fd.append("add_type", 'set_bug');
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
				xin_bug_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#set_bug')[0].reset(); // To reset form fields
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.save').prop('disabled', false);
			Ladda.stopAll();
		} 	        
   });
});

/* Add project file */ /*Form Submit*/
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

$("#delete_record").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=bug&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				$('.delete-modal').modal('toggle');
				xin_bug_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			}
		}
	});
});

// edit
$('.add-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var bug_id = button.data('bug_id');
	var modal = $(this);
$.ajax({
	url :  base_url+"/bug_read/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=bug&bug_id='+bug_id,
	success: function (response) {
		if(response) {
			$("#add_ajax_modal").html(response);
		}
	}
	});
});

$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var task_id = button.data('task_id');
	var mname = button.data('mname');
	var modal = $(this);
	$.ajax({
	url : site_url+"timesheet/read_task_record/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=project_task&task_id='+task_id+"&mname="+mname,
	success: function (response) {
		if(response) {
			$("#ajax_modal").html(response);
		}
	}
	});
});
$('.edit-modal-variation-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var variation_id = button.data('variation_id');
	var mname = button.data('mname');
	var modal = $(this);
	$.ajax({
	url : site_url+"timesheet/read_variation_record/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=project_variation&variation_id='+variation_id+"&mname="+mname,
	success: function (response) {
		if(response) {
			$("#ajax_variation_modal").html(response);
		}
	}
	});
});
$('.edit-modal-timelog-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var timelogs_id = button.data('timelogs_id');
	var modal = $(this);
	$.ajax({
	url : site_url+"project/read_timelog_record/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=project_timelog&timelogs_id='+timelogs_id,
	success: function (response) {
		if(response) {
			$("#ajax_timelog_modal").html(response);
		}
	}
	});
});

var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"timesheet/project_task_list/"+$('#tproject_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
var xin_variation_table = $('#xin_variation_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"timesheet/project_variation_list/"+$('#tproject_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
var xin_timelogs_table = $('#xin_timelogs_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"project/project_timelogs_list/"+$('#f_project_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});

$("#xin-form").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=task&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				xin_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('.icon-spinner3').hide();
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#xin-form')[0].reset(); // To reset form fields
				$('.add-form').removeClass('show');
				$('.select2-selection__rendered').html('');
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
$("#xin-variation-form").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=variation&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				xin_variation_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('.icon-spinner3').hide();
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#xin-variation-form')[0].reset(); // To reset form fields
				$('.add-form').removeClass('show');
				$('.select2-selection__rendered').html('--Select--');
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
$("#add_timelog").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=timelog&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				xin_timelogs_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('.icon-spinner3').hide();
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#add_timelog')[0].reset(); // To reset form fields
				$('.add-form').removeClass('show');
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
$("#delete_record_f").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=8&data=attachment&type=delete&form="+action,
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

$("#delete_record_t").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=8&data=task&type=delete&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				$('.delete-modal-task').modal('toggle');
				xin_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			}
		}
	});
});
$("#delete_record_v").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=8&data=task&type=delete&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				$('.delete-modal-variation').modal('toggle');
				xin_variation_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			}
		}
	});
});
$("#redelete_timelog").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=8&data=timelog&type=delete&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				$('.delete-modal-timelogs').modal('toggle');
				xin_timelogs_table.api().ajax.reload(function(){ 
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

// Clock  
var input = $('.timepicker').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now',
	afterDone: function() {
		var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var startTime = $("#start_time").val();
        var endTime = $("#end_time").val();
		if(startDate!='' && endDate!='' && startTime!='' && endTime!='') {
			projectTotalHours();
		}
	}
});
	$('.user_timelog_date').datepicker({
		minDate: -1,
		maxDate: "+0D",
		dateFormat:'yy-mm-dd',
	});
	$('.timelog_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
});
jQuery(document).on('click keyup change','.timepicker,.date', function () {
	var startDate = $('#start_date').val();
	var endDate = $('#end_date').val();
	var startTime = $("#start_time").val();
	var endTime = $("#end_time").val();
	if(startDate!='' && endDate!='' && startTime!='' && endTime!='') {
		projectTotalHours();
	}
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'project/bug_delete/'+$(this).data('record-id'));
});
$( document ).on( "click", ".fidelete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record_f').attr('action',site_url+'project/attachment_delete/'+$(this).data('record-id'));
});
$( document ).on( "click", ".delete-task", function() {
	$('input[name=_token_del_file]').val($(this).data('record-id'));
	$('#delete_record_t').attr('action',site_url+'timesheet/delete_task/'+$(this).data('record-id'));
});
$( document ).on( "click", ".delete-variation", function() {
	$('input[name=_token_del_file]').val($(this).data('record-id'));
	$('#delete_record_v').attr('action',site_url+'timesheet/delete_variation/'+$(this).data('record-id'));
});
$( document ).on( "click", ".delete-timelog", function() {
	$('input[name=_token_timelog]').val($(this).data('record-id'));
	$('#redelete_timelog').attr('action',site_url+'project/delete_timelog/'+$(this).data('record-id'));
});