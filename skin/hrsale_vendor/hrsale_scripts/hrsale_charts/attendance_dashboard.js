$(window).on("load", function(){
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#attendance_status').get(0).getContext('2d');
	$.ajax({
		url: site_url+'dashboard/employee_working_status/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var donutData        = {
			  labels: [
				  response.working_label, response.absent_label
			  ],
			  datasets: [
				{
				  data: [response.working, response.absent],
				  backgroundColor : ['#00a65a', '#f56954'],
				}
			  ]
			}
			var donutOptions     = {
			  maintainAspectRatio : false,
			  responsive : true,
			}
			//Create pie or douhnut chart
			// You can switch between pie and douhnut using the method below.
			var donutChart = new Chart(donutChartCanvas, {
			  type: 'doughnut',
			  data: donutData,
			  options: donutOptions      
			})
		}
	});
});
$(window).on("load", function(){
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#leave_status').get(0).getContext('2d');
	Chart.defaults.global.legend.display = false;
	$.ajax({
		url: site_url+'dashboard/employee_leave_status/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var donutData        = {
			  labels: [
				  response.accepted, response.pending, response.rejected
			  ],
			  datasets: [
				{
				  data: [response.accepted_count, response.pending_count, response.rejected_count],
				  backgroundColor : ['#00a65a', '#f39c12', '#f56954'],
				}
			  ]
			}
			var donutOptions     = {
			  maintainAspectRatio : false,
			  responsive : true,
			}
			//Create pie or douhnut chart
			// You can switch between pie and douhnut using the method below.
			var donutChart = new Chart(donutChartCanvas, {
			  type: 'pie',
			  data: donutData,
			  options: donutOptions      
			})
		}
	});
});