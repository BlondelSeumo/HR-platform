<div class="container">
	<!-- Recent Jobs -->
	<div class="eleven columns">
	<div class="padding-right">

		<div class="listings-container">
			<?php foreach($results as $job) {?>
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
		<div class="clearfix"></div>

		<div class="pagination-container">
			<nav class="pagination">
				<!--<ul>-->
					<?php foreach ($links as $link) { ?>
                    <?php echo $link;?>
                    <?php } ?>
				<!--</ul>-->
			</nav>
		</div>

	</div>
	</div>


	<!-- Widgets -->
    <div class="five columns">        
        <!-- Category -->
		<div class="widget">
			<h4>Category</h4>

            <ul class="footer-links search-categories">
				<?php foreach($all_job_categories as $category):?>
                <?php $count_cjobs = $this->Recruitment_model->job_category_record_count($category->category_url);?>
                <?php if($count_cjobs > 0){?>
                <li><a href="<?php echo site_url('jobs/search/category/').$category->category_url;?>"><?php echo $category->category_name;?> (<?php echo $this->Recruitment_model->job_category_record_count($category->category_url);?>)</a></li>
                <?php } ?>
				<?php endforeach;?>
			</ul>

		</div>
        <!-- Job Type -->
		<div class="widget">
			<h4>Job Type</h4>

			<ul class="footer-links">
				<?php foreach($all_job_types->result() as $job_type):?>
                <?php $count_jobs = $this->Recruitment_model->job_type_record_count($job_type->type_url);?>
                <?php if($count_jobs > 0){?>
                <li><a href="<?php echo site_url('jobs/search/type/').$job_type->type_url;?>"><?php echo $job_type->type;?> (<?php echo $this->Recruitment_model->job_type_record_count($job_type->type_url);?>)</a></li>
                <?php } ?>
				<?php endforeach;?>
			</ul>

		</div>

	</div>
	
	<!-- Widgets / End -->


</div>
<div class="margin-top-50"></div>
<?php $this->load->view('frontend/hrsale/footer-block');?>