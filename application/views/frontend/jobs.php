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
<title><?php echo $title;?></title>
<!-- Custom css -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/jobs/assets/css/app.css">
<!-- Favicon -->
<link rel="Shortcut Icon"  href="<?php echo $favicon;?>"  type="image/x-icon">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
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
      <img src="<?php echo base_url();?>uploads/logo/job/<?php echo $system[0]->job_logo;?>"></a> 
      <!-- Logo end --> 
      <!-- Navs start -->
      <div class="navs">
        <ul class="nav navbar-nav account">
          <li>
          <?php if(!empty($esession)):?>
          <a href="<?php echo site_url('hr/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
          <?php else:?>
          <a href="<?php echo site_url('admin/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
		  <?php endif;?>
          </li>
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
<section class="page-header lighten-4" style="background: url(<?php echo base_url();?>skin/vendor/jobs/assets/images/cover-2.jpg)">
  <div class="container">
    <h1> <span data-plugin="typed-js" data-plugin-string='["find the job you love","start now"]'></span> </h1>
  </div>
</section>
<section>
  <div class="container">
    <header class="section-header">
      <h3><?php echo $this->lang->line('xin_available_jobs');?> <small>(
        <?php $jobs = $this->Job_post_model->get_jobs(); echo $jobs->num_rows()?>
        )</small></h3>
      <p><?php echo $this->lang->line('xin_newly_created_jobs');?></p>
    </header>
    <div class="card">
      <div class="card-body">
        <?php foreach($all_jobs as $job) {?>
        <?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
        <?php
                    if(!is_null($jtype)){
                        $jt_type = $jtype[0]->type;
                    } else {
                        $jt_type = '--';	
                    }
                  ?>
        <?php $job_designation = $this->Designation_model->read_designation_information($job->designation_id);?>
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
        <div class="item-jobpost">
          <div class="row">
            <div class="col-md-5">
              <h5> <a href="<?php echo site_url();?>frontend/jobs/detail/<?php echo $job->job_id;?>/"> <?php echo $job->job_title;?></a> </h5>
              <ul class="list-inline">
                <li><?php echo date("j", strtotime($job->created_at));?> <span><?php echo date("M", strtotime($job->created_at));?></span></li>
                <li>
                  <label class="label bg-green lighten-1"><?php echo $jt_type;?></label>
                </li>
              </ul>
            </div>
            <div class="col-md-5 jobpost-location"> <span><?php echo $designation_name;?> > <?php echo $department_name;?></span> </div>
            <div class="col-md-2 jobpost-apply-btn"> <a href="<?php echo site_url();?>frontend/jobs/detail/<?php echo $job->job_id;?>/" class="btn btn-primary btn-block btn-outline btn-sm"><?php echo $this->lang->line('xin_apply_for_this_job');?> <i class="md-long-arrow-right m-l-10"></i></a> </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<!-- Footer start -->
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
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/jquery/jquery.min.js"></script> 
<!-- Jquery ui --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/jquery/jquery-ui.min.js"></script> 
<!-- Bootstrap --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/bootstrap/bootstrap.min.js"></script> 
<!-- Bootstrap slider --> 
<script src="<?php echo base_url();?>skin/vendor/jobs/assets/js/bootstrap-slider/bootstrap-slider.min.js"></script> 
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
</body>
</html>