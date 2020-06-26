<?php
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

class Employer extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		$this->load->model("Employees_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->helper('string');
		$this->load->library('email');
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}	 
	 // Logout from frontend
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
	 public function signup() {
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
		redirect('employer/sign_in/', 'refresh');
	}
	  public function forgot_password() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_forgot_password_link');
		$data['path_url'] = 'job_forgot_password';
		$data['subview'] = $this->load->view("frontend/hrsale/forgot_password", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 public function change_password() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('header_change_password');
		$data['path_url'] = 'job_user_password';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['subview'] = $this->load->view("frontend/hrsale/change_password", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	  public function post_job() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_add_new').' '.$this->lang->line('xin_job');
		$data['path_url'] = 'job_create';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['all_job_types'] = $this->Xin_model->get_job_type();
		$data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
		$data['subview'] = $this->load->view("frontend/hrsale/post_job", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 public function dashboard() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['title'] = 'Dashboard';
		$data['path_url'] = 'job_home';
		$data['subview'] = $this->load->view("frontend/hrsale/dashboard", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 public function login() {
		 		
		
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
	// Validate and add info in database
	public function create_account() {
	
		if($this->input->post('add_type')=='employer') {
		// Check validation for user input
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		//$file = $_FILES['photo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$valid_email = $this->Users_model->check_user_email($this->input->post('email'));
		$options = array('cost' => 12);
		$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
		/* Server side PHP input validation */
		if($this->input->post('company_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('first_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} else if( $this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} else if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($valid_email->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_rec_email_exists');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		} else if($this->input->post('contact_number')==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($_FILES['company_logo']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_rec_error_company_logo_field');
		} else {
			if(is_uploaded_file($_FILES['company_logo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['company_logo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["company_logo"]["tmp_name"];
					$bill_copy = "uploads/employers/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["company_logo"]["name"]);
					$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'company_name' => $this->input->post('company_name'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'password' => $password_hash,
					'contact_number' => $this->input->post('contact_number'),
					'is_active' => 1,
					'user_type' => 1,
					'company_logo' => $fname,		
					'created_at' => date('d-m-Y h:i:s')
					);
					// add record > model
					$result = $this->Users_model->add($data);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}	
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_success_register_user');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 public function edit_job() {
		$id = $this->uri->segment(3);
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$result = $this->Job_post_model->read_job_infor_by_url($id);
		if(is_null($result)){
			redirect('employer/manage_jobs/');
		}
		$data = array(
		'path_url' => 'job_edit',
		'title' => $this->lang->line('xin_edit_job'),
		'job_id' => $result[0]->job_id,
		'employer_id' => $result[0]->employer_id,
		'job_title' => $result[0]->job_title,
		'category_id' => $result[0]->category_id,
		'job_type_id' => $result[0]->job_type,
		'job_vacancy' => $result[0]->job_vacancy,
		'gender' => $result[0]->gender,
		'minimum_experience' => $result[0]->minimum_experience,
		'date_of_closing' => $result[0]->date_of_closing,
		'short_description' => $result[0]->short_description,
		'long_description' => $result[0]->long_description,
		'status' => $result[0]->status,
		'all_job_types' => $this->Xin_model->get_job_type(),
		'all_job_categories' => $this->Recruitment_model->all_job_categories()
		);
		
		$data['subview'] = $this->load->view("frontend/hrsale/edit_job", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function manage_jobs() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Manage Jobs';
		$data['path_url'] = 'jobs_manage';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
		$data['subview'] = $this->load->view("frontend/hrsale/manage_jobs", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function manage_applications() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Manage Applications';
		$data['path_url'] = 'jobs_applications';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
		$data['subview'] = $this->load->view("frontend/hrsale/manage_applications", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function jobs_applications_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){ 
			$this->load->view("frontend/hrsale/manage_applications", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$candidates = $this->Job_post_model->get_employee_jobs_applied($session['c_user_id']);		
		$data = array();

        foreach($candidates->result() as $r) {
			 			  
		// get job title
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '--';	
		}
		// get date
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		
		$data[] = array(
			'',
			$job_title,
			'',
			'',
			'',
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $candidates->num_rows(),
			 "recordsFiltered" => $candidates->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function employer_job_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){ 
			$this->load->view("frontend/hrsale/manage_jobs", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$jobs = $this->Job_post_model->get_employer_jobs($session['c_user_id']);
		
		$data = array();

        foreach($jobs->result() as $r) {
			 			  
		// get job designation
		$category = $this->Job_post_model->read_job_category_info($r->category_id);
		if(!is_null($category)){
			$category_name = $category[0]->category_name;
		} else {
			$category_name = '--';
		}
		// get job type
		$job_type = $this->Job_post_model->read_job_type_information($r->job_type);
		if(!is_null($job_type)){
			$jtype = $job_type[0]->type;
		} else {
			$jtype = '--';
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
			$employer_name = '--';	
		}
		
		$data[] = array(
			'<span title="'.$this->lang->line('xin_edit').'"><button data-record-id="'. $r->job_url . '" type="button" class="btn btn-default btn-sm m-b-0-0 waves-effect waves-light job-edit"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button data-record-id="'. $r->job_url . '" type="button" class="btn btn-default btn-sm m-b-0-0 waves-effect waves-light job-view"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->job_id . '"><i class="fa fa-trash-o"></i></button></span>',
			$r->job_title,
			$category_name,
			$jtype,
			$r->job_vacancy,
			$date_of_closing,
			$status,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $jobs->num_rows(),
			 "recordsFiltered" => $jobs->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// Validate and add info in database
	public function add_job() {
	
		if($this->input->post('add_type')=='job') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		$session = $this->session->userdata('c_user_id');
		/* Server side PHP input validation */
		$long_description = $_POST['long_description'];	
		$short_description = $_POST['short_description'];	
		$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
		$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
		
		if($this->input->post('job_title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_title');
		} else if($this->input->post('job_type')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		} else if($this->input->post('category_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_designation');
		} else if($this->input->post('vacancy')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_positions');
		} else if($this->input->post('date_of_closing')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_closing_date');
		} else if($qt_short_description==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_short_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$jurl = random_string('alnum', 40);
		$data = array(
		'job_title' => $this->input->post('job_title'),
		'employer_id' => $session['c_user_id'],
		'job_type' => $this->input->post('job_type'),
		'job_url' => $jurl,
		'category_id' => $this->input->post('category_id'),
		'long_description' => $qt_description,
		'short_description' => $qt_short_description,
		'long_description' => $qt_description,
		'status' => $this->input->post('status'),
		'job_vacancy' => $this->input->post('vacancy'),
		'date_of_closing' => $this->input->post('date_of_closing'),
		'gender' => $this->input->post('gender'),
		'minimum_experience' => $this->input->post('experience'),
		'created_at' => date('Y-m-d h:i:s'),
		
		);
		$result = $this->Job_post_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_job() {
	
		if($this->input->post('edit_type')=='job') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		$session = $this->session->userdata('c_user_id');
		/* Server side PHP input validation */
		$long_description = $_POST['long_description'];	
		$short_description = $_POST['short_description'];	
		$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
		$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
		$id = $this->input->post('jbid');
		if($this->input->post('job_title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_title');
		} else if($this->input->post('job_type')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		} else if($this->input->post('category_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_designation');
		} else if($this->input->post('vacancy')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_positions');
		} else if($this->input->post('date_of_closing')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_closing_date');
		} else if($qt_short_description==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_short_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'job_title' => $this->input->post('job_title'),
		'job_type' => $this->input->post('job_type'),
		'category_id' => $this->input->post('category_id'),
		'short_description' => $qt_short_description,
		'long_description' => $qt_description,
		'status' => $this->input->post('status'),
		'job_vacancy' => $this->input->post('vacancy'),
		'date_of_closing' => $this->input->post('date_of_closing'),
		'gender' => $this->input->post('gender'),
		'minimum_experience' => $this->input->post('experience')
		);
		$result = $this->Job_post_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 public function account() {
		
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$result = $this->Users_model->read_users_info($session['c_user_id']);
		$data = array(
		'path_url' => 'job_user_account',
		'title' => $this->lang->line('xin_rec_my_account'),
		'user_id' => $result[0]->user_id,
		'company_name' => $result[0]->company_name,
		'first_name' => $result[0]->first_name,
		'last_name' => $result[0]->last_name,
		'email' => $result[0]->email,
		'username' => $result[0]->username,
		'password' => $result[0]->password,
		'gender' => $result[0]->gender,
		'company_logo' => $result[0]->company_logo,
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
		$data['subview'] = $this->load->view("frontend/hrsale/employer_account", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 // Validate and update info in database
	public function update_account() {
	
		if($this->input->post('edit_type')=='user') {
		
		$session = $this->session->userdata('c_user_id');
		$id = $session['c_user_id'];
		// Check validation for user input
		// Check validation for user input
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		$file = $_FILES['company_logo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('company_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('first_name')==='') {
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
		else if($_FILES['company_logo']['size'] == 0) {
			 $fname = 'no file';
			 $no_logo_data = array(
			'company_name' => $this->input->post('company_name'),
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
			if(is_uploaded_file($_FILES['company_logo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['company_logo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["company_logo"]["tmp_name"];
					$bill_copy = "uploads/employers/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["company_logo"]["name"]);
					$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'company_name' => $this->input->post('company_name'),
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
					'company_logo' => $fname,		
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
			$Return['result'] = $this->lang->line('xin_client_profile_update');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}	 
	 	
	// Validate and add info in database
	public function add_employer() {
	
		if($this->input->post('add_type')=='employer') {
		// Check validation for user input
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		//$file = $_FILES['photo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		$valid_email = $this->Users_model->check_user_email($this->input->post('email'));
		/* Server side PHP input validation */
		if($this->input->post('company_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('first_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} else if( $this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} else if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($valid_email->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_rec_email_exists');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		} else if($this->input->post('contact_number')==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($_FILES['company_logo']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_rec_error_company_logo_field');
		} else {
		if(is_uploaded_file($_FILES['company_logo']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','gif');
			$filename = $_FILES['company_logo']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["company_logo"]["tmp_name"];
				$bill_copy = "uploads/employers/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$lname = basename($_FILES["company_logo"]["name"]);
				$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $bill_copy.$newfilename);
				$fname = $newfilename;
				$data = array(
				'company_name' => $this->input->post('company_name'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
				'contact_number' => $this->input->post('contact_number'),
				'is_active' => 1,
				'user_type' => 1,
				'company_logo' => $fname,		
				'created_at' => date('d-m-Y h:i:s')
				);
				// add record > model
				$result = $this->Users_model->add($data);
			} else {
				$Return['error'] = $this->lang->line('xin_error_attatchment_type');
			}
		}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}	
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_success_register_user');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
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
		$Return = array('result'=>'', 'error'=>'');
			
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
	
	public function delete_job() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		if($this->input->post('type')=='delete_record') {
			$id = $this->uri->segment(3);
			$result = $this->Job_post_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_job_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// Validate and update info in database // change password
	public function update_password() {
	
		if($this->input->post('type')=='change_password') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$session = $this->session->userdata('c_user_id');
		$id = $session['c_user_id'];
		/* Server side PHP input validation */		
		if(trim($this->input->post('new_password'))==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_newpassword');
		} else if(strlen($this->input->post('new_password')) < 6) {
			$Return['error'] = $this->lang->line('xin_employee_error_password_least');
		} else if(trim($this->input->post('new_password_confirm'))==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_new_cpassword');
		} else if($this->input->post('new_password')!=$this->input->post('new_password_confirm')) {
			 $Return['error'] = $this->lang->line('xin_employee_error_old_new_cpassword');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'password' => $this->input->post('new_password')
		);
		$result = $this->Users_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = 'Password has been updated.';
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}	
	
	public function send_mail() {
				
		if($this->input->post('type')=='fpassword') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			/* Server side PHP input validation */
			if($this->input->post('iemail')==='') {
				$Return['error'] = $this->lang->line('xin_error_enter_email_address');
			} else if(!filter_var($this->input->post('iemail'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if($this->input->post('iemail')) {
		
				//$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(2);
				//get employee info
				$query = $this->Xin_model->read_user_jobs_byemail($this->input->post('iemail'));
				
				$user = $query->num_rows();
				if($user > 0) {
					
					$user_info = $query->result();
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					
					$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
					$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
					//$cid = $this->email->attachment_cid($logo);
					
					$message = '<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
						<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->email,$user_info[0]->password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					
					$this->email->from($cinfo[0]->email, $cinfo[0]->company_name);
					$this->email->to($this->input->post('iemail'));
					
					$this->email->subject($subject);
					$this->email->message($message);
					$this->email->send();
					$Return['result'] = $this->lang->line('xin_success_sent_forgot_password');
					$this->session->set_flashdata('sent_message', $this->lang->line('xin_success_sent_forgot_password'));
				} else {
					/* Unsuccessful attempt: Set error message */
					$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
				}
				$this->output($Return);
				exit;
			}
		}
	}
}
