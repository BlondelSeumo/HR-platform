<?php $session = $this->session->userdata('username'); ?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
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
<!--<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>-->
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
<?php if(($this->router->fetch_class() =='employees' && $this->router->fetch_method() =='detail') || $this->router->fetch_class() =='import' || $this->router->fetch_class() =='profile' || $this->router->fetch_method() =='view_all') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/smartwizard/smartwizard.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/forms_wizard.js"></script>
<?php } ?>
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
	$('.month_year').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").addClass('hide-calendar');
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(year, month, 1));
			$(this).datepicker('widget').removeClass('hide-calendar');
			$(this).datepicker('widget').hide();
		}
			
	});
	$('.hr_month_year').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").addClass('hide-calendar');
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(year, month, 1));
			$(this).datepicker('widget').removeClass('hide-calendar');
			$(this).datepicker('widget').hide();
		}
			
	});
	
	$('.timepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
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
<?php if($this->router->fetch_class() =='employees' || $this->router->fetch_class() =='dashboard' || $this->router->fetch_method() =='accounting_dashboard' || $this->router->fetch_method() =='attendance_dashboard' || $this->router->fetch_class() =='project') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/chartjs/chartjs.js"></script>
<?php } ?>
<?php if($this->router->fetch_class() =='events' || $this->router->fetch_class() =='meetings'){?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/minicolors/minicolors.js"></script>
<?php } ?>
<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var user_session_id = '<?php echo $session['user_id'];?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Xin_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>admin/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'admin/'.$this->router->fetch_class(); ?>';</script>
<script type="text/javascript">var processing_request = '<?php echo $this->lang->line('xin_processing_request');?>';</script>
<script type="text/javascript">var request_submitted = '<?php echo $this->lang->line('xin_hr_request_submitted');?>';</script>
<?php if($this->router->fetch_class() =='project'){?>
	<?php if($system[0]->show_projects=='0'){?>
    	<script type="text/javascript">var show_projects = 'list';</script>
    <?php } else {?>   
    	<script type="text/javascript">var show_projects = 'grid';</script> 
    <?php } ?>
<?php } ?>
<?php if($this->router->fetch_method() =='tasks'){?>
	<?php if($system[0]->show_tasks=='0'){?>
    	<script type="text/javascript">var show_tasks = 'list';</script>
    <?php } else {?>   
    	<script type="text/javascript">var show_tasks = 'grid';</script> 
    <?php } ?>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url().'skin/hrsale_vendor/hrsale_scripts/'.$path_url.'.js'; ?>"></script>
<?php if($this->router->fetch_class() =='dashboard') { ?>
	<?php if($user[0]->user_role_id!=1): ?>
        <?php if($system[0]->is_ssl_available=='yes'){?>
        <script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/user/set_clocking_ssl.js"></script>
        <?php } else {?>
        <script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/user/set_clocking_non_ssl.js"></script>
        <?php } ?>
    <?php endif;?>
<?php } ?>
<?php if($this->router->fetch_class() =='roles') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/kendo/kendo.all.min.js"></script>
<?php $this->load->view('admin/roles/role_values');?>
<?php } ?>
<!-- UI SideNav -->
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/pages_contacts.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/demo.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/dropdown-hover.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/ui_navbar.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/ui_dropdowns.js"></script>

<?php if($this->router->fetch_class() =='dashboard') { ?>
	<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_payroll.js"></script>
	<?php if($user[0]->user_role_id==1): ?>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/employee_department.js"></script>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/employee_designation.js"></script>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_projects.js"></script>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_expense_deposit.js"></script>
    <?php else:?>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_projects.js"></script>
	<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_tasks.js"></script>
    <?php endif; ?>
<?php } ?>
<?php if($this->router->fetch_class() =='employees') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_roles.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_office_shifts.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/employee_company.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/employee_location.js"></script>
<?php } ?>
<?php if($this->router->fetch_method() =='accounting_dashboard') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_expense_deposit.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/knob/knob.js"></script>
<script type="text/javascript">
	$(function () {
	/* jQueryKnob */
    $(".knob").knob({});
    /* END JQUERY KNOB */
});
</script>
<?php } ?>
<?php if($this->router->fetch_method() =='attendance_dashboard') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/employee_working_status.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_overtime_request.js"></script>
<?php } ?>
<?php if($this->router->fetch_method() =='projects_dashboard') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_projects.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_tasks.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/hrsale_scripts/hrsale_charts/hrsale_clients_leads.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/flot/flot.js"></script>

<?php } ?>
<?php if($this->router->fetch_class() =='reports') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/pages_file-manager.js"></script>
<?php } ?>
<?php if($this->router->fetch_class() =='chat') { ?>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/pages_chat.js"></script>
<?php } ?>
<?php if($this->router->fetch_class() =='organization' && $this->router->fetch_method() =='chart') { ?>
<?php $this->load->view('admin/components/vendors/organization_chart');?>
<?php } ?>
<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='timesheet' || $this->router->fetch_class() =='dashboard' || $this->router->fetch_method() =='timecalendar' || $this->router->fetch_method() =='projects_calendar' || $this->router->fetch_method() =='tasks_calendar' || $this->router->fetch_method() =='quote_calendar' || $this->router->fetch_method() =='invoice_calendar' || $this->router->fetch_method() =='projects_dashboard' || $this->router->fetch_method() =='accounting_dashboard' || $this->router->fetch_method() =='calendar'){?>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/fullcalendar/dist/fullcalendar.js"></script>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/fullcalendar/dist/scheduler.min.js"></script>
<?php }?>
<?php if($this->router->fetch_method() =='tasks_scrum_board' || $this->router->fetch_method() =='projects_scrum_board') { ?>
    <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/dragula/dragula.js"></script>
   <?php } ?>
<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='dashboard'){?>
<?php if($user[0]->user_role_id==1): ?>
		<?php $this->load->view('admin/components/vendors/full_calendar');?>
    <?php else:?>
    	<?php $this->load->view('admin/components/vendors/half_calendar');?>
    <?php endif; ?>
	
<?php }?>
<?php if($this->router->fetch_class() =='goal_tracking' || $this->router->fetch_method() =='task_details' || $this->router->fetch_class() =='project' || $this->router->fetch_method() =='project_details' || $this->router->fetch_class() =='quoted_projects'){?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<?php }?>
<?php if($this->router->fetch_method() =='task_details' || $this->router->fetch_method() =='project_details' || ($this->router->fetch_class() =='project' && $this->router->fetch_method() !='projects_calendar') || ($this->router->fetch_class() =='quoted_projects' && $this->router->fetch_method() =='detail')){?>
<script type="text/javascript">
$(document).ready(function(){	
	$("#range_grid").ionRangeSlider({
		type: "single",
		min: 0,
		max: 100,
		from: '<?php echo $progress;?>',
		grid: true,
		force_edges: true,
		onChange: function (data) {
			$('#progres_val').val(data.from);
		}
	});
});
</script>
<?php } ?>
<?php if($this->router->fetch_class() =='timesheet' && $this->router->fetch_method() =='index') { ?>
	<?php $this->load->view('admin/components/vendors/monthly_hrsale_calendar');?>
<?php } ?>
<?php if($this->router->fetch_class() =='timesheet' && $this->router->fetch_method() =='timecalendar') { ?>
	<?php $this->load->view('admin/components/vendors/calendar_time');?>
<?php } ?>
<?php if($this->router->fetch_method() =='tasks_calendar'){?>
	<?php $this->load->view('admin/components/vendors/tasks_calendar');?>
<?php }?>
<?php if($this->router->fetch_method() =='projects_calendar'){?>
	<?php $this->load->view('admin/components/vendors/project_calendar');?>
<?php }?>
<?php if($this->router->fetch_method() =='invoice_calendar'){?>
	<?php $this->load->view('admin/components/vendors/invoice_calendar');?>
<?php }?>
<?php if($this->router->fetch_method() =='quote_calendar'){?>
	<?php $this->load->view('admin/components/vendors/quote_calendar');?>
<?php }?>
<?php if($this->router->fetch_class() =='events' && $this->router->fetch_method() =='calendar'){?>
	<?php $this->load->view('admin/components/vendors/events_calendar');?>
<?php }?>
<?php if($this->router->fetch_class() =='meetings' && $this->router->fetch_method() =='calendar'){?>
	<?php $this->load->view('admin/components/vendors/meetings_calendar');?>
<?php }?>
<?php if($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' && ($this->router->fetch_method() =='create' || $this->router->fetch_method() =='edit')) { ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#add-invoice-item').click(function () {
        var invoice_items = '<div class="row item-row">'
					+'<hr>'
					+'<div class="form-group mb-1 col-sm-12 col-md-3">'
					+'<label for="item_name"><?php echo $this->lang->line('xin_title_item');?></label>'
					+'<br>'
					+'<input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Item Name">'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>'
					+'<br>'
					+'<select class="form-control tax_type" name="tax_type[]" id="tax_type">'
					<?php foreach($all_taxes as $_tax){?>
					<?php
						if($_tax->type=='percentage') {
							$_tax_type = $_tax->rate.'%';
						} else {
							$_tax_type = $this->Xin_model->currency_sign($_tax->rate);
						}
					?>
					+'<option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>"> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>'
					<?php } ?>
				  	+'</select>'
					+'</div>' 
					+'<div class="form-group mb-1 col-sm-12 col-md-1">'
					+'<label for="tax_type"><?php echo $this->lang->line('xin_title_tax_rate');?></label>'
					+'<br>'
					+'<input type="text" readonly="readonly" class="form-control tax-rate-item" name="tax_rate_item[]" value="0" />'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-1">'
					+'<label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_title_qty_hrs');?></label>'
					+'<br>'
					+'<input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">'
					+'</div>'
					+'<div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="unit_price"><?php echo $this->lang->line('xin_title_unit_price');?></label>'
					+'<br>'
					+'<input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="profession"><?php echo $this->lang->line('xin_title_sub_total');?></label>'
					+'<input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />'
					+'<p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>'
					+'</div>'
					+'<div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">'
					+'<label for="profession">&nbsp;</label><br><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button>'
					+'</div>'
				  	+'</div>'

        $('#item-list').append(invoice_items).fadeIn(500);

    });
});	

</script>
<?php } ?>
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


