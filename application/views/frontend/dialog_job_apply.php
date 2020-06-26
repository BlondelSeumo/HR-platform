<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['job_id']) && $_GET['data']=='apply_job'){
$session = $this->session->userdata('username');
$user = $this->Xin_model->read_user_info($session['user_id']);
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_job_application_for');?> <?php echo $job_title;?></h4>
</div>
<?php $attributes = array('name' => 'apply_job', 'id' => 'apply_job', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'Apply', 'job_id' => $job_id, 'user_id' => $session['user_id']);?>
<?php echo form_open_multipart('frontend/jobs/apply_job/'.$job_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('xin_employee_id');?></label>
              <input type="text" readonly="readonly" class="form-control" value="<?php echo $user[0]->employee_id;?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="email"><?php echo $this->lang->line('dashboard_fullname');?></label>
              <input type="text" readonly="readonly" class="form-control" value="<?php echo $user[0]->first_name. ' ' .$user[0]->last_name;?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="contact"><?php echo $this->lang->line('dashboard_email');?></label>
              <input type="text" readonly="readonly" class="form-control" value="<?php echo $user[0]->email;?>">
            </div>
          </div>
        </div>
        <?php $system_setting = $this->Xin_model->read_setting_info(1);?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="resume"><?php echo $this->lang->line('xin_upload_resume_from_pc');?></label>
              <span class="btn btn-primary btn-file"> <?php echo $this->lang->line('xin_browse');?>
              <input type="file" name="resume" id="resume">
              </span>
              <?php if($system_setting[0]->job_application_format!=''){?>
              <br>
              <small><?php echo $this->lang->line('xin_upload_file_only_for_resume');?>: <?php echo $system_setting[0]->job_application_format;?></small>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="message"><?php echo $this->lang->line('xin_your_covering_message_for');?> <?php echo $job_title;?></label>
              <textarea class="form-control" name="message" id="message" rows="5"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_apply');?></button>
  </div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){		

		/* Edit data */
		$("#apply_job").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 6);
		fd.append("add_type", 'apply_job');
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
					$('.apply-job').modal('toggle');
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
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
	});	
  </script>
<?php }
?>
