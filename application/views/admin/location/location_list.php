<?php
/* Location view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/company/');?>" data-link-data="<?php echo site_url('admin/company/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-business"></span> <?php echo $this->lang->line('left_company');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_companies');?></div>
      </a> </li>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/location/');?>" data-link-data="<?php echo site_url('admin/location/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-location-arrow"></span> <?php echo $this->lang->line('left_location');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_locations');?></div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/department/');?>" data-link-data="<?php echo site_url('admin/department/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-codepen"></span> <?php echo $this->lang->line('left_department');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('left_department');?></div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/designation/');?>" data-link-data="<?php echo site_url('admin/designation/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-dev"></span> <?php echo $this->lang->line('left_designation');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('left_designation');?></div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/announcement/');?>" data-link-data="<?php echo site_url('admin/announcement/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-megaphone"></span> <?php echo $this->lang->line('left_announcements');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_announcements');?></div>
      </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/policy/');?>" data-link-data="<?php echo site_url('admin/policy/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-yelp"></span> <?php echo $this->lang->line('left_policies');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('header_policies');?></div>
      </a> </li>
  </ul>
</div>
<hr class="border-light m-0">
<?php if(in_array('250',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="card mb-4 <?php echo $get_animate;?> mt-3">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_location');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_location', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/location/add_location', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-sm-6">
              <?php if($user_info[0]->user_role_id==1){ ?>
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
                <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_companies as $company) {?>
                  <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                  <?php } ?>
                </select>
              </div>
              <?php } else {?>
              <?php $ecompany_id = $user_info[0]->company_id;?>
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
                <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_companies as $company) {?>
					  <?php if($ecompany_id == $company->company_id):?>
                      <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                      <?php endif;?>
                  <?php } ?>
                </select>
              </div>
              <?php } ?>
              <div class="form-group">
                <label for="name"><?php echo $this->lang->line('xin_location_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_location_name');?>" name="name" type="text">
              </div>
              <div class="form-group">
                <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="phone"><?php echo $this->lang->line('xin_phone');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phone');?>" name="phone" type="text">
                  </div>
                  <div class="col-md-6">
                    <label for="xin_faxn"><?php echo $this->lang->line('xin_faxn');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_faxn');?>" name="fax" type="text">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" id="employee_ajax">
                <div class="row">
                  <div class="col-md-12">
                    <label for="email"><?php echo $this->lang->line('xin_view_locationh');?></label>
                    <select class="form-control" name="location_head" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_view_locationh');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text">
                <br>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text">
                <br>
                <div class="row">
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                  </div>
                </div>
                <br>
                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?php echo $country->country_id;?>"> <?php echo $country->country_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_locations');?></span> </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_location_name');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_view_locationh');?></th>
            <th><?php echo $this->lang->line('xin_city');?></th>
            <th><?php echo $this->lang->line('xin_country');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_added_by');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
