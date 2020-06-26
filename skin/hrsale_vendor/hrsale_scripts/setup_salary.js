$(document).ready(function(){			
	
	// get data
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'salary_allowance'){
			var field_add = '&data=e_salary_allowance&type=e_salary_allowance&';
		} else if(field_tpe == 'salary_loan'){
			var field_add = '&data=e_salary_loan&type=e_salary_loan&';
		} else if(field_tpe == 'emp_overtime'){
			var field_add = '&data=emp_overtime_info&type=emp_overtime_info&';
		} else if(field_tpe == 'salary_commissions'){
			var field_add = '&data=salary_commissions_info&type=salary_commissions_info&';
		} else if(field_tpe == 'salary_statutory_deductions'){
			var field_add = '&data=salary_statutory_deductions_info&type=salary_statutory_deductions_info&';
		} else if(field_tpe == 'salary_other_payments'){
			var field_add = '&data=salary_other_payments_info&type=salary_other_payments_info&';
		} else if(field_tpe == 'security_level'){
			var field_add = '&data=esecurity_level_info&type=esecurity_level_info&';
		}
		var modal = $(this);
		$.ajax({
			url: site_url+'employees/dialog_'+field_tpe+'/',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
   });
   
   // Month & Year
	$('.ln_month_year').datepicker({
	changeMonth: true,
	changeYear: true,
	showButtonPanel: true,
	dateFormat:'yy-mm',
	yearRange: '1900:' + (new Date().getFullYear() + 15),
	beforeShow: function(input) {
		$(input).datepicker("widget").addClass('hide-calendar');
	},
	onClose: function(dateText, inst) {
		var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
		var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		$(this).datepicker('setDate', new Date(year, month, 1));
		$(this).datepicker('widget').removeClass('hide-calendar');
		$(this).datepicker('widget').hide();
	}
		
	}); 
	// get current val
	$(".basic_salary").keyup(function(e){
		var to_currency_rate = $('#to_currency_rate').val();
		var curr_val = $(this).val();
		var final_val = to_currency_rate * curr_val;
		var float_val = final_val.toFixed(2);
		$('#current_cur_val').html(float_val);
	});	
	$(".daily_wages").keyup(function(e){
		var to_currency_rate = $('#to_currency_rate').val();
		var curr_val = $(this).val();
		var final_val = to_currency_rate * curr_val;
		var float_val = final_val.toFixed(2);
		$('#current_cur_val2').html(float_val);
	});		
	// On page load 
	var xin_table_emp_overtime = $('#xin_table_emp_overtime').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/salary_overtime/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	// On page load 
	var xin_table_allowances_ad = $('#xin_table_all_allowances').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/salary_all_allowances/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	var xin_table_commissions_ad = $('#xin_table_all_commissions').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/salary_all_commissions/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	var xin_table_statutory_deductions_ad = $('#xin_table_all_statutory_deductions').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/salary_all_statutory_deductions/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	var xin_table_other_payments_ad = $('#xin_table_all_other_payments').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/salary_all_other_payments/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	// On page load 
	var xin_table_all_deductions = $('#xin_table_all_deductions').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/salary_all_deductions/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });		
	/* */
	$("#employee_update_salary").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=employee_update_salary&type=employee_update_salary&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					Ladda.stopAll();
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	// add loan
	$("#add_loan_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=loan_info&type=loan_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					xin_table_all_deductions.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#add_loan_info')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add info */
	jQuery("#employee_update_allowance").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=employee_update_allowance&type=employee_update_allowance&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_allowances_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#employee_update_allowance')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	/* */
	jQuery("#employee_update_commissions").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=employee_update_commissions&type=employee_update_commissions&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_commissions_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#employee_update_commissions')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#statutory_deductions_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=statutory_deductions_info&type=statutory_deductions_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_statutory_deductions_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#statutory_deductions_info')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#other_payments_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=other_payments_info&type=other_payments_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_other_payments_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#other_payments_info')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	/* */
	$("#overtime_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=emp_overtime&type=emp_overtime&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					xin_table_emp_overtime.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#overtime_info')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});
   /* Delete data */
	$("#delete_record").submit(function(e){
	var tk_type = $('#token_type').val();
	if(tk_type == 'all_allowances'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_salary_allowance&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'all_deductions'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_salary_loan&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'emp_overtime'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_salary_overtime&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'all_commissions'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_all_commissions&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'all_statutory_deductions'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_all_statutory_deductions&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'all_other_payments'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_all_other_payments&';
		var tb_name = 'xin_table_'+tk_type;
	}
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			url: e.target.action,
			type: "post",
			data: '?'+obj.serialize()+field_add+"form="+action,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#'+tb_name).dataTable().api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					
				}
			}
		});
	});   
   /// delete a record
	$( document ).on( "click", ".delete", function() {
		$('input[name=_token]').val($(this).data('record-id'));
		$('input[name=token_type]').val($(this).data('token_type'));
		$('#delete_record').attr('action',site_url+'employees/delete_'+$(this).data('token_type')+'/'+$(this).data('record-id'));
	});
});	
$(document).ready(function(){
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		
	$('.cont_date').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: '1990:' + (new Date().getFullYear() + 10),
	});	
	
});