$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/role_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	//
	$('.hrsale-link').click(function(e){
		var ilink = $(this).data('link-data');
		window.location = ilink;
	});
	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);		
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);		
					Ladda.stopAll();			
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var role_id = button.data('role_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=role&role_id='+role_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=role&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					xin_table.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
					}, true);
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#xin-roles-form')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});

$(document).ready(function(){
	$("#role_access").change(function(){
		var sel_val = $(this).val();
		if(sel_val=='1') {
			$('.role-checkbox').prop('checked', true);
		} else {
			$('.role-checkbox').prop("checked", false);
		}
	});
});