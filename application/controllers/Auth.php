.<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
		 
	 public function login() {
		 		
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'user_type'=>'', 'csrf_hash'=>'');
		//$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */
		if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} elseif($this->input->post('password')===''){
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$data = array(
			'email' => $email,
			'password' => $password
			);
		$result = $this->Login_model->frontend_user_login($data);	
		
		if ($result == TRUE) {
			
				$result = $this->Login_model->read_frontend_user_info_session($email);
				$session_data = array(
				'c_user_id' => $result[0]->user_id,
				'c_email' => $result[0]->email,
				'user_type' => $result[0]->user_type
				);
				// Add user data in session
				$this->session->set_userdata('c_email', $session_data);
				$this->session->set_userdata('c_user_id', $session_data);
				$this->session->set_userdata('user_type', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				/*if($result[0]->user_type == 1){
					$Return['user_type'] = 'employer/account';
				} else {
					$Return['user_type'] = 'user/account';
				}*/
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				 $last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result[0]->user_id; // user id
				  
				$this->Users_model->update_record($last_data, $id);
				$this->output($Return);
				
				
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
				/*Return*/
				$this->output($Return);
			}
	}
	 
	 // Logout from frontend
	public function logout() {
	
		$session = $this->session->userdata('c_user_id');
		$last_data = array(
			'is_logged_in' => '0'
		); 
		$this->Users_model->update_record($last_data, $session['c_user_id']);
				
		// Removing session data
		$data['title'] = 'HR Software';
		$sess_array = array('c_user_id' => '','c_email' => '');
		$this->session->sess_destroy();
		$Return['result'] = 'Successfully Logout.';
		redirect('user/sign_in/', 'refresh');
	}
}
