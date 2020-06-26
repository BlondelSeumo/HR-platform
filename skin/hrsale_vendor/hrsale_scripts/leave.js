$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"timesheet/leave_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	var xin_my_team_table = $('#xin_my_team_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/my_team_leave_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
		
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_leave_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	//employee_id
	//filter
	jQuery("#aj_companyf").change(function(){
		jQuery.get(site_url+"payroll/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajaxf').html(data);
		});
	});
	$('#remarks').trumbowyg();
	$("#ihr_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
			 var xin_table2 = $('#xin_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : site_url+"timesheet/leave_list/?ihr=true&company_id="+$('#aj_companyf').val()+"&employee_id="+$('#employee_id').val()+"&status="+$('#status').val(),
					type : 'GET'
				},
				"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();          
				}
			});
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
			data: obj.serialize()+"&is_ajax=2&type=delete&form="+action,
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
		var leave_id = button.data('leave_id');
		var modal = $(this);
	$.ajax({
		url : site_url+"timesheet/read_leave_record/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=leave&leave_id='+leave_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'leave');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
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
						$('.icon-spinner3').hide();
						Ladda.stopAll();
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} 	        
	   });
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'timesheet/delete_leave/'+$(this).data('record-id'));
});