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

class Employees extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Company_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Custom_fields_model");
		$this->load->model("Assets_model");
		$this->load->model("Training_model");
		$this->load->model("Trainers_model");
		$this->load->library("pagination");
		$this->load->model("Awards_model");
		$this->load->model("Travel_model");
		$this->load->model("Tickets_model");
		$this->load->model("Transfers_model");
		$this->load->model("Promotion_model");
		$this->load->model("Complaints_model");
		$this->load->model("Warning_model");
		$this->load->model("Project_model");
		$this->load->model("Payroll_model");
		$this->load->model("Events_model");
		$this->load->model("Meetings_model");
		$this->load->model('Exin_model');
		$this->load->library('Pdf');
		$this->load->helper('string');
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
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$data['breadcrumbs'] = $this->lang->line('xin_employees');
		if(!in_array('13',$role_resources_ids)) {
			$data['path_url'] = 'myteam_employees';
		} else {
			$data['path_url'] = 'employees';
		}
		
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		if(in_array('13',$role_resources_ids) || $reports_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/employees/employees_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 public function staff_dashboard()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('hr_staff_dashboard_title').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$data['breadcrumbs'] = $this->lang->line('hr_staff_dashboard_title');
		$data['path_url'] = 'employees';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('422',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/employees/staff_dashboard", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	
	// employees directory/hr
	public function hr() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees_directory').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		
		if(in_array('88',$role_resources_ids)) {
			$data['breadcrumbs'] = $this->lang->line('xin_employees_directory');
		} else {
			$data['breadcrumbs'] = $this->lang->line('xin_employees_directory').' - '.$this->lang->line('xin_my_team');
		}
		$data['path_url'] = 'employees_directory';
		
		// init params
        $config = array();
        $limit_per_page = 40;
        $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		if($this->input->post("hrsale_directory")==1){
			if($this->input->post("company_id")==0 && $this->input->post("location_id")==0 && $this->input->post("department_id")==0 && $this->input->post("designation_id")==0){
				$total_records = $this->Employees_model->record_count();
				// get current page records
				$data["results"] = $this->Employees_model->fetch_all_employees($limit_per_page, $page*$limit_per_page);
			} else if($this->input->post("company_id")!=0 && $this->input->post("location_id")==0 && $this->input->post("department_id")==0 && $this->input->post("designation_id")==0){
				$total_records = $this->Employees_model->record_count_company_employees($this->input->post("company_id"));
				// get current page records
				$data["results"] = $this->Employees_model->fetch_all_company_employees_flt($limit_per_page, $page*$limit_per_page,$this->input->post("company_id"));
			} else if($this->input->post("company_id")!=0 && $this->input->post("location_id")!=0 && $this->input->post("department_id")==0 && $this->input->post("designation_id")==0){
				$total_records = $this->Employees_model->record_count_company_location_employees($this->input->post("company_id"),$this->input->post("location_id"));
				// get current page records
				$data["results"] = $this->Employees_model->fetch_all_company_location_employees_flt($limit_per_page, $page*$limit_per_page,$this->input->post("company_id"),$this->input->post("location_id"));
			} else if($this->input->post("company_id")!=0 && $this->input->post("location_id")!=0 && $this->input->post("department_id")!=0 && $this->input->post("designation_id")==0){
				$total_records = $this->Employees_model->record_count_company_location_department_employees($this->input->post("company_id"),$this->input->post("location_id"),$this->input->post("department_id"));
				// get current page records
				$data["results"] = $this->Employees_model->fetch_all_company_location_department_employees_flt($limit_per_page, $page*$limit_per_page,$this->input->post("company_id"),$this->input->post("location_id"),$this->input->post("department_id"));
			} else if($this->input->post("company_id")!=0 && $this->input->post("location_id")!=0 && $this->input->post("department_id")!=0 && $this->input->post("designation_id")!=0){
				$total_records = $this->Employees_model->record_count_company_location_department_designation_employees($this->input->post("company_id"),$this->input->post("location_id"),$this->input->post("department_id"),$this->input->post("designation_id"));
				// get current page records
				$data["results"] = $this->Employees_model->fetch_all_company_location_department_designation_employees_flt($limit_per_page, $page*$limit_per_page,$this->input->post("company_id"),$this->input->post("location_id"),$this->input->post("department_id"),$this->input->post("designation_id"));
			}
		} else {
			if(in_array('88',$role_resources_ids)) {
				$total_records = $this->Employees_model->record_count();
				// get current page records
				$data["results"] = $this->Employees_model->fetch_all_employees($limit_per_page, $page*$limit_per_page);
			} else {
				$total_records = $this->Employees_model->record_count_myteam($session['user_id']);
				// get current page records
				$data["results"] = $this->Employees_model->fetch_all_team_employees($limit_per_page, $page*$limit_per_page);
			}
		}
		$config['base_url'] = site_url() . "admin/employees/hr";
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit_per_page;
		$config["uri_segment"] = 4;
		 
		// custom paging configuration
	   // $config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = FALSE;
		//$config['page_query_string'] = TRUE;
		 
		//$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_records;
		$config['cur_tag_open'] = '&nbsp;<a>';
		$config['cur_tag_close'] = '</a>';
		//$config['next_link'] = '»';
		//$config['prev_link'] = '«';
		 
		$this->pagination->initialize($config);
			 
		// build paging links
		$data["links"] = $this->pagination->create_links();
		//$str_links = $this->pagination->create_links();
		//$data["links"] = explode('&nbsp;',$str_links );
		$data["total_record"] = $total_records;
		// View data according to array.
		
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		if(in_array('88',$role_resources_ids) || $reports_to > 0) {
			$data['subview'] = $this->load->view("admin/employees/directory", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}	  
     } 
 
    public function employees_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employees_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();		
		$system = $this->Xin_model->read_setting_info(1);
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
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
			if($user_info[0]->user_role_id==1) {
				$employee = $this->Employees_model->get_employees();
			} else {
				if(in_array('372',$role_resources_ids)) {
					$employee = $this->Employees_model->get_employees_for_other($user_info[0]->company_id);
				} else if(in_array('373',$role_resources_ids)) {
					$employee = $this->Employees_model->get_employees_for_location($user_info[0]->location_id);
				} else {
					$employee = $this->Employees_model->get_employees_for_location($user_info[0]->location_id);
				}
			}
		}
		
		$data = array();

        foreach($employee->result() as $r) {		  
		
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
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
			// get report to
			$reports_to = $this->Xin_model->read_user_info($r->reports_to);
			// user full name
			if(!is_null($reports_to)){
				$manager_name = $reports_to[0]->first_name.' '.$reports_to[0]->last_name;
			} else {
				$manager_name = '--';	
			}
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
			// location
			$location = $this->Location_model->read_location_information($r->location_id);
			if(!is_null($location)){
			$location_name = $location[0]->location_name;
			} else {
			$location_name = '--';	
			}
			
			
			$department_designation = $designation_name.' ('.$department_name.')';
			/*// get status
			if($r->is_active==0): $status = '<span class="badge badge-pill badge-danger">'.$this->lang->line('xin_employees_inactive').'</span>';
			elseif($r->is_active==1): $status = '<span class="badge badge-pill badge-success">'.$this->lang->line('xin_employees_active').'</span>';endif;*/
			
			if($r->user_id != '1') {
				if(in_array('203',$role_resources_ids)) {
					$del_opt = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$del_opt = '';
				}
			} else {
				$del_opt = '';
			}
			if(in_array('202',$role_resources_ids)) {
				$view_opt = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span>';
			} else {
				$view_opt = '';
			}
			$function = $view_opt.$del_opt.'';
			if($r->wages_type == 1){
				$bsalary = $this->Xin_model->currency_sign($r->basic_salary);
			} else {
				$bsalary = $this->Xin_model->currency_sign($r->daily_wages);
			}
			
			
			if($r->profile_picture!='' && $r->profile_picture!='no file') {
				$ol = '<a href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$r->profile_picture.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			} else {
				if($r->gender=='Male') { 
					$de_file = base_url().'uploads/profile/default_male.jpg';
				 } else {
					$de_file = base_url().'uploads/profile/default_female.jpg';
				 }
				$ol = '<a href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><span class="avatar box-32"><img src="'.$de_file.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			}
			//shift info
			$office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
			if(!is_null($office_shift)){
				$shift = $office_shift[0]->shift_name;
			} else {
				$shift = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('xin_office_shift_not_assigned').'</a>';	
			}			
			if(in_array('202',$role_resources_ids)) {
				$ename = '<a href="'.site_url().'admin/employees/detail/'.$r->user_id.'" class="d-block text-primary">'.$full_name.'</a>'; 
			} else {
				$ename = '<span class="d-block text-primary">'.$full_name.'</span>';
			}
			// 1: salary type
			if($r->wages_type==1){
				$wages_type = $this->lang->line('xin_payroll_basic_salary');
				if($system[0]->is_half_monthly==1){
					$basic_salary = $r->basic_salary / 2;
				} else {
					$basic_salary = $r->basic_salary;
				}
			} else if($r->wages_type==2){
				$wages_type = $this->lang->line('xin_employee_daily_wages');
				$basic_salary = $r->basic_salary;
			} else {
				$wages_type = $this->lang->line('xin_payroll_basic_salary');
				if($system[0]->is_half_monthly==1){
					$basic_salary = $r->basic_salary / 2;
				} else {
					$basic_salary = $r->basic_salary;
				}				
			}
			$basic_salary = $this->Xin_model->currency_sign($basic_salary);
			$employee_name = '<div class="media align-items-center">
			'.$ol.'
			<div class="media-body ml-2">
			  '.$ename.'
			  <div class="text-muted small text-truncate">'.$this->lang->line('xin_e_details_shift').': '.$shift.'</div>';
			  if(in_array('421',$role_resources_ids)) {
				$employee_name .= '<div class="text-muted small text-truncate"><a target="_blank" href="'.site_url('admin/employees/download_profile/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_download_profile_title').'">'.$this->lang->line('xin_download_profile_title').' <i class="fas fa-arrow-circle-right"></i></a></div>';
			  }
			  if(in_array('351',$role_resources_ids)) {
				$employee_name .= '<div class="text-info small text-truncate"><a href="'.site_url('admin/employees/setup_salary/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_salary_title').'">'.$this->lang->line('xin_employee_set_salary').': '.$basic_salary.' <i class="fas fa-arrow-circle-right"></i></a></div><div class="text-success small text-truncate"><a href="'.site_url('admin/employees/setup_salary/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_employee_set_salary').'">'.$this->lang->line('left_payroll').': '.$wages_type.' <i class="fas fa-arrow-circle-right"></i></a></div>';
			  } else {
				  $employee_name .= '<div class="text-info small text-truncate">'.$this->lang->line('xin_employee_set_salary').': '.$basic_salary.'</div><div class="text-success small text-truncate">'.$this->lang->line('left_payroll').': '.$wages_type.'</div>';
			  }
			$employee_name .= '</div>
		  </div>';
			
			$comp_name = '<div class="media align-items-center">
				<div class="media-body flex-truncate">
				  '.$comp_name.'
				  <div class="text-muted small text-truncate">'.$this->lang->line('xin_location').': '.$location_name.'</div>
				  <div class="text-muted small text-truncate">'.$this->lang->line('left_department').': '.$department_name.'</div>
				  <div class="text-muted small text-truncate">'.$this->lang->line('left_designation').': '.$designation_name.'</div>
				</div>
			  </div>';			
			$contact_info = '<i class="fa fa-user text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_username').'"></i> '.$r->username.'<br><i class="fa fa-envelope text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_email').'"></i> '.$r->email.'<br><i class="text-muted fa fa-phone" data-state="primary" data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_contact_number').'"></i> '.$r->contact_no;
			
			// get status
			if($r->is_active==0): $status_btn = 'btn-outline-danger'; $status_title = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status_btn = 'btn-success'; $status_title = $this->lang->line('xin_employees_active'); endif;
			
			$role_status = $role_name.'<br><div class="btn-group" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_change_status').'"><button type="button" class="btn btn-sm md-btn-flat dropdown-toggle '.$status_btn.'" data-toggle="dropdown">'.$status_title.'</button><div class="dropdown-menu"><a class="dropdown-item statusinfo" href="javascript:void(0)" data-status="1" data-user-id="'.$r->user_id.'">'.$this->lang->line('xin_employees_active').'</a><a class="dropdown-item statusinfo" href="javascript:void(0)" data-status="2" data-user-id="'.$r->user_id.'">'.$this->lang->line('xin_employees_inactive').'</a></div></div>';
			$data[] = array(
				$function,
				$r->employee_id,
				$employee_name,
				$comp_name,
				$contact_info,
				$manager_name,
				$role_status,
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
	 public function myteam_employees_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employees_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();		
		$system = $this->Xin_model->read_setting_info(1);
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$employee = $this->Employees_model->get_my_team_employees($session['user_id']);
		
		$data = array();

        foreach($employee->result() as $r) {		  
		
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
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
			// get report to
			$reports_to = $this->Xin_model->read_user_info($r->reports_to);
			// user full name
			if(!is_null($reports_to)){
				$manager_name = $reports_to[0]->first_name.' '.$reports_to[0]->last_name;
			} else {
				$manager_name = '--';	
			}
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
			// location
			$location = $this->Location_model->read_location_information($r->location_id);
			if(!is_null($location)){
			$location_name = $location[0]->location_name;
			} else {
			$location_name = '--';	
			}
			
			
			$department_designation = $designation_name.' ('.$department_name.')';
			// get status
			if($r->is_active==0): $status = '<span class="badge bg-red">'.$this->lang->line('xin_employees_inactive').'</span>';
			elseif($r->is_active==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_employees_active').'</span>';endif;
			
			if($r->user_id != '1') {
				if(in_array('203',$role_resources_ids)) {
					$del_opt = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$del_opt = '';
				}
			} else {
				$del_opt = '';
			}
			if(in_array('202',$role_resources_ids)) {
				$view_opt = ' <span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view_opt = '';
			}
			$function = $view_opt.$del_opt.'';
			if($r->wages_type == 1){
				$bsalary = $this->Xin_model->currency_sign($r->basic_salary);
			} else {
				$bsalary = $this->Xin_model->currency_sign($r->daily_wages);
			}
			
			
			if($r->profile_picture!='' && $r->profile_picture!='no file') {
				$ol = '<a href="javascript:void(0);"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$r->profile_picture.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			} else {
				if($r->gender=='Male') { 
					$de_file = base_url().'uploads/profile/default_male.jpg';
				 } else {
					$de_file = base_url().'uploads/profile/default_female.jpg';
				 }
				$ol = '<a href="javascript:void(0);"><span class="avatar box-32"><img src="'.$de_file.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			}
			//shift info
			$office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
			if(!is_null($office_shift)){
				$shift = $office_shift[0]->shift_name;
			} else {
				$shift = '--';	
			}
			if(in_array('202',$role_resources_ids)) {
				$ename = '<a href="'.site_url().'admin/employees/detail/'.$r->user_id.'" class="d-block text-primary">'.$full_name.'</a>'; 
			} else {
				$ename = '<span class="d-block text-primary">'.$full_name.'</span>';
			}
			$employee_name = '<div class="media align-items-center">
			'.$ol.'
			<div class="media-body ml-2">
			  '.$ename.'
			  <div class="text-muted small text-truncate">'.$this->lang->line('xin_e_details_shift').': '.$shift.'</div>';
			  if(in_array('421',$role_resources_ids)) {
				$employee_name .= '<div class="text-muted small text-truncate"><a target="_blank" href="'.site_url('admin/employees/download_profile/').$r->user_id.'" class="text-muted">'.$this->lang->line('xin_download_profile_title').' <i class="fas fa-arrow-circle-right"></i></a></div>';
			  }
			$employee_name .= '</div>
		  </div>';
			
			$comp_name = '<div class="media align-items-center">
				<div class="media-body flex-truncate">
				  '.$comp_name.'
				  <div class="text-muted small text-truncate">'.$this->lang->line('xin_location').': '.$location_name.'</div>
				  <div class="text-muted small text-truncate">'.$this->lang->line('left_department').': '.$department_name.'</div>
				  <div class="text-muted small text-truncate">'.$this->lang->line('left_designation').': '.$designation_name.'</div>
				</div>
			  </div>';			
			$contact_info = '<i class="fa fa-user text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_username').'"></i> '.$r->username.'<br><i class="fa fa-envelope text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_email').'"></i> '.$r->email.'<br><i class="text-muted fa fa-phone" data-state="primary" data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_contact_number').'"></i> '.$r->contact_no;
			
			// get status
			if($r->is_active==0): $status_btn = 'btn-outline-danger'; $status_title = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status_btn = 'btn-success'; $status_title = $this->lang->line('xin_employees_active'); endif;
			$role_status = $role_name.'<br>'.$status_title;
			$data[] = array(
				$function,
				$r->employee_id,
				$employee_name,
				$comp_name,
				$contact_info,
				$manager_name,
				$role_status,
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
	 
	 public function download_profile(){
		$system = $this->Xin_model->read_setting_info(1);		
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$key = $this->uri->segment(4);
		$user = $this->Xin_model->read_user_info($key);
		if(is_null($user)){
			redirect('admin/employees');
		}
		if(!in_array('421',$role_resources_ids)) {
			redirect('admin/employees');
		}
		
		$_des_name = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($_des_name)){
			$_designation_name = $_des_name[0]->designation_name;
		} else {
			$_designation_name = '';
		}
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$_department_name = $department[0]->department_name;
		} else {
			$_department_name = '';
		}
		$fname = $user[0]->first_name.' '.$user[0]->last_name;
		// company info
		$company = $this->Xin_model->read_company_info($user[0]->company_id);
		if(!is_null($company)){
		  $company_name = $company[0]->name;
		  $address_1 = $company[0]->address_1;
		  $address_2 = $company[0]->address_2;
		  $city = $company[0]->city;
		  $state = $company[0]->state;
		  $zipcode = $company[0]->zipcode;
		  $country = $this->Xin_model->read_country_info($company[0]->country);
		  if(!is_null($country)){
			  $country_name = $country[0]->country_name;
		  } else {
			  $country_name = '--';
		  }
		  $c_info_email = $company[0]->email;
		  $c_info_phone = $company[0]->contact_number;
		} else {
		  $company_name = '--';
		  $address_1 = '--';
		  $address_2 = '--';
		  $city = '--';
		  $state = '--';
		  $zipcode = '--';
		  $country_name = '--';
		  $c_info_email = '--';
		  $c_info_phone = '--';
		}
		$location = $this->Location_model->read_location_information($user[0]->location_id);
		if(!is_null($location)){
			$location_name = $location[0]->location_name;
		} else {
			$location_name = '--';
		}
		$user_role = $this->Roles_model->read_role_information($user[0]->user_role_id);
		if(!is_null($user_role)){
			$iuser_role = $user_role[0]->role_name;
		} else {
			$iuser_role = '--';
		}
		// set default header data
		//$c_info_address = $address_1.' '.$address_2.', '.$city.' - '.$zipcode.', '.$country_name;
		$c_info_address = $address_1.' '.$address_2.', '.$city.' - '.$zipcode;
		//$email_phone_address = "$c_info_address \n".$this->lang->line('xin_phone')." : $c_info_phone | ".$this->lang->line('dashboard_email')." : $c_info_email ";
		
		$company_info = $this->lang->line('left_company').": $company_name | ".$this->lang->line('left_location').": $location_name \n";
		$designation_info = $this->lang->line('left_department').": $_department_name | ".$this->lang->line('left_designation').": $_designation_name \n";
		
		$header_string = "$company_info"."$designation_info";
		// set document information
		$pdf->SetCreator('HRSALE');
		$pdf->SetAuthor('HRSALE');
		//$pdf->SetTitle('Workable-Zone - Payslip');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {
			$ol = 'uploads/profile/'.$user[0]->profile_picture;
		} else {
			if($user[0]->gender=='Male') { 
				$de_file = 'uploads/profile/default_male.jpg';
			 } else {
				$de_file = 'uploads/profile/default_female.jpg';
			 }
			$ol = $de_file;
		}
		
		$header_namae = $fname.' '.$this->lang->line('xin_profile');
		$pdf->SetHeaderData('../../../'.$ol, 15, $header_namae, $header_string);
			
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		
		// set margins
		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);
		
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor('HRSALE');
		$pdf->SetTitle($company_name.' - '.$this->lang->line('xin_download_profile_title'));
		$pdf->SetSubject($this->lang->line('xin_download_profile_title'));
		$pdf->SetKeywords($this->lang->line('xin_download_profile_title'));
		// set font
		$pdf->SetFont('helvetica', 'B', 10);
				
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		
		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 10, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
		/*$tbl = '<br>
		<table cellpadding="1" cellspacing="1" border="0">
			<tr>
				<td align="center"><h1>'.$fname.'</h1></td>
			</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');*/
		// -----------------------------------------------------------------------------
		$date_of_joining = $this->Xin_model->set_date_format($user[0]->date_of_joining);
		
		// set cell padding
		$pdf->setCellPaddings(1, 1, 1, 1);
		
		// set cell margins
		$pdf->setCellMargins(0, 0, 0, 0);
		
		// set color for background
		$pdf->SetFillColor(255, 255, 127);
		/////////////////////////////////////////////////////////////////////////////////
		if($user[0]->marital_status=='Single') {
			$mstatus = $this->lang->line('xin_status_single');
		} else if($user[0]->marital_status=='Married') {
			$mstatus = $this->lang->line('xin_status_married');
		} else if($user[0]->marital_status=='Widowed') {
			$mstatus = $this->lang->line('xin_status_widowed');
		} else if($user[0]->marital_status=='Divorced or Separated') {
			$mstatus = $this->lang->line('xin_status_divorced_separated');
		} else {
			$mstatus = $this->lang->line('xin_status_single');
		}
		if($user[0]->is_active=='0') {
			$isactive = $this->lang->line('xin_employees_inactive');
		} else if($user[0]->is_active=='1') {
			$isactive = $this->lang->line('xin_employees_active');
		} else {
			$isactive = $this->lang->line('xin_employees_inactive');
		}
		$tbl_2 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0" >
			<td colspan="6"><strong>'.$this->lang->line('xin_e_details_basic').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('dashboard_username').'</td>
				<td colspan="2">'.$user[0]->username.'</td>
				<td>'.$this->lang->line('dashboard_email').'</td>
				<td colspan="2">'.$user[0]->email.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('dashboard_employee_id').'</td>
				<td colspan="2">'.$user[0]->employee_id.'</td>
				<td>'.$this->lang->line('xin_employee_role').'</td>
				<td colspan="2">'.$iuser_role.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('dashboard_xin_status').'</td>
				<td>'.$isactive.'</td>
				<td>'.$this->lang->line('xin_employee_gender').'</td>
				<td>'.$user[0]->gender.'</td>
				<td>'.$this->lang->line('xin_employee_mstatus').'</td>
				<td>'.$mstatus.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_employee_doj').'</td>
				<td colspan="2">'.$date_of_joining.'</td>
				<td>'.$this->lang->line('dashboard_contact').'#</td>
				<td colspan="2">'.$user[0]->contact_no.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_state').'</td>
				<td>'.$user[0]->state.'</td>
				<td>'.$this->lang->line('xin_city').'</td>
				<td>'.$user[0]->city.'</td>
				<td>'.$this->lang->line('xin_zipcode').'</td>
				<td>'.$user[0]->zipcode.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_employee_address').'</td>
				<td colspan="5">'.$user[0]->address.'</td>
			</tr>
		</table>';
		$pdf->writeHTML($tbl_2, true, false, false, false, '');
		//salary
		if($user[0]->wages_type==1){
			$salary_opt = $this->lang->line('xin_payroll_basic_salary');
		} else {
			$salary_opt = $this->lang->line('xin_employee_daily_wages');
		}
		$tbl_3 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="4"><strong>'.$this->lang->line('xin_salary_title').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_salary_title').'</td>
				<td>'.$this->Xin_model->currency_sign($user[0]->basic_salary).'</td>
				<td>'.$this->lang->line('xin_employee_type_wages').'</td>
				<td>'.$salary_opt.'</td>
			</tr>
			</table>';
			$pdf->writeHTML($tbl_3, true, false, false, false, '');
		//CORE HR
		// awards
		$count_awards = $this->Xin_model->get_employee_awards_count($user[0]->user_id);
		if($count_awards > 0) {
		$tbl_4 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="3"><strong>'.$this->lang->line('left_awards').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_award_name').'</td>
				<td>'.$this->lang->line('xin_gift').'</td>
				<td>'.$this->lang->line('xin_award_month_year').'</td>
			</tr>';
			$award = $this->Awards_model->get_employee_awards($user[0]->user_id);
			foreach($award->result() as $r) {
				// get award type
				$award_type = $this->Awards_model->read_award_type_information($r->award_type_id);
				if(!is_null($award_type)){
					$award_type = $award_type[0]->award_type;
				} else {
					$award_type = '--';	
				}
				$d = explode('-',$r->award_month_year);
				$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
				$award_date = $get_month.', '.$d[0];
				// get currency
				if($r->cash_price == '') {
					$currency = $this->Xin_model->currency_sign(0);
				} else {
					$currency = $this->Xin_model->currency_sign($r->cash_price);
				}
			$tbl_4 .= '
			<tr>
				<td>'.$award_type.'</td>
				<td>'.$r->gift_item.'</td>
				<td>'.$award_date.'</td>
			</tr>';
			}
			$tbl_4 .= '</table>';
			$pdf->writeHTML($tbl_4, true, false, false, false, '');
		}
		// TRAINING
		$count_training = $this->Xin_model->get_employee_training_count($user[0]->user_id);
		if($count_training > 0) {
		$tbl_5 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="4"><strong>'.$this->lang->line('left_training').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('left_training_type').'</td>
				<td>'.$this->lang->line('xin_trainer').'</td>
				<td>'.$this->lang->line('xin_training_duration').'</td>
				<td>'.$this->lang->line('xin_cost').'</td>
			</tr>';
			$training = $this->Training_model->get_employee_training($user[0]->user_id);
			foreach($training->result() as $tr_in) {
				// get training type
				$type = $this->Training_model->read_training_type_information($tr_in->training_type_id);
				if(!is_null($type)){
					$itype = $type[0]->type;
				} else {
					$itype = '--';	
				}
				// get trainer
				$trainer = $this->Xin_model->read_user_info($tr_in->trainer_id);
				// employee full name
				if(!is_null($trainer)){
					$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
				} else {
					$trainer_name = '--';	
				}
				// get end date
				$finish_date = $this->Xin_model->set_date_format($tr_in->finish_date);
				if($tr_in->training_status==0):
					$training_status = $this->lang->line('xin_pending');
				elseif($tr_in->training_status==1):
					$training_status = $this->lang->line('xin_started');
				elseif($tr_in->training_status==2):
					$training_status = $this->lang->line('xin_completed');
				else:
					$training_status = $this->lang->line('xin_terminated');
				endif;
			$tbl_5 .= '
			<tr>
				<td>'.$itype.'</td>
				<td>'.$trainer_name.'</td>
				<td>'.$finish_date.'</td>
				<td>'.$training_status.'</td>
			</tr>';
			}
			$tbl_5 .= '</table>';
			$pdf->writeHTML($tbl_5, true, false, false, false, '');
		}
		// warning
		$count_warning = $this->Xin_model->get_employee_warning_count($user[0]->user_id);
		if($count_warning > 0) {
		$tbl_5 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="4"><strong>'.$this->lang->line('left_warnings').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_subject').'</td>
				<td>'.$this->lang->line('xin_warning_type').'</td>
				<td>'.$this->lang->line('xin_warning_date').'</td>
				<td>'.$this->lang->line('xin_warning_by').'</td>
			</tr>';
			$warning = $this->Warning_model->get_employee_warning($user[0]->user_id);
			foreach($warning->result() as $wr) {
				// get warning date
				$warning_date = $this->Xin_model->set_date_format($wr->warning_date);
				// get warning type
				$warning_type = $this->Warning_model->read_warning_type_information($wr->warning_type_id);
				if(!is_null($warning_type)){
					$wtype = $warning_type[0]->type;
				} else {
					$wtype = '--';	
				}
				// get user > warning by
				$user_by = $this->Xin_model->read_user_info($wr->warning_by);
				// user full name
				if(!is_null($user_by)){
					$warning_by = $user_by[0]->first_name.' '.$user_by[0]->last_name;
				} else {
					$warning_by = '--';	
				}
			$tbl_5 .= '
			<tr>
				<td>'.$wr->subject.'</td>
				<td>'.$wtype.'</td>
				<td>'.$warning_date.'</td>
				<td>'.$warning_by.'</td>
			</tr>';
			}
			$tbl_5 .= '</table>';
			$pdf->writeHTML($tbl_5, true, false, false, false, '');
		}
		// travel
		$travel_count = $this->Xin_model->get_employee_travel_count($user[0]->user_id);
		if($travel_count > 0) {
		$tbl_6 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('xin_travel').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_visit_place').'</td>
				<td colspan="2">'.$this->lang->line('xin_budget_title').'</td>
				<td>'.$this->lang->line('dashboard_xin_status').'</td>
				<td>'.$this->lang->line('xin_end_date').'</td>
			</tr>';
			$travel = $this->Travel_model->get_employee_travel($user[0]->user_id);
			foreach($travel->result() as $trv) {
				// get warning date
				//$warning_date = $this->Xin_model->set_date_format($trv->warning_date);
				if($trv->status==0):
					$status = $this->lang->line('xin_pending');
				elseif($trv->status==1):
					$status = $this->lang->line('xin_accepted');
				else:
					$status = $this->lang->line('xin_rejected');
				endif;
			$expected_budget = $this->Xin_model->currency_sign($trv->expected_budget);
			$actual_budget = $this->Xin_model->currency_sign($trv->actual_budget);	
			$t_budget= $this->lang->line('xin_expected_travel_budget').': '.$expected_budget.'<br>'.$this->lang->line('xin_actual_travel_budget').': '.$expected_budget;
			// get end date
			$end_date = $this->Xin_model->set_date_format($trv->end_date);
			$tbl_6 .= '
			<tr>
				<td>'.$trv->visit_place.'</td>
				<td colspan="2">'.$t_budget.'</td>
				<td>'.$status.'</td>
				<td>'.$end_date.'</td>
			</tr>';
			}
			$tbl_6 .= '</table>';
			$pdf->writeHTML($tbl_6, true, false, false, false, '');
		}
		
		// tickets
		$tickets_count = $this->Xin_model->get_employee_tickets_count($user[0]->user_id);
		if($tickets_count > 0) {
		$tbl_7 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('left_tickets').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_ticket_code').'</td>
				<td>'.$this->lang->line('xin_subject').'</td>
				<td>'.$this->lang->line('xin_p_priority').'</td>
				<td  colspan="2">'.$this->lang->line('xin_e_details_date').'</td>
			</tr>';
			$ticket = $this->Tickets_model->get_employee_tickets($user[0]->user_id);
			foreach($ticket->result() as $tkts) {
				
				if($tkts->ticket_priority==0):
					$ticket_priority = $this->lang->line('xin_low');
				elseif($tkts->ticket_priority==2):
					$ticket_priority = $this->lang->line('xin_medium');
				elseif($tkts->ticket_priority==3):
					$ticket_priority = $this->lang->line('xin_high');
				elseif($tkts->ticket_priority==4):
					$ticket_priority = $this->lang->line('xin_critical');	
				else:
					$ticket_priority = $this->lang->line('xin_low');
				endif;
			if($tkts->ticket_status==1):
				$status = $this->lang->line('xin_open');
			else:
				$status = $this->lang->line('xin_closed');
			endif;			
			
			// ticket_code
			$iticket_code = $tkts->ticket_code.'<br>'.$status;
			$created_at = date('h:i A', strtotime($tkts->created_at));
			$_date = explode(' ',$tkts->created_at);
			$edate = $this->Xin_model->set_date_format($_date[0]);
			$_created_at = $edate. ' '. $created_at;
							 
			$tbl_7 .= '
			<tr>
				<td>'.$iticket_code.'</td>
				<td>'.$tkts->subject.'</td>
				<td>'.$ticket_priority.'</td>
				<td colspan="2">'.$_created_at.'</td>
			</tr>';
			}
			$tbl_7 .= '</table>';
			$pdf->writeHTML($tbl_7, true, false, false, false, '');
		}
		
		// projects
		$projects_count = $this->Xin_model->get_employee_projects_count($user[0]->user_id);
		if($projects_count > 0) {
		$tbl_8 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('left_projects').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('dashboard_xin_title').'</td>
				<td>'.$this->lang->line('dashboard_xin_progress').'</td>
				<td>'.$this->lang->line('xin_end_date').'</td>
				<td  colspan="2">'.$this->lang->line('dashboard_xin_status').'</td>
			</tr>';
			$project = $this->Project_model->get_employee_projects($user[0]->user_id);
			foreach($project->result() as $prj) {
					
			if($prj->status == 0) {
					$status = $this->lang->line('xin_not_started');
				} else if($prj->status ==1){
					$status = $this->lang->line('xin_in_progress');
				} else if($prj->status ==2){
					$status = $this->lang->line('xin_completed');
				} else {
					$status = $this->lang->line('xin_deffered');
				}	
				
				$pdate = $this->Xin_model->set_date_format($prj->end_date);
								 
				$tbl_8 .= '
				<tr>
					<td>'.$prj->title.'</td>
					<td>'.$prj->project_progress.'% '.$this->lang->line('xin_completed').'</td>
					<td>'.$pdate.'</td>
					<td colspan="2">'.$status.'</td>
				</tr>';
			}
			$tbl_8 .= '</table>';
			$pdf->writeHTML($tbl_8, true, false, false, false, '');
		}
		// tasks
		$tasks_count = $this->Xin_model->get_employee_tasks_count($user[0]->user_id);
		if($tasks_count > 0) {
		$tbl_9 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('left_tasks').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('dashboard_xin_title').'</td>
				<td>'.$this->lang->line('dashboard_xin_progress').'</td>
				<td>'.$this->lang->line('xin_end_date').'</td>
				<td  colspan="2">'.$this->lang->line('dashboard_xin_status').'</td>
			</tr>';
			$task = $this->Timesheet_model->get_employee_tasks($user[0]->user_id);
			foreach($task->result() as $tsk) {
					
				// task end date
				$tdate = $this->Xin_model->set_date_format($tsk->end_date);							
				// task status
				if($tsk->task_status == 0) {
					$status = $this->lang->line('xin_not_started');
				} else if($tsk->task_status ==1){
					$status = $this->lang->line('xin_in_progress');
				} else if($tsk->task_status ==2){
					$status = $this->lang->line('xin_completed');
				} else {
					$status = $this->lang->line('xin_deffered');
				}
								 
				$tbl_9 .= '
				<tr>
					<td>'.$tsk->task_name.'</td>
					<td>'.$tsk->task_progress.'% '.$this->lang->line('xin_completed').'</td>
					<td>'.$tdate.'</td>
					<td colspan="2">'.$status.'</td>
				</tr>';
			}
			$tbl_9 .= '</table>';
			$pdf->writeHTML($tbl_9, true, false, false, false, '');
		}
		// assets
		$assets_count = $this->Xin_model->get_employee_assets_count($user[0]->user_id);
		if($assets_count > 0) {
		$tbl_10 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('xin_assets').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_asset_name').'</td>
				<td>'.$this->lang->line('xin_acc_category').'</td>
				<td colspan="2">'.$this->lang->line('xin_company_asset_code').'</td>
				<td>'.$this->lang->line('xin_is_working').'</td>
			</tr>';
			$assets = $this->Assets_model->get_employee_assets($user[0]->user_id);
			foreach($assets->result() as $asts) {
					
				// get category
				$assets_category = $this->Assets_model->read_assets_category_info($asts->assets_category_id);
				if(!is_null($assets_category)){
					$category = $assets_category[0]->category_name;
				} else {
					$category = '--';	
				}		
				//working?
				if($asts->is_working==1){
					$working = $this->lang->line('xin_yes');
				} else {
					$working = $this->lang->line('xin_no');
				}
								 
				$tbl_10 .= '
				<tr>
					<td>'.$asts->name.'</td>
					<td>'.$category.'</td>
					<td colspan="2">'.$asts->company_asset_code.'</td>
					<td>'.$working.'</td>
				</tr>';
			}
			$tbl_10 .= '</table>';
			$pdf->writeHTML($tbl_10, true, false, false, false, '');
		}
		// meetings
		$meetings_count = $this->Xin_model->get_employee_meetings_count($user[0]->user_id);
		if($meetings_count > 0) {
		$tbl_11 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="3"><strong>'.$this->lang->line('xin_hr_meetings').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_hr_meeting_title').'</td>
				<td>'.$this->lang->line('xin_hr_meeting_date').'</td>
				<td>'.$this->lang->line('xin_hr_meeting_time').'</td>
			</tr>';
			$meetings = $this->Meetings_model->get_employee_meetings($user[0]->user_id);
			foreach($meetings->result() as $meetings_hr) {
					
				// get start date and end date
				 $meeting_date = $this->Xin_model->set_date_format($meetings_hr->meeting_date);	
				 $meeting_time = new DateTime($meetings_hr->meeting_time);
				 $metime = $meeting_time->format('h:i a');
								 
				$tbl_11 .= '
				<tr>
					<td>'.$meetings_hr->meeting_title.'</td>
					<td>'.$meeting_date.'</td>
					<td>'.$metime.'</td>
				</tr>';
			}
			$tbl_11 .= '</table>';
			$pdf->writeHTML($tbl_11, true, false, false, false, '');
		}
		// events
		$events_count = $this->Xin_model->get_employee_events_count($user[0]->user_id);
		if($events_count > 0) {
		$tbl_12 = '
		<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="3"><strong>'.$this->lang->line('xin_hr_events').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_hr_event_title').'</td>
				<td>'.$this->lang->line('xin_hr_event_date').'</td>
				<td>'.$this->lang->line('xin_hr_event_time').'</td>
			</tr>';
			$events = $this->Events_model->get_employee_events($user[0]->user_id);
			foreach($events->result() as $events_hr) {
					
				// get start date and end date
				 $sdate = $this->Xin_model->set_date_format($events_hr->event_date);
				 // get time am/pm
			 	$event_time = new DateTime($events_hr->event_time);
				$etime = $event_time->format('h:i a');
								 
				$tbl_12 .= '
				<tr>
					<td>'.$events_hr->event_title.'</td>
					<td>'.$sdate.'</td>
					<td>'.$etime.'</td>
				</tr>';
			}
			$tbl_12 .= '</table>';
			$pdf->writeHTML($tbl_12, true, false, false, false, '');
		}
		
		
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y"));
		//Close and output PDF document
		ob_start();
		$pdf->Output('payslip_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
		 
	 }
	 
	 public function employees_cards_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employees_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$employee = $this->Employees_model->get_employees();
		$countries = $this->Xin_model->get_countries();
		
		$data = array();
		$function = '<table>';
        foreach (array_chunk($countries, 4) as $row) {		  
			$function .= '<tr>';
			foreach ($row as $value) {
				$function .='<td>
        <div class="col-xl-12 col-md-12 col-xs-12">
                    <div class="card">
                        <div class="text-xs-center">
                            <div class="card-block">
                                <img src="'.base_url().'skin/app-assets/images/portrait/medium/avatar-m-4.png" class="rounded-circle  height-150" alt="Card image">
                            </div>
                            <div class="card-block">
                                <h4 class="card-title">asddd</h4>
                                <h6 class="card-subtitle text-muted">asddd</h6>
                            </div>
                            <div class="text-xs-center">
                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="fa fa-twitter"></span></a>
                                <a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin"><span class="fa fa-linkedin font-medium-4"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                </td>';	
				$function .='</tr>';
			}	
				$data[] = array(
					$function
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
	 
	  public function detail() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$result = $this->Employees_model->read_employee_information($id);
		if(is_null($result)){
			redirect('admin/employees');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);
		if(!in_array('202',$role_resources_ids)) {
			redirect('admin/employees');
		}
		/*if($check_role[0]->user_id!=$result[0]->user_id) {
			redirect('admin/employees');
		}*/
		
		//$role_resources_ids = $this->Xin_model->user_role_resource();
		//$data['breadcrumbs'] = $this->lang->line('xin_employee_details');
		//$data['path_url'] = 'employees_detail';	

		$data = array(
			'breadcrumbs' => $this->lang->line('xin_employee_detail'),
			'path_url' => 'employees_detail',
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'user_id' => $result[0]->user_id,
			'employee_id' => $result[0]->employee_id,
			'company_id' => $result[0]->company_id,
			'location_id' => $result[0]->location_id,
			'office_shift_id' => $result[0]->office_shift_id,
			'ereports_to' => $result[0]->reports_to,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			'department_id' => $result[0]->department_id,
			'sub_department_id' => $result[0]->sub_department_id,
			'designation_id' => $result[0]->designation_id,
			'user_role_id' => $result[0]->user_role_id,
			'date_of_birth' => $result[0]->date_of_birth,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'gender' => $result[0]->gender,
			'marital_status' => $result[0]->marital_status,
			'contact_no' => $result[0]->contact_no,
			'state' => $result[0]->state,
			'city' => $result[0]->city,
			'zipcode' => $result[0]->zipcode,
			'blood_group' => $result[0]->blood_group,
			'citizenship_id' => $result[0]->citizenship_id,
			'nationality_id' => $result[0]->nationality_id,
			'iethnicity_type' => $result[0]->ethnicity_type,
			'address' => $result[0]->address,
			'wages_type' => $result[0]->wages_type,
			'basic_salary' => $result[0]->basic_salary,
			'is_active' => $result[0]->is_active,
			'date_of_joining' => $result[0]->date_of_joining,
			'all_departments' => $this->Department_model->all_departments(),
			'all_designations' => $this->Designation_model->all_designations(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('xin_employee_detail').' | '.$this->Xin_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'leave_categories' => $result[0]->leave_categories,
			'view_companies_id' => $result[0]->view_companies_id,
			'all_countries' => $this->Xin_model->get_countries(),
			'all_document_types' => $this->Employees_model->all_document_types(),
			'all_education_level' => $this->Employees_model->all_education_level(),
			'all_qualification_language' => $this->Employees_model->all_qualification_language(),
			'all_qualification_skill' => $this->Employees_model->all_qualification_skill(),
			'all_contract_types' => $this->Employees_model->all_contract_types(),
			'all_contracts' => $this->Employees_model->all_contracts(),
			'all_office_shifts' => $this->Employees_model->all_office_shifts(),
			'get_all_companies' => $this->Xin_model->get_companies(),
			'all_office_locations' => $this->Location_model->all_office_locations(),
			'all_leave_types' => $this->Timesheet_model->all_leave_types(),
			'all_countries' => $this->Xin_model->get_countries()
			);
		
		$data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 public function setup_salary() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$result = $this->Employees_model->read_employee_information($id);
		if(is_null($result)){
			redirect('admin/employees');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);
		if(!in_array('351',$role_resources_ids)) {
			redirect('admin/employees');
		}
		/*if($check_role[0]->user_id!=$result[0]->user_id) {
			redirect('admin/employees');
		}*/
		
		//$role_resources_ids = $this->Xin_model->user_role_resource();
		//$data['breadcrumbs'] = $this->lang->line('xin_employee_details');
		//$data['path_url'] = 'employees_detail';	

		$data = array(
			'breadcrumbs' => $this->lang->line('xin_employee_set_salary'),
			'path_url' => 'setup_salary',
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'user_id' => $result[0]->user_id,
			'employee_id' => $result[0]->employee_id,
			'company_id' => $result[0]->company_id,
			'location_id' => $result[0]->location_id,
			'office_shift_id' => $result[0]->office_shift_id,
			'ereports_to' => $result[0]->reports_to,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			'department_id' => $result[0]->department_id,
			'sub_department_id' => $result[0]->sub_department_id,
			'designation_id' => $result[0]->designation_id,
			'user_role_id' => $result[0]->user_role_id,
			'date_of_birth' => $result[0]->date_of_birth,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'gender' => $result[0]->gender,
			'marital_status' => $result[0]->marital_status,
			'contact_no' => $result[0]->contact_no,
			'state' => $result[0]->state,
			'city' => $result[0]->city,
			'zipcode' => $result[0]->zipcode,
			'blood_group' => $result[0]->blood_group,
			'citizenship_id' => $result[0]->citizenship_id,
			'nationality_id' => $result[0]->nationality_id,
			'iethnicity_type' => $result[0]->ethnicity_type,
			'address' => $result[0]->address,
			'wages_type' => $result[0]->wages_type,
			'basic_salary' => $result[0]->basic_salary,
			'is_active' => $result[0]->is_active,
			'date_of_joining' => $result[0]->date_of_joining,
			'all_departments' => $this->Department_model->all_departments(),
			'all_designations' => $this->Designation_model->all_designations(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('xin_employee_detail').' | '.$this->Xin_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'leave_categories' => $result[0]->leave_categories,
			'view_companies_id' => $result[0]->view_companies_id,
			'all_countries' => $this->Xin_model->get_countries(),
			'all_document_types' => $this->Employees_model->all_document_types(),
			'all_education_level' => $this->Employees_model->all_education_level(),
			'all_qualification_language' => $this->Employees_model->all_qualification_language(),
			'all_qualification_skill' => $this->Employees_model->all_qualification_skill(),
			'all_contract_types' => $this->Employees_model->all_contract_types(),
			'all_contracts' => $this->Employees_model->all_contracts(),
			'all_office_shifts' => $this->Employees_model->all_office_shifts(),
			'get_all_companies' => $this->Xin_model->get_companies(),
			'all_office_locations' => $this->Location_model->all_office_locations(),
			'all_leave_types' => $this->Timesheet_model->all_leave_types(),
			'all_countries' => $this->Xin_model->get_countries()
			);
		
		$data['subview'] = $this->load->view("admin/employees/setup_employee_salary", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
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
			$this->load->view("admin/employees/get_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 
	/* // get location > departments
	 public function get_company_elocations() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'location_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_company_elocations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } */
	 
	public function dialog_contact() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_contact_information($id);
		$data = array(
			'contact_id' => $result[0]->contact_id,
			'employee_id' => $result[0]->employee_id,
			'relation' => $result[0]->relation,
			'is_primary' => $result[0]->is_primary,
			'is_dependent' => $result[0]->is_dependent,
			'contact_name' => $result[0]->contact_name,
			'work_phone' => $result[0]->work_phone,
			'work_phone_extension' => $result[0]->work_phone_extension,
			'mobile_phone' => $result[0]->mobile_phone,
			'home_phone' => $result[0]->home_phone,
			'work_email' => $result[0]->work_email,
			'personal_email' => $result[0]->personal_email,
			'address_1' => $result[0]->address_1,
			'address_2' => $result[0]->address_2,
			'city' => $result[0]->city,
			'state' => $result[0]->state,
			'zipcode' => $result[0]->zipcode,
			'icountry' => $result[0]->country,
			'all_countries' => $this->Xin_model->get_countries()
		);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	 // get company > locations
	 public function get_company_elocations() {

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
				$this->load->view("admin/employees/get_company_elocations", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	  // get company > office shifts
	 public function get_company_office_shifts() {

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
				$this->load->view("admin/employees/get_company_office_shifts", $data);
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
				'location_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/employees/get_location_departments", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	public function dialog_document() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Employees_model->read_document_information($id);
		$data = array(
				'document_id' => $document[0]->document_id,
				'document_type_id' => $document[0]->document_type_id,
				'd_employee_id' => $document[0]->employee_id,
				'all_document_types' => $this->Employees_model->all_document_types(),
				'date_of_expiry' => $document[0]->date_of_expiry,
				'title' => $document[0]->title,
				//'is_alert' => $document[0]->is_alert,
				'description' => $document[0]->description,
				//'notification_email' => $document[0]->notification_email,
				'document_file' => $document[0]->document_file
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_imgdocument() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Employees_model->read_imgdocument_information($id);
		$data = array(
				'immigration_id' => $document[0]->immigration_id,
				'document_type_id' => $document[0]->document_type_id,
				'd_employee_id' => $document[0]->employee_id,
				'all_document_types' => $this->Employees_model->all_document_types(),
				'all_countries' => $this->Xin_model->get_countries(),
				'document_number' => $document[0]->document_number,
				'document_file' => $document[0]->document_file,
				'issue_date' => $document[0]->issue_date,
				'expiry_date' => $document[0]->expiry_date,
				'country_id' => $document[0]->country_id,
				'eligible_review_date' => $document[0]->eligible_review_date,
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_qualification() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_qualification_information($id);
		$data = array(
				'qualification_id' => $result[0]->qualification_id,
				'employee_id' => $result[0]->employee_id,
				'name' => $result[0]->name,
				'education_level_id' => $result[0]->education_level_id,
				'from_year' => $result[0]->from_year,
				'language_id' => $result[0]->language_id,
				'to_year' => $result[0]->to_year,
				'skill_id' => $result[0]->skill_id,
				'description' => $result[0]->description,
				'all_education_level' => $this->Employees_model->all_education_level(),
				'all_qualification_language' => $this->Employees_model->all_qualification_language(),
				'all_qualification_skill' => $this->Employees_model->all_qualification_skill()
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	public function dialog_work_experience() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_work_experience_information($id);
		$data = array(
				'work_experience_id' => $result[0]->work_experience_id,
				'employee_id' => $result[0]->employee_id,
				'company_name' => $result[0]->company_name,
				'from_date' => $result[0]->from_date,
				'to_date' => $result[0]->to_date,
				'post' => $result[0]->post,
				'description' => $result[0]->description
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_bank_account() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_bank_account_information($id);
		$data = array(
				'bankaccount_id' => $result[0]->bankaccount_id,
				'employee_id' => $result[0]->employee_id,
				'is_primary' => $result[0]->is_primary,
				'account_title' => $result[0]->account_title,
				'account_number' => $result[0]->account_number,
				'bank_name' => $result[0]->bank_name,
				'bank_code' => $result[0]->bank_code,
				'bank_branch' => $result[0]->bank_branch
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_contract() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_contract_information($id);
		$data = array(
				'contract_id' => $result[0]->contract_id,
				'employee_id' => $result[0]->employee_id,
				'contract_type_id' => $result[0]->contract_type_id,
				'from_date' => $result[0]->from_date,
				'designation_id' => $result[0]->designation_id,
				'title' => $result[0]->title,
				'to_date' => $result[0]->to_date,
				'description' => $result[0]->description,
				'all_contract_types' => $this->Employees_model->all_contract_types(),
				'all_designations' => $this->Designation_model->all_designations(),
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_leave() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_leave_information($id);
		$data = array(
				'leave_id' => $result[0]->leave_id,
				'employee_id' => $result[0]->employee_id,
				'contract_id' => $result[0]->contract_id,
				'casual_leave' => $result[0]->casual_leave,
				'medical_leave' => $result[0]->medical_leave
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_shift() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_emp_shift_information($id);
		$data = array(
				'emp_shift_id' => $result[0]->emp_shift_id,
				'employee_id' => $result[0]->employee_id,
				'shift_id' => $result[0]->shift_id,
				'from_date' => $result[0]->from_date,
				'to_date' => $result[0]->to_date
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_location() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_location_information($id);
		$data = array(
				'office_location_id' => $result[0]->office_location_id,
				'employee_id' => $result[0]->employee_id,
				'location_id' => $result[0]->location_id,
				'from_date' => $result[0]->from_date,
				'to_date' => $result[0]->to_date
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_salary_allowance() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_single_salary_allowance($id);
		$data = array(
				'allowance_id' => $result[0]->allowance_id,
				'employee_id' => $result[0]->employee_id,
				'is_allowance_taxable' => $result[0]->is_allowance_taxable,
				'allowance_title' => $result[0]->allowance_title,
				'allowance_amount' => $result[0]->allowance_amount
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	public function dialog_salary_commissions() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_single_salary_commissions($id);
		$data = array(
				'salary_commissions_id' => $result[0]->salary_commissions_id,
				'employee_id' => $result[0]->employee_id,
				'commission_title' => $result[0]->commission_title,
				'commission_amount' => $result[0]->commission_amount
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	public function dialog_salary_statutory_deductions() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_single_salary_statutory_deduction($id);
		$data = array(
			'statutory_deductions_id' => $result[0]->statutory_deductions_id,
			'employee_id' => $result[0]->employee_id,
			'deduction_title' => $result[0]->deduction_title,
			'deduction_amount' => $result[0]->deduction_amount,
			'statutory_options' => $result[0]->statutory_options
			);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	public function dialog_salary_other_payments() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_single_salary_other_payment($id);
		$data = array(
			'other_payments_id' => $result[0]->other_payments_id,
			'employee_id' => $result[0]->employee_id,
			'payments_title' => $result[0]->payments_title,
			'payments_amount' => $result[0]->payments_amount
			);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_salary_loan() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_single_loan_deductions($id);
		$data = array(
				'loan_deduction_id' => $result[0]->loan_deduction_id,
				'employee_id' => $result[0]->employee_id,
				'loan_deduction_title' => $result[0]->loan_deduction_title,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'loan_options' => $result[0]->loan_options,
				'monthly_installment' => $result[0]->monthly_installment,
				'reason' => $result[0]->reason,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	public function dialog_emp_overtime() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_salary_overtime_record($id);
		$data = array(
				'salary_overtime_id' => $result[0]->salary_overtime_id,
				'employee_id' => $result[0]->employee_id,
				'overtime_type' => $result[0]->overtime_type,
				'no_of_days' => $result[0]->no_of_days,
				'overtime_hours' => $result[0]->overtime_hours,
				'overtime_rate' => $result[0]->overtime_rate
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	 // get departmens > designations
	 public function designation() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'subdepartment_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	  public function is_designation() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/get_designations", $data);
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
			$this->load->view("admin/employees/get_sub_departments", $data);
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
		$id = $this->input->get('warning_id');
		$result = $this->Warning_model->read_warning_information($id);
		$data = array(
				'warning_id' => $result[0]->warning_id,
				'warning_to' => $result[0]->warning_to,
				'warning_by' => $result[0]->warning_by,
				'warning_date' => $result[0]->warning_date,
				'warning_type_id' => $result[0]->warning_type_id,
				'subject' => $result[0]->subject,
				'description' => $result[0]->description,
				'status' => $result[0]->status,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_warning_types' => $this->Warning_model->all_warning_types(),
				);
		if(!empty($session)){ 
			$this->load->view('admin/warning/dialog_warning', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_employee() {
	
		//$this->CI =& get_instance();
		if($this->input->post('add_type')=='employee') {	
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();		
		
		//$office_shift_id = $this->input->post('office_shift_id');
		$system = $this->Xin_model->read_setting_info(1);
		/* Server side PHP input validation */		
		if($this->input->post('first_name')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}*/ else if($this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}*/else if($this->input->post('employee_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_employee_id');
		} else if($this->Employees_model->check_employee_id($this->input->post('employee_id')) > 0) {
			 $Return['error'] = $this->lang->line('xin_employee_id_already_exist');
		} else if($this->input->post('date_of_joining')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_joining_date');
		} else if($this->Xin_model->validate_date($this->input->post('date_of_joining'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		} else if($this->input->post('company_id')==='') {
			 $Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('department_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_department');
		} /*else if($this->input->post('subdepartment_id')==='') {
        	$Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
		}*/ else if($this->input->post('designation_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_designation');
		} else if($this->input->post('username')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->Employees_model->check_employee_username($this->input->post('username')) > 0) {
			 $Return['error'] = $this->lang->line('xin_employee_username_already_exist');
		} else if($this->input->post('email')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->Employees_model->check_employee_email($this->input->post('email')) > 0) {
			 $Return['error'] = $this->lang->line('xin_employee_email_already_exist');
		} else if($this->input->post('date_of_birth')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_date_of_birth');
		} else if($this->Xin_model->validate_date($this->input->post('date_of_birth'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		} else if($this->input->post('contact_no')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_contact_number');
		} else if(!preg_match('/^([0-9]*)$/', $this->input->post('contact_no'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		} else if($this->input->post('password')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_password');
		} else if(strlen($this->input->post('password')) < 6) {
			 $Return['error'] = $this->lang->line('xin_employee_error_password_least');
		} else if($this->input->post('password')!==$this->input->post('confirm_password')) {
			 $Return['error'] = $this->lang->line('xin_employee_error_password_not_match');
		} else if($this->input->post('role')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_user_role');
		} else if($this->input->post('pin_code')==='') {
			 $Return['error'] = $this->lang->line('xin_pincode_field_error');
		} else if(!filter_var($this->input->post('pin_code'), FILTER_VALIDATE_INT)) {
			$Return['error'] = $this->lang->line('xin_pincode_should_be_digits_error');
		} else if(strlen($this->input->post('pin_code')) < 6) {
			 $Return['error'] = $this->lang->line('xin_pincode_six_digits_error');
		} else if($this->Employees_model->check_employee_pincode($this->input->post('pin_code')) > 0) {
			 $Return['error'] = $this->lang->line('xin_pincode_already_exist');
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		/*if($system[0]->multi_shifts == '1'){
			if(empty($office_shift_id)) {
				$Return['error'] = $this->lang->line('xin_office_shift_field_error');
			}
		}*/
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$module_attributes = $this->Custom_fields_model->all_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_module_attributes();	
		$i=1;
		if($count_module_attributes > 0){
			 foreach($module_attributes as $mattribute) {
				 if($mattribute->validation == 1){
					 if($i!=1) {
					 } else if($this->input->post($mattribute->attribute)=='') {
						$Return['error'] = $this->lang->line('xin_hrsale_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('xin_hrsale_custom_field_is_required');
					}
				 }
			 }		
			 if($Return['error']!=''){
				$this->output($Return);
			}	
		}
		
		$first_name = $this->Xin_model->clean_post($this->input->post('first_name'));
		$last_name = $this->Xin_model->clean_post($this->input->post('last_name'));
		$employee_id = $this->Xin_model->clean_post($this->input->post('employee_id'));
		$date_of_joining = $this->Xin_model->clean_date_post($this->input->post('date_of_joining'));
		$username = $this->Xin_model->clean_post($this->input->post('username'));
		$date_of_birth = $this->Xin_model->clean_date_post($this->input->post('date_of_birth'));
		$contact_no = $this->Xin_model->clean_post($this->input->post('contact_no'));
		$address = $this->Xin_model->clean_post($this->input->post('address'));
		
		$options = array('cost' => 12);
		$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
		$leave_categories = array($this->input->post('leave_categories'));
		$cat_ids = implode(',',$this->input->post('leave_categories'));

		$data = array(
		'employee_id' => $employee_id,
		'office_shift_id' => $this->input->post('office_shift_id'),
		'reports_to' => $this->input->post('reports_to'),
		'first_name' => $first_name,
		'last_name' => $last_name,
		'username' => $username,
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'email' => $this->input->post('email'),
		'password' => $password_hash,
		'pincode' => $this->input->post('pin_code'),
		'date_of_birth' => $date_of_birth,
		'gender' => $this->input->post('gender'),
		'user_role_id' => $this->input->post('role'),
		'department_id' => $this->input->post('department_id'),
		'sub_department_id' => $this->input->post('subdepartment_id'),
		'designation_id' => $this->input->post('designation_id'),
		'date_of_joining' => $date_of_joining,
		'contact_no' => $contact_no,
		'address' => $address,
		'is_active' => 1,
		'leave_categories' => $cat_ids,
		'created_at' => date('Y-m-d h:i:s')
		);
		$iresult = $this->Employees_model->add($data);
		if ($iresult) {
			
			$id = $iresult;
			if($count_module_attributes > 0){
				foreach($module_attributes as $mattribute) {
				 	/*$attr_data = array(
						'user_id' => $iresult,
						'module_attributes_id' => $mattribute->custom_field_id,
						'attribute_value' => $this->input->post($mattribute->attribute),
						'created_at' => date('Y-m-d h:i:s')
					);
					$this->Custom_fields_model->add_values($attr_data);*/
					if($mattribute->attribute_type == 'fileupload'){
						if($_FILES[$mattribute->attribute]['size'] != 0) {
							if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
							//checking image type
								$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
								$filename = $_FILES[$mattribute->attribute]['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
									$profile = "uploads/custom_files/";
									$set_img = base_url()."uploads/custom_files/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES[$mattribute->attribute]["name"]);
									$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
									move_uploaded_file($tmp_name, $profile.$newfilename);
									$fname = $newfilename;	
								}
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $fname,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else {
							$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => '',
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
						}
					} else if($mattribute->attribute_type == 'multiselect') {
						$multisel_val = $this->input->post($mattribute->attribute);
						if(!empty($multisel_val)){
							$newdata = implode(',', $this->input->post($mattribute->attribute));
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $newdata,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
						$this->Custom_fields_model->add_values($iattr_data);
					}
					/*$attr_orig_value = $this->Custom_fields_model->read_hrsale_module_attributes_values($result,$mattribute->custom_field_id);
					if($attr_orig_value->module_attributes_id != $mattribute->custom_field_id) {
						$this->Custom_fields_model->add_values($attr_data);
					}*/
				 }
			}
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			$company = $this->Xin_model->read_company_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {
				// load email library
				$this->load->library('email');
				$this->email->set_mailtype("html");
				
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(8);
						
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$company[0]->sign_in_logo;
				
				// get user full name
				$full_name = $this->input->post('first_name').' '.$this->input->post('last_name');
				
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var username}","{var employee_id}","{var employee_name}","{var email}","{var password}"),array($cinfo[0]->company_name,site_url(),$this->input->post('username'),$this->input->post('employee_id'),$full_name,$this->input->post('email'),$this->input->post('password')),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				hrsale_mail($cinfo[0]->email,$cinfo[0]->company_name,$this->input->post('email'),$subject,$message);				
			}
			$Return['result'] = $this->lang->line('xin_success_add_employee');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	/*  add and update employee details info */
	// Validate and update info in database // basic info
	public function basic_info() {
	
		if($this->input->post('type')=='basic_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		//$office_shift_id = $this->input->post('office_shift_id');
		$system = $this->Xin_model->read_setting_info(1);
			
		/* Server side PHP input validation */		
		if($this->input->post('first_name')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}*/ else if($this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}*/ else if($this->input->post('employee_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_employee_id');
		} else if($this->input->post('username')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->input->post('email')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->input->post('company_id')==='') {
			 $Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('location_id')==='') {
			 $Return['error'] = $this->lang->line('xin_location_field_error');
		} else if($this->input->post('department_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_department');
		} else if($this->input->post('subdepartment_id')==='') {
        	$Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
		} else if($this->input->post('designation_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_designation');
		} else if($this->input->post('date_of_birth')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_date_of_birth');
		} else if($this->Xin_model->validate_date($this->input->post('date_of_birth'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		} else if($this->input->post('date_of_joining')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_joining_date');
		} else if($this->Xin_model->validate_date($this->input->post('date_of_joining'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}  else if($this->input->post('role')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_user_role');
		} else if($this->input->post('contact_no')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_contact_number');
		} else if(!preg_match('/^([0-9]*)$/', $this->input->post('contact_no'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		/*if($system[0]->multi_shifts == '1'){
			if(empty($office_shift_id)) {
				$Return['error'] = $this->lang->line('xin_office_shift_field_error');
			}
			$office_shift_ids = implode(',',$this->input->post('office_shift_id'));
			$column_shift = $office_shift_ids;
		} else {
			$column_shift = $this->input->post('office_shift_id');
		}*/
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$first_name = $this->Xin_model->clean_post($this->input->post('first_name'));
		$last_name = $this->Xin_model->clean_post($this->input->post('last_name'));
		$employee_id = $this->input->post('employee_id');
		$date_of_joining = $this->Xin_model->clean_date_post($this->input->post('date_of_joining'));
		//$username = $this->Xin_model->clean_post($this->input->post('username'));
		$username = $this->input->post('username');
		$date_of_birth = $this->Xin_model->clean_date_post($this->input->post('date_of_birth'));
		$contact_no = $this->Xin_model->clean_post($this->input->post('contact_no'));
		$address = $this->input->post('address');
		$leave_categories = array($this->input->post('leave_categories'));
		$cat_ids = implode(',',$this->input->post('leave_categories'));
		$view_companies_id = implode(',',$this->input->post('view_companies_id'));
		
		$module_attributes = $this->Custom_fields_model->all_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_module_attributes();	
		$i=1;
		if($count_module_attributes > 0){
			 foreach($module_attributes as $mattribute) {
				 if($mattribute->validation == 1){
					 if($i!=1) {
					 } else if($this->input->post($mattribute->attribute)=='') {
						$Return['error'] = $this->lang->line('xin_hrsale_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('xin_hrsale_custom_field_is_required');
					}
				 }
			 }		
			 if($Return['error']!=''){
				$this->output($Return);
			}	
		}
	
		$data = array(
		'employee_id' => $employee_id,
		'office_shift_id' => $this->input->post('office_shift_id'),
		'reports_to' => $this->input->post('reports_to'),
		'first_name' => $first_name,
		'last_name' => $last_name,
		'username' => $username,
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'email' => $this->input->post('email'),
		'date_of_birth' => $date_of_birth,
		'gender' => $this->input->post('gender'),
		'user_role_id' => $this->input->post('role'),
		'department_id' => $this->input->post('department_id'),
		'sub_department_id' => $this->input->post('subdepartment_id'),
		'designation_id' => $this->input->post('designation_id'),
		'date_of_joining' => $date_of_joining,
		'contact_no' => $contact_no,
		'address' => $address,
		'state' => $this->input->post('estate'),
		'city' => $this->input->post('ecity'),
		'zipcode' => $this->input->post('ezipcode'),
		'ethnicity_type' => $this->input->post('ethnicity_type'),
		'leave_categories' => $cat_ids,
		'view_companies_id' => $view_companies_id,
		'date_of_leaving' => $this->input->post('date_of_leaving'),
		'marital_status' => $this->input->post('marital_status'),
		'blood_group' => $this->input->post('blood_group'),
		'citizenship_id' => $this->input->post('citizenship_id'),
		'nationality_id' => $this->input->post('nationality_id'),
		'is_active' => $this->input->post('status'),
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->basic_info($data,$id);
		if($count_module_attributes > 0){
			foreach($module_attributes as $mattribute) {
				
				//
				$count_exist_values = $this->Custom_fields_model->count_module_attributes_values($id,$mattribute->custom_field_id);
				if($count_exist_values > 0){
					if($mattribute->attribute_type == 'fileupload'){
						if($_FILES[$mattribute->attribute]['size'] != 0) {
							if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
							//checking image type
								$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
								$filename = $_FILES[$mattribute->attribute]['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
									$profile = "uploads/custom_files/";
									$set_img = base_url()."uploads/custom_files/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES[$mattribute->attribute]["name"]);
									$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
									move_uploaded_file($tmp_name, $profile.$newfilename);
									$fname = $newfilename;	
								}
								$iattr_data = array(
									'attribute_value' => $fname
								);
								$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
							}
							
						} else {
						}
					} else if($mattribute->attribute_type == 'multiselect') {
						$multisel_val = $this->input->post($mattribute->attribute);
						if(!empty($multisel_val)){
							$newdata = implode(',', $this->input->post($mattribute->attribute));
							$iattr_data = array(
								'attribute_value' => $newdata,
							);
							$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
						}
					} else {
						$attr_data = array(
							'attribute_value' => $this->input->post($mattribute->attribute),
						);
						$this->Custom_fields_model->update_att_record($attr_data, $id,$mattribute->custom_field_id);
					}
					
				} else {
					if($mattribute->attribute_type == 'fileupload'){
						if($_FILES[$mattribute->attribute]['size'] != 0) {
							if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
							//checking image type
								$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
								$filename = $_FILES[$mattribute->attribute]['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
									$profile = "uploads/custom_files/";
									$set_img = base_url()."uploads/custom_files/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES[$mattribute->attribute]["name"]);
									$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
									move_uploaded_file($tmp_name, $profile.$newfilename);
									$fname = $newfilename;	
								}
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $fname,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					} else if($mattribute->attribute_type == 'multiselect') {
						$multisel_val = $this->input->post($mattribute->attribute);
						if(!empty($multisel_val)){
							$newdata = implode(',', $this->input->post($mattribute->attribute));
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $newdata,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
						$this->Custom_fields_model->add_values($iattr_data);
					}
				}
			 }
		}
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update status info in database // status info
	public function update_status_info() {
		/* Define return | here result is used to return user data and error for error message */
		$status_id = $this->uri->segment(4);
		if($status_id == 2){
			$status_id = 0;
		}
		$user_id = $this->uri->segment(5);
		$user = $this->Xin_model->read_user_info($user_id);
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		$data = array(
			'is_active' => $status_id,
		);
		//$id = $this->input->post('user_id');
		$this->Employees_model->basic_info($data,$user_id);
		//$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
		echo $full_name.' '.$this->lang->line('xin_employee_status_updated');
		//$this->output($Return);
		//exit;
	}
	
	// Validate and update info in database // social info
	public function profile_picture() {
	
		if($this->input->post('type')=='profile_picture') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->input->post('user_id');
			
		/* Check if file uploaded..*/
		if($_FILES['p_file']['size'] == 0 && null ==$this->input->post('remove_profile_picture')) {
			$Return['error'] = $this->lang->line('xin_employee_select_picture');
		} else {
			if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['p_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["p_file"]["tmp_name"];
					$profile = "uploads/profile/";
					$set_img = base_url()."uploads/profile/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["p_file"]["name"]);
					$newfilename = 'profile_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;
					
					//UPDATE Employee info in DB
					$data = array('profile_picture' => $fname);
					$result = $this->Employees_model->profile_picture($data,$id);
					if ($result == TRUE) {
						$Return['result'] = $this->lang->line('xin_employee_picture_updated');
						$Return['img'] = $set_img.$fname;
					} else {
						$Return['error'] = $this->lang->line('xin_error_msg');
					}
					$this->output($Return);
					exit;
					
				} else {
					$Return['error'] = $this->lang->line('xin_employee_picture_type');
				}
				}
			}
			
			if(null!=$this->input->post('remove_profile_picture')) {
				//UPDATE Employee info in DB
				$data = array('profile_picture' => 'no file');				
				$row = $this->Employees_model->read_employee_information($id);
				$profile = base_url()."uploads/profile/";
				$result = $this->Employees_model->profile_picture($data,$id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('xin_employee_picture_updated');
					if($row[0]->gender=='Male') {
						$Return['img'] = $profile.'default_male.jpg';
					} else {
						$Return['img'] = $profile.'default_female.jpg';
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;
				
			}
				
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}
	
	// Validate and update info in database // basic info
	public function social_info() {
	
		if($this->input->post('type')=='social_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if ($this->input->post('facebook_link')!=='' && !filter_var($this->input->post('facebook_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_fb_field_error');
		} else if ($this->input->post('twitter_link')!=='' && !filter_var($this->input->post('twitter_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_twitter_field_error');
		} else if ($this->input->post('blogger_link')!=='' && !filter_var($this->input->post('blogger_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_blogger_field_error');
		} else if ($this->input->post('linkdedin_link')!=='' && !filter_var($this->input->post('linkdedin_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_linkedin_field_error');
		} else if ($this->input->post('google_plus_link')!=='' && !filter_var($this->input->post('google_plus_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_gplus_field_error');
		} else if ($this->input->post('instagram_link')!=='' && !filter_var($this->input->post('instagram_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_instagram_field_error');
		} else if ($this->input->post('pinterest_link')!=='' && !filter_var($this->input->post('pinterest_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_pinterest_field_error');
		} else if ($this->input->post('youtube_link')!=='' && !filter_var($this->input->post('youtube_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_youtube_field_error');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'facebook_link' => $this->input->post('facebook_link'),
		'twitter_link' => $this->input->post('twitter_link'),
		'blogger_link' => $this->input->post('blogger_link'),
		'linkdedin_link' => $this->input->post('linkdedin_link'),
		'google_plus_link' => $this->input->post('google_plus_link'),
		'instagram_link' => $this->input->post('instagram_link'),
		'pinterest_link' => $this->input->post('pinterest_link'),
		'youtube_link' => $this->input->post('youtube_link')
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->social_info($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_social_info');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}	
	
	// Validate and update info in database // contact info
	public function update_contacts_info() {
	
		if($this->input->post('type')=='contact_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		/* Server side PHP input validation */		
		if($this->input->post('salutation')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_salutation');
		} else if($this->input->post('contact_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
		} else if($this->input->post('relation')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_grp');
		} else if($this->input->post('primary_email')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_pemail');
		} else if($this->input->post('mobile_phone')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
		} else if($this->input->post('city')==='') {
			 $Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($this->input->post('country')==='') {
			 $Return['error'] = $this->lang->line('xin_error_country_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'salutation' => $this->input->post('salutation'),
		'contact_name' => $this->input->post('contact_name'),
		'relation' => $this->input->post('relation'),
		'company' => $this->input->post('company'),
		'job_title' => $this->input->post('job_title'),
		'primary_email' => $this->input->post('primary_email'),
		'mobile_phone' => $this->input->post('mobile_phone'),
		'address' => $this->input->post('address'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		'employee_id' => $this->input->post('user_id'),
		'contact_type' => 'permanent'
		);
		
		$query = $this->Employees_model->check_employee_contact_permanent($this->input->post('user_id'));
		if ($query->num_rows() > 0 ) {
			$res = $query->result();
			$e_field_id = $res[0]->contact_id;
			$result = $this->Employees_model->contact_info_update($data,$e_field_id);
		} else {
			$result = $this->Employees_model->contact_info_add($data);
		}

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contact_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database //  econtact info
	public function update_contact_info() {
	
		if($this->input->post('type')=='contact_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		/* Server side PHP input validation */		
		if($this->input->post('salutation')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_salutation');
		} else if($this->input->post('contact_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
		} else if($this->input->post('relation')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_grp');
		} else if($this->input->post('primary_email')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_pemail');
		} else if($this->input->post('mobile_phone')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
		} else if($this->input->post('city')==='') {
			 $Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($this->input->post('country')==='') {
			 $Return['error'] = $this->lang->line('xin_error_country_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'salutation' => $this->input->post('salutation'),
		'contact_name' => $this->input->post('contact_name'),
		'relation' => $this->input->post('relation'),
		'company' => $this->input->post('company'),
		'job_title' => $this->input->post('job_title'),
		'primary_email' => $this->input->post('primary_email'),
		'mobile_phone' => $this->input->post('mobile_phone'),
		'address' => $this->input->post('address'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		'employee_id' => $this->input->post('user_id'),
		'contact_type' => 'current'
		);
		
		$query = $this->Employees_model->check_employee_contact_current($this->input->post('user_id'));
		if ($query->num_rows() > 0 ) {
			$res = $query->result();
			$e_field_id = $res[0]->contact_id;
			$result = $this->Employees_model->contact_info_update($data,$e_field_id);
		} else {
			$result = $this->Employees_model->contact_info_add($data);
		}
		//$e_field_id = 1;
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contact_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // contact info
	public function contact_info() {
	
		if($this->input->post('type')=='contact_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('relation')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_relation');
		} else if($this->input->post('contact_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
		} else if(!preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('contact_name'))) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		} else if($this->input->post('contact_no')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('contact_no'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		} else if($this->input->post('work_phone')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('work_phone'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		} else if($this->input->post('work_phone_extension')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('work_phone_extension'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		} else if($this->input->post('mobile_phone')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
		} else if(!preg_match('/^([0-9]*)$/', $this->input->post('mobile_phone'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		} else if($this->input->post('home_phone')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('home_phone'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		} else if($this->input->post('work_email')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('work_email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if ($this->input->post('personal_email')!=='' && !filter_var($this->input->post('personal_email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->input->post('zipcode')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('zipcode'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}
		
		if(null!=$this->input->post('is_primary')) {
			$is_primary = $this->input->post('is_primary');
		} else {
			$is_primary = '';
		}
		if(null!=$this->input->post('is_dependent')) {
			$is_dependent = $this->input->post('is_dependent');
		} else {
			$is_dependent = '';
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$contact_name = $this->Xin_model->clean_post($this->input->post('contact_name'));
		$address_1 = $this->Xin_model->clean_post($this->input->post('address_1'));
		$address_2 = $this->Xin_model->clean_post($this->input->post('address_2'));
		$city = $this->Xin_model->clean_post($this->input->post('city'));
		$state = $this->Xin_model->clean_post($this->input->post('state'));		
	
		$data = array(
		'relation' => $this->input->post('relation'),
		'work_email' => $this->input->post('work_email'),
		'is_primary' => $is_primary,
		'is_dependent' => $is_dependent,
		'personal_email' => $this->input->post('personal_email'),
		'contact_name' => $contact_name,
		'address_1' => $address_1,
		'work_phone' => $this->input->post('work_phone'),
		'work_phone_extension' => $this->input->post('work_phone_extension'),
		'address_2' => $address_2,
		'mobile_phone' => $this->input->post('mobile_phone'),
		'city' => $city,
		'state' => $state,
		'zipcode' => $this->input->post('zipcode'),
		'home_phone' => $this->input->post('home_phone'),
		'country' => $this->input->post('country'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->contact_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contact_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database //  econtact info
	public function e_contact_info() {
	
		if($this->input->post('type')=='e_contact_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('relation')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_relation');
		} else if($this->input->post('contact_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
		} else if($this->input->post('mobile_phone')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
		}
		
		if(null!=$this->input->post('is_primary')) {
			$is_primary = $this->input->post('is_primary');
		} else {
			$is_primary = '';
		}
		if(null!=$this->input->post('is_dependent')) {
			$is_dependent = $this->input->post('is_dependent');
		} else {
			$is_dependent = '';
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'relation' => $this->input->post('relation'),
		'work_email' => $this->input->post('work_email'),
		'is_primary' => $is_primary,
		'is_dependent' => $is_dependent,
		'personal_email' => $this->input->post('personal_email'),
		'contact_name' => $this->input->post('contact_name'),
		'address_1' => $this->input->post('address_1'),
		'work_phone' => $this->input->post('work_phone'),
		'work_phone_extension' => $this->input->post('work_phone_extension'),
		'address_2' => $this->input->post('address_2'),
		'mobile_phone' => $this->input->post('mobile_phone'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'home_phone' => $this->input->post('home_phone'),
		'country' => $this->input->post('country')
		);
		
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->contact_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contact_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // document info
	public function document_info() {
	
		if($this->input->post('type')=='document_info' && $this->input->post('data')=='document_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('document_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} /*else if($this->Xin_model->validate_date($this->input->post('date_of_expiry'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}*/ else if($this->input->post('title')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_document_title');
		} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('title')) != 1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		} else if($this->input->post('email')==='') {
			 $Return['error'] = $this->lang->line('xin_error_notify_email_field');
		} else if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} */
		
		/* Check if file uploaded..*/
		else if($_FILES['document_file']['size'] == 0) {
			$fname = '';
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
					
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		//clean simple fields
		$title = $this->Xin_model->clean_post($this->input->post('title'));
		$description = $this->Xin_model->clean_post($this->input->post('description'));
		// clean date fields
		$date_of_expiry = $this->Xin_model->clean_date_post($this->input->post('date_of_expiry'));
	
		$data = array(
		'document_type_id' => $this->input->post('document_type_id'),
		'date_of_expiry' => $date_of_expiry,
		'document_file' => $fname,
		'title' => $title,
		//'notification_email' => $this->input->post('email'),
		//'is_alert' => $this->input->post('send_mail'),
		'description' => $description,
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->document_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_d_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // document info
	public function immigration_info() {
	
		if($this->input->post('type')=='immigration_info' && $this->input->post('data')=='immigration_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		//preg_match("/^(\pL{1,}[ ]?)+$/u",
		/* Server side PHP input validation */		
		if($this->input->post('document_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} else if($this->input->post('document_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_number');
		} else if($this->input->post('issue_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_issue');
		} else if($this->Xin_model->validate_date($this->input->post('issue_date'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		} else if($this->input->post('expiry_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_expiry_date');
		} else if($this->Xin_model->validate_date($this->input->post('expiry_date'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}
		
		/* Check if file uploaded..*/
		else if($_FILES['document_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_employee_select_d_file');
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/immigration/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
					
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$document_number = $this->Xin_model->clean_post($this->input->post('document_number'));	
		$issue_date = $this->Xin_model->clean_date_post($this->input->post('issue_date'));
		$expiry_date = $this->Xin_model->clean_date_post($this->input->post('expiry_date'));
		$eligible_review_date = $this->Xin_model->clean_date_post($this->input->post('eligible_review_date'));
		$data = array(
		'document_type_id' => $this->input->post('document_type_id'),
		'document_number' => $document_number,
		'document_file' => $fname,
		'issue_date' => $issue_date,
		'expiry_date' => $expiry_date,
		'country_id' => $this->input->post('country'),
		'eligible_review_date' => $eligible_review_date,
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s'),
		);
		$result = $this->Employees_model->immigration_info_add($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_img_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // document info
	public function e_immigration_info() {
	
		if($this->input->post('type')=='e_immigration_info' && $this->input->post('data')=='e_immigration_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('document_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} else if($this->input->post('document_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_number');
		} else if($this->input->post('issue_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_issue');
		} else if($this->input->post('expiry_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_expiry_date');
		}
		
		/* Check if file uploaded..*/
		else if($_FILES['document_file']['size'] == 0) {
			$data = array(
				'document_type_id' => $this->input->post('document_type_id'),
				'document_number' => $this->input->post('document_number'),
				'issue_date' => $this->input->post('issue_date'),
				'expiry_date' => $this->input->post('expiry_date'),
				'country_id' => $this->input->post('country'),
				'eligible_review_date' => $this->input->post('eligible_review_date'),
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Employees_model->img_document_info_update($data,$e_field_id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('xin_employee_img_info_updated');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/immigration/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
					$data = array(
					'document_type_id' => $this->input->post('document_type_id'),
					'document_number' => $this->input->post('document_number'),
					'document_file' => $fname,
					'issue_date' => $this->input->post('issue_date'),
					'expiry_date' => $this->input->post('expiry_date'),
					'country_id' => $this->input->post('country'),
					'eligible_review_date' => $this->input->post('eligible_review_date'),
					);
					$e_field_id = $this->input->post('e_field_id');
					$result = $this->Employees_model->img_document_info_update($data,$e_field_id);
					if ($result == TRUE) {
						$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
					} else {
						$Return['error'] = $this->lang->line('xin_error_msg');
					}
					$this->output($Return);
					exit;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
							
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_img_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // e_document info
	public function e_document_info() {
	 
		if($this->input->post('type')=='e_document_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('document_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} else if($this->input->post('title')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_document_title');
		}
		
		/* Check if file uploaded..*/
		else if($_FILES['document_file']['size'] == 0) {
			$data = array(
				'document_type_id' => $this->input->post('document_type_id'),
				'date_of_expiry' => $this->input->post('date_of_expiry'),
				'title' => $this->input->post('title'),
				//'notification_email' => $this->input->post('email'),
				//'is_alert' => $this->input->post('send_mail'),
				'description' => $this->input->post('description')
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Employees_model->document_info_update($data,$e_field_id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
					$data = array(
					'document_type_id' => $this->input->post('document_type_id'),
					'date_of_expiry' => $this->input->post('date_of_expiry'),
					'document_file' => $fname,
					'title' => $this->input->post('title'),
					//'notification_email' => $this->input->post('email'),
					//'is_alert' => $this->input->post('send_mail'),
					'description' => $this->input->post('description')
					);
					$e_field_id = $this->input->post('e_field_id');
					$result = $this->Employees_model->document_info_update($data,$e_field_id);
					if ($result == TRUE) {
						$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
					} else {
						$Return['error'] = $this->lang->line('xin_error_msg');
					}
					$this->output($Return);
					exit;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
					
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		}
	}
	
	// Validate and add info in database // qualification info
	public function qualification_info() {
	
		if($this->input->post('type')=='qualification_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */	
		$from_year = $this->input->post('from_year');
		$to_year = $this->input->post('to_year');
		$st_date = strtotime($from_year);
		$ed_date = strtotime($to_year);
			
		if($this->input->post('name')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_sch_uni');
		} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('name'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		} else if($this->input->post('from_year')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->Xin_model->validate_date($this->input->post('from_year'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		} else if($this->input->post('to_year')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		} else if($this->Xin_model->validate_date($this->input->post('to_year'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$name = $this->Xin_model->clean_post($this->input->post('name'));
		$from_year = $this->Xin_model->clean_date_post($this->input->post('from_year'));
		$to_year = $this->Xin_model->clean_date_post($this->input->post('to_year'));
		$description = $this->Xin_model->clean_post($this->input->post('description'));
		$data = array(
		'name' => $name,
		'education_level_id' => $this->input->post('education_level'),
		'from_year' => $from_year,
		'language_id' => $this->input->post('language'),
		'to_year' => $this->input->post('to_year'),
		'skill_id' => $this->input->post('skill'),
		'description' => $description,
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->qualification_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_q_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // qualification info
	public function e_qualification_info() {
	
		if($this->input->post('type')=='e_qualification_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		$from_year = $this->input->post('from_year');
		$to_year = $this->input->post('to_year');
		$st_date = strtotime($from_year);
		$ed_date = strtotime($to_year);
			
		if($this->input->post('name')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_sch_uni');
		} else if($this->input->post('from_year')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('to_year')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
		}
			
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'education_level_id' => $this->input->post('education_level'),
		'from_year' => $this->input->post('from_year'),
		'language_id' => $this->input->post('language'),
		'to_year' => $this->input->post('to_year'),
		'skill_id' => $this->input->post('skill'),
		'description' => $this->input->post('description')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->qualification_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_q_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // work experience info
	public function work_experience_info() {
	
		if($this->input->post('type')=='work_experience_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$frm_date = strtotime($this->input->post('from_date'));	
		$to_date = strtotime($this->input->post('to_date'));
		/* Server side PHP input validation */		
		if($this->input->post('company_name')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('post')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_post');
		} else if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('to_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		} else if($frm_date > $to_date) {
			 $Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
		} 
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'company_name' => $this->input->post('company_name'),
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date'),
		'post' => $this->input->post('post'),
		'description' => $this->input->post('description'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->work_experience_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_w_exp_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function e_work_experience_info() {
	
		if($this->input->post('type')=='e_work_experience_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$frm_date = strtotime($this->input->post('from_date'));	
		$to_date = strtotime($this->input->post('to_date'));
		/* Server side PHP input validation */		
		if($this->input->post('company_name')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('to_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		} else if($frm_date > $to_date) {
			 $Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
		} else if($this->input->post('post')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_post');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'company_name' => $this->input->post('company_name'),
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date'),
		'post' => $this->input->post('post'),
		'description' => $this->input->post('description')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->work_experience_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_w_exp_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	
	// Validate and add info in database // bank account info
	public function bank_account_info() {
	
		if($this->input->post('type')=='bank_account_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('account_title')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_acc_title');
		} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('account_title'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		} else if($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		} else if($this->input->post('bank_name')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_name');
		} else if($this->input->post('bank_code')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_code');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'account_title' => $this->input->post('account_title'),
		'account_number' => $this->input->post('account_number'),
		'bank_name' => $this->input->post('bank_name'),
		'bank_code' => $this->input->post('bank_code'),
		'bank_branch' => $this->input->post('bank_branch'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->bank_account_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_bank_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // bank account info
	public function add_security_level() {
	
		if($this->input->post('type')=='security_level_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('security_level')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_security_level_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'security_type' => $this->input->post('security_level'),
		'expiry_date' => $this->input->post('expiry_date'),
		'date_of_clearance' => $this->input->post('date_of_clearance'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->security_level_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_security_level_emp_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // ebank account info
	public function e_security_level_info() {
	
		if($this->input->post('type')=='e_security_level_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('security_level')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_security_level_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
			'security_type' => $this->input->post('security_level'),
			'expiry_date' => $this->input->post('expiry_date'),
			'date_of_clearance' => $this->input->post('date_of_clearance')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->security_level_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_security_level_emp_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// delete security level record
	public function delete_security_level() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_security_level_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_security_level_emp_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// Validate and add info in database // ebank account info
	public function e_bank_account_info() {
	
		if($this->input->post('type')=='e_bank_account_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('account_title')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_acc_title');
		} else if($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		} else if($this->input->post('bank_name')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_name');
		} else if($this->input->post('bank_code')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_code');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'account_title' => $this->input->post('account_title'),
		'account_number' => $this->input->post('account_number'),
		'bank_name' => $this->input->post('bank_name'),
		'bank_code' => $this->input->post('bank_code'),
		'bank_branch' => $this->input->post('bank_branch')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->bank_account_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_bank_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database //contract info
	public function contract_info() {
	
		if($this->input->post('type')=='contract_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$frm_date = strtotime($this->input->post('from_date'));	
		$to_date = strtotime($this->input->post('to_date'));
		/* Server side PHP input validation */		
		if($this->input->post('contract_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_contract_type');
		} else if($this->input->post('title')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_contract_title');
		} else if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('to_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		} else if($frm_date > $to_date) {
			 $Return['error'] = $this->lang->line('xin_employee_error_frm_to_date');
		} else if($this->input->post('designation_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_designation');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'contract_type_id' => $this->input->post('contract_type_id'),
		'title' => $this->input->post('title'),
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date'),
		'designation_id' => $this->input->post('designation_id'),
		'description' => $this->input->post('description'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->contract_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contract_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database //e contract info
	public function e_contract_info() {
	
		if($this->input->post('type')=='e_contract_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$frm_date = strtotime($this->input->post('from_date'));	
		$to_date = strtotime($this->input->post('to_date'));
		/* Server side PHP input validation */		
		if($this->input->post('contract_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_contract_type');
		} else if($this->input->post('title')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_contract_title');
		} else if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('to_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		} else if($frm_date > $to_date) {
			 $Return['error'] = $this->lang->line('xin_employee_error_frm_to_date');
		} else if($this->input->post('designation_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_designation');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'contract_type_id' => $this->input->post('contract_type_id'),
		'title' => $this->input->post('title'),
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date'),
		'designation_id' => $this->input->post('designation_id'),
		'description' => $this->input->post('description')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->contract_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contract_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database //leave_info
	public function leave_info() {
	
		if($this->input->post('type')=='leave_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('contract_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_contract_f');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'contract_id' => $this->input->post('contract_id'),
		'casual_leave' => $this->input->post('casual_leave'),
		'medical_leave' => $this->input->post('medical_leave'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->leave_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_leave_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database //Eleave_info
	public function e_leave_info() {
	
		if($this->input->post('type')=='e_leave_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
							
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'casual_leave' => $this->input->post('casual_leave'),
		'medical_leave' => $this->input->post('medical_leave')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->leave_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_leave_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // shift info
	public function shift_info() {
	
		if($this->input->post('type')=='shift_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */		
		if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('shift_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_shift_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date'),
		'shift_id' => $this->input->post('shift_id'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->shift_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_shift_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // eshift info
	public function e_shift_info() {
	
		if($this->input->post('type')=='e_shift_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		}
					
		$data = array(
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->shift_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_shift_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // location info
	public function location_info() {
	
		if($this->input->post('type')=='location_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */		
		if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('location_id')==='') {
			 $Return['error'] = $this->lang->line('error_location_dept_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date'),
		'location_id' => $this->input->post('location_id'),
		'employee_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->location_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_location_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // elocation info
	public function e_location_info() {
	
		if($this->input->post('type')=='e_location_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */		
		if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		} else if($this->input->post('location_id')==='') {
			 $Return['error'] = $this->lang->line('error_location_dept_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'from_date' => $this->input->post('from_date'),
		'to_date' => $this->input->post('to_date')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->location_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_location_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database // update_allowance_info
	public function update_allowance_info() {
	
		if($this->input->post('type')=='e_allowance_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */		
		if($this->input->post('allowance_title')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_allowance_title_error');
		} else if($this->input->post('allowance_amount')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_set_allowance_amount_error');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'allowance_title' => $this->input->post('allowance_title'),
		'allowance_amount' => $this->input->post('allowance_amount'),
		'is_allowance_taxable' => $this->input->post('is_allowance_taxable')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->salary_allowance_update_record($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_updated_allowance_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database //
	public function update_commissions_info() {
	
		if($this->input->post('type')=='e_salary_commissions_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */		
		if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'commission_title' => $this->input->post('title'),
		'commission_amount' => $this->input->post('amount')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->salary_commissions_update_record($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_update_commission_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database //
	public function update_statutory_deductions_info() {
	
		if($this->input->post('type')=='e_salary_statutory_deductions_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */		
		if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'deduction_title' => $this->input->post('title'),
		'deduction_amount' => $this->input->post('amount'),
		'statutory_options' => $this->input->post('statutory_options')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->salary_statutory_deduction_update_record($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_update_statutory_deduction_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database //
	public function update_other_payment_info() {
	
		if($this->input->post('type')=='e_salary_other_payments_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */		
		if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payments_title' => $this->input->post('title'),
		'payments_amount' => $this->input->post('amount')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->salary_other_payment_update_record($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_update_otherpayments_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // change password
	public function change_password() {
	
		if($this->input->post('type')=='change_password') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */						
		if(trim($this->input->post('old_password'))==='') {
       		 $Return['error'] = $this->lang->line('xin_old_password_error_field');
		} else if($this->Employees_model->check_old_password($this->input->post('old_password'),$this->input->post('user_id'))!= 1) {
			 $Return['error'] = $this->lang->line('xin_old_password_does_not_match');
		} else if(trim($this->input->post('new_password'))==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_newpassword');
		} else if(strlen($this->input->post('new_password')) < 6) {
			$Return['error'] = $this->lang->line('xin_employee_error_password_least');
		} else if(trim($this->input->post('new_password_confirm'))==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_new_cpassword');
		} else if($this->input->post('new_password')!=$this->input->post('new_password_confirm')) {
			 $Return['error'] = $this->lang->line('xin_employee_error_old_new_cpassword');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$options = array('cost' => 12);
		$password_hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $options);
	
		$data = array(
		'password' => $password_hash
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->change_password($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_password_update');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	 /*  get all employee details lisitng *//////////////////
	 
	public function security_level_list() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$security_level = $this->Employees_model->set_employee_security_level($id);
		
		$data = array();

        foreach($security_level->result() as $r) {			
		$security_type = $this->Xin_model->read_security_level($r->security_type);
		if(!is_null($security_type)){
			$sc_type = $security_type[0]->name;
		} else {
			$sc_type = '--';
		}
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->security_level_id . '" data-field_type="security_level"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->security_level_id . '" data-token_type="security_level"><i class="fas fa-trash-restore"></i></button></span>',
			$sc_type,
			$r->expiry_date,
			$r->date_of_clearance
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $security_level->num_rows(),
			 "recordsFiltered" => $security_level->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // employee contacts - listing
	public function contacts()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$contacts = $this->Employees_model->set_employee_contacts($id);
		
		$data = array();

        foreach($contacts->result() as $r) {
			
			if($r->is_primary==1){
				$primary = '<span class="tag tag-success">'.$this->lang->line('xin_employee_primary').'</span>';
			 } else {
				 $primary = '';
			 }
			 if($r->is_dependent==2){
				$dependent = '<span class="tag tag-danger">'.$this->lang->line('xin_employee_dependent').'</span>';
			 } else {
				 $dependent = '';
			 }
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->contact_id . '" data-field_type="contact"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->contact_id . '" data-token_type="contact"><i class="fas fa-trash-restore"></i></button></span>',
			$r->contact_name . ' ' .$primary . ' '.$dependent,
			$r->relation,
			$r->work_email,
			$r->mobile_phone
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $contacts->num_rows(),
			 "recordsFiltered" => $contacts->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee documents - listing
	public function documents() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$documents = $this->Employees_model->set_employee_documents($id);
		
		$data = array();

        foreach($documents->result() as $r) {
			
			$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->document_type;
			} else {
				$document_d = '--';
			}
			if($r->date_of_expiry == ''){
				$date_of_expiry = '';
			} else {
				$date_of_expiry = $this->Xin_model->set_date_format($r->date_of_expiry);
			}
			if($r->document_file!='' && $r->document_file!='no file') {
			 $functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="Download"><a href="'.site_url().'admin/download?type=document&filename='.$r->document_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('xin_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			 } else {
				 $functions ='';
			 }
			 
			 /*if($r->is_alert==1){
			 	$alert = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_e_details_alert_notifyemail').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><i class="fa fa-bell"></i></button></span>';
			 } else {
				 $alert = '';
			 }*/
		
		$data[] = array(
			$functions.'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->document_id . '" data-field_type="document"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_id . '" data-token_type="document"><i class="fas fa-trash-restore"></i></button></span>',
			$document_d,
			$r->title,
			$date_of_expiry
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $documents->num_rows(),
			 "recordsFiltered" => $documents->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // employee immigration - listing
	public function immigration() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$immigration = $this->Employees_model->set_employee_immigration($id);
		
		$data = array();

        foreach($immigration->result() as $r) {
			
		$issue_date = $this->Xin_model->set_date_format($r->issue_date);
		$expiry_date = $this->Xin_model->set_date_format($r->expiry_date);
		$eligible_review_date = $this->Xin_model->set_date_format($r->eligible_review_date);
		$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
		if(!is_null($d_type)){
			$document_d = $d_type[0]->document_type.'<br>'.$r->document_number;
		} else {
			$document_d = $r->document_number;
		}
		$country = $this->Xin_model->read_country_info($r->country_id);
		if(!is_null($country)){
			$c_name = $country[0]->country_name;
		} else {
			$c_name = '--';	
		}
				
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->immigration_id . '" data-field_type="imgdocument"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->immigration_id . '" data-token_type="imgdocument"><i class="fas fa-trash-restore"></i></button></span>',
			$document_d,
			$issue_date,
			$expiry_date,
			$c_name,
			$eligible_review_date,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $immigration->num_rows(),
			 "recordsFiltered" => $immigration->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee qualification - listing
	public function qualification() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$qualification = $this->Employees_model->set_employee_qualification($id);
		
		$data = array();

        foreach($qualification->result() as $r) {
			
			$education = $this->Employees_model->read_education_information($r->education_level_id);
			if(!is_null($education)){
				$edu_name = $education[0]->name;
			} else {
				$edu_name = '--';
			}
		//	$language = $this->Employees_model->read_qualification_language_information($r->language_id);
			
			/*if($r->skill_id == 'no course') {
				$ol = 'No Course';
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->skill_id) as $desig_id) {
					$skill = $this->Employees_model->read_qualification_skill_information($desig_id);
					$ol .= '<li>'.$skill[0]->name.'</li>';
				 }
				 $ol .= '</ol>';
			}*/
			$sdate = $this->Xin_model->set_date_format($r->from_year);
			$edate = $this->Xin_model->set_date_format($r->to_year);	
			
			$time_period = $sdate.' - '.$edate;
			// get date
			$pdate = $time_period;
			$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->qualification_id . '" data-field_type="qualification"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->qualification_id . '" data-token_type="qualification"><i class="fas fa-trash-restore"></i></button></span>',
			$r->name,
			$pdate,
			$edu_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $qualification->num_rows(),
			 "recordsFiltered" => $qualification->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee work experience - listing
	public function experience() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$experience = $this->Employees_model->set_employee_experience($id);
		
		$data = array();

        foreach($experience->result() as $r) {
			
			$from_date = $this->Xin_model->set_date_format($r->from_date);
			$to_date = $this->Xin_model->set_date_format($r->to_date);
			
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->work_experience_id . '" data-field_type="work_experience"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->work_experience_id . '" data-token_type="work_experience"><i class="fas fa-trash-restore"></i></button></span>',
			$r->company_name,
			$from_date,
			$to_date,
			$r->post,
			$r->description
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $experience->num_rows(),
			 "recordsFiltered" => $experience->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee bank account - listing
	public function bank_account() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$bank_account = $this->Employees_model->set_employee_bank_account($id);
		
		$data = array();

        foreach($bank_account->result() as $r) {			
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->bankaccount_id . '" data-field_type="bank_account"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->bankaccount_id . '" data-token_type="bank_account"><i class="fas fa-trash-restore"></i></button></span>',
			$r->account_title,
			$r->account_number,
			$r->bank_name,
			$r->bank_code,
			$r->bank_branch
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $bank_account->num_rows(),
			 "recordsFiltered" => $bank_account->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee contract - listing
	public function contract() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$contract = $this->Employees_model->set_employee_contract($id);
		
		$data = array();

        foreach($contract->result() as $r) {			
			// designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}
			//contract type
			$contract_type = $this->Employees_model->read_contract_type_information($r->contract_type_id);
			if(!is_null($contract_type)){
				$ctype = $contract_type[0]->name;
			} else {
				$ctype = '--';
			}
			// date
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->contract_id . '" data-field_type="contract"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->contract_id . '" data-token_type="contract"><i class="fas fa-trash-restore"></i></button></span>',
			$duration,
			$designation_name,
			$ctype,
			$r->title
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $contract->num_rows(),
			 "recordsFiltered" => $contract->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee leave - listing
	public function leave() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$leave = $this->Employees_model->set_employee_leave($id);
		
		$data = array();

        foreach($leave->result() as $r) {			
			
			
			
			// contract
			$contract = $this->Employees_model->read_contract_information($r->contract_id);
			if(!is_null($contract)){
				// contract duration
			$duration = $this->Xin_model->set_date_format($contract[0]->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($contract[0]->to_date);
				$ctitle = $contract[0]->title.' '.$duration;
			} else {
				$ctitle = '--';
			}
			
			$contracti = $ctitle;
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->leave_id . '" data-field_type="leave"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->leave_id . '" data-token_type="leave"><i class="fas fa-trash-restore"></i></button></span>',
			$contracti,
			$r->casual_leave,
			$r->medical_leave
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $leave->num_rows(),
			 "recordsFiltered" => $leave->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee office shift - listing
	public function shift() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$shift = $this->Employees_model->set_employee_shift($id);
		
		$data = array();

        foreach($shift->result() as $r) {			
			// contract
			$shift_info = $this->Employees_model->read_shift_information($r->shift_id);
			// contract duration
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
			
			if(!is_null($shift_info)){
				$shift_name = $shift_info[0]->shift_name;
			} else {
				$shift_name = '--';
			}
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->emp_shift_id . '" data-field_type="shift"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->emp_shift_id . '" data-token_type="shift"><i class="fas fa-trash-restore"></i></button></span>',
			$duration,
			$shift_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $shift->num_rows(),
			 "recordsFiltered" => $shift->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// employee location - listing
	public function location() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$location = $this->Employees_model->set_employee_location($id);
		
		$data = array();

        foreach($location->result() as $r) {			
			// contract
			$of_location = $this->Location_model->read_location_information($r->location_id);
			// contract duration
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
			if(!is_null($of_location)){
				$location_name = $of_location[0]->location_name;
			} else {
				$location_name = '--';
			}
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->office_location_id . '" data-field_type="location"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->office_location_id . '" data-token_type="location"><i class="fas fa-trash-restore"></i></button></span>',
			$duration,
			$location_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $location->num_rows(),
			 "recordsFiltered" => $location->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='warning') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('warning_to')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_warning');
		} else if($this->input->post('type')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_warning_type');
		} else if($this->input->post('subject')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_subject');
		} else if($this->input->post('warning_by')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_warning_by');
		} else if($this->input->post('warning_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_warning_date');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'warning_to' => $this->input->post('warning_to'),
		'warning_type_id' => $this->input->post('type'),
		'description' => $qt_description,
		'subject' => $this->input->post('subject'),
		'warning_by' => $this->input->post('warning_by'),
		'warning_date' => $this->input->post('warning_date'),
		'status' => $this->input->post('status'),
		);
		
		$result = $this->Warning_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_warning_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// import > employees
	 public function import()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_import_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_employees');
		$data['path_url'] = 'import_employees';		
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('92',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/employees/employes_import", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
	
	
	// delete contact record
	public function delete_contact() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_contact_record($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_contact_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete document record
	public function delete_document() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Employees_model->delete_document_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_document_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete document record
	public function delete_imgdocument() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_imgdocument_record($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_img_document_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete qualification record
	public function delete_qualification() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_qualification_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_qualification_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete work_experience record
	public function delete_work_experience() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_work_experience_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_work_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete bank_account record
	public function delete_bank_account() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_bank_account_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_bankaccount_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete contract record
	public function delete_contract() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_contract_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_contract_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete leave record
	public function delete_leave() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_leave_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_leave_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete shift record
	public function delete_shift() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_shift_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_shift_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete location record
	public function delete_location() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_location_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_location_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete employee record
	public function delete() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_current_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// Validate and update info in database // basic info
	public function update_salary_option() {
	
		if($this->input->post('type')=='employee_update_salary') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('basic_salary')==='') {
			$Return['error'] = $this->lang->line('xin_employee_salary_error_basic');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'wages_type' => $this->input->post('wages_type'),
		'basic_salary' => $this->input->post('basic_salary')
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->basic_info($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_updated_salary_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // basic info
	public function set_overtime() {
	
		if($this->input->post('type')=='emp_overtime') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('overtime_type')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_title_error');
		} else if($this->input->post('no_of_days')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_no_of_days_error');
		} else if($this->input->post('overtime_hours')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_hours_error');
		} else if($this->input->post('overtime_rate')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_rate_error');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'employee_id' => $this->input->post('user_id'),
		'overtime_type' => $this->input->post('overtime_type'),
		'no_of_days' => $this->input->post('no_of_days'),
		'overtime_hours' => $this->input->post('overtime_hours'),
		'overtime_rate' => $this->input->post('overtime_rate')
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->add_salary_overtime($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_added_overtime_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // basic info
	public function update_overtime_info() {
	
		if($this->input->post('type')=='e_overtime_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('overtime_type')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_title_error');
		} else if($this->input->post('no_of_days')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_no_of_days_error');
		} else if($this->input->post('overtime_hours')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_hours_error');
		} else if($this->input->post('overtime_rate')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_rate_error');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$id = $this->input->post('e_field_id');
		$data = array(
		'overtime_type' => $this->input->post('overtime_type'),
		'no_of_days' => $this->input->post('no_of_days'),
		'overtime_hours' => $this->input->post('overtime_hours'),
		'overtime_rate' => $this->input->post('overtime_rate')
		);
		//$id = $this->input->post('user_id');
		$result = $this->Employees_model->salary_overtime_update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_updated_overtime_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // basic info
	public function employee_allowance_option() {
	
		if($this->input->post('type')=='employee_update_allowance') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('allowance_title')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_allowance_title_error');
		} else if($this->input->post('allowance_amount')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_allowance_amount_error');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'allowance_title' => $this->input->post('allowance_title'),
		'allowance_amount' => $this->input->post('allowance_amount'),
		'employee_id' => $this->input->post('user_id'),
		'is_allowance_taxable' => $this->input->post('is_allowance_taxable')
		);
		$result = $this->Employees_model->add_salary_allowances($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_set_allowance_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database // basic info
	public function employee_commissions_option() {
	
		if($this->input->post('type')=='employee_update_commissions') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'commission_title' => $this->input->post('title'),
		'commission_amount' => $this->input->post('amount'),
		'employee_id' => $this->input->post('user_id')
		);
		$result = $this->Employees_model->add_salary_commissions($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_set_commission_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database // basic info
	public function set_statutory_deductions() {
	
		if($this->input->post('type')=='statutory_deductions_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'deduction_title' => $this->input->post('title'),
		'deduction_amount' => $this->input->post('amount'),
		'statutory_options' => $this->input->post('statutory_options'),
		'employee_id' => $this->input->post('user_id')
		);
		$result = $this->Employees_model->add_salary_statutory_deductions($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_set_statutory_deduction_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database // basic info
	public function set_other_payments() {
	
		if($this->input->post('type')=='other_payments_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'payments_title' => $this->input->post('title'),
		'payments_amount' => $this->input->post('amount'),
		'employee_id' => $this->input->post('user_id')
		);
		$result = $this->Employees_model->add_salary_other_payments($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_set_otherpayments_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// delete allowances record
	public function delete_all_allowances() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_allowance_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_allowance_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete commissions record
	public function delete_all_commissions() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_commission_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_commission_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete statutory_deductions record
	public function delete_all_statutory_deductions() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_statutory_deductions_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_statutory_deduction_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete other payments record
	public function delete_all_other_payments() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_other_payments_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_otherpayments_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete deductions record
	public function delete_all_deductions() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_loan_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_loan_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete overtime record
	public function delete_emp_overtime() {
		
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_overtime_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_overtime_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// employee all_allowances
	public function salary_all_allowances() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$allowances = $this->Employees_model->set_employee_allowances($id);
		
		$data = array();
		/*$system = $this->Xin_model->read_setting_info(1);
		$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/

        foreach($allowances->result() as $r) {			
		//$current_amount = $r->allowance_amount * $current_rate;
		if($r->is_allowance_taxable==0){
			$allowance_opt = $this->lang->line('xin_salary_allowance_non_taxable');
		} else {
			$allowance_opt = $this->lang->line('xin_salary_allowance_taxable');
		}
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->allowance_id . '" data-field_type="salary_allowance"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->allowance_id . '" data-token_type="all_allowances"><span class="fas fa-trash-restore"></span></button></span>',
			$allowance_opt,
			$r->allowance_title,
			$r->allowance_amount
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $allowances->num_rows(),
			 "recordsFiltered" => $allowances->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 // employee commissions
	public function salary_all_commissions() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$commissions = $this->Employees_model->set_employee_commissions($id);
		
		$data = array();

        foreach($commissions->result() as $r) {			
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->salary_commissions_id . '" data-field_type="salary_commissions"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->salary_commissions_id . '" data-token_type="all_commissions"><span class="fas fa-trash-restore"></span></button></span>',
			$r->commission_title,
			$r->commission_amount
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $commissions->num_rows(),
			 "recordsFiltered" => $commissions->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	  // employee statutory_deductions
	public function salary_all_statutory_deductions() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$statutory_deductions = $this->Employees_model->set_employee_statutory_deductions($id);
		
		$data = array();

        foreach($statutory_deductions->result() as $r) {			
		if($r->statutory_options==1){
			$sd_opt = $this->lang->line('xin_sd_ssc_title');
		} else if($r->statutory_options==2){
			$sd_opt = $this->lang->line('xin_sd_phic_title');
		} else if($r->statutory_options==3){
			$sd_opt = $this->lang->line('xin_sd_hdmf_title');
		} else if($r->statutory_options==4){
			$sd_opt = $this->lang->line('xin_sd_wht_title');
		} else {
			$sd_opt = $this->lang->line('xin_sd_other_sd_title');
		}
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->statutory_deductions_id . '" data-field_type="salary_statutory_deductions"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->statutory_deductions_id . '" data-token_type="all_statutory_deductions"><span class="fas fa-trash-restore"></span></button></span>',
			$sd_opt,
			$r->deduction_title,
			$r->deduction_amount
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $statutory_deductions->num_rows(),
			 "recordsFiltered" => $statutory_deductions->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	   // employee other payments
	public function salary_all_other_payments() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$other_payment = $this->Employees_model->set_employee_other_payments($id);
		
		$data = array();

        foreach($other_payment->result() as $r) {			
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->other_payments_id . '" data-field_type="salary_other_payments"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->other_payments_id . '" data-token_type="all_other_payments"><span class="fas fa-trash-restore"></span></button></span>',
			$r->payments_title,
			$r->payments_amount
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $other_payment->num_rows(),
			 "recordsFiltered" => $other_payment->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // employee overtime
	public function salary_overtime() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$overtime = $this->Employees_model->set_employee_overtime($id);
		$system = $this->Xin_model->read_setting_info(1);
		$data = array();

        foreach($overtime->result() as $r) {			
		$current_amount = $r->overtime_rate;
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->salary_overtime_id . '" data-field_type="emp_overtime"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->salary_overtime_id . '" data-token_type="emp_overtime"><span class="fas fa-trash-restore"></span></button></span>',
			$r->overtime_type,
			$r->no_of_days,
			$r->overtime_hours,
			$current_amount
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $overtime->num_rows(),
			 "recordsFiltered" => $overtime->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // employee salary_all_deductions
	public function salary_all_deductions() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/employee_detail", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$deductions = $this->Employees_model->set_employee_deductions($id);
		/*$system = $this->Xin_model->read_setting_info(1);
		$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
		$data = array();

        foreach($deductions->result() as $r) {		
		
		$sdate = $this->Xin_model->set_date_format($r->start_date);
		$edate = $this->Xin_model->set_date_format($r->end_date);	
		// loan time
		if($r->loan_time < 2) {
			$loan_time = $r->loan_time. ' '.$this->lang->line('xin_employee_loan_time_single_month');
		} else {
			$loan_time = $r->loan_time. ' '.$this->lang->line('xin_employee_loan_time_more_months');
		}
		if($r->loan_options == 1) {
			$loan_options = $this->lang->line('xin_loan_ssc_title');
		} else if($r->loan_options == 2) {
			$loan_options = $this->lang->line('xin_loan_hdmf_title');
		} else {
			$loan_options = $this->lang->line('xin_loan_other_sd_title');
		}
		$loan_details = '<div class="text-semibold">'.$this->lang->line('dashboard_xin_title').': '.$r->loan_deduction_title.'</div>
								<div class="text-muted">'.$this->lang->line('xin_salary_loan_options').': '.$loan_options.'</div><div class="text-muted">'.$this->lang->line('xin_start_date').': '.$sdate.'</div><div class="text-muted">'.$this->lang->line('xin_end_date').': '.$edate.'</div><div class="text-muted">'.$this->lang->line('xin_reason').': '.$r->reason.'</div>';
		//$eoption_removed = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->loan_deduction_id . '" data-field_type="salary_loan"><span class="fas fa-pencil-alt"></span></button></span>';
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->loan_deduction_id . '" data-token_type="all_deductions"><span class="fas fa-trash-restore"></span></button></span>',
			$loan_details,
			$r->monthly_installment,
			$loan_time
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $deductions->num_rows(),
			 "recordsFiltered" => $deductions->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // Validate and add info in database
	public function update_loan_info() {
	
		if($this->input->post('type')=='loan_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		
		$id = $this->input->post('e_field_id');
		
		/* Server side PHP input validation */		
		if($this->input->post('loan_deduction_title')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_loan_title_error');
		} else if($this->input->post('monthly_installment')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_mins_title_error');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'loan_deduction_title' => $this->input->post('loan_deduction_title'),
		'reason' => $qt_reason,
		'monthly_installment' => $this->input->post('monthly_installment'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'loan_options' => $this->input->post('loan_options')
		);
		
		$result = $this->Employees_model->salary_loan_update_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_update_loan_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	 // Validate and add info in database
	public function employee_loan_info() {
	
		if($this->input->post('type')=='loan_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		
		$user_id = $this->input->post('user_id');
		
		/* Server side PHP input validation */		
		if($this->input->post('loan_deduction_title')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_loan_title_error');
		} else if($this->input->post('monthly_installment')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_mins_title_error');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$tm = $this->Employees_model->get_month_diff($this->input->post('start_date'),$this->input->post('end_date'));
		if($tm < 1) {
			$m_ins = $this->input->post('monthly_installment');
		} else {
			$m_ins = $this->input->post('monthly_installment')/$tm;
		}
	
		$data = array(
		'loan_deduction_title' => $this->input->post('loan_deduction_title'),
		'reason' => $qt_reason,
		'monthly_installment' => $this->input->post('monthly_installment'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'loan_options' => $this->input->post('loan_options'),
		'loan_time' => $tm,
		'loan_deduction_amount' => $m_ins,
		'employee_id' => $user_id
		);
		
		$result = $this->Employees_model->add_salary_loan($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_add_loan_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// get company > locations
	 public function filter_company_flocations() {

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
				$this->load->view("admin/filter/filter_company_flocations", $data);
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
	 public function filter_location_fdepartments() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'location_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/filter/filter_location_fdepartments", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 public function filter_location_fdesignation() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/filter/filter_location_fdesignation", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	  public function expired_documents() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_e_details_exp_documents').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_e_details_exp_documents');
		$data['path_url'] = 'employees_expired_documents';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('400',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/expired_documents_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 // employee documents - listing
	public function expired_documents_list() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/expired_documents_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$documents = $this->Employees_model->get_documents_expired_all();
		} else {
			$documents = $this->Employees_model->get_user_documents_expired_all($session['user_id']);
		}
		
		
		$data = array();

        foreach($documents->result() as $r) {
			
			$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->document_type;
			} else {
				$document_d = '--';
			}
			$date_of_expiry = $this->Xin_model->set_date_format($r->date_of_expiry);
			if($r->document_file!='' && $r->document_file!='no file') {
			 $functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="Download"><a href="'.site_url().'admin/download?type=document&filename='.$r->document_file.'"><button type="button" class="btn icon-btn btn-outline-secondary btn-sm waves-effect waves-light" title="'.$this->lang->line('xin_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			 } else {
				 $functions ='';
			 }
			 //userinfo
			$xuser_info = $this->Xin_model->read_user_info($r->employee_id);	
			if(!is_null($xuser_info)){
				if($user_info[0]->user_role_id==1){
					$fc_name = '<a target="_blank" href="'.site_url('admin/employees/detail/').$r->employee_id.'">'.$xuser_info[0]->first_name.' '.$xuser_info[0]->last_name.'</a>';
				} else {
					$fc_name = $xuser_info[0]->first_name.' '.$xuser_info[0]->last_name;
				}
			} else {
				$fc_name = '--';	
			}
			$data[] = array(
				$functions.'<span data-toggle="tooltip" data-placement="top" data-state="primary"  title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->document_id . '" data-field_type="document"><i class="fas fa-pencil-alt"></i></button></span>',
			$fc_name,
			$document_d,
			$r->title,
			$date_of_expiry
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $documents->num_rows(),
			 "recordsFiltered" => $documents->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	  // employee immigration - listing
	public function expired_immigration_list() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/expired_documents_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
	//	$id = $this->uri->segment(4);
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$immigration = $this->Employees_model->get_img_documents_expired_all();
		} else {
			$immigration = $this->Employees_model->get_user_img_documents_expired_all($session['user_id']);
		}
		
		
		$data = array();

        foreach($immigration->result() as $r) {
			
		$issue_date = $this->Xin_model->set_date_format($r->issue_date);
		$expiry_date = $this->Xin_model->set_date_format($r->expiry_date);
		$eligible_review_date = $this->Xin_model->set_date_format($r->eligible_review_date);
		$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
		if(!is_null($d_type)){
			$document_d = $d_type[0]->document_type.'<br>'.$r->document_number;
		} else {
			$document_d = $r->document_number;
		}
		$country = $this->Xin_model->read_country_info($r->country_id);
		if(!is_null($country)){
			$c_name = $country[0]->country_name;
		} else {
			$c_name = '--';	
		}
		//userinfo
		$xuser_info = $this->Xin_model->read_user_info($r->employee_id);	
		if(!is_null($xuser_info)){
			if($user_info[0]->user_role_id==1){
				$fc_name = '<a target="_blank" href="'.site_url('admin/employees/detail/').$r->employee_id.'">'.$xuser_info[0]->first_name.' '.$xuser_info[0]->last_name.'</a>';
			} else {
				$fc_name = $xuser_info[0]->first_name.' '.$xuser_info[0]->last_name;
			}
		} else {
			$fc_name = '--';	
		}
		if($r->document_file!='' && $r->document_file!='no file') {
		 	$functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="Download"><a href="'.site_url().'admin/download?type=document/immigration&filename='.$r->document_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('xin_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
		 } else {
			 $functions ='';
		 }
		$data[] = array(
			$functions.'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->immigration_id . '" data-field_type="imgdocument"><i class="fas fa-pencil-alt"></i></button></span>',
			$fc_name,
			$document_d,
			$issue_date,
			$expiry_date,
			$c_name,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $immigration->num_rows(),
			 "recordsFiltered" => $immigration->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 public function exp_company_license_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/employees/expired_documents_list", $data);
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
			$company = $this->Employees_model->company_license_expired_all();
		} else {
			$company = $this->Employees_model->get_company_license_expired($user_info[0]->company_id);
		}
		$data = array();

          foreach($company->result() as $r) {
			  			  
			  if(in_array('247',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-field_id="'. $r->document_id . '" data-field_type="company_license_expired"><i class="fas fa-pencil-alt"></i></button></span>';
			} else {
				$edit = '';
			}
			$company_id = $this->Company_model->read_company_information($r->company_id);
			if(!is_null($company_id)){
				$company_name = $company_id[0]->name;
			} else {
				$company_name = '--';	
			}
			
			if($r->document!='' && $r->document!='no file') {
				 $doc_view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_download').'"><a href="'.base_url().'admin/download?type=company/official_documents&filename='.$r->document.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('xin_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			 } else {
				 $doc_view ='';
			 }
			$combhr = $doc_view.$edit;
			$ilicense_name = $r->license_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_hr_official_license_number').': '.$r->license_number.'<i></i></i></small>';
		   $data[] = array(
				$combhr,
				$ilicense_name,
				$company_name,
				$r->expiry_date
		   );
          }
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $company->num_rows(),
                 "recordsFiltered" => $company->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // assets warranty list
	public function assets_warranty_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/employees/expired_documents_list", $data);
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
			$assets = $this->Employees_model->warranty_assets_expired_all();
		} else {
			if(in_array('265',$role_resources_ids)) {
				$assets = $this->Employees_model->company_warranty_assets_expired_all($user_info[0]->company_id);
			} else {
				$assets = $this->Employees_model->user_warranty_assets_expired_all($session['user_id']);
			}
		}
		$data = array();
		
          foreach($assets->result() as $r) {						
			
			// get category
			$assets_category = $this->Assets_model->read_assets_category_info($r->assets_category_id);
			if(!is_null($assets_category)){
				$category = $assets_category[0]->category_name;
			} else {
			 	$category = '--';	
			}
			//working?
			if($r->is_working==1){
				$working = $this->lang->line('xin_yes');
			} else {
				$working = $this->lang->line('xin_no');
			}
			// get user > added by
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			if(in_array('263',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->assets_id . '" data-field_type="assets_warranty_expired"><i class="fas fa-pencil-alt"></i></button></span>';
			} else {
				$edit = '';
			}
			
			if(in_array('265',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-asset_id="'. $r->assets_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit;
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			$iname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_created_at').': '.$created_at.'<i></i></i></small>';					 			  				
			$data[] = array($combhr,
				$iname,
				$category,
				$r->company_asset_code,
				$working,
				$full_name
			);
		}
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $assets->num_rows(),
                 "recordsFiltered" => $assets->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 public function dialog_exp_document() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Employees_model->read_document_information($id);
		$data = array(
				'document_id' => $document[0]->document_id,
				'document_type_id' => $document[0]->document_type_id,
				'd_employee_id' => $document[0]->employee_id,
				'all_document_types' => $this->Employees_model->all_document_types(),
				'date_of_expiry' => $document[0]->date_of_expiry,
				'title' => $document[0]->title,
				'is_alert' => $document[0]->is_alert,
				'description' => $document[0]->description,
				'notification_email' => $document[0]->notification_email,
				'document_file' => $document[0]->document_file
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_exp_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_exp_imgdocument() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Employees_model->read_imgdocument_information($id);
		$data = array(
				'immigration_id' => $document[0]->immigration_id,
				'document_type_id' => $document[0]->document_type_id,
				'd_employee_id' => $document[0]->employee_id,
				'all_document_types' => $this->Employees_model->all_document_types(),
				'all_countries' => $this->Xin_model->get_countries(),
				'document_number' => $document[0]->document_number,
				'document_file' => $document[0]->document_file,
				'issue_date' => $document[0]->issue_date,
				'expiry_date' => $document[0]->expiry_date,
				'country_id' => $document[0]->country_id,
				'eligible_review_date' => $document[0]->eligible_review_date,
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_exp_details', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_exp_company_license_expired() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_document_info($id);
		$data = array(
				'document_id' => $result[0]->document_id,
				'license_name' => $result[0]->license_name,
				'company_id' => $result[0]->company_id,
				'expiry_date' => $result[0]->expiry_date,
				'license_number' => $result[0]->license_number,
				'license_notification' => $result[0]->license_notification,
				'document' => $result[0]->document,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/employees/dialog_employee_exp_details', $data);
	}
	public function dialog_exp_assets_warranty_expired() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Assets_model->read_assets_info($id);
		$data = array(
			'assets_id' => $result[0]->assets_id,
			'assets_category_id' => $result[0]->assets_category_id,
			'company_id' => $result[0]->company_id,
			'employee_id' => $result[0]->employee_id,
			'company_asset_code' => $result[0]->company_asset_code,
			'name' => $result[0]->name,
			'purchase_date' => $result[0]->purchase_date,
			'invoice_number' => $result[0]->invoice_number,
			'manufacturer' => $result[0]->manufacturer,
			'serial_number' => $result[0]->serial_number,
			'warranty_end_date' => $result[0]->warranty_end_date,
			'asset_note' => $result[0]->asset_note,
			'asset_image' => $result[0]->asset_image,
			'is_working' => $result[0]->is_working,
			'created_at' => $result[0]->created_at,
			'all_employees' => $this->Xin_model->all_employees(),
			'all_assets_categories' => $this->Assets_model->get_all_assets_categories(),
			'all_companies' => $this->Xin_model->get_companies()
			);
		$this->load->view('admin/employees/dialog_employee_exp_details', $data);
	}
	public function dialog_security_level() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_security_level_information($id);
		$data = array(
				'security_level_id' => $result[0]->security_level_id,
				'employee_id' => $result[0]->employee_id,
				'security_type' => $result[0]->security_type,
				'date_of_clearance' => $result[0]->date_of_clearance,
				'expiry_date' => $result[0]->expiry_date
				);
		if(!empty($session)){ 
			$this->load->view('admin/employees/dialog_employee_details', $data);
		} else {
			redirect('admin/');
		}
	}
}
