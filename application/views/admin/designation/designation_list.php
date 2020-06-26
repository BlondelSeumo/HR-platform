<?php
/*
* Designation View
*/
$session = $this->session->userdata('username');
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('5',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/company/');?>" data-link-data="<?php echo site_url('admin/company/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-business"></span> <?php echo $this->lang->line('left_company');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_companies');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('6',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/location/');?>" data-link-data="<?php echo site_url('admin/location/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-location-arrow"></span> <?php echo $this->lang->line('left_location');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_locations');?></div>
      </a> </li>
     <?php } ?>
    <?php if(in_array('3',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/department/');?>" data-link-data="<?php echo site_url('admin/department/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-codepen"></span> <?php echo $this->lang->line('left_department');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('left_department');?></div>
      </a> </li>
     <?php } ?>
    <?php if(in_array('4',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/designation/');?>" data-link-data="<?php echo site_url('admin/designation/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-dev"></span> <?php echo $this->lang->line('left_designation');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('left_designation');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('11',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/announcement/');?>" data-link-data="<?php echo site_url('admin/announcement/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-megaphone"></span> <?php echo $this->lang->line('left_announcements');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_announcements');?></div>
      </a> </li>
     <?php } ?>    
     <?php if(in_array('9',$role_resources_ids)) { ?>
     <li class="nav-item clickable"> <a href="<?php echo site_url('admin/policy/');?>" data-link-data="<?php echo site_url('admin/policy/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-yelp"></span> <?php echo $this->lang->line('left_policies');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('header_policies');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('243',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_designation');?></span>
      
    </div>
      <div class="card-body">
      <?php $attributes = array('name' => 'add_designation', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/designation/add_designation', $attributes, $hidden);?>
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
        <?php } else { ?>
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
        <div class="form-group" id="department_ajax">
          <label for="name"><?php echo $this->lang->line('xin_hr_main_department');?></label>
          <select disabled="disabled" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="department_id">
            <option value=""></option>
          </select>
        </div>
        <?php if($system[0]->is_active_sub_departments=='yes'){?>
        <div class="form-group" id="subdepartment_ajax">
          <label for="name"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
          <select disabled="disabled" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="subdepartment_id">
            <option value=""></option>
          </select>
        </div>
        <?php } else {?>
        <input type="hidden" name="subdepartment_id" value="0" />
        <?php } ?>
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_designation_name');?></label>
          <input type="text" class="form-control" name="designation_name" placeholder="<?php echo $this->lang->line('xin_designation_name');?>">
        </div>
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea type="text" class="form-control" name="description" placeholder="<?php echo $this->lang->line('xin_description');?>"></textarea>
        </div>
      
      <div class="form-actions box-footer">
        <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
      </div>
      <?php echo form_close(); ?> </div></div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_designations');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th style="width:65px;"><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_designation');?></th>
                <th><?php echo $this->lang->line('left_company');?></th>
                <!--<th><?php echo $this->lang->line('xin_department');?></th>
                <th><?php echo $this->lang->line('xin_hr_sub_department');?></th>-->
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
