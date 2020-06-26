<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
<?php
$session = $this->session->userdata('client_username');
if(!empty($session)){ 
	redirect('client/dashboard/');
}
?>
<?php
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
	$auth_bg = 'bg-full-screen-image-admin-fpass';
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
  <!-- Icon fonts -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/fonts/fontawesome.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/fonts/linearicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/fonts/open-iconic.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/fonts/pe-icon-7-stroke.css">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/rtl/bootstrap.css" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/rtl/appwork.css" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/rtl/theme-corporate.css" class="theme-settings-theme-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/rtl/colors.css" class="theme-settings-colors-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/rtl/uikit.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/css/demo.css">
  <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/material-ripple.js"></script>
  <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/layout-helpers.js"></script>

  <!-- Theme settings -->
  <!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
  <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/theme-settings.js"></script>
  <script>
    window.themeSettings = new ThemeSettings({
      cssPath: '<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/rtl/',
      themesPath: '<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/rtl/'
    });
  </script>

  <!-- Core scripts -->
  <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/pace.js"></script>
  <script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/jquery.min.js"></script>

  <!-- Libs -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
  <!-- Page -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/css/pages/authentication.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/toastr/toastr.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/css/animate.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">
  </head>
<body>
<div class="page-loader">
    <div class="bg-primary"></div>
  </div>
<div class="authentication-wrapper authentication-2 px-4">
    <div class="authentication-inner py-5"> 
    
    <!-- Form -->
    <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'class' => 'form-hrsale', 'autocomplete' => 'off');?>
    <?php $hidden = array('_method' => 'forgott_pass');?>
    <?php echo form_open('client/auth/send_mail/', $attributes, $hidden);?>
    <div class="p-4 p-sm-5"> 
        
        <!-- Logo -->
        <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
        <div class="position-relative"> <img src="<?php echo base_url();?>uploads/logo/signin/<?php echo $company[0]->sign_in_logo;?>" alt="hrsale logo"> </div>
      </div>
        <!-- / Logo -->
        
        <h5 class="text-center text-muted font-weight-normal mb-4"><?php echo $this->lang->line('xin_reset_password_hr');?></h5>
        <hr class="mt-0 mb-4">
        <p> <?php echo $this->lang->line('xin_reset_password_link');?> </p>
        <div class="form-group">
        <input type="text" name="iemail" id="iemail" class="form-control" placeholder="<?php echo $this->lang->line('xin_enter_your_email_fg');?>">
        <a href="<?php echo site_url('client/');?>" class="d-block small"><?php echo $this->lang->line('xin_remember_password');?></a> </div>
        <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-primary btn-block btn-flat save', 'content' => '<i class="fa fa-unlock"></i> '.$this->lang->line('xin_hr_recover_password'))); ?> </div>
    <?php echo form_close();?> 
    <!-- / Form --> 
    
  </div>
  </div>
<!-- /.login-box --> 

<!-- Core scripts --> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/popper/popper.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/bootstrap.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/sidenav.js"></script> 
<!-- Libs --> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script> 
<!-- Demo --> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/demo.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/toastr/toastr.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/ladda/ladda.css">
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/spin/spin.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/ladda/ladda.js"></script>

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
$(document).ready(function(){
	Ladda.bind('button[type=submit]');
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=forgot_password&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
	});
});
</script>
</body>
</html>