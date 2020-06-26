$(document).ready(function() {
   var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var type_id = $('#type_id').val();
	var company_id = $('#aj_company').val();
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"accounting/report_expense_list/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id+"&company_id="+company_id,
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": [{
			extend: 'csv',
			exportOptions: {
				columns: [ 1, 2, 3, 4]
			}
		}, {
			extend: 'excel',
			exportOptions: {
				columns: [ 1, 2, 3, 4]
			}
		}, {
			extend: 'pdfHtml5',
			exportOptions: {
				columns: [ 1, 2, 3, 4]
			}
		},], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_expense_type_reports/"+jQuery(this).val(), function(data, status){
			jQuery('#expense_type_ajax').html(data);
		});
	});	
	/* report */
	$("#hrm-form").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var type_id = $('#type_id').val();
		var company_id = $('#aj_company').val();
		jQuery.get(base_url+"/get_expense_footer/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id+"&company_id="+company_id, function(data, status){
			jQuery('#get_footer').html(data);
		});
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"accounting/report_expense_list/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id+"&company_id="+company_id,
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": [{
				extend: 'csv',
				exportOptions: {
					columns: [ 1, 2, 3, 4]
				}
			}, {
				extend: 'excel',
				exportOptions: {
					columns: [ 1, 2, 3, 4]
				}
			}, {
				extend: 'pdfHtml5',
				exportOptions: {
					columns: [ 1, 2, 3, 4]
				}
			},], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		Ladda.stopAll();
	});
});