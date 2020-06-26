<?php
/* User Roles view
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
    <li class="nav-item active"> <a href="<?php echo site_url('admin/roles/');?>" class="mb-3 nav-link hrsale-link" data-link-data="<?php echo site_url('admin/roles/');?>"> <span class="sw-icon ion ion-md-unlock"></span> <?php echo $this->lang->line('xin_role_urole');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_set_roles');?></div>
      </a> </li>
     <?php } ?>
    <?php if(in_array('7',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/office_shift/');?>" data-link-data="<?php echo site_url('admin/timesheet/office_shift/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_office_shifts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('left_office_shifts');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_employee_role');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_role_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_role_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'add_role', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('_user' => $session['user_id']);?>
            <?php echo form_open('admin/roles/add_role', $attributes, $hidden);?>
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_name"><?php echo $this->lang->line('xin_role_name');?><i class="hrsale-asterisk">*</i></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_role_name');?>" name="role_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_access"><?php echo $this->lang->line('xin_role_access');?><i class="hrsale-asterisk">*</i></label>
                        <select class="form-control custom-select" id="role_access" data-plugin="select_hrm" name="role_access"  data-placeholder="<?php echo $this->lang->line('xin_role_access');?>">
                          <option value="">&nbsp;</option>
                          <option value="1"><?php echo $this->lang->line('xin_role_all_menu');?></option>
                          <option value="2"><?php echo $this->lang->line('xin_role_cmenu');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <p><strong><?php echo $this->lang->line('xin_role_note_title');?></strong></p>
                      <p><?php echo $this->lang->line('xin_role_note1');?></p>
                      <p><?php echo $this->lang->line('xin_role_note2');?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="resources"><?php echo $this->lang->line('xin_role_resource');?></label>
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r1"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r2"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_roles');?></span>
    <div class="card-header-elements ml-md-auto"> <a href="<?php echo site_url('admin/reports/');?>" class="text-dark collapsed">
      <button type="button" class="btn btn-xs btn-primary"> <span class="fas fa-chart-bar"></span> <?php echo $this->lang->line('xin_report');?></button>
      </a> </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_role_rid');?></th>
            <th><?php echo $this->lang->line('xin_role_name');?></th>
            <th><?php echo $this->lang->line('xin_role_menu_per');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_role_added_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.k-in { display:none !important; }
</style>
