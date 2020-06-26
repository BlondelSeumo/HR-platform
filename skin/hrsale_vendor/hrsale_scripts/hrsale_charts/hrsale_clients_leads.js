$(window).on("load", function(){
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
	Chart.defaults.global.legend.display = false;
    var donutChartCanvas = $('#hrsale_clients_leads').get(0).getContext('2d');
	$.ajax({
		url: site_url+'dashboard/hrsale_clients_leads/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var donutData        = {
			  labels: [
				  response.clients_label, response.leads_label
			  ],
			  datasets: [
				{
				  data: [response.total_clients, response.total_leads],
				  backgroundColor : ['#28c3d7', '#FFD950'],
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