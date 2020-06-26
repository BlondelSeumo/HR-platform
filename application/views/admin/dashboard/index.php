<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php
if($user_info[0]->user_role_id==1):
	if($theme[0]->dashboard_option == 'dashboard_1') {
		$this->load->view('admin/dashboard/administrator_dashboard_1');
	} else if($theme[0]->dashboard_option == 'dashboard_2') {
		$this->load->view('admin/dashboard/administrator_dashboard_2');
	} else if($theme[0]->dashboard_option == 'dashboard_3') {
		$this->load->view('admin/dashboard/administrator_dashboard_3');
	} else if($theme[0]->dashboard_option == 'dashboard_4') {
		$this->load->view('admin/dashboard/administrator_dashboard_4');
	} else {
		$this->load->view('admin/dashboard/administrator_dashboard_1');
	}
/*elseif($user_info[0]->user_role_id==3):
	$this->load->view('admin/dashboard/management_dashboard');*/
else:
$this->load->view('admin/dashboard/employee_dashboard');
endif;?>