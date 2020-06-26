<?php 
$session = $this->session->userdata('c_user_id');
$iuser = $this->Xin_model->read_user_info($session['c_user_id']);?>
<div class="container">
	
	<!-- Table -->
	<div class="sixteen columns">

		<p class="margin-bottom-25">Your applied jobs listings are shown in the table below.</p>

		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> Title</th>
				<th><i class="fa fa-check-square-o"></i> Job Type</th>
				<th><i class="fa fa-calendar"></i> Date Applied</th>
				<th><i class="fa fa-calendar"></i> Date Expires</th>
				<th><i class="fa fa-user"></i> Resume</th>
				<th></th>
			</tr>
         <?php $my_jobs = $this->Job_post_model->get_user_jobs_applied($session['c_user_id']);?>   
		<?php foreach($my_jobs->result() as $jobs):?>
        <?php $result = $this->Job_post_model->read_job_information($jobs->job_id);?>
        <?php $jtype = $this->Job_post_model->read_job_type_information($result[0]->job_type); ?>
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
			<!-- Item #1 -->
			<tr>
				<td class="title"><a href="<?php echo site_url('jobs/detail/').$jobs->job_url;?>" target="_blank"><?php echo $result[0]->job_title;?></a></td>
				<td class="centered"><?php echo $jt_type;?></td>
				<td><?php echo $this->Xin_model->set_date_format($jobs->created_at);?></td>
				<td><?php echo $this->Xin_model->set_date_format($result[0]->date_of_closing);?></td>
				<td class="action">
					<a href="<?php echo site_url('download').'?type=resume&filename='.$jobs->job_resume;?>" class="delete"><i class="ln ln-icon-File-Download"></i> Download</a>
				</td>
                <td>&nbsp;</td>
			</tr>
          <?php endforeach;?>  
		</table>

	</div>

</div>


