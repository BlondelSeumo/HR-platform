$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/last_login_list/",
            type : 'GET'
        },
    });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
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
	$("#ihr_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		//$('#hrload-img').show();
		//toastr.info(processing_request);
			 var xin_table2 = $('#xin_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : site_url+"employees_last_login/last_login_list/?ihr=true&company_id="+$('#filter_company').val()+"&location_id="+$('#filter_location').val()+"&department_id="+$('#filter_department').val()+"&designation_id="+$('#filter_designation').val(),
					type : 'GET'
				},
				"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();          
				}
			});
			xin_table2.api().ajax.reload(function(){ toastr.success(request_submitted);}, true);
	});
});