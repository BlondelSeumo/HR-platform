<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('246',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/files/');?>" data-link-data="<?php echo site_url('admin/files/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-signature"></span> <?php echo $this->lang->line('xin_files_manager');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_department_upload_files');?></div>
      </a> </li>
     <?php } ?> 
    <?php if(in_array('442',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/company/official_documents/');?>" data-link-data="<?php echo site_url('admin/company/official_documents/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-word"></span> <?php echo $this->lang->line('xin_hr_official_documents');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_hr_official_documents_setup');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('400',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/employees/expired_documents/');?>" data-link-data="<?php echo site_url('admin/employees/expired_documents/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-export"></span> <?php echo $this->lang->line('xin_e_details_exp_documents');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_e_list_exp_documents');?></div>
      </a> </li>
    <?php } ?>  
  </ul>
  <hr class="border-light m-0 mb-3">
</div>
<?php if(in_array('246',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_document');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_official_document', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/company/add_official_document', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="license_name"><?php echo $this->lang->line('xin_hr_official_license_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_official_license_name');?>" name="license_name" type="text">
              </div>
              <div class="form-group">
                <div class="row">
                  <?php if($user_info[0]->user_role_id==1){ ?>
                  <div class="col-md-6">
                    <label for="company_id"><?php echo $this->lang->line('left_company');?></label>
                    <select class="form-control" name="company_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""><?php echo $this->lang->line('left_company');?></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php } else {?>
                  <?php $ecompany_id = $user_info[0]->company_id;?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_id"><?php echo $this->lang->line('left_company');?></label>
                      <select class="form-control" name="company_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                        <option value=""><?php echo $this->lang->line('left_company');?></option>
                        <?php foreach($get_all_companies as $company) {?>
                        <?php if($ecompany_id == $company->company_id):?>
                        <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                        <?php endif;?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="expiry_date"><?php echo $this->lang->line('xin_expiry_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_expiry_date');?>" name="expiry_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="scan_file"><?php echo $this->lang->line('xin_hr_official_license_scan');?></label>
                      <fieldset class="form-group">
                        <input type="file" class="form-control-file" id="scan_file" name="scan_file">
                        <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="relation"><?php echo $this->lang->line('xin_e_details_dtype');?></label>
                    <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                      <option value=""><?php echo $this->lang->line('xin_e_details_choose_dtype');?></option>
                      <?php foreach($all_document_types as $document_type) {?>
                      <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="license_number"><?php echo $this->lang->line('xin_hr_official_license_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_official_license_number');?>" name="license_number" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="xin_gtax"><?php echo $this->lang->line('xin_hr_official_license_alarm');?></label>
                <select class="form-control" name="license_notification" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_hr_official_license_alarm');?>">
                  <option value="0"><?php echo $this->lang->line('xin_hr_license_no_alarm');?></option>
                  <option value="1"><?php echo $this->lang->line('xin_hr_license_alarm_1');?></option>
                  <option value="3"><?php echo $this->lang->line('xin_hr_license_alarm_3');?></option>
                  <option value="6"><?php echo $this->lang->line('xin_hr_license_alarm_6');?></option>
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
<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_hr_official_documents');?> </span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="100px;"><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_expiry_date');?></th>
            <th><i class="fa fa-bell"></i> <?php echo $this->lang->line('header_notifications');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
