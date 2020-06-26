<?php $session = $this->session->userdata('c_user_id'); ?>
<?php $jobs = $this->Job_post_model->get_employer_jobs($session['c_user_id']);?>

<!--<div class="container">
  <p class="margin-bottom-25">Your listings are shown in the table below.</p>
  <table id="xin_table" class="display hover manage-table responsive-table" style="width:100%">
    <thead>
      <tr>
        <th width="80">Action</th>
        <th>Title</th>
        <th>Category</th>
        <th>Job Type</th>
        <th>Vacancies</th>
        <th>Closing Date</th>
      </tr>
    </thead>
  </table>
</div>-->
<div class="container">
	<!-- Table -->
	<div class="sixteen columns">

		<p class="margin-bottom-25">Your listings are shown in the table below.</p>

		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> Title</th>
				<th><i class="fa fa-check-square-o"></i> Category</th>
				<th><i class="fa fa-life-bouy"></i> Job Type</th>
				<th><i class="fa fa-calendar"></i> Date Posted</th>
				<th><i class="fa fa-user"></i> Applications</th>
				<th></th>
			</tr>
					
			<?php foreach($jobs->result() as $r) { ?>
            <?php
			// get job designation
			$category = $this->Job_post_model->read_job_category_info($r->category_id);
			if(!is_null($category)){
				$category_name = $category[0]->category_name;
			} else {
				$category_name = '-';
			}
			// get job type
			$job_type = $this->Job_post_model->read_job_type_information($r->job_type);
			if(!is_null($job_type)){
				$jtype = $job_type[0]->type;
			} else {
				$jtype = '-';
			}
			// get date
			$date_of_closing = $this->Xin_model->set_date_format($r->date_of_closing);
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			/* get job status*/
			if($r->status==1): $status = $this->lang->line('xin_published'); elseif($r->status==2): $status = $this->lang->line('xin_unpublished'); endif;
			$employer = $this->Recruitment_model->read_employer_info($r->employer_id);
			if(!is_null($employer)){
				$employer_name = $employer[0]->company_name;
			} else {
				$employer_name = '-';	
			}
			?>
			<tr>
				<td class="title"><a href="<?php echo site_url('jobs/detail/').$r->job_url;?>"><?php echo $r->job_title;?> <span class="pending">(<?php echo $status;?>)</span></a></td>
				<td class="centered"><?php echo $category_name;?></td>
				<td><?php echo $jtype;?></td>
				<td><?php echo $created_at;?></td>
				<td class="centered">
                <?php $chk_job = $this->Recruitment_model->check_jobs_applications($r->job_id);?>
                <?php if($chk_job > 0):?>
                <a href="<?php echo site_url('employer/manage_applications/').$r->job_url;?>" class="button">Show (<?php echo $chk_job;?>)</a>
                <?php else:?>-
                <?php endif;?>
                </td>
				<td class="action">
					<a href="<?php echo site_url('employer/edit_job/').$r->job_url;?>"><i class="fa fa-pencil"></i> Edit</a>
                    <a href="#" class="delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?php echo $r->job_id;?>"><i class="fa fa-remove"></i> Delete</a>
				</td>
			</tr>
			<?php  } ?>
		</table>

		<br>
		<a href="<?php echo site_url('employer/post_job');?>" class="button">Add a Job</a>

	</div>

</div>
<div class="margin-top-60"></div>
