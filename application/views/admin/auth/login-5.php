<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
<?php
$session = $this->session->userdata('username');
if(!empty($session)){ 
	redirect('admin/dashboard/');
}
?>
<?php
$session = $this->session->userdata('username');
if(empty($wz_lang)):
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';
elseif($wz_lang == 'english'):
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
endif;
if($system[0]->enable_auth_background=='yes'):
	$auth_bg = 'bg-full-screen-image-admin-login';
else:
	$auth_bg = '';	
endif;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/dist/css/AdminLTE.min.css">
<!-- toastr -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.css">
<!-- animate -->
<link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/animate.css">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_login_2.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<img id="hrload-img" src="<?php echo base_url()?>skin/img/loading.gif" style="">
<style type="text/css">
#hrload-img {
    display: none;
    z-index: 87896969;
    float: right;
    margin-right: 25px;
    margin-top: 0px;
}
</style>
<div class="login-box animated fadeInDownBig"> 
  <?php if($this->session->flashdata('reset_password_success')):?>
  <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->lang->line('xin_reset_password_success_sent_email');?> </div>
  <?php endif;?>
 <div class="login-logo"> 
      <!--<b style="color:#FFF;"><?php echo $company[0]->company_name;?></b>hrm--> 
      <img src="<?php echo base_url();?>uploads/logo/signin/<?php echo $company[0]->sign_in_logo;?>" alt="hrsale logo"> </div>
       <!-- /.login-logo -->
  <div class="login-box-body">    
    <p class="login-box-msg"><?php echo $this->lang->line('xin_sign_in_page_title');?></p>
    <?php $attributes = array('class' => 'form-hrsale', 'name' => 'hrm-form', 'id' => 'hrm-form', 'data-redirect' => 'dashboard', 'data-form-table' => 'login', 'data-is-redirect' => '1', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => 0);?>
    <?php echo form_open('admin/auth/login', $attributes, $hidden);?>
    <?php
	if($system[0]->employee_login_id=='username'):
		$login_txt = $this->lang->line('xin_login_username');
		$login_title = $this->lang->line('dashboard_username');
		$ilogn_info = 'fionagrace';
	    $ilogn_info2 = 'jhonsmith';
	else:
		$login_txt = $this->lang->line('xin_login_email');
		$login_title = $this->lang->line('dashboard_email');
		$ilogn_info = 'administrator@hrsale.com';
		$ilogn_info2 = 'jsmt12@hrsale.com';
	endif;?>
    <div class="form-group has-feedback">
      <input type="text" id="iusername" name="iusername" class="form-control" placeholder="<?php echo $login_txt;?>" autocomplete="off">
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span> </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" id="ipassword" name="ipassword" placeholder="Enter Password" autocomplete="off">
      <span class="glyphicon glyphicon-lock form-control-feedback"></span> </div>
    <div class="row">
      
      <!-- /.col -->
      <div class="col-xs-12"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-primary btn-block btn-flat save', 'content' => '<i class="fa fa-lock"></i> '.$this->lang->line('xin_login'))); ?> </div>
      <div class="col-xs-8 m-t-20"> <a href="<?php echo site_url('admin/auth/forgot_password');?>" class="d-block small"><?php echo $this->lang->line('xin_forgot_password_link');?></a> </div>
      <!-- /.col --> 
    </div>
    <?php echo form_close(); ?>
    <hr>
    <div class="row">
      <div class="col-xs-8">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown" aria-expanded="false">Login With</button>
          <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Login With</span> </button>
          <ul class="dropdown-menu" role="menu">
            <li><a class="dropdown-item login-as" href="javascript:void(0);" data-username="<?php echo $ilogn_info;?>" data-password="fgrace$$##">Super Admin</a></li>
            <li><a class="dropdown-item login-as" href="javascript:void(0);" data-username="<?php echo $ilogn_info2;?>" data-password="jhonsmith$$##">Employee</a></li>
          </ul>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-4">
        <button type="button" class="btn btn-success btn-block btn-flat btn-sm" onClick="window.location='<?php echo site_url('client/');?>'">Client Panel </button>
      </div>
      <!-- /.col --> 
    </div>
    <hr>
    <div class="lockscreen-footer text-center">
      <?php if($system[0]->enable_current_year=='yes'):?>
      <?php echo date('Y');?>
      <?php endif;?>
      © <?php echo $system[0]->footer_text;?>
      <?php if($system[0]->enable_page_rendered=='yes'):?>
      - <?php echo $this->lang->line('xin_page_rendered_text');?> <strong>{elapsed_time}</strong> seconds.
      <?php endif; ?>
    </div>
  </div>
  <!-- /.login-box-body --> 
</div>
<!-- /.login-box --> 

<!-- jQuery 3 --> 
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script> 
<!-- Bootstrap 3.3.7 --> 
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
	var site_url = '<?php echo site_url(); ?>';
});
</script> 
<script type="text/javascript">
var site_url = '<?php echo base_url(); ?>';
var processing_request = '<?php echo $this->lang->line('xin_processing_request');?>';</script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/hrsale_scripts/xin_login.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
$(".login-as").click(function(){
		var uname = jQuery(this).data('username');
		var password = jQuery(this).data('password');
		jQuery('#iusername').val(uname);
		jQuery('#ipassword').val(password);
	});
});	
</script>
</body>
</html>