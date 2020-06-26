$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"payroll/salary_list/",
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
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);	
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);						
				}
			}
		});
	});
	
	// detail modal data payroll
	$('.payroll_template_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var employee_id = button.data('employee_id');
		var modal = $(this);
		$.ajax({
			url: site_url+'payroll/payroll_template_read/',
			type: "GET",
			data: 'jd=1&is_ajax=11&mode=not_paid&data=payroll_template&type=payroll_template&employee_id='+employee_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_payroll").html(response);
				}
			}
		});
	});
	
	// detail modal data  hourlywages
	$('.hourlywages_template_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var employee_id = button.data('employee_id');
		var modal = $(this);
		$.ajax({
			url: site_url+'payroll/hourlywage_template_read/',
			type: "GET",
			data: 'jd=1&is_ajax=11&mode=not_paid&data=hourlywages&type=hourlywages&employee_id='+employee_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_hourlywages").html(response);
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var hourly_rate_id = button.data('hourly_rate_id');
		var modal = $(this);
	$.ajax({
		url : site_url+"payroll/hourly_wage_read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=payroll&hourly_rate_id='+hourly_rate_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	/* Add data */ /*Form Submit*/
	$("#user_salary_template").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=payroll&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	/* Set Salary Details*/
	$("#set_salary_details").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		var employee_id = jQuery('#employee_id').val();
		var company_id = jQuery('#aj_company').val();
		$('.icon-spinner33').show();
		// On page load: datatable
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"payroll/salary_list/?employee_id="+employee_id+"&company_id="+company_id,
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
    	});
		xin_table2.api().ajax.reload(function(){ 
		}, true);
		$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
		$('.icon-spinner33').hide();
	});
});