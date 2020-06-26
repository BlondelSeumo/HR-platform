<?php
/* Settings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $file_setting = $this->Xin_model->read_file_setting_info(1);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $company_info = $this->Xin_model->read_company_setting_info(1); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $moduleInfo = $this->Xin_model->read_setting_info(1);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php //$company = $this->Xin_model->read_company_setting_info(1);?>
<?php if($this->session->flashdata('restore_msg')){?>
<div class="alert alert-success alert-dismissible fade show">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo $this->session->flashdata('restore_msg'); ?>
</div>
<?php } ?>
  <div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <?php if(in_array('60',$role_resources_ids)) { ?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/settings/');?>" data-link-data="<?php echo site_url('admin/settings/');?>" class="mb-3 nav-link hrsale-link"><span class="sw-icon fas fa-cog"></span> <?php echo $this->lang->line('xin_system');?>
        <div class="text-muted small"><?php echo $this->lang->line('header_configuration');?></div>
        </a> </li>
        <?php } ?>
      <?php if(in_array('61',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/constants/');?>" data-link-data="<?php echo site_url('admin/settings/constants/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-adjust"></span> <?php echo $this->lang->line('left_constants');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up_all_types');?></div>
        </a> </li>
        <?php } ?>
      <?php if(in_array('93',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/modules/');?>" data-link-data="<?php echo site_url('admin/settings/modules/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-life-ring"></span> <?php echo $this->lang->line('xin_setup_modules');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_enable_disable_modules');?></div>
        </a> </li>
        <?php } ?>
      <?php if(in_array('62',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/database_backup/');?>" data-link-data="<?php echo site_url('admin/settings/database_backup/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-database"></span> <?php echo $this->lang->line('header_db_log');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_database_backup_restore');?></div>
        </a> </li>
        <?php } ?>
      <?php if(in_array('63',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/email_template/');?>" data-link-data="<?php echo site_url('admin/settings/email_template/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-envelope"></span> <?php echo $this->lang->line('left_email_templates');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_email_templates');?></div>
        </a> </li>
       <?php } ?> 
    </ul>
 </div>   
<hr class="border-light m-0 mb-3">
<?php
	$active297 = '';$active431 = '';$active432 = '';$active433 = '';$active434 = '';$active435 = '';
	$active436 = '';$active118 = '';$active437 = '';$active438 = '';$active439 = '';$active440 = '';$active441 = '';
	$actshow297 = '';$actshow431 = '';$actshow432 = '';$actshow433 = '';$actshow434 = '';$actshow435 = '';
	$actshow436 = '';$actshow118 = '';$actshow437 = '';$actshow438 = '';$actshow439 = '';$actshow440 = '';$actshow441 = '';
	$active = '';
	$actshow = '';
	if(in_array('297',$role_resources_ids)) {
		$active297 = 'active';
		$actshow297 = 'active show';
	} else if(in_array('431',$role_resources_ids)) {
		$active431 = 'active';
		$actshow431 = 'active show';
	} else if(in_array('432',$role_resources_ids)) {
		$active432 = 'active';
		$actshow432 = 'active show';
	} else if(in_array('433',$role_resources_ids)) {
		$active433 = 'active';
		$actshow433 = 'active show';
	} else if(in_array('434',$role_resources_ids)) {
		$active434 = 'active';
		$actshow434 = 'active show';
	} else if(in_array('435',$role_resources_ids)) {
		$active435 = 'active';
		$actshow435 = 'active show';
	} else if(in_array('436',$role_resources_ids)) {
		$active436 = 'active';
		$actshow436 = 'active show';
	} else if(in_array('118',$role_resources_ids)) {
		$active118 = 'active';
		$actshow118 = 'active show';
	} else if(in_array('437',$role_resources_ids)) {
		$active437 = 'active';
		$actshow437 = 'active show';
	} else if(in_array('438',$role_resources_ids)) {
		$active438 = 'active';
		$actshow438 = 'active show';
	} else if(in_array('439',$role_resources_ids)) {
		$active439 = 'active';
		$actshow439 = 'active show';
	} else if(in_array('441',$role_resources_ids)) {
		$active441 = 'active';
		$actshow441 = 'active show';
	}
?>
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
      <?php if(in_array('297',$role_resources_ids)) { ?>
      <a class="list-group-item list-group-item-action <?php echo $active297;?>" data-toggle="list" href="#account-system"><i class="ion ion-ios-heart text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_system');?></a>
      <?php } ?>
      <?php if(in_array('431',$role_resources_ids)) { ?>
      <a class="list-group-item list-group-item-action <?php echo $active431;?>" data-toggle="list" href="#account-general"><i class="ion ion-logo-buffer text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_general');?></a>
      <?php } ?>
      <?php if(in_array('432',$role_resources_ids)) { ?>
      <a class="list-group-item list-group-item-action <?php echo $active432;?>" data-toggle="list" href="#account-role"><i class="fa fa-unlock-alt text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_role');?></a>
      <?php } ?>
      <?php if(in_array('433',$role_resources_ids)) { ?>
      <a class="list-group-item list-group-item-action <?php echo $active433;?>" data-toggle="list" href="#account-payroll"><i class="fa fa-calculator text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_payroll');?></a>
      <?php } ?>
        <?php if($system[0]->module_recruitment=='true' && in_array('434',$role_resources_ids)){?>
        <a class="list-group-item list-group-item-action <?php echo $active434;?>" data-toggle="list" href="#account-recruitment"><i class="fas fa-newspaper text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_recruitment');?></a>
        <?php } ?>
        <?php if($system[0]->module_performance=='yes' && in_array('435',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active435;?>" data-toggle="list" href="#account-performance"><i class="fa fa-cube text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_performance');?></a>
        <?php } ?>
        <?php if(in_array('436',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active436;?>" data-toggle="list" href="#account-system_logos"><i class="fa fa-image text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_system_logos');?></a>
        <?php } ?>
        <?php if(in_array('118',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active118;?>" data-toggle="list" href="#account-payment_gateway"><i class="fab fa-cc-paypal text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_acc_payment_gateway');?></a>
        <?php } ?>
        <?php if(in_array('437',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active437;?>" data-toggle="list" href="#account-email"><i class="fa fa-envelope text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_email_notifications');?></a>
        <?php } ?>
        <?php if(in_array('438',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active438;?>" data-toggle="list" href="#account-page_layouts"><i class="fa fa-cubes text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_page_layouts');?></a>
        <?php } ?>
        <?php if(in_array('439',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active439;?>" data-toggle="list" href="#account-notification_position"><i class="fa fa-exclamation-circle text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_notification_position');?></a>
        <?php } ?>
        <?php if($system[0]->module_files=='true' && in_array('440',$role_resources_ids)){?>
        <a class="list-group-item list-group-item-action <?php echo $active440;?>" data-toggle="list" href="#account-files"><i class="fas fa-file-upload text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_files_manager');?></a>
        <?php } ?>
        <?php if(in_array('441',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active441;?>" data-toggle="list" href="#account-org_chart"><i class="fa fa-sitemap text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_org_chart_title');?></a>
        <?php } ?>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade <?php echo $actshow297;?>" id="account-system">
          <div class="card-body media align-items-center"> <span class="app-brand-logo demo bg-primary"> <img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo d-block ui-w-30" style="width:32px;"> </span>
            <div class="media-body ml-4"> <?php echo $application_name;?>
              <div class="text-light small mt-1"><?php echo $this->lang->line('xin_change_setting_info');?></div>
            </div>
          </div>
          <hr class="border-light m-0">
          <div class="card-body">
            <div class="card-block">
              <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?php echo form_open('admin/settings/system_info/'.$company_info_id, $attributes, $hidden);?>
              <div class="bg-white">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_application_name');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_system_settings');?>" name="application_name" type="text" value="<?php echo $application_name;?>" id="application_name">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_default_currency');?></label>
                      <select class="form-control" name="default_currency_symbol" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_default_currency_symbol');?>" tabindex="-1" aria-hidden="true">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <?php foreach($this->Xin_model->get_currencies() as $currency){?>
                        <?php $_currency = $currency->code.' - '.$currency->symbol;?>
                        <option value="<?php echo $_currency;?>" <?php if($default_currency_symbol==$_currency):?> selected <?php endif;?>> <?php echo $_currency;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_default_currency_symbol_code');?></label>
                      <select class="form-control" name="show_currency" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_show_currency');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="code" <?php if($show_currency=='code'){?> selected <?php }?>><?php echo $this->lang->line('xin_currency_code');?></option>
                        <option value="symbol" <?php if($show_currency=='symbol'){?> selected <?php }?>><?php echo $this->lang->line('xin_currency_symbol');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_currency_position');?></label>
                      <input type="hidden" name="notification_position" value="Bottom Left">
                      <input type="hidden" name="enable_registration" value="no">
                      <input type="hidden" name="login_with" value="username">
                      <select class="form-control" name="currency_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_currency_position');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="Prefix" <?php if($currency_position=='Prefix'){?> selected <?php }?>><?php echo $this->lang->line('xin_prefix');?></option>
                        <option value="Suffix" <?php if($currency_position=='Suffix'){?> selected <?php }?>><?php echo $this->lang->line('xin_suffix');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_login_employee');?></label>
                      <select class="form-control" name="employee_login_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_login_employee');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="username" <?php if($employee_login_id=='username'){?> selected <?php }?>><?php echo $this->lang->line('xin_login_employee_with_username');?></option>
                        <option value="email" <?php if($employee_login_id=='email'){?> selected <?php }?>><?php echo $this->lang->line('xin_login_employee_with_email');?></option>
                        <option value="pincode" <?php if($employee_login_id=='pincode'){?> selected <?php }?>><?php echo $this->lang->line('xin_login_employee_with_pincode');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_date_format');?></label>
                      <select class="form-control" name="date_format" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_date_format');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="d-m-Y" <?php if($date_format_xi=='d-m-Y'){?> selected <?php }?>>dd-mm-YYYY (<?php echo date('d-m-Y');?>)</option>
                        <option value="m-d-Y" <?php if($date_format_xi=='m-d-Y'){?> selected <?php }?>>mm-dd-YYYY (<?php echo date('m-d-Y');?>)</option>
                        <option value="d-M-Y" <?php if($date_format_xi=='d-M-Y'){?> selected <?php }?>>dd-MM-YYYY (<?php echo date('d-M-Y');?>)</option>
                        <option value="M-d-Y" <?php if($date_format_xi=='M-d-Y'){?> selected <?php }?>>MM-dd-YYYY (<?php echo date('M-d-Y');?>)</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_footer_text');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_footer_text');?>" name="footer_text" type="text" value="<?php echo $footer_text;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_setting_timezone');?></label>
                      <select class="form-control" name="system_timezone" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_setting_timezone');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <?php foreach($this->Xin_model->all_timezones() as $tval=>$labels):?>
                        <option value="<?php echo $tval;?>" <?php if($system_timezone==$tval):?> selected <?php endif;?>><?php echo $labels;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <?php $languages = $this->Xin_model->all_languages();?>
                      <label class="form-label"><?php echo $this->lang->line('xin_hrsale_default_language');?></label>
                      <select class="form-control" name="default_language" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_hrsale_default_language');?>">
                        <?php foreach($languages as $lang):?>
                        <option value="<?php echo $lang->language_code;?>" <?php if($lang->language_code==$default_language):?> selected="selected"<?php endif;?>><?php echo $lang->language_name;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_enable_year_on_footer');?> <small>(footer)</small></label>
                      <br>
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher switcher-success">
                          <input data-group-cls="btn-group-sm" type="checkbox" id="enable_current_year" class="js-switch switcher-input" value="yes" <?php if($enable_current_year=='yes'):?> checked="checked" <?php endif;?>/>
                          <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_enable_codeigniter_on_footer');?> <small>(footer)</small></label>
                      <br>
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher switcher-success">
                          <input type="checkbox" id="enable_page_rendered" name="enable_page_rendered" class="js-switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($enable_page_rendered=='yes'):?> checked="checked" <?php endif;?> value="yes">
                          <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_enable_geolocation_ssl');?>
                        <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_enable_geolocation_ssl_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_enable_geolocation_ssl');?>"><span class="fa fa-question-circle"></span></button>
                      </label>
                      <br>
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher switcher-success">
                          <input type="checkbox" name="is_ssl_available" id="is_ssl_available" class="js-switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($is_ssl_available=='yes'):?> checked="checked" <?php endif;?> value="yes">
                          <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_payroll_statutory_fixed');?></label>
                      <br>
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher switcher-success">
                          <input type="checkbox" id="statutory_fixed" name="statutory_fixed" class="js-switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($statutory_fixed=='yes'):?> checked="checked" <?php endif;?> value="yes">
                          <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_setting_google_maps_api_key');?>
                        <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_setting_google_maps_api_key_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_setting_google_maps_api_key');?>"><span class="fa fa-question-circle"></span></button>
                      </label>
                      <br />
                      <textarea class="form-control" name="google_maps_api_key" id="google_maps_api_key" rows="1"><?php echo $google_maps_api_key;?></textarea>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('left_show_projects');?></label>
                      <select class="form-control" name="show_projects" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_show_projects');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="0" <?php if($show_projects=='0'){?> selected <?php }?>><?php echo $this->lang->line('xin_list_view');?></option>
                        <option value="1" <?php if($show_projects=='1'){?> selected <?php }?>><?php echo $this->lang->line('xin_grid_view');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('left_show_tasks');?></label>
                      <select class="form-control" name="show_tasks" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_show_tasks');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="0" <?php if($show_tasks=='0'){?> selected <?php }?>><?php echo $this->lang->line('xin_list_view');?></option>
                        <option value="1" <?php if($show_tasks=='1'){?> selected <?php }?>><?php echo $this->lang->line('xin_grid_view');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_estimate_terms_condition');?></label>
                      <textarea class="form-control" name="estimate_terms_condition" rows="5"><?php echo $estimate_terms_condition;?></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_invoice_terms_condition');?></label>
                      <textarea class="form-control" name="invoice_terms_condition" rows="5"><?php echo $invoice_terms_condition;?></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-actions box-footer">
                        <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow431;?>" id="account-general">
          <div class="card-body">
            <div class="card-block">
              <?php $attributes = array('name' => 'company_info', 'id' => 'company_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_company_info' => 'UPDATE');?>
              <?php echo form_open('admin/settings/company_info/'.$company_info_id, $attributes, $hidden);?>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_company_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text" value="<?php echo $company_name;?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_se_contact_person');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_se_contact_person');?>" name="contact_person" type="text" value="<?php echo $contact_person;?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_phone');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phone');?>" name="phone" type="text" value="<?php echo $phone;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employee_address');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
                    <br>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
                    <br>
                    <div class="row">
                      <div class="col-md-5">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
                      </div>
                      <div class="col-md-3">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
                      </div>
                    </div>
                    <br>
                    <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <?php foreach($all_countries as $scountry) {?>
                      <option value="<?php echo $scountry->country_id;?>" <?php if($country==$scountry->country_id):?> selected <?php endif;?>> <?php echo $scountry->country_name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <input name="config_type" type="hidden" value="general">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow432;?>" id="account-role">
          <div class="card-body pb-2">
            <?php $attributes = array('name' => 'role_info', 'id' => 'role_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/settings/role_info/'.$company_info_id, $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_contact_info');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="contact_role" id="contact_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_contact=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_bank_account');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="bank_account_role" id="bank_account_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_bank_account=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_qualification');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="edu_role" id="edu_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_qualification=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_work_experience');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="work_role" id="work_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_work_experience=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_documents');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="doc_role" id="doc_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_document=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_profile_picture');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="pic_role" id="pic_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_picture=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_profile_info');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="profile_role" id="profile_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_profile=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employe_can_manage_social_info');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="social_role" id="social_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_social=='yes'):?> checked="checked" <?php endif;?> value="yes">
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow433;?>" id="account-payroll">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'payroll_config', 'id' => 'payroll_config', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?php echo form_open('admin/settings/payroll_config/'.$company_info_id, $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-7">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_payslip_password_format');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <select class="form-control" name="payslip_password_format" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="dateofbirth" <?php if($payslip_password_format=='dateofbirth'){?> selected <?php }?>>Employee date of birth (<?php echo date('dmY');?>)</option>
                        <option value="contact_no" <?php if($payslip_password_format=='contact_no'){?> selected <?php }?>>Employee Contact Number. (<?php echo '123456789';?>)</option>
                        <option value="full_name" <?php if($payslip_password_format=='full_name'){?> selected <?php }?>>Employee First name Last name (<?php echo 'JhonDoe';?>)</option>
                        <option value="email" <?php if($payslip_password_format=='email'){?> selected <?php }?>>Employee Email Address (<?php echo 'employee@example.com';?>)</option>
                        <option value="password" <?php if($payslip_password_format=='password'){?> selected <?php }?>>Employee Password (<?php echo 'testpassword';?>)</option>
                        <option value="user_password" <?php if($payslip_password_format=='user_password'){?> selected <?php }?>>Employee Username & Password (<?php echo 'usernametestpassword';?>)</option>
                        <option value="employee_id" <?php if($payslip_password_format=='employee_id'){?> selected <?php }?>>Employee ID (<?php echo 'EMP001WA5';?>)</option>
                        <option value="employee_id_password" <?php if($payslip_password_format=='employee_id_password'){?> selected <?php }?>>Employee ID & Password (<?php echo 'EMP001WA5testpassword';?>)</option>
                        <option value="dateofbirth_name" <?php if($payslip_password_format=='dateofbirth_name'){?> selected <?php }?>>Employee date of birth & 2 first character from Name (<?php echo date('dmY').'JD';?>)</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_enable_password_generate_payslip');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="payslip_password_generate" id="payslip_password_generate" class="js-switch switch switcher-input" data-group-cls="btn-group-sm" <?php if($is_payslip_password_generate=='1'):?> checked="checked" <?php endif;?> value="1" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_enable_saudi_gosi');?></label>
                    <select name="enable_saudi_gosi" class="form-control" data-plugin="select_hrm">
                      <option value="0" <?php if($enable_saudi_gosi==0 || $enable_saudi_gosi==''):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_no');?></option>
                      <option value="5" <?php if($enable_saudi_gosi==5):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_yes');?> - 5%</option>
                      <option value="10" <?php if($enable_saudi_gosi==10):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_yes');?> - 10%</option>
                      <option value="15" <?php if($enable_saudi_gosi==15):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_yes');?> - 15%</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3" id="half_monthly_is">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_is_half_monthly');?></label>
                    <select name="is_half_monthly" id="is_half_monthly" class="form-control" data-plugin="select_hrm">
                      <option value="0" <?php if($is_half_monthly==0 || $is_half_monthly==''):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_no');?></option>
                      <option value="1" <?php if($is_half_monthly==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_yes');?></option>
                    </select>
                  </div>
                </div>
                <?php if($is_half_monthly==1): $stl = 'style="display:block;"';  else: $stl = 'style="display:none;"'; endif;?>
                <div class="col-md-3" id="deduct_options"  <?php echo $stl;?>>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_half_deduct_month');?></label>
                    <select name="half_deduct_month" id="half_deduct_month" class="form-control" data-plugin="select_hrm">
                      <option value="1" <?php if($half_deduct_month==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_is_half_monthly_bs_only');?></option>
                      <option value="2" <?php if($half_deduct_month==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_is_half_monthly_bs_only_both');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <?php if($system[0]->module_recruitment=='true'){?>
        <?php if($system[0]->enable_job_application_candidates=='1'){?>
        <div class="tab-pane fade <?php echo $actshow434;?>" id="account-recruitment">
        <?php if(in_array('50',$role_resources_ids)) { ?>
          <div class="card-body"> <a target="_blank" href="<?php echo site_url('jobs');?>">
            <button type="button" class="btn btn-primary"><?php echo $this->lang->line('left_jobs_listing');?></button>
            </a> </div>
         <?php } ?>   
          <hr class="border-light m-0">
          <div class="card-body">
            <div class="card-block">
              <?php $attributes = array('name' => 'job_info', 'id' => 'job_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?php echo form_open('admin/settings/job_info/'.$company_info_id, $attributes, $hidden);?>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_enable_jobs_for_employees');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="enable_job2" id="enable_job2" class="js-switch switch switcher-input" <?php if($enable_job_application_candidates=='1'):?> checked="checked" <?php endif;?> value="1" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_job_application_file_format');?></label>
                    <br>
                    <input type="text" value="<?php echo $job_application_format;?>" data-role="tagsinput" name="job_application_format">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
        <div class="tab-pane fade <?php echo $actshow435;?>" id="account-performance">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'performance_info', 'id' => 'performance_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?php echo form_open('admin/settings/performance_info/'.$company_info_id, $attributes, $hidden);?>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_performance_technical_competencies');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <input type="text" value="<?php echo $technical_competencies;?>" data-role="tagsinput" name="technical_competencies">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                  <div class="pull-xs-left m-r-1">
                    <label class="form-label"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></label>
                    <br>
                    <input type="text" value="<?php echo $organizational_competencies;?>" data-role="tagsinput" name="organizational_competencies">
                  </div>
                  
                  </div>
                </div>
              </div>
              <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('left_performance');?></label>
                  <select class="form-control" name="performance_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_performance');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="goal" <?php if($performance_option=='goal'){?> selected <?php }?>><?php echo $this->lang->line('xin_hr_goal_title');?></option>
                    <option value="appraisal" <?php if($performance_option=='appraisal'){?> selected <?php }?>><?php echo $this->lang->line('left_performance_xappraisal');?></option>
                    <option value="both" <?php if($performance_option=='both'){?> selected <?php }?>><?php echo $this->lang->line('xin_both_goal_appraisal');?></option>
                  </select>
                </div>
              </div>
              </div>    
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <?php if($system[0]->module_files=='true'){?>
        <div class="tab-pane fade <?php echo $actshow440;?>" id="account-files">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'setting_info', 'id' => 'file_setting_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?php echo form_open('admin/files/setting_info/'.$company_info_id, $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-3">
                  <label class="form-label"><?php echo $this->lang->line('xin_file_maxsize');?></label>
                  <br>
                  <div class="input-group">
                    <input type="text" class="form-control" value="<?php echo $file_setting[0]->maximum_file_size;?>" name="maximum_file_size" placeholder="<?php echo $this->lang->line('xin_file_size_mb');?>" maxlength="2000" min="1">
                    <div class="input-group-append"> <span class="input-group-text">MB</span> </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_allowed_extensions');?></label>
                    <br>
                    <input type="text" value="<?php echo $file_setting[0]->allowed_extensions;?>" data-role="tagsinput" name="allowed_extensions">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_employee_can_view_download_other_files');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="view_all_files" id="view_all_files" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  <?php if($file_setting[0]->is_enable_all_files=='yes'):?> checked="checked" <?php endif;?> value="yes">
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <?php } ?>
        <div class="tab-pane fade <?php echo $actshow437;?>" id="account-email">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'email_info', 'id' => 'email_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?php echo form_open('admin/settings/email_info/'.$company_info_id, $attributes, $hidden);?>
              <div class="bg-white">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_email_notification_enable');?></label>
                      <br>
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher switcher-success">
                          <input type="checkbox" name="srole_email_notification" id="srole_email_notification" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  <?php if($enable_email_notification=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                          <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_mail_type_config');?></label>
                      <select class="form-control" name="email_type" id="email_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_mail_type_config');?>">
                        <option value="codeigniter" <?php if($email_type == 'codeigniter'):?> selected="selected"<?php endif;?>>CodeIgniter Mail()</option>
                        <option value="phpmail" <?php if($email_type == 'phpmail'):?> selected="selected"<?php endif;?>>PHP Mail()</option>
                      </select>
                    </div>
                  </div>
                </div>
                <?php if($email_type == 'smtp'): $sm_opt = 'style="display:block;"';  else: $sm_opt = 'style="display:none;"'; endif;?>
                <div class="row" id="smtp_options" <?php echo $sm_opt;?>>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_mail_smtp_host');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_host');?>" name="smtp_host" type="text" value="<?php echo $smtp_host;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_mail_smtp_username');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_username');?>" name="smtp_username" type="text" value="<?php echo $smtp_username;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_mail_smtp_password');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_password');?>" name="smtp_password" type="password" value="<?php echo $smtp_password;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_mail_smtp_port');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_port');?>" name="smtp_port" type="text" value="<?php echo $smtp_port;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_mail_smtp_secure');?></label>
                      <select class="form-control" name="smtp_secure" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_mail_smtp_secure');?>">
                        <option value="tls"<?php if($smtp_secure == 'tls'):?> selected="selected"<?php endif;?>>TLS</option>
                        <option value="ssl"<?php if($smtp_secure == 'ssl'):?> selected="selected"<?php endif;?>>SSL</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-actions box-footer">
                        <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow438;?>" id="account-page_layouts">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'page_layouts_info', 'id' => 'page_layouts_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('theme_info' => 'UPDATE');?>
              <?php echo form_open('admin/theme/page_layouts/', $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_theme_show_dashboard_cards');?></label>
                    <select class="form-control" name="statistics_cards" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_theme_show_dashboard_cards');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="4" <?php if($statistics_cards=='4'){?> selected <?php }?>>4</option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('xin_theme_set_statistics_cards');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label"> <?php echo $this->lang->line('xin_hrsale_dashboard_options');?></label>
                    <select class="form-control" name="dashboard_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="dashboard_1" <?php if($dashboard_option=='dashboard_1'){?> selected <?php }?>> <?php echo $this->lang->line('xin_hrsale_dashboard_option_1');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('xin_hrsale_dashboard_options_details');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label"> <?php echo $this->lang->line('xin_sign_in_page_options');?></label>
                    <select class="form-control" name="login_page_options" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="login_page_1" <?php if($login_page_options=='login_page_1'){?> selected <?php }?>> <?php echo $this->lang->line('xin_hrsale_login_v1');?></option>
                      <option value="login_page_2" <?php if($login_page_options=='login_page_2'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_login_v2');?></option>
                      <option value="login_page_3" <?php if($login_page_options=='login_page_3'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_login_v3');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('xin_sign_in_page_option_details');?></small> </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('xin_hrsale_show_calendar_on_dashboard');?> </label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="dashboard_calendar" class="js-switch switch switcher-input" <?php if($dashboard_calendar=='true'):?> checked="checked" <?php endif;?> value="true" />
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-label"><?php echo $this->lang->line('xin_login_page_text');?>
                      </label>
                      <textarea class="form-control" name="login_page_text" id="login_page_text" rows="3"><?php echo $login_page_text;?></textarea>
                      <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('xin_login_page_text_desc');?></small>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow439;?>" id="account-notification_position">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'notification_position_info', 'id' => 'notification_position_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('theme_info' => 'UPDATE');?>
              <?php echo form_open('admin/theme/notification_position_info/', $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('dashboard_position');?></label>
                    <select class="form-control" name="notification_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_position');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="toast-top-right" <?php if($notification_position=='toast-top-right'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_right');?></option>
                      <option value="toast-bottom-right" <?php if($notification_position=='toast-bottom-right'){?> selected <?php }?>><?php echo $this->lang->line('xin_bottom_right');?></option>
                      <option value="toast-bottom-left" <?php if($notification_position=='toast-bottom-left'){?> selected <?php }?>><?php echo $this->lang->line('xin_bottom_left');?></option>
                      <option value="toast-top-left" <?php if($notification_position=='toast-top-left'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_left');?></option>
                      <option value="toast-top-center" <?php if($notification_position=='toast-top-center'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_center');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_set_position_for_notifications');?></small> </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_close_button');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="sclose_btn" id="sclose_btn" class="js-switch switch switcher-input" <?php if($notification_close_btn=='true'):?> checked="checked" <?php endif;?> value="true">
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_progress_bar');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="snotification_bar" id="snotification_bar" class="js-switch switch switcher-input" <?php if($notification_bar=='true'):?> checked="checked" <?php endif;?> value="true">
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow118;?>" id="account-system_logos">
            <div class="row">
              <div class="col-xl-12">
                <div class="nav-tabs-top mb-4">
                  <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#xin_system_logos"><?php echo $this->lang->line('xin_system_logos');?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#xin_theme_signin_page_logo_title"><?php echo $this->lang->line('xin_theme_signin_page_logo_title');?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#xin_theme_job_page_logo_title"><?php echo $this->lang->line('xin_theme_job_page_logo_title');?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#xin_theme_payroll_logo_title"><?php echo $this->lang->line('xin_theme_payroll_logo_title');?></a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade active show" id="xin_system_logos">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <?php $attributes = array('name' => 'logo_info', 'id' => 'logo_info', 'autocomplete' => 'off');?>
                            <?php $hidden = array('company_logo' => 'UPDATE');?>
                            <?php echo form_open_multipart('admin/settings/logo_info/'.$company_info_id, $attributes, $hidden);?>
                            <div class='form-group'>
                              <fieldset class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('xin_first_logo');?></label>
                                <?php if($logo!='' && $logo!='no file') {?>
                                <input type="file" class="form-control-file" id="p_file" name="p_file" value="<?php echo $logo;?>">
                                <?php } else {?>
                                <input type="file" class="form-control-file" id="p_file" name="p_file">
                                <?php } ?>
                              </fieldset>
                              <?php if($logo!='' && $logo!='no file') {?>
                              <img src="<?php echo base_url().'uploads/logo/'.$logo;?>" width="70px" style="margin-left:30px;" id="u_file_1">
                              <?php } else {?>
                              <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file_1">
                              <?php } ?>
                              <br>
                              <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                              <small>- <?php echo $this->lang->line('xin_best_main_logo_size');?></small><br />
                              <small>- <?php echo $this->lang->line('xin_logo_whit_background_light_text');?></small> </div>
                            <div class="form-actions box-footer">
                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                            </div>
                            <?php echo form_close(); ?> </div>
                          <div class="col-md-6">
                            <?php $attributes = array('name' => 'logo_favicon', 'id' => 'logo_favicon', 'autocomplete' => 'off');?>
                            <?php $hidden = array('company_logo' => 'UPDATE');?>
                            <?php echo form_open_multipart('admin/settings/logo_favicon/'.$company_info_id, $attributes, $hidden);?>
                            <div class='form-group'>
                              <fieldset class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('xin_favicon');?></label>
                                <input type="file" class="form-control-file" id="favicon" name="favicon">
                              </fieldset>
                              <?php if($favicon!='' && $favicon!='no file') {?>
                              <img src="<?php echo base_url().'uploads/logo/favicon/'.$favicon;?>" width="16px" style="margin-left:30px;" id="favicon1">
                              <?php } else {?>
                              <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="16px" style="margin-left:30px;" id="favicon1">
                              <?php } ?>
                              <br>
                              <small>- <?php echo $this->lang->line('xin_logo_files_only_favicon');?></small><br />
                              <small>- <?php echo $this->lang->line('xin_best_logo_size_favicon');?></small></div>
                            <div class="form-actions box-footer">
                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="xin_theme_signin_page_logo_title">
                      <div class="card-body">
						<?php $attributes = array('name' => 'singin_logo', 'id' => 'singin_logo', 'autocomplete' => 'off');?>
                        <?php $hidden = array('company_logo' => 'UPDATE');?>
                        <?php echo form_open_multipart('admin/theme/singin_logo/', $attributes, $hidden);?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class='form-group'>
                              <fieldset class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('xin_logo');?></label>
                                <input type="file" class="form-control-file" id="p_file3" name="p_file3">
                              </fieldset>
                              <?php if($sign_in_logo!='' && $sign_in_logo!='no file') {?>
                              <img src="<?php echo base_url().'uploads/logo/signin/'.$sign_in_logo;?>" width="70px" style="margin-left:30px;" id="u_file3">
                              <?php } else {?>
                              <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file3">
                              <?php } ?>
                              <br>
                              <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                              <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?></small></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-actions box-footer">
                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                            </div>
                          </div>
                        </div>
                        <?php echo form_close(); ?> </div>
                    </div>
                    <div class="tab-pane fade" id="xin_theme_job_page_logo_title">
                      <div class="card-body">
                    <?php $attributes = array('name' => 'job_logo', 'id' => 'job_logo', 'autocomplete' => 'off');?>
                    <?php $hidden = array('job_logo' => 'UPDATE');?>
                    <?php echo form_open_multipart('admin/settings/job_logo/', $attributes, $hidden);?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class='form-group'>
                          <fieldset class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('xin_logo');?></label>
                            <input type="file" class="form-control-file" id="p_file4" name="p_file4">
                          </fieldset>
                          <?php if($job_logo!='' && $job_logo!='no file') {?>
                          <img src="<?php echo base_url().'uploads/logo/job/'.$job_logo;?>" width="70px" style="margin-left:30px;" id="u_file4">
                          <?php } else {?>
                          <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file4">
                          <?php } ?>
                          <br>
                          <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                          <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?> </small></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-actions box-footer">
                          <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                      </div>
                    </div>
                    <?php echo form_close(); ?> </div>
                    </div>
                    <div class="tab-pane fade" id="xin_theme_payroll_logo_title">
                      <div class="card-body">
                    <?php $attributes = array('name' => 'payroll_logo', 'id' => 'payroll_logo_info', 'autocomplete' => 'off');?>
                    <?php $hidden = array('payroll_logo' => 'UPDATE');?>
                    <?php echo form_open_multipart('admin/settings/payroll_logo/', $attributes, $hidden);?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class='form-group'>
                          <fieldset class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('xin_logo');?></label>
                            <input type="file" class="form-control-file" id="p_file5" name="p_file5">
                          </fieldset>
                          <?php if($payroll_logo!='' && $payroll_logo!='no file') {?>
                          <img src="<?php echo base_url().'uploads/logo/payroll/'.$payroll_logo;?>" width="70px" style="margin-left:30px;" id="u_file5">
                          <?php } else {?>
                          <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file5">
                          <?php } ?>
                          <br>
                          <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                          <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?></small></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-actions box-footer">
                          <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                      </div>
                    </div>
                    <?php echo form_close(); ?> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <?php if($system[0]->module_orgchart=='true'){?>
        <div class="tab-pane fade <?php echo $actshow441;?>" id="account-org_chart">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'orgchart_info', 'id' => 'orgchart_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('iorgchart_info' => 'UPDATE');?>
              <?php echo form_open('admin/theme/orgchart/', $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_org_chart_layout');?></label>
                    <select class="form-control" name="org_chart_layout" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_org_chart_layout');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="r2l" <?php if($org_chart_layout=='r2l'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_r2l');?></option>
                      <option value="l2r" <?php if($org_chart_layout=='l2r'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_l2r');?></option>
                      <option value="t2b" <?php if($org_chart_layout=='t2b'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_t2b');?></option>
                      <option value="b2t" <?php if($org_chart_layout=='b2t'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_b2t');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_org_chart_set_layout');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('xin_org_chart_export_file_title');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_org_chart_export_file_title');?>" name="export_file_title" type="text" value="<?php echo $export_file_title;?>">
                    <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_org_chart_export_file_title_details');?> </small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_export');?>
                      <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_export_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_export');?>"><span class="fa fa-question-circle"></span></button>
                    </label>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="export_orgchart" id="export_orgchart" class="js-switch switch switcher-input" <?php if($export_orgchart=='true'):?> checked="checked" <?php endif;?> value="true">
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_zoom');?>
                      <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_zoom_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_zoom');?>"><span class="fa fa-question-circle"></span></button>
                    </label>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="org_chart_zoom" id="org_chart_zoom" class="js-switch switch switcher-input" <?php if($org_chart_zoom=='true'):?> checked="checked" <?php endif;?> value="true">
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_pan');?>
                      <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_pan_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_pan');?>"><span class="fa fa-question-circle"></span></button>
                    </label>
                    <div class="pull-xs-left m-r-1">
                      <label class="switcher switcher-success">
                        <input type="checkbox" name="org_chart_pan" id="org_chart_pan" class="js-switch switch switcher-input" <?php if($org_chart_pan=='true'):?> checked="checked" <?php endif;?> value="true">
                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
        <?php } ?>
        <div class="tab-pane fade <?php echo $actshow118;?>" id="account-payment_gateway">
          <div class="card-body">
            <?php $attributes = array('name' => 'payment_gateway', 'id' => 'payment_gateway', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_company_info' => 'UPDATE');?>
            <?php echo form_open('admin/settings/update_payment_gateway/996633', $attributes, $hidden);?>
            <h5><?php echo $this->lang->line('xin_acc_paypal_info');?></h5>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('xin_acc_paypal_email');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_paypal_email');?>" name="paypal_email" type="text" value="<?php echo $paypal_email;?>">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label class="form-label"><?php echo $this->lang->line('xin_acc_paypal_sandbox_active');?></label>
                      <select class="form-control" name="paypal_sandbox" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('paypal_sandbox_active');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="yes" <?php if($paypal_sandbox =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_yes');?></option>
                        <option value="no" <?php if($paypal_sandbox =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_no');?></option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label"><?php echo $this->lang->line('xin_employees_active');?></label>
                      <select class="form-control" name="paypal_active" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_employees_active');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="yes" <?php if($paypal_active =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_yes');?></option>
                        <option value="no" <?php if($paypal_active =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_no');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('xin_acc_paypal_ipn_url');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_paypal_ipn_url');?>" name="paypal_ipn_url" type="text" value="<?php echo site_url('admin/gateway/paypal_process/paypal_ipn');?>" readonly="readonly">
                </div>
              </div>
            </div>
          </div>
          <hr class="border-light m-0">
          <div class="card-body">
            <h5 class="pb-2"><?php echo $this->lang->line('xin_acc_stripe_info');?></h5>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('xin_acc_stripe_secret_key');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_stripe_secret_key');?>" name="stripe_secret_key" type="text" value="<?php echo $stripe_secret_key;?>">
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('xin_acc_stripe_publlished_key');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_stripe_publlished_key');?>" name="stripe_publishable_key" type="text" value="<?php echo $stripe_publishable_key;?>">
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('xin_employees_active');?></label>
                  <select class="form-control" name="stripe_active" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_employees_active');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="yes" <?php if($stripe_active =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_yes');?></option>
                    <option value="no" <?php if($stripe_active =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_no');?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <hr class="border-light m-0">
          <div class="card-body">
            <h6 class="mb-4"><?php echo $this->lang->line('xin_acc_online_payment_receive_account');?></h6>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('xin_acc_account');?></label>
                  <select name="bank_cash_id" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
                    <option value=""></option>
                    <?php foreach($all_bank_cash as $bank_cash) {?>
                    <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($online_payment_account == $bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->account_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>