<?php
/* Payment History view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('36',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/payroll/generate_payslip/');?>" data-link-data="<?php echo site_url('admin/payroll/generate_payslip/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-calculator"></span> <?php echo $this->lang->line('left_payroll');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_generate_payslip');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('37',$role_resources_ids)) { ?>  
    <li class="nav-item active"> <a href="<?php echo site_url('admin/payroll/payment_history/');?>" data-link-data="<?php echo site_url('admin/payroll/payment_history/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-ios-cash"></span> <?php echo $this->lang->line('xin_payslip_history');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_payslip_history');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if($user_info[0]->user_role_id==1){ ?>
<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'payroll_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/payroll/payment_history_list', $attributes, $hidden);?>
  <?php
        $data = array(
          'type'        => 'hidden',
          'name'        => 'date_format',
          'id'          => 'date_format',
          'value'       => $this->Xin_model->set_date_format(date('Y-m-d')),
          'class'       => 'form-control',
        );
        echo form_input($data);
        ?>
  <div class="form-row">
    <div class="col-md mb-4">
      <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
      <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
        <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
        <?php foreach($get_all_companies as $company) {?>
        <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md mb-4" id="location_ajax">
      <label for="name"><?php echo $this->lang->line('left_location');?></label>
      <select disabled="disabled" name="location_id" id="aj_location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
        <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
      </select>
    </div>
    <div class="col-md mb-4" id="department_ajax">
      <label for="department"><?php echo $this->lang->line('left_department');?></label>
      <select class="form-control" id="aj_subdepartments" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" disabled="disabled">
        <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
      </select>
    </div>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('xin_select_month');?></label>
      <input type="text" class="form-control hr_month_year" name="salary_month" id="salary_month" placeholder="<?php echo $this->lang->line('xin_salary_month');?>" value="<?php echo date('Y-m');?>" />
    </div>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_search');?> </button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
<?php } ?>
<div class="card <?php echo $get_animate;?> mt-3">
  <div class="box-header with-border">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_payment_history');?></span>
      <?php if($user_info[0]->user_role_id==1){ ?>
      <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employee_name');?></th>
            <th><i class="fa fa-building"></i> <?php echo $this->lang->line('module_company_title');?></th>
            <th><?php echo $this->lang->line('xin_acc_account');?>#</th>
            <th><?php echo $this->lang->line('xin_payroll_net_payable');?></th>
            <th><?php echo $this->lang->line('xin_salary_month');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_payroll_date_title');?></th>
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
