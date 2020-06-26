$(window).on("load", function(){	
	var ctx = $("#projects_status");
	Chart.defaults.global.legend.display = false;
	$.ajax({
		url: site_url+'dashboard/projects_status/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
		var bgcolor = [];
		var final = [];
		var final2 = [];
		for(i=0; i < response.c_name.length; i++) {
			final.push(response.chart_data[i].value);
			final2.push(response.chart_data[i].label);
			bgcolor.push(response.chart_data[i].bgcolor);
		} 
		
		// Chart Options
		var chartOptions = {
			responsive: true,
			maintainAspectRatio: false,
			responsiveAnimationDuration:500,
		};
	
		// Chart Data
		var chartData = {
			labels: final2,
			datasets: [{
				label: "project status",
				data: final,
				backgroundColor: bgcolor,
			}]
		};
	
		var config = {
			type: 'pie',
			options : chartOptions,
			data : chartData
		};
	
		var doughnutSimpleChart = new Chart(ctx, config);
		},
		error: function(data) {
			console.log(data);
		}
	});
});
$(window).on("load", function(){	
	var ctx = $("#tasks_status");
	Chart.defaults.global.legend.display = false;
	$.ajax({
		url: site_url+'dashboard/tasks_status/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
		var bgcolor = [];
		var final = [];
		var final2 = [];
		for(i=0; i < response.c_name.length; i++) {
			final.push(response.chart_data[i].value);
			final2.push(response.chart_data[i].label);
			bgcolor.push(response.chart_data[i].bgcolor);
		} 
		
		// Chart Options
		var chartOptions = {
			responsive: true,
			maintainAspectRatio: false,
			responsiveAnimationDuration:500,
		};
	
		// Chart Data
		var chartData = {
			labels: final2,
			datasets: [{
				label: "project status",
				data: final,
				backgroundColor: bgcolor,
			}]
		};
	
		var config = {
			type: 'doughnut',
			options : chartOptions,
			data : chartData
		};
	
		var doughnutSimpleChart = new Chart(ctx, config);
		},
		error: function(data) {
			console.log(data);
		}
	});
});