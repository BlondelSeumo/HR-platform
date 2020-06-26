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

class Leads extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Clients_model");
		$this->load->model("Xin_model");
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
	
	 public function index()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_leads').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['breadcrumbs'] = $this->lang->line('xin_leads');
		$data['path_url'] = 'leads';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('411',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/clients/leads_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
 	// import > leads
	 public function import()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_leads').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_leads');
		$data['path_url'] = 'import_leads';		
		$data['all_employees'] = $this->Xin_model->all_employees();
		//$data['all_departments'] = $this->Department_model->all_departments();
		//$data['all_designations'] = $this->Designation_model->all_designations();
		//$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		//$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('92',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/clients/leads_import", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 // Validate and add info in database
	public function import_leads() {
	
		if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					//skip first line
					fgetcsv($csvFile);
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
						
						$options = array('cost' => 12);
						$password_hash = password_hash($line[2], PASSWORD_BCRYPT, $options);
						$data = array(
						'name' => $line[0],
						'email' => $line[1],
						'client_password' => $password_hash,
						'contact_number' => $line[3],
						'company_name' => $line[4],
						'website_url' => $line[5],
						'address_1' => $line[6],
						'address_2' => $line[7],
						'city' => $line[8],
						'state' => $line[9],
						'zipcode' => $line[10],
						'country' => $line[11],
						'is_active' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'is_changed' => '0',
						'client_profile' => '',
						);
					$this->Clients_model->add_lead($data);
				}					
				//close opened csv file
				fclose($csvFile);
	
				$Return['result'] = $this->lang->line('xin_success_leads_import');
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_leads_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		$this->output($Return);
		exit;
		}
	}
    public function leads_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/clients/leads_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$leads = $this->Clients_model->get_leads();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($leads->result() as $r) {
			  
			  // get country
			  $country = $this->Xin_model->read_country_info($r->country);
			  if(!is_null($country)){
			  	$c_name = $country[0]->country_name;
			  } else {
				  $c_name = '--';	
			  }	  
			  
			  if(in_array('413',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-timelog-data"  data-client_id="'. $r->client_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('414',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->client_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('420',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-client_id="'. $r->client_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			// change to client
			if($r->is_changed == '0'){
				$change = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_change_to_client').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-lead_id="'. $r->client_id . '"><span class="fas fa-exchange-alt"></span></button></span>';
				$opt = '<span class="badge badge-info">'.$this->lang->line('xin_lead').'</span>';
			} else {
				$change = '';
				$opt = '<span class="badge badge-success">'.$this->lang->line('xin_contact_person').'</span>';
			}
			$lead_flup = $this->Clients_model->get_total_lead_followup($r->client_id);
			if($lead_flup > 0){
				if($r->is_changed == '0'){
					$ldflp_opt = '<span class="badge badge-danger">'.$this->lang->line('xin_lead_followup').'</span>';
				} else {
					$ldflp_opt = '';
				}
			} else {
				$ldflp_opt = '';
			}
			
			if($r->is_changed == 0){
			$dview = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_lead_add_followup').'"><a href="'.site_url().'admin/leads/followup/'.$r->client_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$dview = '';
			}
			$combhr = $edit.$view.$dview.$change.$delete;
		
               $data[] = array(
			   		$combhr,
                    $r->name.'<br>'.$opt.'<br>'.$ldflp_opt,
					$r->company_name,
					$r->email,
                    $r->website_url,
                    $c_name,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $leads->num_rows(),
                 "recordsFiltered" => $leads->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 public function leads_followup_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/clients/leads_followup", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$followup = $this->Clients_model->get_lead_followup($id);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($followup->result() as $r) {
			 
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->leads_followup_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-timelog-data"  data-leads_followup_id="'. $r->leads_followup_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$combhr = $edit.$delete;
		
               $data[] = array(
			   		$combhr,
                    $r->next_followup,
					$r->description,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $followup->num_rows(),
                 "recordsFiltered" => $followup->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function lead_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('client_id');
		$result = $this->Clients_model->read_lead_info($id);
		$data = array(
			'client_id' => $result[0]->client_id,
			'name' => $result[0]->name,
			'company_name' => $result[0]->company_name,
			'client_profile' => $result[0]->client_profile,
			'email' => $result[0]->email,
			'contact_number' => $result[0]->contact_number,
			'website_url' => $result[0]->website_url,
			'address_1' => $result[0]->address_1,
			'address_2' => $result[0]->address_2,
			'is_changed' => $result[0]->is_changed,
			'city' => $result[0]->city,
			'state' => $result[0]->state,
			'zipcode' => $result[0]->zipcode,
			'countryid' => $result[0]->country,
			'is_active' => $result[0]->is_active,
			'all_countries' => $this->Xin_model->get_countries(),
		);
		$this->load->view('admin/clients/dialog_leads', $data);
	}
	public function read_leads_followup()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('leads_followup_id');
		$result = $this->Clients_model->read_lead_followup_info($id);
		$data = array(
			'leads_followup_id' => $result[0]->leads_followup_id,
			'lead_id' => $result[0]->lead_id,
			'next_followup' => $result[0]->next_followup,
			'description' => $result[0]->description,
		);
		$this->load->view('admin/clients/dialog_leads', $data);
	}
	// Validate and add info in database
	public function add_followup() {
	
		if($this->input->post('type')=='followup_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('next_followup')==='') {
        	$Return['error'] = $this->lang->line('xin_lead_next_followup_field_error');
		} else if($this->input->post('description')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'next_followup' => $this->input->post('next_followup'),
		'description' => $this->input->post('description'),
		'lead_id' => $this->input->post('client_id'),
		);
		$result = $this->Clients_model->add_lead_followup($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_lead_followup_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database
	public function update_lead_followup() {
	
		if($this->input->post('data')=='edit_followup_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$id = $this->uri->segment(4);	
		/* Server side PHP input validation */		
		if($this->input->post('next_followup')==='') {
        	$Return['error'] = $this->lang->line('xin_lead_next_followup_field_error');
		} else if($this->input->post('description')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'next_followup' => $this->input->post('next_followup'),
		'description' => $this->input->post('description'),
		);
		$result = $this->Clients_model->update_lead_followup_record($data,$id);	
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_lead_followup_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database
	public function add_lead() {
	
		if($this->input->post('add_type')=='lead') {
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
		$user_id = $this->input->post('user_id');
		$file = $_FILES['client_photo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_clcontact_person_field_error');
		} /*else if($company_name==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($contact_number==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		}*/ else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($this->Xin_model->check_client_email($email) > 0) {
			$Return['error'] = $this->lang->line('xin_check_client_email_error');
		}  /*else if($city==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($zipcode==='') {
			$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		}*/ else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} /*else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}*/
		
		/* Check if file uploaded..*/
		else if($_FILES['client_photo']['size'] == 0) {
			$fname = 'no file';
			 $options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
		
			$data = array(
			'name' => $this->input->post('name'),
			'company_name' => $this->input->post('company_name'),
			'email' => $this->input->post('email'),
			'is_changed' => '0',
			'client_password' => $password_hash,
			'client_profile' => '',
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'is_active' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			
			);
			$result = $this->Clients_model->add_lead($data);
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
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
		
			$data = array(
			'name' => $this->input->post('name'),
			'company_name' => $this->input->post('company_name'),
			'email' => $this->input->post('email'),
			'is_changed' => '0',
			'client_password' => $password_hash,
			'client_profile' => $fname,
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'is_active' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			
			);
			$result = $this->Clients_model->add_lead($data);
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_lead_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_lead() {
	
		if($this->input->post('edit_type')=='lead') {
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
			$Return['error'] = $this->lang->line('xin_clcontact_person_field_error');
		} /*else if($company_name==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($contact_number==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		}*/ else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($this->Xin_model->check_client_email($email) > 1) {
			$Return['error'] = $this->lang->line('xin_check_client_email_error');
		}  /*else if($city==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($zipcode==='') {
			$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		}*/ else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} /*else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		}*/
				
		/* Check if file uploaded..*/
		else if($_FILES['client_photo']['size'] == 0) {
			 //$fname = 'no file';
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
			'is_active' => $this->input->post('status'),
			);
			 $result = $this->Clients_model->update_lead_record($no_logo_data,$id);
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
					//'client_username' => $this->input->post('username'),
					'client_profile' => $fname,
					'contact_number' => $this->input->post('contact_number'),
					'website_url' => $this->input->post('website'),
					'address_1' => $this->input->post('address_1'),
					'address_2' => $this->input->post('address_2'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zipcode' => $this->input->post('zipcode'),
					'country' => $this->input->post('country'),		
					'is_active' => $this->input->post('status'),
					);
					// update record > model
					$result = $this->Clients_model->update_lead_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
	
		if($Return['error']!=''){
       		$this->output($Return);
    	}		
			
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_lead_updated');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 // Validate and update info in database // update_status
	public function change_to_client() {
	
		if($this->input->post('edit_type')=='change_lead') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'is_changed' => '1',
		);
		$id = $this->uri->segment(4);
		$result = $this->Clients_model->update_lead_record($data,$id);
		$lead_info = $this->Clients_model->read_lead_info($id);
		$data_lead = array(
			'name' => $lead_info[0]->name,
			'company_name' => $lead_info[0]->company_name,
			'email' => $lead_info[0]->email,
			'client_password' => $lead_info[0]->client_password,
			'client_profile' => $lead_info[0]->client_profile,
			'contact_number' => $lead_info[0]->contact_number,
			'website_url' => $lead_info[0]->website_url,
			'address_1' => $lead_info[0]->address_1,
			'address_2' => $lead_info[0]->address_2,
			'city' => $lead_info[0]->city,
			'state' => $lead_info[0]->state,
			'zipcode' => $lead_info[0]->zipcode,
			'country' => $lead_info[0]->country,
			'is_active' => 1,
			'created_at' => date('Y-m-d H:i:s'),
		);
		$this->Clients_model->add($data_lead);
		//$this->Clients_model->delete_lead_record($id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_lead_has_been_converted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
	// leads follow up
	public function followup()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Clients_model->read_lead_info($id);
		if(is_null($result)){
			redirect('admin/leads');
		}
		
		$data = array(
			'title' => $this->lang->line('xin_lead_details').' | '.$this->Xin_model->site_title(),
			'client_id' => $result[0]->client_id,
			'name' => $result[0]->name,
			'company_name' => $result[0]->company_name,
			'client_profile' => $result[0]->client_profile,
			'email' => $result[0]->email,
			'contact_number' => $result[0]->contact_number,
			'website_url' => $result[0]->website_url,
			'address_1' => $result[0]->address_1,
			'address_2' => $result[0]->address_2,
			'is_changed' => $result[0]->is_changed,
			'city' => $result[0]->city,
			'state' => $result[0]->state,
			'zipcode' => $result[0]->zipcode,
			'countryid' => $result[0]->country,
			'is_active' => $result[0]->is_active,
			'all_countries' => $this->Xin_model->get_countries(),
		);
		$data['breadcrumbs'] = $this->lang->line('xin_lead').'#'.$result[0]->client_id.' - '.$result[0]->company_name;
		$data['path_url'] = 'lead_details';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/clients/leads_followup", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}		  
     }
	public function delete_lead() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Clients_model->delete_lead_record($id);
			$result = $this->Clients_model->delete_main_lead_followup($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_project_lead_deleted');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function delete_lead_followup() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Clients_model->delete_lead_followup($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_lead_followup_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
