<?php
/* Generate Payslip view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php
$is_half_col = '5';
if($system[0]->is_half_monthly==1){
	$bulk_form_url = 'admin/payroll/add_half_pay_to_all';
	$is_half_col = '12';
} else {
	$bulk_form_url = 'admin/payroll/add_pay_to_all';
	$is_half_col = '5';
}
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('36',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/payroll/generate_payslip/');?>" data-link-data="<?php echo site_url('admin/payroll/generate_payslip/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-calculator"></span> <?php echo $this->lang->line('left_payroll');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_generate_payslip');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('37',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/payroll/payment_history/');?>" data-link-data="<?php echo site_url('admin/payroll/payment_history/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-ios-cash"></span> <?php echo $this->lang->line('xin_payslip_history');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_payslip_history');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'set_salary_details', 'id' => 'set_salary_details', 'class' => 'm-b-1 add form-hrm');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/payroll/set_salary_details', $attributes, $hidden);?>
  <div class="form-row">
    <?php if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){ ?>
    <div class="col-md mb-4">
      <?php if($user_info[0]->user_role_id==1){ ?>
      <label class="form-label"><?php echo $this->lang->line('module_company_title');?></label>
      <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
        <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
        <?php foreach($all_companies as $company) {?>
        <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
        <?php } ?>
      </select>
      <?php } else {?>
      <?php $ecompany_id = $user_info[0]->company_id;?>
      <label class="form-label"><?php echo $this->lang->line('module_company_title');?></label>
      <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
        <option value=""><?php echo $this->lang->line('module_company_title');?></option>
        <?php foreach($all_companies as $company) {?>
        <?php if($ecompany_id == $company->company_id):?>
        <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
        <?php endif;?>
        <?php } ?>
      </select>
      <?php } ?>
    </div>
    <div class="col-md mb-4" id="employee_ajax">
      <label class="form-label"><?php echo $this->lang->line('dashboard_single_employee');?></label>
      <select id="employee_id" name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
        <option value="0"><?php echo $this->lang->line('xin_all_employees');?></option>
      </select>
    </div>
    <?php } else {?>
    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $session['user_id'];?>" />
    <?php } ?>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('xin_select_month');?></label>
      <input class="form-control hr_month_year" placeholder="<?php echo $this->lang->line('xin_select_month');?>" id="month_year" name="month_year" type="text" value="<?php echo date('Y-m');?>">
    </div>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_search');?> </button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
<?php if($system[0]->is_half_monthly!=1){?>
<?php if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){ ?>
<div id="bulk_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
  <div class="ui-bordered px-4 pt-4 mb-4">
    <?php $attributes = array('name' => 'bulk_payment', 'id' => 'bulk_payment', 'class' => 'm-b-1 add form-hrm');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open($bulk_form_url, $attributes, $hidden);?>
    <div class="form-row">
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
        <select class="form-control" name="company_id" id="aj_companyx" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
          <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
          <?php foreach($all_companies as $company) {?>
          <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md mb-4" id="location_ajax">
        <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
        <select name="location_id" id="aj_location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
          <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
        </select>
      </div>
      <div class="col-md mb-4" id="department_ajax">
        <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
        <select class="form-control" id="aj_subdepartments" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>">
          <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
        </select>
      </div>
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('xin_select_month');?></label>
        <input class="form-control hr_month_year" placeholder="<?php echo $this->lang->line('xin_select_month');?>" id="month_year" name="month_year" type="text" value="<?php echo date('Y-m');?>">
      </div>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <button type="submit" class="btn btn-secondary btn-block"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_payroll_bulk_payment');?> </button>
      </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
<?php } ?>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_payment_info_for');?></strong> <span id="payroll_date"><?php echo date('Y-m');?></span></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#bulk_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_payroll_bulk_payment');?></button>
          </a> </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="80"><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_name');?></th>
            <th><?php echo $this->lang->line('xin_name');?></th>
            <th><?php echo $this->lang->line('xin_salary_type');?></th>
            <th><?php echo $this->lang->line('xin_salary_title');?></th>
            <th><?php echo $this->lang->line('xin_payroll_net_salary');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>