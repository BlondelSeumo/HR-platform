<?php
/* Theme Settings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $file_setting = $this->Xin_model->read_file_setting_info(1);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<section id="basic-listgroup">
  <div class="row match-heights <?php echo $get_animate?>">
    <div class="col-lg-3 col-md-3">
      <div class="card">
        <div class="card-blocks">
          <div class="list-group"> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item active" href="#page_layout" data-profile="1" data-profile-block="page_layout" data-toggle="tab" aria-expanded="true" id="setting_1"> <i class="fa fa-cubes"></i> <?php echo $this->lang->line('xin_page_layouts');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#notification" data-profile="4" data-profile-block="notification" data-toggle="tab" aria-expanded="true" id="setting_4"> <i class="fa fa-exclamation-circle"></i> <?php echo $this->lang->line('xin_notification_position');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#form_design" data-profile="5" data-profile-block="form_design" data-toggle="tab" aria-expanded="true" id="setting_5"> <i class="fa fa-edit"></i> <?php echo $this->lang->line('xin_theme_form_design');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#company_logo" data-profile="6" data-profile-block="company_logo" data-toggle="tab" aria-expanded="true" id="setting_6"> <i class="fa fa-image"></i> <?php echo $this->lang->line('xin_system_logos');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#signin_logo" data-profile="7" data-profile-block="signin_logo" data-toggle="tab" aria-expanded="true" id="setting_7"> <i class="fa fa-file-image-o"></i> <?php echo $this->lang->line('xin_theme_signin_page_logo_title');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#job_page_logo" data-profile="8" data-profile-block="job_page_logo" data-toggle="tab" aria-expanded="true" id="setting_8"> <i class="fa fa-file-image-o"></i> <?php echo $this->lang->line('xin_theme_job_page_logo_title');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#payroll_logo" data-profile="9" data-profile-block="payroll_logo" data-toggle="tab" aria-expanded="true" id="setting_9"> <i class="fa fa-camera-retro"></i> <?php echo $this->lang->line('xin_theme_payroll_logo_title');?> </a>
            <?php if($system[0]->module_orgchart=='true'){?>
            <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#org_chart" data-profile="10" data-profile-block="org_chart" data-toggle="tab" aria-expanded="true" id="setting_10"> <i class="fa fa-sitemap"></i> <?php echo $this->lang->line('xin_org_chart_title');?> </a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="page_layout">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_page_layouts');?> </h3>
        </div>
        <div class="box-body">
          <div class="box-block">
            <?php $attributes = array('name' => 'page_layouts_info', 'id' => 'page_layouts_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('theme_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/page_layouts/', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('xin_theme_page_headers');?></label>
                    <select class="form-control" name="page_header" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_theme_page_headers');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="breadcrumb-light" <?php if($page_header=='breadcrumb-light'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_breadcrumbs_transparent');?></option>
                      <option value="breadcrumb-transparent" <?php if($page_header=='breadcrumb-transparent'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_breadcrumbs_light');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $this->lang->line('xin_theme_set_breadcrumbs');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('xin_theme_footer_layout');?></label>
                    <select class="form-control" name="footer_layout" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_theme_footer_layout');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="footer-light" <?php if($footer_layout=='footer-light'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_footer_light');?></option>
                      <option value="footer-dark" <?php if($footer_layout=='footer-dark'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_footer_dark');?></option>
                      <option value="footer-transparent" <?php if($footer_layout=='footer-transparent'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_footer_transparent');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $this->lang->line('xin_theme_set_footer_layout');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('xin_theme_show_dashboard_cards');?></label>
                    <select class="form-control" name="statistics_cards" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_theme_show_dashboard_cards');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="0" <?php if($statistics_cards=='0'){?> selected <?php }?>>0</option>
                      <option value="4" <?php if($statistics_cards=='4'){?> selected <?php }?>>4</option>
                      <option value="8" <?php if($statistics_cards=='8'){?> selected <?php }?>>8</option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $this->lang->line('xin_theme_set_statistics_cards');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('xin_header_menu_animation_style');?></label>
                    <select class="form-control  input--dropdown js--animations" name="animation_style" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                      <optgroup label="Fading Entrances">
                      <option value="fadeIn" <?php if($astyle=='fadeIn'):?> selected="selected"<?php endif;?>>fadeIn</option>
                      <option value="fadeInDown"<?php if($astyle=='fadeInDown'):?> selected="selected"<?php endif;?>>fadeInDown</option>
                      <option value="fadeInDownBig"<?php if($astyle=='fadeInDownBig'):?> selected="selected"<?php endif;?>>fadeInDownBig</option>
                      <option value="fadeInLeft"<?php if($astyle=='fadeInLeft'):?> selected="selected"<?php endif;?>>fadeInLeft</option>
                      <option value="fadeInLeftBig"<?php if($astyle=='fadeInLeftBig'):?> selected="selected"<?php endif;?>>fadeInLeftBig</option>
                      <option value="fadeInRight"<?php if($astyle=='fadeInRight'):?> selected="selected"<?php endif;?>>fadeInRight</option>
                      <option value="fadeInRightBig"<?php if($astyle=='fadeInRightBig'):?> selected="selected"<?php endif;?>>fadeInRightBig</option>
                      <option value="fadeInUp"<?php if($astyle=='fadeInUp'):?> selected="selected"<?php endif;?>>fadeInUp</option>
                      <option value="fadeInUpBig"<?php if($astyle=='fadeInUpBig'):?> selected="selected"<?php endif;?>>fadeInUpBig</option>
                      </optgroup>
                      <optgroup label="Flippers">
                      <option value="flip"<?php if($astyle=='flip'):?> selected="selected"<?php endif;?>>flip</option>
                      <option value="flipInX"<?php if($astyle=='flipInX'):?> selected="selected"<?php endif;?>>flipInX</option>
                      <option value="flipInY"<?php if($astyle=='flipInY'):?> selected="selected"<?php endif;?>>flipInY</option>
                      </optgroup>
                      <optgroup label="Sliding Entrances">
                      <option value="slideInDown"<?php if($astyle=='slideInDown'):?> selected="selected"<?php endif;?>>slideInDown</option>
                      <option value="slideInLeft"<?php if($astyle=='slideInLeft'):?> selected="selected"<?php endif;?>>slideInLeft</option>
                      <option value="slideInRight"<?php if($astyle=='slideInRight'):?> selected="selected"<?php endif;?>>slideInRight</option>
                      </optgroup>
                      <optgroup label="Attention Seekers">
                      <option value="flash"<?php if($astyle=='flash'):?> selected="selected"<?php endif;?>>flash</option>
                      <option value="pulse"<?php if($astyle=='pulse'):?> selected="selected"<?php endif;?>>pulse</option>
                      <option value="shake"<?php if($astyle=='shake'):?> selected="selected"<?php endif;?>>shake</option>
                      <option value="swing"<?php if($astyle=='swing'):?> selected="selected"<?php endif;?>>swing</option>
                      <option value="tada"<?php if($astyle=='tada'):?> selected="selected"<?php endif;?>>tada</option>
                      <option value="wobble"<?php if($astyle=='wobble'):?> selected="selected"<?php endif;?>>wobble</option>
                      <option value="rollIn"<?php if($astyle=='rollIn'):?> selected="selected"<?php endif;?>>rollIn</option>
                      </optgroup>
                    </select>
                    <header class="site__header island">
                      <div class="wrap"> <span id="animationSandbox" style="display: block;" class=""> <small class="site__title mega"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $this->lang->line('xin_header_menu_animation_style_view_changes');?></small></span> </div>
                    </header>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"> <?php echo $this->lang->line('xin_hrsale_themes_options');?></label>
                    <select class="form-control" name="theme_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="template_1" <?php if($theme_option=='template_1'){?> selected <?php }?>> <?php echo $this->lang->line('xin_hrsale_themes_option_1');?></option>
                      <option value="template_2" <?php if($theme_option=='template_2'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                      <option value="template_3" <?php if($theme_option=='template_3'){?> selected <?php }?>>Template 3<?php //echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                      <option value="template_4" <?php if($theme_option=='template_4'){?> selected <?php }?>>Template 4<?php //echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                      <option value="template_5" <?php if($theme_option=='template_5'){?> selected <?php }?>>Template 5<?php //echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                      <option value="template_6" <?php if($theme_option=='template_6'){?> selected <?php }?>>Template 6<?php //echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                      <option value="template_7" <?php if($theme_option=='template_7'){?> selected <?php }?>>Template 7<?php //echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                      <option value="template_8" <?php if($theme_option=='template_8'){?> selected <?php }?>>Template 8<?php //echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                      <option value="template_9" <?php if($theme_option=='template_9'){?> selected <?php }?>>Template 9<?php //echo $this->lang->line('xin_hrsale_themes_option_2');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $this->lang->line('xin_hrsale_themes_options_details');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"> <?php echo $this->lang->line('xin_hrsale_dashboard_options');?></label>
                    <select class="form-control" name="dashboard_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="dashboard_1" <?php if($dashboard_option=='dashboard_1'){?> selected <?php }?>> <?php echo $this->lang->line('xin_hrsale_dashboard_option_1');?></option>
                      <option value="dashboard_2" <?php if($dashboard_option=='dashboard_2'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_dashboard_option_2');?></option>
                      <option value="dashboard_3" <?php if($dashboard_option=='dashboard_3'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_dashboard_option_3');?></option>
                      <option value="dashboard_4" <?php if($dashboard_option=='dashboard_4'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_dashboard_option_4');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $this->lang->line('xin_hrsale_dashboard_options_details');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"> <?php echo $this->lang->line('xin_sign_in_page_options');?></label>
                    <select class="form-control" name="login_page_options" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="login_page_1" <?php if($login_page_options=='login_page_1'){?> selected <?php }?>> <?php echo $this->lang->line('xin_hrsale_login_v1');?></option>
                      <option value="login_page_2" <?php if($login_page_options=='login_page_2'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_login_v2');?></option>
                      <option value="login_page_3" <?php if($login_page_options=='login_page_3'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_login_v3');?></option>
                      <option value="login_page_4" <?php if($login_page_options=='login_page_4'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_login_v4');?></option>
                      <option value="login_page_5" <?php if($login_page_options=='login_page_5'){?> selected <?php }?>><?php echo $this->lang->line('xin_hrsale_login_v5');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="fa fa-arrow-circle-o-up"></i> <?php echo $this->lang->line('xin_sign_in_page_option_details');?></small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="company_name" data-trigger="hover"> <?php echo $this->lang->line('xin_hrsale_show_calendar_on_dashboard');?> </label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <input type="checkbox" name="dashboard_calendar" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($dashboard_calendar=='true'):?> checked="checked" <?php endif;?> value="true" />
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="company_name" data-trigger="hover"> <?php echo $this->lang->line('xin_hr_sub_menu_icons');?> </label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label> <i class="fa fa-circle-o"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-circle-o" <?php if($sub_menu_icons=='fa-circle-o'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-check"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-check" <?php if($sub_menu_icons=='fa-check'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-circle"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-circle" <?php if($sub_menu_icons=='fa-circle'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-ellipsis-h"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-ellipsis-h" <?php if($sub_menu_icons=='fa-ellipsis-h'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-check-circle-o"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-check-circle-o" <?php if($sub_menu_icons=='fa-check-circle-o'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-circle-thin"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-circle-thin" <?php if($sub_menu_icons=='fa-circle-thin'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-arrow-right"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-arrow-right" <?php if($sub_menu_icons=='fa-arrow-right'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-long-arrow-right"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-long-arrow-right" <?php if($sub_menu_icons=='fa-long-arrow-right'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-arrow-circle-o-right"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-arrow-circle-o-right" <?php if($sub_menu_icons=='fa-arrow-circle-o-right'):?> checked="checked" <?php endif;?>>
                      </label>
                      <label> <i class="fa fa-caret-right"></i><br />
                        <input type="radio" name="sub_menu_icons" class="minimal" value="fa-caret-right" <?php if($sub_menu_icons=='fa-caret-right'):?> checked="checked" <?php endif;?>>
                      </label>
                    </div>
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
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="form_design" style="display:none;">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_theme_form_design');?> </h3>
        </div>
        <div class="box-body">
          <div class="box-block">
            <?php $attributes = array('name' => 'form_design_info', 'id' => 'form_design_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('form_design_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/form_design/', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('xin_theme_form_design_input');?></label>
                    <select class="form-control" name="form_design" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_theme_form_design_input');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="basic_form" <?php if($form_design=='basic_form'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_default_input_design');?></option>
                      <option value="modern_form" <?php if($form_design=='modern_form'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_modern_form_design');?></option>
                      <option value="rounded_form" <?php if($form_design=='rounded_form'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_rounded_form_design');?></option>
                      <option value="default_square_form" <?php if($form_design=='default_square_form'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_default_square_form_design');?></option>
                      <option value="medium_square_form" <?php if($form_design=='medium_square_form'){?> selected <?php }?>><?php echo $this->lang->line('xin_theme_medium_square_form_design');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_theme_set_form_design');?></small> </div>
                </div>
                <div class="col-md-12">
                  <p>
                    <label for="xin_theme_form_design"><strong><?php echo $this->lang->line('xin_theme_basic_form_design');?></strong></label>
                  </p>
                  <img class="img-thumbnail img-fluid" src="<?php echo base_url('skin/img/form_input_designs.png');?>" /> </div>
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
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="notification" style="display:none;">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_notification_position');?> </h3>
        </div>
        <div class="box-body">
          <div class="box-block">
            <?php $attributes = array('name' => 'notification_position_info', 'id' => 'notification_position_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('theme_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/notification_position_info/', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('dashboard_position');?></label>
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
                    <label for="company_name"><?php echo $this->lang->line('xin_close_button');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <input type="checkbox" name="sclose_btn" id="sclose_btn" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($notification_close_btn=='true'):?> checked="checked" <?php endif;?> value="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="company_name"><?php echo $this->lang->line('xin_progress_bar');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <input type="checkbox" name="snotification_bar" id="snotification_bar" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($notification_bar=='true'):?> checked="checked" <?php endif;?> value="true">
                    </div>
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
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="company_logo" style="display:none;">
      <div class="box mb-4">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_system_logos');?> </h3>
        </div>
        <div id="hrsale_1" class="box-body">
          <div class="row">
            <?php $attributes = array('name' => 'logo_info', 'id' => 'logo_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('company_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/settings/logo_info/'.$company_info_id, $attributes, $hidden);?>
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_first_logo');?></label>
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
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
            <?php echo form_close(); ?>
            <?php $attributes = array('name' => 'logo_favicon', 'id' => 'logo_favicon', 'autocomplete' => 'off');?>
            <?php $hidden = array('company_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/settings/logo_favicon/'.$company_info_id, $attributes, $hidden);?>
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_favicon');?></label>
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
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="signin_logo" style="display:none;">
      <div class="box mb-4">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_theme_signin_page_logo_title');?> </h3>
        </div>
        <div id="hrsale_2" class="box-body">
          <?php $attributes = array('name' => 'singin_logo', 'id' => 'singin_logo', 'autocomplete' => 'off');?>
          <?php $hidden = array('company_logo' => 'UPDATE');?>
          <?php echo form_open_multipart('admin/admin/singin_logo/', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
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
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="job_page_logo" style="display:none;">
      <div class="box mb-4">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_theme_job_page_logo_title');?> <small>(<?php echo $this->lang->line('left_frontend');?>)</small> </h3>
        </div>
        <div id="hrsale_3" class="box-body">
          <?php $attributes = array('name' => 'job_logo', 'id' => 'job_logo', 'autocomplete' => 'off');?>
          <?php $hidden = array('job_logo' => 'UPDATE');?>
          <?php echo form_open_multipart('admin/settings/job_logo/', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
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
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="payroll_logo" style="display:none;">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_theme_payroll_logo_title');?> <small>(<?php echo $this->lang->line('xin_for_pdf');?>)</small> </h3>
        </div>
        <div id="hrsale_4" class="box-body">
          <?php $attributes = array('name' => 'payroll_logo', 'id' => 'payroll_logo_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('payroll_logo' => 'UPDATE');?>
          <?php echo form_open_multipart('admin/settings/payroll_logo/', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
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
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
    <?php if($system[0]->module_orgchart=='true'){?>
    <div class="col-md-9 current-tab animated fadeInRight" id="org_chart" style="display:none;">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_org_chart_title');?> </h3>
        </div>
        <div class="box-body">
          <div class="box-block">
            <?php $attributes = array('name' => 'orgchart_info', 'id' => 'orgchart_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('iorgchart_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/orgchart/', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('xin_org_chart_layout');?></label>
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
                    <label for="export_file_title"><?php echo $this->lang->line('xin_org_chart_export_file_title');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_org_chart_export_file_title');?>" name="export_file_title" type="text" value="<?php echo $export_file_title;?>">
                    <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_org_chart_export_file_title_details');?> </small> </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="export_orgchart" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_export');?>
                      <button type="button" class="btn icon-btn btn-xs btn-outline-info itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_export_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_export');?>"><span class="fa fa-question-circle"></span></button>
                    </label>
                    <div class="pull-xs-left m-r-1">
                      <input type="checkbox" name="export_orgchart" id="export_orgchart" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($export_orgchart=='true'):?> checked="checked" <?php endif;?> value="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="export_orgchart" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_zoom');?>
                      <button type="button" class="btn icon-btn btn-xs btn-outline-info itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_zoom_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_zoom');?>"><span class="fa fa-question-circle"></span></button>
                    </label>
                    <div class="pull-xs-left m-r-1">
                      <input type="checkbox" name="org_chart_zoom" id="org_chart_zoom" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($org_chart_zoom=='true'):?> checked="checked" <?php endif;?> value="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="export_orgchart" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_pan');?>
                      <button type="button" class="btn icon-btn btn-xs btn-outline-info itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_pan_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_pan');?>"><span class="fa fa-question-circle"></span></button>
                    </label>
                    <div class="pull-xs-left m-r-1">
                      <input type="checkbox" name="org_chart_pan" id="org_chart_pan" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($org_chart_pan=='true'):?> checked="checked" <?php endif;?> value="true">
                    </div>
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
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</section>
