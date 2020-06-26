$(window).on("load", function(){
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
	Chart.defaults.global.legend.display = false;
    var donutChartCanvas = $('#hrsale_overtime_request').get(0).getContext('2d');
	$.ajax({
		url: site_url+'dashboard/hrsale_overtime_request/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var donutData        = {
			  labels: [
				  response.overtime_approved, response.overtime_pending, response.overtime_rejected
			  ],
			  datasets: [
				{
				  data: [response.approved, response.pending, response.rejected],
				  backgroundColor : ['#009688', '#FFD950', '#d9534f'],
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