$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : base_url+"/custom_fields_list/",
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
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
	var custom_field_id = button.data('custom_field_id');
	var modal = $(this);
	$.ajax({
		url : base_url+"/read_info/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=custom_field&custom_field_id='+custom_field_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
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
	//$('#hrload-img').show();
	//toastr.info(processing_request);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=custom_field&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				//toastr.clear();
				//$('#hrload-img').hide();
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
				Ladda.stopAll();
			} else {
				xin_table.api().ajax.reload(function(){ 
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('#xin-form')[0].reset(); // To reset form fields
				$('.add-form').removeClass('show');
				$('.select2-selection__rendered').html('--Select--');
				$("#newlink").empty();
				$('#add_items').hide();
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
$("#attribute_type").change(function(e){
	if($(this).val() == 'select' || $(this).val() == 'multiselect'){
		$('#add_items').show();
		$('#newlink').show();
		new_link();
	} else {
		$('#add_items').hide();
		$('#newlink').hide();
	}
});	
	
});
$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
/*
This script is identical to the above JavaScript function.
*/
var ct = 1;
function new_link()
{
	ct++;
	var div1 = document.createElement('div');
	div1.id = ct;
	// link to delete extended form elements
	var delLink = '<div class="row"><div class="col-md-6"><div class="form-group"><label for="field_label">&nbsp;</label><div><a href="javascript:delIt('+ ct +')"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button></a></div></div></div></div></div>';
	div1.innerHTML = document.getElementById('newlinktpl').innerHTML + delLink;
	document.getElementById('newlink').appendChild(div1);
}
// function to delete the newly added set of elements
function delIt(eleId)
{
	d = document;
	var ele = d.getElementById(eleId);
	var parentEle = d.getElementById('newlink');
	parentEle.removeChild(ele);
}
