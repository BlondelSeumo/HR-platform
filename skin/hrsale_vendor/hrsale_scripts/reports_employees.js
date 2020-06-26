$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"reports/report_employees_list/0/0/0/",
            type : 'GET'
        },
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// get departments
	jQuery("#aj_company").change(function(){
		var c_id = jQuery(this).val();
		jQuery.get(base_url+"/get_departments/"+c_id, function(data, status){
			jQuery('#department_ajax').html(data);			
		});
		/*if(c_id == 0){
			jQuery.get(base_url+"/designation/"+jQuery(this).val(), function(data, status){
				jQuery('#designation_ajax').html(data);
			});
		}*/
	});
		
	/* projects report */
	$("#employee_reports").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var company_id = $('#aj_company').val();
		var department_id = $('#aj_department').val();
		var designation_id = $('#designation_id').val();
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"reports/report_employees_list/"+company_id+"/"+department_id+"/"+designation_id+"/",
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		xin_table2.api().ajax.reload(function(){ Ladda.stopAll(); }, true);
	});
});