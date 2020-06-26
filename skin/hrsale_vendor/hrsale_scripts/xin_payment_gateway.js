$(document).ready(function(){			

$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
$('[data-plugin="xin_select"]').select2({ width:'100%' });	
	
jQuery("#payment_gateway").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&data=payment_gateway&type=payment_gateway&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});	
});
