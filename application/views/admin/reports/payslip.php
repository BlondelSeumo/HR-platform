<?php
/* Hourly Wage/Rate view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'payslip_report', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/payslip_report', $attributes, $hidden);?>
          <div class="form-row">
          <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="col-md mb-4">
              <label class="form-label"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
            <?php } else {?>
            <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="col-md mb-4">
              <label class="form-label"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                <?php foreach($all_companies as $company) {?>
                <?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php endif;?>
                <?php } ?>
              </select>
            </div>
             <?php } ?>
            <div class="col-md mb-4">
            <div class="form-group" id="employee_ajax">
                <label class="form-label"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                <select name="employee_id" id="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                </select>
            </div>
            </div>
           
            <div class="col-md mb-4">
              <label class="form-label"><?php echo $this->lang->line('xin_award_month_year');?></label>
              <input class="form-control month_year" placeholder="<?php echo $this->lang->line('xin_award_month_year');?>" readonly name="month_year" id="month_year" type="text">
            </div>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md-12 <?php echo $get_animate;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_view');?></strong> <?php echo $this->lang->line('xin_hr_reports_payslip');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('dashboard_employee_id');?></th>
                <th><?php echo $this->lang->line('xin_employee_name');?></th>
                <th><?php echo $this->lang->line('xin_paid_amount');?></th>
                <th><?php echo $this->lang->line('xin_payment_month');?></th>
                <th><?php echo $this->lang->line('xin_payment_date');?></th>
                <th><?php echo $this->lang->line('xin_employee_type_wages');?></th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- responsive --> 
      </div>
    </div>
  </div>
</div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>