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

class Designation extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Designation_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Company_model");
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
		$data['title'] = $this->lang->line('xin_designations').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		//$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_designations');
		$data['path_url'] = 'designation';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('4',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/designation/designation_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load		  
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function designation_list()
     {

		$session = $this->session->userdata('username');
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/designation/designation_list", $data);
		} else {
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$designation = $this->Designation_model->get_designations();
		} else {
			$designation = $this->Designation_model->get_company_designations($user_info[0]->company_id);
		}
		$data = array();

          foreach($designation->result() as $r) {
			  
			// get department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';	
			}
			if($system[0]->is_active_sub_departments=='yes'){
				// get sub department
				$subdepartment = $this->Department_model->read_sub_department_info($r->sub_department_id);
				if(!is_null($subdepartment)){
					$subdep_name = $subdepartment[0]->department_name;
					$subdep_name = '<br><small class="text-muted"><i>'.$this->lang->line('xin_hr_sub_department').': '.$subdep_name.'<i></i></i></small>';
				} else {
					$subdep_name = '<br><small class="text-muted"><i>'.$this->lang->line('xin_hr_sub_department').': --<i></i></i></small>';	
				}
			} else {
				$subdep_name ='';
			}
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			if(in_array('244',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-designation_id="'. $r->designation_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('245',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->designation_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $edit.$delete;
			$idesignation_name = $r->designation_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department').': '.$department_name.'<i></i></i></small>'.$subdep_name.'';

            $data[] = array(
				$combhr,
				$idesignation_name,
				$comp_name
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $designation->num_rows(),
                 "recordsFiltered" => $designation->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('designation_id');
		$result = $this->Designation_model->read_designation_information($id);
		$data = array(
				'designation_id' => $result[0]->designation_id,
				'company_id' => $result[0]->company_id,
				'department_id' => $result[0]->department_id,
				'sub_department_id' => $result[0]->sub_department_id,
				'designation_name' => $result[0]->designation_name,
				'description' => $result[0]->description,
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_departments' => $this->Department_model->all_departments()
				);
		if(!empty($session)){ 
			$this->load->view('admin/designation/dialog_designation', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get company > departments
	 public function get_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/designation/get_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > departments
	 public function get_model_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/designation/get_model_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 // get main department > sub departments
	 public function get_sub_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/designation/get_subdepartments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get main department > sub departments
	 public function get_sub_departments_modal() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/designation/get_subdepartments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	// get departmens > designations
	 public function topdesignation() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/designation/get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	// Validate and add info in database
	public function add_designation() {
	
		if($this->input->post('add_type')=='designation') {
		// Check validation for user input
		$this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation_name', 'Designation', 'trim|required|xss_clean');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$system = $this->Xin_model->read_setting_info(1);
		/* Server side PHP input validation */
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('department_id')==='') {
        	$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('subdepartment_id')==='') {
        	$Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
		} else if($this->input->post('designation_name')==='') {
			$Return['error'] = $this->lang->line('error_designation_field');
		} else if($this->input->post('description')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$data = array(
		'department_id' => $this->input->post('department_id'),
		'sub_department_id' => $this->input->post('subdepartment_id'),
		'company_id' => $this->input->post('company_id'),
		'designation_name' => $this->input->post('designation_name'),
		'description' => $this->input->post('description'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Designation_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_designation');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='designation') {
			
		$id = $this->uri->segment(4);
		
		// Check validation for user input
		$this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation_name', 'Designation', 'trim|required|xss_clean');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$system = $this->Xin_model->read_setting_info(1);
		/* Server side PHP input validation */
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('department_id')==='') {
        	$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('subdepartment_id')==='') {
        	$Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
		} else if($this->input->post('designation_name')==='') {
			$Return['error'] = $this->lang->line('error_designation_field');
		} else if($this->input->post('description')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_file_description');
		} 
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$data = array(
		'department_id' => $this->input->post('department_id'),
		'sub_department_id' => $this->input->post('subdepartment_id'),
		'company_id' => $this->input->post('company_id'),
		'designation_name' => $this->input->post('designation_name'),
		'description' => $this->input->post('description'),		
		);
		$result = $this->Designation_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_designation');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
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
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Designation_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_designation');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
