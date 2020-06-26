<?php
$session = $this->session->userdata('c_user_id');
$job_category = $this->Recruitment_model->read_category_info($category_id);?>
<?php
	if(!is_null($job_category)){
		$category_name = $job_category[0]->category_name;
	} else {
		$category_name = '--';	
	}
  ?>
<?php $jtype = $this->Job_post_model->read_job_type_information($job_type_id); ?>
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
<?php $time_ago = $this->Recruitment_model->timeAgo($created_at);?>  
  <!-- Titlebar
================================================== -->
<div id="titlebar" class="photo-bg" style="background: url(<?php echo base_url();?>skin/jobs/hrsale/images/all-categories-photo.jpg)">
	<div class="container">
		<div class="ten columns">
			<span style="color:#fff;"><?php echo $category_name;?></span>
			<h2><?php echo $job_title;?> <span class="<?php echo $clS;?>"><?php echo $jt_type;?></span></h2>
		</div>

	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	
	<!-- Recent Jobs -->
	<div class="eleven columns">
	<div class="padding-right">
		
		<!-- Company Info -->
		<div class="company-info">
			<div class="content">
				<h5><?php echo htmlspecialchars_decode($short_description);?></h5>
                <span><a href="#"><i class="ln ln-icon-Clock-Back"></i> <?php echo $time_ago?></a></span>
                <span><a href="#"><i class="ln ln-icon-Male"></i> <?php if($gender=='0'):?>
				<?php echo $this->lang->line('xin_gender_male');?>
                <?php endif;?>
                <?php if($gender=='1'):?>
                <?php echo $this->lang->line('xin_gender_female');?>
                <?php endif;?>
                <?php if($gender=='2'):?>
                <?php echo $this->lang->line('xin_job_no_preference');?>
                <?php endif;?></a></span>
			</div>
			<div class="clearfix"></div>
		</div>

		<?php echo htmlspecialchars_decode($long_description);?>
	</div>
	</div>


	<!-- Widgets -->
	<div class="five columns">

		<!-- Sort by -->
		<div class="widget">
			<h4>Overview</h4>

			<div class="job-overview">
				
				<ul>
					<li>
						<i class="ln ln-icon-ID-3"></i>
						<div>
							<strong>Job Title:</strong>
							<span><?php echo $job_title?></span>
						</div>
					</li>
                    <li>
						<i class="ln ln-icon-Professor"></i>
						<div>
							<strong>Experience:</strong>
							<span><?php if($minimum_experience=='0'):?>
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
                            <?php endif;?></span>
						</div>
					</li>
                    <li>
						<i class="ln ln-icon-Blackboard"></i>
						<div>
							<strong>Vacancy:</strong>
							<span><?php echo $job_vacancy;?></span>
						</div>
					</li>
					<li>
						<i class="ln ln-icon-Calendar"></i>
						<div>
							<strong>Posted Date:</strong>
							<span><?php echo $this->Xin_model->set_date_format($created_at);?></span>
						</div>
					</li>
					<li>
						<i class="ln ln-icon-Calendar-4"></i>
						<div>
							<strong>Apply Before:</strong>
							<span><?php echo $this->Xin_model->set_date_format($date_of_closing);?></span>
						</div>
					</li>
				</ul>
                <a href="#small-dialog" class="popup-with-zoom-anim button">Apply For This Job</a>
                
				<div id="small-dialog" class="zoom-anim-dialog mfp-hide apply-popup">
					<div class="small-dialog-headline">
						<h2>Apply For This Job</h2>
					</div>

					<div class="small-dialog-content">
                        <?php $attributes = array('name' => 'apply_job', 'id' => 'apply', 'class' => 'login', 'autocomplete' => 'on');?>
						<?php $hidden = array('apply_job' => '1');?>
                        <?php echo form_open('jobs/apply_job/1', $attributes, $hidden);?>
							<input type="text" placeholder="Full Name" name="full_name" value=""/>
							<input type="text" placeholder="Email Address" name="email" value=""/>
							<textarea placeholder="Your message / cover letter" name="message"  id="cover_letter"></textarea>
                            <input type="hidden" name="job_id" value="<?php echo $job_id;?>">
                            <input type="hidden" name="user_id" value="0">

							<!-- Upload CV -->
							<div class="upload-info"><strong>Upload your CV (optional)</strong> <span>Max. file size: 5MB</span></div>
							<div class="clearfix"></div>

							<label class="upload-btn">
							    <input type="file" id="resume" name="resume" />
							    <i class="fa fa-upload"></i> Browse
							</label>
							<div class="divider"></div>

							<button type="submit" class="send">Send Application</button>
						</form> 
					</div>
					
				</div>
			</div>

		</div>

	</div>
	<!-- Widgets / End -->
</div>
<div class="margin-top-50"></div>
<?php $this->load->view('frontend/hrsale/footer-block');?>