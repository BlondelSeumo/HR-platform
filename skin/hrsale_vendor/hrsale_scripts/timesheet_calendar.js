$(document).ready(function() {	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
});
$(document).ready(function() { 
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_update_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
});