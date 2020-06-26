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

class User extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		//$this->load->model("Designation_model");
		//$this->load->model("Department_model");
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
	
	 public function sign_in() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_sign_in_button');
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['path_url'] = 'job_user_signin';
		$data['subview'] = $this->load->view("frontend/hrsale/sign_in", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	public function elogin() {
		 		
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
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
		} else {
			$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
		}
		$this->output($Return);
		exit;
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
	
	
	  public function register() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Sign Up';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['path_url'] = 'job_create_user';
		$data['subview'] = $this->load->view("frontend/hrsale/register", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function forgot_password() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_forgot_password_title');
		$data['subview'] = $this->load->view("frontend/hrsale/forgot_password", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function change_password() {
		$data['title'] = $this->lang->line('header_change_password');
		$data['path_url'] = 'job_user_password';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('user/sign_in/');
		}
		$data['subview'] = $this->load->view("frontend/hrsale/change_password", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	  public function my_jobs() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_jobs_applied');
		$data['path_url'] = 'job_user_account';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('user/sign_in/');
		}
		$data['subview'] = $this->load->view("frontend/hrsale/my_jobs", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function account() {
		
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('user/sign_in/');
		}
		$result = $this->Users_model->read_users_info($session['c_user_id']);
		$data = array(
		'path_url' => 'job_user_account',
		'title' => $this->lang->line('xin_rec_my_account'),
		'user_id' => $result[0]->user_id,
		'first_name' => $result[0]->first_name,
		'last_name' => $result[0]->last_name,
		'email' => $result[0]->email,
		'username' => $result[0]->username,
		'password' => $result[0]->password,
		'gender' => $result[0]->gender,
		'profile_photo' => $result[0]->profile_photo,
		'profile_background' => $result[0]->profile_background,
		'contact_number' => $result[0]->contact_number,
		'address_1' => $result[0]->address_1,
		'address_2' => $result[0]->address_2,
		'city' => $result[0]->city,
		'state' => $result[0]->state,
		'zipcode' => $result[0]->zipcode,
		'icountry' => $result[0]->country,
		'last_login_date' => $result[0]->last_login_date,
		'last_login_ip' => $result[0]->last_login_ip,
		'is_logged_in' => $result[0]->is_logged_in,
		'all_countries' => $this->Xin_model->get_countries()
		);
		$data['subview'] = $this->load->view("frontend/hrsale/user_account", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='user') {
		
		$session = $this->session->userdata('c_user_id');
		$id = $session['c_user_id'];
		// Check validation for user input
		// Check validation for user input
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		$file = $_FILES['photo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('first_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} else if( $this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} else if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->input->post('city')==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($this->input->post('country')==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		}		
		/* Check if file uploaded..*/
		else if($_FILES['photo']['size'] == 0) {
			 $fname = 'no file';
			 $no_logo_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'gender' => $this->input->post('gender'),
			'contact_number' => $this->input->post('contact_number'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country')
			);
			 $result = $this->Users_model->update_record_no_photo($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['photo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['photo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["photo"]["tmp_name"];
					$bill_copy = "uploads/users/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["photo"]["name"]);
					$newfilename = 'user_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'contact_number' => $this->input->post('contact_number'),
					'address_1' => $this->input->post('address_1'),
					'address_2' => $this->input->post('address_2'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zipcode' => $this->input->post('zipcode'),
					'country' => $this->input->post('country'),
					'profile_photo' => $fname,		
					);
					// update record > model
					$result = $this->Users_model->update_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_user_profile_update');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	
}
