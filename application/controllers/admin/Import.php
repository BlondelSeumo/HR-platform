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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
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
	 
	// import
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_imports').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_imports');
		$data['path_url'] = 'hrsale_import';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('111',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/layout/hrsale_import", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}	 
	
	// Validate and add info in database
	public function import_employees() {
	
		if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					//skip first line
					fgetcsv($csvFile);
					
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
					
						$data = array(
						'first_name' => $line[0],
						'last_name' => $line[1],
						'username' => $line[2],
						'email' => $line[3],
						'password' => $line[4],
						'employee_id' => $line[5],
						'date_of_joining' => $line[6],
						'gender' => $line[7],
						'date_of_birth' => $line[8],
						'contact_no' => $line[9],
						/*'address' => $line[10],*/
						'company_id' => $line[10],
						'location_id' => $line[11],
						'department_id' =>$line[12],
						'sub_department_id' =>$line[13],
						'designation_id' => $line[14],
						'user_role_id' => $line[15],
						'marital_status' => $line[16],
						'is_active' => $line[17],
						'office_shift_id' => $line[18],
						'leave_categories' => $line[19],
						'created_at' => date('Y-m-d h:i:s')
						);
					$last_insert_id = $this->Employees_model->add($data);
					$immigration_data = array(
					'document_type_id' => $line[20],
					'document_number' => $line[21],
					'document_file' => $line[22],
					'issue_date' => $line[23],
					'expiry_date' => $line[24],
					'country_id' => $line[25],
					'eligible_review_date' => $line[26],
					'employee_id' => $last_insert_id,
					'created_at' => date('d-m-Y h:i:s'),
					);
					$iimmigration = $this->Employees_model->immigration_info_add($immigration_data);
					$contact_data = array(
					'relation' => $line[27],
					'work_email' => $line[28],
					'is_primary' => $line[29],
					'is_dependent' => $line[30],
					'personal_email' => $line[31],
					'contact_name' => $line[32],
					'address_1' => $line[33],
					'work_phone' => $line[34],
					'work_phone_extension' => $line[35],
					'address_2' => $line[36],
					'mobile_phone' => $line[37],
					'city' => $line[38],
					'state' => $line[39],
					'zipcode' => $line[40],
					'home_phone' => $line[41],
					'country' => $line[42],
					'employee_id' => $last_insert_id,
					'created_at' => date('d-m-Y'),
					);
					$icontact = $this->Employees_model->contact_info_add($contact_data);
					$document_data = array(
					'document_type_id' =>  $line[43],
					'date_of_expiry' =>  $line[44],
					'title' =>  $line[45],
					'notification_email' =>  $line[46],
					'description' =>  $line[47],
					'document_file' => $line[48],
					'is_alert' =>  $line[49],
					'employee_id' => $last_insert_id,
					'created_at' => date('d-m-Y'),
					);
					$idocument = $this->Employees_model->document_info_add($document_data);
					$qualificaton_data = array(
					'name' => $line[50],
					'education_level_id' => $line[51],
					'from_year' => $line[52],
					'to_year' => $line[53],
					'skill_id' => $line[54],
					'language_id' => $line[55],
					'description' => $line[56],
					'employee_id' => $last_insert_id,
					'created_at' => date('d-m-Y'),
					);
					$iqualificaton = $this->Employees_model->qualification_info_add($qualificaton_data);
					$experience_data = array(
					'company_name' => $line[57],
					'post' => $line[58],
					'from_date' => $line[59],
					'to_date' => $line[60],
					'description' => $line[61],
					'employee_id' => $last_insert_id,
					'created_at' => date('d-m-Y'),
					);
					$iexperience = $this->Employees_model->work_experience_info_add($experience_data);
					$bank_account_data = array(
					'account_title' => $line[62],
					'account_number' => $line[63],
					'bank_name' => $line[64],
					'bank_code' => $line[65],
					'bank_branch' => $line[66],
					'employee_id' => $last_insert_id,
					'created_at' => date('d-m-Y'),
					);
					$ibank_account = $this->Employees_model->bank_account_info_add($bank_account_data);
				}					
				//close opened csv file
				fclose($csvFile);
	
				$Return['result'] = $this->lang->line('xin_success_attendance_import');
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_employee_import');
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
	
	 // Validate and add info in database
	public function import_leads() {
	
		if($this->input->post('is_ajax')=='3') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
		if($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					//skip first line
					fgetcsv($csvFile);
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
						
						$options = array('cost' => 12);
						$password_hash = password_hash($line[2], PASSWORD_BCRYPT, $options);
						$data = array(
						'name' => $line[0],
						'email' => $line[1],
						'client_password' => $password_hash,
						'contact_number' => $line[3],
						'company_name' => $line[4],
						'website_url' => $line[5],
						'address_1' => $line[6],
						'address_2' => $line[7],
						'city' => $line[8],
						'state' => $line[9],
						'zipcode' => $line[10],
						'country' => $line[11],
						'is_active' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'is_changed' => '0',
						'client_profile' => '',
						);
					$this->Clients_model->add_lead($data);
				}					
				//close opened csv file
				fclose($csvFile);
	
				$Return['result'] = $this->lang->line('xin_success_leads_import');
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_not_leads_import');
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
} 
?>