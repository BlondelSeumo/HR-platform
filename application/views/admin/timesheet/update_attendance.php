<?php
/* Update Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_timesheet_dashboard_title');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('28',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/attendance/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_attendance');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_attendance');?> <?php echo $this->lang->line('xin_role_list');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('30',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/update_attendance');?>" data-link-data="<?php echo site_url('admin/timesheet/update_attendance');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-pencil-alt"></span> <?php echo $this->lang->line('left_update_attendance');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_edit_info');?> <?php echo $this->lang->line('left_attendance');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('10',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_month_timesheet_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view_all');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('261',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-calendar"></span> <?php echo $this->lang->line('xin_acc_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('401',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/overtime_request/');?>" data-link-data="<?php echo site_url('admin/overtime_request/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-timer"></span> <?php echo $this->lang->line('xin_overtime_request');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_overtime_request');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('left_update_attendance');?></strong></span> </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'update_attendance_report', 'id' => 'update_attendance_report', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/timesheet/update_attendance', $attributes, $hidden);?>
            <?php
				$data = array(
				  'name'        => 'emp_id',
				  'id'          => 'emp_id',
				  'value'       => $session['user_id'],
				  'type'   		=> 'hidden',
				  'class'       => 'form-control',
				);
			
				echo form_input($data);
				?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly id="attendance_date" name="attendance_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <?php } else if(in_array('310',$role_resources_ids)) {?>
                <?php $ecompany_id = $user_info[0]->company_id;?>
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <?php if($ecompany_id == $company->company_id):?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
                <?php } ?>
                <?php if($user_info[0]->user_role_id==1 || in_array('310',$role_resources_ids)){ ?>
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
                  <select disabled="disabled" name="employee_id" id="up_employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                  </select>
                </div>
                <?php } else {?>
                <input type="hidden" name="employee_id" id="up_employee_id" value="<?php echo $session['user_id'];?>" />
                <?php }?>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('left_update_attendance');?></strong></span>
        <div class="card-header-elements ml-md-auto">
          <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
          <?php if(in_array('277',$role_resources_ids)) {?>
          <button type="button" class="btn btn-xs btn-primary" id="add_attendance_btn" data-toggle="modal" style="display:none;" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
          <?php } else {?>
          <span id="add_attendance_btn" style="display:none;">&nbsp;</span>
          <?php } ?>
        </div>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_in_time');?></th>
                <th><?php echo $this->lang->line('xin_out_time');?></th>
                <th><?php echo $this->lang->line('dashboard_total_work');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
