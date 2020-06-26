<?php
/* Performance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php
	if($system[0]->performance_option == 'appraisal'):
		$this->load->view('admin/performance/appraisal');
	else:
		$this->load->view('admin/performance/goals');	
	endif;
?>
