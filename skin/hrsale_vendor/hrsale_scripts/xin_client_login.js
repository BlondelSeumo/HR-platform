$(document).ready(function(){
	
	$(".login-as").click(function(){
		var uname = jQuery(this).data('username');
		var password = jQuery(this).data('password');
		jQuery('#iusername').val(uname);
		jQuery('#ipassword').val(password);
	});
	
	$("#hrm-form").submit(function(e){
		$('.save').prop('disabled', true);
		$('.saveinfo').removeClass('ft-unlock');
		$('.saveinfo').addClass('fa spinner fa-refresh');
	/*Form Submit*/
	e.preventDefault();
	var obj = $(this), action = obj.attr('name'), redirect_url = obj.data('redirect'), form_table = obj.data('form-table'),  is_redirect = obj.data('is-redirect');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&form="+form_table,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('.save').prop('disabled', false);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.saveinfo').addClass('ft-unlock');
				$('.saveinfo').removeClass('fa spinner fa-refresh');
				Ladda.stopAll();
			} else {
				toastr.success(JSON.result);
				$('.save').prop('disabled', false);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.saveinfo').addClass('ft-unlock');
				$('.saveinfo').removeClass('fa spinner fa-refresh');
				Ladda.stopAll();
				if(is_redirect==1) {
					window.location = site_url+'client/dashboard?module=dashboard';
				}
			}
		}
	});
	});
});