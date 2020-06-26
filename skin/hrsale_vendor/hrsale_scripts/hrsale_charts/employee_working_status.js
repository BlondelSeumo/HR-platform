$(window).on("load", function(){
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
	Chart.defaults.global.legend.display = false;
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
				  backgroundColor : ['#009688', '#d9534f'],
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