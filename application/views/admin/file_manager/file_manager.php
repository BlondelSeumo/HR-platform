<?php
/*
* Files Manager view
*/
$session = $this->session->userdata('username');
?>
<?php $file_setting = $this->Xin_model->read_file_setting_info(1);?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($user[0]->user_role_id==1){
	$all = 'department-file';
	$val = '0';
} else {
	
	if($file_setting[0]->is_enable_all_files=='yes'):
		$val = '0';
		$all = 'department-file';
	else:
		$val = $user[0]->department_id;
		$all = 'not-allowed';
	endif;
}
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('246',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/files/');?>" data-link-data="<?php echo site_url('admin/files/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-signature"></span> <?php echo $this->lang->line('xin_files_manager');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_department_upload_files');?></div>
      </a> </li>
     <?php } ?> 
    <?php if(in_array('442',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/company/official_documents/');?>" data-link-data="<?php echo site_url('admin/company/official_documents/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-word"></span> <?php echo $this->lang->line('xin_hr_official_documents');?>
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
<input type="hidden" id="depval" value="<?php echo $val;?>" />
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <?php if($user[0]->user_role_id==1 || $file_setting[0]->is_enable_all_files=='yes'){?>
        <a class="list-group-item list-group-item-action department-file active" data-toggle="list" href="#account-general" data-department-id="0"><?php echo $this->lang->line('xin_all_departments');?></a>
        <?php } ?>
        <?php foreach($all_departments as $department):?>
        <?php if($user[0]->user_role_id==1){?>
        <a class="list-group-item list-group-item-action department-file" data-toggle="list" href="#account-change-password" data-department-id="<?php echo $department->department_id;?>" data-config="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></a>
        <?php } else {?>
        <?php if($user[0]->department_id==$department->department_id){ ?>
        <a class="list-group-item list-group-item-action department-file" data-toggle="list" href="#account-change-password" data-department-id="<?php echo $department->department_id;?>" data-config="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></a>
        <?php } elseif($file_setting[0]->is_enable_all_files=='yes') { ?>
        <a class="list-group-item list-group-item-action department-file" data-toggle="list" href="#account-change-password" data-department-id="<?php echo $department->department_id;?>" data-config="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></a>
        <?php }} ?>
        <?php endforeach;?>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="account-general">
          <div class="box mb-4">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_files');?> </span> </div>
            <div class="card-body">
              <?php //if($user[0]->user_role_id==1){?>
              <div role="tabpanel" class="tab-all-files tab-pane active" id="all_files">
                <div class="box-block bg-white">
                  <?php $attributes = array('name' => 'add_files', 'id' => 'xin-form', 'autocomplete' => 'off');?>
                  <?php $hidden = array('user_id' => $session['user_id']);?>
                  <?php echo form_open_multipart('admin/files/add_files', $attributes, $hidden);?>
                  <div class="row">
                    <?php if($user[0]->user_role_id==1){?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="department_id"><?php echo $this->lang->line('left_department');?></label>
                        <select name="department_id" id="department_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_department');?>">
                          <option value=""><?php echo $this->lang->line('xin_choose_department');?></option>
                          <?php foreach($all_departments as $department) {?>
                          <option value="<?php echo $department->department_id;?>"> <?php echo $department->department_name;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <?php } else { ?>
                    <input type="hidden" name="department_id" id="department_id" value="<?php echo $user[0]->department_id;?>" />
                    <?php } ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
                        <fieldset class="form-group">
                          <input type="file" name="xin_file" id="xin_file">
                          <br />
                          <small><?php echo $this->lang->line('xin_upload_file_only_for_resume');?> <?php echo $file_setting[0]->allowed_extensions;?></small>
                        </fieldset>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="form-actions box-footer">
                          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <!-- tab --> 
          </div>
          <div class="box">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_files');?> </span> </div>
            <div class="card-body">
              <div class="card-datatable table-responsive">
                <table class="datatables-demo table table-striped table-bordered" id="xin_table_files">
                  <thead>
                    <tr>
                      <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
                      <th><?php echo $this->lang->line('xin_single_file');?></th>
                      <th><?php echo $this->lang->line('left_department');?></th>
                      <th><?php echo $this->lang->line('xin_single_size');?></th>
                      <th><?php echo $this->lang->line('xin_extension');?></th>
                      <th><?php echo $this->lang->line('xin_uploaded_date');?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
