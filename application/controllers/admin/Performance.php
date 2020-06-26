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

class Performance extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Performance_appraisal_model");
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
		if($system[0]->performance_option == 'appraisal'):
			$data['title'] = $this->lang->line('left_performance_xappraisal').' | '.$this->Xin_model->site_title();
			$data['breadcrumbs'] = $this->lang->line('left_performance_xappraisal');
			$data['path_url'] = 'performance_appraisal';
		else:
			$data['title'] = $this->lang->line('xin_hr_goal_tracking').' | '.$this->Xin_model->site_title();
			$data['breadcrumbs'] = $this->lang->line('xin_hr_goal_tracking');
			$data['path_url'] = 'performance_goals';
		endif;
		
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('42',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/performance/performance_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function appraisal_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/performance/performance_appraisal_list", $data);
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
			$appraisal = $this->Performance_appraisal_model->get_performance_appraisal();
		} else {
			if(in_array('305',$role_resources_ids)) {
				$appraisal = $this->Performance_appraisal_model->get_company_performance_appraisal($user_info[0]->company_id);
			} else {
				$appraisal = $this->Performance_appraisal_model->get_employee_performance_appraisal($session['user_id']);
			}
		}
		$data = array();

        foreach($appraisal->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Xin_model->read_user_info($r->employee_id);
		// user full name
		if(!is_null($user)){
				
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				// department
				$department = $this->Department_model->read_department_information($user[0]->department_id);
				if(!is_null($department)){
					$department_name = $department[0]->department_name;
				} else {
					$department_name = '--';
				}
				// get designation
				$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
				if(!is_null($designation)){
					$designation_name = $designation[0]->designation_name;
				} else {
					$designation_name = '--';
				}
		} else {
			$full_name = '--';
			$designation_name = '--';
			$department_name = '--';
		}		
		
		 // appraisal month/year
		$d = explode('-',$r->appraisal_year_month);
		$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
		$ap_date = $get_month.', '.$d[0];
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		
		if(in_array('303',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-performance_appraisal_id="'. $r->performance_appraisal_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('304',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->performance_appraisal_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		if(in_array('305',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-p_appraisal_id="'. $r->performance_appraisal_id . '"><span class="fa fa-eye"></span></button></span>';
		} else {
			$view = '';
		}
		$combhr = $edit.$view.$delete;
		
		$data[] = array(
			$combhr,
			$comp_name,
			$full_name,
			$designation_name,
			$department_name,
			$ap_date
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $appraisal->num_rows(),
			 "recordsFiltered" => $appraisal->num_rows(),
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
			$this->load->view("admin/performance/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 public function read() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('performance_appraisal_id');
		$result = $this->Performance_appraisal_model->read_appraisal_information($id);
		$data = array(
				'performance_appraisal_id' => $result[0]->performance_appraisal_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'appraisal_year_month' => $result[0]->appraisal_year_month,
				'remarks' => $result[0]->remarks,
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_employees' => $this->Xin_model->all_employees()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/performance/dialog_appraisal', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_appraisal() {
	
		/*echo '<pre>'; print_r($this->input->post('technical_competencies_value'));
		echo '<pre>'; print_r($this->input->post('organizational_competencies_value'));
		exit;*/
		if($this->input->post('add_type')=='appraisal') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$remarks = $this->input->post('remarks');
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
       		$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_error_performance_app_month_year');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'appraisal_year_month' => $this->input->post('month_year'),
		'remarks' => $qt_remarks,
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Performance_appraisal_model->add($data);
		if ($result) {
			foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
				$data_opt = array(
				'appraisal_id' => $result,
				'appraisal_type' => 'technical',
				'appraisal_option_id' => $key,
				'appraisal_option_value' => $tech_value,
				);
				$this->Performance_appraisal_model->add_appraisal_options($data_opt);
			}
			foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
				$data_opt2 = array(
				'appraisal_id' => $result,
				'appraisal_type' => 'organizational',
				'appraisal_option_id' => $ikey,
				'appraisal_option_value' => $org_value,
				);
				$this->Performance_appraisal_model->add_appraisal_options($data_opt2);
			}
			$Return['result'] = $this->lang->line('xin_success_performance_app_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='appraisal') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$remarks = $this->input->post('remarks');
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
       		$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_error_performance_app_month_year');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'appraisal_year_month' => $this->input->post('month_year'),
		'remarks' => $qt_remarks,
		);
		
		$result = $this->Performance_appraisal_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
				$row_technical = $this->Performance_appraisal_model->read_appraisal_technical_options_available($key,$id);
				if($row_technical > 0){
					$data_opt = array(
					'appraisal_option_value' => $tech_value,
					);
					$this->Performance_appraisal_model->update_appraisal_technical_record($key,$data_opt,$id);
				} else {
					$data_opt = array(
					'appraisal_id' => $id,
					'appraisal_type' => 'technical',
					'appraisal_option_id' => $key,
					'appraisal_option_value' => $tech_value,
					);
					$this->Performance_appraisal_model->add_appraisal_options($data_opt);
				}
			}
			foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
				$row_organization = $this->Performance_appraisal_model->read_appraisal_organizational_options_available($ikey,$id);
				if($row_organization > 0){
					$data_org = array(
					'appraisal_option_value' => $org_value,
					);
					$this->Performance_appraisal_model->update_appraisal_organizational_record($ikey,$data_org,$id);
				} else {
					$data_org = array(
					'appraisal_id' => $id,
					'appraisal_type' => 'organizational',
					'appraisal_option_id' => $ikey,
					'appraisal_option_value' => $org_value,
					);
					$this->Performance_appraisal_model->add_appraisal_options($data_org);
				}
				
			}
			$Return['result'] = $this->lang->line('xin_success_performance_app_updated');
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
		$result = $this->Performance_appraisal_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_performance_app_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
