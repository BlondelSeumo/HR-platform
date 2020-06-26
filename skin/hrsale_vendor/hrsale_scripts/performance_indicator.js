$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : base_url+"/performance_indicator_list/",
		type : 'GET'
	},
	dom: 'lBfrtip',
	"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
jQuery("#aj_company").change(function(){
	jQuery.get(base_url+"/get_designations/"+jQuery(this).val(), function(data, status){
		jQuery('#designation_ajax').html(data);
	});
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 

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
				xin_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);	
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);		
				Ladda.stopAll();				
			}
		}
	});
});

// edit
$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var performance_indicator_id = button.data('performance_indicator_id');
	var modal = $(this);
$.ajax({
	url : base_url+"/read/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=indicator&performance_indicator_id='+performance_indicator_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal").html(response);
		}
	}
	});
});

// view and get data
$('.view-modal-data-bg').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var p_indicator_id = button.data('p_indicator_id');
	var modal = $(this);
$.ajax({
	url: base_url+'/read/',
	type: "GET",
	data: 'jd=1&is_ajax=4&mode=modal&data=view_indicator&type=view_indicator&performance_indicator_id='+p_indicator_id,
	success: function (response) {
		if(response) {
			$("#pajax_modal_view").html(response);
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
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=indicator&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
				Ladda.stopAll();
			} else {
				xin_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.add-form').removeClass('show');
				$('.select2-selection__rendered').html('--Select--');
				$('#xin-form')[0].reset(); // To reset form fields
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
});
$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
