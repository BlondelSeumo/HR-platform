<?php
/* Expired documents
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('246',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/files/');?>" data-link-data="<?php echo site_url('admin/files/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-signature"></span> <?php echo $this->lang->line('xin_files_manager');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_department_upload_files');?></div>
      </a> </li>
     <?php } ?> 
    <?php if(in_array('442',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/company/official_documents/');?>" data-link-data="<?php echo site_url('admin/company/official_documents/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-word"></span> <?php echo $this->lang->line('xin_hr_official_documents');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_hr_official_documents_setup');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('400',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employees/expired_documents/');?>" data-link-data="<?php echo site_url('admin/employees/expired_documents/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-export"></span> <?php echo $this->lang->line('xin_e_details_exp_documents');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_e_list_exp_documents');?></div>
      </a> </li>
    <?php } ?>  
  </ul>
  <hr class="border-light m-0 mb-3">
</div>
<div class="card overflow-hidden">
<div class="row no-gutters row-bordered row-border-light">
<div class="col-md-3 pt-0">
  <div class="list-group list-group-flush account-settings-links">
    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-exp_documents"><?php echo $this->lang->line('xin_e_details_exp_documents');?></a>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-employee_immigration"><?php echo $this->lang->line('xin_employee_immigration');?></a>
    <?php if(in_array('5',$role_resources_ids)) { ?>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-official_documents"><?php echo $this->lang->line('xin_hr_official_documents');?></a>
    <?php } ?>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-assets_warranty"><?php echo $this->lang->line('xin_assets_warranty');?></a>
  </div>
</div>
<div class="col-md-9">
  <div class="tab-content">
    <div class="tab-pane fade active show" id="account-exp_documents">
    <div class="box">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_exp_documents');?> </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table_document" style="width:100%;">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
                <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_doe');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    </div>
    <div class="tab-pane fade" id="account-employee_immigration">
    <div class="box">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_immigration');?> </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table_imgdocument" style="width:100%;">
            <thead>
              <tr>
                  <th><?php echo $this->lang->line('xin_action');?></th>
                  <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
                  <th><?php echo $this->lang->line('xin_e_details_document');?></th>
                  <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_issue_date');?></th>
                  <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_expiry_date');?></th>
                  <th><?php echo $this->lang->line('xin_issued_by');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    </div>
    <?php if(in_array('5',$role_resources_ids)) { ?>
    <div class="tab-pane fade" id="account-official_documents">
    <div class="box">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_hr_official_documents');?> </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table_company_license" style="width:100%;">
            <thead>
              <tr>
                <th width="100px;"><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><?php echo $this->lang->line('left_company');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_expiry_date');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    </div>
    <?php } ?>
    <div class="tab-pane fade" id="account-assets_warranty">
    <div class="box">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_assets_warranty');?> </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table_assets_warranty" style="width:100%;">
            <thead>
              <tr>
              <th><?php echo $this->lang->line('xin_action');?></th>
              <th><i class="fa fa-flask"></i> <?php echo $this->lang->line('xin_asset_name');?></th>
              <th><?php echo $this->lang->line('xin_acc_category');?></th>
              <th><?php echo $this->lang->line('xin_company_asset_code');?></th>
              <th><?php echo $this->lang->line('xin_is_working');?></th>
              <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_assets_assign_to');?></th>
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