<?php
/* Holidays view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php  if(in_array('98',$role_resources_ids)) {?>
    <li class="nav-item active">
      <a href="<?php echo site_url('admin/events/');?>" data-link-data="<?php echo site_url('admin/events/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fas fa-calendar-alt"></span>
        <?php echo $this->lang->line('xin_hr_events');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_hr_events');?></div>
      </a>
    </li>
    <?php } ?>
    <?php  if(in_array('98',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/events/calendar');?>" data-link-data="<?php echo site_url('admin/events/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fas fa-calendar-check"></span>
        <?php echo $this->lang->line('xin_hrsale_events_calendar');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_hrsale_events_calendar');?></div>
      </a>
    </li>
    <?php } ?>
    <?php  if(in_array('99',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/meetings/');?>" data-link-data="<?php echo site_url('admin/meetings/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fas fa-users"></span>
        <?php echo $this->lang->line('xin_hr_meetings');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_hr_meetings');?></div>
      </a>
    </li>
    <?php } ?>
    <?php  if(in_array('99',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/meetings/calendar');?>" data-link-data="<?php echo site_url('admin/events/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon far fa-calendar-check"></span>
        <?php echo $this->lang->line('xin_hrsale_meetings_calendar');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_hrsale_meetings_calendar');?></div>
      </a>
    </li>
   <?php } ?> 
  </ul>
 </div> 
<hr class="border-light m-0 mb-3"> 
<div class="row m-b-1 <?php echo $get_animate;?>">
<?php if(in_array('269',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_hr_event');?></span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_event', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/events/add_event', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-12">
            <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
            <?php } else {?>
            <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                <?php endif;?>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" id="employee_ajax">
              <label for="first_name"><?php echo $this->lang->line('dashboard_single_employee');?></label>
              <select disabled="disabled" class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="event_title"><?php echo $this->lang->line('xin_hr_event_title');?></label>
              <input type="text" class="form-control" name="event_title" placeholder="<?php echo $this->lang->line('xin_hr_event_title');?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('xin_hr_event_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_hr_event_date');?>" readonly name="event_date" type="text">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="event_time"><?php echo $this->lang->line('xin_hr_event_time');?></label>
              <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_hr_event_time');?>" readonly name="event_time" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="event_color"><?php echo $this->lang->line('xin_event_color');?></label>
              <input type="text" id="minicolors-brightness" class="form-control" value="#2655ff" name="event_color" readonly="readonly">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="event_note"><?php echo $this->lang->line('xin_hr_event_note');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_hr_event_note');?>" name="event_note" id="event_note"></textarea>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_hr_events');?></span> </div>
      <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
              <th><?php echo $this->lang->line('xin_hr_event_title');?></th>
              <th><?php echo $this->lang->line('xin_hr_event_date');?></th>
              <th><?php echo $this->lang->line('xin_hr_event_time');?></th>
            </tr>
          </thead>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>
