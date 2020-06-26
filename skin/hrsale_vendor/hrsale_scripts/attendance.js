$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"timesheet/attendance_list/?attendance_date="+$('#attendance_date').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });
jQuery("#aj_company").change(function(){
	jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
		jQuery('#employee_ajax').html(data);
	});
});
$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var ipaddress = button.data('ipaddress');
	var uid = button.data('uid');
	var start_date = button.data('start_date');
	var att_type = button.data('att_type');
	var modal = $(this);
$.ajax({
	url :  site_url+"timesheet/read_map_info/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=view_map&type=view_map&ipaddress='+ipaddress+'&uid='+uid+'&start_date='+start_date+'&att_type='+att_type,
	success: function (response) {
		if(response) {
			$("#ajax_modal_view").html(response);
		}
	}
	});
});


// Month & Year
$('.attendance_date').datepicker({
	changeMonth: true,
	changeYear: true,
	maxDate: '0',
	dateFormat:'yy-mm-dd',
	altField: "#date_format",
	altFormat: js_date_format,
	yearRange: '1970:' + new Date().getFullYear(),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
});
/* attendance datewise report */
$("#attendance_datewise_report").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	var user_id = $('#employee_id').val();
	var xin_table2 = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/date_wise_list/?start_date="+start_date+"&end_date="+end_date+"&user_id="+user_id,
			type : 'GET'
		},
		/*dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}*/
	});
	toastr.success('Request Submit.');
	xin_table2.api().ajax.reload(function(){Ladda.stopAll(); }, true);
});
/* attendance daily report */
$("#attendance_daily_report").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
	var attendance_date = $('#attendance_date').val();
	var date_format = $('#date_format').val();
	if(attendance_date == ''){
		toastr.error('Please select date.');
	} else {
	$('#att_date').html(date_format);
		 var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"timesheet/attendance_list/?attendance_date="+$('#attendance_date').val()+"&location_id="+$('#location_id').val(),
				type : 'GET'
			},
		});
		xin_table2.api().ajax.reload(function(){
		Ladda.stopAll();}, true);
	}
});

});