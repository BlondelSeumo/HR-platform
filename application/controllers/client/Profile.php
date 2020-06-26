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

class Profile extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Clients_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	  public function index() {

		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/auth/');
		}
		$result = $this->Clients_model->read_client_info($session['client_id']);
		$data = array(
			'name' => $result[0]->name,
			'client_id' => $result[0]->client_id,
			'client_username' => $result[0]->client_username,
			'email' => $result[0]->email,
			'company_name' => $result[0]->company_name,
			'gender' => $result[0]->gender,
			'website_url' => $result[0]->website_url,
			'contact_number' => $result[0]->contact_number,
			'address_1' => $result[0]->address_1,
			'address_2' => $result[0]->address_2,
			'city' => $result[0]->city,
			'state' => $result[0]->state,
			'zipcode' => $result[0]->zipcode,
			'countryid' => $result[0]->country,
			'is_active' => $result[0]->is_active,
			'title' => $this->Xin_model->site_title(),
			'client_profile' => $result[0]->client_profile,
			'last_login_date' => $result[0]->last_login_date,
			'last_login_date' => $result[0]->last_login_date,
			'last_login_ip' => $result[0]->last_login_ip,
			'all_countries' => $this->Xin_model->get_countries(),
			);
		$data['breadcrumbs'] = $this->lang->line('header_my_profile');
		$data['path_url'] = 'profile_client';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("client/profile/client_profile", $data, TRUE);
			$this->load->view('client/layout/layout_main', $data); //page load
		} else {
			redirect('client/auth/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('type')=='client') {
		$id = $this->uri->segment(4);
		// Check validation for user input
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		
		$name = $this->input->post('name');
		$company_name = $this->input->post('company_name');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$website = $this->input->post('website');
		$address_1 = $this->input->post('address_1');
		$address_2 = $this->input->post('address_2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zipcode = $this->input->post('zipcode');
		$country = $this->input->post('country');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($company_name==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($contact_number==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($website==='') {
			$Return['error'] = $this->lang->line('xin_error_website_field');
		}  else if($city==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($zipcode==='') {
			$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		} else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		}
				
		/* Check if file uploaded..*/
		else if($_FILES['client_photo']['size'] == 0) {
			 $fname = 'no file';
			 $no_logo_data = array(
			'name' => $this->input->post('name'),
			'company_name' => $this->input->post('company_name'),
			'email' => $this->input->post('email'),
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			);
			 $result = $this->Clients_model->update_record($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['client_photo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['client_photo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["client_photo"]["tmp_name"];
					$bill_copy = "uploads/clients/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["client_photo"]["name"]);
					$newfilename = 'client_photo_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'name' => $this->input->post('name'),
					'company_name' => $this->input->post('company_name'),
					'email' => $this->input->post('email'),
					'client_profile' => $fname,
					'contact_number' => $this->input->post('contact_number'),
					'website_url' => $this->input->post('website'),
					'address_1' => $this->input->post('address_1'),
					'address_2' => $this->input->post('address_2'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zipcode' => $this->input->post('zipcode'),
					'country' => $this->input->post('country'),		
					);
					// update record > model
					$result = $this->Clients_model->update_record($data,$id);
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
	// Validate and update info in database // change password
	public function change_password() {
	
		if($this->input->post('type')=='change_password') {		
		/* Define return | here result is used to return user data and error for error message */
		$session = $this->session->userdata('client_username');
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
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
		$options = array('cost' => 12);
		$password_hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $options);
	
		$data = array(
		'client_password' => $password_hash
		);
		$id = $session['client_id'];
		$result = $this->Clients_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_client_password_update');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
}