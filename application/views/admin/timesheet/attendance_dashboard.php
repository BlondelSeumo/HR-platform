<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
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
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/overtime_request/');?>" data-link-data="<?php echo site_url('admin/overtime_request/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-timer"></span> <?php echo $this->lang->line('xin_overtime_request');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_overtime_request');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<?php if(in_array('28',$role_resources_ids) || in_array('401',$role_resources_ids)) { ?>
<hr class="border-light m-0 mb-3">
<div class="row">
<?php if(in_array('28',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title">Attendance Status</div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                    <td><?php echo $this->lang->line('xin_absent');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                    <td><?php echo $this->lang->line('xin_emp_working');?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="attendance_status"  style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if(in_array('401',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title">Overtime Request Status</div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                    <td><?php echo $this->lang->line('xin_approved');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #FFD950;"></div></td>
                    <td><?php echo $this->lang->line('xin_pending');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                    <td><?php echo $this->lang->line('xin_rejected');?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="hrsale_overtime_request" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>