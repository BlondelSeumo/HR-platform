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

class Resignation extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Resignation_model");
		$this->load->model("Department_model");
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
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_resignations').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_resignations');
		$data['path_url'] = 'resignation';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('16',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/resignation/resignation_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function resignation_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/resignation/resignation_list", $data);
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
			$resignation = $this->Resignation_model->get_resignations();
		} else {
			if(in_array('234',$role_resources_ids)) {
				$resignation = $this->Resignation_model->get_company_resignations($user_info[0]->company_id);
			} else {
				$resignation = $this->Resignation_model->get_employee_resignation($session['user_id']);
			}
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

        foreach($resignation->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Xin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->employee_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
		} else {
			$employee_name = '--';	
		}
		// get notice date
		$notice_date = $this->Xin_model->set_date_format($r->notice_date);
		// get resignation date
		$resignation_date = $this->Xin_model->set_date_format($r->resignation_date);
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		
		if(in_array('214',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-resignation_id="'. $r->resignation_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('215',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->resignation_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		if(in_array('234',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-resignation_id="'. $r->resignation_id . '"><span class="fa fa-eye"></span></button></span>';
		} else {
			$view = '';
		}
		$combhr = $edit.$view.$delete;
		if($r->status == 0){
			$app_status = $this->lang->line('xin_not_approve_payroll_title');
		} else if($r->status == 1){
			$app_status = $this->lang->line('xin_manager_level_title');
		} else if($r->status == 2){
			$app_status = $this->lang->line('xin_hrd_level_title');
		} else if($r->status == 3){
			$app_status = $this->lang->line('xin_gm_om_level_title');
		} else {
			$app_status = $this->lang->line('xin_not_approve_payroll_title');
		}
		$iemployee_name = $employee_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_reason').': '.$r->reason.'<i></i></i></small>'.'<br><small class="text-muted"><i>'.$app_status.'<i></i></i></small>';
		
		$data[] = array(
			$combhr,
			$iemployee_name,
			$comp_name,
			$notice_date,
			$resignation_date
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $resignation->num_rows(),
			 "recordsFiltered" => $resignation->num_rows(),
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
			$this->load->view("admin/resignation/get_employees", $data);
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
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('resignation_id');
		$result = $this->Resignation_model->read_resignation_information($id);
		$data = array(
				'resignation_id' => $result[0]->resignation_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'approval_status' => $result[0]->status,
				'notice_date' => $result[0]->notice_date,
				'resignation_date' => $result[0]->resignation_date,
				'reason' => $result[0]->reason,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/resignation/dialog_resignation', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_resignation() {
	
		if($this->input->post('add_type')=='resignation') {		
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
		} else if($this->input->post('notice_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_resignation_notice_date');
		} else if($this->input->post('resignation_date')==='') {
			 $Return['error'] = $this->lang->line('xin_error_resignation_date');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'notice_date' => $this->input->post('notice_date'),
		'resignation_date' => $this->input->post('resignation_date'),
		'reason' => $qt_reason,
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Resignation_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_resignation_added');			
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='resignation') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
		
		if($this->input->post('notice_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_resignation_notice_date');
		} else if($this->input->post('resignation_date')==='') {
			 $Return['error'] = $this->lang->line('xin_error_resignation_date');
		} else if($this->input->post('status')==='') {
			 $Return['error'] = $this->lang->line('xin_error_template_status');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'notice_date' => $this->input->post('notice_date'),
		'resignation_date' => $this->input->post('resignation_date'),
		'status' => $this->input->post('status'),
		'reason' => $qt_reason,
		);
		
		$result = $this->Resignation_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_resignation_updated');
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
		$result = $this->Resignation_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_resignation_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
