$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : base_url+"/project_list/",
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
jQuery("#aj_company").change(function(){
	jQuery.get(base_url+"/get_employees/?cid="+jQuery(this).val(), function(data, status){
		jQuery('#employee_ajax').html(data);
	});
});
jQuery("#aj_company").change(function(){
	jQuery.get(site_url+"quotes/get_employees/"+jQuery(this).val(), function(data, status){
		jQuery('#pemployee_ajax').html(data);
	});
});
jQuery("#aj_company").change(function(){
	jQuery.get(site_url+"quotes/get_co_employees/"+jQuery(this).val(), function(data, status){
		jQuery('#cemployee_ajax').html(data);
	});
});

$('#description').trumbowyg();
/* Delete data */
$("#delete_record").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=2&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				$('.delete-modal').modal('toggle');
				if(show_projects == 'list'){
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);	
				} else {
					toastr.success(JSON.result);
					window.location = '';
				}
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);	
				Ladda.stopAll();				
			}
		}
	});
});

// edit
$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var project_id = button.data('project_id');
	var modal = $(this);
$.ajax({
	url : base_url+"/read/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=project&project_id='+project_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal").html(response);
		}
	}
	});
});

// view
$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var project_id = button.data('project_id');
	var modal = $(this);
$.ajax({
	url : base_url+"/read/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=view_project&project_id='+project_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal_view").html(response);
		}
	}
	});
});

/* Add data */ /*Form Submit*/
$("#xin-form").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	$.ajax({
		type: "POST",
		url: base_url+"/add_project/",
		data: obj.serialize()+"&is_ajax=1&add_type=project&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
				Ladda.stopAll();
			} else {
				if(show_projects == 'list'){
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
					$('.icon-spinner3').hide();
					$('#xin-form')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
					$('.icon-spinner3').hide();
					$('#xin-form')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
					Ladda.stopAll();
					window.location = '';
				}
			}
		}
	});
});
});
$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});