<?php $session = $this->session->userdata('c_user_id'); ?>
<?php $job_url = $this->uri->segment(3);?>
<?php $result = $this->Job_post_model->read_job_infor_by_url($job_url);?>
<?php
if(is_null($result)){
	redirect('employer/manage_jobs');
}
?>
<div class="container">
	<!-- Table -->
	<div class="sixteen columns">

		<p class="margin-bottom-25" style="float: left;">The job applications for <strong><a href="<?php echo site_url('jobs/detail/').$result[0]->job_url;?>"><?php echo $result[0]->job_title?></a></strong> are listed below.</p>
	</div>
	<!-- Applications -->
	<div class="sixteen columns">
		
		<?php $candidates = $this->Recruitment_model->get_candidates_jobs_applied($job_url);?>
        <?php foreach($candidates->result() as $r) {?>
        <?php $created_at = $this->Xin_model->set_date_format($r->created_at);?>
        <?php
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '--';	
		}
		?>
		<div class="application">
			<div class="app-content">
				<!-- Name / -->
				<div class="info">
					<span><?php echo $r->full_name;?></span>
					<ul>
						<li><a href="<?php echo site_url('download/')?>?type=resume&filename=<?php echo $r->job_resume;?>"><i class="fa fa-file-text"></i> Download CV</a></li>
					</ul>
				</div>
				
				<!-- Buttons -->
				<div class="buttons">
					<a href="#three-1" class="button gray app-link"><i class="fa fa-plus-circle"></i> Show Details</a>
				</div>
				<div class="clearfix"></div>

			</div>

			<!--  Hidden Tabs -->
			<div class="app-tabs">

				<a href="#" class="close-tab button gray"><i class="fa fa-close"></i></a>
			    <!-- Third Tab -->
			    <div class="app-tab-content"  id="three-1">
					<i>Full Name:</i>
					<span><?php echo $r->full_name;?></span>

					<i>Email:</i>
					<span><?php echo $r->email;?></span>

					<i>Message:</i>
					<span><?php echo $r->message;?> </span>
			    </div>

			</div>

			<!-- Footer -->
			<div class="app-footer">
				<ul>
					<li><i class="fa fa-file-text-o"></i> New</li>
					<li><i class="fa fa-calendar"></i> <?php echo $created_at;?></li>
				</ul>
				<div class="clearfix"></div>

			</div>
		</div>
        <?php } ?>
	</div>
</div>
<div class="margin-top-60"></div>