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

class Employees_last_login extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Employees_model");
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
		$data['title'] = $this->lang->line('left_employees_last_login').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_employees_last_login');
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'employees_last_login';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		if(in_array('22',$role_resources_ids) || $reports_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/last_login/last_login_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
 
    public function last_login_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/last_login/last_login_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		
		if($this->input->get("ihr")=='true'){
			if($this->input->get("company_id")==0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0 && $this->input->get("designation_id")==0){
				$employee = $this->Employees_model->get_employees();
				
			} else if($this->input->get("company_id")!=0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0 && $this->input->get("designation_id")==0){
				$employee = $this->Employees_model->get_company_employees_flt($this->input->get("company_id"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")==0 && $this->input->get("designation_id")==0){
				$employee = $this->Employees_model->get_company_location_employees_flt($this->input->get("company_id"),$this->input->get("location_id"));
				
			} else if($this->input->get("company_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("designation_id")==0){
				$employee = $this->Employees_model->get_company_location_department_employees_flt($this->input->get("company_id"),$this->input->get("location_id"),$this->input->get("department_id"));
				
			} else if($this->input->get("company_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("designation_id")!=0){
				$employee = $this->Employees_model->get_company_location_department_designation_employees_flt($this->input->get("company_id"),$this->input->get("location_id"),$this->input->get("department_id"),$this->input->get("designation_id"));
			}
		} else {
			$user_info = $this->Xin_model->read_user_info($session['user_id']);
			if($user_info[0]->user_role_id==1) {
				$employee = $this->Employees_model->get_employees();
			} else if($reports_to > 0) {
				$employee = $this->Employees_model->get_employees_my_team($session['user_id']);
			} else {
				$employee = $this->Employees_model->get_employees_for_other($user_info[0]->company_id);
			}
			
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		
		$data = array();
		
		foreach($employee->result() as $r) {
						  
		// login date and time
		if($r->last_login_date==''){
			$edate = '-';
			$etime = '-';
		} else {
			$edate = $this->Xin_model->set_date_format($r->last_login_date);
			$last_login =  new DateTime($r->last_login_date);
			$etime = $last_login->format('h:i a');
		}
		// employee link
		//$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('202',$role_resources_ids)) {
			$emp_link = '<a href="'.site_url().'admin/employees/detail/'.$r->user_id.'" data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'">'.$r->employee_id.'</a>';
		} else {
			$emp_link = $r->employee_id;
		}
		// user full name
		$full_name = $r->first_name.' '.$r->last_name;
		// user role
		$role = $this->Xin_model->read_user_role_info($r->user_role_id);
		if(!is_null($role)){
			$role_name = $role[0]->role_name;
		} else {
			$role_name = '--';	
		}
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		/* get status*/
		if($r->is_active==0): $status = '<span class="badge bg-red">'.$this->lang->line('xin_employees_inactive').'</span>';
			elseif($r->is_active==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_employees_active').'</span>';endif;
		// get designation
		$designation = $this->Designation_model->read_designation_information($r->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		// department
		$department = $this->Department_model->read_department_information($r->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		$department_designation = $designation_name.' ('.$department_name.')';
		$employee_name = $full_name.'<br><small class="text-muted"><i>'.$department_designation.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_employees_id').': '.$emp_link.'<i></i></i></small>';
		// last login date and time
		$elast_login = $edate.' '.$etime;
		$data[] = array(
			$employee_name,
			$r->username,
			$comp_name,
			$elast_login,
			$role_name,
			$status
		);
		}
		
		$output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
		}
}
