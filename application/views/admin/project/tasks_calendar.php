<?php $session = $this->session->userdata('username');?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('45',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/timesheet/tasks/');?>" data-link-data="<?php echo site_url('admin/timesheet/tasks/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-fantasy-flight-games"></span> <?php echo $this->lang->line('left_tasks');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_tasks');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('90',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/project/tasks_calendar/');?>" data-link-data="<?php echo site_url('admin/project/tasks_calendar/');?>" class="mb-3 nav-link hrsale-link">
    <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_tasks_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_tasks_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('91',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/tasks_scrum_board/');?>" data-link-data="<?php echo site_url('admin/project/tasks_scrum_board/');?>" class="mb-3 nav-link hrsale-link">
    <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('xin_tasks_sboard');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_tasks_sboard');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
    <div class="row">
      <div class="col-md-3">
        <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_calendar_options');?></strong></span> </div>
            <input type="hidden" id="exact_date" value="" />
            <div class="list-group" id="list_group">
              <span class="list-group-item calendar-options hrsale-drag-option" data-record="0"> <i class="ion ion-md-done-all text-success"></i> &nbsp; <?php echo $this->lang->line('xin_completed');?></span>
              <span class="list-group-item calendar-options text-aqua hrsale-drag-option" data-record="0"> <i class="ion ion-ios-list text-primary"></i> &nbsp; <?php echo $this->lang->line('xin_in_progress');?></span>
              <span class="list-group-item calendar-options text-purple hrsale-drag-option" data-record="0"> <i class="ion ion-md-football text-info"></i> &nbsp; <?php echo $this->lang->line('xin_not_started');?></span>
              <span class="list-group-item calendar-options text-red hrsale-drag-option" data-record="0"> <i class="ion ion-md-close-circle-outline text-danger"></i> &nbsp; <?php echo $this->lang->line('xin_project_cancelled');?></span>
              <span class="list-group-item calendar-options text-yellow hrsale-drag-option" data-record="0"> <i class="ion ion-md-flash-off text-warning"></i> &nbsp; <?php echo $this->lang->line('xin_project_hold');?></span>
            </div>  
            <div class="card-body">
            <?php $attributes = array('name' => 'hr_calendar_option', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('', $attributes, $hidden);?>
            <div class="form-body">
              <div class="form-group">
                <label for="set_date"><?php echo $this->lang->line('xin_set_date');?></label>
                <input class="form-control set_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="set_date" name="set_date" type="text" value="<?php if(isset($_POST['set_date'])){ echo $_POST['set_date']; } else { echo date('Y-m-d'); }?>">
              </div>
            </div>
            <div class="form-actions right">
              <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_get');?></button>
            </div>
            <?php echo form_close(); ?>
            </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card">
          <div class="card-body">
            <div id='calendar_hr'></div>
          </div>
        </div>
      </div>
    </div>