<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $result = $this->Project_model->read_project_information($project_id);?>
<?php if($result[0]->assigned_to!='') { $assigned_to = explode(',',$result[0]->assigned_to);?>
<?php foreach($assigned_to as $assign_id) {?>
<?php $e_name = $this->Xin_model->read_user_info($assign_id);?>
<?php $_designation = $this->Designation_model->read_designation_information($e_name[0]->designation_id);?>
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

<div class="il-item"> <a class="text-black" href="<?php echo site_url();?>admin/employees/detail/<?php echo $e_name[0]->user_id;?>/">
  <div class="media">
    <div class="media-left">
      <div class="avatar box-48"> <img class="b-a-radius-circle" src="<?php echo $u_file;?>" alt=""> <i class="status bg-secondary bottom right"></i> </div>
    </div>
    <div class="media-body">
      <h6 class="media-heading"><?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?></h6>
      <span class="text-muted"><?php echo $_designation[0]->designation_name;?></span> </div>
  </div>
  <div class="il-icon"><i class="fa fa-angle-right"></i></div>
  </a> </div>
<?php } ?>
<?php } else { ?>
<span>&nbsp;</span>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>