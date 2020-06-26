<?php
$session = $this->session->userdata('username');
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if($theme[0]->right_side_icons=='true') {
	$icons_right = 'expanded menu-icon-right';
} else {
	$icons_right = '';
}
if($theme[0]->bordered_menu=='true') {
	$menu_bordered = 'menu-bordered';
} else {
	$menu_bordered = '';
}
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->is_active!=1) {
	redirect('admin/');
}
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $arr_mod = $this->Xin_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<?php 
if($theme[0]->sub_menu_icons != ''){
	$submenuicon = $theme[0]->sub_menu_icons;
} else {
	$submenuicon = 'fa-circle-o';
}
// reports to 
  $reports_to = get_reports_team_data($session['user_id']);
?>
<?php  if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {?>
<?php $cpimg = base_url().'uploads/profile/'.$user_info[0]->profile_picture;?>
<?php } else {?>
<?php  if($user_info[0]->gender=='Male') { ?>
<?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
<?php $cpimg = $de_file;?>
<?php  } ?>

<ul class="sidenav-inner py-1">
  <!-- Dashboards -->
  <li class="sidenav-item <?php if(!empty($arr_mod['active']))echo $arr_mod['active'];?>"> <a href="<?php echo site_url('admin/dashboard');?>" class="sidenav-link"> <i class="sidenav-icon ion ion-md-speedometer"></i>
    <div><?php echo $this->lang->line('dashboard_title');?></div>
    </a> </li>
  <?php if(in_array('13',$role_resources_ids) || in_array('7',$role_resources_ids) || in_array('422',$role_resources_ids) || $reports_to>0 || $user_info[0]->user_role_id==1){?>
  <li class="<?php if(!empty($arr_mod['stff_open']))echo $arr_mod['stff_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon fas fa-user-friends"></i>
    <div><?php echo $this->lang->line('dashboard_employees');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if($user_info[0]->user_role_id==1){?>
      <?php if(in_array('422',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['staff_active']))echo $arr_mod['staff_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/employees/staff_dashboard/');?>" > <?php echo $this->lang->line('hr_staff_dashboard_title');?> </a> </li>
      <?php } ?>
      <?php } ?>
      <?php if(in_array('13',$role_resources_ids) || $reports_to>0) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['hremp_active']))echo $arr_mod['hremp_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/employees/');?>" > <?php echo $this->lang->line('dashboard_employees');?> </a> </li>
      <?php } ?>
      <?php if($user_info[0]->user_role_id==1){?>
      <li class="sidenav-item <?php if(!empty($arr_mod['roles_active']))echo $arr_mod['roles_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/roles/');?>" > <?php echo $this->lang->line('left_set_roles');?> </a> </li>
      <?php } ?>
      <?php if(in_array('7',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['shift_active']))echo $arr_mod['shift_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/office_shift/');?>"> <?php echo $this->lang->line('left_office_shifts');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if($system[0]->module_payroll=='yes'){?>
  <?php if(in_array('36',$role_resources_ids) && in_array('37',$role_resources_ids)){?>
  <li class="sidenav-item <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>"> <a href="<?php echo site_url('admin/payroll/generate_payslip/');?>" class="sidenav-link"> <i class="sidenav-icon fa fa-calculator"></i>
    <div><?php echo $this->lang->line('left_payroll');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('36',$role_resources_ids) && !in_array('37',$role_resources_ids)){?>
  <li class="sidenav-item <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>"> <a href="<?php echo site_url('admin/payroll/generate_payslip/');?>" class="sidenav-link"> <i class="sidenav-icon fa fa-calculator"></i>
    <div><?php echo $this->lang->line('left_payroll');?></div>
    </a> </li>
  <?php } ?>
  <?php } ?>
  <?php if($system[0]->module_accounting=='true'){?>
  <?php if(in_array('286',$role_resources_ids) || in_array('72',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('77',$role_resources_ids) || in_array('78',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['hr_acc_open']))echo $arr_mod['hr_acc_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon ion ion-md-cash"></i>
    <div><?php echo $this->lang->line('xin_hr_finance');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('286',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['dashboard_accounting_active']))echo $arr_mod['dashboard_accounting_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/accounting/accounting_dashboard/');?>" > <?php echo $this->lang->line('hr_accounting_dashboard_title');?> </a> </li>
      <?php } ?>
      <?php if(in_array('72',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['bank_cash_act']))echo $arr_mod['bank_cash_act'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/accounting/bank_cash/');?>" > <?php echo $this->lang->line('xin_acc_account_list');?> </a> </li>
      <?php } ?>
      <?php if(in_array('75',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['deposit_active']))echo $arr_mod['deposit_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/accounting/deposit/');?>" > <?php echo $this->lang->line('xin_acc_deposit');?> </a> </li>
      <?php } ?>
      <?php if(in_array('76',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['expense_active']))echo $arr_mod['expense_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/accounting/expense/');?>" > <?php echo $this->lang->line('xin_acc_expense');?> </a> </li>
      <?php } ?>
      <?php if(in_array('77',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['transfer_active']))echo $arr_mod['transfer_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/accounting/transfer/');?>" > <?php echo $this->lang->line('xin_acc_transfer');?> </a> </li>
      <?php } ?>
      <?php if(in_array('78',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['transactions_active']))echo $arr_mod['transactions_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/accounting/transactions/');?>" > <?php echo $this->lang->line('xin_acc_transactions');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php } ?>
  <?php  if(in_array('12',$role_resources_ids) || in_array('14',$role_resources_ids) || in_array('15',$role_resources_ids) || in_array('16',$role_resources_ids) || in_array('17',$role_resources_ids) || in_array('18',$role_resources_ids) || in_array('19',$role_resources_ids) || in_array('20',$role_resources_ids) || in_array('21',$role_resources_ids) || in_array('22',$role_resources_ids) || in_array('23',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['emp_open']))echo $arr_mod['emp_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon ion ion-ios-globe"></i>
    <div><?php echo $this->lang->line('xin_hr');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if($system[0]->module_awards=='true'){?>
      <?php if(in_array('14',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['awar_active']))echo $arr_mod['awar_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/awards');?>" > <?php echo $this->lang->line('left_awards');?> </a> </li>
      <?php } ?>
      <?php } ?>
      <?php if(in_array('15',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['tra_active']))echo $arr_mod['tra_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/transfers');?>" > <?php echo $this->lang->line('left_transfers');?> </a> </li>
      <?php } ?>
      <?php if(in_array('16',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['res_active']))echo $arr_mod['res_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/resignation');?>" > <?php echo $this->lang->line('left_resignations');?> </a> </li>
      <?php } ?>
      <?php if($system[0]->module_travel=='true'){?>
      <?php if(in_array('17',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['trav_active']))echo $arr_mod['trav_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/travel');?>"> <?php echo $this->lang->line('left_travels');?> </a> </li>
      <?php } ?>
      <?php } ?>
      <?php if(in_array('18',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['pro_active']))echo $arr_mod['pro_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/promotion');?>"> <?php echo $this->lang->line('left_promotions');?> </a> </li>
      <?php } ?>
      <?php if(in_array('19',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['compl_active']))echo $arr_mod['compl_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/complaints');?>"> <?php echo $this->lang->line('left_complaints');?> </a> </li>
      <?php } ?>
      <?php if(in_array('20',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['warn_active']))echo $arr_mod['warn_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/warning');?>"> <?php echo $this->lang->line('left_warnings');?> </a> </li>
      <?php } ?>
      <?php if(in_array('21',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['term_active']))echo $arr_mod['term_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/termination');?>"> <?php echo $this->lang->line('left_terminations');?> </a> </li>
      <?php } ?>
      <?php if(in_array('23',$role_resources_ids)) { ?>
      <li class="<?php if(!empty($arr_mod['emp_ex_active']))echo $arr_mod['emp_ex_active'];?> sidenav-item"><a href="<?php echo site_url('admin/employee_exit');?>" class="sidenav-link"> <?php echo $this->lang->line('left_employees_exit');?></a></li>
      <?php } ?>
      <?php if(in_array('22',$role_resources_ids) || $reports_to > 0) { ?>
      <li class="<?php if(!empty($arr_mod['emp_ll_active']))echo $arr_mod['emp_ll_active'];?> sidenav-item"><a href="<?php echo site_url('admin/employees_last_login');?>" class="sidenav-link"> <?php echo $this->lang->line('left_employees_last_login');?></a></li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('2',$role_resources_ids) || in_array('3',$role_resources_ids) || in_array('4',$role_resources_ids) || in_array('5',$role_resources_ids) || in_array('6',$role_resources_ids) || in_array('11',$role_resources_ids) || in_array('9',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['adm_open']))echo $arr_mod['adm_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon ion ion-md-business"></i>
    <div><?php echo $this->lang->line('left_organization');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('5',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['com_active']))echo $arr_mod['com_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/company/');?>" > <?php echo $this->lang->line('xin_companies');?> </a> </li>
      <?php } ?>
      <?php if(in_array('6',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['loc_active']))echo $arr_mod['loc_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/location/');?>" > <?php echo $this->lang->line('xin_locations');?> </a> </li>
      <?php } ?>
      <?php if(in_array('3',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['dep_active']))echo $arr_mod['dep_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/department/');?>" > <?php echo $this->lang->line('left_department');?> </a> </li>
      <?php } ?>
      <?php if(in_array('4',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['des_active']))echo $arr_mod['des_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/designation/');?>" > <?php echo $this->lang->line('left_designation');?> </a> </li>
      <?php } ?>
      <?php if(in_array('11',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['ann_active']))echo $arr_mod['ann_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/announcement/');?>" > <?php echo $this->lang->line('left_announcements');?> </a> </li>
      <?php } ?>
      <?php if(in_array('9',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['pol_active']))echo $arr_mod['pol_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/policy/');?>" > <?php echo $this->lang->line('header_policies');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('27',$role_resources_ids) || in_array('423',$role_resources_ids) || in_array('10',$role_resources_ids) || in_array('30',$role_resources_ids) || in_array('401',$role_resources_ids) || in_array('261',$role_resources_ids) || in_array('28',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['attnd_open']))echo $arr_mod['attnd_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon ion ion-md-clock"></i>
    <div><?php echo $this->lang->line('left_timesheet');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('423',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['attendance_dashboard_active']))echo $arr_mod['attendance_dashboard_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" > <?php echo $this->lang->line('hr_timesheet_dashboard_title');?> </a> </li>
      <?php } ?>
      <?php if(in_array('28',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/attendance/');?>" > <?php echo $this->lang->line('left_attendance');?> </a> </li>
      <?php } ?>
      <?php if(in_array('30',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['upd_attnd_active']))echo $arr_mod['upd_attnd_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/update_attendance/');?>" > <?php echo $this->lang->line('left_update_attendance');?> </a> </li>
      <?php } ?>
      <?php if(in_array('10',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['timesheet_active']))echo $arr_mod['timesheet_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/');?>" > <?php echo $this->lang->line('xin_month_timesheet_title');?> </a> </li>
      <?php } ?>
      <?php if(in_array('261',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['timecalendar_active']))echo $arr_mod['timecalendar_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/timecalendar/');?>" > <?php echo $this->lang->line('xin_acc_calendar');?> </a> </li>
      <?php } ?>
      <?php if(in_array('401',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['overtime_request_act']))echo $arr_mod['overtime_request_act'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/overtime_request/');?>" > <?php echo $this->lang->line('xin_overtime_request');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('95',$role_resources_ids)) { ?>
  <li class="sidenav-item <?php if(!empty($arr_mod['calendar_hr_active']))echo $arr_mod['calendar_hr_active'];?>"> <a href="<?php echo site_url('admin/calendar/hr/');?>" class="sidenav-link"> <i class="sidenav-icon oi oi-calendar"></i>
    <div><?php echo $this->lang->line('xin_hr_calendar_title');?></div>
    </a> </li>
  <?php } ?>
  <?php if($system[0]->module_payroll=='yes'){?>
  <?php if(!in_array('36',$role_resources_ids) && in_array('37',$role_resources_ids)){?>
  <li class="sidenav-item <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>"> <a href="<?php echo site_url('admin/payroll/payment_history/');?>" class="sidenav-link"> <i class="sidenav-icon fa fa-calculator"></i>
    <div><?php echo $this->lang->line('xin_payslip_history');?></div>
    </a> </li>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('45',$role_resources_ids) || in_array('90',$role_resources_ids) || in_array('91',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['task_open']))echo $arr_mod['task_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon fab fa-fantasy-flight-games"></i>
    <div><?php echo $this->lang->line('left_tasks');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('45',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['task_active']))echo $arr_mod['task_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/tasks/');?>" > <?php echo $this->lang->line('left_tasks');?> </a> </li>
      <?php } ?>
      <?php if(in_array('90',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['tasks_calendar_active']))echo $arr_mod['tasks_calendar_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/project/tasks_calendar/');?>" > <?php echo $this->lang->line('xin_tasks_calendar');?> </a> </li>
      <?php } ?>
      <?php if(in_array('91',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['tasks_scrum_board_active']))echo $arr_mod['tasks_scrum_board_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/project/tasks_scrum_board/');?>" > <?php echo $this->lang->line('xin_tasks_sboard');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('47',$role_resources_ids) || in_array('400',$role_resources_ids) || in_array('442',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['files_open']))echo $arr_mod['files_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon fas fa-file-signature"></i>
    <div><?php echo $this->lang->line('xin_files');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('47',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['file_active']))echo $arr_mod['file_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/files/');?>" > <?php echo $this->lang->line('xin_files');?> </a> </li>
      <?php } ?>
      <?php if(in_array('442',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['official_documents_active']))echo $arr_mod['official_documents_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/company/official_documents/');?>" > <?php echo $this->lang->line('xin_hr_official_documents');?> </a> </li>
      <?php } ?>
      <?php if(in_array('400',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['expired_documents_active']))echo $arr_mod['expired_documents_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/employees/expired_documents/');?>" > <?php echo $this->lang->line('xin_e_details_exp_documents');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('121',$role_resources_ids) || in_array('330',$role_resources_ids) || in_array('122',$role_resources_ids) || in_array('426',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['invoices_open']))echo $arr_mod['invoices_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon fas fa-file-invoice-dollar"></i>
    <div><?php echo $this->lang->line('xin_invoices_title');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('121',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['invoices_inv_active']))echo $arr_mod['invoices_inv_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/invoices/');?>" > <?php echo $this->lang->line('xin_invoices_title');?> </a> </li>
      <?php } ?>
      <?php if(in_array('426',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['invoice_calendar_active']))echo $arr_mod['invoice_calendar_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/invoices/invoice_calendar/');?>" > <?php echo $this->lang->line('xin_invoice_calendar');?> </a> </li>
      <?php } ?>
      <?php if(in_array('330',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['payments_history_inv_active']))echo $arr_mod['payments_history_inv_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/invoices/payments_history/');?>" > <?php echo $this->lang->line('xin_acc_invoice_payments');?> </a> </li>
      <?php } ?>
      <?php if(in_array('122',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['taxes_inv_active']))echo $arr_mod['taxes_inv_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/invoices/taxes/');?>" > <?php echo $this->lang->line('xin_invoice_tax_type');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('46',$role_resources_ids) && in_array('409',$role_resources_ids)){?>
  <li class="sidenav-item <?php if(!empty($arr_mod['leave_active']))echo $arr_mod['leave_active'];?>"> <a href="<?php echo site_url('admin/timesheet/leave/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-calendar-alt"></i>
    <div><?php echo $this->lang->line('xin_manage_leaves');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('46',$role_resources_ids) && !in_array('409',$role_resources_ids)){?>
  <li class="sidenav-item <?php if(!empty($arr_mod['leave_active']))echo $arr_mod['leave_active'];?>"> <a href="<?php echo site_url('admin/timesheet/leave/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-calendar-alt"></i>
    <div><?php echo $this->lang->line('xin_manage_leaves');?></div>
    </a> </li>
  <?php } ?>
  <?php if(!in_array('46',$role_resources_ids) && in_array('409',$role_resources_ids)){?>
  <li class="sidenav-item <?php if(!empty($arr_mod['leave_active']))echo $arr_mod['leave_active'];?>"> <a href="<?php echo site_url('admin/reports/employee_leave/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-calendar-alt"></i>
    <div><?php echo $this->lang->line('xin_leave_status');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('44',$role_resources_ids) || in_array('312',$role_resources_ids) || in_array('119',$role_resources_ids) || in_array('94',$role_resources_ids) || in_array('424',$role_resources_ids) || in_array('425',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['project_open']))echo $arr_mod['project_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon ion ion-logo-buffer"></i>
    <div><?php echo $this->lang->line('xin_projects_manager_title');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('312',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['projects_dashboard_active']))echo $arr_mod['projects_dashboard_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/project/projects_dashboard/');?>" > <?php echo $this->lang->line('dashboard_title');?> </a> </li>
      <?php } ?>
      <?php if(in_array('44',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['project_active']))echo $arr_mod['project_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/project/');?>" > <?php echo $this->lang->line('left_projects');?> </a> </li>
      <?php } ?>
      <?php if(in_array('119',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['clients_active']))echo $arr_mod['clients_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/clients/');?>" > <?php echo $this->lang->line('xin_project_clients');?> </a> </li>
      <?php } ?>
      <?php if(in_array('94',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['project_timelogs_active']))echo $arr_mod['project_timelogs_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/project/timelogs/');?>" > <?php echo $this->lang->line('xin_project_timelogs');?> </a> </li>
      <?php } ?>
      <?php if(in_array('424',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['projects_calendar_active']))echo $arr_mod['projects_calendar_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/project/projects_calendar/');?>" > <?php echo $this->lang->line('xin_acc_calendar');?> </a> </li>
      <?php } ?>
      <?php if(in_array('425',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['projects_scrum_board_active']))echo $arr_mod['projects_scrum_board_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/project/projects_scrum_board/');?>" > <?php echo $this->lang->line('xin_projects_scrm_board');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('415',$role_resources_ids) || in_array('410',$role_resources_ids) || in_array('427',$role_resources_ids) || in_array('428',$role_resources_ids) || in_array('429',$role_resources_ids) || in_array('430',$role_resources_ids)){?>
  <li class="<?php if(!empty($arr_mod['hr_quote_manager_open']))echo $arr_mod['hr_quote_manager_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon fa fa-tasks"></i>
    <div><?php echo $this->lang->line('xin_estimates');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('415',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['all_quotes_active']))echo $arr_mod['all_quotes_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/quotes/');?>" > <?php echo $this->lang->line('xin_estimates');?> </a> </li>
      <?php } ?>
      <?php if(in_array('427',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['quote_calendar_active']))echo $arr_mod['quote_calendar_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" > <?php echo $this->lang->line('xin_quote_calendar');?> </a> </li>
      <?php } ?>
      <?php if(in_array('429',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['leadsl_quotes_active']))echo $arr_mod['leadsl_quotes_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/leads/');?>" > <?php echo $this->lang->line('xin_leads');?> </a> </li>
      <?php } ?>
      <?php if(in_array('430',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['timelogs_quotes_active']))echo $arr_mod['timelogs_quotes_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/timelogs/');?>" > <?php echo $this->lang->line('xin_project_timelogs');?> </a> </li>
      <?php } ?>
      <?php if(in_array('428',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['quoted_projects_active']))echo $arr_mod['quoted_projects_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/');?>" > <?php echo $this->lang->line('xin_quoted_projects');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } //297?>
  <?php if($system[0]->module_recruitment=='true'){?>
  <?php  if(in_array('49',$role_resources_ids) || in_array('51',$role_resources_ids) || in_array('52',$role_resources_ids) || in_array('296',$role_resources_ids)) {?>
  <li class="<?php if(!empty($arr_mod['recruit_open']))echo $arr_mod['recruit_open'];?> sidenav-item"> <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon fas fa-newspaper"></i>
    <div><?php echo $this->lang->line('left_recruitment');?></div>
    </a>
    <ul class="sidenav-menu">
      <?php if(in_array('49',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['jb_post_active']))echo $arr_mod['jb_post_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/job_post/');?>" > <?php echo $this->lang->line('left_job_posts');?> </a> </li>
      <?php } ?>
      <?php if(in_array('51',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['job_candidates_active']))echo $arr_mod['job_candidates_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/job_candidates/');?>"> <?php echo $this->lang->line('left_job_candidates');?> </a> </li>
      <?php } ?>
      <?php if(in_array('52',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['jb_employer_active']))echo $arr_mod['jb_employer_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/job_post/employer/');?>" > <?php echo $this->lang->line('xin_jobs_employer');?> </a> </li>
      <?php } ?>
      <?php if(in_array('296',$role_resources_ids)) { ?>
      <li class="sidenav-item <?php if(!empty($arr_mod['jb_pages_active']))echo $arr_mod['jb_pages_active'];?>"> <a class="sidenav-link" href="<?php echo site_url('admin/job_post/pages/');?>" > <?php echo $this->lang->line('xin_jobs_cms_pages');?> </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php } ?>
  <?php if($system[0]->module_performance=='yes'){?>
  <?php if($system[0]->performance_option == 'goal'): ?>
  <?php if(in_array('106',$role_resources_ids) || in_array('107',$role_resources_ids) || in_array('108',$role_resources_ids)){?>
  <?php if(in_array('107',$role_resources_ids) && in_array('108',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/goal_tracking/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('107',$role_resources_ids) && !in_array('108',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/goal_tracking/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php if(!in_array('107',$role_resources_ids) && in_array('108',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/goal_tracking/type/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?></div>
    </a> </li>
  <?php } ?>
  <?php } ?>
  <?php elseif($system[0]->performance_option == 'appraisal'): ?>
  <?php if(in_array('40',$role_resources_ids) || in_array('41',$role_resources_ids) || in_array('42',$role_resources_ids)) {?>
  <?php if(in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php if(!in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('41',$role_resources_ids) && !in_array('42',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/performance_indicator/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php } ?>
  <?php else:?>
  <?php if(in_array('40',$role_resources_ids) || in_array('41',$role_resources_ids) || in_array('42',$role_resources_ids)) {?>
  <?php if(in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php if(!in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('41',$role_resources_ids) && !in_array('42',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> <a href="<?php echo site_url('admin/performance_indicator/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
    <div><?php echo $this->lang->line('left_performance');?></div>
    </a> </li>
  <?php } ?>
  <?php } ?>
  <?php endif;?>
  <?php } ?>
</ul>
