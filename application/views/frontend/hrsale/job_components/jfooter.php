<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<div class="margin-top-0"></div>
<div id="footer">
	<!-- Main -->
	<div class="container">

		<div class="seven columns">
			<h4>About</h4>
			<p>Morbi convallis bibendum urna ut viverra. Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper.</p>
            <?php $session = $this->session->userdata('c_user_id');?>
            <?php if(!$session):?>
            <a class="button" href="<?php echo site_url('employer/signup');?>">Get Started</a>
            <?php else:?>
            <a class="button" href="<?php echo site_url('employer/post_job');?>">Post a Job</a>
            <?php endif;?>
		</div>

		<div class="three columns">
			<h4>Company</h4>
			<ul class="footer-links">
				<li><a href="<?php echo site_url('page/view/');?>xl9wkRy7tqOehBo6YCDjFG2JTucpKI4gMNsn8Zdf">About Us</a></li>
				<li><a href="<?php echo site_url('page/view/');?>5uk4EUc3V9FYTbBQz7PWgKM6qCajfAipvhOJnZHl">Communications</a></li>
				<li><a href="<?php echo site_url('page/view/');?>5r6OCsUoHQFiRwI17W0eT38jbvpxEGuLhzgmt9lZ">Lending Licenses</a></li>
				<li><a href="<?php echo site_url('page/view/');?>QrfbMOUWpdYNxjLFz8G1m6t3wi0X2RKEZVC9ySka">Terms of Service</a></li>
				<li><a href="<?php echo site_url('page/view/');?>rjHKhmsNezT2OJBAoQq0yU1tL5F34MCwgIiZEc7x">Privacy Policy</a></li>
			</ul>
		</div>
		
		<div class="three columns">
			<h4>&nbsp;</h4>
			<ul class="footer-links">
				<li><a href="<?php echo site_url('page/view/');?>gZbBVMxnfzYLlC2AOk609Q7yWpaSjmJHuRXosr58">Support</a></li>
				<li><a href="<?php echo site_url('page/view/');?>l1BbMd6H2D3rkFnjU9LgCH2D3rkFnjU9BbMd6H2D3r">How It Works</a></li>
				<li><a href="<?php echo site_url('page/view/');?>CTbzS9IrWkNU7VM3HGZYjp6iwmfyXDOQgtsP8FEc">Disclaimers</a></li>
				<li><a href="<?php echo site_url('page/view/');?>">Testimonials</a></li>
			</ul>
		</div>		

		<div class="three columns">
			<h4>Jobs by Type</h4>
			<ul class="footer-links">
               <?php $iall_job_types = $this->Xin_model->get_job_type()?>
				<?php foreach($iall_job_types->result() as $job_type):?>
                <?php $count_jobs = $this->Recruitment_model->job_type_record_count($job_type->type_url);?>
                <?php if($count_jobs > 0){?>
                <li><a href="<?php echo site_url('jobs/search/type/').$job_type->type_url;?>"><?php echo $job_type->type;?> (<?php echo $this->Recruitment_model->job_type_record_count($job_type->type_url);?>)</a></li>
                <?php } ?>
				<?php endforeach;?>

			</ul>
		</div>

	</div>

	<!-- Bottom -->
	<div class="container">
		<div class="footer-bottom">
			<div class="sixteen columns">
				<h4>Follow Us</h4>
				<ul class="social-icons">
					<li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
					<li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
					<li><a class="gplus" href="#"><i class="icon-gplus"></i></a></li>
					<li><a class="linkedin" href="#"><i class="icon-linkedin"></i></a></li>
				</ul>
				<div class="copyrights">©  Copyright <?php echo date('Y');?> by <?php echo $company[0]->company_name;?>. All Rights Reserved.</div>
			</div>
		</div>
	</div>

</div>
<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>