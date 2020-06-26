$(document).ready(function() {
   var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var type_id = $('#type_id').val();
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"accounting/report_income_list/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id,
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": ['copy', 'csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	/* report */
	$("#hrm-form").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var type_id = $('#type_id').val();
		jQuery.get(base_url+"/get_income_footer/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id, function(data, status){
			jQuery('#get_footer').html(data);
		});
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"accounting/report_income_list/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id,
				type : 'GET'
			},
			dom: 'lBfrtip',
        	"buttons": ['copy', 'csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		Ladda.stopAll();
	});
});