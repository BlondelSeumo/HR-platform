$(document).ready(function(){
	
	/*$(window).scroll(function(){
		if ($(this).scrollTop() >= 75) 
		{
			jQuery('.navbar-static-top').addClass('fixed-header');
		} 
		else 
		{
			jQuery('.navbar-static-top').removeClass('fixed-header');
		}
	});*/
	
});	
	
$(document).ready(function(){	
	
	  
	  $('.policy').on('show.bs.modal', function (event) {
	$.ajax({
		url: site_url+'settings/policy_read/',
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=policy&type=policy&p=1',
		success: function (response) {
			if(response) {
				$("#policy_modal").html(response);
			}
		}
		});
	});
	
	
	
	jQuery(".hrsale_layout").change(function(){
		if($('#fixed_layout_hrsale').is(':checked')){
			var fixed_layout_hrsale = $("#fixed_layout_hrsale").val();
			
		} else {
			var fixed_layout_hrsale = '';
		}
		if($('#boxed_layout_hrsale').is(':checked')){
			var boxed_layout_hrsale = $("#boxed_layout_hrsale").val();
		} else {
			var boxed_layout_hrsale = '';
		}
		if($('#sidebar_layout_hrsale').is(':checked')){
			var sidebar_layout_hrsale = $("#sidebar_layout_hrsale").val();
		} else {
			var sidebar_layout_hrsale = '';
		}
	
		$.ajax({
			type: "GET",  url: site_url+"settings/layout_skin_info/?is_ajax=2&type=hrsale_layout_info&form=2&fixed_layout_hrsale="+fixed_layout_hrsale+"&boxed_layout_hrsale="+boxed_layout_hrsale+"&sidebar_layout_hrsale="+sidebar_layout_hrsale+"&user_session_id="+user_session_id,
			//data: order,
			success: function(response) {
				if (response.error != '') {
					toastr.error(response.error);
				} else {
					toastr.success(response.result);	
				}
			}
		});
	});
	//
	jQuery("#fixed_layout_hrsale").click(function(){
		if($('#fixed_layout_hrsale').is(':checked')){
			//$('#boxed_layout_hrsale').prop('checked', false);
		}
	});
	jQuery("#boxed_layout_hrsale").click(function(){
		if($('#boxed_layout_hrsale').is(':checked')){
			$('.hrsale-layout').removeClass('fixed');
			$('#fixed_layout_hrsale').prop('checked', false);
		}
	});
});