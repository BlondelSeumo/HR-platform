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

class Trainers extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Trainers_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
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
		if($system[0]->module_training!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_trainers').' | '.$this->Xin_model->site_title();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_trainers');
		$data['path_url'] = 'trainers';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('56',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/trainers/trainer_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
     }
 
    public function trainer_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/trainers/trainer_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
				
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$trainers = $this->Trainers_model->get_trainers();
		} else {
			$trainers = $this->Trainers_model->get_company_trainers($user_info[0]->company_id);
		}
		$data = array();

        foreach($trainers->result() as $r) {
			 			  
			// get name
			$full_name = $r->first_name.' '.$r->last_name;
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
			$comp_name = $company[0]->name;
			} else {
			  $comp_name = '--';	
			}
			if(in_array('349',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-trainer_id="'. $r->trainer_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('350',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->trainer_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('351',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-trainer_id="'. $r->trainer_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$ifull_name = $full_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_expertise').': '.html_entity_decode($r->expertise).'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_address').': '.html_entity_decode($r->address).'<i></i></i></small>';
			$data[] = array(
			$combhr,
			$ifull_name,
			$comp_name,
			$r->contact_number,
			$r->email
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $trainers->num_rows(),
			 "recordsFiltered" => $trainers->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('trainer_id');
		$result = $this->Trainers_model->read_trainer_information($id);
		$data = array(
				'trainer_id' => $result[0]->trainer_id,
				'company_id' => $result[0]->company_id,
				'first_name' => $result[0]->first_name,
				'last_name' => $result[0]->last_name,
				'contact_number' => $result[0]->contact_number,
				'email' => $result[0]->email,
				'expertise' => $result[0]->expertise,
				'address' => $result[0]->address,
				'all_companies' => $this->Xin_model->get_companies(),
				'all_designations' => $this->Designation_model->all_designations()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/trainers/dialog_trainer', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_trainer() {
	
		if($this->input->post('add_type')=='trainer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$expertise = $this->input->post('expertise');
		$qt_expertise = htmlspecialchars(addslashes($expertise), ENT_QUOTES);
		$address = $this->input->post('address');
		$qt_address = htmlspecialchars(addslashes($address), ENT_QUOTES);
		
		if($this->input->post('first_name')==='') {
       		$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} else if($this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} else if($this->input->post('contact_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_number');
		} else if($this->input->post('email')==='') {
       		$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
		  $Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}				
	
		$data = array(
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'company_id' => $this->input->post('company'),
		'contact_number' => $this->input->post('contact_number'),
		'expertise' => $qt_expertise,
		'address' => $qt_address,
		'email' => $this->input->post('email'),
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Trainers_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_trainer_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='trainer') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$expertise = $this->input->post('expertise');
		$qt_expertise = htmlspecialchars(addslashes($expertise), ENT_QUOTES);
		$address = $this->input->post('address');
		$qt_address = htmlspecialchars(addslashes($address), ENT_QUOTES);
		
		if($this->input->post('first_name')==='') {
       		$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} else if($this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} else if($this->input->post('contact_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_number');
		} else if($this->input->post('email')==='') {
       		$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
		  $Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->input->post('designation_id')==='') {
       		$Return['error'] = $this->lang->line('xin_error_designation_field');
		} else if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}				
	
		$data = array(
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'company_id' => $this->input->post('company'),
		'contact_number' => $this->input->post('contact_number'),
		'expertise' => $qt_expertise,
		'address' => $qt_address,
		'email' => $this->input->post('email')
		);
		
		$result = $this->Trainers_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_trainer_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Trainers_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_trainer_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
