<?php
/* overtime request
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
    <li class="nav-item active"> <a href="<?php echo site_url('admin/overtime_request/');?>" data-link-data="<?php echo site_url('admin/overtime_request/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-timer"></span> <?php echo $this->lang->line('xin_overtime_request');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_overtime_request');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_overtime_request');?></strong></span>
      <div class="card-header-elements ml-md-auto"> 
        <button type="button" class="btn btn-xs btn-primary" id="add_attendance_btn" data-toggle="modal" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </div>
    </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_employee');?></th>
                <th><?php echo $this->lang->line('xin_project_no');?></th>
                <th><?php echo $this->lang->line('xin_phase_no');?></th>
                <th><?php echo $this->lang->line('xin_e_details_date');?></th>
                <th><?php echo $this->lang->line('xin_in_time');?></th>
                <th><?php echo $this->lang->line('xin_out_time');?></th>
                <th><?php echo $this->lang->line('xin_overtime_thours');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
