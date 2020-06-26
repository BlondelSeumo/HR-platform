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

class Timesheet extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Timesheet_model");
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");
		$this->load->library('email');
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Project_model");
		$this->load->model("Location_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 // daily attendance > timesheet
	 public function attendance()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('dashboard_attendance').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('dashboard_attendance');
		$data['path_url'] = 'attendance';
		$data['all_office_shifts'] = $this->Location_model->all_office_locations();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('28',$role_resources_ids)) {
			if(!empty($session)){
			$data['subview'] = $this->load->view("admin/timesheet/attendance_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/dashboard/');
			}	
		} else {
			redirect('admin/dashboard');
		}	  
     }
	 public function attendance_dashboard()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('hr_timesheet_dashboard_title').' | '.$this->Xin_model->site_title();
		
		$data['breadcrumbs'] = $this->lang->line('hr_timesheet_dashboard_title');
		$data['path_url'] = 'attendance_dashboard';
		//$data['get_invoice_payments'] = $this->Finance_model->get_invoice_payments();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('423',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/attendance_dashboard", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 // date wise date_wise_attendance > timesheet
	 public function date_wise_attendance()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_date_wise_attendance').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_date_wise_attendance');
		$data['path_url'] = 'date_wise_attendance';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('29',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/timesheet/date_wise", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}  
     }
	 
	 // update_attendance > timesheet
	 public function update_attendance()
     {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_update_attendance').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_update_attendance');
		$data['path_url'] = 'update_attendance';		
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('30',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/update_attendance", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
     }
	 
	 // import > timesheet
	 public function import() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_import_attendance').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_import_attendance');
		$data['path_url'] = 'import_attendance';		
		$data['all_employees'] = $this->Xin_model->all_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('31',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/attendance_import", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 // index > timesheet
	 public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$month_year = $this->input->post('month_year');
		if(isset($month_year)): $title = date('F Y', strtotime($month_year)); else: $title = date('F Y'); endif;
		$data['title'] = $this->lang->line('left_timesheet').' | '.$title;
		$data['breadcrumbs'] = $this->lang->line('left_timesheet');
		$data['path_url'] = 'timesheet_monthly';		
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_office_shifts'] = $this->Location_model->all_office_locations();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('10',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/timesheet_monthly", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 // timecard > timesheet
	 public function timecalendar() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_attendance_timecalendar').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_attendance_timecalendar');
		$data['path_url'] = 'timesheet_calendar';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('261',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/calendar/timecalendar", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
	// Validate and add info in database
	public function import_attendance() {
	
		if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
		if(empty($_FILES['file']['name'])) {
			$Return['error'] = $this->lang->line('xin_attendance_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 512000) {
						$Return['error'] = $this->lang->line('xin_error_attendance_import_size');
					} else {
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					//skip first line
					fgetcsv($csvFile);
					
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
							
						$attendance_date = $line[1];
						$clock_in = $line[2];
						$clock_out = $line[3];
						$clock_in2 = $attendance_date.' '.$clock_in;
						$clock_out2 = $attendance_date.' '.$clock_out;
						
						//total work
						$total_work_cin =  new DateTime($clock_in2);
						$total_work_cout =  new DateTime($clock_out2);
						
						$interval_cin = $total_work_cout->diff($total_work_cin);
						$hours_in   = $interval_cin->format('%h');
						$minutes_in = $interval_cin->format('%i');
						$total_work = $hours_in .":".$minutes_in;
						
						$user = $this->Xin_model->read_user_by_employee_id($line[0]);
						if(!is_null($user)){
							$user_id = $user[0]->user_id;
						} else {
							$user_id = '0';
						}
					
						$data = array(
						'employee_id' => $user_id,
						'attendance_date' => $attendance_date,
						'clock_in' => $clock_in2,
						'clock_out' => $clock_out2,
						'time_late' => $clock_in2,
						'total_work' => $total_work,
						'early_leaving' => $clock_out2,
						'overtime' => $clock_out2,
						'attendance_status' => 'Present',
						'clock_in_out' => '0'
						);
					$result = $this->Timesheet_model->add_employee_attendance($data);
				}					
				//close opened csv file
				fclose($csvFile);
	
				$Return['result'] = $this->lang->line('xin_success_attendance_import');
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_attendance_import');
			}
		}else{
			$Return['error'] = $this->lang->line('xin_error_invalid_file');
		}
		} // file empty
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		$this->output($Return);
		exit;
		}
	}
	 
	  // office shift > timesheet
	 public function office_shift() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_office_shift').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_office_shift');
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'office_shift';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('7',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/office_shift", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 // holidays > timesheet
	 public function holidays() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->lang->line('left_holidays').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_holidays');
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'holidays';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('8',$role_resources_ids)) {
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/timesheet/holidays", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 // leave > timesheet
	 public function leave() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_leave').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$data['breadcrumbs'] = $this->lang->line('left_leave');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['path_url'] = 'leave';
		
		
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		if(in_array('46',$role_resources_ids) || $reports_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/leave", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 // leave > timesheet
	 public function leave_details() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$leave_id = $this->uri->segment(5);
		// leave applications
		$result = $this->Timesheet_model->read_leave_information($leave_id);
		if(is_null($result)){
			redirect('admin/timesheet/leave');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Xin_model->update_notification_record($edata,$leave_id,$session['user_id'],'leave');
		// get leave types
		$type = $this->Timesheet_model->read_leave_type_information($result[0]->leave_type_id);
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
		} else {
			$type_name = '--';	
		}
		// get employee
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
		if(!is_null($user)){
			$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
			$u_role_id = $user[0]->user_role_id;
			$department = $this->Department_model->read_department_information($user[0]->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';	
			}
		} else {
			$full_name = '--';	
			$u_role_id = '--';
			$department_name = '--';
		}			 
		
		$data = array(
				'title' => $this->lang->line('xin_leave_detail').' | '.$this->Xin_model->site_title(),
				'type' => $type_name,
				'role_id' => $u_role_id,
				'full_name' => $full_name,
				'eemployee_id' => $result[0]->employee_id,
				'department_name' => $department_name,
				'leave_id' => $result[0]->leave_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'leave_type_id' => $result[0]->leave_type_id,
				'from_date' => $result[0]->from_date,
				'to_date' => $result[0]->to_date,
				'applied_on' => $result[0]->applied_on,
				'reason' => $result[0]->reason,
				'remarks' => $result[0]->remarks,
				'status' => $result[0]->status,
				'leave_attachment' => $result[0]->leave_attachment,
				'is_half_day' => $result[0]->is_half_day,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_leave_types' => $this->Timesheet_model->all_leave_types(),
				);
		$data['breadcrumbs'] = $this->lang->line('xin_leave_detail');
		$data['path_url'] = 'leave_details';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		if(in_array('46',$role_resources_ids) || $reports_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/leave_details", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
		  
     }
	 
	 // leave > timesheet
	 public function task_details() {
		
		$session = $this->session->userdata('username');
		$data['title'] = $this->Xin_model->site_title();
		
		$task_id = $this->uri->segment(5);
		$result = $this->Timesheet_model->read_task_information($task_id);
		if(is_null($result)){
			redirect('admin/timesheet/tasks');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Xin_model->update_notification_record($edata,$task_id,$session['user_id'],'tasks');
		/* get User info*/
		$u_created = $this->Xin_model->read_user_info($result[0]->created_by);
		
		if(!is_null($u_created)){
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
		} else {
			$f_name = '--';	
		}
		
		// task project
		$prj_task = $this->Project_model->read_project_information($result[0]->project_id);
		if(!is_null($prj_task)){
			$prj_name = $prj_task[0]->title;
		} else {
			$prj_name = '--';
		}
		
		$data = array(
		'title' => $this->lang->line('xin_task_detail').' | '.$this->Xin_model->site_title(),
		'task_id' => $result[0]->task_id,
		'project_name' => $prj_name,
		'created_by' => $f_name,
		'task_name' => $result[0]->task_name,
		'assigned_to' => $result[0]->assigned_to,
		'start_date' => $result[0]->start_date,
		'end_date' => $result[0]->end_date,
		'task_hour' => $result[0]->task_hour,
		'task_status' => $result[0]->task_status,
		'task_note' => $result[0]->task_note,
		'progress' => $result[0]->task_progress,
		'description' => $result[0]->description,
		'created_at' => $result[0]->created_at,
		'all_employees' => $this->Xin_model->all_employees()
		);
		$data['breadcrumbs'] = $this->lang->line('xin_task_detail');
		$data['path_url'] = 'task_details';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('45',$role_resources_ids)) {
		if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/tasks/task_details", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
		  
     }
	 
	 // tasks > timesheet
	 public function tasks() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_tasks').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_projects'] = $this->Project_model->get_all_projects();
		$data['breadcrumbs'] = $this->lang->line('left_tasks');
		$data['path_url'] = 'tasks';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('45',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/timesheet/tasks/task_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
     }
	 
	// Validate and update info in database // assign_ticket
	public function assign_task() {
	
		if($this->input->post('type')=='task_user') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();		
		
		if(null!=$this->input->post('assigned_to')) {
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
			$employee_ids = $assigned_ids;
		} else {
			$employee_ids = '';
		}
	
		$data = array(
		'assigned_to' => $employee_ids
		);
		$id = $this->input->post('task_id');
		$result = $this->Timesheet_model->assign_task_user($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_assigned');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// update task user > task details
	public function task_users() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'task_id' => $id,
			'all_employees' => $this->Xin_model->all_employees(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/get_task_users", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	  // Validate and update info in database // update_status
	public function update_task_status() {
	
		if($this->input->post('type')=='update_status') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();		
			
		$data = array(
		'task_progress' => $this->input->post('progres_val'),
		'task_status' => $this->input->post('status'),
		);
		$id = $this->input->post('task_id');
		$result = $this->Timesheet_model->update_task_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_status');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 // task list > timesheet
	 public function task_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/leave", $data);
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
			$task = $this->Timesheet_model->get_tasks();
		} else {
			if(in_array('322',$role_resources_ids)) {
				$task = $this->Timesheet_model->get_company_tasks($user_info[0]->company_id);
			} else {
				$task = $this->Timesheet_model->get_employee_tasks($session['user_id']);
			}
		}
		$data = array();

          foreach($task->result() as $r) {
			$aim = explode(',',$r->assigned_to);
				  
				if($r->assigned_to == '' || $r->assigned_to == 'None') {
					$ol = 'None';
				} else {
					$ol = '';
					foreach(explode(',',$r->assigned_to) as $uid) {
						//$user = $this->Xin_model->read_user_info($uid);
						$assigned_to = $this->Xin_model->read_user_info($uid);
						if(!is_null($assigned_to)){
							
						$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
						 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
							} else {
							if($assigned_to[0]->gender=='Male') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							 } else {
								$de_file = base_url().'uploads/profile/default_female.jpg';
							 }
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
							}
						}
					 }
				 $ol .= '';
				}
				//$ol = 'A';
				/* get User info*/
				$u_created = $this->Xin_model->read_user_info($r->created_by);
				if(!is_null($u_created)){
					$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
				} else {
					$f_name = '--';	
				}
				
				// task project
				$prj_task = $this->Project_model->read_project_information($r->project_id);
				if(!is_null($prj_task)){
					$prj_name = $prj_task[0]->title;
				} else {
					$prj_name = '--';
				}
				// task category
				$task_catname = $r->task_name;
				
				/// set task progress
				if($r->task_progress=='' || $r->task_progress==0): $progress = 0; else: $progress = $r->task_progress; endif;				
				// task progress
				if($r->task_progress <= 20) {
				$progress_class = 'progress-bar-danger';
				} else if($r->task_progress > 20 && $r->task_progress <= 50){
				$progress_class = 'progress-bar-warning';
				} else if($r->task_progress > 50 && $r->task_progress <= 75){
				$progress_class = 'progress-bar-info';
				} else {
				$progress_class = 'progress-bar-success';
				}
				
				$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->task_progress.'%</span>
	<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$r->task_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$r->task_progress.'%"></div></div></p>';
				// task status			
				if($r->task_status == 0) {
					$status = '<span class="label label-warning">'.$this->lang->line('xin_not_started').'</span>';
				} else if($r->task_status ==1){
					$status = '<span class="label label-primary">'.$this->lang->line('xin_in_progress').'</span>';
				} else if($r->task_status ==2){
					$status = '<span class="label label-success">'.$this->lang->line('xin_completed').'</span>';
				} else if($r->task_status ==3){
					$status = '<span class="label label-danger">'.$this->lang->line('xin_project_cancelled').'</span>';
				} else {
					$status = '<span class="label label-danger">'.$this->lang->line('xin_project_hold').'</span>';
				}
				// task start/end date
				$psdate = $this->Xin_model->set_date_format($r->start_date);
				$pedate = $this->Xin_model->set_date_format($r->end_date);
				if(in_array('320',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-task_id="'. $r->task_id.'" data-mname="admin"><span class="fas fa-pencil-alt"></span></button></span>';
					$add_users = ' <a href="javascript:void(0)" class="text-muted" data-toggle="modal" data-target=".edit-modal-data" data-task_id="'. $r->task_id . '" ><span class="ion ion-md-add" data-placement="top" data-state="primary" data-toggle="tooltip" title="'.$this->lang->line('xin_add_member').'"></span></a> ';
				} else {
					$edit = '';
					$add_users = '';
				}
				if(in_array('321',$role_resources_ids)) { // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->task_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$delete = '';
				}
				if(in_array('322',$role_resources_ids)) { //view
					$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/task_details/id/'.$r->task_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
				} else {
					$view = '';
				}
				$combhr = $edit.$view.$delete;
			  $ttask_date = $this->lang->line('xin_start_date').': '.$psdate.'<br>'.$this->lang->line('xin_end_date').': '.$pedate;				
			   $data[] = array(
					$combhr,
					$task_catname.'<br>'.$this->lang->line('xin_project').': <a href="'.site_url().'admin/project/detail/'.$r->project_id.'">'.$prj_name.'</a><br>'.$this->lang->line('xin_hours').': '.$r->task_hour,
					$ol.$add_users,
					$ttask_date,
					$status,
					
					$f_name,
					$progress_bar
			   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $task->num_rows(),
			 "recordsFiltered" => $task->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // project task list > timesheet
	 public function project_task_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);		
		$task = $this->Timesheet_model->get_project_tasks($id);
		
		$data = array();

          foreach($task->result() as $r) {
			  
			if($r->assigned_to == '' || $r->assigned_to == 'None') {
				$ol = $this->lang->line('xin_performance_none');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $uid) {
					$assigned_to = $this->Xin_model->read_user_info($uid);
					if(!is_null($assigned_to)){
					$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
					if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
						if($assigned_to[0]->gender=='Male') { 
							$de_file = base_url().'uploads/profile/default_male.jpg';
						 } else {
							$de_file = base_url().'uploads/profile/default_female.jpg';
						 }
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
						}
					//
					}
				 }
			 $ol .= '';
			}
			//$ol = 'A';
			/* get User info*/
			$u_created = $this->Xin_model->read_user_info($r->created_by);
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			// task category
			$task_catname = $r->task_name;
			/// set task progress
			if($r->task_progress=='' || $r->task_progress==0): $progress = 0; else: $progress = $r->task_progress; endif;
			
			
			// task progress
			if($r->task_progress <= 20) {
			$progress_class = 'progress-danger';
			} else if($r->task_progress > 20 && $r->task_progress <= 50){
			$progress_class = 'progress-warning';
			} else if($r->task_progress > 50 && $r->task_progress <= 75){
			$progress_class = 'progress-info';
			} else {
			$progress_class = 'progress-success';
			}
			
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->task_progress.'%</span></p><div class="progress" style="height: 7px;"><div class="progress-bar" style="width: '.$r->task_progress.'%;"></div></div>';
			
			
			// task status
			if($r->task_status == 0) {
				$status = $this->lang->line('xin_not_started');
			} else if($r->task_status ==1){
				$status = $this->lang->line('xin_in_progress');
			} else if($r->task_status ==2){
				$status = $this->lang->line('xin_completed');
			} else if($r->task_status ==3){
				$status = $this->lang->line('xin_project_cancelled');
			} else {
				$status = $this->lang->line('xin_project_hold');
			}
			
			// task end date
			$tdate = $this->Xin_model->set_date_format($r->end_date);
			 			
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/task_details/id/'.$r->task_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-task_id="'. $r->task_id.'" data-mname="hr"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-task" data-toggle="modal" data-target=".delete-modal-task" data-record-id="'. $r->task_id . '"><span class="fas fa-trash-restore"></span></button></span>',
				$task_catname,
				$tdate,
				$status,
				$ol,
				$f_name,
				$progress_bar
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $task->num_rows(),
			 "recordsFiltered" => $task->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // project variation list > timesheet
	 public function project_variation_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);		
		$task = $this->Timesheet_model->get_project_variations($id);
		
		$data = array();

          foreach($task->result() as $r) {
			  
			if($r->assigned_to == '' || $r->assigned_to == 'None') {
				$ol = $this->lang->line('xin_performance_none');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $uid) {
					$assigned_to = $this->Xin_model->read_user_info($uid);
					if(!is_null($assigned_to)){
					$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
					if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
						if($assigned_to[0]->gender=='Male') { 
							$de_file = base_url().'uploads/profile/default_male.jpg';
						 } else {
							$de_file = base_url().'uploads/profile/default_female.jpg';
						 }
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
						}
					//
					}
				 }
			 $ol .= '';
			}
			//$ol = 'A';
			/* get User info*/
			$u_created = $this->Xin_model->read_user_info($r->created_by);
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			// variation category
			$task_cat = $this->Project_model->read_task_category_information($r->variation_name);
			if(!is_null($task_cat)){
				$task_catname = $task_cat[0]->category_name;
			} else {
				$task_catname = '--';
			}											
			
			// variation status
			if($r->variation_status == 0) {
				$status = '<span class="label label-warning">'.$this->lang->line('xin_not_started').'</span>';
			} else if($r->variation_status ==1){
				$status = '<span class="label label-primary">'.$this->lang->line('xin_in_progress').'</span>';
			} else if($r->variation_status ==2){
				$status = '<span class="label label-success">'.$this->lang->line('xin_completed').'</span>';
			} else if($r->variation_status ==3){
				$status = '<span class="label label-danger">'.$this->lang->line('xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.$this->lang->line('xin_project_hold').'</span>';
			}
			if($r->client_approval == 0) {
				$client_approval = $this->lang->line('xin_client_approval_unclaimed');
			} else {
				$client_approval = $this->lang->line('xin_client_approval_claimed');
			}
			// variation end date
			$vsdate = $this->Xin_model->set_date_format($r->start_date);
			$vedate = $this->Xin_model->set_date_format($r->end_date);
			$variation_date = $this->lang->line('xin_start_date').': '.$vsdate.'<br>'.$this->lang->line('xin_end_date').': '.$vedate;			
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-variation-data" data-variation_id="'. $r->variation_id.'" data-mname="variation"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-variation" data-toggle="modal" data-target=".delete-modal-variation" data-record-id="'. $r->variation_id . '"><span class="fas fa-trash-restore"></span></button></span>',
				$task_catname.'<br>'.$status,
				$r->variation_no,
				$variation_date,
				$ol,
				$client_approval
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $task->num_rows(),
			 "recordsFiltered" => $task->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function comments_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/task_details", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$comments = $this->Timesheet_model->get_comments($id);
		
		$data = array();

        foreach($comments->result() as $r) {
			 			  		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->user_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get designation
			$_designation = $this->Designation_model->read_designation_information($employee[0]->designation_id);
			if(!is_null($_designation)){
				$designation_name = $_designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			
			// profile picture
			if($employee[0]->profile_picture!='' && $employee[0]->profile_picture!='no file') {
				$u_file = base_url().'uploads/profile/'.$employee[0]->profile_picture;
			} else {
				if($employee[0]->gender=='Male') { 
					$u_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$u_file = base_url().'uploads/profile/default_female.jpg';
				}
			} 
		} else {
			$employee_name = '--';
			$designation_name = '--';
			$u_file = '--';
		}
		// created at
		$created_at = date('h:i A', strtotime($r->created_at));
		$_date = explode(' ',$r->created_at);
		$date = $this->Xin_model->set_date_format($_date[0]);
		//
			$link = '<a class="c-user text-black" href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><span class="underline">'.$employee_name.' ('.$designation_name.')</span></a>';

			$dlink = '<div class="media-right">
							<div class="c-rating">
							<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'">
								<a class="btn icon-btn btn-sm btn-outline-danger delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
			  <span class="fas fa-trash-restore m-r-0-5"></span></a></span>
							</div>
						</div>';
		
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="user-image-hr-prj ui-w-30 rounded-circle" src="'.$u_file.'">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
							</div>
							<div class="c-text">'.$r->task_comments.'</div>
						</div>
						'.$dlink.'
					</div>
				</div>';
		
		$data[] = array(
			$function
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $comments->num_rows(),
			 "recordsFiltered" => $comments->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// Validate and add info in database
	public function set_comment() {
	
		if($this->input->post('add_type')=='set_comment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('xin_comment')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_comment_field');
		} 
		$xin_comment = $this->input->post('xin_comment');
		$qt_xin_comment = htmlspecialchars(addslashes($xin_comment), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'task_comments' => $qt_xin_comment,
		'task_id' => $this->input->post('comment_task_id'),
		'user_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Timesheet_model->add_comment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_comment_task');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function comment_delete() {
		if($this->input->post('data') == 'task_comment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_comment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_comment_task_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// Validate and add info in database
	public function add_attachment() {
	
		if($this->input->post('add_type')=='dfile_attachment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('file_name')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_task_file_name');
		} else if($_FILES['attachment_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_task_file');
		} else if($this->input->post('file_description')==='') {
			 $Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
		$description = $this->input->post('file_description');
		$file_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// is file upload
		if(is_uploaded_file($_FILES['attachment_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx','txt');
			$filename = $_FILES['attachment_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["attachment_file"]["tmp_name"];
				$attachment_file = "uploads/task/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["attachment_file"]["name"]);
				$newfilename = 'task_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $attachment_file.$newfilename);
				$fname = $newfilename;
			} else {
				$Return['error'] = $this->lang->line('xin_error_task_file_attachment');
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'task_id' => $this->input->post('c_task_id'),
		'upload_by' => $this->input->post('user_id'),
		'file_title' => $this->input->post('file_name'),
		'file_description' => $file_description,
		'attachment_file' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Timesheet_model->add_new_attachment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_att_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	  // attachment list
	  public function attachment_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/task_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Timesheet_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
		$data = array();

        foreach($attachments->result() as $r) {
			 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=task&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->task_attachment_id . '"><span class="fas fa-trash-restore"></span></button></span>',
			$r->file_title,
			$r->file_description,
			$r->created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $attachments->num_rows(),
			 "recordsFiltered" => $attachments->num_rows(),
			 "data" => $data
		);
		} else {
			$data[] = array('','','','');
      

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => 0,
			 "recordsFiltered" => 0,
			 "data" => $data
		);
		}
	  echo json_encode($output);
	  exit();
     }
	 
	 // delete task attachment
	 public function attachment_delete() {
		if($this->input->post('data') == 'task_attachment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_attachment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_task_att_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// daily attendance list > timesheet
    public function attendance_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/attendance_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$attendance_date = $this->input->get("attendance_date");
		$ref_location_id = $this->input->get("location_id");
		if($user_info[0]->user_role_id==1){
			if($ref_location_id == 0) {
				$employee = $this->Employees_model->get_attendance_employees();
			} else {
				$employee = $this->Employees_model->get_attendance_location_employees($ref_location_id);
			}
		} else {
			if(in_array('397',$role_resources_ids)) {
				$employee = $this->Xin_model->get_company_employees($user_info[0]->company_id);
			} else {
				$employee = $this->Xin_model->read_employee_info_att($session['user_id']);
			}
		}
		
		$system = $this->Xin_model->read_setting_info(1);
		$data = array();

        foreach($employee->result() as $r) {
			if($r->user_role_id!=1){ 			  		
			// user full name
			$full_name = $r->first_name.' '.$r->last_name;	
			// get office shift for employee
			$get_day = strtotime($attendance_date);
			$day = date('l', $get_day);
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			// attendance date
			$d_date = $this->Xin_model->set_date_format($attendance_date);
			// office shift
			$office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
			if(!is_null($office_shift)){
					// get clock in/clock out of each employee
					if($day == 'Monday') {
						if($office_shift[0]->monday_in_time==''){
							$in_time = '00:00:00';
							$out_time = '00:00:00';
						} else {
							$in_time = $office_shift[0]->monday_in_time;
							$out_time = $office_shift[0]->monday_out_time;
						}
					} else if($day == 'Tuesday') {
						if($office_shift[0]->tuesday_in_time==''){
							$in_time = '00:00:00';
							$out_time = '00:00:00';
						} else {
							$in_time = $office_shift[0]->tuesday_in_time;
							$out_time = $office_shift[0]->tuesday_out_time;
						}
					} else if($day == 'Wednesday') {
						if($office_shift[0]->wednesday_in_time==''){
							$in_time = '00:00:00';
							$out_time = '00:00:00';
						} else {
							$in_time = $office_shift[0]->wednesday_in_time;
							$out_time = $office_shift[0]->wednesday_out_time;
						}
					} else if($day == 'Thursday') {
						if($office_shift[0]->thursday_in_time==''){
							$in_time = '00:00:00';
							$out_time = '00:00:00';
						} else {
							$in_time = $office_shift[0]->thursday_in_time;
							$out_time = $office_shift[0]->thursday_out_time;
						}
					} else if($day == 'Friday') {
						if($office_shift[0]->friday_in_time==''){
							$in_time = '00:00:00';
							$out_time = '00:00:00';
						} else {
							$in_time = $office_shift[0]->friday_in_time;
							$out_time = $office_shift[0]->friday_out_time;
						}
					} else if($day == 'Saturday') {
						if($office_shift[0]->saturday_in_time==''){
							$in_time = '00:00:00';
							$out_time = '00:00:00';
						} else {
							$in_time = $office_shift[0]->saturday_in_time;
							$out_time = $office_shift[0]->saturday_out_time;
						}
					} else if($day == 'Sunday') {
						if($office_shift[0]->sunday_in_time==''){
							$in_time = '00:00:00';
							$out_time = '00:00:00';
						} else {
							$in_time = $office_shift[0]->sunday_in_time;
							$out_time = $office_shift[0]->sunday_out_time;
						}
					}
					// check if clock-in for date
					$attendance_status = '';
					$check = $this->Timesheet_model->attendance_first_in_check($r->user_id,$attendance_date);		
					if($check->num_rows() > 0){
						// check clock in time
						$attendance = $this->Timesheet_model->attendance_first_in($r->user_id,$attendance_date);
						// clock in
						$clock_in = new DateTime($attendance[0]->clock_in);
						$clock_in2 = $clock_in->format('h:i a');
						if($system[0]->is_ssl_available=='yes'){
						$clkInIp = $clock_in2.'<br><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_in_ip_address.'" data-uid="'.$r->user_id.'" data-att_type="clock_in" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkin_ip').'</button>';
						} else {
							$clkInIp = $clock_in2;
						}
						$office_time =  new DateTime($in_time.' '.$attendance_date);
						//time diff > total time late
						$office_time_new = strtotime($in_time.' '.$attendance_date);
						$clock_in_time_new = strtotime($attendance[0]->clock_in);
						if($clock_in_time_new <= $office_time_new) {
							$total_time_l = '00:00';
						} else {
							$interval_late = $clock_in->diff($office_time);
							$hours_l   = $interval_late->format('%h');
							$minutes_l = $interval_late->format('%i');			
							$total_time_l = $hours_l ."h ".$minutes_l."m";
						}
						
						// total hours work/ed
						$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($r->user_id,$attendance_date);
						$hrs_old_int1 = '';
						$Total = '';
						$Trest = '';
						$total_time_rs = '';
						$hrs_old_int_res1 = '';
						foreach ($total_hrs->result() as $hour_work){		
							// total work			
							$timee = $hour_work->total_work.':00';
							$str_time =$timee;
				
							$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
							
							sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
							
							$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
							
							$hrs_old_int1 = $hrs_old_seconds;
							
							$Total = gmdate("H:i", $hrs_old_int1);	
						}
						if($Total=='') {
							$total_work = '00:00';
						} else {
							$total_work = $Total;
						}
						
						// total rest > 
						$total_rest = $this->Timesheet_model->total_rest_attendance($r->user_id,$attendance_date);
						foreach ($total_rest->result() as $rest){			
							// total rest
							$str_time_rs = $rest->total_rest.':00';
							//$str_time_rs =$timee_rs;
				
							$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
							
							sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
							
							$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
							
							$hrs_old_int_res1 = $hrs_old_seconds_rs;
							
							$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
						}
						
						// check attendance status
						$status = $attendance[0]->attendance_status;
						if($total_time_rs=='') {
							$Trest = '00:00';
						} else {
							$Trest = $total_time_rs;
						}
					
					} else {
						$clock_in2 = '-';
						$total_time_l = '00:00';
						$total_work = '00:00';
						$Trest = '00:00';
						$clkInIp = $clock_in2;
						// get holiday/leave or absent
						/* attendance status */
						// get holiday
						$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
						$holiday_arr = array();
						if($h_date_chck->num_rows() == 1){
							$h_date = $this->Timesheet_model->holiday_date($attendance_date);
							$begin = new DateTime( $h_date[0]->start_date );
							$end = new DateTime( $h_date[0]->end_date);
							$end = $end->modify( '+1 day' ); 
							
							$interval = new DateInterval('P1D');
							$daterange = new DatePeriod($begin, $interval ,$end);
							
							foreach($daterange as $date){
								$holiday_arr[] =  $date->format("Y-m-d");
							}
						} else {
							$holiday_arr[] = '99-99-99';
						}
						
						
						// get leave/employee
						$leave_date_chck = $this->Timesheet_model->leave_date_check($r->user_id,$attendance_date);
						$leave_arr = array();
						if($leave_date_chck->num_rows() == 1){
							$leave_date = $this->Timesheet_model->leave_date($r->user_id,$attendance_date);
							$begin1 = new DateTime( $leave_date[0]->from_date );
							$end1 = new DateTime( $leave_date[0]->to_date);
							$end1 = $end1->modify( '+1 day' ); 
							
							$interval1 = new DateInterval('P1D');
							$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
							
							foreach($daterange1 as $date1){
								$leave_arr[] =  $date1->format("Y-m-d");
							}	
						} else {
							$leave_arr[] = '99-99-99';
						}
							
						if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
							$status = $this->lang->line('xin_holiday');	
						} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
							$status = $this->lang->line('xin_holiday');	
						} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
							$status = $this->lang->line('xin_holiday');	
						} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
							$status = $this->lang->line('xin_holiday');	
						} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
							$status = $this->lang->line('xin_holiday');	
						} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
							$status = $this->lang->line('xin_holiday');	
						} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
							$status = $this->lang->line('xin_holiday');	
						} else if(in_array($attendance_date,$holiday_arr)) { // holiday
							$status = $this->lang->line('xin_holiday');
						} else if(in_array($attendance_date,$leave_arr)) { // on leave
							$status = $this->lang->line('xin_on_leave');
						} 
						else {
							$status = $this->lang->line('xin_absent');
						}
					}
					
					// check if clock-out for date
					$check_out = $this->Timesheet_model->attendance_first_out_check($r->user_id,$attendance_date);		
					if($check_out->num_rows() == 1){
						/* early time */
						$early_time =  new DateTime($out_time.' '.$attendance_date);
						// check clock in time
						$first_out = $this->Timesheet_model->attendance_first_out($r->user_id,$attendance_date);
						// clock out
						$clock_out = new DateTime($first_out[0]->clock_out);
						
						if ($first_out[0]->clock_out!='') {
							$clock_out2 = $clock_out->format('h:i a');
							if($system[0]->is_ssl_available=='yes'){
								$clkOutIp = $clock_out2.'<br><button type="button" class="btn icon-btn btn-sm btn-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_out_ip_address.'" data-uid="'.$r->user_id.'" data-att_type="clock_out" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkout_ip').'</button>';
							} else {
								$clkOutIp = $clock_out2;
							}
						
							// early leaving
							$early_new_time = strtotime($out_time.' '.$attendance_date);
							$clock_out_time_new = strtotime($first_out[0]->clock_out);
						
							if($early_new_time <= $clock_out_time_new) {
								$total_time_e = '00:00';
							} else {			
								$interval_lateo = $clock_out->diff($early_time);
								$hours_e   = $interval_lateo->format('%h');
								$minutes_e = $interval_lateo->format('%i');			
								$total_time_e = $hours_e ."h ".$minutes_e."m";
							}
							
							/* over time */
							$over_time =  new DateTime($out_time.' '.$attendance_date);
							$overtime2 = $over_time->format('h:i a');
							// over time
							$over_time_new = strtotime($out_time.' '.$attendance_date);
							$clock_out_time_new1 = strtotime($first_out[0]->clock_out);
							
							if($clock_out_time_new1 <= $over_time_new) {
								$overtime2 = '00:00';
							} else {			
								$interval_lateov = $clock_out->diff($over_time);
								$hours_ov   = $interval_lateov->format('%h');
								$minutes_ov = $interval_lateov->format('%i');			
								$overtime2 = $hours_ov ."h ".$minutes_ov."m";
							}				
							
						} else {
							$clock_out2 =  '-';
							$total_time_e = '00:00';
							$overtime2 = '00:00';
							$clkOutIp = $clock_out2;
						}
								
					} else {
						$clock_out2 =  '-';
						$total_time_e = '00:00';
						$overtime2 = '00:00';
						$clkOutIp = $clock_out2;
					}	
					//
					if($user_info[0]->user_role_id==1){
						$fclckIn = $clkInIp;
						$fclckOut = $clkOutIp;
					} else {
						$fclckIn = $clock_in2;
						$fclckOut = $clock_out2;
					}
			} else {
				// attendance date
				$d_date = $this->Xin_model->set_date_format($attendance_date);
				$status = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('xin_office_shift_not_assigned').'</a>';
				$fclckIn = '--';
				$fclckOut = '--';
				$total_time_l = '--';
				$total_time_e = '--';
				$overtime2 = '--';
				$total_work = '--';
				$Trest = '--';
			}
			$data[] = array(
				$full_name,
				$r->employee_id,
				$comp_name,
				$d_date,
				$status,
				$fclckIn,
				$fclckOut,
				$total_time_l,
				$total_time_e,
				$overtime2,
				$total_work,
				$Trest
			);
			}
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
	 
	// get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	// get company > employees
	 public function get_leave_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_leave_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	// get company > employees leave
	 public function get_employees_leave() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$leave_type_id = $this->uri->segment(4);
		$employee_id = $this->uri->segment(5);
		
		$remaining_leave = $this->Timesheet_model->count_total_leaves($leave_type_id,$employee_id);
		$type = $this->Timesheet_model->read_leave_type_information($leave_type_id);
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
			$total = $type[0]->days_per_year;
			$leave_remaining_total = $total - $remaining_leave;
		} else {
			$type_name = '--';	
			$leave_remaining_total = 0;
		}
		ob_start();
		echo $leave_remaining_total." ".$type_name. ' ' .$this->lang->line('xin_remaining');
		ob_end_flush();
	} 
	// get employee assigned leave types
	 public function get_employee_assigned_leave_types() {

		$data['title'] = $this->Xin_model->site_title();
		$employee_id = $this->uri->segment(4);
		
		$data = array(
			'employee_id' => $employee_id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_employee_assigned_leave_types", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	// get company > projects
	 public function get_company_project() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/get_company_project", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	// get company > employees
	 public function get_company_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	// get company > employees
	 public function get_update_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_update_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	
	 }
	 // get company > employees
	 public function get_cal_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_update_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	
	 }
	 // get company > employees
	 public function get_timesheet_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_timesheet_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	
	 }
	// daily attendance list > timesheet
    public function dtwise_attendance_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/attendance_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$employee = $this->Xin_model->read_user_attendance_info();
		
		$data = array();

        foreach($employee->result() as $r) {
			$data[] = array('','','','','','','','','','','');
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
	 // date wise attendance list > timesheet
    public function date_wise_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/date_wise", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource(); 
		if(in_array('381',$role_resources_ids) && $user_info[0]->user_role_id!=1) {
			$employee_id = $this->input->get("user_id");
		} else if($user_info[0]->user_role_id!=1) {
			$employee_id = $session['user_id'];
		} else {
			$employee_id = $this->input->get("user_id");
		}
		$system = $this->Xin_model->read_setting_info(1);
		$employee = $this->Xin_model->read_user_info($employee_id);
		
		$start_date = new DateTime( $this->input->get("start_date"));
		$end_date = new DateTime( $this->input->get("end_date") );
		$end_date = $end_date->modify( '+1 day' ); 
		
		$interval_re = new DateInterval('P1D');
		$date_range = new DatePeriod($start_date, $interval_re ,$end_date);
		$attendance_arr = array();
		
		$data = array();
		foreach($date_range as $date) {
		$attendance_date =  $date->format("Y-m-d");
       // foreach($employee->result() as $r) {
			 			  		
		// user full name
	//	$full_name = $r->first_name.' '.$r->last_name;	
		// get office shift for employee
		$get_day = strtotime($attendance_date);
		$day = date('l', $get_day);
		// user full name
		$full_name = $employee[0]->first_name.' '.$employee[0]->last_name;
		// get company
		$company = $this->Xin_model->read_company_info($employee[0]->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}	
		// office shift
		$office_shift = $this->Timesheet_model->read_office_shift_information($employee[0]->office_shift_id);
		if(!is_null($office_shift)){
		// get clock in/clock out of each employee
		if($day == 'Monday') {
			if($office_shift[0]->monday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->monday_in_time;
				$out_time = $office_shift[0]->monday_out_time;
			}
		} else if($day == 'Tuesday') {
			if($office_shift[0]->tuesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->tuesday_in_time;
				$out_time = $office_shift[0]->tuesday_out_time;
			}
		} else if($day == 'Wednesday') {
			if($office_shift[0]->wednesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->wednesday_in_time;
				$out_time = $office_shift[0]->wednesday_out_time;
			}
		} else if($day == 'Thursday') {
			if($office_shift[0]->thursday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->thursday_in_time;
				$out_time = $office_shift[0]->thursday_out_time;
			}
		} else if($day == 'Friday') {
			if($office_shift[0]->friday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->friday_in_time;
				$out_time = $office_shift[0]->friday_out_time;
			}
		} else if($day == 'Saturday') {
			if($office_shift[0]->saturday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->saturday_in_time;
				$out_time = $office_shift[0]->saturday_out_time;
			}
		} else if($day == 'Sunday') {
			if($office_shift[0]->sunday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->sunday_in_time;
				$out_time = $office_shift[0]->sunday_out_time;
			}
		}
		// check if clock-in for date
		$attendance_status = '';
		$check = $this->Timesheet_model->attendance_first_in_check($employee[0]->user_id,$attendance_date);		
		if($check->num_rows() > 0){
			// check clock in time
			$attendance = $this->Timesheet_model->attendance_first_in($employee[0]->user_id,$attendance_date);
			// clock in
			$clock_in = new DateTime($attendance[0]->clock_in);
			$clock_in2 = $clock_in->format('h:i a');
			if($system[0]->is_ssl_available=='yes'){
				$clkInIp = $clock_in2.'<br><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_in_ip_address.'" data-uid="'.$employee[0]->user_id.'" data-att_type="clock_in" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkin_ip').'</button>';
			} else {
				$clkInIp = $clock_in2;
			}		
			$office_time =  new DateTime($in_time.' '.$attendance_date);
			//time diff > total time late
			$office_time_new = strtotime($in_time.' '.$attendance_date);
			$clock_in_time_new = strtotime($attendance[0]->clock_in);
			if($clock_in_time_new <= $office_time_new) {
				$total_time_l = '00:00';
			} else {
				$interval_late = $clock_in->diff($office_time);
				$hours_l   = $interval_late->format('%h');
				$minutes_l = $interval_late->format('%i');			
				$total_time_l = $hours_l ."h ".$minutes_l."m";
			}
			
			// total hours work/ed
			$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($employee[0]->user_id,$attendance_date);
			$hrs_old_int1 = 0;
			$Total = '';
			$Trest = '';
			$hrs_old_seconds = 0;
			$hrs_old_seconds_rs = 0;
			$total_time_rs = '';
			$hrs_old_int_res1 = 0;
			foreach ($total_hrs->result() as $hour_work){		
				// total work			
				$timee = $hour_work->total_work.':00';
				$str_time =$timee;
	
				$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
				
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$hrs_old_int1 += $hrs_old_seconds;
				
				$Total = gmdate("H:i", $hrs_old_int1);	
			}
			if($Total=='') {
				$total_work = '00:00';
			} else {
				$total_work = $Total;
			}
			
			// total rest > 
			$total_rest = $this->Timesheet_model->total_rest_attendance($employee[0]->user_id,$attendance_date);
			foreach ($total_rest->result() as $rest){			
				// total rest
				$str_time_rs = $rest->total_rest.':00';
				//$str_time_rs =$timee_rs;
	
				$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
				
				sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
				
				$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
				
				$hrs_old_int_res1 += $hrs_old_seconds_rs;
				
				$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
			}
			
			// check attendance status
			$status = $attendance[0]->attendance_status;
			if($total_time_rs=='') {
				$Trest = '00:00';
			} else {
				$Trest = $total_time_rs;
			}
		
		} else {
			$clock_in2 = '-';
			$total_time_l = '00:00';
			$total_work = '00:00';
			$Trest = '00:00';
			$clkInIp = $clock_in2;
			// get holiday/leave or absent
			/* attendance status */
			// get holiday
			$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
			$holiday_arr = array();
			if($h_date_chck->num_rows() == 1){
				$h_date = $this->Timesheet_model->holiday_date($attendance_date);
				$begin = new DateTime( $h_date[0]->start_date );
				$end = new DateTime( $h_date[0]->end_date);
				$end = $end->modify( '+1 day' ); 
				
				$interval = new DateInterval('P1D');
				$daterange = new DatePeriod($begin, $interval ,$end);
				
				foreach($daterange as $date){
					$holiday_arr[] =  $date->format("Y-m-d");
				}
			} else {
				$holiday_arr[] = '99-99-99';
			}
			
			
			// get leave/employee
			$leave_date_chck = $this->Timesheet_model->leave_date_check($employee[0]->user_id,$attendance_date);
			$leave_arr = array();
			if($leave_date_chck->num_rows() == 1){
				$leave_date = $this->Timesheet_model->leave_date($employee[0]->user_id,$attendance_date);
				$begin1 = new DateTime( $leave_date[0]->from_date );
				$end1 = new DateTime( $leave_date[0]->to_date);
				$end1 = $end1->modify( '+1 day' ); 
				
				$interval1 = new DateInterval('P1D');
				$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
				
				foreach($daterange1 as $date1){
					$leave_arr[] =  $date1->format("Y-m-d");
				}	
			} else {
				$leave_arr[] = '99-99-99';
			}
				
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = $this->lang->line('xin_holiday');	
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = $this->lang->line('xin_holiday');
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = $this->lang->line('xin_on_leave');
			} 
			else {
				$status = $this->lang->line('xin_absent');
			}
		}
		
		
		
		// check if clock-out for date
		$check_out = $this->Timesheet_model->attendance_first_out_check($employee[0]->user_id,$attendance_date);		
		if($check_out->num_rows() == 1){
			/* early time */
			$early_time =  new DateTime($out_time.' '.$attendance_date);
			// check clock in time
			$first_out = $this->Timesheet_model->attendance_first_out($employee[0]->user_id,$attendance_date);
			// clock out
			$clock_out = new DateTime($first_out[0]->clock_out);
			
			if ($first_out[0]->clock_out!='') {
				$clock_out2 = $clock_out->format('h:i a');
				if($system[0]->is_ssl_available=='yes'){
					$clkOutIp = $clock_out2.'<br><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_out_ip_address.'" data-uid="'.$employee[0]->user_id.'" data-att_type="clock_out" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkout_ip').'</button>';
				} else {
					$clkOutIp = $clock_out2;
				}			
				// early leaving
				$early_new_time = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new = strtotime($first_out[0]->clock_out);
			
				if($early_new_time <= $clock_out_time_new) {
					$total_time_e = '00:00';
				} else {			
					$interval_lateo = $clock_out->diff($early_time);
					$hours_e   = $interval_lateo->format('%h');
					$minutes_e = $interval_lateo->format('%i');			
					$total_time_e = $hours_e ."h ".$minutes_e."m";
				}
				
				/* over time */
				$over_time =  new DateTime($out_time.' '.$attendance_date);
				$overtime2 = $over_time->format('h:i a');
				// over time
				$over_time_new = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new1 = strtotime($first_out[0]->clock_out);
				
				if($clock_out_time_new1 <= $over_time_new) {
					$overtime2 = '00:00';
				} else {			
					$interval_lateov = $clock_out->diff($over_time);
					$hours_ov   = $interval_lateov->format('%h');
					$minutes_ov = $interval_lateov->format('%i');			
					$overtime2 = $hours_ov ."h ".$minutes_ov."m";
				}				
				
			} else {
				$clock_out2 =  '-';
				$total_time_e = '00:00';
				$overtime2 = '00:00';
				$clkOutIp = $clock_out2;
			}
					
		} else {
			$clock_out2 =  '-';
			$total_time_e = '00:00';
			$overtime2 = '00:00';
			$clkOutIp = $clock_out2;
		}		
			
			// attendance date
			$tdate = $this->Xin_model->set_date_format($attendance_date);
			/*if($user_info[0]->user_role_id==1){
				$fclckIn = $clkInIp;
				$fclckOut = $clkOutIp;
			} else {
				$fclckIn = $clock_in2;
				$fclckOut = $clock_out2;
			}*/
			} else {
				// attendance date
				$tdate = $this->Xin_model->set_date_format($attendance_date);
				$status = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('xin_office_shift_not_assigned').'</a>';
				
				$clkInIp = '--';
				$clkOutIp = '--';
				$total_time_l = '--';
				$total_time_e = '--';
				$overtime2 = '--';
				$total_work = '--';
				$Trest = '--';
			}
			$data[] = array(
				$full_name,
				$employee[0]->employee_id,
				$comp_name,
				$status,
				$tdate,
				$clkInIp,
				$clkOutIp,
				$total_time_l,
				$total_time_e,
				$overtime2,
				$total_work,
				$Trest
			);
		
		/*$data[] = array(
			$status,
			$tdate,
			$clock_in2,
			$clock_out2,
			$total_time_l,
			$total_time_e,
			$overtime2,
			$total_work,
			$Trest
		);*/
      }

	  $output = array(
		   "draw" => $draw,
			 //"recordsTotal" => count($date_range),
			 //"recordsFiltered" => count($date_range),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // update_attendance_list > timesheet
	 public function update_attendance_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		// get date
		$attendance_date = $this->input->get("attendance_date");
		// get employee id
		$employee_id = $this->input->get("employee_id");
		/*// get user info >
		$user = $this->xin_model->read_user_info($employee_id);
		// user full name
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		// get designation
		$designation = $this->designation_model->read_designation_information($user[0]->designation_id);
		// department
		$department = $this->department_model->read_department_information($user[0]->department_id);
		
		$dept_des = $designation[0]->designation_name.' in '.$department[0]->department_name;
		$employee_name = $full_name.' ('.$dept_des.')';
		$data = array(
				'employee_name' => $employee_name,
				//'employee_id' => $result[0]->employee_id,
				);*/
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/update_attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		
		$attendance_employee = $this->Timesheet_model->attendance_employee_with_date($employee_id,$attendance_date);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($attendance_employee->result() as $r) {
			  
			// total work
			$in_time = new DateTime($r->clock_in);
			$out_time = new DateTime($r->clock_out);
			
			$clock_in = $in_time->format('h:i a');			
			// attendance date
			$att_date_in = explode(' ',$r->clock_in);
			$att_date_out = explode(' ',$r->clock_out);
			$cidate = $this->Xin_model->set_date_format($att_date_in[0]);
			$cin_date = $cidate.' '.$clock_in;
			if($r->clock_out=='') {
				$cout_date = '-';
				$total_time = '-';
			} else {
				$clock_out = $out_time->format('h:i a');
				$interval = $in_time->diff($out_time);
				$hours  = $interval->format('%h');
				$minutes = $interval->format('%i');			
				$total_time = $hours ."h ".$minutes."m";
				$codate = $this->Xin_model->set_date_format($att_date_out[0]);
				$cout_date = $codate.' '.$clock_out;
			}
			if(in_array('278',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-attendance_id="'.$r->time_attendance_id.'"><i class="fas fa-pencil-alt"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('279',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->time_attendance_id.'"><i class="fas fa-trash-restore"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $edit.$delete;

		   $data[] = array(
				$combhr,
				$cin_date,
				$cout_date,
				$total_time
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $attendance_employee->num_rows(),
			 "recordsFiltered" => $attendance_employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // update_attendance_list > timesheet
	 public function office_shift_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/office_shift", $data);
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
			$office_shift = $this->Timesheet_model->get_office_shifts();
		} else {
			if(in_array('311',$role_resources_ids)) {
				$office_shift = $this->Timesheet_model->get_company_shifts($user_info[0]->company_id);
			} else {
				$office_shift = $this->Xin_model->get_employee_shift_office($user_info[0]->office_shift_id);
			}
		}
		$data = array();

          foreach($office_shift->result() as $r) {
			  
			/* get Office Shift info*/
			$monday_in_time = new DateTime($r->monday_in_time);
			$monday_out_time = new DateTime($r->monday_out_time);
			$tuesday_in_time = new DateTime($r->tuesday_in_time);
			$tuesday_out_time = new DateTime($r->tuesday_out_time);
			$wednesday_in_time = new DateTime($r->wednesday_in_time);
			$wednesday_out_time = new DateTime($r->wednesday_out_time);
			$thursday_in_time = new DateTime($r->thursday_in_time);
			$thursday_out_time = new DateTime($r->thursday_out_time);
			$friday_in_time = new DateTime($r->friday_in_time);
			$friday_out_time = new DateTime($r->friday_out_time);
			$saturday_in_time = new DateTime($r->saturday_in_time);
			$saturday_out_time = new DateTime($r->saturday_out_time);
			$sunday_in_time = new DateTime($r->sunday_in_time);
			$sunday_out_time = new DateTime($r->sunday_out_time);
			
			if($r->monday_in_time == '') {
				$monday = '-';
			} else {
				$monday = $monday_in_time->format('h:i a') .' ' .$this->lang->line('dashboard_to').' ' .$monday_out_time->format('h:i a');
			}
			if($r->tuesday_in_time == '') {
				$tuesday = '-';
			} else {
				$tuesday = $tuesday_in_time->format('h:i a') .' ' . $this->lang->line('dashboard_to').' '.$tuesday_out_time->format('h:i a');
			}
			if($r->wednesday_in_time == '') {
				$wednesday = '-';
			} else {
				$wednesday = $wednesday_in_time->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$wednesday_out_time->format('h:i a');
			}
			if($r->thursday_in_time == '') {
				$thursday = '-';
			} else {
				$thursday = $thursday_in_time->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$thursday_out_time->format('h:i a');
			}
			if($r->friday_in_time == '') {
				$friday = '-';
			} else {
				$friday = $friday_in_time->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$friday_out_time->format('h:i a');
			}
			if($r->saturday_in_time == '') {
				$saturday = '-';
			} else {
				$saturday = $saturday_in_time->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$saturday_out_time->format('h:i a');
			}
			if($r->sunday_in_time == '') {
				$sunday = '-';
			} else {
				$sunday = $sunday_in_time->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$sunday_out_time->format('h:i a');
			}
			
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			if(in_array('281',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-office_shift_id="'. $r->office_shift_id.'" ><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('282',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->office_shift_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
		$functions = '';
		if($r->default_shift=='' || $r->default_shift==0) {
			if(in_array('2822',$role_resources_ids)) { // default
		 		$functions = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_make_default').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light default-shift" data-office_shift_id="'. $r->office_shift_id.'"><span class="ion ion-md-timer"></span></button></span>';
			} else {
				$functions = '';
			}
		 } else {
		 	$functions = '';
		 }
		 $combhr = $edit.$functions.$delete;
		
		 if($r->default_shift==1){
			$success = '<span class="badge badge-success">'.$this->lang->line('xin_default').'</span>';
		 } else {
			 $success = '';
		 }

		   $data[] = array(
				$combhr,
				$comp_name,
				$r->shift_name . ' ' .$success,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$saturday,
				$sunday
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $office_shift->num_rows(),
			 "recordsFiltered" => $office_shift->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // holidays_list > timesheet
	 public function holidays_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/holidays", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
				
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($this->input->get("ihr")=='true'){
			if($this->input->get("company_id")==0 && $this->input->get("status")=='all'){
				$holidays = $this->Timesheet_model->get_holidays();
			} else if($this->input->get("company_id")!=0 && $this->input->get("status")=='all'){
				$holidays = $this->Timesheet_model->filter_company_holidays($this->input->get("company_id"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("status")!='all'){
				$holidays = $this->Timesheet_model->filter_company_publish_holidays($this->input->get("company_id"),$this->input->get("status"));
			} else if($this->input->get("company_id")==0 && $this->input->get("status")!='all'){
				$holidays = $this->Timesheet_model->filter_notcompany_publish_holidays($this->input->get("status"));
			}
		} else{
			if($user_info[0]->user_role_id==1){
				$holidays = $this->Timesheet_model->get_holidays();
			} else {
				$holidays = $this->Timesheet_model->get_company_holidays($user_info[0]->company_id);
			}
		}
		$data = array();

        foreach($holidays->result() as $r) {
			  
			/* get publish/unpublish label*/
			 if($r->is_publish==1): $publish = '<span class="badge bg-green">'.$this->lang->line('xin_published').'</span>'; else: $publish = '<span class="badge bg-orange">'.$this->lang->line('xin_unpublished').'</span>'; endif;
			 // get start date and end date
			 $sdate = $this->Xin_model->set_date_format($r->start_date);
			 $edate = $this->Xin_model->set_date_format($r->end_date);
			 // get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			if(in_array('284',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-holiday_id="'. $r->holiday_id.'"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('285',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->holiday_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('286',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-holiday_id="'. $r->holiday_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$ievent_name = $r->event_name.'<br><small class="text-muted"><i>'.$comp_name.'<i></i></i></small><br><small class="text-muted"><i>'.$publish.'<i></i></i></small>';
		   $data[] = array(
				$combhr,
				$ievent_name,
				$sdate,
				$edate
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $holidays->num_rows(),
			 "recordsFiltered" => $holidays->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // leave list > timesheet
	 public function leave_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/leave", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$data = array();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($this->input->get("ihr")=='true'){
			if($this->input->get("company_id")==0 && $this->input->get("employee_id")==0 && $this->input->get("status")==0){
				$leave = $this->Timesheet_model->get_leaves();
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")==0 && $this->input->get("status")==0){
				$leave = $this->Timesheet_model->filter_company_leaves($this->input->get("company_id"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")!=0 && $this->input->get("status")==0){
				$leave = $this->Timesheet_model->filter_company_employees_leaves($this->input->get("company_id"),$this->input->get("employee_id"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")!=0 && $this->input->get("status")!=0){
				$leave = $this->Timesheet_model->filter_company_employees_status_leaves($this->input->get("company_id"),$this->input->get("status"));
			} else if($this->input->get("company_id")!=0 && $this->input->get("employee_id")==0 && $this->input->get("status")!=0){
				$leave = $this->Timesheet_model->filter_company_only_status_leaves($this->input->get("company_id"),$this->input->get("status"));
			}
		} else {
			$view_companies_ids = explode(',',$user_info[0]->view_companies_id);
			if($user_info[0]->user_role_id==1){
				$leave = $this->Timesheet_model->get_leaves();
			} else {
				if(in_array('290',$role_resources_ids)) {
					$leave = $this->Timesheet_model->get_company_leaves($user_info[0]->company_id);
				} else {
					$leave = $this->Timesheet_model->get_employee_leaves($session['user_id']);
				}
			}
		}
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		foreach($leave->result() as $r) {
			  
			// get start date and end date
			$user = $this->Xin_model->read_user_info($r->employee_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
				// department
				$department = $this->Department_model->read_department_information($user[0]->department_id);
				if(!is_null($department)){
					$department_name = $department[0]->department_name;
				} else {
					$department_name = '--';	
				}
			} else {
				$full_name = '--';	
				$department_name = '--';
			}
			 
			// get leave type
			$leave_type = $this->Timesheet_model->read_leave_type_information($r->leave_type_id);
			if(!is_null($leave_type)){
				$type_name = $leave_type[0]->type_name;
			} else {
				$type_name = '--';	
			}
			
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			 
			$datetime1 = new DateTime($r->from_date);
			$datetime2 = new DateTime($r->to_date);
			$interval = $datetime1->diff($datetime2);
			if(strtotime($r->from_date) == strtotime($r->to_date)){
				$no_of_days =1;
			} else {
				$no_of_days = $interval->format('%a') + 1;
			}
			$applied_on = $this->Xin_model->set_date_format($r->applied_on);
			 /*$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$no_of_days;*/
			
			 if($r->is_half_day == 1){
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$this->lang->line('xin_hr_leave_half_day');
			} else {
				$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$no_of_days;
			}
			
			if($r->status==1): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
			elseif($r->status==2): $status = '<span class="badge bg-green">'.$this->lang->line('xin_approved').'</span>';
			elseif($r->status==4): $status = '<span class="badge bg-green">'.$this->lang->line('xin_role_first_level_approved').'</span>';
			else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
			
			
			if(in_array('288',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-leave_id="'. $r->leave_id.'" ><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('289',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->leave_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('290',$role_resources_ids) || $user_info[0]->user_role_id==1 || $reports_to > 0) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/leave_details/id/'.$r->leave_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$itype_name = $type_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_reason').': '.$r->reason.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('left_company').': '.$comp_name.'<i></i></i></small>';
	
		   $data[] = array(
				$combhr,
				$itype_name,
				$department_name,
				$full_name,
				$duration,
				$applied_on
		   );
	  }
	  $output = array(
		   "draw" => $draw,
			// "recordsTotal" => $leave->num_rows(),
			// "recordsFiltered" => $leave->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 // my team leave list > timesheet
	 public function my_team_leave_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/leave", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$data = array();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$leave = $this->Timesheet_model->get_leaves();
		// reports to 
 		$reports_to = get_reports_team_data($session['user_id']);
		foreach($leave->result() as $r) {
			
			$user = $this->Xin_model->read_user_info($r->employee_id);
			if($user[0]->reports_to == $session['user_id']) {  
				// get start date and end date
				$user = $this->Xin_model->read_user_info($r->employee_id);
				if(!is_null($user)){
					$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
					// department
					$department = $this->Department_model->read_department_information($user[0]->department_id);
					if(!is_null($department)){
						$department_name = $department[0]->department_name;
					} else {
						$department_name = '--';	
					}
				} else {
					$full_name = '--';	
					$department_name = '--';
				}
				 
				// get leave type
				$leave_type = $this->Timesheet_model->read_leave_type_information($r->leave_type_id);
				if(!is_null($leave_type)){
					$type_name = $leave_type[0]->type_name;
				} else {
					$type_name = '--';	
				}
				
				// get company
				$company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($company)){
					$comp_name = $company[0]->name;
				} else {
					$comp_name = '--';	
				}
				 
				$datetime1 = new DateTime($r->from_date);
				$datetime2 = new DateTime($r->to_date);
				$interval = $datetime1->diff($datetime2);
				if(strtotime($r->from_date) == strtotime($r->to_date)){
					$no_of_days =1;
				} else {
					$no_of_days = $interval->format('%a') + 1;
				}
				$applied_on = $this->Xin_model->set_date_format($r->applied_on);
				 /*$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$no_of_days;*/
				
				 if($r->is_half_day == 1){
				$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$this->lang->line('xin_hr_leave_half_day');
				} else {
					$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$no_of_days;
				}
				
				if($r->status==1): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
				elseif($r->status==2): $status = '<span class="badge bg-green">'.$this->lang->line('xin_approved').'</span>';
				elseif($r->status==4): $status = '<span class="badge bg-green">'.$this->lang->line('xin_role_first_level_approved').'</span>';
				else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
				
				
				if(in_array('288',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-leave_id="'. $r->leave_id.'" ><span class="fas fa-pencil-alt"></span></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('289',$role_resources_ids)) { // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->leave_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$delete = '';
				}
				if(in_array('290',$role_resources_ids) || $reports_to > 0) { //view
					$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/leave_details/id/'.$r->leave_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
				} else {
					$view = '';
				}
				$combhr = $edit.$view.$delete;
				$itype_name = $type_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_reason').': '.$r->reason.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('left_company').': '.$comp_name.'<i></i></i></small>';
		
			   $data[] = array(
					$combhr,
					$itype_name,
					$department_name,
					$full_name,
					$duration,
					$applied_on
			   );
		  }
		}
	  $output = array(
		   "draw" => $draw,
			// "recordsTotal" => $leave->num_rows(),
			// "recordsFiltered" => $leave->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// add attendance > modal form 
	public function update_attendance_add()
	{
		$data['title'] = $this->Xin_model->site_title();
		$employee_id = $this->input->get('employee_id');
		$data = array(
				'employee_id' => $employee_id,
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_attendance', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_task() {
	
		if($this->input->post('add_type')=='task') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('task_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_name');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('task_hour')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_hour');
		} else if($this->input->post('project_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_project_field');
		} else if($this->input->post('assigned_to')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_assigned_user');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$assigned_ids = implode(',',$this->input->post('assigned_to'));
		// get company name by project id
		$co_info  = $this->Project_model->read_project_information($this->input->post('project_id'));
			
		$data = array(
		'project_id' => $this->input->post('project_id'),
		'company_id' => $this->input->post('company_id'),
		'created_by' => $this->input->post('user_id'),
		'task_name' => $this->input->post('task_name'),
		'assigned_to' => $assigned_ids,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'task_hour' => $this->input->post('task_hour'),
		'task_progress' => '0',
		'is_notify' => '1',
		'description' => $qt_description,
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Timesheet_model->add_task_record($data);
		
		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('task_id',"DESC")->get("xin_tasks")->row();
			$Return['result'] = $this->lang->line('xin_success_task_added');	
			$Return['re_last_id'] = $row->task_id;
			// notificaions
			foreach($this->input->post('assigned_to') as $p_employee){
				$nticket_data = array(
				'module_name' => 'tasks',
				'module_id' => $row->task_id,
				'employee_id' => $p_employee,
				'is_notify' => '1',
				'created_at' => date('d-m-Y h:i:s'),
				);
				$this->Xin_model->add_notifications($nticket_data);
			}
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {
			
				$this->email->set_mailtype("html");
				$to_email = array();
				foreach($this->input->post('assigned_to') as $p_employee) {
					
					// assigned by
					$user_info = $this->Xin_model->read_user_info($this->input->post('user_id'));	
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;		
					
					// assigned to
					$user_to = $this->Xin_model->read_user_info($p_employee);	
					//get company info
					$cinfo = $this->Xin_model->read_company_setting_info(1);
					//get email template
					$template = $this->Xin_model->read_email_template(14);
					
					$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					
					$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var task_name}","{var task_assigned_by}"),array($cinfo[0]->company_name,site_url(),$this->input->post('task_name'),$full_name),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
			
					hrsale_mail($cinfo[0]->email,$cinfo[0]->company_name,$user_info[0]->email,$subject,$message);
				}
			}		
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_project_variation() {
	
		if($this->input->post('add_type')=='variation') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('variation_name')==='') {
        	$Return['error'] = $this->lang->line('xin_project_variation_title_field_error');
		} else if($this->input->post('variation_no')==='') {
        	$Return['error'] = $this->lang->line('xin_project_variation_field_error');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('variation_hour')==='') {
			$Return['error'] = $this->lang->line('xin_project_variation_hrs_field_error');
		} else if($this->input->post('project_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_project_field');
		} else if($this->input->post('assigned_to')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_assigned_user');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$assigned_ids = implode(',',$this->input->post('assigned_to'));
		// get company name by project id
		$co_info  = $this->Project_model->read_project_information($this->input->post('project_id'));
			
		$data = array(
		'project_id' => $this->input->post('project_id'),
		'company_id' => $this->input->post('company_id'),
		'created_by' => $this->input->post('user_id'),
		'variation_name' => $this->input->post('variation_name'),
		'variation_no' => $this->input->post('variation_no'),
		'assigned_to' => $assigned_ids,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'variation_hours' => $this->input->post('variation_hour'),
		'variation_status' => $this->input->post('status'),
		'client_approval' => $this->input->post('client_approval'),
		'description' => $qt_description,
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Timesheet_model->add_project_variations($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_added');	
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_leave() {
	
		if($this->input->post('add_type')=='leave') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$remarks = $this->input->post('remarks');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('leave_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_leave_type_field');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('reason')==='') {
			$Return['error'] = $this->lang->line('xin_error_leave_type_reason');
		}
		$datetime1 = new DateTime($this->input->post('start_date'));
		$datetime2 = new DateTime($this->input->post('end_date'));
		$interval = $datetime1->diff($datetime2);
		$no_of_days = $interval->format('%a') + 1;
		if($this->input->post('leave_half_day')==1 && $no_of_days>1) {
			$Return['error'] = $this->lang->line('xin_hr_cant_appply_morethan').' 1 '.$this->lang->line('xin_day');
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
			
		if($this->input->post('start_date')!=''){	
			
			//$user_info_all = $this->Employees_model->read_employee_information($this->input->post('employee_id'));
			$eremaining_leave = 0;//$user_info_all[0]->leave_days;
			
			$count_l = 0;
			$leave_halfday_cal = employee_leave_halfday_cal($this->input->post('leave_type'),$this->input->post('employee_id'));
			foreach($leave_halfday_cal as $lhalfday):
				$count_l += 0.5;
			endforeach;
			
			$remaining_leave = count_leaves_info($this->input->post('leave_type'),$this->input->post('employee_id'));
			$remaining_leave = $remaining_leave - $count_l;
			
			$type = $this->Timesheet_model->read_leave_type_information($this->input->post('leave_type'));
			if(!is_null($type)){
				$type_name = $type[0]->type_name;
				$total = $type[0]->days_per_year;
				$leave_remaining_total = $total - $remaining_leave;
			} else {
				$type_name = '--';	
				$leave_remaining_total = 0;
			}
					
			if($this->input->post('leave_type')==3 || $this->input->post('leave_type')==5 || $this->input->post('leave_type')==7) {
				$leave_remaining_total = $leave_remaining_total + $eremaining_leave;
			} else {
				$leave_remaining_total = $leave_remaining_total;
			}
			
			if($this->input->post('leave_half_day')!=1){
				if($no_of_days > $leave_remaining_total){
					$Return['error'] = $this->lang->line('xin_hr_cant_appply_morethan').' '.$this->lang->line('xin_day');
				}
			} else {
				if(0.5 > $leave_remaining_total){
					$Return['error'] = $this->lang->line('xin_hr_cant_appply_morethan').' '.$leave_remaining_total.' '.$this->lang->line('xin_hr_contract_days');
				}
			}
			
			if($leave_remaining_total < 0.4){
				$Return['error'] = $this->lang->line('xin_leave_limit_msg').' '.$this->lang->line('xin_hrsale_leave_quota_completed') .$type_name;
			}
				
			/*$remaining_leave = count_leaves_info($this->input->post('leave_type'),$this->input->post('employee_id'));
			$type = $this->Timesheet_model->read_leave_type_information($this->input->post('leave_type'));
			if(!is_null($type)){
				$type_name = $type[0]->type_name;
				$total = $type[0]->days_per_year;
				$leave_remaining_total = $total - $remaining_leave;
			} else {
				$type_name = '--';	
				$leave_remaining_total = 0;
			}
			
			if($leave_remaining_total == 0){
				$Return['error'] = $this->lang->line('xin_leave_limit_msg').' '.$this->lang->line('xin_hrsale_leave_quota_completed') .$type_name;
			}*/
		}
		if($Return['error']!=''){
       		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
    	}	
		if($this->input->post('leave_half_day')!=1){
			$leave_half_day_opt = 0;
		} else {
			$leave_half_day_opt = $this->input->post('leave_half_day');
		}
		if(is_uploaded_file($_FILES['attachment']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif');
			$filename = $_FILES['attachment']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["attachment"]["tmp_name"];
				$profile = "uploads/leave/";
				$set_img = base_url()."uploads/leave/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["attachment"]["name"]);
				$newfilename = 'leave_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;			
			} else {
				$Return['error'] = $this->lang->line('xin_error_attatchment_type');
			}
		} else {
			$fname = '';
		}
		
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'leave_type_id' => $this->input->post('leave_type'),
		'from_date' => $this->input->post('start_date'),
		'to_date' => $this->input->post('end_date'),
		'applied_on' => date('Y-m-d h:i:s'),
		'reason' => $this->input->post('reason'),
		'remarks' => $qt_remarks,
		'leave_attachment' => $fname,
		'status' => '1',
		'is_notify' => '1',
		'is_half_day' => $leave_half_day_opt,
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Timesheet_model->add_leave_record($data);
		
		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('leave_id',"DESC")->get("xin_leave_applications")->row();
			$Return['result'] = $this->lang->line('xin_success_leave_added');
			// get leave type
			$leave_type = $this->Timesheet_model->read_leave_type_information($row->leave_type_id);
			if(!is_null($leave_type)){
				$type_name = $leave_type[0]->type_name;
			} else {
				$type_name = '--';	
			}
			$Return['re_last_id'] = $row->leave_id;
			$Return['lv_type_name'] = $type_name;
			// notificaions
			$nticket_data = array(
				'module_name' => 'leave',
				'module_id' => $row->leave_id,
				'employee_id' => $this->input->post('employee_id'),
				'is_notify' => '1',
				'created_at' => date('d-m-Y h:i:s'),
			);
			$this->Xin_model->add_notifications($nticket_data);
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {
				
				$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(5);
				//get employee info
				$user_info = $this->Xin_model->read_user_info($this->input->post('employee_id'));
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				//get reports to
				$reports_to = $this->Xin_model->read_user_info($user_info[0]->reports_to);
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var employee_name}"),array($cinfo[0]->company_name,site_url(),$full_name),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				if(!is_null($reports_to)){
					hrsale_mail($user_info[0]->email,$full_name,$reports_to[0]->email,$subject,$message);
				} else {
					hrsale_mail($user_info[0]->email,$full_name,$cinfo[0]->email,$subject,$message);
				}
				
			}
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_attendance() {
	
		if($this->input->post('add_type')=='attendance') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('attendance_date_m')==='') {
        	$Return['error'] = $this->lang->line('xin_error_attendance_date');
		} else if($this->input->post('clock_in_m')==='') {
        	$Return['error'] = $this->lang->line('xin_error_attendance_in_time');
		} else if($this->input->post('clock_out_m')==='') {
        	$Return['error'] = $this->lang->line('xin_error_attendance_out_time');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$attendance_date = $this->input->post('attendance_date_m');
		$clock_in = $this->input->post('clock_in_m');
		$clock_out = $this->input->post('clock_out_m');
		
		$clock_in2 = $attendance_date.' '.$clock_in.':00';
		$clock_out2 = $attendance_date.' '.$clock_out.':00';
		
		//total work
		$total_work_cin =  new DateTime($clock_in2);
		$total_work_cout =  new DateTime($clock_out2);
		
		$interval_cin = $total_work_cout->diff($total_work_cin);
		$hours_in   = $interval_cin->format('%h');
		$minutes_in = $interval_cin->format('%i');
		$total_work = $hours_in .":".$minutes_in;
	
		$data = array(
		'employee_id' => $this->input->post('employee_id_m'),
		'attendance_date' => $attendance_date,
		'clock_in' => $clock_in2,
		'clock_out' => $clock_out2,
		'time_late' => $clock_in2,
		'total_work' => $total_work,
		'early_leaving' => $clock_out2,
		'overtime' => $clock_out2,
		'attendance_status' => 'Present',
		'clock_in_out' => '0'
		);
		$result = $this->Timesheet_model->add_employee_attendance($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_attendance_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_holiday() {
	
		if($this->input->post('add_type')=='holiday') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('event_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_event_name');
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
		'event_name' => $this->input->post('event_name'),
		'company_id' => $this->input->post('company_id'),
		'description' => $qt_description,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'is_publish' => $this->input->post('is_publish'),
		'created_at' => date('Y-m-d')
		);
		$result = $this->Timesheet_model->add_holiday_record($data);
		
		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('holiday_id',"DESC")->get("xin_holidays")->row();
			$Return['result'] = $this->lang->line('xin_holiday_added');
			$Return['re_last_id'] = $row->holiday_id;	
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function edit_holiday() {
	
		if($this->input->post('edit_type')=='holiday') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('event_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_event_name');
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
		'event_name' => $this->input->post('event_name'),
		'company_id' => $this->input->post('company_id'),
		'description' => $qt_description,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'is_publish' => $this->input->post('is_publish')
		);
		
		$result = $this->Timesheet_model->update_holiday_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_holiday_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function edit_leave() {
	
		if($this->input->post('edit_type')=='leave') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$remarks = $this->input->post('remarks');
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('reason')==='') {
			$Return['error'] = $this->lang->line('xin_error_leave_type_reason');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
			
		$data = array(
		'reason' => $this->input->post('reason'),
		'remarks' => $qt_remarks
		);
		
		$result = $this->Timesheet_model->update_leave_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_leave_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_leave_status() {
	
		if($this->input->post('update_type')=='leave') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$remarks = $this->input->post('remarks');
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
			
		$data = array(
		'status' => $this->input->post('status'),
		'remarks' => $qt_remarks
		);
		
		$result = $this->Timesheet_model->update_leave_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_leave__status_updated');
			$setting = $this->Xin_model->read_setting_info(1);
		if($setting[0]->enable_email_notification == 'yes') {
					
			if($this->input->post('status') == 2){
				
				$this->email->set_mailtype("html");
				
				//get leave info
				$timesheet = $this->Timesheet_model->read_leave_information($id);
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(6);
				//get employee info
				$user_info = $this->Xin_model->read_user_info($timesheet[0]->employee_id);
				
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$from_date = $this->Xin_model->set_date_format($timesheet[0]->from_date);
				$to_date = $this->Xin_model->set_date_format($timesheet[0]->to_date);
			
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var leave_start_date}","{var leave_end_date}"),array($cinfo[0]->company_name,site_url(),$from_date,$to_date),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				hrsale_mail($cinfo[0]->email,$cinfo[0]->company_name,$user_info[0]->email,$subject,$message);
			} else if($this->input->post('status') == 3){ // rejected
				
				$this->email->set_mailtype("html");
				
				//get leave info
				$timesheet = $this->Timesheet_model->read_leave_information($id);
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(7);
				//get employee info
				$user_info = $this->Xin_model->read_user_info($timesheet[0]->employee_id);
				
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$from_date = $this->Xin_model->set_date_format($timesheet[0]->from_date);
				$to_date = $this->Xin_model->set_date_format($timesheet[0]->to_date);
			
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var leave_start_date}","{var leave_end_date}"),array($cinfo[0]->company_name,site_url(),$from_date,$to_date),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				hrsale_mail($cinfo[0]->email,$cinfo[0]->company_name,$user_info[0]->email,$subject,$message);
			} }
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function edit_task() {
	
		if($this->input->post('edit_type')=='task') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('project_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_project_field');
		} else if($this->input->post('task_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_name');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('task_hour')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_hour');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if(null!=$this->input->post('assigned_to')) {
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
		} else {
			$assigned_ids = 'None';
		}
			
		$data = array(
		'task_name' => $this->input->post('task_name'),
		'project_id' => $this->input->post('project_id'),
		'assigned_to' => $assigned_ids,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'task_hour' => $this->input->post('task_hour'),
		'description' => $qt_description
		);
		
		$result = $this->Timesheet_model->update_task_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database
	public function edit_variation() {
	
		if($this->input->post('edit_type')=='variation') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('variation_name')==='') {
        	$Return['error'] = $this->lang->line('xin_project_variation_title_field_error');
		} else if($this->input->post('variation_no')==='') {
        	$Return['error'] = $this->lang->line('xin_project_variation_field_error');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('variation_hour')==='') {
			$Return['error'] = $this->lang->line('xin_project_variation_hrs_field_error');
		} else if($this->input->post('assigned_to')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_assigned_user');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if(null!=$this->input->post('assigned_to')) {
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
		} else {
			$assigned_ids = 'None';
		}
			
		$data = array(
		'variation_name' => $this->input->post('variation_name'),
		'variation_no' => $this->input->post('variation_no'),
		'assigned_to' => $assigned_ids,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'variation_hours' => $this->input->post('variation_hour'),
		'variation_status' => $this->input->post('status'),
		'client_approval' => $this->input->post('client_approval'),
		'description' => $qt_description
		);
		
		$result = $this->Timesheet_model->update_project_variations($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_variation_added_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// get record of leave by id > modal
	public function read_task_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$task_id = $this->input->get('task_id');
		$result = $this->Timesheet_model->read_task_information($task_id);
		
		$data = array(
				'task_id' => $result[0]->task_id,
				'project_id' => $result[0]->project_id,
				'company_id' => $result[0]->company_id,
				'projectid' => $result[0]->project_id,
				'created_by' => $result[0]->created_by,
				'task_name' => $result[0]->task_name,
				'assigned_to' => $result[0]->assigned_to,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'task_hour' => $result[0]->task_hour,
				'task_status' => $result[0]->task_status,
				'task_progress' => $result[0]->task_progress,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_projects' => $this->Project_model->get_all_projects()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/tasks/dialog_task', $data);
		} else {
			redirect('admin/');
		}
	}
	// get record of leave by id > modal
	public function read_variation_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$variation_id = $this->input->get('variation_id');
		$result = $this->Timesheet_model->read_variation_information($variation_id);
		
		$data = array(
				'variation_id' => $result[0]->variation_id,
				'project_id' => $result[0]->project_id,
				'company_id' => $result[0]->company_id,
				'client_approval' => $result[0]->client_approval,
				'created_by' => $result[0]->created_by,
				'variation_name' => $result[0]->variation_name,
				'assigned_to' => $result[0]->assigned_to,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'variation_hours' => $result[0]->variation_hours,
				'variation_status' => $result[0]->variation_status,
				'variation_no' => $result[0]->variation_no,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/tasks/dialog_task', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get record of leave by id > modal
	public function read_leave_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$leave_id = $this->input->get('leave_id');
		$result = $this->Timesheet_model->read_leave_information($leave_id);
		
		$data = array(
				'leave_id' => $result[0]->leave_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'leave_type_id' => $result[0]->leave_type_id,
				'from_date' => $result[0]->from_date,
				'to_date' => $result[0]->to_date,
				'applied_on' => $result[0]->applied_on,
				'is_half_day' => $result[0]->is_half_day,
				'reason' => $result[0]->reason,
				'remarks' => $result[0]->remarks,
				'status' => $result[0]->status,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_leave_types' => $this->Timesheet_model->all_leave_types(),
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_leave', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	// get record of attendance
	public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$attendance_id = $this->input->get('attendance_id');
		$result = $this->Timesheet_model->read_attendance_information($attendance_id);
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
		// user full name
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		
		$in_time = new DateTime($result[0]->clock_in);
		$out_time = new DateTime($result[0]->clock_out);
		
		$clock_in = $in_time->format('H:i');
		if($result[0]->clock_out == '') {
			$clock_out = '';
		} else {
			$clock_out = $out_time->format('H:i');
		}
		
		$data = array(
				'time_attendance_id' => $result[0]->time_attendance_id,
				'employee_id' => $result[0]->employee_id,
				'full_name' => $full_name,
				'attendance_date' => $result[0]->attendance_date,
				'clock_in' => $clock_in,
				'clock_out' => $clock_out
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_attendance', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get record of holiday
	public function read_holiday_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$holiday_id = $this->input->get('holiday_id');
		$result = $this->Timesheet_model->read_holiday_information($holiday_id);
		
		$data = array(
				'holiday_id' => $result[0]->holiday_id,
				'company_id' => $result[0]->company_id,
				'event_name' => $result[0]->event_name,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'is_publish' => $result[0]->is_publish,
				'description' => $result[0]->description,
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_holiday', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get record of office shift
	public function read_shift_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$office_shift_id = $this->input->get('office_shift_id');
		$result = $this->Timesheet_model->read_office_shift_information($office_shift_id);
		
		$data = array(
				'office_shift_id' => $result[0]->office_shift_id,
				'company_id' => $result[0]->company_id,
				'shift_name' => $result[0]->shift_name,
				'monday_in_time' => $result[0]->monday_in_time,
				'monday_out_time' => $result[0]->monday_out_time,
				'tuesday_in_time' => $result[0]->tuesday_in_time,
				'tuesday_out_time' => $result[0]->tuesday_out_time,
				'wednesday_in_time' => $result[0]->wednesday_in_time,
				'wednesday_out_time' => $result[0]->wednesday_out_time,
				'thursday_in_time' => $result[0]->thursday_in_time,
				'thursday_out_time' => $result[0]->thursday_out_time,
				'friday_in_time' => $result[0]->friday_in_time,
				'friday_out_time' => $result[0]->friday_out_time,
				'saturday_in_time' => $result[0]->saturday_in_time,
				'saturday_out_time' => $result[0]->saturday_out_time,
				'sunday_in_time' => $result[0]->sunday_in_time,
				'get_all_companies' => $this->Xin_model->get_companies(),
				'sunday_out_time' => $result[0]->sunday_out_time
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_office_shift', $data);
		} else {
			redirect('admin/');
		}
	}
	//read_map_info
	public function read_map_info()
	{
		$data['title'] = $this->Xin_model->site_title();
		//$office_shift_id = $this->input->get('office_shift_id');
		//$result = $this->Timesheet_model->read_office_shift_information($office_shift_id);
		
		$data = array(
			//	'office_shift_id' => $result[0]->office_shift_id,
				//'company_id' => $result[0]->company_id
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_read_map', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and update info in database
	public function edit_attendance() {
	
		if($this->input->post('edit_type')=='attendance') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('attendance_date_e')==='') {
        	$Return['error'] = $this->lang->line('xin_error_attendance_date');
		} else if($this->input->post('clock_in')==='') {
        	$Return['error'] = $this->lang->line('xin_error_attendance_in_time');
		} /*else if($this->input->post('clock_out')==='') {
        	$Return['error'] = "The office Out Time field is required.";
		}*/
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$attendance_date = $this->input->post('attendance_date_e');
		$clock_in = $this->input->post('clock_in');
		
		$clock_in2 = $attendance_date.' '.$clock_in.':00';
		
		//total work
		$total_work_cin =  new DateTime($clock_in2);
		
		if($this->input->post('clock_out') ==='') {
			$data = array(
			'employee_id' => $this->input->post('emp_att'),
			'attendance_date' => $attendance_date,
			'clock_in' => $clock_in2,
			'time_late' => $clock_in2,
			'early_leaving' => $clock_in2,
			'overtime' => $clock_in2,
		);
		} else {
			$clock_out = $this->input->post('clock_out');
			$clock_out2 = $attendance_date.' '.$clock_out.':00';
			$total_work_cout =  new DateTime($clock_out2);
			
			$interval_cin = $total_work_cout->diff($total_work_cin);
			$hours_in   = $interval_cin->format('%h');
			$minutes_in = $interval_cin->format('%i');
			$total_work = $hours_in .":".$minutes_in;
		
			$data = array(
			'employee_id' => $this->input->post('emp_att'),
			'attendance_date' => $attendance_date,
			'clock_in' => $clock_in2,
			'clock_out' => $clock_out2,
			'time_late' => $clock_in2,
			'total_work' => $total_work,
			'early_leaving' => $clock_out2,
			'overtime' => $clock_out2,
			'attendance_status' => 'Present',
			'clock_in_out' => '0'
			);
		}
		
		$result = $this->Timesheet_model->update_attendance_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_attendance_update');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function default_shift() {
	
		if($this->input->get('office_shift_id')) {
			
		$id = $this->input->get('office_shift_id');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		$data = array(
		'default_shift' => '0'
		);
		
		$data2 = array(
		'default_shift' => '1'
		);
		
		$result = $this->Timesheet_model->update_default_shift_zero($data);
		$result = $this->Timesheet_model->update_default_shift_record($data2,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_shift_default_made');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_office_shift() {
	
		if($this->input->post('add_type')=='office_shift') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('shift_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_shift_name_field');
		} else if($this->input->post('monday_in_time')!='' && $this->input->post('monday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_monday_timeout');
		} else if($this->input->post('tuesday_in_time')!='' && $this->input->post('tuesday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_tuesday_timeout');
		} else if($this->input->post('wednesday_in_time')!='' && $this->input->post('wednesday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_wednesday_timeout');
		} else if($this->input->post('thursday_in_time')!='' && $this->input->post('thursday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_thursday_timeout');
		} else if($this->input->post('friday_in_time')!='' && $this->input->post('friday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_friday_timeout');
		} else if($this->input->post('saturday_in_time')!='' && $this->input->post('saturday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_saturday_timeout');
		} else if($this->input->post('sunday_in_time')!='' && $this->input->post('sunday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_sunday_timeout');
		} 
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
			
		$data = array(
		'shift_name' => $this->input->post('shift_name'),
		'company_id' => $this->input->post('company_id'),
		'monday_in_time' => $this->input->post('monday_in_time'),
		'monday_out_time' => $this->input->post('monday_out_time'),
		'tuesday_in_time' => $this->input->post('tuesday_in_time'),
		'tuesday_out_time' => $this->input->post('tuesday_out_time'),
		'wednesday_in_time' => $this->input->post('wednesday_in_time'),
		'wednesday_out_time' => $this->input->post('wednesday_out_time'),
		'thursday_in_time' => $this->input->post('thursday_in_time'),
		'thursday_out_time' => $this->input->post('thursday_out_time'),
		'friday_in_time' => $this->input->post('friday_in_time'),
		'friday_out_time' => $this->input->post('friday_out_time'),
		'saturday_in_time' => $this->input->post('saturday_in_time'),
		'saturday_out_time' => $this->input->post('saturday_out_time'),
		'sunday_in_time' => $this->input->post('sunday_in_time'),
		'sunday_out_time' => $this->input->post('sunday_out_time'),
		'created_at' => date('Y-m-d')
		);
		$result = $this->Timesheet_model->add_office_shift_record($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_shift_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function edit_office_shift() {
	
		if($this->input->post('edit_type')=='shift') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('shift_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_shift_name_field');
		} else if($this->input->post('monday_in_time')!='' && $this->input->post('monday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_monday_timeout');
		} else if($this->input->post('tuesday_in_time')!='' && $this->input->post('tuesday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_tuesday_timeout');
		} else if($this->input->post('wednesday_in_time')!='' && $this->input->post('wednesday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_wednesday_timeout');
		} else if($this->input->post('thursday_in_time')!='' && $this->input->post('thursday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_thursday_timeout');
		} else if($this->input->post('friday_in_time')!='' && $this->input->post('friday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_friday_timeout');
		} else if($this->input->post('saturday_in_time')!='' && $this->input->post('saturday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_saturday_timeout');
		} else if($this->input->post('sunday_in_time')!='' && $this->input->post('sunday_out_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_shift_sunday_timeout');
		} 
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
			
		$data = array(
		'shift_name' => $this->input->post('shift_name'),
		'company_id' => $this->input->post('company_id'),
		'monday_in_time' => $this->input->post('monday_in_time'),
		'monday_out_time' => $this->input->post('monday_out_time'),
		'tuesday_in_time' => $this->input->post('tuesday_in_time'),
		'tuesday_out_time' => $this->input->post('tuesday_out_time'),
		'wednesday_in_time' => $this->input->post('wednesday_in_time'),
		'wednesday_out_time' => $this->input->post('wednesday_out_time'),
		'thursday_in_time' => $this->input->post('thursday_in_time'),
		'thursday_out_time' => $this->input->post('thursday_out_time'),
		'friday_in_time' => $this->input->post('friday_in_time'),
		'friday_out_time' => $this->input->post('friday_out_time'),
		'saturday_in_time' => $this->input->post('saturday_in_time'),
		'saturday_out_time' => $this->input->post('saturday_out_time'),
		'sunday_in_time' => $this->input->post('sunday_in_time'),
		'sunday_out_time' => $this->input->post('sunday_out_time')
		);
		
		$result = $this->Timesheet_model->update_shift_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_shift_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// delete attendance record
	public function delete_attendance() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_attendance_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_employe_attendance_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete holiday record
	public function delete_holiday() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_holiday_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_holiday_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete shift record
	public function delete_shift() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_shift_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_shift_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete leave record
	public function delete_leave() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_leave_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_leave_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function delete_task() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_task_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_task_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function delete_variation() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_variation_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_project_variation_added_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// Validate and update info in database // add_note
	public function add_note() {
	
		if($this->input->post('type')=='add_note') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'task_note' => $this->input->post('task_note')
		);
		$id = $this->input->post('note_task_id');
		$result = $this->Timesheet_model->update_task_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_note_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// monthly timesheet
	public function timesheet_monthly_employees()
	{
		/* Define return | here result is used to return user data and error for error message */	
		if($this->input->post('employee_id')==0){
			$xin_employees = $this->Xin_model->all_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
		foreach($xin_employees as $hr_user) { 
				
			$full_name = $hr_user->first_name.' '.$hr_user->last_name;	
			$designation = $this->Designation_model->read_designation_information($hr_user->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			// department
			$department = $this->Department_model->read_department_information($hr_user->department_id);
			if(!is_null($department)){
			$department_name = $department[0]->department_name;
			} else {
			$department_name = '--';
			}
			$user_info = $full_name.' ('.$designation_name.')';
		
			$someArray[] = array(
			  'id' => $hr_user->user_id,
			  'title'   => htmlspecialchars_decode($user_info),
			  'occupancy' => $hr_user->user_id
			  );
		}
		$this->output($someArray);
		exit;
	}
	// monthly timesheet resources
	public function timesheet_monthly_resources()
	{
		/* Define return | here result is used to return user data and error for error message */	
		$someArray = array();
		$xin_employees = $this->Xin_model->all_employees();
		/*$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$month_year = date('Y-m');*/
		$month_year = $this->input->post('month_year');
		if(isset($month_year)){
			$date = strtotime($this->input->post('month_year').'-01');
			$imonth_year = explode('-',$this->input->post('month_year'));
			$day = date('d', $date);
			$month = date($imonth_year[1], $date);
			$year = date($imonth_year[0], $date);
			$month_year = $this->input->get('month_year');
		} else {
			$date = strtotime(date("Y-m-d"));
			//$date = strtotime('2020-05-01');
			$day = date('d', $date);
			$month = date('m', $date);
			$year = date('Y', $date);
			$month_year = date('Y-m');
		}
		// total days in month
		$daysInMonth = date('t');
		
		$imonth = date('F', $date);
		$j=0;foreach($xin_employees as $r) { 
				
			// user full name 
			$full_name = $r->first_name.' '.$r->last_name;
			// get designation
			/*$designation = $this->Designation_model->read_designation_information($r->designation_id);
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
			}*/
		//	$department_designation = $designation_name.' ('.$department_name.')';$pcount=0;
			
			for($i = 1; $i <= $daysInMonth; $i++):
				$i = str_pad($i, 2, 0, STR_PAD_LEFT);
				// get date <
				$attendance_date = $year.'-'.$month.'-'.$i;
				$tdate = $year.'-'.$month.'-'.$i;
				$get_day = strtotime($attendance_date);
				$day = date('l', $get_day);
				$user_id = $r->user_id;
				// office shift
				$office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
				// get holiday
				$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
				$holiday_arr = array();
				if($h_date_chck->num_rows() == 1){
					$h_date = $this->Timesheet_model->holiday_date($attendance_date);
					$begin = new DateTime( $h_date[0]->start_date );
					$end = new DateTime( $h_date[0]->end_date);
					$end = $end->modify( '+1 day' ); 
					
					$interval = new DateInterval('P1D');
					$daterange = new DatePeriod($begin, $interval ,$end);
					
					foreach($daterange as $date){
						$holiday_arr[] =  $date->format("Y-m-d");
					}
				} else {
					$holiday_arr[] = '99-99-99';
				}
				//echo '<pre>'; print_r($holiday_arr);
				// get leave/employee
				$leave_date_chck = $this->Timesheet_model->leave_date_check($r->user_id,$attendance_date);
				$leave_arr = array();
				if($leave_date_chck->num_rows() == 1){
					$leave_date = $this->Timesheet_model->leave_date($r->user_id,$attendance_date);
					$begin1 = new DateTime( $leave_date[0]->from_date );
					$end1 = new DateTime( $leave_date[0]->to_date);
					$end1 = $end1->modify( '+1 day' ); 
					
					$interval1 = new DateInterval('P1D');
					$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
					
					foreach($daterange1 as $date1){
						$leave_arr[] =  $date1->format("Y-m-d");
					}	
				} else {
					$leave_arr[] = '99-99-99';
				}
				$attendance_status = '';
				$check = $this->Timesheet_model->attendance_first_in_check($r->user_id,$attendance_date);
				if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
					$status = 'H';	
				} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
					$status = 'H';
				} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
					$status = 'H';
				} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
					$status = 'H';
				} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
					$status = 'H';
				} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
					$status = 'H';
				} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
					$status = 'H';
				} else if(in_array($attendance_date,$holiday_arr)) { // holiday
					$status = 'H';
				} else if(in_array($attendance_date,$leave_arr)) { // on leave
					$status = 'L';
				} else if($check->num_rows() > 0){
					$attendance = $this->Timesheet_model->attendance_first_in($r->user_id,$attendance_date);
					$status = 'P';					
				} else {
					$status = 'A';
					//$pcount += 0;
				}
				//$pcount += $check->num_rows();
				// set to present date
				$iattendance_date = strtotime($attendance_date);
				//$icurrent_date = strtotime(date('Y-m-d'));
				$status = $status;
				/*if($iattendance_date <= $icurrent_date){
					$status = $status;
				} else {
					$status = '1';
				}*/
				$idate_of_joining = strtotime($r->date_of_joining);
				if($idate_of_joining < $iattendance_date){
					$status = $status;
				} else {
					$status = '';
				}
				
			$someArray[] = array(
			  'title' => $status,
			  'resourceIds' => $r->user_id,
			  'start'   => $attendance_date,
			  'end'   => $attendance_date,
			  );
			  endfor;	
		}
		$this->output($someArray);
		exit;
	}
	// set clock in - clock out > attendance
	public function set_clocking() {
	
		if($this->input->post('type')=='set_clocking') {
			$system = $this->Xin_model->read_setting_info(1);
			//if($system[0]->system_ip_restriction == 'yes'){
				$sys_arr = explode(',',$system[0]->system_ip_address);
					//if(in_array($this->input->ip_address(),$sys_arr)) { 
					//if($system[0]->system_ip_address == $this->input->ip_address()){	
					/* Define return | here result is used to return user data and error for error message */
					$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
					$Return['csrf_hash'] = $this->security->get_csrf_hash();	
					
					$session = $this->session->userdata('username');
					
					$employee_id = $session['user_id'];
					$clock_state = $this->input->post('clock_state');
					$latitude = $this->input->post('latitude');
					$longitude = $this->input->post('longitude');
					$time_id = $this->input->post('time_id');
					// set time
					$nowtime = date("Y-m-d H:i:s");
					//$date = date('Y-m-d H:i:s', strtotime($nowtime . ' + 4 hours'));
					$date = date('Y-m-d H:i:s');
					$curtime = $date;
					$today_date = date('Y-m-d');	
					
					if($clock_state=='clock_in') {
						$query = $this->Timesheet_model->check_user_attendance();
						$result = $query->result();
						if($query->num_rows() < 1) {
							$total_rest = '';
						} else {
							$cout =  new DateTime($result[0]->clock_out);
							$cin =  new DateTime($curtime);
							
							$interval_cin = $cin->diff($cout);
							$hours_in   = $interval_cin->format('%h');
							$minutes_in = $interval_cin->format('%i');
							$total_rest = $hours_in .":".$minutes_in;
						}
						
						$data = array(
						'employee_id' => $employee_id,
						'attendance_date' => $today_date,
						'clock_in' => $curtime,
						'clock_in_ip_address' => $this->input->ip_address(),
						'clock_in_latitude' => $latitude,
						'clock_in_longitude' => $longitude,
						'time_late' => $curtime,
						'early_leaving' => $curtime,
						'overtime' => $curtime,
						'total_rest' => $total_rest,
						'attendance_status' => 'Present',
						'clock_in_out' => '1'
						);
						
						$result = $this->Timesheet_model->add_new_attendance($data);
									
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('xin_success_clocked_in');
						} else {
							$Return['error'] = $this->lang->line('xin_error_msg');
						}
					} else if($clock_state=='clock_out') {
						
						$query = $this->Timesheet_model->check_user_attendance_clockout();
						$clocked_out = $query->result();
						$total_work_cin =  new DateTime($clocked_out[0]->clock_in);
						$total_work_cout =  new DateTime($curtime);
						
						$interval_cin = $total_work_cout->diff($total_work_cin);
						$hours_in   = $interval_cin->format('%h');
						$minutes_in = $interval_cin->format('%i');
						$total_work = $hours_in .":".$minutes_in;
						
						$data = array(
							'employee_id' => $employee_id,
							'clock_out' => $curtime,
							'clock_out_ip_address' => $this->input->ip_address(),
							'clock_out_latitude' => $latitude,
							'clock_out_longitude' => $longitude,
							'clock_in_out' => '0',
							'early_leaving' => $curtime,
							'overtime' => $curtime,
							'total_work' => $total_work
						);
						
			
						$id = $this->input->post('time_id');
						$resuslt2 = $this->Timesheet_model->update_attendance_clockedout($data,$id);
						
						if ($resuslt2 == TRUE) {
							$Return['result'] = $this->lang->line('xin_success_clocked_out');
							$Return['time_id'] = '';
						} else {
							$Return['error'] = $this->lang->line('xin_error_msg');
						}
					
					}
						
					$this->output($Return);
					exit;
				}
	}
}
