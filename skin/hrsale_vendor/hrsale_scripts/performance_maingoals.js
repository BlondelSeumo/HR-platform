$(document).ready(function() {
	var xin_table_maingoals, xin_table_variable, xin_table_incidental;
	var user_id = $('#aj_all_employees').val();
	maingoals_table(user_id);
	variable_table(user_id);
	incidental_table(user_id);
	get_all_variable_statistic(user_id);

	//main goals table
	function maingoals_table (user_id) {
		xin_table_maingoals = $('#xin_table_maingoals').dataTable({
			dom: 'lBfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ],
	        "bDestroy": true,
			"ajax": {
	            url : site_url+"performance_maingoals/maingoals_list/"+user_id,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings) {
				$('[data-toggle="tooltip"]').tooltip();          
			}
	    });
	}

   	//variable table
   	function variable_table (user_id) {
   		xin_table_variable = $('#xin_table_variable').DataTable({
   			dom: 'lBfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ],
	        destroy: true,
			"ajax": {
	            url : site_url+"performance_variable/variable_list/"+user_id,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
	    });
   	}
    

    //incidental table
    function incidental_table (user_id) {
    	xin_table_incidental = $('#xin_table_incidental').dataTable({
    		dom: 'lBfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ],
	        "bDestroy": true,
			"ajax": {
	            url : site_url+"performance_incidental/incidental_list/"+user_id,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
	    });
    }

    //main goals get by year
    function main_goals_by_year (year, user_id) {
    	$('#xin_table_maingoals').dataTable({
			dom: 'lBfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ],
	        "bDestroy": true,
			"ajax": {
	            url : site_url+"performance_maingoals/maingoals_by_year/"+year+"/"+user_id,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings) {
				$('[data-toggle="tooltip"]').tooltip();       
			}
	    });
    }
    
    //variable get quarterly
   	function variable_get_quarterly (user_id, quarter, year) {
   		$('#xin_table_variable').dataTable({
   			dom: 'lBfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ],
	        "bDestroy": true,
			"ajax": {
	            url : site_url+"performance_variable/variable_quarter_list/"+user_id+"/"+quarter+"/"+year,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
	    });
   	}

   	//incidental get quarterly
   	function incidental_get_quarterly (user_id, quarter, year) {
   		$('#xin_table_incidental').dataTable({
   			dom: 'lBfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ],
	        "bDestroy": true,
			"ajax": {
	            url : site_url+"performance_incidental/incidental_quarter_list/"+user_id+"/"+quarter+"/"+year,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
	    });
   	}

   	//get all variable statistic
   	function get_all_variable_statistic (user_id) {
   		$('#xin_table_statistics_variable').dataTable({
	        "bDestroy": true,
			"ajax": {
	            url : site_url+"performance_variable/get_all_variable_statistic/"+user_id,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
	    });
   	}
   	//variable get statistic
   	function variable_statistic (user_id, quarter, year) {
   		$('#xin_table_statistics_variable').dataTable({
	        "bDestroy": true,
			"ajax": {
	            url : site_url+"performance_variable/variable_statistic/"+user_id+"/"+quarter+"/"+year,
	            type : 'GET'
	        },
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
	    });
   	}

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

	jQuery("#aj_all_employees").change(function(){
		maingoals_table(jQuery(this).val());
		variable_table(jQuery(this).val());
		incidental_table(jQuery(this).val());
		$('#kpi_quarter_name').val('All');
		get_all_variable_statistic(jQuery(this).val());
	});


	/* Delete data maingoals */
	$("#delete_record_maingoals").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					$('.delete-modal-maingoals').modal('toggle');
					xin_table_maingoals.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, false);							
				}
			}
		});
	});

	/* Delete data variable */
	$("#delete_record_variable").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					$('.delete-modal-variable').modal('toggle');
					xin_table_variable.ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, false);							
				}
			}
		});
	});

	/* Delete data incidental */
	$("#delete_record_incidental").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					$('.delete-modal-incidental').modal('toggle');
					xin_table_incidental.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, false);							
				}
			}
		});
	});

	/* Approve main goals kpi */
	$("#approve_maingoals_kpi").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=approve&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					$('.approve-modal-maingoals-kpi').modal('toggle');
					xin_table_maingoals.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, false);							
				}
			}
		});
	});

	/* Approve variable kpi */
	$("#approve_variable_kpi").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=approve&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					$('.approve-modal-variable-kpi').modal('toggle');
					xin_table_variable.ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, false);							
				}
			}
		});
	});


	// edit maingoals
	$('.edit-modal-maingoals-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var maingoals_id = button.data('maingoals_id');
		var modal = $(this);
	$.ajax({
		url : site_url+"performance_maingoals/read_maingoals_record/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=maingoals&maingoals_id='+maingoals_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_maingoals").html(response);
			}
		}
		});
	});

	// edit variable
	$('.edit-modal-variable-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var variable_id = button.data('variable_id');
		var modal = $(this);
	$.ajax({
		url : site_url+"performance_variable/read_variable_record/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=variable&variable_id='+variable_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_variable").html(response);
			}
		}
		});
	});

	// edit incidental
	$('.edit-modal-incidental-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var incidental_id = button.data('incidental_id');
		var modal = $(this);
		$.ajax({
			url : site_url+"performance_incidental/read_incidental_record/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=incidental&incidental_id='+incidental_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_incidental").html(response);
				}
			}
		});
	});
	
	/* Add data maingoals */ /*Form Submit*/
	$("#xin-form-maingoals").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=kpi_maingoals&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} else {
					xin_table_maingoals.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.add-form').removeClass('show');
					$('#xin-form-maingoals')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});


	/* Add data variable */ /*Form Submit*/
	$("#xin-form-variable").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=kpi_variable&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} else {
					xin_table_variable.ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, false);
					$('.add-form').removeClass('show');
					$('#xin-form-variable')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});


	/* Add data incidental */ /*Form Submit*/
	$("#xin-form-incidental").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=kpi_incidental&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} else {
					xin_table_incidental.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.add-form').removeClass('show');
					$('#xin-form-incidental')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});

	//filter maingoals by year
	$('#main_goals_year').on('change', function () {
		var u_id = $('#aj_all_employees').val();
		var maingoal_year = $('#main_goals_year').val();
		main_goals_by_year(maingoal_year, u_id);
	});

	//filter by quarter
	$('#kpi_quarter_name').on('change', function() {
		var u_id = $('#aj_all_employees').val();
		var quarter = $('#kpi_quarter_name').val();
		var kpi_year = $('#kpi_year').val();

		variable_get_quarterly(u_id,quarter,kpi_year);
		incidental_get_quarterly(u_id,quarter,kpi_year);
		variable_statistic(u_id,quarter,kpi_year);
	});	
	//filter by year
	$('#kpi_year').on('change', function () {
		var u_id = $('#aj_all_employees').val();
		var quarter = $('#kpi_quarter_name').val();
		var kpi_year = $('#kpi_year').val();

		variable_get_quarterly(u_id,quarter,kpi_year);
		incidental_get_quarterly(u_id,quarter,kpi_year);
		variable_statistic(u_id,quarter,kpi_year);
	});
});

$( document ).on( "click", ".delete-maingoals", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record_maingoals').attr('action',site_url+'performance_maingoals/delete_maingoals/'+$(this).data('record-id'));
});

$( document ).on( "click", ".delete-variable", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record_variable').attr('action',site_url+'performance_variable/delete_variable/'+$(this).data('record-id'));
});

$( document ).on( "click", ".delete-incidental", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record_incidental').attr('action',site_url+'performance_incidental/delete_incidental/'+$(this).data('record-id'));
});

$( document ).on( "click", ".approve-maingoals", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#approve_maingoals_kpi').attr('action',site_url+'performance_maingoals/approve_maingoals/'+$(this).data('record-id'));
});

$( document ).on( "click", ".approve-variable", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#approve_variable_kpi').attr('action',site_url+'performance_variable/approve_variable/'+$(this).data('record-id'));
});

