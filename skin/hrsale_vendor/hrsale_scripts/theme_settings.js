$(document).ready(function(){			

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });	

jQuery("#page_layouts_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=page_layouts_info&type=page_layouts_info&form="+action,
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
jQuery("#nav_menu_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	if($('#collapsed-sidebar').is(':checked')){
		var compact_menu = $("#collapsed-sidebar").val();
	} else {
		var compact_menu = 'false';
	}
	if($('#flipped-navigation').is(':checked')){
		var flipped_menu = $("#flipped-navigation").val();
	} else {
		var flipped_menu = 'false';
	}
	if($('#right-side-icons').is(':checked')){
		var right_side_icons = $("#right-side-icons").val();
	} else {
		var right_side_icons = 'false';
	}
	if($('#bordered-navigation').is(':checked')){
		var bordered_menu = $("#bordered-navigation").val();
	} else {
		var bordered_menu = 'false';
	}
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=nav_menu_info&type=nav_menu_info&form="+action+'&compact_menu='+compact_menu+'&flipped_menu='+flipped_menu+'&right_side_icons='+right_side_icons+'&bordered_menu='+bordered_menu,
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
jQuery("#color_system_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=color_system_info&type=color_system_info&form="+action,
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
jQuery("#form_design_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=form_design_info&type=form_design_info&form="+action,
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
/* Update logo */
/* Update logo */
$("#logo_info").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 2);
	fd.append("type", 'logo_info');
	fd.append("data", 'logo_info');
	fd.append("form", action);
	e.preventDefault();
	$('.icon-spinner3').show();
	$('.save').prop('disabled', true);
	$.ajax({
		url: e.target.action,
		type: "POST",
		data:  fd,
		contentType: false,
		cache: false,
		processData:false,
		success: function(JSON)
		{
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#logo_info')[0].reset();
				$('.icon-spinner3').hide();
				$('#u_file_1').attr("src", JSON.img);
				//$('#favicon1').attr("src", JSON.img3);
				$('.save').prop('disabled', false);
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.icon-spinner3').hide();
			$('.save').prop('disabled', false);
		} 	        
   });
});

/* Update logo */
$("#logo_favicon").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 2);
	fd.append("type", 'logo_favicon');
	fd.append("data", 'logo_favicon');
	fd.append("form", action);
	e.preventDefault();
	$('.icon-spinner3').show();
	$('.save').prop('disabled', true);
	$.ajax({
		url: e.target.action,
		type: "POST",
		data:  fd,
		contentType: false,
		cache: false,
		processData:false,
		success: function(JSON)
		{
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#logo_favicon')[0].reset();
				$('.icon-spinner3').hide();
				//$('#u_file').attr("src", JSON.img);
				$('#favicon1').attr("src", JSON.img3);
				$('.save').prop('disabled', false);
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.icon-spinner3').hide();
			$('.save').prop('disabled', false);
		} 	        
   });
});

$("#singin_logo").submit(function(e){
	var fd = new FormData(this);
	$('.icon-spinner3').show();
	var user_id = $('#user_id').val();
	var session_id = $('#session_id').val();
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 2);
	fd.append("type", 'singin_logo');
	fd.append("data", 'singin_logo');
	fd.append("form", action);
	e.preventDefault();
	$('.save').prop('disabled', true);
	$.ajax({
		url: site_url+'theme/sign_in_logo/',
		type: "POST",
		data:  fd,
		contentType: false,
		cache: false,
		processData:false,
		success: function(JSON)
		{
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('#u_file3').attr("src", JSON.img);
				$('.save').prop('disabled', false);
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.icon-spinner3').hide();
			$('.save').prop('disabled', false);
		} 	        
   });
});

$("#job_logo").submit(function(e){
	var fd = new FormData(this);
	$('.icon-spinner3').show();
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 2);
	fd.append("type", 'job_logo');
	fd.append("data", 'job_logo');
	fd.append("form", action);
	e.preventDefault();
	$('.save').prop('disabled', true);
	$.ajax({
		url: site_url+'theme/job_logo/',
		type: "POST",
		data:  fd,
		contentType: false,
		cache: false,
		processData:false,
		success: function(JSON)
		{
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#u_file4').attr("src", JSON.img);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.icon-spinner3').hide();
			$('.save').prop('disabled', false);
		} 	        
   });
});

$("#payroll_logo_info").submit(function(e){
	var fd = new FormData(this);
	$('.icon-spinner3').show();
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 2);
	fd.append("type", 'ipayroll_logo');
	fd.append("data", 'ipayroll_logo');
	fd.append("form", action);
	e.preventDefault();
	$('.save').prop('disabled', true);
	$.ajax({
		url: site_url+'theme/payroll_logo/',
		type: "POST",
		data:  fd,
		contentType: false,
		cache: false,
		processData:false,
		success: function(JSON)
		{
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('#u_file5').attr("src", JSON.img);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.icon-spinner3').hide();
			$('.save').prop('disabled', false);
		} 	        
   });
});

jQuery("#animation_effect_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=animation_effect_info&type=animation_effect_info&form="+action,
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
jQuery("#notification_position_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	if($('#sclose_btn').is(':checked')){
		var close_btn = $("#sclose_btn").val();
	} else {
		var close_btn = 'false';
	}
	if($('#snotification_bar').is(':checked')){
		var notification_bar = $("#snotification_bar").val();
	} else {
		var notification_bar = 'false';
	}
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=notification_position_info&type=notification_position_info&form="+action+'&notification_close_btn='+close_btn+'&notification_bar='+notification_bar,
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
jQuery("#orgchart_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	if($('#export_orgchart').is(':checked')){
		var export_orgchart = $("#export_orgchart").val();
	} else {
		var export_orgchart = 'false';
	}
	if($('#org_chart_zoom').is(':checked')){
		var org_chart_zoom = $("#org_chart_zoom").val();
	} else {
		var org_chart_zoom = 'false';
	}
	if($('#org_chart_pan').is(':checked')){
		var org_chart_pan = $("#org_chart_pan").val();
	} else {
		var org_chart_pan = 'false';
	}
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=6&data=orgchart_info&type=orgchart_info&form="+action+'&export_orgchart='+export_orgchart+'&org_chart_zoom='+org_chart_zoom+'&org_chart_pan='+org_chart_pan,
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
	
$(".nav-tabs-link").click(function(){
	var profile_id = $(this).data('profile');
	var profile_block = $(this).data('profile-block');
	$('.list-group-item').removeClass('active');
	$('.current-tab').hide();
	$('#setting_'+profile_id).addClass('active');
	$('#'+profile_block).show();
});	
});
