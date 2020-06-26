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

class Performance_appraisal extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
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
		if($system[0]->module_performance!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_performance_appraisal');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_performance_appraisal');
		$data['path_url'] = 'performance_appraisal';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('42',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/performance/performance_appraisal_list", $data, TRUE);
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
		
		
		$appraisal = $this->Performance_appraisal_model->get_performance_appraisal();
		
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
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-p_appraisal_id="'. $r->performance_appraisal_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-performance_appraisal_id="'. $r->performance_appraisal_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->performance_appraisal_id . '"><i class="fa fa-trash-o"></i></button></span>',
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
				'customer_experience' => $result[0]->customer_experience,
				'marketing' => $result[0]->marketing,
				'management' => $result[0]->management,
				'administration' => $result[0]->administration,
				'presentation_skill' => $result[0]->presentation_skill,
				'quality_of_work' => $result[0]->quality_of_work,
				'efficiency' => $result[0]->efficiency,
				'integrity' => $result[0]->integrity,
				'professionalism' => $result[0]->professionalism,
				'team_work' => $result[0]->team_work,
				'critical_thinking' => $result[0]->critical_thinking,
				'conflict_management' => $result[0]->conflict_management,
				'attendance' => $result[0]->attendance,
				'ability_to_meet_deadline' => $result[0]->ability_to_meet_deadline,
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
	
		if($this->input->post('add_type')=='appraisal') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
			
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
		'customer_experience' => $this->input->post('customer_experience'),
		'remarks' => $qt_remarks,
		'marketing' => $this->input->post('marketing'),
		'management' => $this->input->post('management'),
		'administration' => $this->input->post('administration'),
		'presentation_skill' => $this->input->post('presentation_skill'),
		'quality_of_work' => $this->input->post('quality_of_work'),
		'efficiency' => $this->input->post('efficiency'),
		'integrity' => $this->input->post('integrity'),
		'professionalism' => $this->input->post('professionalism'),
		'team_work' => $this->input->post('team_work'),
		'critical_thinking' => $this->input->post('critical_thinking'),
		'conflict_management' => $this->input->post('conflict_management'),
		'attendance' => $this->input->post('attendance'),
		'ability_to_meet_deadline' => $this->input->post('ability_to_meet_deadline'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Performance_appraisal_model->add($data);
		if ($result == TRUE) {
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
		$Return = array('result'=>'', 'error'=>'');
			
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
		'customer_experience' => $this->input->post('customer_experience'),
		'remarks' => $qt_remarks,
		'marketing' => $this->input->post('marketing'),
		'management' => $this->input->post('management'),
		'administration' => $this->input->post('administration'),
		'presentation_skill' => $this->input->post('presentation_skill'),
		'quality_of_work' => $this->input->post('quality_of_work'),
		'efficiency' => $this->input->post('efficiency'),
		'integrity' => $this->input->post('integrity'),
		'professionalism' => $this->input->post('professionalism'),
		'team_work' => $this->input->post('team_work'),
		'critical_thinking' => $this->input->post('critical_thinking'),
		'conflict_management' => $this->input->post('conflict_management'),
		'attendance' => $this->input->post('attendance'),
		'ability_to_meet_deadline' => $this->input->post('ability_to_meet_deadline')
		);
		
		$result = $this->Performance_appraisal_model->update_record($data,$id);		
		
		if ($result == TRUE) {
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
		$Return = array('result'=>'', 'error'=>'');
		$id = $this->uri->segment(4);
		$result = $this->Performance_appraisal_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_performance_app_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
