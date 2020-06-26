<?php $session = $this->session->userdata('c_user_id');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<div class="fullwidthbanner-container">
	<div class="fullwidthbanner">
		<ul>
			<li data-fstransition="fade" data-transition="fade" data-slotamount="10" data-masterspeed="300">
				<img src="<?php echo base_url();?>skin/jobs/hrsale/images/banner-02.jpg" alt="">

				<div class="caption title sfb" data-x="center" data-y="195" data-speed="400" data-start="800"  data-easing="easeOutExpo">
					<h2>Hire great hourly employees</h2>
				</div>

				<div class="caption text align-center sfb" data-x="center" data-y="270" data-speed="400" data-start="1200" data-easing="easeOutExpo">
					<p><?php echo $company[0]->company_name;?> is most trusted job board, connecting the world's <br> brightest minds with resume database loaded with talents.</p>
				</div>

				<div class="caption sfb" data-x="center" data-y="400" data-speed="400" data-start="1600" data-easing="easeOutExpo">
					<a href="<?php echo site_url('employer/post_job');?>" class="slider-button">Post a Job</a>
				</div>
			</li>
		</ul>
	</div>
</div>
<!-- Icon Boxes -->
<div class="section-background top-0">
	<div class="container">

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Folder-Add"></i>
				<h4>Post Job</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Search-onCloud"></i>
				<h4>Search Resumes</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Business-ManWoman"></i>
				<h4>Hire Candidates</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

	</div>
</div>
<div class="container">
	
	<!-- Recent Jobs -->
	<div class="eleven columns">
	<div class="padding-right">
		<h3 class="margin-bottom-25">Recent Jobs</h3>
		<div class="listings-container">
			<?php foreach($all_jobs as $job) {?>
			<?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
            <?php $employer = $this->Recruitment_model->read_employer_info($job->employer_id);?>
            <?php
				if(!is_null($employer)){
					$employer_logo = $employer[0]->company_logo;
				} else {
					$employer_logo = '';
				}
				if(!is_null($jtype)){
					$jt_type = $jtype[0]->type;
					if($jt_type == 'Freelance'):
						$clS = 'freelance';
					elseif($jt_type == 'Internship'):
						$clS = 'internship';
					elseif($jt_type == 'Part Time'):
						$clS = 'part-time';
					elseif($jt_type == 'Full Time'):
						$clS = 'full-time';
					else:		
						$clS = 'full-time';		
					endif;
				} else {
					$jt_type = '--';	
					$clS = 'full-time';	
				}
			  ?>
            <?php
				if($job->is_featured==1):
					$fCls = 'featured';
				else:
					$fCls = '';
				endif;
			?>  
			<!-- Listing -->
            <?php $time_ago = $this->Recruitment_model->timeAgo($job->created_at);?>
            <!-- Listing -->
			<a href="<?php echo site_url('jobs/detail/').$job->job_url;?>" class="listing <?php echo $clS;?> <?php echo $fCls;?>">
				<div class="listing-logo">
					<img src="<?php echo base_url().'uploads/employers/'.$employer_logo;?>" alt="">
				</div>
                <div class="listing-title">
					<h4><?php echo $job->job_title;?> <span class="listing-type"><?php echo $jt_type;?></span></h4>
					<ul class="listing-icons">
						<li><i class="ln ln-icon-Male"></i> <?php if($job->gender=='0'):?>
						<?php echo $this->lang->line('xin_gender_male');?>
                        <?php endif;?>
                        <?php if($job->gender=='1'):?>
                        <?php echo $this->lang->line('xin_gender_female');?>
                        <?php endif;?>
                        <?php if($job->gender=='2'):?>
                        <?php echo $this->lang->line('xin_job_no_preference');?>
                        <?php endif;?></li>
						<li><i class="ln ln-icon-Professor"></i> <?php if($job->minimum_experience=='0'):?>
						<?php echo $this->lang->line('xin_job_fresh');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='1'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_1year');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='2'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_2years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='3'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_3years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='4'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_4years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='5'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_5years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='6'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_6years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='7'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_7years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='8'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_8years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='9'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_9years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='10'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_10years');?>
                        <?php endif;?>
                        <?php if($job->minimum_experience=='11'):?>
                        <?php echo $this->lang->line('xin_job_experience_define_plus_10years');?>
                        <?php endif;?></li>
                        <li><div class="listing-date"><?php echo $time_ago?></div></li>
					</ul>
				</div>
			</a>
			<?php } ?> 
		</div>

		<a href="<?php echo site_url('jobs');?>" class="button centered"><i class="fa fa-plus-circle"></i> Show More Jobs</a>
		<div class="margin-bottom-55"></div>
	</div>
	</div>

	<!-- Job Spotlight -->
	<div class="five columns">
		<h3 class="margin-bottom-5">Featured Jobs</h3>

		<!-- Navigation -->
		<div class="showbiz-navigation">
			<div id="showbiz_left_1" class="sb-navigation-left"><i class="fa fa-angle-left"></i></div>
			<div id="showbiz_right_1" class="sb-navigation-right"><i class="fa fa-angle-right"></i></div>
		</div>
		<div class="clearfix"></div>
		
		<!-- Showbiz Container -->
		<div id="job-spotlight" class="showbiz-container">
			<div class="showbiz" data-left="#showbiz_left_1" data-right="#showbiz_right_1" data-play="#showbiz_play_1" >
				<div class="overflowholder">

					<ul>

						<?php foreach($all_featured_jobs as $job) {?>
						<?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
                        <?php
                            if(!is_null($jtype)){
                                $jt_type = $jtype[0]->type;
                                if($jt_type == 'Freelance'):
                                    $clS = 'freelance';
                                elseif($jt_type == 'Internship'):
                                    $clS = 'internship';
                                elseif($jt_type == 'Part Time'):
                                    $clS = 'part-time';
                                elseif($jt_type == 'Full Time'):
                                    $clS = 'full-time';
                                else:		
                                    $clS = 'full-time';		
                                endif;
                            } else {
                                $jt_type = '--';	
                            }
                          ?>
                        <?php
                            if($job->is_featured==1):
                                $fCls = 'featured';
                            else:
                                $fCls = '';
                            endif;
                        ?>  
                        <!-- Listing -->
                        <?php $time_ago = $this->Recruitment_model->timeAgo($job->created_at);?>
                        <li>
							<div class="job-spotlight">
								<a href="<?php echo site_url('jobs/detail/').$job->job_url;?>"><h4><?php echo $job->job_title;?> <span class="<?php echo $clS;?>"><?php echo $jt_type;?></span></h4></a>
								<span><i class="ln ln-icon-Clock-Back"></i> <?php echo $time_ago?></span>
								<p><?php echo htmlspecialchars_decode($job->short_description);?></p>
								<a href="<?php echo site_url('jobs/detail/').$job->job_url;?>" class="button">Apply For This Job</a>
							</div>
						</li>
                       <?php } ?> 
					</ul>
					<div class="clearfix"></div>

				</div>
				<div class="clearfix"></div>
			</div>
		</div>

	</div>
</div>
<?php $this->load->view('frontend/hrsale/testimonials-block');?>
<?php $this->load->view('frontend/hrsale/footer-block');?>