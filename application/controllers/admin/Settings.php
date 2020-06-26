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

require_once('Backup_hrsale.php');

class Settings extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Employee_exit_model");
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Finance_model");
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
		$data['title'] = $this->lang->line('left_settings').' | '.$this->Xin_model->site_title();
		$setting = $this->Xin_model->read_setting_info(1);
		$company_info = $this->Xin_model->read_company_setting_info(1);
		$email_config = $this->Xin_model->read_email_config_info(1);
		$theme_info = $this->Xin_model->read_theme_info(1);
		$data = array(
			'title' => $this->lang->line('left_settings').' | '.$this->Xin_model->site_title(),
			'company_info_id' => $company_info[0]->company_info_id,
			'logo' => $company_info[0]->logo,
			'logo_second' => $company_info[0]->logo_second,
			'favicon' => $company_info[0]->favicon,
			'sign_in_logo' => $company_info[0]->sign_in_logo,
			'job_logo' => $setting[0]->job_logo,
			'payroll_logo' => $setting[0]->payroll_logo,
			'is_payslip_password_generate' => $setting[0]->is_payslip_password_generate,
			'payslip_password_format' => $setting[0]->payslip_password_format,
			'company_name' => $company_info[0]->company_name,
			'contact_person' => $company_info[0]->contact_person,
			'website_url' => $company_info[0]->website_url,
			'starting_year' => $company_info[0]->starting_year,
			'company_email' => $company_info[0]->company_email,
			'company_contact' => $company_info[0]->company_contact,
			'email' => $company_info[0]->email,
			'phone' => $company_info[0]->phone,
			'address_1' => $company_info[0]->address_1,
			'address_2' => $company_info[0]->address_2,
			'city' => $company_info[0]->city,
			'state' => $company_info[0]->state,
			'zipcode' => $company_info[0]->zipcode,
			'country' => $company_info[0]->country,
			'updated_at' => $company_info[0]->updated_at,
			'application_name' => $setting[0]->application_name,
			'default_currency_symbol' => $setting[0]->default_currency_symbol,
			'show_currency' => $setting[0]->show_currency,
			'currency_position' => $setting[0]->currency_position,
			'date_format_xi' => $setting[0]->date_format_xi,
			'animation_effect' => $setting[0]->animation_effect,
			'animation_effect_topmenu' => $setting[0]->animation_effect_topmenu,
			'animation_effect_modal' => $setting[0]->animation_effect_modal,
			'notification_position' => $setting[0]->notification_position,
			'notification_close_btn' => $setting[0]->notification_close_btn,
			'notification_bar' => $setting[0]->notification_bar,
			'employee_manage_own_bank_account' => $setting[0]->employee_manage_own_bank_account,
			'employee_manage_own_contact' => $setting[0]->employee_manage_own_contact,
			'employee_manage_own_profile' => $setting[0]->employee_manage_own_profile,
			'employee_manage_own_qualification' => $setting[0]->employee_manage_own_qualification,
			'employee_manage_own_work_experience' => $setting[0]->employee_manage_own_work_experience,
			'employee_manage_own_document' => $setting[0]->employee_manage_own_document,
			'employee_manage_own_picture' => $setting[0]->employee_manage_own_picture,
			'employee_manage_own_social' => $setting[0]->employee_manage_own_social,
			'enable_attendance' => $setting[0]->enable_attendance,
			'enable_clock_in_btn' => $setting[0]->enable_clock_in_btn,
			'enable_email_notification' => $setting[0]->enable_email_notification,
			'enable_job_application_candidates' => $setting[0]->enable_job_application_candidates,
			'job_application_format' => $setting[0]->job_application_format,
			'technical_competencies' => $setting[0]->technical_competencies,
			'organizational_competencies' => $setting[0]->organizational_competencies,
			'footer_text' => $setting[0]->footer_text,
			'email_type' => $email_config[0]->email_type,
			'smtp_host' => $email_config[0]->smtp_host,
			'smtp_username' => $email_config[0]->smtp_username,
			'smtp_password' => $email_config[0]->smtp_password,
			'smtp_port' => $email_config[0]->smtp_port,
			'smtp_secure' => $email_config[0]->smtp_secure,
			'enable_page_rendered' => $setting[0]->enable_page_rendered,
			'enable_current_year' => $setting[0]->enable_current_year,
			'employee_login_id' => $setting[0]->employee_login_id,
			'enable_auth_background' => $setting[0]->enable_auth_background,
			'system_timezone' => $setting[0]->system_timezone,
			'system_ip_address' => $setting[0]->system_ip_address,
			'google_maps_api_key' => $setting[0]->google_maps_api_key,
			'is_ssl_available' => $setting[0]->is_ssl_available,
			'is_half_monthly' => $setting[0]->is_half_monthly,
			'half_deduct_month' => $setting[0]->half_deduct_month,
			'default_language' => $setting[0]->default_language,
			'show_projects' => $setting[0]->show_projects,
			'show_tasks' => $setting[0]->show_tasks,
			'statutory_fixed' => $setting[0]->statutory_fixed,
			'estimate_terms_condition' => $setting[0]->estimate_terms_condition,
			'invoice_terms_condition' => $setting[0]->invoice_terms_condition,
			'statistics_cards' => $theme_info[0]->statistics_cards,
			'dashboard_option' => $theme_info[0]->dashboard_option,
			'dashboard_calendar' => $theme_info[0]->dashboard_calendar,
			'login_page_options' => $theme_info[0]->login_page_options,
			'export_orgchart' => $theme_info[0]->export_orgchart,
			'export_file_title' => $theme_info[0]->export_file_title,
			'org_chart_layout' => $theme_info[0]->org_chart_layout,
			'org_chart_zoom' => $theme_info[0]->org_chart_zoom,
			'org_chart_pan' => $theme_info[0]->org_chart_pan,
			'login_page_text' => $theme_info[0]->login_page_text,
			'enable_saudi_gosi' => $setting[0]->enable_saudi_gosi,
			'logo' => $company_info[0]->logo,
			'logo_second' => $company_info[0]->logo_second,
			'favicon' => $company_info[0]->favicon,
			'sign_in_logo' => $company_info[0]->sign_in_logo,
			'job_logo' => $setting[0]->job_logo,
			'payroll_logo' => $setting[0]->payroll_logo,
			'all_countries' => $this->Xin_model->get_countries(),
			'module_recruitment' => $setting[0]->module_recruitment,
			'module_travel' => $setting[0]->module_travel,
			'module_performance' => $setting[0]->module_performance,
			'module_files' => $setting[0]->module_files,
			'module_awards' => $setting[0]->module_awards,
			'module_training' => $setting[0]->module_training,
			'module_inquiry' => $setting[0]->module_inquiry,
			'module_language' => $setting[0]->module_language,
			'module_orgchart' => $setting[0]->module_orgchart,
			'module_accounting' => $setting[0]->module_accounting,
			'module_events' => $setting[0]->module_events,
			'module_goal_tracking' => $setting[0]->module_goal_tracking,
			'module_assets' => $setting[0]->module_assets,
			'module_payroll' => $setting[0]->module_payroll,
			'module_chat_box' => $setting[0]->module_chat_box,
			'is_active_sub_departments' => $setting[0]->is_active_sub_departments,
			'paypal_email' => $setting[0]->paypal_email,
			'paypal_sandbox' => $setting[0]->paypal_sandbox,
			'paypal_active' => $setting[0]->paypal_active,
			'stripe_secret_key' => $setting[0]->stripe_secret_key,
			'stripe_publishable_key' => $setting[0]->stripe_publishable_key,
			'stripe_active' => $setting[0]->stripe_active,
			'online_payment_account' => $setting[0]->online_payment_account,
			'performance_option' => $setting[0]->performance_option,
			'all_bank_cash' => $this->Finance_model->all_bank_cash(),
			'all_companies' => $this->Xin_model->get_companies()
			);
		$data['breadcrumbs'] = $this->lang->line('left_settings');
		$data['path_url'] = 'settings';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('60',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/settings/settings", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 // get all constants > all types
	public function constants()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_constants').' | '.$this->Xin_model->site_title();
		//$setting = $this->Xin_model->read_setting_info(1);
		$company_info = $this->Xin_model->read_company_setting_info(1);
		$data['breadcrumbs'] = $this->lang->line('left_constants');
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'constants';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('61',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/settings/constants", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }	 
	  public function payment_gateway()
     {	

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_acc_payment_gateway').' | '.$this->Xin_model->site_title();
		$setting = $this->Xin_model->read_setting_info(1);
		$data = array(
			'title' => $this->lang->line('xin_acc_payment_gateway').' | '.$this->Xin_model->site_title(),
			'paypal_email' => $setting[0]->paypal_email,
			'paypal_sandbox' => $setting[0]->paypal_sandbox,
			'paypal_active' => $setting[0]->paypal_active,
			'stripe_secret_key' => $setting[0]->stripe_secret_key,
			'stripe_publishable_key' => $setting[0]->stripe_publishable_key,
			'stripe_active' => $setting[0]->stripe_active,
			'online_payment_account' => $setting[0]->online_payment_account,
			'all_bank_cash' => $this->Finance_model->all_bank_cash()
			);
		$data['breadcrumbs'] = $this->lang->line('xin_acc_payment_gateway');
		$data['path_url'] = 'xin_payment_gateway';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('118',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/settings/payment_gateway_settings", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 // database backup
	 public function database_backup()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_db_backup').' | '.$this->Xin_model->site_title();
		$setting = $this->Xin_model->read_setting_info(1);
		$company_info = $this->Xin_model->read_company_setting_info(1);
		$data['breadcrumbs'] = $this->lang->line('left_db_backup');
		$data['path_url'] = 'database_backup';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('62',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/settings/database_backup", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 	 
	 // system modules
	 public function modules()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$setting = $this->Xin_model->read_setting_info(1);
		$data['breadcrumbs'] = $this->lang->line('xin_modules');
		$data['path_url'] = 'modules_setup';
		$data = array(
			'title' => $this->lang->line('xin_modules').' | '.$this->Xin_model->site_title(),
			'path_url' => 'modules_setup',
			'breadcrumbs' => $this->lang->line('xin_modules'),
			'module_recruitment' => $setting[0]->module_recruitment,
			'module_travel' => $setting[0]->module_travel,
			'module_performance' => $setting[0]->module_performance,
			'module_files' => $setting[0]->module_files,
			'module_awards' => $setting[0]->module_awards,
			'module_training' => $setting[0]->module_training,
			'module_inquiry' => $setting[0]->module_inquiry,
			'module_language' => $setting[0]->module_language,
			'module_orgchart' => $setting[0]->module_orgchart,
			'module_accounting' => $setting[0]->module_accounting,
			'module_events' => $setting[0]->module_events,
			'module_goal_tracking' => $setting[0]->module_goal_tracking,
			'module_assets' => $setting[0]->module_assets,
			'module_payroll' => $setting[0]->module_payroll,
			'module_chat_box' => $setting[0]->module_chat_box,
			'is_active_sub_departments' => $setting[0]->is_active_sub_departments,
			);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('93',$role_resources_ids)) {	
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/settings/modules", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	  			 
	 public function create_database_backup()
     {
		$data['title'] = $this->Xin_model->site_title();
		if($this->input->post('type')==='backup') {
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$db = array('default' => array());
			// get db credentials
			require 'application/config/database.php';
			$hostname = $db['default']['hostname'];
			$username = $db['default']['username'];
			$password = $db['default']['password'];
			$database = $db['default']['database'];
				
			$dir  = 'uploads/dbbackup/'; // directory files
			$name = 'hrsale_backup_'.date('d-m-Y').'_'.time(); // name sql backup
			
			$newImport = new Backup_hrsale($hostname,$database,$username,$password);
			$newImport->backup();					
					
			$fname = $name.'.sql';
					
			$data = array(
			'backup_file' => $fname,
			'created_at' => date('d-m-Y H:i:s')
			);
			
			$result = $this->Xin_model->add_backup($data);	
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_database_backup_generated');
				
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
     }
	 public function restore_database_backup()
     {
		$data['title'] = $this->Xin_model->site_title();
		if($this->input->post('type')==='restore') {
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('restore_id')==='') {
				$Return['error'] = $this->lang->line('xin_database_backup_field_error');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$dir  = 'uploads/dbbackup/'; // directory files
			$restore = $this->Xin_model->read_db_backup($this->input->post('restore_id'));
			$filename = $dir.$restore[0]->backup_file;
			//call of restore function
			$db = array('default' => array());
			// get db credentials
			require 'application/config/database.php';
			$hostname = $db['default']['hostname'];
			$username = $db['default']['username'];
			$password = $db['default']['password'];
			$database = $db['default']['database'];
			$newImport = new Backup_hrsale($hostname,$database,$username,$password);
        	$msg = $newImport->restore($filename);
			if($msg == 1){
				$Return['result'] = $this->lang->line('xin_databse_restored_success');
				$this->session->set_flashdata('restore_msg',$this->lang->line('xin_databse_restored_success'));
			}
			$this->output($Return);
			exit;
		}
     }
	 // get database backup
	 public function get_database_backup() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'restore_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/get_database_backup", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 public function delete_db_backup()
     {
		if($this->input->post('type')==='delete_old_backup') {
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			/*Delete backup*/
			$result = $this->Xin_model->delete_all_backup_record();
			$baseurl = base_url();
			$files = glob('uploads/dbbackup/*'); //get all file names
			foreach($files as $file){
				if(is_file($file))
				unlink($file); //delete file
			}
			
			$Return['result'] = $this->lang->line('xin_success_database_old_backup_deleted');
			$this->output($Return);
			exit;
		}
     }
	 
	 // backup list
	  public function database_backup_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$db_backup = $this->Xin_model->all_db_backup();

		$data = array();

        foreach($db_backup->result() as $r) {
			
			$created_at = $this->Xin_model->set_date_format($r->created_at);
						 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=dbbackup&filename='.$r->backup_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light deletedb" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->backup_id . '"><span class="fas fa-trash-restore"></span></button></span>',
			$r->backup_file,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $db_backup->num_rows(),
			 "recordsFiltered" => $db_backup->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
    }
	 
	public function email_template() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_email_templates').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_email_templates');
		$data['path_url'] = 'email_template';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('63',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/settings/email_template", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     } 
	
	// email templates > list
	  public function email_template_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$email_template = $this->Xin_model->get_email_templates();

		$data = array();

        foreach($email_template->result() as $r) {
			
		if($r->status==1){
			$status = '<span class="badge badge-pill badge-success">'.$this->lang->line('xin_employees_active').'</span>';
		} else {
			$status = '<span class="badge badge-pill badge-danger">'.$this->lang->line('xin_employees_inactive').'</span>';
		}
						 			  				
		$data[] = array('<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#modals-slide"  data-template_id="'. $r->template_id . '"><span class="fas fa-pencil-alt"></span></button></span>',
			$r->name,
			$r->subject,
			$status
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $email_template->num_rows(),
			 "recordsFiltered" => $email_template->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     } 
	 // security level type > list
	  public function security_level_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_security_level_type();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_id . '" data-field_type="security_level"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_id . '" data-token_type="security_level"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	public function read_tempalte()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('template_id');
		$result = $this->Xin_model->read_email_template_info($id);
		$data = array(
				'template_id' => $result[0]->template_id,
				'template_code' => $result[0]->template_code,
				'name' => $result[0]->name,
				'subject' => $result[0]->subject,
				'message' => $result[0]->message,
				'status' => $result[0]->status
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/settings/dialog_email_template', $data);
		} else {
			redirect('admin/');
		}
	} 
	
	public function password_read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('user_id');
		$result = $this->Xin_model->read_user_info($id);
		$data = array(
				'user_id' => $result[0]->user_id,
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/settings/dialog_constants', $data);
		} else {
			redirect('admin/');
		}
	} 
	
	public function policy_read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/settings/dialog_constants', $data);
		} else {
			redirect('admin/');
		}
	} 
	
	// Validate and update info in database
	public function update_template() {
	
		if($this->input->post('edit_type')=='update_template') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('name')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($this->input->post('subject')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_subject');
		} else if($this->input->post('status')==='') {
			 $Return['error'] = $this->lang->line('xin_error_template_status');
		} else if($this->input->post('message')==='') {
			$Return['error'] = $this->lang->line('xin_project_message');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$message = $this->input->post('message');
		//$new_message = mysqli_real_escape_string($message);
		$new_message = $message;
	
		$data = array(
		'name' => $this->input->post('name'),
		'subject' => $this->input->post('subject'),
		'status' => $this->input->post('status'),
		'message' => $new_message
		);
		
		$result = $this->Xin_model->update_email_template_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_email_template_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	/*// get all constants > all types
	public function constants()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_constants').' | '.$this->Xin_model->site_title();
		//$setting = $this->Xin_model->read_setting_info(1);
		$company_info = $this->Xin_model->read_company_setting_info(1);
		$data['breadcrumbs'] = $this->lang->line('left_constants');
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'constants';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('61',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/settings/constants", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }*/
	 	
	// Validate and update info in database
	public function company_info() {
	
		if($this->input->post('type')=='company_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		if($this->input->post('company_name')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('website')==='') {
			$Return['error'] = $this->lang->line('xin_error_website_field');
		} else if($this->input->post('contact_person')==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_person');
		} else if($this->input->post('email')==='') {
			 $Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($this->input->post('phone')==='') {
			$Return['error'] = $this->lang->line('xin_error_phone_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'company_name' => $this->input->post('company_name'),
		'contact_person' => $this->input->post('contact_person'),
		'website_url' => $this->input->post('website'),
		'starting_year' => $this->input->post('starting_year'),
		'company_email' => $this->input->post('company_email'),
		'company_contact' => $this->input->post('company_contact'),
		'email' => $this->input->post('email'),
		'phone' => $this->input->post('phone'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		);
		
		$result = $this->Xin_model->update_company_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_company_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function logo_info() {
	
		if($this->input->post('type')=='logo_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		if($_FILES['p_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_select_first_logo');
		} 
		
		if($Return['error']!=''){
				$this->output($Return);
			}
							
		if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
		//checking image type
		$allowed =  array('png','jpg','jpeg','pdf','gif');
		$filename = $_FILES['p_file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		if(in_array($ext,$allowed)){
			$tmp_name = $_FILES["p_file"]["tmp_name"];
			$profile = "uploads/logo/";
			$set_img = base_url()."uploads/logo/";
			// basename() may prevent filesystem traversal attacks;
			// further validation/sanitation of the filename may be appropriate
			$name = basename($_FILES["p_file"]["name"]);
			$newfilename = 'logo_'.round(microtime(true)).'.'.$ext;
			move_uploaded_file($tmp_name, $profile.$newfilename);
			$fname = $newfilename;			
			
			} else {
				$Return['error'] = $this->lang->line('xin_error_logo_first_attachment');
			}
		}	
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'logo' => $fname,
		);
		$result = $this->Xin_model->update_company_info_record($data,$id);	
		if ($result == TRUE) {
			$Return['img'] = $set_img.$fname;
			$Return['result'] = $this->lang->line('xin_success_system_logo_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;

		}
	}
	
	// Validate and update info in database
	public function logo_favicon() {
	
		if($this->input->post('type')=='logo_favicon') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		if($_FILES['favicon']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_select_favicon');
		}
		if($Return['error']!=''){
				$this->output($Return);
		}
									
		if(is_uploaded_file($_FILES['favicon']['tmp_name'])) {
		//checking image type
		$allowed3 =  array('png','jpg','gif','ico');
		$filename3 = $_FILES['favicon']['name'];
		$ext3 = pathinfo($filename3, PATHINFO_EXTENSION);
		
		if(in_array($ext3,$allowed3)){
			$tmp_name3 = $_FILES["favicon"]["tmp_name"];
			$profile3 = "uploads/logo/favicon/";
			$set_img3 = base_url()."uploads/logo/favicon/";
			// basename() may prevent filesystem traversal attacks;
			// further validation/sanitation of the filename may be appropriate
			$name = basename($_FILES["favicon"]["name"]);
			$newfilename3 = 'favicon_'.round(microtime(true)).'.'.$ext3;
			move_uploaded_file($tmp_name3, $profile3.$newfilename3);
			$fname3 = $newfilename3;			
			
			} else {
				$Return['error'] = $this->lang->line('xin_error_logo_favicon_attachment');
			}
		}

	
		$data = array(
		'favicon' => $fname3
		);
		$result = $this->Xin_model->update_company_info_record($data,$id);	
		if ($result == TRUE) {
			$Return['img3'] = $set_img3.$fname3;
			$Return['result'] = $this->lang->line('xin_success_system_logo_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;

		}
	}
	
	// Validate and update info in database
	public function profile_background() {
	
		if($this->input->post('type')=='profile_background') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
		$id = $this->input->post('user_id');
		
		if($_FILES['p_file']['size'] == 0) {
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$Return['error'] = $this->lang->line('xin_error_select_profile_cover');
		} else {
		if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif');
			$filename = $_FILES['p_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["p_file"]["tmp_name"];
				$profile = "uploads/profile/background/";
				$set_img = base_url()."uploads/profile/background/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["p_file"]["name"]);
				$newfilename = 'profile_background_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;			
				
				$data = array(
				'profile_background' => $fname
				);
				$result = $this->Employees_model->basic_info($data,$id);	
				if ($result == TRUE) {
					$Return['profile_background'] = $set_img.$fname;
					$Return['result'] = $this->lang->line('xin_success_profile_background_updated');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
				exit;	
		
			} else {
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
				
		if($Return['error']!=''){
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
		}
		}
	}
	
	// Validate and update info in database
	public function payroll_config() {
	
		if($this->input->post('type')=='payroll_config') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		$data = array(
		'is_payslip_password_generate' => $this->input->post('payslip_password_generate'),
		'payslip_password_format' => $this->input->post('payslip_password_format'),
		'is_half_monthly' => $this->input->post('is_half_monthly'),
		'half_deduct_month' => $this->input->post('half_deduct_month'),
		'enable_saudi_gosi' => $this->input->post('enable_saudi_gosi')
		);
		$result = $this->Xin_model->update_setting_info_record($data,$id);	
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_payroll_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
				
		if($Return['error']!=''){
		$this->output($Return);
		}
		}
	}
	
	// Validate and update info in database
	public function system_info() {
	
		if($this->input->post('type')=='system_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		if(trim($this->input->post('application_name'))==='') {
       		 $Return['error'] = $this->lang->line('xin_error_application_name_field');
		} else if($this->input->post('default_currency_symbol')==='') {
			$Return['error'] = $this->lang->line('xin_error_default_currency_field');
		} else if($this->input->post('show_currency')==='') {
			$Return['error'] = $this->lang->line('xin_error_default_currency_symbol');
		} else if($this->input->post('currency_position')==='') {
			$Return['error'] = $this->lang->line('xin_error_currency_position');
		} else if($this->input->post('date_format')==='') {
			$Return['error'] = $this->lang->line('xin_error_date_format_field');
		} else if($this->input->post('footer_text')==='') {
			$Return['error'] = $this->lang->line('xin_error_footer_text');
		} else if($this->input->post('employee_login_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_login_id_field');
		} else if($this->input->post('system_timezone')==='') {
			$Return['error'] = $this->lang->line('xin_error_timezone_field');
		} else if($this->input->post('google_maps_api_key')==='') {
			$Return['error'] = $this->lang->line('xin_error_gmap_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
			'application_name' => $this->input->post('application_name'),
			'default_currency_symbol' => $this->input->post('default_currency_symbol'),
			'default_currency' => $this->input->post('default_currency_symbol'),
			'show_currency' => $this->input->post('show_currency'),
			'currency_position' => $this->input->post('currency_position'),
			'date_format_xi' => $this->input->post('date_format'),
			'footer_text' => $this->input->post('footer_text'),
			'enable_page_rendered' => $this->input->post('enable_page_rendered'),
			'enable_current_year' => $this->input->post('enable_current_year'),
			'employee_login_id' => $this->input->post('employee_login_id'),
			'system_timezone' => $this->input->post('system_timezone'),
			'google_maps_api_key' => $this->input->post('google_maps_api_key'),
			'is_ssl_available' => $this->input->post('is_ssl_available'),
			'default_language' => $this->input->post('default_language'),
			'statutory_fixed' => $this->input->post('statutory_fixed'),
			'invoice_terms_condition' => $this->input->post('invoice_terms_condition'),
			'estimate_terms_condition' => $this->input->post('estimate_terms_condition'),
			'show_projects' => $this->input->post('show_projects'),
			'show_tasks' => $this->input->post('show_tasks'),
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_system_configuration_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function modules_info() {
	
		if($this->input->get('type')=='modules_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
	
		$data = array(
		'module_recruitment' => $this->input->get('mrecruitment'),
		'module_travel' => $this->input->get('mtravel'),
		'module_files' => $this->input->get('mfiles'),
		'module_language' => $this->input->get('mlanguage'),
		'module_orgchart' => $this->input->get('morgchart'),
		'module_events' => $this->input->get('mevents'),
		'module_chat_box' => $this->input->get('chatbox'),
		'is_active_sub_departments' => $this->input->get('is_sub_departments'),
		'module_payroll' => $this->input->get('module_payroll'),
		'module_performance' => $this->input->get('module_performance'),
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_system_modules_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function layout_skin_info() {
	
		if($this->input->get('type')=='hrsale_layout_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->input->get('user_session_id');
			
		$data = array(
		'fixed_header' => $this->input->get('fixed_layout_hrsale'),
		'boxed_wrapper' => $this->input->get('boxed_layout_hrsale'),
		'compact_sidebar' => $this->input->get('sidebar_layout_hrsale')
		);
		
		$result = $this->Employees_model->basic_info($data,$id);	
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_system_layout_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function role_info() {
	
		if($this->input->post('type')=='role_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
			
		$data = array(
		'employee_manage_own_contact' => $this->input->post('employee_manage_own_contact'),
		'employee_manage_own_social' => $this->input->post('employee_manage_own_social'),
		'employee_manage_own_bank_account' => $this->input->post('employee_manage_own_bank_account'),
		'employee_manage_own_qualification' => $this->input->post('employee_manage_own_qualification'),
		'employee_manage_own_work_experience' => $this->input->post('employee_manage_own_work_experience'),
		'employee_manage_own_document' => $this->input->post('employee_manage_own_document'),
		'employee_manage_own_picture' => $this->input->post('employee_manage_own_picture'),
		'employee_manage_own_profile' => $this->input->post('employee_manage_own_profile'),
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_role_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function sidebar_setting_info() {
	
		if($this->input->post('type')=='other_settings') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
			
		$data = array(
		'enable_attendance' => $this->input->post('enable_attendance'),
		'enable_job_application_candidates' => $this->input->post('enable_job'),
		'enable_profile_background' => $this->input->post('enable_profile_background'),
		'enable_email_notification' => $this->input->post('role_email_notification'),
		'notification_close_btn' => $this->input->post('close_btn'),
		'notification_bar' => $this->input->post('notification_bar'),
		'enable_policy_link' => $this->input->post('role_policy_link'),
		'enable_layout' => $this->input->post('enable_layout'),
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_setting_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function attendance_info() {
	
		if($this->input->post('type')=='attendance_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
			
		$data = array(
		'enable_attendance' => $this->input->post('enable_attendance'),
		'enable_clock_in_btn' => $this->input->post('enable_clock_in_btn')
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_attendance_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function email_info() {
	
		if($this->input->post('type')=='email_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
			
		$data = array(
		'enable_email_notification' => $this->input->post('enable_email_notification')
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);
		$cdata = array(
		'email_type' => $this->input->post('email_type'),
		'smtp_host' => $this->input->post('smtp_host'),
		'smtp_username' => $this->input->post('smtp_username'),
		'smtp_password' => $this->input->post('smtp_password'),
		'smtp_port' => $this->input->post('smtp_port'),
		'smtp_secure' => $this->input->post('smtp_secure')
		);
		$this->Xin_model->update_email_config_record($cdata,1);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_email_notify_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function job_info() {
	
		if($this->input->post('type')=='job_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('job_application_format')==='') {
        	$Return['error'] = $this->lang->line('xin_error_job_app_format');
		}
		
		if($Return['error']!=''){
			$hrm_f->output($Return);
		}
		$job_format = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('job_application_format'));
		$id = 1;
			
		$data = array(
		'enable_job_application_candidates' => $this->input->post('enable_job'),
		'job_application_format' => $job_format
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function animation_effect_info() {
	
		if($this->input->post('type')=='animation_effect_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
			
		$data = array(
		'animation_effect' => $this->input->post('animation_effect'),
		'animation_effect_topmenu' => $this->input->post('animation_effect_topmenu'),
		'animation_effect_modal' => $this->input->post('animation_effect_modal')
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_animation_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function notification_position_info() {
	
		if($this->input->post('type')=='notification_position_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('notification_position')==='') {
        	$Return['error'] = $this->lang->line('xin_error_notify_position');
		}
		
		if($Return['error']!=''){
			$hrm_f->output($Return);
		}
		$id = 1;
			
		$data = array(
		'notification_position' => $this->input->post('notification_position'),
		'notification_close_btn' => $this->input->post('notification_close_btn'),
		'notification_bar' => $this->input->post('notification_bar')
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_notify_position_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete_single_backup() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Xin_model->delete_single_backup_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_database_backup_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
	
	/*  ALL CONSTANTS */
	
	// Contract Type > list
	  public function contract_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$contract_type = $this->Xin_model->get_contract_types();

		$data = array();

        foreach($contract_type->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->contract_type_id . '" data-field_type="contract_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->contract_type_id . '" data-token_type="contract_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $contract_type->num_rows(),
			 "recordsFiltered" => $contract_type->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     } 
	 
	 // Education Level > list
	  public function education_level_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_qualification_education();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->education_level_id . '" data-field_type="education_level"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->education_level_id . '" data-token_type="education_level"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Language > list
	  public function qualification_language_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_qualification_language();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->language_id . '" data-field_type="qualification_language"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->language_id . '"  data-token_type="qualification_language"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Skill > list
	  public function qualification_skill_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_qualification_skill();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->skill_id . '" data-field_type="qualification_skill"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->skill_id . '" data-token_type="qualification_skill"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Document Type > list
	  public function document_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_document_type();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->document_type_id . '" data-field_type="document_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_type_id . '" data-token_type="document_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->document_type,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Award Type > list
	  public function award_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_award_type();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->award_type_id . '" data-field_type="award_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->award_type_id . '" data-token_type="award_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->award_type,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Leave Type > list
	  public function leave_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_leave_type();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->leave_type_id . '" data-field_type="leave_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->leave_type_id . '" data-token_type="leave_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type_name,
			$r->days_per_year
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Warning Type > list
	  public function warning_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_warning_type();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->warning_type_id . '" data-field_type="warning_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->warning_type_id . '" data-token_type="warning_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Ethnicity Type > list
	  public function ethnicity_type_list(){

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_ethnicity_type();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->ethnicity_type_id . '" data-field_type="ethnicity_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->ethnicity_type_id . '" data-token_type="ethnicity_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Income Type > list
	  public function income_type_list(){

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_income_categories();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->category_id . '" data-field_type="income_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->category_id . '" data-token_type="income_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Termination Type > list
	  public function termination_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_termination_type();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->termination_type_id . '" data-field_type="termination_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->termination_type_id . '" data-token_type="termination_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Expense Type > list
	  public function expense_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_expense_type();

		$data = array();

        foreach($constant->result() as $r) {
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
			  $comp_name = '--';	
			}
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->expense_type_id . '" data-field_type="expense_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->expense_type_id . '" data-token_type="expense_type"><span class="fas fa-trash-restore"></span></button></span>',
			$comp_name,
			$r->name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Job Type > list
	  public function job_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_job_type();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->job_type_id . '" data-field_type="job_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->job_type_id . '" data-token_type="job_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Job Categories > list
	  public function job_category_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_job_categories();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->category_id . '" data-field_type="job_category"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->category_id . '" data-token_type="job_category"><span class="fas fa-trash-restore"></span></button></span>',
			$r->category_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Exit Type > list
	  public function exit_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_exit_type();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->exit_type_id . '" data-field_type="exit_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->exit_type_id . '" data-token_type="exit_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Travel Arrangement Type > list
	  public function travel_arr_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_travel_type();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->arrangement_type_id . '" data-field_type="travel_arr_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->arrangement_type_id . '" data-token_type="travel_arr_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Payment Method > list
	  public function payment_method_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_payment_method();

		$data = array();

        foreach($constant->result() as $r) {
												 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->payment_method_id . '" data-field_type="payment_method"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->payment_method_id . '" data-token_type="payment_method"><span class="fas fa-trash-restore"></span></button></span>',
			$r->method_name,
			$r->payment_percentage.'%',
			$r->account_number
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Currency type > list
	  public function currency_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_currency_types();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->currency_id . '" data-field_type="currency_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->currency_id . '" data-token_type="currency_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
			$r->code,
			$r->symbol
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 // Company type > list
	  public function company_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/settings/settings", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$constant = $this->Xin_model->get_company_type();

		$data = array();

        foreach($constant->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_id . '" data-field_type="company_type"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_id . '" data-token_type="company_type"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $constant->num_rows(),
			 "recordsFiltered" => $constant->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     }
	 
	 /*  Add constant data */
	 
	// Validate and add info in database
	public function contract_type_info() {
	
		if($this->input->post('type')=='contract_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('contract_type')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_contract_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('contract_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Xin_model->add_contract_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_contract_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function document_type_info() {
	
		if($this->input->post('type')=='document_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('document_type')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_d_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'document_type' => $this->input->post('document_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Xin_model->add_document_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_document_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function edu_level_info() {
	
		if($this->input->post('type')=='edu_level_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_education_level');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_edu_level($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_education_level_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function edu_language_info() {
	
		if($this->input->post('type')=='edu_language_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_education_language');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_edu_language($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_education_language_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function edu_skill_info() {
	
		if($this->input->post('type')=='edu_skill_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_education_skill');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_edu_skill($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_education_skill_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function payment_method_info() {
	
		if($this->input->post('type')=='payment_method_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('payment_method')==='') {
        	$Return['error'] = $this->lang->line('xin_error_payment_method');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'method_name' => $this->input->post('payment_method'),
		'payment_percentage' => $this->input->post('payment_percentage'),
		'account_number' => $this->input->post('account_number'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_payment_method($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_payment_method_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function award_type_info() {
	
		if($this->input->post('type')=='award_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('award_type')==='') {
        	$Return['error'] = $this->lang->line('xin_award_error_award_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'award_type' => $this->input->post('award_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_award_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_award_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function leave_type_info() {
	
		if($this->input->post('type')=='leave_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('leave_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_leave_type_field');
		} else if($this->input->post('days_per_year')==='') {
        	$Return['error'] = $this->lang->line('xin_error_days_per_year');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type_name' => $this->input->post('leave_type'),
		'days_per_year' => $this->input->post('days_per_year'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_leave_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_leave_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function warning_type_info() {
	
		if($this->input->post('type')=='warning_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('warning_type')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_warning_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type' => $this->input->post('warning_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_warning_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_warning_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function termination_type_info() {
	
		if($this->input->post('type')=='termination_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('termination_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_termination_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type' => $this->input->post('termination_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_termination_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_termination_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function expense_type_info() {
	
		if($this->input->post('type')=='expense_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('expense_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_expense_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('expense_type'),
		'company_id' => $this->input->post('company'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_expense_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_expense_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function job_type_info() {
	
		if($this->input->post('type')=='job_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('job_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$jurl = random_string('alnum', 40);
		$data = array(
		'type' => $this->input->post('job_type'),
		'type_url' => $jurl,
		'company_id' => 1,
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_job_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database
	public function job_category_info() {
	
		if($this->input->post('type')=='job_category_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('job_category')==='') {
        	$Return['error'] = $this->lang->line('xin_error_job_category');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$jurl = random_string('alnum', 40);
		$data = array(
		'category_name' => $this->input->post('job_category'),
		'category_url' => $jurl,
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_job_category($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_category_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function exit_type_info() {
	
		if($this->input->post('type')=='exit_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('exit_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_exit_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type' => $this->input->post('exit_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_exit_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_error_education_level');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function travel_arr_type_info() {
	
		if($this->input->post('type')=='travel_arr_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('travel_arr_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_travel_arrangment_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type' => $this->input->post('travel_arr_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_travel_arr_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_travel_arrangment_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function company_type_info() {
	
		if($this->input->post('type')=='company_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_ctype_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('company_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_company_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_company_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function ethnicity_type_info() {
	
		if($this->input->post('type')=='ethnicity_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('ethnicity_type')==='') {
        	$Return['error'] = $this->lang->line('xin_ethnicity_type_error_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type' => $this->input->post('ethnicity_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_ethnicity_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_ethnicity_type_success_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database
	public function security_level_info() {
	
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
		'name' => $this->input->post('security_level'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_security_level($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_security_level_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database
	public function income_type_info() {
	
		if($this->input->post('type')=='income_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('income_type')==='') {
        	$Return['error'] = $this->lang->line('xin_income_type_error_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('income_type'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Xin_model->add_income_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_income_type_success_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function currency_type_info() {
	
		if($this->input->post('type')=='currency_type_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_currency_name_field');
		} else if($this->input->post('code')==='') {
        	$Return['error'] = $this->lang->line('xin_error_currency_code_field');
		} else if($this->input->post('symbol')==='') {
        	$Return['error'] = $this->lang->line('xin_error_currency_symbol_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'code' => $this->input->post('code'),
		'symbol' => $this->input->post('symbol')
		);
		
		$result = $this->Xin_model->add_currency_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_currency_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	/*  DELETE CONSTANTS */
	// delete constant record > table
	public function delete_contract_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_contract_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_contract_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_document_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_document_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_document_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_payment_method() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_payment_method_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_payment_method_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_education_level() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_education_level_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_education_level_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_qualification_language() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_qualification_language_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_qualification_lang_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_qualification_skill() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_qualification_skill_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_qualification_skill_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_award_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_award_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_award_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_leave_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_leave_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_leave_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_warning_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_warning_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_warning_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_termination_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_termination_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_termination_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_expense_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_expense_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_expense_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_job_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_job_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_job_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_job_category() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_job_category_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_job_category_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_exit_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_exit_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_exit_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_travel_arr_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_travel_arr_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_travel_arrtype_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_ethnicity_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_ethnicity_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_ethnicity_type_success_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_income_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_income_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_income_type_success_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_currency_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_currency_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_currency_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete constant record > table
	public function delete_company_type() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_company_type_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_company_type_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete constant record > table
	public function delete_security_level() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Xin_model->delete_security_level_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_security_level_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// read and view all constants data > modal form
	public function constants_read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/settings/dialog_constants', $data);
		} else {
			redirect('admin/');
		}
	}
	
	/*  UPDATE RECORD > CONSTANTS*/
	
	// Validate and update info in database
	public function update_document_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_d_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'document_type' => $this->input->post('name'),
		'company_id' => $this->input->post('company')
		);
		
		$result = $this->Xin_model->update_document_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_document_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_ethnicity_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('ethnicity_type')==='') {
        	$Return['error'] = $this->lang->line('xin_ethnicity_type_error_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type' => $this->input->post('ethnicity_type'),
		);
		
		$result = $this->Xin_model->update_ethnicity_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_ethnicity_type_success_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_income_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('income_type')==='') {
        	$Return['error'] = $this->lang->line('xin_income_type_error_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('income_type'),
		);
		
		$result = $this->Xin_model->update_income_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_income_type_success_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_contract_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] =$this->lang->line('xin_employee_error_contract_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'name' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_contract_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_contract_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_payment_method() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_payment_method');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'method_name' => $this->input->post('name'),
		'payment_percentage' => $this->input->post('payment_percentage'),
		'account_number' => $this->input->post('account_number')
		);
		
		$result = $this->Xin_model->update_payment_method_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_payment_method_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_education_level() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_education_level');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'name' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_education_level_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_education_level_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_qualification_language() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_education_language');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'name' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_qualification_language_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_error_education_level');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_qualification_skill() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_education_skill');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'name' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_qualification_skill_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_qualification_skill_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_award_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_award_error_award_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'award_type' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_award_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_award_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_leave_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_leave_type_field');
		} else if($this->input->post('days_per_year')==='') {
        	$Return['error'] = $this->lang->line('xin_error_days_per_year');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'type_name' => $this->input->post('name'),
		'days_per_year' => $this->input->post('days_per_year')
		);
		
		$result = $this->Xin_model->update_leave_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_leave_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_warning_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_employee_error_warning_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'type' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_warning_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_warning_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_termination_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_termination_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'type' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_termination_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_termination_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_expense_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_expense_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'company_id' => $this->input->post('company'),
		'name' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_expense_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_expense_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_job_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'type' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_job_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_job_category() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('job_category')==='') {
        	$Return['error'] = $this->lang->line('xin_error_job_category');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'category_name' => $this->input->post('job_category')
		);
		
		$result = $this->Xin_model->update_job_category_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_category_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_exit_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_exit_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'type' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_exit_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_exit_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_travel_arr_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_travel_arrangment_type');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'type' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_travel_arr_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_travel_arrtype_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_company_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_ctype_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name')
		);
		
		$result = $this->Xin_model->update_company_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_company_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_currency_type() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_currency_name_field');
		} else if($this->input->post('code')==='') {
        	$Return['error'] = $this->lang->line('xin_error_currency_code_field');
		} else if($this->input->post('symbol')==='') {
        	$Return['error'] = $this->lang->line('xin_error_currency_symbol_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		
		'name' => $this->input->post('name'),
		'code' => $this->input->post('code'),
		'symbol' => $this->input->post('symbol')
		);
		
		$result = $this->Xin_model->update_currency_type_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_currency_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database
	public function update_payment_gateway() {
	
		if($this->input->post('type')=='payment_gateway') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
	
		$data = array(
		'paypal_email' => $this->input->post('paypal_email'),
		'paypal_sandbox' => $this->input->post('paypal_sandbox'),
		'paypal_active' => $this->input->post('paypal_active'),
		'stripe_secret_key' => $this->input->post('stripe_secret_key'),
		'stripe_publishable_key' => $this->input->post('stripe_publishable_key'),
		'stripe_active' => $this->input->post('stripe_active'),
		'online_payment_account' => $this->input->post('bank_cash_id'),
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_payment_gateway_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}	
	// Validate and update info in database
	public function update_security_level() {
	
		if($this->input->post('type')=='edit_record') {
			
		$id = $this->uri->segment(4);
		
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
		'name' => $this->input->post('security_level')
		);
		
		$result = $this->Xin_model->update_security_level_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_security_level_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database
	public function performance_info() {
	
		if($this->input->post('type')=='performance_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('technical_competencies')==='') {
        	$Return['error'] = $this->lang->line('xin_performance_technical_error_field');
		} else if($this->input->post('organizational_competencies')==='') {
        	$Return['error'] = $this->lang->line('xin_performance_org_error_field');
		}
		
		if($Return['error']!=''){
			$hrm_f->output($Return);
		}
		$technical_competencies = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('technical_competencies'));
		$organizational_competencies = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('organizational_competencies'));
		$id = 1;
			
		$data = array(
		'technical_competencies' => $technical_competencies,
		'organizational_competencies' => $organizational_competencies,
		'performance_option' => $this->input->post('performance_option')
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_performance_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
}
