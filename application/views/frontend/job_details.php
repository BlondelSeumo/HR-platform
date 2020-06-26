<?php $session = $this->session->userdata('username');?>
<?php $esession = $this->session->userdata('employee_id');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $job_title?></title>
<!-- Custom css -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/jobs/assets/css/app.css">
<!-- Favicon -->
<link rel="Shortcut Icon"  href="<?php echo $favicon;?>"  type="image/x-icon">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/respond.min.js"></script>
    <![endif]-->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.css">
</head>
<body>
<!-- Page loader start -->
<div class="page-loader"></div>
<!-- Page loader end --> 
<!-- Header start -->
<header class="main-header"> 
  <!-- Navbar start -->
  <nav class="navbar">
    <div class="container"> 
      <!-- Logo start --> 
      <a href="<?php echo site_url('frontend/jobs');?>" class="navbar-brand">
      <img src="<?php echo base_url();?>uploads/logo/job/<?php echo $system[0]->job_logo;?>"> </a> 
      <!-- Logo end -->
      <!-- Navs start -->
      <div class="navs"> 
      <ul class="nav navbar-nav account">
        <li><?php if(!empty($esession)):?>
          <a href="<?php echo site_url('hr/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
          <?php else:?>
          <a href="<?php echo site_url('admin/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
		  <?php endif;?></li>
      </ul>
        <!-- Main nav start -->
        <ul class="nav navbar-nav">
          <?php if(!empty($esession)):?>
          <li> <a href="<?php echo site_url('hr/dashboard');?>"><?php echo $this->lang->line('xin_my_dashboard');?></a> </li>
          <li> <a href="<?php echo site_url('hr/user/jobs_applied');?>"><?php echo $this->lang->line('left_jobs_applied');?></a> </li>
          <li> <a href="<?php echo site_url('frontend/jobs');?>"><?php echo $this->lang->line('xin_jobs_list');?></a> </li>
          <?php else:?>
          <li> <a href="<?php echo site_url('admin/dashboard');?>"><?php echo $this->lang->line('xin_my_dashboard');?></a> </li>
          <li> <a href="<?php echo site_url('frontend/jobs');?>"><?php echo $this->lang->line('xin_jobs_list');?></a> </li>
		  <?php endif;?>
        </ul>
        <!-- Main nav end --> 
      </div>
      <!-- Navs end --> 
      <!-- Responsive nav button start -->
      <ul class="nav navbar-nav responsive-btn">
        <li><a href="#"><i class="md-menu m-r-10"></i></a></li>
      </ul>
      <!-- Responsive nav button end --> 
    </div>
  </nav>
  <!-- Navbar end --> 
</header>
<!-- Header end -->
<?php $job_designation = $this->Designation_model->read_designation_information($designation_id);?>
<?php
		if(!is_null($job_designation)){
			$designation_name = $job_designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
    ?>
<?php $department = $this->Department_model->read_department_information($job_designation[0]->department_id);?>
<?php
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
    ?>
<section class="page-header lighten-4" style="background: url(<?php echo base_url();?>skin/vendor/jobs/assets/images/cover-1.jpg)">
  <div class="container">
    <h2><?php echo $job_title?></h2>
    <div class="row m-t-b-30">
      <div class="col-sm-12 col-lg-4 col-xl-2 col-sm-offset-4"> <a href="#" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target=".apply-job" data-job_id="<?php echo $job_id;?>"><?php echo $this->lang->line('xin_apply_for_this_job');?></a> </div>
    </div>
    <div><?php echo $designation_name;?> (<?php echo $department_name;?>)</div>
  </div>
</section>
<section class="bg-white">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="row simple">
          <li class="col-sm-2 col-xs-6">
            <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('xin_designation');?></h5>
            <span><?php echo $designation_name;?></span> </li>
          <li class="col-sm-2 col-xs-6">
            <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('xin_employee_gender');?></h5>
            <span>
            <?php if($gender=='0'):?>
            <?php echo $this->lang->line('xin_gender_male');?>
            <?php endif;?>
            <?php if($gender=='1'):?>
            <?php echo $this->lang->line('xin_gender_female');?>
            <?php endif;?>
            <?php if($gender=='2'):?>
            <?php echo $this->lang->line('xin_job_no_preference');?>
            <?php endif;?>
            </span> </li>
          <li class="col-sm-2 col-xs-6">
            <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('xin_experience');?></h5>
            <span>
            <?php if($minimum_experience=='0'):?>
            <?php echo $this->lang->line('xin_job_fresh');?>
            <?php endif;?>
            <?php if($minimum_experience=='1'):?>
            <?php echo $this->lang->line('xin_job_experience_define_1year');?>
            <?php endif;?>
            <?php if($minimum_experience=='2'):?>
            <?php echo $this->lang->line('xin_job_experience_define_2years');?>
            <?php endif;?>
            <?php if($minimum_experience=='3'):?>
            <?php echo $this->lang->line('xin_job_experience_define_3years');?>
            <?php endif;?>
            <?php if($minimum_experience=='4'):?>
            <?php echo $this->lang->line('xin_job_experience_define_4years');?>
            <?php endif;?>
            <?php if($minimum_experience=='5'):?>
            <?php echo $this->lang->line('xin_job_experience_define_5years');?>
            <?php endif;?>
            <?php if($minimum_experience=='6'):?>
            <?php echo $this->lang->line('xin_job_experience_define_6years');?>
            <?php endif;?>
            <?php if($minimum_experience=='7'):?>
            <?php echo $this->lang->line('xin_job_experience_define_7years');?>
            <?php endif;?>
            <?php if($minimum_experience=='8'):?>
            <?php echo $this->lang->line('xin_job_experience_define_8years');?>
            <?php endif;?>
            <?php if($minimum_experience=='9'):?>
            <?php echo $this->lang->line('xin_job_experience_define_9years');?>
            <?php endif;?>
            <?php if($minimum_experience=='10'):?>
            <?php echo $this->lang->line('xin_job_experience_define_10years');?>
            <?php endif;?>
            <?php if($minimum_experience=='11'):?>
            <?php echo $this->lang->line('xin_job_experience_define_plus_10years');?>
            <?php endif;?>
            </span> </li>
          <li class="col-sm-2 col-xs-6">
            <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('xin_vacancy');?></h5>
            <span><?php echo $job_vacancy;?></span> </li>
          <li class="col-sm-2 col-xs-6">
            <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('xin_apply_before');?></h5>
            <span><?php echo date('M d, Y', strtotime($date_of_closing));?></span> </li>
          <li class="col-sm-2 col-xs-6">
            <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('xin_posted_date');?></h5>
            <span><?php echo date('M d, Y', strtotime($created_at));?></span> </li>
        </ul>
        <hr class="sm">
        <article>
          <div class="content-row"> <?php echo htmlspecialchars_decode($long_description);?> </div>
        </article>
      </div>
    </div>
  </div>
</section>
<!-- Footer start -->
<div class="modal fade apply-job" id="apply-job" tabindex="-1" role="dialog" aria-labelledby="apply-job" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal"></div>
  </div>
</div>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <p>
          <?php if($system[0]->enable_current_year=='yes'):?>
          <?php echo date('Y');?>
          <?php endif;?>
          © <?php echo $system[0]->footer_text;?></p>
      </div>
    </div>
  </div>
</footer>
<!-- Footer end --> 
<!-- ================= Script files ================= --> 
<!-- Jquery --> 
<!--<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/jquery/jquery-1.12.3.min.js"></script> --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/jquery/jquery.min.js"></script> 
<!-- Jquery ui --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/jquery/jquery-ui.min.js"></script> 
<!-- Bootstrap --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/bootstrap/bootstrap.min.js"></script> 
<!-- Bootstrap slider --> 
<!--<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/bootstrap-slider/bootstrap-slider.min.js"></script> -->
<!-- Waves effect --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/waves/waves.min.js"></script> 
<!-- Scroll animate effect --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/scroll.js"></script> 
<!-- Owl carousel --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/owl-carousel/owl.carousel.min.js"></script> 
<!-- Summernote editor --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/summernote/summernote.min.js"></script> 
<!-- Typed.js --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/typed.min.js"></script> 
<!-- Custom --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/app.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = true;
	toastr.options.progressBar = false;
	toastr.options.timeOut = 3000;
	toastr.options.positionClass = "toast-bottom-right";
			
	$("#apply_job").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 6);
		fd.append("type", 'apply_job');
		fd.append("data", 'apply_job');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.apply-form').fadeOut('slow');
					$('#apply_job')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} 	        
	   });
	});
	
	// get data
	$('.apply-job').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var job_id = button.data('job_id');
		var modal = $(this);
	$.ajax({
		url : "<?php echo site_url("frontend/jobs/apply") ?>",
		type: "GET",
		data: 'jd=1&is_ajax=app_job&mode=modal&data=apply_job&type=apply_job&job_id='+job_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
	});
	});
}); // jquery loaded
</script>
</body>
</html>