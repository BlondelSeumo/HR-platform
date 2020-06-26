<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('415',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quotes/');?>" data-link-data="<?php echo site_url('admin/quotes/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-tasks"></span> <?php echo $this->lang->line('xin_estimates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_create_quote');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('427',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_quote_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_quote_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('429',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/leads/');?>" data-link-data="<?php echo site_url('admin/leads/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_leads');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_leads');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('430',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/quoted_projects/timelogs/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('428',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('xin_quoted_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_quoted_projects');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('315',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $project_no = $this->Xin_model->generate_random_string();?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_project_timelogs');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_projecttimelog', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/quoted_projects/add_project_timelog', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <?php $colmd = '2'; $user_date = 'timelog_date';?>
              <?php if($user_info[0]->user_role_id == '1'){?>
              <?php $colmd = '2'; $user_date = 'timelog_date';?>
              <?php } else {?>
              <?php $colmd = '3'; $user_date = 'user_timelog_date';?>
              <?php } ?>
              <?php if($user_info[0]->user_role_id == '1'){?>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="project_id" class="control-label"><?php echo $this->lang->line('xin_quoted_projects');?></label>
                    <select class="form-control" name="project_id" id="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_quoted_projects');?>">
                      <option value=""><?php echo $this->lang->line('xin_quoted_projects');?></option>
                       <?php foreach($all_projects as $project) {?>
                        <option value="<?php echo $project->project_id?>"> <?php echo $project->title;?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
               <?php } else {?>
               <?php $r_projects = $this->Quoted_project_model->get_employee_projects($session['user_id']);?>
               <div class="col-md-2">
                  <div class="form-group">
                    <label for="project_id" class="control-label"><?php echo $this->lang->line('xin_project');?></label>
                    <select class="form-control" name="project_id"  data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
                      <option value=""><?php echo $this->lang->line('xin_project');?></option>
                       <?php foreach($r_projects->result() as $project) {?>
                        <option value="<?php echo $project->project_id?>"> <?php echo $project->title;?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
               <?php } ?> 
                <div class="col-md-2">
                 <?php if($user_info[0]->user_role_id == '1'){?>
                  <div class="form-group" id="employee_ajax">
                    <label for="employees" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
                    <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee');?>">
                      <option value=""><?php echo $this->lang->line('xin_employee');?></option>
                    </select>
                  </div>
                  <?php } else {?>
                  <div class="form-group">
                    <label for="employees" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
                    <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee');?>">
                      <option value="<?php echo $session['user_id'];?>"><?php echo $user_info[0]->first_name.' '.$user_info[0]->last_name;?></option>
                    </select>
                  </div>
                  <?php } ?>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="start_time"><?php echo $this->lang->line('xin_project_timelogs_starttime');?></label>
                    <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_project_timelogs_starttime');?>" readonly name="start_time" id="start_time" type="text" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="end_time"><?php echo $this->lang->line('xin_project_timelogs_endtime');?></label>
                    <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_project_timelogs_endtime');?>" readonly name="end_time" id="end_time" type="text" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                    <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" id="start_date" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                    <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" id="end_date" value="">
                  </div>
                </div>                
              </div>
            <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" name="total_hours" id="total_hours" value="0" />
                    <label for="timelogs_memo"><?php echo $this->lang->line('xin_project_timelogs_memo');?> 
                     <span id="total_time">&nbsp;</span></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_timelogs_memo');?>" name="timelogs_memo" type="text" value="">
                  </div>
                </div>
              </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_project_timelogs');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_project');?></th>
            <th><?php echo $this->lang->line('xin_employee');?></th>
            <th><?php echo $this->lang->line('xin_start_date');?></th>
            <th><?php echo $this->lang->line('xin_end_date');?></th>
            <th><?php echo $this->lang->line('xin_overtime_thours');?></th>
            <th><?php echo $this->lang->line('xin_project_timelogs_memo');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
