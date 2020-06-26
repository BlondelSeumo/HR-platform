<?php
/* Employee Exit view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $xuser_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($xuser_info[0]->user_role_id==1){ ?>
<div id="filter_hrsale" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
<div class="row">
  <div class="col-md-12">
    <div class="box mb-4">
    <div class="box-header  with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_filter');?></h3>
          <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-minus"></span> <?php echo $this->lang->line('xin_hide');?></button>
            </a> </div>
        </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'class' => 'm-b-1 add form-hrm');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/employee_exit/exit_list', $attributes, $hidden);?>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="department"><?php echo $this->lang->line('module_company_title');?></label>
                  <select class="form-control" name="company" id="aj_companyf" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
                    <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" id="employee_ajaxf">
                  <label for="department"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                  <select id="employee_id" name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value="0"><?php echo $this->lang->line('xin_all_employees');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <label for="status"><?php echo $this->lang->line('xin_exit_interview');?></label>
                    <select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                      <option value="all" ><?php echo $this->lang->line('xin_acc_all');?></option>
                      <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                      <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                    </select>
                  </div>
              </div>
              <div class="col-md-1"><label for="xin_get">&nbsp;</label><button name="hrsale_form" type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_get');?></button>
            </div>
            </div>
            
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php } ?>
<?php if(in_array('204',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_employee_exit');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_exit', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/employee_exit/add_exit', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?><i class="hrsale-asterisk">*</i></label>
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
                  <label for="first_name"><?php echo $this->lang->line('left_company');?><i class="hrsale-asterisk">*</i></label>
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
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_employee_to_exit');?><i class="hrsale-asterisk">*</i></label>
                  <select disabled="disabled" name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exit_date"><?php echo $this->lang->line('xin_exit_date');?><i class="hrsale-asterisk">*</i></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_exit_date');?>" readonly name="exit_date" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="type"><?php echo $this->lang->line('xin_type_of_exit');?><i class="hrsale-asterisk">*</i></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_type_of_exit');?>" name="type">
                        <option value=""></option>
                        <?php foreach($all_exit_types as $exit_type) {?>
                        <option value="<?php echo $exit_type->exit_type_id?>"><?php echo $exit_type->type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="reason" rows="5" id="reason"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exit_interview"><?php echo $this->lang->line('xin_exit_interview');?><i class="hrsale-asterisk">*</i></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_exit_interview');?>" name="exit_interview">
                        <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="is_inactivate_account"><?php echo $this->lang->line('xin_exit_inactive_employee_account');?><i class="hrsale-asterisk">*</i></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_exit_inactive_employee_account');?>" name="is_inactivate_account">
                        <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                      </select>
                    </div>
                  </div>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_exit');?></span> </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style="width:96px;"><?php echo $this->lang->line('xin_action');?></th>
            <th width="380"><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_single_employee');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><?php echo $this->lang->line('xin_exit_type');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_exit_date');?></th>
            <th><?php echo $this->lang->line('xin_exit_interview');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
