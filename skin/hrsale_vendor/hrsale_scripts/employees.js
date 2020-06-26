$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/employees_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	var xin_my_team_table = $('#xin_my_team_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/myteam_employees_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var warning_id = button.data('warning_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=warning&warning_id='+warning_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	$("#ihr_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		 var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"employees/employees_list/?ihr=true&company_id="+$('#filter_company').val()+"&location_id="+$('#filter_location').val()+"&department_id="+$('#filter_department').val()+"&designation_id="+$('#filter_designation').val(),
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		xin_table2.api().ajax.reload(function(){
			toastr.success(request_submitted);
			Ladda.stopAll();
		}, true);
		
	});
	jQuery("#aj_company_emp").change(function(){
		jQuery.get(base_url+"/get_company_elocations/"+jQuery(this).val(), function(data, status){
			jQuery('#location_ajax').html(data);
		});
		jQuery.get(base_url+"/get_company_office_shifts/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_office_shift').html(data);
		});
	});
	jQuery("#filter_company").change(function(){
		if(jQuery(this).val() == 0){
			jQuery('#filter_location').prop('selectedIndex', 0);	
			jQuery('#filter_department').prop('selectedIndex', 0);
			jQuery('#filter_designation').prop('selectedIndex', 0);
		}	
		jQuery.get(site_url+"employees/filter_company_flocations/"+jQuery(this).val(), function(data, status){
		jQuery('#location_ajaxflt').html(data);
		});
	});
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'employee');
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
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.icon-spinner3').hide();
					xin_table.api().ajax.reload(function(){ 
						
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
					$('#xin-form')[0].reset(); // To reset form fields
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
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);							
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
 $( document ).on( "click", ".statusinfo", function() {
	
	jQuery.get(base_url+"/update_status_info/"+jQuery(this).data('status')+'/'+jQuery(this).data('user-id'), function(data, status){
		var xin_table = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : base_url+"/employees_list/",
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		xin_table.api().ajax.reload(function(){ 

			toastr.success(data);
		}, true);
	});
});