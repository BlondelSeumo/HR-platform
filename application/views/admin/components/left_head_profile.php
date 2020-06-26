<?php
$session = $this->session->userdata('username');
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if($theme[0]->right_side_icons=='true') {
	$icons_right = 'expanded menu-icon-right';
} else {
	$icons_right = '';
}
if($theme[0]->bordered_menu=='true') {
	$menu_bordered = 'menu-bordered';
} else {
	$menu_bordered = '';
}
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->is_active!=1) {
	redirect('admin/');
}
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $arr_mod = $this->Xin_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<?php 
if($theme[0]->sub_menu_icons != ''){
	$submenuicon = $theme[0]->sub_menu_icons;
} else {
	$submenuicon = 'fa-circle-o';
}
$company_info = $this->Xin_model->read_company_setting_info(1);
?>
<?php  if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {?>
<?php $cpimg = base_url().'uploads/profile/'.$user_info[0]->profile_picture;?>
<?php } else {?>
<?php  if($user_info[0]->gender=='Male') { ?>
<?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
<?php $cpimg = $de_file;?>
<?php  } ?>
  <?php if($theme[0]->theme_option == 'template_1'):?>
  <div class="user-panel">
    <div class="image text-center"><img src="<?php echo $cpimg;?>" class="img-circle" alt="<?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?>"> </div>
    <div class="info">
      <p><?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?></p>
      <a href="<?php echo site_url('admin/profile');?>"><i class="fa fa-user"></i></a>
      <?php if(in_array('60',$role_resources_ids)) { ?>
      <a href="<?php echo site_url('admin/settings');?>"><i class="fa fa-gear"></i></a>
      <?php } ?>
      <a href="<?php echo site_url('admin/logout');?>"><i class="fa fa-power-off"></i></a> </div>
  </div>
  <?php elseif($theme[0]->theme_option == 'template_2'):?>
  <div class="user-panel">
    <div class="pull-left image"> <img src="<?php echo $cpimg;?>" class="img-circle" alt="<?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?>"> </div>
    <div class="pull-left info">
      <p><?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?></p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
  </div>
  <?php elseif($theme[0]->theme_option == 'template_4' || $theme[0]->theme_option == 'template_5'):?>
  <div class="user-panel">
		 <div class="ulogo">
			 <a href="<?php echo site_url('admin/dashboard/');?>">
			  <!-- logo for regular state and mobile devices -->
			  <span><b><?php echo $system[0]->application_name;?> </b></span>
			</a>
		</div>
        <div class="image">
          <img src="<?php echo $cpimg;?>" class="rounded-circle" alt="<?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?>">
        </div>
        <div class="info">
          <p><?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?></p>
			<a href="<?php echo site_url('admin/profile');?>" class="link" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('header_my_profile');?>"><i class="fa fa-user"></i></a>
            <a href="<?php echo site_url('admin/profile?change_password=true')?>" class="link" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('xin_employee_password');?>"><i class="fa fa-key"></i></a>
            <a href="<?php echo site_url('admin/logout');?>" class="link" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('header_sign_out');?>"><i class="ion ion-power"></i></a>
        </div>
      </div>
  <?php else:?>
  
  <?php endif;?>
  