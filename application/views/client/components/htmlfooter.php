<?php $session = $this->session->userdata('client_username'); ?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $user = $this->Clients_model->read_client_info($session['client_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php $this->load->view('admin/components/vendors/del_dialog');?>

<!-- Core scripts -->

<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/popper/popper.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/sidenav.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/dropdown-hover.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/bootstrap-menu/bootstrap-menu.js"></script>
<!-- Picker-->
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/moment/moment.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/timepicker/timepicker.js"></script>
<!-- Libs -->
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/datatables/datatables.js"></script>

<!-- Editor-->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/Trumbowyg/dist/trumbowyg.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/select2/select2.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/validate/validate.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/ui_tooltips.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/ladda/ladda.css">
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/spin/spin.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/ladda/ladda.js"></script>


<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/toastr/toastr.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	$('.date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	$('.hrsale-link').click(function(){
		var ilink = $(this).data('link-data');
		window.location = ilink;
	});
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
	var site_url = '<?php echo site_url(); ?>';
	Ladda.bind('button[type=submit]');
	function escapeHtmlSecure(str) {
		var map =
		{
			'alert': '&lt;',
			'313': '&lt;',
			'bzps': '&lt;',
			'<': '&lt;',
			'>': '&gt;',
			'script': '&lt;',
			'html': '&lt;',
			'php': '&lt;',
		};
		return str.replace(/[<>]/g, function(m) {return map[m];});
	}
});
</script>
<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var user_session_id = '<?php echo $session['client_id'];?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Xin_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>client/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'client/'.$this->router->fetch_class(); ?>';</script>
<script type="text/javascript">var processing_request = '<?php echo $this->lang->line('xin_processing_request');?>';</script>
<script type="text/javascript">var request_submitted = '<?php echo $this->lang->line('xin_hr_request_submitted');?>';</script>

<script type="text/javascript" src="<?php echo base_url().'skin/hrsale_vendor/hrsale_scripts/'.$path_url.'.js'; ?>"></script>

<!-- UI SideNav -->
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/demo.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/dropdown-hover.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/ui_navbar.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/ui_dropdowns.js"></script>

<?php if($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' && $this->router->fetch_method() =='view') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/printThis.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.print-invoice').click(function () {
		$("#print_invoice_hr").printThis();
	});	
});
</script>
<?php } ?>



<?php //$this->load->view('client/components/vendors/del_dialog');?>
<!-- Vendor JS -->
<?php /*?><script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/popper/popper.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/sidenav.js"></script>

<!-- Libs -->
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/datatables/datatables.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/Trumbowyg/dist/trumbowyg.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/clockpicker/dist/jquery-clockpicker.min.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_assets/js/demo.js"></script>

<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Xin_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>client/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'client/'.$this->router->fetch_class(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.js"></script>
<?php //if($this->router->fetch_class() !='dashboard'){?>
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.showMethod = 'slideDown';
	toastr.options.hideMethod = 'slideUp';
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
   // setTimeout(refreshChatMsgs, 5000);
   $('[data-toggle="popover"]').popover();
});
</script>
<script type="text/javascript" src="<?php echo base_url().'skin/hrsale_assets/hrsale_scripts/'.$path_url.'.js'; ?>"></script>
<?php if($this->router->fetch_class() =='invoices' && $this->router->fetch_method() =='view') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/printThis.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.print-invoice').click(function () {
		$("#print_invoice_hr").printThis();
	});	
});
</script>
<?php } ?>
</body>
</html><?php */?>