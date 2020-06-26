<?php
/* Office Shift view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
// reports to 
$reports_to = get_reports_team_data($session['user_id']); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('422',$role_resources_ids) && $user_info[0]->user_role_id==1) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employees/staff_dashboard/');?>" data-link-data="<?php echo site_url('admin/employees/staff_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon ion ion-md-speedometer"></span> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('hr_staff_dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_staff_dashboard_title');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('13',$role_resources_ids) || $reports_to>0) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employees/');?>" data-link-data="<?php echo site_url('admin/employees/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('dashboard_employees');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('dashboard_employees');?></div>
      </a> </li>
    <?php } ?>
    <?php if($user_info[0]->user_role_id==1) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/roles/');?>" class="mb-3 nav-link hrsale-link" data-link-data="<?php echo site_url('admin/roles/');?>"> <span class="sw-icon ion ion-md-unlock"></span> <?php echo $this->lang->line('xin_role_urole');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_set_roles');?></div>
      </a> </li>
     <?php } ?>
    <?php if(in_array('7',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/office_shift/');?>" data-link-data="<?php echo site_url('admin/timesheet/office_shift/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_office_shifts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('left_office_shifts');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('280',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('left_office_shift');?></span>
            <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_shift_form" aria-expanded="false">
              <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
              </a> </div>
          </div>
    <div id="add_shift_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_office_shift', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/add_office_shift', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-10">
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('left_company');?></label>
                  <div class="col-md-4">
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php } else {?>
                <?php $ecompany_id = $user_info[0]->company_id;?>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('left_company');?></label>
                  <div class="col-md-4">
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
						  <?php if($ecompany_id == $company->company_id):?>
                          <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                          <?php endif;?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php } ?>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_shift_name');?></label>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_shift_name');?>" name="shift_name" type="text" value="" id="name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_monday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-1" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="monday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-1" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="monday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="1"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_tuesday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-2" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="tuesday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-2" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="tuesday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="2"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_wednesday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-3" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="wednesday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-3" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="wednesday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="3"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_thursday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-4" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="thursday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-4" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="thursday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="4"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_friday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-5" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="friday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-5" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="friday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="5"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_saturday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-6" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="saturday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-6" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="saturday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="6"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_sunday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-7" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="sunday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-7" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="sunday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="7"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_office_shift');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="60"><?php echo $this->lang->line('xin_option');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><?php echo $this->lang->line('xin_day');?></th>
            <th><?php echo $this->lang->line('xin_monday');?></th>
            <th><?php echo $this->lang->line('xin_tuesday');?></th>
            <th><?php echo $this->lang->line('xin_wednesday');?></th>
            <th><?php echo $this->lang->line('xin_thursday');?></th>
            <th><?php echo $this->lang->line('xin_friday');?></th>
            <th><?php echo $this->lang->line('xin_saturday');?></th>
            <th><?php echo $this->lang->line('xin_sunday');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
