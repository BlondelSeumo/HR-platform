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

class Performance_indicator extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Performance_indicator_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
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
		if($system[0]->module_performance!='yes'){
			redirect('admin/dashboard');
		}
		/*if($system[0]->performance_option!='appraisal'){
			redirect('admin/goal_tracking');
		}*/
		$data['title'] = $this->lang->line('left_performance_indicator').' | '.$this->Xin_model->site_title();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_performance_indicator');
		$data['path_url'] = 'performance_indicator';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('41',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/performance/performance_indicator_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 	
	// get company > designations
	 public function get_designations() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/performance/get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
    public function performance_indicator_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/performance/performance_indicator_list", $data);
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
			$performance = $this->Performance_indicator_model->get_performance_indicator();
		} else {
			if(in_array('301',$role_resources_ids)) {
				$performance = $this->Performance_indicator_model->get_company_performance_indicator($user_info[0]->company_id);
			} else {
				$performance = $this->Performance_indicator_model->get_designation_performance_indicator($user_info[0]->designation_id);
			}
		}
		$data = array();

        foreach($performance->result() as $r) {
			 			  
		// created date
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		// get user > added by
		$user = $this->Xin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
			
		// get designation
		$designation = $this->Designation_model->read_designation_information($r->designation_id);
		if(!is_null($designation)){
			$ides = $designation[0]->designation_name;
			$idepartment = $this->Department_model->read_department_information($designation[0]->department_id);
			if(!is_null($idepartment)){
				$department = $idepartment[0]->department_name;
			} else {
				$department = '--';
			}
		} else {
			$department = '--';	
			$ides = '--';
		}
		// department
		
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		if(in_array('299',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-performance_indicator_id="'. $r->performance_indicator_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('300',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->performance_indicator_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		if(in_array('301',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-p_indicator_id="'. $r->performance_indicator_id . '"><span class="fa fa-eye"></span></button></span>';
		} else {
			$view = '';
		}
		$combhr = $edit.$view.$delete;
		
		$data[] = array(
			$combhr,
			$ides,
			$comp_name,
			$department,
			$full_name,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $performance->num_rows(),
			 "recordsFiltered" => $performance->num_rows(),
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
		$id = $this->input->get('performance_indicator_id');
		$result = $this->Performance_indicator_model->read_performance_indicator_information($id);
		$data = array(
				'performance_indicator_id' => $result[0]->performance_indicator_id,
				'company_id' => $result[0]->company_id,
				'designation_id' => $result[0]->designation_id,
				'all_designations' => $this->Designation_model->all_designations(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/performance/dialog_indicator', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_indicator() {
	
		if($this->input->post('add_type')=='indicator') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('designation_id')==='') {
       		$Return['error'] = $this->lang->line('xin_error_designation_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'company_id' => $this->input->post('company_id'),
		'designation_id' => $this->input->post('designation_id'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Performance_indicator_model->add($data);
		if ($result) {
			foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
				$data_opt = array(
				'indicator_id' => $result,
				'indicator_type' => 'technical',
				'indicator_option_id' => $key,
				'indicator_option_value' => $tech_value,
				);
				$this->Performance_indicator_model->add_indicator_options($data_opt);
			}
			foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
				$data_opt2 = array(
				'indicator_id' => $result,
				'indicator_type' => 'organizational',
				'indicator_option_id' => $ikey,
				'indicator_option_value' => $org_value,
				);
				$this->Performance_indicator_model->add_indicator_options($data_opt2);
			}
			$Return['result'] = $this->lang->line('xin_success_performance_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='indicator') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('designation_id')==='') {
       		$Return['error'] = $this->lang->line('xin_error_designation_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'company_id' => $this->input->post('company_id'),
		'designation_id' => $this->input->post('designation_id'),
		);
		
		$result = $this->Performance_indicator_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
				$row_technical = $this->Performance_indicator_model->read_indicator_technical_options_available($key,$id);
				if($row_technical > 0){
					$data_opt = array(
					'indicator_option_value' => $tech_value,
					);
					$this->Performance_indicator_model->update_indicator_technical_record($key,$data_opt,$id);
				} else {
					$data_opt = array(
					'indicator_id' => $id,
					'indicator_type' => 'technical',
					'indicator_option_id' => $key,
					'indicator_option_value' => $tech_value,
					);
					$this->Performance_indicator_model->add_indicator_options($data_opt);
				}
			}
			foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
				$row_organization = $this->Performance_indicator_model->read_indicator_organizational_options_available($ikey,$id);
				if($row_organization > 0){
					$data_org = array(
					'indicator_option_value' => $org_value,
					);
					$this->Performance_indicator_model->update_indicator_organizational_record($ikey,$data_org,$id);
				} else {
					$data_org = array(
					'indicator_id' => $id,
					'indicator_type' => 'organizational',
					'indicator_option_id' => $ikey,
					'indicator_option_value' => $org_value,
					);
					$this->Performance_indicator_model->add_indicator_options($data_org);
				}
				
			}
			$Return['result'] = $this->lang->line('xin_success_performance_updated');
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
		$result = $this->Performance_indicator_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_performance_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
