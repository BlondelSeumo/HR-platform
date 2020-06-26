<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $session = $this->session->userdata('username');?>
<?php 
/*if(!$session){
	redirect('admin');
}*/
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
	$auth_bg = 'style="background-position: center center; background-size: cover; background-image: url('.base_url().'skin/hrsale_assets/img/bg/bg-2.jpg");"';
else:
	$auth_bg = '';	
endif;
?>
<?php
$session_id = $this->session->userdata('user_id');
$iresult = $this->Login_model->read_user_info_session_id($session_id['user_id']);
?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
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
  <!-- toastr -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/toastr/toastr.min.css">
  <!-- animate -->
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/css/animate.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">
  </head>
  <body>
<style type="text/css">
#hrload-img {
    display: none;
    position: absolute;
}
</style>
<div class="page-loader">
    <div class="bg-primary"></div>
  </div>

<!-- Content -->

<div class="authentication-wrapper authentication-1 px-4">
    <div class="authentication-inner py-5">
    <div class="media align-items-center">
        <?php  if($iresult[0]->profile_picture!='' && $iresult[0]->profile_picture!='no file') {?>
        <img src="<?php  echo base_url().'uploads/profile/'.$iresult[0]->profile_picture;?>" alt="unlock-user" class="d-block ui-w-60 rounded-circle">
        <?php } else {?>
        <?php  if($iresult[0]->gender=='Male') { ?>
        <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
        <?php } else { ?>
        <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
        <?php } ?>
        <img src="<?php  echo $de_file;?>" alt="unlock-user" class="d-block ui-w-60 rounded-circle">
        <?php  } ?>
        <div class="media-body ml-3">
        <div class="text-light small font-weight-semibold line-height-1 mb-1"><?php echo $this->lang->line('xin_lock_user_logged_in_as');?></div>
        <div class="text-xlarge font-weight-bolder line-height-1"><?php echo $iresult[0]->first_name;?> <?php echo $iresult[0]->last_name;?></div>
      </div>
      </div>
    
    <!-- Form -->
    <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'class' => 'mt-4 form-hrsale', 'autocomplete' => 'off');?>
    <?php $hidden = array('_method' => 'forgott_pass');?>
    <?php echo form_open('admin/auth/unlock/', $attributes, $hidden);?>
    <p class="text-muted small"><?php echo $this->lang->line('xin_lock_user_session_timeout');?></p>
    <div class="input-group">
        <input type="password" class="form-control" name="ipassword" id="ipassword" placeholder="<?php echo $this->lang->line('xin_login_enter_password');?>">
        <div class="input-group-append"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-primary icon-btn save', 'content' => '<i class="ion ion-md-arrow-forward"></i> ')); ?> <img id="hrload-img" src="<?php echo base_url()?>skin/img/loading.gif" style=""> </div>
      </div>
    <?php echo form_close(); ?> 
    <!-- / Form -->
    
    <hr class="my-4">
    <div class="text-center text-muted small"> <?php echo $this->lang->line('xin_user_not_you');?> <a href="<?php echo site_url('admin/logout');?>"><?php echo $this->lang->line('xin_user_logged_different');?></a> </div>
  </div>
  </div>

<!-- / Content --> 

<!-- Core scripts --> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/popper/popper.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/bootstrap.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/js/sidenav.js"></script> 

<!-- Libs --> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script> 

<!-- Demo --> 
<script src="<?php echo base_url();?>skin/hrsale_vendor/assets/js/demo.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/toastr/toastr.min.js"></script> 
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
    var processing_request = '<?php echo $this->lang->line('xin_processing_request');?>';
    </script> 
<script type="text/javascript">
    $(document).ready(function(){
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        toastr.options.timeOut = 3000;
        toastr.options.positionClass = "toast-top-center";
        
        /* Add data */ /*Form Submit*/
        $("#xin-form").submit(function(e){
        e.preventDefault();
            $('#hrload-img').show();
            toastr.info(processing_request);
            var obj = $(this), action = obj.attr('name');
            $('.save').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: e.target.action,
                data: obj.serialize()+"&is_ajax=1&add_type=forgot_password&form="+action,
                cache: false,
                success: function (JSON) {
                    if (JSON.error != '') {
                        toastr.clear();
                        $('#hrload-img').hide();
                        toastr.error(JSON.error);
                        $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                        $('.save').prop('disabled', false);
                    } else {
                        toastr.clear();
                        $('#hrload-img').hide();
                        toastr.success(JSON.result);
                        $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                        window.location = site_url+'admin/dashboard?module=dashboard';
                        $('.save').prop('disabled', false);
                    }
                }
            });
        });
    });
    </script>
</body>
</html>