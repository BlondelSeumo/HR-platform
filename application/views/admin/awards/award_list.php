<?php
/* Awards view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('207',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>

<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_award');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>    
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_award', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/awards/add_award', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
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
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                  <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="award_type"><?php echo $this->lang->line('xin_award_type');?></label>
                      <select name="award_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_award_type');?>">
                        <option value=""></option>
                        <?php foreach($all_award_types as $award_type) {?>
                        <option value="<?php echo $award_type->award_type_id;?>"><?php echo $award_type->award_type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="award_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_award_date');?>" readonly name="award_date" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="month_year"><?php echo $this->lang->line('xin_award_month_year');?></label>
                      <input class="form-control hr_month_year" placeholder="<?php echo $this->lang->line('xin_award_month_year');?>" readonly name="month_year" type="text">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="gift"><?php echo $this->lang->line('xin_gift');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_gift');?>" name="gift" type="text">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="cash"><?php echo $this->lang->line('xin_cash');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_cash');?>" name="cash" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="logo"><?php echo $this->lang->line('xin_award_photo');?></label>
                    <input type="file" class="form-control-file" id="award_picture" name="award_picture">
                    <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="award_information"><?php echo $this->lang->line('xin_award_info');?></label>
                <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_award_info');?>" name="award_information" cols="30" rows="3" id="award_information"></textarea>
              </div>
              </div>
            </div>
            <?php $count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();?>
            <?php if($count_module_attributes > 0):?>
            <div class="row">
              <?php $module_attributes = $this->Custom_fields_model->awards_hrsale_module_attributes();?>
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
            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_awards');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style="width:120px;"><?php echo $this->lang->line('xin_action');?></th>
            <th width="350"><i class="fa fa-trophy"></i> <?php echo $this->lang->line('xin_award_name');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><i class="fa fa-gift"></i> <?php echo $this->lang->line('xin_gift');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_award_month_year');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>