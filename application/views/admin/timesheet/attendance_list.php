<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_timesheet_dashboard_title');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('28',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/attendance/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_attendance');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_attendance');?> <?php echo $this->lang->line('xin_role_list');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('30',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/update_attendance');?>" data-link-data="<?php echo site_url('admin/timesheet/update_attendance');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-pencil-alt"></span> <?php echo $this->lang->line('left_update_attendance');?>
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
<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'attendance_daily_report', 'id' => 'attendance_daily_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/timesheet/attendance_list', $attributes, $hidden);?>
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
    <?php if($user_info[0]->user_role_id==1){ ?>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
      <select name="location_id" id="location_id" class="form-control custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
        <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
        <?php foreach($all_office_shifts as $elocation) {?>
        <option value="<?php echo $elocation->location_id?>"><?php echo $elocation->location_name?></option>
        <?php } ?>
      </select>
    </div>
    <?php } else {?>
    <input type="hidden" value="0" name="location_id" id="location_id" />
    <?php } ?>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('xin_e_details_date');?></label>
      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="attendance_date" name="attendance_date" type="text" value="<?php echo date('Y-m-d');?>">
    </div>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block save"><?php echo $this->lang->line('xin_get');?></button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
<?php if(in_array('29',$role_resources_ids)) { ?>
<div id="date_wise_attendance" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
  <div class="ui-bordered px-4 pt-4 mb-4">
    <?php $attributes = array('name' => 'attendance_datewise_report', 'id' => 'attendance_datewise_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
    <?php $hidden = array('euser_id' => $session['user_id']);?>
    <?php echo form_open('admin/timesheet/datewise_attendance_list', $attributes, $hidden);?>
    <?php
		$data = array(
		  'type'        => 'hidden',
		  'name'        => 'user_id',
		  'id'          => 'user_id',
		  'value'       => $session['user_id'],
		  'class'       => 'form-control',
		);
		echo form_input($data);
		?>
    <div class="form-row">
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('xin_start_date');?></label>
        <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
      </div>
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('xin_end_date');?></label>
        <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
      </div>
      <?php if(!in_array('381',$role_resources_ids) && $user[0]->user_role_id!=1) {?>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
      </div>
      <?php } ?>
      <?php if($user_info[0]->user_role_id==1 || in_array('381',$role_resources_ids)) {?>
      <div class="col-md mb-4">
        <?php if($user_info[0]->user_role_id==1){?>
        <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
        <select class="form-control custom-select" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
          <option value=""></option>
          <?php foreach($get_all_companies as $company) {?>
          <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
          <?php } ?>
        </select>
        <?php } else {?>
        <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
        <select class="form-control custom-select" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
          <option value=""></option>
          <?php foreach($get_all_companies as $company) {?>
          <?php if($user_info[0]->company_id == $company->company_id):?>
          <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
          <?php endif;?>
          <?php } ?>
        </select>
        <?php } ?>
      </div>
      <div class="col-md mb-3" id="employee_ajax">
        <label class="form-label"><?php echo $this->lang->line('xin_employee');?></label>
        <select name="employee_id" id="employee_id" class="form-control custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
          <option value="">All</option>
        </select>
      </div>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
      </div>
      <?php } ?>
    </div>
    <?php echo form_close(); ?> </div>
</div>
<?php } ?>
<div class="card">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_daily_attendance_report');?></strong></span>
      <?php if(in_array('29',$role_resources_ids)) { ?>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#date_wise_attendance" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('left_date_wise_attendance');?></button>
      </a> </div>
      <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th colspan="3"><?php echo $this->lang->line('xin_hr_info');?></th>
            <th colspan="9"><?php echo $this->lang->line('xin_attendance_report');?></th>
          </tr>
          <tr>
            <th style="width:120px;"><?php echo $this->lang->line('xin_employee');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_employee_id');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('left_company');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_in');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_out');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_late');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_early_leaving');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_overtime');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_work');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_rest');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>