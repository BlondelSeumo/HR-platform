<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $result = $this->Timesheet_model->read_task_information($task_id);?>
<?php if($result[0]->assigned_to!='') { $assigned_to = explode(',',$result[0]->assigned_to);?>

<ul class="list-group list-group-flush">
  <?php foreach($assigned_to as $assign_id) {?>
  <?php $e_name = $this->Xin_model->read_user_info($assign_id);?>
  <?php if(!is_null($e_name)){ ?>
  <?php $_designation = $this->Designation_model->read_designation_information($e_name[0]->designation_id);?>
  <?php
	  if(!is_null($_designation)){
		$designation_name = $_designation[0]->designation_name;
	  } else {
		$designation_name = '--';	
	  }
	  ?>
  <?php
    if($e_name[0]->profile_picture!='' && $e_name[0]->profile_picture!='no file') {
        $u_file = base_url().'uploads/profile/'.$e_name[0]->profile_picture;
    } else {
        if($e_name[0]->gender=='Male') { 
            $u_file = base_url().'uploads/profile/default_male.jpg';
        } else {
            $u_file = base_url().'uploads/profile/default_female.jpg';
        }
    } ?>
  <div class="il-item">
    <li class="list-group-item" style="border:0px;">
      <div class="media align-items-center"> <img src="<?php echo $u_file;?>" class="d-block ui-w-30 rounded-circle" alt="">
        <div class="media-body px-2">
          <?php if($user[0]->user_role_id==1):?>
          <a href="<?php echo site_url()?>admin/employees/detail/<?php echo $e_name[0]->user_id;?>" class="text-dark">
          <?php endif;?>
          <?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?>
          <?php if($user[0]->user_role_id==1):?>
          </a>
          <?php endif;?>
          <br>
          <p class="font-small-2 mb-0 text-muted"><?php echo $designation_name;?></p>
        </div>
      </div>
    </li>
  </div>
  <?php } } ?>
  <?php } else { ?>
  <li class="list-group-item" style="border:0px;">&nbsp;</li>
  <?php } ?>
</ul>
<script type="text/javascript">
$(document).ready(function(){	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>