$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"payroll/payment_history_list/",
		type : 'GET'
	},
	dom: 'lBfrtip',
		"buttons": [{
			extend: 'csv',
			exportOptions: {
				columns: [ 1, 2, 3, 4, 5,6]
			}
		}, {
			extend: 'excel',
			exportOptions: {
				columns: [ 1, 2, 3, 4, 5,6]
			}
		}, {
			extend: 'pdfHtml5',
			exportOptions: {
				columns: [ 1, 2, 3, 4, 5,6]
			}
		},], // colvis > if needed
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	
jQuery("#aj_company").change(function(){
	jQuery.get(base_url+"/get_company_plocations/"+jQuery(this).val(), function(data, status){
		jQuery('#location_ajax').html(data);
	});
});
$("#ihr_report").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
	//var attendance_date = $('#attendance_date').val();
	//var date_format = $('#date_format').val();
		//$('#att_date').html(date_format);
		 var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"payroll/payment_history_list/?ihr=true&company_id="+$('#aj_company').val()+"&location_id="+$('#aj_location_id').val()+"&department_id="+$('#aj_subdepartments').val()+"&salary_month="+$('#salary_month').val(),
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
// detail modal data
$('.detail_modal_data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var employee_id = button.data('employee_id');
	var pay_id = button.data('pay_id');
	var modal = $(this);
	$.ajax({
		url: site_url+'payroll/make_payment_view/',
		type: "GET",
		data: 'jd=1&is_ajax=11&mode=modal&data=pay_payment&type=pay_payment&emp_id='+employee_id+'&pay_id='+pay_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_details").html(response);
			}
		}
	});
});
});