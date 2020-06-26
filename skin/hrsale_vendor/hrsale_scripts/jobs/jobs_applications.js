$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"employer/jobs_applications_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		//$('[data-toggle="tooltip"]').tooltip();          
		}
	});
});