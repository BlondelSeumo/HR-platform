<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
<?php $session = $this->session->userdata('c_user_id'); ?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>

<!-- Basic Page Needs
================================================== -->
<meta charset="utf-8">
<title><?php echo $title;?></title>

<!-- Mobile Specific Metas
================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
<!-- CSS
================================================== -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/jobs/hrsale/css/style.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/jobs/hrsale/css/colors/green.css" id="colors">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale.css">
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>

<!-- Header
================================================== -->
<header class="sticky-header">
<div class="container">
	<div class="sixteen columns">

		<!-- Logo -->
		<div id="logo">
			<h1><a href="<?php echo site_url('');?>"><img src="<?php echo base_url();?>uploads/logo/job/<?php echo $system[0]->job_logo;?>" alt="<?php echo $title;?>" /></a></h1>
		</div>

		<!-- Menu -->
		<nav id="navigation" class="menu">
			<ul id="responsive">

				<li><a href="<?php echo site_url('');?>">Home</a><li>

				<li><a href="<?php echo site_url('jobs');?>">Search Jobs</a></li>
                <li><a href="<?php echo site_url('jobs/categories');?>">Browse Categories</a></li>
                <li><a href="<?php echo site_url('page/view/');?>xl9wkRy7tqOehBo6YCDjFG2JTucpKI4gMNsn8Zdf">About Us</a></li>
                <li><a href="<?php echo site_url('contact_us');?>">Contact Us</a></li>
                <?php if(!empty($session)){ ?>
                <li><a href="#"><i class="fa fa-user"></i> My Profile</a>
                <ul>
                    <li><a href="<?php echo site_url('employer/dashboard');?>">Dashboard</a></li>
                    <li><a href="<?php echo site_url('employer/account');?>">Account Settings</a></li>
                    <li><a href="<?php echo site_url('employer/post_job');?>">Post a Job</a></li>
                    <li><a href="<?php echo site_url('employer/manage_jobs');?>">Manage Jobs</a></li>
                    <li><a href="<?php echo site_url('employer/change_password');?>">Change Password</a></li>
                    <li><a href="<?php echo site_url('employer/logout');?>">Logout</a></li>
                </ul>
                </li>
                <?php }else {?>
                <li><a href="<?php echo site_url('employer/signup/');?>"><i class="fa fa-user"></i> Sign Up</a><li>
				<li><a href="<?php echo site_url('employer/sign_in/');?>"><i class="fa fa-lock"></i> Log In</a></li>
                <?php } ?>
			</ul>
			<ul class="responsive float-right">
				<li><a href="<?php echo site_url('employer/post_job');?>"><i class="ln ln-icon-Pencil"></i> POST A JOB</a></li>
			</ul>
		</nav>

		<!-- Navigation -->
		<div id="mobile-navigation">
			<a href="#menu" class="menu-trigger"><i class="fa fa-reorder"></i> Menu</a>
		</div>

	</div>
</div>
</header>
<div class="clearfix"></div>


<?php if($this->router->fetch_class()!='welcome' && $this->router->fetch_class()!='jobs') { ?>
<!-- Titlebar
================================================== -->
<?php
	if($this->router->fetch_class() == 'employer' && $this->router->fetch_method()=='post_job'){
		$adJb = 'single submit-page';
	} else {
		$adJb = 'single';
	}
?>
<div id="titlebar" class="single">
	<div class="container">

		<div class="ten columns">
			<h2><?php echo $title;?></h2>
			<nav id="breadcrumbs">
				<ul>
					<li>You are here:</li>
					<li><a href="<?php echo site_url('');?>">Home</a></li>
					<li><?php echo $title;?></li>
				</ul>
			</nav>
		</div>
        <?php if($this->router->fetch_class()=='employer' && $this->router->fetch_method()=='account') { ?>
        <div class="six columns">
			<a href="<?php echo site_url('employer/post_job');?>" class="button"><i class="fa fa-plus-circle"></i> Post a Job</a>
		</div>
		<?php } ?>
        <?php if($this->router->fetch_method()=='manage_jobs') { ?>
        <div class="six columns">
			<a href="<?php echo site_url('employer/post_job');?>" class="button"><i class="fa fa-plus-circle"></i> Post a Job</a>
		</div>
		<?php } ?>
        <?php if($this->router->fetch_method()=='post_job') { ?>
        <div class="six columns">
			<a href="<?php echo site_url('employer/manage_jobs');?>" class="button"><i class="fa fa-arrow-circle-right"></i> Manage Jobs</a>
		</div>
		<?php } ?>
        <?php if($this->router->fetch_method()=='edit_job') { ?>
        <div class="six columns">
			<a href="<?php echo site_url('employer/manage_jobs');?>" class="button"><i class="fa fa-arrow-circle-right"></i> Manage Jobs</a>
		</div>
		<?php } ?>
        <?php if($this->router->fetch_method()=='sign_in') { ?>
        <div class="six columns">
			<a href="<?php echo site_url('employer/signup');?>" class="button">Register, It’s Free!</a>
		</div>
        <?php } ?>
	</div>
</div>
<?php } ?>
<?php if($this->router->fetch_class()=='jobs' && $this->router->fetch_method()!='detail') { ?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="ten columns">
        	<?php if($this->router->fetch_method()=='categories') { ?>
			<h2>All Categories</h2>
            <?php } else {?>
            	<?php if($this->uri->segment(3)=='category') {?>
                <?php
				$csql = "SELECT * FROM xin_job_categories WHERE category_url = '".$this->uri->segment(4)."'";
				$cquery = $this->db->query($csql);
				$category_info = $cquery->result();
				?>
                <span>We found <?php echo $count_search_jobs;?> jobs matching:</span>
                <h2><?php echo ucwords(str_replace('-',' ',$category_info[0]->category_name));?></h2>
                <?php } else if($this->uri->segment(3)=='type') {
					$csql = "SELECT * FROM xin_job_type WHERE type_url = '".$this->uri->segment(4)."'";
					$cquery = $this->db->query($csql);
					$type_info = $cquery->result();
				?>
                <span>We found <?php echo $count_search_jobs;?> jobs matching:</span>
                <h2><?php echo ucwords(str_replace('-',' ',$type_info[0]->type));?></h2>
                <?php } else {?>
                	<?php if($this->input->get("search")) {?>
            		<h2>We found <?php echo $count_search_jobs;?> active jobs</h2>
                    <?php } else {?>
                    <h2>We found <?php echo $this->Job_post_model->all_active_jobs();?> active jobs</h2>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <div class="six columns">
                <a href="<?php echo site_url('employer/post_job');?>" class="button">Post a Job, It’s Free!</a>
            </div>
		</div>

	</div>
</div>
<?php } ?>
<!-- Container -->
<?php echo $subview;?>
<!-- Container / End -->

<!-- Footer
================================================== -->
<!--<div class="margin-top-20"></div>-->

<?php $this->load->view('frontend/hrsale/job_components/jfooter');?>
<!-- Back To Top Button -->
<!--<div id="backtotop"><a href="#"></a></div>

</div>-->
<!-- Wrapper / End -->
<?php $this->load->view('frontend/hrsale/job_components/html_jfooter');?>




</body>
</html>