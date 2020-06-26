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

class Users extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Users_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Roles_model");		
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_users');
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['breadcrumbs'] = $this->lang->line('xin_users');
		$data['path_url'] = 'users';
		$data['subview'] = $this->load->view("admin/users/users_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
     }
 
    public function users_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/users/users_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$users = $this->Users_model->get_users();
		
		$data = array();

          foreach($users->result() as $r) {
			  
			// get country
			$country = $this->Xin_model->read_country_info($r->country);
			if(!is_null($country)){
				$c_name = $country[0]->country_name;
			} else {
			  	$c_name = '--';	
			}
			
			$full_name = $r->first_name . ' ' .$r->first_name;
			if($r->user_id!=1):
				$opt = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><i class="fas fa-trash-restore-o"></i></button></span>';
			else:
				$opt = '';	
			endif;
			
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-user_id="'. $r->user_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-user_id="'. $r->user_id . '"><i class="fa fa-eye"></i></button></span>'.$opt.'',
				$full_name,
				$r->email,
				$r->username,
				$r->password,
				$c_name
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $users->num_rows(),
                 "recordsFiltered" => $users->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function profile()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$result = $this->Users_model->read_users_info($session['user_id']);
		$data = array(
		'path_url' => 'user_profile',
		'title' => $this->lang->line('xin_user_profile'),
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
		'all_countries' => $this->Xin_model->get_countries(),
		'all_user_roles' => $this->Roles_model->all_user_roles()
		);
		$data['subview'] = $this->load->view("admin/users/user_profile", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
     }
	 
	 // Validate and update info in database
	public function profile_background() {
	
		if($this->input->post('type')=='profile_background') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		$session = $this->session->userdata('username');
		$id = $session['user_id'];
		
		if($_FILES['p_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_select_profile_cover');
		} else {
		if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif');
			$filename = $_FILES['p_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["p_file"]["tmp_name"];
				$profile = "uploads/users/background/";
				$set_img = base_url()."uploads/users/background/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["p_file"]["name"]);
				$newfilename = 'profile_background_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;			
				
				$data = array(
				'profile_background' => $fname
				);
				$result = $this->Users_model->update_record($data,$id);	
				if ($result == TRUE) {
					$Return['profile_background'] = $set_img.$fname;
					$Return['result'] = $this->lang->line('xin_success_profile_background_updated');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;	
		
			} else {
				$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
				
		if($Return['error']!=''){
		$this->output($Return);
		}
		}
	}
	 
	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('user_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Users_model->read_users_info($id);
		$data = array(
		'user_id' => $result[0]->user_id,
		'first_name' => $result[0]->first_name,
		'last_name' => $result[0]->last_name,
		'email' => $result[0]->email,
		'username' => $result[0]->username,
		'password' => $result[0]->password,
		'gender' => $result[0]->gender,
		'profile_photo' => $result[0]->profile_photo,
		'contact_number' => $result[0]->contact_number,
		'address_1' => $result[0]->address_1,
		'address_2' => $result[0]->address_2,
		'city' => $result[0]->city,
		'state' => $result[0]->state,
		'zipcode' => $result[0]->zipcode,
		'icountry' => $result[0]->country,
		'all_countries' => $this->Xin_model->get_countries(),
		'all_user_roles' => $this->Roles_model->all_user_roles()
		);
		$this->load->view('admin/users/dialog_users', $data);
	}
	
	// Validate and add info in database
	public function add_user() {
	
		if($this->input->post('add_type')=='user') {
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
		} else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		} else if($this->input->post('city')==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($this->input->post('country')==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		}		
		/* Check if file uploaded..*/
		else if($_FILES['photo']['size'] == 0) {
			$fname = 'no file';
			 $Return['error'] = $this->lang->line('xin_user_photo_field');
		} else {
			if(is_uploaded_file($_FILES['photo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['photo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["photo"]["tmp_name"];
					$user_photo = "uploads/users/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["photo"]["name"]);
					$newfilename = 'user_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $user_photo.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'email' => $this->input->post('email'),
		'username' => $this->input->post('username'),
		'password' => $this->input->post('password'),
		'gender' => $this->input->post('gender'),
		'contact_number' => $this->input->post('contact_number'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		'profile_photo' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Users_model->add($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_user_added');
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
		$id = $this->uri->segment(4);
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
		} else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
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
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
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
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
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
			$Return['result'] = $this->lang->line('xin_success_user_updated');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Users_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_company');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
