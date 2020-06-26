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

class Employee_exit extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Employee_exit_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Employees_model");
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
		$data['title'] = $this->lang->line('left_employees_exit').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_exit_types'] = $this->Employee_exit_model->all_exit_types();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_employees_exit');
		$data['path_url'] = 'employee_exit';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('23',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/exit/exit_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function exit_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/exit/exit_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		if($this->input->get("ihr")=='true'){
			if($this->input->get("company_id")==0 && $this->input->get("employee_id")==0 && $this->input->get("status")=='all'){
				$exit = $this->Employee_exit_model->get_exit();
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")==0 && $this->input->get("status")=='all'){
				$exit = $this->Employee_exit_model->filter_company_exit($this->input->get("company_id"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")!=0 && $this->input->get("status")=='all'){
				$exit = $this->Employee_exit_model->filter_company_employee_exit($this->input->get("company_id"),$this->input->get("employee_id"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")!=0 && $this->input->get("status")!='all'){
				$exit = $this->Employee_exit_model->filter_company_employee_status_exit($this->input->get("company_id"),$this->input->get("employee_id"),$this->input->get("status"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")==0 && $this->input->get("status")!='all'){
				$exit = $this->Employee_exit_model->filter_company_notemployee_status_exit($this->input->get("company_id"),$this->input->get("status"));
			}
		} else {
			$exit = $this->Employee_exit_model->get_exit();
		}
		$data = array();

        $role_resources_ids = $this->Xin_model->user_role_resource();
		foreach($exit->result() as $r) {
			 			  
		// get user > employee to exit
		$user = $this->Xin_model->read_user_info($r->employee_id);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		// get user > added by
		$user_by = $this->Xin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($user_by)){
			$added_by = $user_by[0]->first_name.' '.$user_by[0]->last_name;
		} else {
			$added_by = '--';	
		}
		// get exit date
		$exit_date = $this->Xin_model->set_date_format($r->exit_date);
				
		// get exit type
		$exit_type = $this->Employee_exit_model->read_exit_type_information($r->exit_type_id);
		if(!is_null($exit_type)){
			$etype = $exit_type[0]->type;
		} else {
			$etype = '--';	
		}
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		if($r->exit_interview==0): $exit_interview = $this->lang->line('xin_no'); else: $exit_interview = $this->lang->line('xin_yes'); endif;
		//if($r->is_inactivate_account==0): $account = $this->lang->line('xin_no'); else: $account = $this->lang->line('xin_yes'); endif;
		
		if(in_array('205',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-exit_id="'. $r->exit_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('206',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->exit_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		if(in_array('231',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-exit_id="'. $r->exit_id . '"><span class="fa fa-eye"></span></button></span>';
		} else {
			$view = '';
		}
		$iful_name = $full_name.'<br><small class="text-muted"><i>'.$r->reason.'<i></i></i></small>';
		$combhr = $edit.$view.$delete;
		$data[] = array(
			$combhr,
			$iful_name,
			$comp_name,
			$etype,
			$exit_date,
			$exit_interview
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $exit->num_rows(),
			 "recordsFiltered" => $exit->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/exit/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('exit_id');
		$result = $this->Employee_exit_model->read_exit_information($id);
		$data = array(
				'exit_id' => $result[0]->exit_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'exit_date' => $result[0]->exit_date,
				'exit_type_id' => $result[0]->exit_type_id,
				'exit_interview' => $result[0]->exit_interview,
				'is_inactivate_account' => $result[0]->is_inactivate_account,
				'reason' => $result[0]->reason,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_exit_types' => $this->Employee_exit_model->all_exit_types(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/exit/dialog_exit', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_exit() {
	
		if($this->input->post('add_type')=='exit') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('exit_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_exit_date');
		} else if($this->input->post('type')==='') {
			 $Return['error'] = $this->lang->line('xin_error_exit_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'exit_date' => $this->input->post('exit_date'),
		'reason' => $qt_reason,
		'exit_type_id' => $this->input->post('type'),
		'exit_interview' => $this->input->post('exit_interview'),
		'is_inactivate_account' => $this->input->post('is_inactivate_account'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employee_exit_model->add($data);
		if ($result == TRUE) {
			if($this->input->post('is_inactivate_account') == 1){
				$icdata = array(
					'is_active' => 0,
				);
				$this->Employees_model->basic_info($icdata,$this->input->post('employee_id'));
			} else {
				$icdata = array(
				'is_active' => 1,
			);
				$this->Employees_model->basic_info($icdata,$this->input->post('employee_id'));
			}
			
			$Return['result'] = $this->lang->line('xin_success_employee_exit_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='exit') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
		
		if($this->input->post('exit_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_exit_date');
		} else if($this->input->post('type')==='') {
			 $Return['error'] = $this->lang->line('xin_error_exit_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'exit_date' => $this->input->post('exit_date'),
		'reason' => $qt_reason,
		'exit_type_id' => $this->input->post('type'),
		'exit_interview' => $this->input->post('exit_interview'),
		'is_inactivate_account' => $this->input->post('is_inactivate_account'),
		);
		
		$result = $this->Employee_exit_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			if($this->input->post('is_inactivate_account') == 1){
				$icdata = array(
					'is_active' => 0,
				);
				$this->Employees_model->basic_info($icdata,$this->input->post('employee_id'));
			} else {
				$icdata = array(
				'is_active' => 1,
			);
				$this->Employees_model->basic_info($icdata,$this->input->post('employee_id'));
			}
			$Return['result'] = $this->lang->line('xin_success_employee_exit_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Employee_exit_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_employee_exit_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
