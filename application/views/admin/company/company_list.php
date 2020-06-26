<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('5',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/company/');?>" data-link-data="<?php echo site_url('admin/company/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-business"></span> <?php echo $this->lang->line('left_company');?>
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
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/designation/');?>" data-link-data="<?php echo site_url('admin/designation/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-dev"></span> <?php echo $this->lang->line('left_designation');?>
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

<?php if(in_array('246',$role_resources_ids)) {?>

<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('module_company_title');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_company', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/company/add_company', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="name" type="text">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?php echo $this->lang->line('xin_company_type');?></label>
                    <select class="form-control" name="company_type" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_company_type');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <?php foreach($get_company_types as $ctype) {?>
                      <option value="<?php echo $ctype->type_id;?>"> <?php echo $ctype->name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="trading_name"><?php echo $this->lang->line('xin_company_trading');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_trading');?>" name="trading_name" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="registration_no"><?php echo $this->lang->line('xin_company_registration');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_registration');?>" name="registration_no" type="text">
                  </div>
                  <div class="col-md-6">
                    <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
                  </div>
                  <div class="col-md-6">
                    <label for="website"><?php echo $this->lang->line('xin_website');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>" name="website" type="text">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="xin_gtax"><?php echo $this->lang->line('xin_gtax');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_gtax');?>" name="xin_gtax" type="text">
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
                <select class="form-control" name="country" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?php echo $country->country_id;?>"> <?php echo $country->country_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text">
            </div>
            <div class="col-md-3">
              <label for="website"><?php echo $this->lang->line('xin_employee_password');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text">
            </div>
            <div class="col-md-6">
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('xin_company_logo');?></label>
                <input type="file" class="form-control-file" id="logo" name="logo">
                <small><?php echo $this->lang->line('xin_company_file_type');?></small>
              </fieldset>
            </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email"><?php echo $this->lang->line('xin_invoice_currency');?></label>
                  <select class="form-control" name="default_currency" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_invoice_currency');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($this->Xin_model->get_currencies() as $currency){?>
                    <?php $_currency = $currency->code.' - '.$currency->symbol;?>
                    <option value="<?php echo $_currency;?>"> <?php echo $_currency;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_setting_timezone');?></label>
                  <select class="form-control" name="default_timezone" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_setting_timezone');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($this->Xin_model->all_timezones() as $tval=>$labels):?>
                    <option value="<?php echo $tval;?>"><?php echo $labels;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
            </div>
        </div>
        <?php $count_module_attributes = $this->Custom_fields_model->count_company_module_attributes();?>
            <?php if($count_module_attributes > 0):?>
            <div class="row">
              <?php $module_attributes = $this->Custom_fields_model->company_hrsale_module_attributes();?>
              <?php foreach($module_attributes as $mattribute):?>
              <?php if($mattribute->attribute_type == 'date'){?>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                  <input class="form-control date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                </div>
              </div>
              <?php } else if($mattribute->attribute_type == 'select'){?>
              <div class="col-md-4">
                <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                <div class="form-group">
                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                  <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                    <?php foreach($iselc_val as $selc_val) {?>
                    <option value="<?php echo $selc_val->attributes_select_value_id?>"><?php echo $selc_val->select_label?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } else if($mattribute->attribute_type == 'multiselect'){?>
              <div class="col-md-4">
                <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                <div class="form-group">
                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                  <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                    <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                    <option value="<?php echo $multi_selc_val->attributes_select_value_id?>"><?php echo $multi_selc_val->select_label?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } else if($mattribute->attribute_type == 'textarea'){?>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                  <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                </div>
              </div>
              <?php } else if($mattribute->attribute_type == 'fileupload'){?>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                  <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
                </div>
              </div>
              <?php } else { ?>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                  <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                </div>
              </div>
              <?php }	?>
              <?php endforeach;?>
            </div>
            <?php endif;?>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_companies');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('module_company_title');?></th>
            <th><i class="fa fa-envelope"></i> <?php echo $this->lang->line('xin_email');?></th>
            <th><?php echo $this->lang->line('xin_city');?></th>
            <th><?php echo $this->lang->line('xin_country');?></th>
            <th><?php echo $this->lang->line('xin_invoice_currency');?></th>
            <th><?php echo $this->lang->line('xin_setting_timezone');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
