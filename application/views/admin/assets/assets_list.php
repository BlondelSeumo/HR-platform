<?php
/* Assets view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('25',$role_resources_ids)) {?>
    <li class="nav-item active">
      <a href="<?php echo site_url('admin/assets/');?>" data-link-data="<?php echo site_url('admin/assets/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-md-today"></span>
        <?php echo $this->lang->line('xin_assets');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_assets');?></div>
      </a>
    </li>
    <?php } ?>
    <?php if(in_array('26',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/assets/category/');?>" data-link-data="<?php echo site_url('admin/assets/category/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fab fa-typo3"></span>
        <?php echo $this->lang->line('xin_acc_category');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_acc_category');?></div>
      </a>
    </li>
   <?php } ?>
  </ul>
 </div> 
  <hr class="border-light m-0 mb-3">
    <?php if(in_array('262',$role_resources_ids)) {?>
      <div class="card mb-4 <?php echo $get_animate;?>">
          <div id="accordion">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_asset');?></span>
              <div class="card-header-elements ml-md-auto">
                <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
                </a> </div>
            </div>
            <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
              <div class="card-body">
                <?php $attributes = array('name' => 'add_assets', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open_multipart('admin/assets/add_asset', $attributes, $hidden);?>
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="first_name"><?php echo $this->lang->line('xin_acc_category');?></label>
                            <select class="form-control" name="category_id" id="category_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_category');?>">
                              <option value=""></option>
                              <?php foreach($all_assets_categories as $assets_category) {?>
                              <option value="<?php echo $assets_category->assets_category_id?>"><?php echo $assets_category->category_name?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="asset_name" class="control-label"><?php echo $this->lang->line('xin_asset_name');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_asset_name');?>" name="asset_name" type="text" value="">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <?php if($user_info[0]->user_role_id==1){ ?>
                          <div class="form-group">
                            <label for="company_id"><?php echo $this->lang->line('left_company');?></label>
                            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                              <option value=""></option>
                              <?php foreach($all_companies as $company) {?>
                              <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <?php } else {?>
                          <?php $ecompany_id = $user_info[0]->company_id;?>
                          <div class="form-group">
                            <label for="company_id"><?php echo $this->lang->line('left_company');?></label>
                            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                              <option value=""></option>
                              <?php foreach($all_companies as $company) {?>
                                  <?php if($ecompany_id == $company->company_id):?>
                                  <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                                  <?php endif;?>
                              <?php } ?>
                            </select>
                          </div>
                          <?php } ?>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" id="employee_ajax">
                            <label for="first_name"><?php echo $this->lang->line('xin_assets_assign_to');?></label>
                            <select class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                              <option value=""></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="manufacturer"><?php echo $this->lang->line('xin_manufacturer');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_manufacturer');?>" name="manufacturer" type="text" value="">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="xin_serial_number" class="control-label"><?php echo $this->lang->line('xin_serial_number');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_serial_number');?>" name="serial_number" type="text" value="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="company_asset_code"><?php echo $this->lang->line('xin_company_asset_code');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_asset_code');?>" name="company_asset_code" type="text" value="">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="is_working" class="control-label"><?php echo $this->lang->line('xin_is_working');?></label>
                            <select class="form-control" name="is_working" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_is_working');?>">
                              <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                              <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="purchase_date"><?php echo $this->lang->line('xin_purchase_date');?></label>
                            <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_purchase_date');?>" name="purchase_date" type="text" value="">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="role"><?php echo $this->lang->line('xin_invoice_number');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_invoice_number');?>" name="invoice_number" type="text" value="">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="warranty_end_date" class="control-label"><?php echo $this->lang->line('xin_warranty_end_date');?></label>
                            <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_warranty_end_date');?>" name="warranty_end_date" type="text" value="">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="asset_image"><?php echo $this->lang->line('xin_asset_image');?></label>
                              <input type="file" class="form-control-file" id="asset_image" name="asset_image">
                              <small><?php echo $this->lang->line('xin_asset_allowed_image_formats');?></small>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="award_information"><?php echo $this->lang->line('xin_asset_note');?></label>
                    <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_asset_note');?>" name="asset_note" cols="30" rows="3" id="asset_note"></textarea>
                  </div>
                </div>
                <?php $count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();?>
                    <?php if($count_module_attributes > 0):?>
                    <div class="row">
                      <?php $module_attributes = $this->Custom_fields_model->assets_hrsale_module_attributes();?>
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
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_assets');?></span>
            </div>
          <div class="card-body">
          <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="xin_table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('xin_action');?></th>
                  <th><i class="fa fa-flask"></i> <?php echo $this->lang->line('xin_asset_name');?></th>
                  <th><?php echo $this->lang->line('xin_acc_category');?></th>
                  <th><?php echo $this->lang->line('xin_company_asset_code');?></th>
                  <th><?php echo $this->lang->line('xin_is_working');?></th>
                  <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_assets_assign_to');?></th>
                  <th><?php echo $this->lang->line('left_company');?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        </div>    
