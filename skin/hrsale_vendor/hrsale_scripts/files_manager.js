$(document).ready(function(){			

 var xin_table_files = $('#xin_table_files').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+'files/files_list/dId/'+$('#depval').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
	
/* Update */
$("#xin-form").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 2);
	fd.append("type", 'file_info');
	fd.append("data", 'file_info');
	fd.append("form", action);
	var dep_id = $('#department_id').val();
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
				var xin_table_files2 = $('#xin_table_files').dataTable({
					"bDestroy": true,
					"ajax": {
						url : site_url+'files/files_list/dId/'+dep_id,
						type : 'GET'
					},
					"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();          
					}
				});
				xin_table_files2.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.select2-selection__rendered').html('Choose Department');
				$('#xin-form')[0].reset();
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
			} else {
				$('.delete-modal').modal('toggle');
				xin_table_files.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);		
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);					
			}
		}
	});
});

// edit
$('.payroll_template_modal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var file_id = button.data('file_id');
	var modal = $(this);
$.ajax({
	url :  site_url+"files/read/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=file_manager&file_id='+file_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal_payroll").html(response);
		}
	}
	});
});

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 

// get department files
$(".department-file").click(function(){
    var dep_id = $(this).data('department-id');
	var xin_table_files = $('#xin_table_files').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+'files/files_list/dId/'+dep_id,
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
	});
});

$(".not-allowed").click(function(){
	toastr.error('You can access only own department files!!!');
});
$(".nav-tabs-link").click(function(){
	var config_id = $(this).data('config');
	var config_block = $(this).data('config-block');
	$('.nav-tabs-link').removeClass('active');
	$('#config_'+config_id).addClass('active');
});

});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'files/delete/'+$(this).data('record-id'));
});