<?php
/* Date Wise Attendance Report > EMployees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('46',$role_resources_ids)) { ?>
    <li class="nav-item clickable">
      <a  href="<?php echo site_url('admin/timesheet/leave/');?>" data-link-data="<?php echo site_url('admin/timesheet/leave/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon oi oi-calculator"></span>
        <?php echo $this->lang->line('xin_manage_leaves');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_hr_calendar_lv_request');?></div>
      </a>
    </li>
    <?php } ?>
    <?php if(in_array('409',$role_resources_ids)) { ?>
    <li class="nav-item active">
      <a  href="<?php echo site_url('admin/reports/employee_leave/');?>" data-link-data="<?php echo site_url('admin/reports/employee_leave/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fas fa-chalkboard-teacher"></span>
        <?php echo $this->lang->line('xin_leave_status');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_leave_status');?></div>
      </a>
    </li>
    <?php } ?>
  </ul>
</div>  
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_report_filters');?></strong></span>
    </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'training_report', 'id' => 'training_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/reports/training_report', $attributes, $hidden);?>
            <?php
                    $data = array(
                      'name'        => 'user_id',
                      'id'          => 'user_id',
                      'type'        => 'hidden',
                      'value'   	   => $session['user_id'],
                      'class'       => 'form-control',
                    );
                
                echo form_input($data);
                ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>" <?php /*?><?php if($company_id==$company->company_id):?> selected 
						<?php endif;?><?php */?>><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } else {?>
            <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
						<?php if($ecompany_id == $company->company_id):?>
                        <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                        <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="employee_ajax">
                  <select name="employee_id" id="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                    <option value="">All</option>
                    <!--<?php foreach($result as $employee) {?>
                        <option value="<?php echo $employee->user_id;?>" <?php if($session['user_id']==$employee->user_id):?> selected <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                        <?php } ?>-->
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_view');?></strong> <?php echo $this->lang->line('xin_leave_status');?></span> </div>
      <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('xin_employee');?></th>
              <th><?php echo $this->lang->line('xin_approved');?></th>
              <th><?php echo $this->lang->line('xin_pending');?></th>
              <th><?php echo $this->lang->line('xin_upcoming_leave');?></th>
              <th><?php echo $this->lang->line('xin_rejected');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
</div>