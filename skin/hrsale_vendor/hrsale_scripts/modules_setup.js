$(document).ready(function(){
jQuery(".switch-setup-modules").change(function(){
	if($('#m-recruitment').is(':checked')){
		var mrecruitment = $("#m-recruitment").val();
	} else {
		var mrecruitment = '';
	}
	if($('#m-travel').is(':checked')){
		var mtravel = $("#m-travel").val();
	} else {
		var mtravel = '';
	}
	if($('#m-files').is(':checked')){
		var mfiles = $("#m-files").val();
	} else {
		var mfiles = '';
	}
	if($('#m-language').is(':checked')){
		var mlanguage = $("#m-language").val();
	} else {
		var mlanguage = '';
	}
	if($('#m-orgchart').is(':checked')){
		var morgchart = $("#m-orgchart").val();
	} else {
		var morgchart = '';
	}
	if($('#m-events').is(':checked')){
		var mevents = $("#m-events").val();
	} else {
		var mevents = '';
	}
	if($('#m-chatbox').is(':checked')){
		var chatbox = $("#m-chatbox").val();
	} else {
		var chatbox = '';
	}
	if($('#m-sub_departments').is(':checked')){
		var is_sub_departments = $("#m-sub_departments").val();
	} else {
		var is_sub_departments = '';
	}
	if($('#m-payroll').is(':checked')){
		var module_payroll = $("#m-payroll").val();
	} else {
		var module_payroll = '';
	}
	if($('#m-performance').is(':checked')){
		var module_performance = $("#m-performance").val();
	} else {
		var module_performance = '';
	}
	
	$.ajax({
		type: "GET",  url: site_url+"settings/modules_info/?is_ajax=2&type=modules_info&form=2&mrecruitment="+mrecruitment+"&mtravel="+mtravel+"&mfiles="+mfiles+"&mlanguage="+mlanguage+"&morgchart="+morgchart+"&mevents="+mevents+"&chatbox="+chatbox+'&is_sub_departments='+is_sub_departments+'&module_payroll='+module_payroll+'&module_performance='+module_performance,
		//data: order,
		success: function(response) {
			if (response.error != '') {
					toastr.error(response.error);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(response.result);	
					$('.save').prop('disabled', false);						
				}
		}
	});
});
});//jquery