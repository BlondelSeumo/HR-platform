<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php
if(!empty($wz_lang)):
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
elseif($system[0]->default_language!=''):
	$lang_code = $this->Xin_model->get_language_info($system[0]->default_language);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';	
endif;
?>
<?php
$role_user = $this->Xin_model->read_user_role_info($user[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
//$designation_info = $this->Xin_model->read_designation_info($user_info[0]->designation_id);
// set color
if($theme[0]->is_semi_dark==1):
	$light_cls = 'navbar-semi-dark navbar-shadow';
	$ext_clr = '';
else:
	$light_cls = 'navbar-dark';
	$ext_clr = $theme[0]->top_nav_dark_color;
endif;
// set layout / fixed or static
if($theme[0]->boxed_layout=='true'){
	$lay_fixed = 'container boxed-layout';
} else {
	$lay_fixed = '';
}
if($theme[0]->animation_style == '') {
	$animated = 'animated flipInY';
} else {
	$animated = 'animated '.$theme[0]->animation_style;
}
?>
<style type="text/css">
.main-header .sidebar-toggle-hrsale-chat:before {
	content: "\f0e6";
}
.main-header .sidebar-toggle-hrsale-quicklinks:before {
	content: "\f00a";
}
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('admin/dashboard/');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><img alt="HR Sale" src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo" style="width:32px;"></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img alt="HR Sale" src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo" style="width:32px;"> <b><?php echo $system[0]->application_name;?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <?php if($system[0]->module_chat_box=='true'){?>
        <a href="<?php echo site_url('admin/chat');?>" class="sidebar-toggle sidebar-toggle-hrsale-chat" role="button" title="<?php echo $this->lang->line('xin_hr_chat_box');?>">
          <?php $unread_msgs = $this->Xin_model->get_single_unread_message($session['user_id']);?>
          <?php if($unread_msgs > 0) {?><span class="chat-badge label label-aqua" id="msgs_count"><?php echo $unread_msgs;?></span><?php } ?>
        </a>
       <?php } if($user[0]->user_role_id=='1'){?>
          <a href="javascript:void(0);" class="sidebar-toggle sidebar-toggle-hrsale-quicklinks" role="button" data-toggle="modal" data-target=".modal-hrsaleapps" title="<?php echo $this->lang->line('xin_quick_links');?>">	</a>
        <?php } ?> 

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
		  <?php  if(in_array('90',$role_resources_ids)) { ?>
           <?php $fcount = 0; $leave_count = 0; $proj_count = 0; $tsk_count = 0;$nst_count = 0; $tkt_count = 0;
				if($user[0]->user_role_id=='1'){
					$leaveapp = $this->Xin_model->get_notify_leave_applications();
					$nproject = $this->Xin_model->get_notify_projects();
					$ntask = $this->Xin_model->get_notify_tasks();
					$nannouncements = $this->Xin_model->get_notify_announcements();
					$ntickets = $this->Xin_model->get_notify_tickets();
					// count
					$leave_count = $this->Xin_model->count_notify_leave_applications();
					$proj_count = $this->Xin_model->count_notify_projects();
					$tsk_count = $this->Xin_model->count_notify_tasks();
					$nst_count = $this->Xin_model->count_notify_announcements();
					$tkt_count = $this->Xin_model->count_notify_tickets();
					//$tsk_count = $this->Xin_model->count_notify_tasks();
					$fcount = $proj_count + $leave_count + $tsk_count + $nst_count + $tkt_count;
				} else {
					$leaveapp = $this->Xin_model->get_last_user_leave_applications($session['user_id']);
					// projects
					if(in_array('318',$role_resources_ids)) {
						$nproject = $this->Xin_model->get_notify_company_projects($user[0]->company_id);
						$proj_count = $this->Xin_model->count_notify_company_projects($user[0]->company_id);
					} else {
						$nproject = $this->Xin_model->get_notify_user_projects($session['user_id']);
						$proj_count = $this->Xin_model->count_notify_user_projects($session['user_id']);
					}
					// tasks
					if(in_array('322',$role_resources_ids)) {
						$ntask = $this->Xin_model->get_notify_company_tasks($user[0]->company_id);
						$tsk_count = $this->Xin_model->count_notify_company_tasks($user[0]->company_id);
					} else {
						$ntask = $this->Xin_model->get_notify_user_tasks($session['user_id']);
						$tsk_count = $this->Xin_model->count_notify_user_tasks($session['user_id']);
					}
					// announcementss
					if(in_array('257',$role_resources_ids)) {
						$nannouncements = $this->Xin_model->get_notify_company_announcements($user[0]->company_id);
						$nst_count = $this->Xin_model->count_notify_company_announcements($user[0]->company_id);
					} else {
						$nannouncements = $this->Xin_model->get_notify_dept_announcements($user[0]->department_id);
						$nst_count = $this->Xin_model->count_notify_dept_announcements($user[0]->department_id);
					}
					// tickets
					if(in_array('309',$role_resources_ids)) {
						$ntickets = $this->Xin_model->get_notify_company_tickets($user[0]->company_id);
						$tkt_count = $this->Xin_model->count_notify_company_tickets($user[0]->company_id);
					} else {
						$ntickets = $this->Xin_model->get_notify_user_tickets($session['user_id']);
						$tkt_count = $this->Xin_model->count_notify_user_tickets($session['user_id']);
					}
					// count
					$leave_count = $this->Xin_model->count_user_notify_leave_applications($session['user_id']);
					$fcount = $proj_count + $leave_count + $tsk_count + $nst_count + $tkt_count;
				}
			 ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <i class="fa fa-bell-o"></i>
              <span class="label label-success"><?php echo $fcount;?></span>
            </a>
            <?php if($proj_count > 0 || $leave_count > 0 || $tsk_count > 0 || $nst_count > 0 || $tkt_count > 0){?>
            <ul class="dropdown-menu menu <?php echo $animated;?>">
              <li><ul class="menu" style="max-height: 245px;"><li>
                <!-- inner menu: contains the actual data -->               
                <?php if($leave_count > 0){?>
                <ul class="menu">
                <li class="header"><a href="javascript:void(0);"><?php echo $this->lang->line('xin_leave_notifications');?></a></li>
                  <?php foreach($leaveapp as $leave_notify){?>
					<?php $employee_info = $this->Xin_model->read_user_info($leave_notify->employee_id);?>
                    <?php
                        if(!is_null($employee_info)){
                            $emp_name = $employee_info[0]->first_name. ' '.$employee_info[0]->last_name;
                        } else {
                            $emp_name = '--';	
                        }
                    ?>
                    <li><!-- start message -->
                    <a href="<?php echo site_url('admin/timesheet/leave_details/id')?>/<?php echo $leave_notify->leave_id;?>/">
                      <div class="pull-left">
                        <?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
                        <img src="<?php  echo base_url().'uploads/profile/'.$user[0]->profile_picture;?>" alt="" id="user_avatar" 
                        class="img-circle user_profile_avatar">
                        <?php } else {?>
                        <?php  if($user[0]->gender=='Male') { ?>
                        <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                        <?php } else { ?>
                        <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                        <?php } ?>
                        <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="img-circle user_profile_avatar">
                        <?php  } ?>
                      </div>
                      <h4>
                        <?php echo $emp_name;?>
                        <small><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($leave_notify->applied_on);?></small>
                      </h4>
                      <p><?php echo $this->lang->line('header_has_applied_for_leave');?></p>
                    </a>
                  </li>
                  <?php } ?>
                  </ul>
				  <?php } ?>
                  
                  <?php if($proj_count > 0){?>
                  <ul class="menu">
                  <li class="header"><a href="javascript:void(0);"><?php echo $this->lang->line('xin_projects_notifications');?></a></li>
                  <?php foreach($nproject as $nprj) {?>
                    <li><!-- start message -->
                    <a href="<?php echo site_url('admin/project/detail')?>/<?php echo $nprj->project_id;?>/">
                      <div class="pull-left">
                        <i class="fa fa-fw fa-tasks text-green"></i>
                      </div>
                      <h4>
                        <?php echo $nprj->title;?>
                        <small><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($nprj->end_date);?></small>
                      </h4>
                    </a>
                  </li>
                  <?php } ?>
                  </ul>
                  <?php } ?>
                  
                  <?php if($tsk_count > 0){?>
                  <ul class="menu">
                  <li class="header"><a href="javascript:void(0);"><?php echo $this->lang->line('xin_tasks_notifications');?></a></li>
                  <?php foreach($ntask as $ntsk) {?>
                    <li><!-- start message -->
                    <a href="<?php echo site_url('admin/timesheet/task_details')?>/id/<?php echo $ntsk->task_id;?>/">
                      <div class="pull-left">
                        <i class="fa fa-fw fa-bullhorn text-aqua"></i>
                      </div>
                      <h4>
                        <?php echo $ntsk->task_name;?>
                        <small><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($ntsk->end_date);?></small>
                      </h4>
                    </a>
                  </li>
                  <?php } ?>
                  </ul>
                  <?php } ?>
                  <?php if($nst_count > 0){?>
                  <ul class="menu">
                  <li class="header"><a href="javascript:void(0);"><?php echo $this->lang->line('dashboard_announcements');?></a></li>
                  <?php foreach($nannouncements as $n_annc) {?>
                    <li><!-- start message -->
                    <a href="<?php echo site_url('admin/announcement')?>/?is_notify=1">
                      <div class="pull-left">
                        <i class="fa fa-warning text-yellow"></i>
                      </div>
                      <h4>
                        <?php echo $n_annc->title;?>
                        <small><i class="fa fa-calendar"></i> <?php echo $this->Xin_model->set_date_format($n_annc->start_date);?></small>
                      </h4>
                    </a>
                  </li>
                  <?php } ?>
                  </ul>
                  <?php } ?>
                  <?php if($tkt_count > 0){?>
                  <ul class="menu">
                  <li class="header"><a href="javascript:void(0);"><?php echo $this->lang->line('left_tickets');?></a></li>
                  <?php foreach($ntickets as $n_ticket) {?>
                    <li><!-- start message -->
                      <a href="<?php echo site_url('admin/tickets/details')?>/<?php echo $n_ticket->ticket_id;?>">
                      <div class="pull-left">
                        <i class="fa fa-ticket text-red"></i>
                      </div>
                      <h4>
                        <?php echo $n_ticket->subject;?>
                        <small><i class="fa fa-codepen"></i> <?php echo $n_ticket->ticket_code;?></small>
                      </h4>
                    </a>
                  </li>
                  <?php } ?>
                  </ul>
                  <?php } ?>
                  <!-- end message -->
              </li>
            </ul>
            </li></ul>
            <?php } ?>
          </li> 
          <?php } ?>
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          	<?php  if(in_array('61',$role_resources_ids) || in_array('93',$role_resources_ids) || in_array('63',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('62',$role_resources_ids) || in_array('94',$role_resources_ids) || in_array('96',$role_resources_ids) || in_array('60',$role_resources_ids) || $user[0]->user_role_id==1 || $system[0]->module_recruitment=='true' || $system[0]->enable_job_application_candidates=='1' || in_array('50',$role_resources_ids) || in_array('393',$role_resources_ids)) { ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                  <i class="fa fa-qrcode"></i>
                </a>
                <ul class="dropdown-menu <?php echo $animated;?>">
                  <?php if($system[0]->module_recruitment=='true'){?>
				  <?php if($system[0]->enable_job_application_candidates=='1'){?>
                  <?php  if(in_array('50',$role_resources_ids)) { ?>
                  <li role="presentation">
                    <a role="menuitem" tabindex="-1" target="_blank" href="<?php echo site_url();?>frontend/jobs/"><i class="fa fa-newspaper-o"></i><?php echo $this->lang->line('header_apply_jobs_frontend');?>
                    </a>
                  </li>
                  <?php  } ?>
                  <?php  } ?>
                  <?php  } ?>
				  <?php  if(in_array('61',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/constants');?>"> <i class="fa fa-align-justify"></i><?php echo $this->lang->line('left_constants');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('393',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/custom_fields');?>"> <i class="fa fa-sliders"></i><?php echo $this->lang->line('xin_hrsale_custom_fields');?></a></li>
                  <?php } ?>
				  <?php  if($user[0]->user_role_id==1) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/roles');?>"> <i class="fa fa-unlock-alt"></i><?php echo $this->lang->line('xin_role_urole');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('93',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/modules');?>"> <i class="fa fa-life-ring"></i><?php echo $this->lang->line('xin_setup_modules');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('63',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/email_template');?>"> <i class="fa fa-envelope"></i><?php echo $this->lang->line('left_email_templates');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('92',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/employees/import');?>"> <i class="fa fa-users"></i><?php echo $this->lang->line('xin_import_employees');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('62',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/database_backup');?>"> <i class="fa fa-database"></i><?php echo $this->lang->line('header_db_log');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('94',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/theme');?>"> <i class="fa fa-columns"></i><?php echo $this->lang->line('xin_theme_settings');?></a></li>
                  <?php } ?>
                  <?php if($system[0]->module_orgchart=='true'){?>
            	  <?php if(in_array('96',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/organization/chart');?>"> <i class="fa fa-sitemap"></i><?php echo $this->lang->line('xin_org_chart_title');?></a></li>
                  <?php } ?>
                  <?php } ?>
                  <?php if(in_array('60',$role_resources_ids)) { ?>
                  <li class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings');?>"> <i class="fa fa-cog text-aqua"></i><?php echo $this->lang->line('header_configuration');?></a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>  
          	<?php if($system[0]->module_language=='true'){?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                  <?php echo $flg_icn;?>
                </a>
                <ul class="dropdown-menu <?php echo $animated;?>">
                <?php $languages = $this->Xin_model->all_languages();?>
				<?php foreach($languages as $lang):?>
                <?php $flag = '<img src="'.base_url().'uploads/languages_flag/'.$lang->language_flag.'">';?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/dashboard/set_language/').$lang->language_code;?>"><?php echo $flag;?> &nbsp; <?php echo $lang->language_name;?></a></li>
                  <?php endforeach;?>
                  <?php if($system[0]->module_language=='true'){?>
            	<?php  if(in_array('89',$role_resources_ids)) { ?>
                  <li class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/languages');?>"> <i class="fa fa-cog text-aqua"></i><?php echo $this->lang->line('left_settings');?></a></li>
                  <?php } ?>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>  
            <!--<li class="messages-menu">
            <a data-toggle="modal" data-target=".policy" href="#">
              <i class="fa fa-flag-o"></i>
            </a>
          </li> -->
              <li class="dropdown user user-menu">
              <?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
            	<?php $cpimg = base_url().'uploads/profile/'.$user[0]->profile_picture;?>
            	<?php $cimg = '<img src="'.$cpimg.'" alt="" id="user_avatar" class="img-circle rounded-circle user_profile_avatar">';?>
            <?php } else {?>
            <?php  if($user[0]->gender=='Male') { ?>
            <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
            <?php } else { ?>
            <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
            <?php } ?>
            	<?php $cpimg = $de_file;?>
            	<?php $cimg = '<img src="'.$de_file.'" alt="" id="user_avatar" class="img-circle rounded-circle user_profile_avatar">';?>
            <?php  } ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-user"></i>
            </a>
            <ul class="dropdown-menu <?php echo $animated;?>">
              <!-- User image -->
              <li class="user-header">
                <?php echo $cimg;?>
                <p>
                  <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>
                  <small><?php echo $this->lang->line('xin_emp_member_since');?> <?php echo date('M. Y',strtotime($user[0]->date_of_joining));?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-5 text-center">
                    <a href="<?php echo site_url('admin/auth/lock')?>"><?php echo $this->lang->line('xin_lock_user');?></a>
                  </div>
                  <div class="col-xs-3 text-center">
                    <a data-toggle="modal" data-target=".policy" href="#"><i class="fa fa-flag-o"></i></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="<?php echo site_url('admin/profile?change_password=true')?>"><?php echo $this->lang->line('xin_employee_password');?></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('admin/profile');?>" class="btn btn-default btn-flat"><?php echo $this->lang->line('header_my_profile');?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('admin/logout');?>" class="btn btn-default btn-flat text-red"><?php echo $this->lang->line('header_sign_out');?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gear fa-spin"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
