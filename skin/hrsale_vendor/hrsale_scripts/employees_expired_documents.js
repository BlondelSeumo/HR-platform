$(document).ready(function(){			
	
	// get data
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'document'){
			var field_add = '&data=emp_document&type=emp_document&';
		} else if(field_tpe == 'imgdocument'){
			var field_add = '&data=e_imgdocument&type=e_imgdocument&';
		} else if(field_tpe == 'company_license_expired'){
			var field_add = '&data=edocument_id&type=edocument_id&';
		} else if(field_tpe == 'assets_warranty_expired'){
			var field_add = '&data=eassets_warranty&type=eassets_warranty&';
		}
		var modal = $(this);
		$.ajax({
			url: site_url+'employees/dialog_exp_'+field_tpe+'/',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
   });
	
	// On page load: table_contacts
	 var xin_table_contact = $('#xin_table_company_license').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/exp_company_license_list/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	// On page load > documents
	var xin_table_immigration = $('#xin_table_imgdocument').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/expired_immigration_list/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	// On page load > documents
	var xin_table_document = $('#xin_table_document').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/expired_documents_list/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });	
	// On page load > documents
	var xin_table_assets_warranty = $('#xin_table_assets_warranty').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/assets_warranty_list/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });	  
	$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('constant');
		var profile_block = $(this).data('constant-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#constant_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});
});	