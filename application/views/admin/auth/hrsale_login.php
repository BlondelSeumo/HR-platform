<?php
// hrsale login pages
$system = $this->Xin_model->read_setting_info(1);
$theme = $this->Xin_model->read_theme_info(1);
if($system[0]->employee_login_id != 'pincode') {
	if($theme[0]->login_page_options == 'login_page_1'):
		$this->load->view('admin/auth/login-1');
	elseif($theme[0]->login_page_options == 'login_page_2'):
		$this->load->view('admin/auth/login-2');
	elseif($theme[0]->login_page_options == 'login_page_3'):
		$this->load->view('admin/auth/login-3');
	elseif($theme[0]->login_page_options == 'login_page_4'):
		$this->load->view('admin/auth/login-4');
	elseif($theme[0]->login_page_options == 'login_page_5'):
		$this->load->view('admin/auth/login-5');				
	else:
		$this->load->view('admin/auth/login-1');	
	endif;
} else {
	$this->load->view('admin/auth/login_pincode');
}
?>