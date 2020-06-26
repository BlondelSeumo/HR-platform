<?php
/* Constants view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $moduleInfo = $this->Xin_model->read_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/');?>" data-link-data="<?php echo site_url('admin/settings/');?>" class="mb-3 nav-link hrsale-link"><span class="sw-icon fas fa-cog"></span> <?php echo $this->lang->line('xin_system');?>
        <div class="text-muted small"><?php echo $this->lang->line('header_configuration');?></div>
        </a> </li>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/settings/constants/');?>" data-link-data="<?php echo site_url('admin/settings/constants/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-adjust"></span> <?php echo $this->lang->line('left_constants');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up_all_types');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/modules/');?>" data-link-data="<?php echo site_url('admin/settings/modules/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-life-ring"></span> <?php echo $this->lang->line('xin_setup_modules');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_enable_disable_modules');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/database_backup/');?>" data-link-data="<?php echo site_url('admin/settings/database_backup/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-database"></span> <?php echo $this->lang->line('header_db_log');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_database_backup_restore');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/email_template/');?>" data-link-data="<?php echo site_url('admin/settings/email_template/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-envelope"></span> <?php echo $this->lang->line('left_email_templates');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_email_templates');?></div>
        </a> </li>
    </ul>
 </div>   
<hr class="border-light m-0 mb-3">
<?php
	$active448 = '';$active449 = '';$active450 = '';$active451 = '';$active452 = '';$active453 = '';$active454 = '';$active455 = '';
	$active456 = '';$active457 = '';$active458 = '';$active459 = '';$active460 = '';$active461 = '';$active462 = '';$active463 = '';$active464 = '';
	
	$actshow448 = '';$actshow449 = '';$actshow450 = '';$actshow451 = '';$actshow452 = '';$actshow453 = '';$actshow454 = '';$actshow455 = '';
	$actshow456 = '';$actshow457 = '';$actshow458 = '';$actshow459 = '';$actshow460 = '';$actshow461 = '';$actshow462 = '';$actshow463 = '';$actshow464 = '';
	$active = '';
	$actshow = '';
	if(in_array('448',$role_resources_ids)) {
		$active448 = 'active';
		$actshow448 = 'active show';
	} else if(in_array('449',$role_resources_ids)) {
		$active449 = 'active';
		$actshow449 = 'active show';
	} else if(in_array('450',$role_resources_ids)) {
		$active450 = 'active';
		$actshow450 = 'active show';
	} else if(in_array('451',$role_resources_ids)) {
		$active451 = 'active';
		$actshow451 = 'active show';
	} else if(in_array('452',$role_resources_ids)) {
		$active452 = 'active';
		$actshow452 = 'active show';
	} else if(in_array('453',$role_resources_ids)) {
		$active453 = 'active';
		$actshow453 = 'active show';
	} else if(in_array('454',$role_resources_ids)) {
		$active454 = 'active';
		$actshow454 = 'active show';
	} else if(in_array('455',$role_resources_ids)) {
		$active455 = 'active';
		$actshow455 = 'active show';
	} else if(in_array('456',$role_resources_ids)) {
		$active456 = 'active';
		$actshow456 = 'active show';
	} else if(in_array('457',$role_resources_ids)) {
		$active457 = 'active';
		$actshow457 = 'active show';
	} else if(in_array('458',$role_resources_ids)) {
		$active458 = 'active';
		$actshow458 = 'active show';
	} else if(in_array('459',$role_resources_ids)) {
		$active459 = 'active';
		$actshow459 = 'active show';
	} else if(in_array('460',$role_resources_ids)) {
		$active460 = 'active';
		$actshow460 = 'active show';
	} else if(in_array('461',$role_resources_ids)) {
		$active461 = 'active';
		$actshow461 = 'active show';
	} else if(in_array('462',$role_resources_ids)) {
		$active462 = 'active';
		$actshow462 = 'active show';
	} else if(in_array('463',$role_resources_ids)) {
		$active463 = 'active';
		$actshow463 = 'active show';
	} else if(in_array('464',$role_resources_ids)) {
		$active464 = 'active';
		$actshow464 = 'active show';
	}
?>
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
		<?php if(in_array('448',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active448;?>" data-toggle="list" href="#account-contract_type"><i class="lnr lnr-pencil text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_contract_type');?></a>
        <?php } ?>
        <?php if(in_array('449',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active449;?>" data-toggle="list" href="#account-qualification"><i class="lnr lnr-coffee-cup text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_qualification');?></a>
        <?php } ?>
        <?php if(in_array('450',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active450;?>" data-toggle="list" href="#account-dtype"><i class="lnr lnr-file-add text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_dtype');?></a>
        <?php } ?>
        <?php if($moduleInfo[0]->module_awards=='true' && in_array('451',$role_resources_ids)){?>
        <a class="list-group-item list-group-item-action <?php echo $active451;?>" data-toggle="list" href="#account-award_type"><i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_award_type');?></a>
        <?php } ?>
        <?php if(in_array('452',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active452;?>" data-toggle="list" href="#account-ethnicity_type"><i class="lnr lnr-funnel text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_ethnicity_type_title');?></a>
        <?php } ?>
        <?php if(in_array('453',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active453;?>" data-toggle="list" href="#account-leave_type"><i class="lnr lnr-rocket text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_leave_type');?></a>
        <?php } ?>
        <?php if(in_array('454',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active454;?>" data-toggle="list" href="#account-warning_type"><i class="lnr lnr-warning text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_warning_type');?></a>
        <?php } ?>
        <?php if(in_array('455',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active455;?>" data-toggle="list" href="#account-expense_type"><i class="pe-7s-door-lock text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_expense_type');?></a>
        <?php } ?>
        <?php if(in_array('456',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active456;?>" data-toggle="list" href="#account-income_type"><i class="lnr lnr-lighter text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_income_type');?></a>
        <?php } ?>
        <?php if($moduleInfo[0]->module_recruitment=='true'){?>
			<?php if(in_array('457',$role_resources_ids)) { ?>
            <a class="list-group-item list-group-item-action <?php echo $active457;?>" data-toggle="list" href="#account-job_type"><i class="lnr lnr-line-spacing text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_job_type');?></a>
            <?php } ?>
            <?php if(in_array('458',$role_resources_ids)) { ?>
            <a class="list-group-item list-group-item-action <?php echo $active458;?>" data-toggle="list" href="#account-job_categories"><i class="lnr lnr-highlight text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_rec_job_categories');?></a>
            <?php } ?>
        <?php } ?>
        <?php if(in_array('459',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active459;?>" data-toggle="list" href="#account-currency_type"><i class="pe-7s-cash text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_currency_type');?></a>
        <?php } ?>
        <?php if(in_array('460',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active460;?>" data-toggle="list" href="#account-company_type"><i class="lnr lnr-apartment text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_company_type');?></a>
        <?php } ?>
        <?php if(in_array('461',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active461;?>" data-toggle="list" href="#account-security_level"><i class="lnr lnr-linearicons text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_security_level');?></a>
        <?php } ?>
        <?php if(in_array('462',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active462;?>" data-toggle="list" href="#account-termination_type"><i class="lnr lnr-users text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_termination_type');?></a>
        <?php } ?>
        <?php if(in_array('463',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active463;?>" data-toggle="list" href="#account-exit_type"><i class="lnr lnr-exit text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_exit_type');?></a>
        <?php } ?>
        <?php if(in_array('464',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active464;?>" data-toggle="list" href="#account-arrangement_type"><i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_travel_arrangement_type');?></a>
        <?php } ?>
        </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade <?php echo $actshow448;?>" id="account-contract_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_contract_type');?></span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'contract_type_info', 'id' => 'contract_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_contract_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/contract_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_e_details_contract_type');?></label>
                    <input type="text" class="form-control" name="contract_type" placeholder="<?php echo $this->lang->line('xin_e_details_contract_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_contract_type');?></span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_contract_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_e_details_contract_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow449;?>" id="account-qualification">
            <div class="row">
              <div class="col-xl-12">

                <div class="nav-tabs-top mb-4">
                  <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#xin_e_details_edu_level"><?php echo $this->lang->line('xin_e_details_edu_level');?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#xin_e_details_language"><?php echo $this->lang->line('xin_e_details_language');?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#xin_skill"><?php echo $this->lang->line('xin_skill');?></a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="xin_e_details_edu_level">
                      <div class="card-body">
                        <div class="row mb-4">
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_edu_level');?></span> </div>
                              <div class="card-body">
                                <?php $attributes = array('name' => 'edu_level_info', 'id' => 'edu_level_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                <?php $hidden = array('set_document_type' => 'UPDATE');?>
                                <?php echo form_open('admin/settings/edu_level_info/', $attributes, $hidden);?>
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_e_details_edu_level');?></label>
                                  <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_e_details_edu_level');?>">
                                </div>
                                <div class="form-actions box-footer">
                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                                </div>
                                <?php echo form_close(); ?> </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_edu_level');?></span> </div>
                              <div class="card-body">
                                <div class="card-datatable table-responsive">
                                  <table class="datatables-demo table table-striped table-bordered" id="xin_table_education_level">
                                    <thead>
                                      <tr>
                                        <th><?php echo $this->lang->line('xin_action');?></th>
                                        <th><?php echo $this->lang->line('xin_e_details_edu_level');?></th>
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
                    <div class="tab-pane fade" id="xin_e_details_language">
                      <div class="card-body">
                        <div class="row mb-4">
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_language');?></span> </div>
                              <div class="card-body">
                                <?php $attributes = array('name' => 'edu_language_info', 'id' => 'edu_language_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                <?php $hidden = array('set_edu_language' => 'UPDATE');?>
                                <?php echo form_open('admin/settings/edu_language_info/', $attributes, $hidden);?>
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_e_details_language');?></label>
                                  <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_e_details_language');?>">
                                </div>
                                <div class="form-actions box-footer">
                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                                </div>
                                <?php echo form_close(); ?> </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_language');?></span> </div>
                              <div class="card-body">
                                <div class="card-datatable table-responsive">
                                  <table class="datatables-demo table table-striped table-bordered" id="xin_table_qualification_language">
                                    <thead>
                                      <tr>
                                        <th><?php echo $this->lang->line('xin_action');?></th>
                                        <th><?php echo $this->lang->line('xin_e_details_language');?></th>
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
                    <div class="tab-pane fade" id="xin_skill">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_skill');?></span> </div>
                              <div class="card-body">
                                <?php $attributes = array('name' => 'edu_skill_info', 'id' => 'edu_skill_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                <?php $hidden = array('set_edu_skill' => 'UPDATE');?>
                                <?php echo form_open('admin/settings/edu_skill_info/', $attributes, $hidden);?>
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_skill');?></label>
                                  <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_skill');?>">
                                </div>
                                <div class="form-actions box-footer">
                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                                </div>
                                <?php echo form_close(); ?> </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_skill');?></span> </div>
                              <div class="card-body">
                                <div class="card-datatable table-responsive">
                                  <table class="datatables-demo table table-striped table-bordered" id="xin_table_qualification_skill">
                                    <thead>
                                      <tr>
                                        <th><?php echo $this->lang->line('xin_action');?></th>
                                        <th><?php echo $this->lang->line('xin_skill');?></th>
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
                </div>
              </div>             
            </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow450;?>" id="account-dtype">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_dtype');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'document_type_info', 'id' => 'document_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_document_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/document_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_e_details_dtype');?></label>
                    <input type="text" class="form-control" name="document_type" placeholder="<?php echo $this->lang->line('xin_e_details_dtype');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_dtype');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_document_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow451;?>" id="account-award_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_award_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'award_type_info', 'id' => 'award_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_award_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/award_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_award_type');?></label>
                    <input type="text" class="form-control" name="award_type" placeholder="<?php echo $this->lang->line('xin_award_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_award_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_award_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_award_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow452;?>" id="account-ethnicity_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_ethnicity_type_title');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'ethnicity_type_info', 'id' => 'ethnicity_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_ethnicity_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/ethnicity_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_ethnicity_type_title');?></label>
                    <input type="text" class="form-control" name="ethnicity_type" placeholder="<?php echo $this->lang->line('xin_ethnicity_type_title');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_ethnicity_type_title');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_ethnicity_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_ethnicity_type_title');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow453;?>" id="account-leave_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_leave_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'leave_type_info', 'id' => 'leave_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_leave_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/leave_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_leave_type');?></label>
                    <input type="text" class="form-control" name="leave_type" placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
                  </div>
                  <div class="form-group">
                    <label for="name"><?php echo $this->lang->line('xin_days_per_year');?></label>
                    <input type="text" class="form-control" name="days_per_year" placeholder="<?php echo $this->lang->line('xin_days_per_year');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_leave_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_leave_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_leave_type');?></th>
                          <th><?php echo $this->lang->line('xin_days_per_year');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow454;?>" id="account-warning_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_warning_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'warning_type_info', 'id' => 'warning_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_warning_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/warning_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_warning_type');?></label>
                    <input type="text" class="form-control" name="warning_type" placeholder="<?php echo $this->lang->line('xin_warning_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_warning_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_warning_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_warning_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow462;?>" id="account-termination_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_termination_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'termination_type_info', 'id' => 'termination_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_termination_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/termination_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_termination_type');?></label>
                    <input type="text" class="form-control" name="termination_type" placeholder="<?php echo $this->lang->line('xin_termination_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_termination_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_termination_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_termination_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow455;?>" id="account-expense_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_expense_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'expense_type_info', 'id' => 'expense_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_expense_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/expense_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('module_company_title');?></label>
                    <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <?php foreach($all_companies as $company) {?>
                      <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_expense_type');?></label>
                    <input type="text" class="form-control" name="expense_type" placeholder="<?php echo $this->lang->line('xin_expense_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_expense_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_expense_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('left_company');?></th>
                          <th><?php echo $this->lang->line('xin_expense_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow456;?>" id="account-income_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_income_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'income_type_info', 'id' => 'income_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_ethnicity_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/income_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_income_type');?></label>
                    <input type="text" class="form-control" name="income_type" placeholder="<?php echo $this->lang->line('xin_income_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_income_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_income_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_income_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php if($moduleInfo[0]->module_recruitment=='true'){?>
        <div class="tab-pane fade <?php echo $actshow457;?>" id="account-job_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_job_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'job_type_info', 'id' => 'job_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_job_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/job_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_job_type');?></label>
                    <input type="text" class="form-control" name="job_type" placeholder="<?php echo $this->lang->line('xin_job_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_job_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_job_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_job_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow458;?>" id="account-job_categories">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_rec_job_category');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'job_category_info', 'id' => 'job_category_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_job_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/job_category_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_rec_job_category');?></label>
                    <input type="text" class="form-control" name="job_category" placeholder="<?php echo $this->lang->line('xin_rec_job_category');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_rec_job_categories');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_job_category">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_rec_job_category');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
        <div class="tab-pane fade <?php echo $actshow463;?>" id="account-exit_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_exit_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'exit_type_info', 'id' => 'exit_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_exit_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/exit_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employee_exit_type');?></label>
                    <input type="text" class="form-control" name="exit_type" placeholder="<?php echo $this->lang->line('xin_exit_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_exit_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_exit_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_employee_exit_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow464;?>" id="account-arrangement_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_travel_arrangement_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'travel_arr_type_info', 'id' => 'travel_arr_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_travel_arr_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/travel_arr_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_travel_arrangement_type');?></label>
                    <input type="text" class="form-control" name="travel_arr_type" placeholder="<?php echo $this->lang->line('xin_travel_arrangement_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_travel_arrangement_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_travel_arr_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_travel_arrangement_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow459;?>" id="account-currency_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_currency_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'currency_type_info', 'id' => 'currency_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_currency_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/currency_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_currency_name');?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_currency_name');?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_currency_code');?></label>
                    <input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('xin_currency_code');?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_currency_symbol');?></label>
                    <input type="text" class="form-control" name="symbol" placeholder="<?php echo $this->lang->line('xin_currency_symbol');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_currencies');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_currency_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_name');?></th>
                          <th><?php echo $this->lang->line('xin_code');?></th>
                          <th><?php echo $this->lang->line('xin_symbol');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow460;?>" id="account-company_type">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_company_type');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'company_type_info', 'id' => 'company_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_company_type' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/company_type_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_company_type');?></label>
                    <input type="text" class="form-control" name="company_type" placeholder="<?php echo $this->lang->line('xin_company_type');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_company_type');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_company_type">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_company_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow461;?>" id="account-security_level">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_security_level');?> </span> </div>
                <div class="card-body">
                  <?php $attributes = array('name' => 'security_level_info', 'id' => 'security_level_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                  <?php $hidden = array('set_security_level' => 'UPDATE');?>
                  <?php echo form_open('admin/settings/security_level_info/', $attributes, $hidden);?>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_security_level');?></label>
                    <input type="text" class="form-control" name="security_level" placeholder="<?php echo $this->lang->line('xin_security_level');?>">
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_security_level');?> </span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table_security_level">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_security_level');?></th>
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
  </div>
</div>
<div class="modal fade edit_setting_datail" id="edit_setting_datail" tabindex="-1" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_setting_info"></div>
  </div>
</div>
<style type="text/css">
.table-striped { width:100% !important; }
</style>