<?php
/* Leave Application view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_employee_info($session['user_id']);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('287',$role_resources_ids)) {?>
<?php $leave_categories = $user[0]->leave_categories;?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_leave');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_leave', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/add_leave', $attributes, $hidden);?>
        <?php $leaave_cat = get_employee_leave_category($leave_categories,$session['user_id']);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="leave_type" class="control-label"><?php echo $this->lang->line('xin_leave_type');?></label>
                  <select class="form-control" id="leave_type" name="leave_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
                    <option value=""></option>
                    <?php foreach($leaave_cat as $type) {?>
                    <option value="<?php echo $type->leave_type_id;?>"> <?php echo $type->type_name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="">
                    </div>
                  </div>
                </div>
                <?php $role_resources_ids = $this->Xin_model->user_role_resource();
				if(!in_array('383',$role_resources_ids)) { ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                      <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                        <option value=""></option>
                        <?php foreach($get_all_companies as $company) {?>
                        <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="employee_ajax">
                      <label for="employees" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
                      <select disabled="disabled" class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
                <?php } else {?>
                <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $session['user_id'];?>" />
                <input type="hidden" name="company_id" id="company_id" value="<?php echo $user[0]->company_id;?>" />
                <?php } ?>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" rows="5"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="summary"><?php echo $this->lang->line('xin_leave_reason');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_leave_reason');?>" name="reason" cols="30" rows="3" id="reason"></textarea>
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
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_leave');?></h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_employee');?></th>
            <th><?php echo $this->lang->line('xin_leave_type');?></th>
            <th><?php echo $this->lang->line('xin_leave_duration');?></th>
            <th><?php echo $this->lang->line('xin_applied_on');?></th>
            <th><?php echo $this->lang->line('xin_reason');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
