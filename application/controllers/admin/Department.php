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

class Department extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		$this->load->model("Department_model");
		$this->load->model("Location_model");
		$this->load->model("Xin_model");
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
		if(!$session){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_departments').' | '.$this->Xin_model->site_title();
		$data['all_locations'] = $this->Xin_model->all_locations();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$session = $this->session->userdata('username');
		$data['breadcrumbs'] = $this->lang->line('xin_departments');
		$data['path_url'] = 'department';
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('3',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/department/department_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 public function sub_departments()
     {
		$session = $this->session->userdata('username');
		if(!$session){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->is_active_sub_departments!='yes'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_hr_sub_departments').' | '.$this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$data['breadcrumbs'] = $this->lang->line('xin_hr_sub_departments');
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['path_url'] = 'sub_department';
		$role_resources_ids = $this->Xin_model->user_role_resource();
				
		if(in_array('3',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/department/sub_department_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function sub_department_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/department/sub_department_list", $data);
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
			$department = $this->Department_model->get_sub_departments();
		} else {
			$department = $this->Department_model->get_department_subdepartments($user_info[0]->department_id);
		}
		$data = array();

          foreach($department->result() as $r) {
			  			
			// department
			$dep = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($dep)){
				$d_name = $dep[0]->department_name;
			} else {
				$d_name = '--';	
			}
			
			if(in_array('241',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-department_id="'. $r->sub_department_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('242',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->sub_department_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			$combhr = $edit.$delete;
			  
		   $data[] = array(
				$combhr,
				$r->department_name,
				$d_name,
				$created_at
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $department->num_rows(),
                 "recordsFiltered" => $department->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function department_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/department/department_list", $data);
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
			$department = $this->Department_model->get_departments();
		} else {
			$department = $this->Department_model->get_company_departments($user_info[0]->company_id);
		}
		$data = array();

          foreach($department->result() as $r) {
			  
			// get user > head
			$head_user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($head_user)){
				$dep_head = $head_user[0]->first_name.' '.$head_user[0]->last_name;
			} else {
				$dep_head = '--';	
			}
			
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			// get company
			$location = $this->Location_model->read_location_information($r->location_id);
			if(!is_null($location)){
				$location_name = $location[0]->location_name;
			} else {
				$location_name = '--';	
			}
			
			if(in_array('241',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-department_id="'. $r->department_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('242',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->department_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$ititle = $r->department_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $edit.$delete;
			  
		   $data[] = array(
				$combhr,
				$ititle,
				$location_name,
				$this->security->xss_clean($comp_name)
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $department->num_rows(),
                 "recordsFiltered" => $department->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 	 
	 // get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'company_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/department/get_employees", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 // get company > employees
	 public function get_company_locations() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'company_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/department/get_company_locations", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 // get location > departments
	 public function get_location_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'company_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/department/get_company_locations", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->input->get('department_id'));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			$id = $this->security->xss_clean($id);
			$result = $this->Department_model->read_department_information($id);
			$data = array(
				'department_id' => $result[0]->department_id,
				'location_id' => $result[0]->location_id,
				'department_name' => $result[0]->department_name,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'all_locations' => $this->Xin_model->all_locations(),
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
			$session = $this->session->userdata('username');
			
			if(!empty($session)){ 
				$this->load->view('admin/department/dialog_department', $data);
			} else {
				redirect('admin/');
			}
		}
	}
	
	public function read_sub_record()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->input->get('department_id'));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			$id = $this->security->xss_clean($id);
			$result = $this->Department_model->read_sub_department_info($id);
			$data = array(
			'sub_department_id' => $result[0]->sub_department_id,
			'department_id' => $result[0]->department_id,
			'department_name' => $result[0]->department_name,
			);
			$data['all_departments'] = $this->Department_model->all_departments();
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$this->load->view('admin/department/dialog_sub_department', $data);
			} else {
				redirect('admin/');
			}
		}
	}
					
	// Validate and add info in database
	public function add_sub_department() {
	
		if($this->input->post('add_type')=='department') {
		// Check validation for user input
		$session = $this->session->userdata('username');
		
		$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|xss_clean');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($this->input->post('department_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($this->input->post('department_id')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_department');
		}
		if($Return['error']!=''){
			
       		$this->output($Return);
    	}
	
		$data = array(
		'department_name' => $this->input->post('department_name'),
		'department_id' => $this->input->post('department_id'),
		'created_at' => date('Y-m-d H:i:s'),
		
		);

		$data = $this->security->xss_clean($data);
		$result = $this->Department_model->add_sub($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_sub_department_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_department() {
	
		if($this->input->post('add_type')=='department') {
		// Check validation for user input
		$session = $this->session->userdata('username');
		
		$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('company_id', 'Company', 'trim|required|xss_clean');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		//if($this->form_validation->run() == FALSE) {
				//$Return['error'] = 'validation error.';
		//}
		/* Server side PHP input validation */
		if($this->input->post('department_name')==='') {
        	$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('location_id')==='') {
			$Return['error'] = $this->lang->line('xin_location_field_error');
		} 
		if($Return['error']!=''){
			
       		$this->output($Return);
    	}
	
		$data = array(
		'department_name' => $this->input->post('department_name'),
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'employee_id' => $this->input->post('employee_id'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('Y-m-d H:i:s'),
		
		);

		$data = $this->security->xss_clean($data);
		$result = $this->Department_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_department');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='department') {
			
		
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			// Check validation for user input
			$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
			$this->form_validation->set_rules('employee_id', 'Employee', 'trim|required|xss_clean');
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			/* Server side PHP input validation */
			if($this->input->post('department_name')==='') {
				$Return['error'] = $this->lang->line('error_department_field');
			} else if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('xin_location_field_error');
			} 
					
			if($Return['error']!=''){
				$this->output($Return);
			}
		
			$data = array(
			'department_name' => $this->input->post('department_name'),
			'company_id' => $this->input->post('company_id'),
			'location_id' => $this->input->post('location_id'),
			'employee_id' => $this->input->post('employee_id'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->Department_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_update_department');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
		}
	}
	
	// Validate and update info in database
	public function update_sub_record() {
	
		if($this->input->post('edit_type')=='department') {
			
		
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			// Check validation for user input
			$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|xss_clean');
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			/* Server side PHP input validation */
			if($this->input->post('department_name')==='') {
				$Return['error'] = $this->lang->line('error_department_field');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_department');
			}
					
			if($Return['error']!=''){
				$this->output($Return);
			}
		
			$data = array(
			'department_name' => $this->input->post('department_name'),
			'department_id' => $this->input->post('department_id'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->Department_model->update_sub_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_hr_sub_department_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(is_numeric($keywords[0])) {
				$id = $keywords[0];
				$id = $this->security->xss_clean($id);
				$result = $this->Department_model->delete_record($id);
				if(isset($id)) {
					$Return['result'] = $this->lang->line('xin_success_delete_department');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
			}
		}
	}
	public function sub_delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(is_numeric($keywords[0])) {
				$id = $keywords[0];
				$id = $this->security->xss_clean($id);
				$result = $this->Department_model->delete_sub_record($id);
				if(isset($id)) {
					$Return['result'] = $this->lang->line('xin_hr_sub_department_deleted');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
			}
		}
	}
}
