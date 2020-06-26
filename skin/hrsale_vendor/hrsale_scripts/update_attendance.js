$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"timesheet/update_attendance_list/?employee_id="+$('#up_employee_id').val()+"&attendance_date="+$('#attendance_date').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
jQuery("#aj_company").change(function(){
	jQuery.get(base_url+"/get_update_employees/"+jQuery(this).val(), function(data, status){
		jQuery('#employee_ajax').html(data);
	});
});



$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 


/* update_attendance_report */
$("#update_attendance_report").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
	var employee_id = $('#up_employee_id').val();
	var attendance_date = $('#attendance_date').val();
	var xin_table2 = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/update_attendance_list/?employee_id="+employee_id+"&attendance_date="+attendance_date,
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	$('#add_attendance_btn').show();
	toastr.success('Request Submit.');
	xin_table2.api().ajax.reload(function(){		
	Ladda.stopAll();
	}, true);
});
	
/* Delete data */
$("#delete_record").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=true&type=delete&form="+action,
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

// add attendance
$('.add-modal-data').on('show.bs.modal', function (event) {
	var employee_id = $('#up_employee_id').val();
	var button = $(event.relatedTarget);
	var modal = $(this);
	$.ajax({
		url: site_url+'timesheet/update_attendance_add/',
		type: "GET",
		data: 'jd=1&is_ajax=9&mode=modal&data=add_attendance&type=add_attendance&employee_id='+employee_id,
		success: function (response) {
			if(response) {
				$("#add_ajax_modal").html(response);
			}
		}
	});
});

// edit
$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var attendance_id = button.data('attendance_id');
	var modal = $(this);
$.ajax({
	url : site_url+"timesheet/read/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=attendance&type=attendance&attendance_id='+attendance_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal").html(response);
		}
	}
	});
});
});
$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',site_url+'timesheet/delete_attendance/'+$(this).data('record-id'))+'/';
});
