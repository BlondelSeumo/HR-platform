<?php
	
class Xin_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	// get single location
	 public function read_location_info($id) {
	
		$sql = 'SELECT * FROM xin_office_location WHERE location_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
		
	// is logged in to system
	public function is_logged_in($id)
	{
		$CI =& get_instance();
		$is_logged_in = $CI->session->userdata($id);
		return $is_logged_in;       
	}
	
	// generate random string
	public function generate_random_string($length = 7) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	// generate employee id
	public function generate_random_employeeid($length = 6) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	// generate employee pincode
	public function generate_random_pincode($length = 6) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function get_countries()
	{
	  $query = $this->db->query("SELECT * from xin_countries");
  	  return $query->result();
	}
	
	public function clean_post($post_name) {
	   $name = trim($post_name);
	   $Evalue = array('-','alert','<script>','</script>','</php>','<php>','<p>','\r\n','\n','\r','=',"'",'/','cmd','!',"('","')", '|');
	   $post_name = str_replace($Evalue, '', $name); 
	   $post_name = preg_replace('/^(\d{1,2}[^0-9])/m', '', $post_name);
	  // $post_name = htmlspecialchars(trim($post_name), ENT_QUOTES, "UTF-8");
	   
	   return $post_name;
	}
	
	public function clean_date_post($post_name) {
	   $name = trim($post_name);
	   $Evalue = array('alert','<script>','</script>','</php>','<php>','<p>','\r\n','\n','\r','=',"'",'/','cmd','!',"('","')", '|');
	   $post_name = str_replace($Evalue, '', $name); 
	   $post_name = preg_replace('/^(\d{1,2}[^0-9])/m', '', $post_name);
	   $post_name = htmlspecialchars(trim($post_name), ENT_QUOTES, "UTF-8");
	   return $post_name;
	}
	// class button
	public function form_button_class() {
		return 'btn btn-primary';
	}
	public function validate_date($dateStr, $format)
	{
		date_default_timezone_set('UTC');
		$date = DateTime::createFromFormat($format, $dateStr);
		return $date && ($date->format($format) === $dateStr);
	}
	private function validate_numbers_only($value) {
		return preg_match('/^([0-9]*)$/', $value);
	}
	// get selected module
	public function select_module_class($mClass,$mMethod) {
		$arr = array();
		// dashboard
		if($mClass=='dashboard') {
			$arr['active'] = 'active';
			$arr['open'] = '';
			return $arr;
		} else if($mClass=='department' && $mMethod=='sub_departments') {
			$arr['sub_departments_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='department') {
			$arr['dep_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='designation') {
			$arr['des_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='company' && $mMethod=='official_documents') {
			$arr['official_documents_active'] = 'active';
			$arr['files_open'] = 'open';
			return $arr;
		} else if($mClass=='company') {
			$arr['com_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='location') {
			$arr['loc_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='policy') {
			$arr['pol_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='expense') {
			$arr['exp_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='announcement') {
			$arr['ann_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='employees' && $mMethod=='staff_dashboard') {
			$arr['staff_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mClass=='employees' && $mMethod=='hr') {
			$arr['hremp_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mClass=='employees' && $mMethod=='expired_documents') {
			$arr['expired_documents_active'] = 'active';
			$arr['files_open'] = 'open';
			return $arr;
		} else if($mClass=='employees' && $mMethod=='import') {
			$arr['importemp_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mClass=='employees') {
			$arr['hremp_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} /*else if($mClass=='custom_fields') {
			$arr['custom_fields_active'] = 'active';
			$arr['stff_open'] = 'active';
			return $arr;
		}*/ else if($mClass=='awards') {
			$arr['awar_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='transfers') {
			$arr['tra_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='resignation') {
			$arr['res_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='travel') {
			$arr['trav_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='promotion') {
			$arr['pro_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='complaints') {
			$arr['compl_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='warning') {
			$arr['warn_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='termination') {
			$arr['term_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='employees_last_login') {
			$arr['emp_ll_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mClass=='employee_exit') {
			$arr['emp_ex_active'] = 'active';
			$arr['emp_open'] = 'open';
			return $arr;
		} else if($mMethod=='category' && $mClass=='assets') {
			$arr['asst_cat_active'] = 'active';
			$arr['asst_open'] = 'open';
			return $arr;
		} else if($mClass=='assets') {
			$arr['asst_active'] = 'active';
			$arr['asst_open'] = 'open';
			return $arr;
		} else if($mClass=='chat') {
			$arr['chat_active'] = 'active';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='attendance') {
			$arr['attnd_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='timecalendar') {
			$arr['timecalendar_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='date_wise_attendance') {
			$arr['attnd_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='update_attendance') {
			$arr['upd_attnd_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='overtime_request') {
			$arr['overtime_request_act'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='attendance_dashboard') {
			$arr['attendance_dashboard_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='import') {
			$arr['import_attnd_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='office_shift' && $mClass=='timesheet') {
			$arr['shift_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mMethod=='holidays' && $mClass=='timesheet') {
			$arr['hol_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='leave' && $mClass=='timesheet') {
			$arr['leave_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='leave_details' && $mClass=='timesheet') {
			$arr['leave_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='index') {
			$arr['timesheet_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='calendar' && $mMethod=='attendance') {
			$arr['attnd_cal_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='hourly_wages') {
			$arr['pay_hourly_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='templates') {
			$arr['pay_temp_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='manage_salary') {
			$arr['pay_mang_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mClass=='payroll' && $mMethod=='payslip') {
			$arr['pay_generate_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='generate_payslip') {
			$arr['pay_generate_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='payment_history') {
			$arr['pay_generate_active'] = 'active';
			//$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mMethod=='currency_converter') {
			$arr['curren_conv_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='advance_salary') {
			$arr['pay_advn_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='advance_salary_report') {
			$arr['pay_advn_rpt_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_indicator') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_report') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_maingoals') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_appraisal') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='organization' && $mMethod=='chart') {
			$arr['org_chart_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='calendar' && $mMethod=='hr') {
			$arr['calendar_hr_active'] = 'active';
			return $arr;
		} else if($mClass=='tickets') {
			$arr['ticket_active'] = 'active';
			return $arr;
		} else if($mMethod=='calendar' && $mClass=='leave') {
			$arr['leave_cal_active'] = 'active';
			$arr['leave_open'] = 'open';
			return $arr;
		} else if($mClass=='project' && $mMethod=='projects_dashboard') {
			$arr['projects_dashboard_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='projects_scrum_board' && $mClass=='project') {
			$arr['projects_scrum_board_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='tasks_scrum_board' && $mClass=='project') {
			$arr['tasks_scrum_board_active'] = 'active';
			$arr['task_open'] = 'open';
			return $arr;
		} else if($mMethod=='tasks_calendar' && $mClass=='project') {
			$arr['tasks_calendar_active'] = 'active';
			$arr['task_open'] = 'open';
			return $arr;
		} else if($mMethod=='projects_calendar' && $mClass=='project') {
			$arr['projects_calendar_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='timelogs' && $mClass=='project') {
			$arr['project_timelogs_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='timelogs' && $mClass=='quoted_projects') {
			$arr['timelogs_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='quote_calendar' && $mClass=='quoted_projects') {
			$arr['quote_calendar_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='task_categories' && $mClass=='project') {
			$arr['task_cat_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		}  else if($mClass=='project') {
			$arr['project_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mClass=='projects') {
			$arr['projects_active'] = 'active';
			$arr['projects_active'] = 'open';
			return $arr;
		} else if($mMethod=='tasks' && $mClass=='timesheet') {
			$arr['task_active'] = 'active';
			$arr['task_open'] = 'open';
			return $arr;
		} else if($mMethod=='task_details') {
			$arr['task_active'] = 'active';
			$arr['task_open'] = 'open';
			return $arr;
		} else if($mClass=='clients') {
			$arr['clients_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='import' && $mClass=='leads') {
			$arr['hr_import_leads_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mClass=='leads') {
			$arr['leadsl_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='create' && $mClass=='invoices') {
			$arr['hr_create_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mMethod=='create' && $mClass=='quotes') {
			$arr['all_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='taxes' && $mClass=='invoices') {
			$arr['taxes_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mMethod=='payments_history' && $mClass=='invoices') {
			$arr['payments_history_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mClass=='quoted_projects') {
			$arr['quoted_projects_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='invoice_calendar' && $mClass=='invoices') {
			$arr['invoice_calendar_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mClass=='invoices') {
			$arr['invoices_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mClass=='quotes') {
			$arr['all_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mClass=='files') {
			$arr['file_active'] = 'active';
			$arr['files_open'] = 'open';
			return $arr;
		} else if($mClass=='import') {
			$arr['import_active'] = 'active';
			return $arr;
		}  else if($mClass=='job_post' && $mMethod=='pages') {
			$arr['jb_pages_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='job_post' && $mMethod=='employer') {
			$arr['jb_employer_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='job_post') {
			$arr['jb_post_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='job_candidates') {
			$arr['job_candidates_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='job_interviews') {
			$arr['jb_post_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='training') {
			$arr['training_active'] = 'active';
			$arr['training_open'] = 'open';
			return $arr;
		} else if($mClass=='training_type') {
			$arr['tr_type_active'] = 'active';
			$arr['training_open'] = 'open';
			return $arr;
		} else if($mClass=='trainers') {
			$arr['trainers_active'] = 'active';
			$arr['training_open'] = 'open';
			return $arr;
		} else if($mClass=='users') {
			$arr['users_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='roles') {
			$arr['roles_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mMethod=='constants' && $mClass=='settings') {
			$arr['constants_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='database_backup' && $mClass=='settings') {
			$arr['db_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='email_template' && $mClass=='settings') {
			$arr['email_template_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='modules' && $mClass=='settings') {
			$arr['modules_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='theme') {
			$arr['theme_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='settings') {
			$arr['settings_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='changelog') {
			$arr['changelog_active'] = 'active';
			return $arr;
		} else if($mClass=='languages') {
			$arr['languages_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='events' && $mMethod=='calendar') {
			$arr['hr_ecalendar_active'] = 'active';
			$arr['hr_events_open'] = 'open';
			return $arr;
		} else if($mClass=='meetings') {
			$arr['hr_meetings_active'] = 'active';
			$arr['hr_events_open'] = 'open';
			return $arr;
		} else if($mClass=='events') {
			$arr['hr_events_active'] = 'active';
			$arr['hr_events_open'] = 'open';
			return $arr;
		} else if($mClass=='goal_tracking' && $mMethod=='calendar') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='goal_tracking' && $mMethod=='type') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='goal_tracking') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='employee_leave') {
			$arr['leave_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='payslip') {
			$arr['reports_active'] = 'active';
			$arr['reports_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='employee_attendance') {
			$arr['reports_active'] = 'active';
			$arr['reports_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='employee_training') {
			$arr['reports_active'] = 'active';
			$arr['reports_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='projects') {
			$arr['reports_active'] = 'active';
			$arr['reports_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='tasks') {
			$arr['reports_active'] = 'active';
			$arr['reports_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='roles') {
			$arr['reports_active'] = 'active';
			$arr['reports_open'] = 'open';
			return $arr;
		} else if($mClass=='reports'  && $mMethod=='employees') {
			$arr['reports_active'] = 'active';
			$arr['reports_open'] = 'open';
			return $arr;
		} else if($mClass=='reports') {
			$arr['reports_active'] = 'active';
			return $arr;
		} else if($mClass=='user' && $mMethod=='awards') {
			$arr['hr_awards_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='transfer') {
			$arr['hr_transfer_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='promotion') {
			$arr['hr_promotion_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='complaints') {
			$arr['hr_complaints_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='warning') {
			$arr['hr_warning_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='travel') {
			$arr['hr_travel_active'] = 'active';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='accounting_dashboard') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='bank_cash') {
			$arr['bank_cash_act'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='account_balances') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='transfer') {
			$arr['transfer_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='deposit') {
			$arr['deposit_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='expense') {
			$arr['expense_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='transactions') {
			$arr['transactions_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='bankwise_transactions') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='accounts_ledger') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='payees') {
			$arr['hr_payees_active'] = 'active';
			//$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='payers') {
			$arr['hr_payers_active'] = 'active';
			//$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='account_statement') {
			$arr['reports_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_report_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='expense_report') {
			$arr['reports_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_report_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='income_report') {
			$arr['reports_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_report_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='transfer_report') {
			$arr['reports_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_report_open'] = 'open';
			return $arr;
		} else if($mClass=='profile' && isset($_GET['change_password'])=='true') {
			$arr['hr_password_active'] = 'active';
			return $arr;
		} else if($mClass=='invoices' && $mClass=='payments_history') {
			$arr['hr_all_inv_active'] = 'active';
			return $arr;
		} else if($mClass=='invoices') {
			$arr['hr_client_invoices_active'] = 'active';
			return $arr;
		}
	}

	 // get single country
	 public function read_country_info($id) {
	
		$sql = 'SELECT * FROM xin_countries WHERE country_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to update record in table
	public function login_update_record($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get single employee
	public function read_user_info($id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}
	// get single user
	public function read_user_xuinfo($id) {
	
		$sql = 'SELECT * FROM xin_users WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}
	
	// get single user
	public function read_user_attendance_info() {
		
		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array('000');
		$query = $this->db->query($sql, $binds);
		
		return $query;	
	}
	
	// get single user
	public function read_user_by_employee_id($id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}
	
	// get single user > by email
	public function read_user_info_byemail($email) {
	
		$sql = 'SELECT * FROM xin_employees WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	// get single user > by email >>> jobs listing module
	public function read_user_jobs_byemail($email) {
	
		$sql = 'SELECT * FROM xin_users WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get single employee
	public function read_employee_info($id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}	
	// get single employee > by email
	public function read_employee_info_byemail($email) {
	
		$sql = 'SELECT * FROM xin_employees WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	
	// get last user attendance > check if loged in-
	public function attendance_time_checks($id) {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ?, clock_out = ? order by time_attendance_id desc limit 1';
		$binds = array($id, '');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get single user > by designation
	public function read_user_info_bydesignation($email) {
	
		$sql = 'SELECT * FROM xin_employees WHERE designation_id = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	// get theme info
	public function read_theme_info($id) {
	
		$sql = 'SELECT * FROM xin_theme_settings WHERE theme_settings_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get single company
	public function read_company_info($id) {
	
		$sql = 'SELECT * FROM xin_companies WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_employee_officeshift($id) {
	 	
		$sql = 'SELECT * FROM xin_employee_shift WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_employee_row($id) {
	 	
		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_employee_shift_office($id) {
	 	
		$sql = 'SELECT * FROM xin_office_shift WHERE office_shift_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return null;
		}
	}
	
	// get single user role info
	public function read_user_role_info($id) {
	
		$sql = 'SELECT * FROM xin_user_roles WHERE role_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get setting info
	public function read_setting_info($id) {
	
		$sql = 'SELECT * FROM xin_system_setting WHERE setting_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get setting info
	public function read_currency_con_info($id) {
	
		$sql = 'SELECT * FROM xin_currency_converter WHERE currency_converter_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get file setting info
	public function read_file_setting_info($id) {
	
		$sql = 'SELECT * FROM xin_file_manager_settings WHERE setting_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get setting layout
	public function system_layout() {
	
		// get details of layout
		$system = $this->read_setting_info(1);
		
		if($system[0]->compact_sidebar!=''){
			// if compact sidebar
			$compact_sidebar = 'compact-sidebar';
		} else {
			$compact_sidebar = '';
		}
		if($system[0]->fixed_header!=''){
			// if fixed header
			$fixed_header = 'fixed-header';
		} else {
			$fixed_header = '';
		}
		if($system[0]->fixed_sidebar!=''){
			// if fixed sidebar
			$fixed_sidebar = 'fixed-sidebar';
		} else {
			$fixed_sidebar = '';
		}
		if($system[0]->boxed_wrapper!=''){
			// if boxed wrapper
			$boxed_wrapper = 'boxed-wrapper';
		} else {
			$boxed_wrapper = '';
		}
		if($system[0]->layout_static!=''){
			// if static layout
			$static = 'static';
		} else {
			$static = '';
		}
		return $layout = $compact_sidebar.' '.$fixed_header.' '.$fixed_sidebar.' '.$boxed_wrapper.' '.$static;
	}
	
	// get company setting info
	public function read_company_setting_info($id) {
	
		$sql = 'SELECT * FROM xin_company_info WHERE company_info_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get title
	public function site_title() {
		$system = $this->read_setting_info(1);
		return $system[0]->application_name;
	}
	
	// get all companies
	public function get_companies()
	{
	  $query = $this->db->query("SELECT * from xin_companies");
  	  return $query->result();
	}
	
	// get all leave applications
	public function get_leave_applications()
	{
	  $query = $this->db->query("SELECT * from xin_leave_applications");
  	  return $query->result();
	}
	
	// 1
	public function get_notify_leave_applications() {
	  $query = $this->db->query("SELECT * from xin_leave_applications where is_notify = '1' order by leave_id desc");
  	  return $query->result();
	}
 	public function get_last_user_leave_applications($user_id) {
	  $query = $this->db->query("SELECT * from xin_leave_applications where employee_id = '".$user_id."' and is_notify = '1' order by leave_id desc");
  	  return $query->result();
	}
	//2
	public function get_notify_projects() {
	  $query = $this->db->query("SELECT * from xin_projects where is_notify = '1' order by project_id desc");
  	  return $query->result();
	}
	public function get_notify_company_projects($company_id) {
		$query = $this->db->query("SELECT * from xin_projects where company_id = '".$company_id."' and is_notify = '1' order by project_id desc");
		return $query->result();
	}
	public function get_notify_user_projects($id) {
	  $query = $this->db->query("SELECT * from xin_projects where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id' order by project_id desc");
  	  return $query->result();
	}
	//3
	public function get_notify_tasks() {
	  $query = $this->db->query("SELECT * from xin_tasks where is_notify = '1' order by task_id desc");
  	  return $query->result();
	}
	public function get_notify_company_tasks($company_id) {
	  $query = $this->db->query("SELECT * from xin_tasks where is_notify = '1' and company_id = '".$company_id."' order by task_id desc");
  	  return $query->result();
	}
	public function get_notify_user_tasks($id) {
	  $query = $this->db->query("SELECT * from xin_tasks where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id' order by task_id desc");
  	  return $query->result();
	}
	//4
	public function get_notify_announcements() {
	  $query = $this->db->query("SELECT * from xin_announcements where is_notify = '1' order by announcement_id desc");
  	  return $query->result();
	}
	public function get_notify_company_announcements($company_id) {
	  $query = $this->db->query("SELECT * from xin_announcements where is_notify = '1' and company_id = '".$company_id."' order by announcement_id desc");
  	  return $query->result();
	}
	public function get_notify_dept_announcements($department_id) {
	  $query = $this->db->query("SELECT * from xin_announcements where is_notify = '1' and department_id = '$department_id' order by announcement_id desc");
  	  return $query->result();
	}
	//5
	public function get_notify_tickets() {
	  $query = $this->db->query("SELECT * from xin_support_tickets_employees where is_notify = '1' order by ticket_id desc");
  	  return $query->result();
	}
	public function get_notify_company_tickets($company_id) {
	  $query = $this->db->query("SELECT * from xin_support_tickets_employees where is_notify = '1' and company_id = '".$company_id."' order by ticket_id desc");
  	  return $query->result();
	}
	public function count_notify_user_tickets($employee_id) {
	  $query = $this->db->query("SELECT st.*, ste.* FROM xin_support_tickets as st, xin_support_tickets_employees as ste WHERE st.ticket_id=ste.ticket_id and ste.employee_id = $employee_id");
	  //$this->db->group_by("st.ticket_id");
  	  return $query->num_rows();
	}
	
	public function get_notify_user_tickets($employee_id) {
	  $query = $this->db->query("SELECT st.*, ste.* FROM xin_support_tickets as st, xin_support_tickets_employees as ste WHERE st.ticket_id=ste.ticket_id and ste.employee_id = $employee_id");
	   //$this->db->group_by("st.ticket_id");
  	  return $query->result();
	}
	public function count_total_companies() {
	  $query = $this->db->query("SELECT * from xin_companies");
  	  return $query->num_rows();
	}
	
	
	// notifications
	public function count_user_notify_leave_applications($user_id)
	{
	  $query = $this->db->query("SELECT * from xin_leave_applications where employee_id = '".$user_id."' and is_notify = '1'");
  	  return $query->num_rows();
	}
	public function count_notify_leave_applications()
	{
	  $query = $this->db->query("SELECT * from xin_leave_applications where is_notify = '1'");
  	  return $query->num_rows();
	}
	// 2 nt
	public function count_notify_projects() {
	  $query = $this->db->query("SELECT * from xin_projects where is_notify = '1'");
  	  return $query->num_rows();
	}
	public function count_notify_company_projects($company_id) {
	  $query = $this->db->query("SELECT * from xin_projects where is_notify = '1' and company_id = '".$company_id."'");
  	  return $query->num_rows();
	}
	public function count_notify_user_projects($id) {
	  $query = $this->db->query("SELECT * from xin_projects where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'");
  	  return $query->num_rows();
	}
	// 3 nt
	public function count_notify_tasks() {
	  $query = $this->db->query("SELECT * from xin_tasks where is_notify = '1'");
  	  return $query->num_rows();
	}
	public function count_notify_company_tasks($company_id) {
	  $query = $this->db->query("SELECT * from xin_tasks where is_notify = '1' and company_id = '".$company_id."'");
  	  return $query->num_rows();
	}
	public function count_notify_user_tasks($id) {
	  $query = $this->db->query("SELECT * from xin_tasks where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'");
  	  return $query->num_rows();
	}
	// 4 nt
	public function count_notify_announcements() {
	  $query = $this->db->query("SELECT * from xin_announcements where is_notify = '1'");
  	  return $query->num_rows();
	}
	public function count_notify_company_announcements($company_id) {
	  $query = $this->db->query("SELECT * from xin_announcements where is_notify = '1' and company_id = '".$company_id."'");
  	  return $query->num_rows();
	}
	public function count_notify_dept_announcements($department_id) {
	  $query = $this->db->query("SELECT * from xin_announcements where is_notify = '1' and department_id = '$department_id' order by announcement_id desc");
  	  return $query->num_rows();
	}
	//5
	public function count_notify_tickets() {
	  $query = $this->db->query("SELECT * from xin_support_tickets where is_notify = '1' order by ticket_id desc");
  	  return $query->num_rows();
	}
	public function count_notify_company_tickets($company_id) {
	  $query = $this->db->query("SELECT * from xin_support_tickets where is_notify = '1' and company_id = '".$company_id."' order by ticket_id desc");
  	  return $query->num_rows();
	}
	
	//
	public function update_announcements_record($data){
		$sql = 'UPDATE xin_announcements SET is_notify = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);		
	}
	public function money_format($format, $number) 
	{ 
		$regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'. 
				  '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/'; 
		if (setlocale(LC_MONETARY, 0) == 'C') { 
			setlocale(LC_MONETARY, ''); 
		} 
		$locale = localeconv(); 
		preg_match_all($regex, $format, $matches, PREG_SET_ORDER); 
		foreach ($matches as $fmatch) { 
			$value = floatval($number); 
			$flags = array( 
				'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ? 
							   $match[1] : ' ', 
				'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0, 
				'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? 
							   $match[0] : '+', 
				'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0, 
				'isleft'    => preg_match('/\-/', $fmatch[1]) > 0 
			); 
			$width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0; 
			$left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0; 
			$right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits']; 
			$conversion = $fmatch[5]; 
	
			$positive = true; 
			if ($value < 0) { 
				$positive = false; 
				$value  *= -1; 
			} 
			$letter = $positive ? 'p' : 'n'; 
	
			$prefix = $suffix = $cprefix = $csuffix = $signal = ''; 
	
			$signal = $positive ? $locale['positive_sign'] : $locale['negative_sign']; 
			switch (true) { 
				case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+': 
					$prefix = $signal; 
					break; 
				case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+': 
					$suffix = $signal; 
					break; 
				case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+': 
					$cprefix = $signal; 
					break; 
				case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+': 
					$csuffix = $signal; 
					break; 
				case $flags['usesignal'] == '(': 
				case $locale["{$letter}_sign_posn"] == 0: 
					$prefix = '('; 
					$suffix = ')'; 
					break; 
			} 
			if (!$flags['nosimbol']) { 
				$currency = $cprefix . 
							($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) . 
							$csuffix; 
			} else { 
				$currency = ''; 
			} 
			$space  = $locale["{$letter}_sep_by_space"] ? ' ' : ''; 
	
			$value = number_format($value, $right, $locale['mon_decimal_point'], 
					 $flags['nogroup'] ? '' : $locale['mon_thousands_sep']); 
			$value = @explode($locale['mon_decimal_point'], $value); 
	
			$n = strlen($prefix) + strlen($currency) + strlen($value[0]); 
			if ($left > 0 && $left > $n) { 
				$value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0]; 
			} 
			$value = @implode($locale['mon_decimal_point'], $value); 
			if ($locale["{$letter}_cs_precedes"]) { 
				$value = $value; 
			} else { 
				$value = $value; 
			} 
			if ($width > 0) { 
				$value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ? 
						 STR_PAD_RIGHT : STR_PAD_LEFT); 
			} 
	
			$format = str_replace($fmatch[0], $value, $format); 
		} 
		return $format; 
	}
	public function convertNumberToWord($num = false) {
		$num = str_replace(array(',', ' '), '' , trim($num));
		if(! $num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
			'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
		);
		$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
		$list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
			'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
			'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ( $tens < 20 ) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
			} else {
				$tens = (int)($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		} //end for loop
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		return implode(' ', $words);
	}
	//set currency sign
	public function currency_sign($number) {
		
		
		// get details
		$system_setting = $this->read_setting_info(1);
		$default_locale = 'en_US';
		/*if($system_setting[0]->default_currency_locale == ''){
			$default_locale = 'en_US';
		} else {
			$default_locale = $system_setting[0]->default_currency_locale;
		}*/
		setlocale(LC_MONETARY, $default_locale);
		// currency code/symbol
		if($system_setting[0]->show_currency=='code'){
			$ar_sc = explode(' -',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[1];
		}
		if($system_setting[0]->currency_position=='Prefix'){
			$number = $this->money_format('%i', $number);
			$sign_value = $sc_show.''.$number;
		} else {
			$number = $this->money_format('%i', $number);
			$sign_value = $number.''.$sc_show;
		}
		
		return $sign_value;
	}
	//set company currency sign
	public function company_currency_sign($number,$company_id) {
		
		
		// get details
		$system_setting = $this->read_setting_info(1);
		$default_locale = 'en_US';
		/*if($system_setting[0]->default_currency_locale == ''){
			$default_locale = 'en_US';
		} else {
			$default_locale = $system_setting[0]->default_currency_locale;
		}*/
		$company_info = $this->Company_model->read_company_information($company_id);
		if(!is_null($company_info)){
			$default_currency = $company_info[0]->default_currency;
			//date_default_timezone_set($default_timezone);
		} else {
			$default_currency = $system[0]->default_currency_symbol;
			//date_default_timezone_set($default_timezone);	
		}
			
		setlocale(LC_MONETARY, $default_locale);
		// currency code/symbol
		if($system_setting[0]->show_currency=='code'){
			$ar_sc = explode(' -',$default_currency);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$default_currency);
			$sc_show = $ar_sc[1];
		}
		if($system_setting[0]->currency_position=='Prefix'){
			$number = $this->money_format('%i', $number);
			$sign_value = $sc_show.''.$number;
		} else {
			$number = $this->money_format('%i', $number);
			$sign_value = $number.''.$sc_show;
		}
		
		return $sign_value;
	}
	// set percentage value
	public function set_percentage($number){
		if(is_int($number)) {
			$inumber = $number;
		} else {
			$inumber = number_format((float)$number, 2, '.', '');
		}
		return $inumber;
		
	}
	// get all locations
	public function all_locations()
	{
	  $query = $this->db->query("SELECT * from xin_office_location");
  	  return $query->result();
	}
	
	// get all companies
	public function all_companies_dash()
	{
	  $query = $this->db->query("SELECT * from xin_companies");
  	  return $query->result();
	}
	
	//set currency sign
	public function set_date_format_js() {
		
		// get details
		$system_setting = $this->read_setting_info(1);
		// date format
		if($system_setting[0]->date_format_xi=='d-m-Y'){
			$d_format = 'dd-mm-yy';
		} else if($system_setting[0]->date_format_xi=='m-d-Y'){
			$d_format = 'mm-dd-yy';
		} else if($system_setting[0]->date_format_xi=='d-M-Y'){
			$d_format = 'dd-M-yy';
		} else if($system_setting[0]->date_format_xi=='M-d-Y'){
			$d_format = 'M-dd-yy';;
		}
		
		return $d_format;
	}
	
	public function read_designation_info($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get department designations	
	public function read_low_designations($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	 	return $query->result();
	}
	// get department designations	
	public function read_top_designations($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE top_designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	 	return $query->result();
	}
	
	// get department designations	
	public function read_dep_designations($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	 	return $query->result();
	}
	
	// get designation employees	
	public function read_designation_employees($id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	 	return $query->result();
	}
	
	// get all employees status
	public function all_employees_status()
	{
	  $query = $this->db->query("SELECT * from xin_employees");
  	  return $query;
	}
	
	// get all employees attendance calendar
	public function all_employees_attendance_calendar()
	{
	  $query = $this->db->query("SELECT * from xin_employees");
  	  return $query;
	}
	
	// get current day attendance 
	public function current_month_day_attendance($current_month) {
		
		$session = $this->session->userdata('username');
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT employee_id,attendance_date FROM xin_attendance_time WHERE attendance_date = ? group by employee_id';
		$binds = array($current_month);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	// get current day attendance > calendar
	public function current_employee_absent_calendar($current_month) {
		
		$session = $this->session->userdata('username');		
		$sql = "SELECT at.*,e.*,la.* from xin_attendance_time as at, xin_employees as e, xin_leave_applications as la where at.attendance_date = ? and e.user_id!=at.employee_id and e.user_id!=la.employee_id";
		$binds = array($current_month);
		$query = $this->db->query($sql, $binds);
		
		
		return $query->result();
	}
	public function current_employee_absent_calendar_count($current_month) {
		
		$session = $this->session->userdata('username');
		$sql = "SELECT at.*,e.*,la.* from xin_attendance_time as at, xin_employees as e, xin_leave_applications as la where at.attendance_date = ? and e.user_id!=at.employee_id and e.user_id!=la.employee_id";
		$binds = array($current_month);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	// check if leave available
	public function employee_leave_date_calendar($current_date) {
	
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = "SELECT la.*,e.user_id,e.first_name,e.last_name from xin_leave_applications as la, xin_employees as e where (la.from_date between la.from_date and la.to_date) or la.from_date = ? and la.to_date = ? and e.user_id=la.employee_id and la.status=2 group by la.employee_id";
		$binds = array($current_date,$current_date);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	public function employee_leave_date_calendar_count($current_date) {
	
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = "SELECT la.*,e.user_id,e.first_name,e.last_name from xin_leave_applications as la, xin_employees as e where (la.from_date between la.from_date and la.to_date) or la.from_date = ? and la.to_date = ? and e.user_id=la.employee_id and la.status=2 group by la.employee_id";
		$binds = array($current_date,$current_date);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	//
	// get current day attendance > calendar
	public function current_employee_leave_calendar() {
		
		$session = $this->session->userdata('username');
		$query = $this->db->query("SELECT la.*,e.* from xin_leave_applications as la, xin_employees as e where e.user_id=la.employee_id");
		return $query->result();
	}
	
	public function current_employee_working_calendar($current_date) {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * FROM xin_attendance_time WHERE attendance_date = ? group by employee_id';
		$binds = array($current_date);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
			
	// get all employees
	public function all_employees()
	{
	  $query = $this->db->query("SELECT * from xin_employees where user_role_id!=1");
  	  return $query->result();
	}
	
	// get all employees
	public function all_active_employees()
	{
	 	$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_employees WHERE is_active = ? and user_id!=?';
		$binds = array(1,$session['user_id']);
		$query = $this->db->query($sql, $binds);
  	  	return $query->result();
	}
	
	// get male
	public function male_employees()
	{
		$sql = 'SELECT * FROM xin_employees WHERE gender = ?';
		$binds = array('Male');
		$query = $this->db->query($sql, $binds);
		
		$male_emp = $query->num_rows();
		$stquery = $this->all_employees_status();
		$st_total = $stquery->num_rows();
		if($male_emp==0) {
			return $male_employees = 0;
		} else {
		// get actual data
			$rd_emp = round($male_emp / ($st_total / 100),2);
			return $rd_emp;
		}
	}
	// get female
	public function female_employees()
	{
		$sql = 'SELECT * FROM xin_employees WHERE gender = ?';
		$binds = array('Female');
		$query = $this->db->query($sql, $binds);
		$female_emp = $query->num_rows();
		$stquery = $this->all_employees_status();
		$st_total = $stquery->num_rows();
		// get actual data
		if($female_emp==0) {
			return $female_employees = 0;
		} else {
			// get actual data
			$rd_emp = round($female_emp / ($st_total / 100),2);
			return $rd_emp;
		}
	}
	
	// get all customers
	public function all_customers()
	{
	  $query = $this->db->query("SELECT * from xin_customers");
  	  return $query->result();
	}
	
	// get all suppliers
	public function all_suppliers()
	{
	  $query = $this->db->query("SELECT * from xin_suppliers");
  	  return $query->result();
	}
	
	// get all agents
	public function all_agents()
	{
	  $query = $this->db->query("SELECT * from xin_agents");
  	  return $query->result();
	}
		
	//set currency sign
	public function set_date_format($date) {
		
		// get details
		$system_setting = $this->read_setting_info(1);
		// date formate
		if($system_setting[0]->date_format_xi=='d-m-Y'){
			$d_format = date("d-m-Y", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='m-d-Y'){
			$d_format = date("m-d-Y", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='d-M-Y'){
			$d_format = date("d-M-Y", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='M-d-Y'){
			$d_format = date("M-d-Y", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='F-j-Y'){
			$d_format = date("F-j-Y", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='j-F-Y'){
			$d_format = date("j-F-Y", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='m.d.y'){
			$d_format = date("m.d.y", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='d.m.y'){
			$d_format = date("d.m.y", strtotime($date));
		} else {
			$d_format = $system_setting[0]->date_format_xi;
		}
		
		return $d_format;
	}
	
	//set currency sign
	public function set_date_time_format($date) {
		
		// get details
		$system_setting = $this->read_setting_info(1);
		// date formate
		if($system_setting[0]->date_format_xi=='d-m-Y'){
			$d_format = date("d-m-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='m-d-Y'){
			$d_format = date("m-d-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='d-M-Y'){
			$d_format = date("d-M-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='M-d-Y'){
			$d_format = date("M-d-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='F-j-Y'){
			$d_format = date("F-j-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='j-F-Y'){
			$d_format = date("j-F-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='m.d.y'){
			$d_format = date("m.d.y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_xi=='d.m.y'){
			$d_format = date("d.m.y h:i a", strtotime($date));
		} else {
			$d_format = $system_setting[0]->date_format_xi;
		}
		
		return $d_format;
	}
	
	// get all table rows 
	public function all_policies() {
	 	$query = $this->db->query("SELECT * from xin_company_policy");
		return $query->result();
	}
	
	// Function to update record in table > company information
	public function update_company_info_record($data, $id){
		$this->db->where('company_info_id', $id);
		if( $this->db->update('xin_company_info',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > company information
	public function update_setting_info_record($data, $id){
		$this->db->where('setting_id', $id);
		if( $this->db->update('xin_system_setting',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > company information
	public function update_email_config_record($data, $id){
		$this->db->where('email_config_id', $id);
		if( $this->db->update('xin_email_configuration',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > theme information
	public function update_theme_info_record($data, $id){
		$this->db->where('theme_settings_id', $id);
		if( $this->db->update('xin_theme_settings',$data)) {
			return true;
		} else {
			return false;
		}		
	}
		
	// Function to add record in table
	public function add_backup($data){
		$this->db->insert('xin_database_backup', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// get all db backup/s 
	public function all_db_backup() {
	 	return  $query = $this->db->query("SELECT * from xin_database_backup");
	}
	
	// get single db backup
	 public function read_db_backup($backup_id) {
	
		$sql = 'SELECT * FROM xin_database_backup WHERE backup_id = ?';
		$binds = array($backup_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_single_backup_record($id){
		$this->db->where('backup_id', $id);
		$this->db->delete('xin_database_backup');
		
	}
	// Function to Delete selected record from table
	public function delete_all_backup_record(){
		$this->db->empty_table('xin_database_backup');
		
	}
	
	// get all email templates 
	public function get_email_templates() {
	 	return  $query = $this->db->query("SELECT * from xin_email_template");
	}
	
	// get email template info
	public function read_email_template_info($id) {
	
		$sql = 'SELECT * FROM xin_email_template WHERE template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to update record in table > email template
	public function update_email_template_record($data, $id){
		$this->db->where('template_id', $id);
		if( $this->db->update('xin_email_template',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	/*  ALL CONSTATNS */
	
	// get all table rows 
	public function get_contract_types() {
	 	return  $query = $this->db->query("SELECT * from xin_contract_type");
	}
	
	// get all table rows 
	public function get_qualification_education() {
	 	return  $query = $this->db->query("SELECT * from xin_qualification_education_level");
	}
	
	// get all table rows 
	public function get_qualification_language() {
	 	return  $query = $this->db->query("SELECT * from xin_qualification_language");
	}
	
	// get all table rows 
	public function get_qualification_skill() {
	 	return  $query = $this->db->query("SELECT * from xin_qualification_skill");
	}
	
	// get all table rows 
	public function get_document_type() {
	 	return  $query = $this->db->query("SELECT * from xin_document_type");
	}
	
	// get all table rows 
	public function get_award_type() {
	 	return  $query = $this->db->query("SELECT * from xin_award_type");
	}
	
	public function get_company_type() {
	 	return  $query = $this->db->query("SELECT * from xin_company_type");
	}
	
	// get all table rows 
	public function get_leave_type() {
	 	return  $query = $this->db->query("SELECT * from xin_leave_type");
	}
	
	// get all table rows 
	public function get_warning_type() {
	 	return  $query = $this->db->query("SELECT * from xin_warning_type");
	}
	
	// get all table rows 
	public function get_termination_type() {
	 	return  $query = $this->db->query("SELECT * from xin_termination_type");
	}
	
	// get all table rows 
	public function get_expense_type() {
	 	return  $query = $this->db->query("SELECT * from xin_expense_type");
	}
	
	// get all table rows 
	public function get_job_type() {
	 	return  $query = $this->db->query("SELECT * from xin_job_type");
	}
	// get all table rows 
	public function get_job_categories() {
	 	return  $query = $this->db->query("SELECT * from xin_job_categories");
	}
	
	// get all table rows 
	public function get_exit_type() {
	 	return  $query = $this->db->query("SELECT * from xin_employee_exit_type");
	}
	
	// get all table rows 
	public function get_travel_type() {
	 	return  $query = $this->db->query("SELECT * from xin_travel_arrangement_type");
	}
	
	// get all table rows 
	public function get_payment_method() {
	 	return  $query = $this->db->query("SELECT * from xin_payment_method");
	}
	
	// get all table rows 
	public function get_currency_types() {
	 	return  $query = $this->db->query("SELECT * from xin_currencies");
	}
	
	/*  ADD CONSTANTS */
	
	// Function to add record in table
	public function add_contract_type($data){
		$this->db->insert('xin_contract_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_document_type($data){
		$this->db->insert('xin_document_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_edu_level($data){
		$this->db->insert('xin_qualification_education_level', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_edu_language($data){
		$this->db->insert('xin_qualification_language', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_edu_skill($data){
		$this->db->insert('xin_qualification_skill', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_payment_method($data){
		$this->db->insert('xin_payment_method', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_award_type($data){
		$this->db->insert('xin_award_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_leave_type($data){
		$this->db->insert('xin_leave_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_warning_type($data){
		$this->db->insert('xin_warning_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_termination_type($data){
		$this->db->insert('xin_termination_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_expense_type($data){
		$this->db->insert('xin_expense_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_job_type($data){
		$this->db->insert('xin_job_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add_job_category($data){
		$this->db->insert('xin_job_categories', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_exit_type($data){
		$this->db->insert('xin_employee_exit_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_company_type($data){
		$this->db->insert('xin_company_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_travel_arr_type($data){
		$this->db->insert('xin_travel_arrangement_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_currency_type($data){
		$this->db->insert('xin_currencies', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/*  DELETE CONSTANTS */
	// Function to Delete selected record from table
	public function delete_contract_type_record($id){
		$this->db->where('contract_type_id', $id);
		$this->db->delete('xin_contract_type');
		
	}
	// Function to Delete selected record from table
	public function delete_document_type_record($id){
		$this->db->where('document_type_id', $id);
		$this->db->delete('xin_document_type');
		
	}
	// Function to Delete selected record from table
	public function delete_payment_method_record($id){
		$this->db->where('payment_method_id', $id);
		$this->db->delete('xin_payment_method');
		
	}
	// Function to Delete selected record from table
	public function delete_education_level_record($id){
		$this->db->where('education_level_id', $id);
		$this->db->delete('xin_qualification_education_level');
		
	}
	// Function to Delete selected record from table
	public function delete_qualification_language_record($id){
		$this->db->where('language_id', $id);
		$this->db->delete('xin_qualification_language');
		
	}
	// Function to Delete selected record from table
	public function delete_qualification_skill_record($id){
		$this->db->where('skill_id', $id);
		$this->db->delete('xin_qualification_skill');
		
	}
	// Function to Delete selected record from table
	public function delete_award_type_record($id){
		$this->db->where('award_type_id', $id);
		$this->db->delete('xin_award_type');
		
	}
	// Function to Delete selected record from table
	public function delete_leave_type_record($id){
		$this->db->where('leave_type_id', $id);
		$this->db->delete('xin_leave_type');
		
	}
	// Function to Delete selected record from table
	public function delete_warning_type_record($id){
		$this->db->where('warning_type_id', $id);
		$this->db->delete('xin_warning_type');
		
	}
	// Function to Delete selected record from table
	public function delete_termination_type_record($id){
		$this->db->where('termination_type_id', $id);
		$this->db->delete('xin_termination_type');
		
	}
	// Function to Delete selected record from table
	public function delete_expense_type_record($id){
		$this->db->where('expense_type_id', $id);
		$this->db->delete('xin_expense_type');
		
	}
	// Function to Delete selected record from table
	public function delete_job_type_record($id){
		$this->db->where('job_type_id', $id);
		$this->db->delete('xin_job_type');
		
	}
	// Function to Delete selected record from table
	public function delete_job_category_record($id){
		$this->db->where('category_id', $id);
		$this->db->delete('xin_job_categories');
		
	}
	// Function to Delete selected record from table
	public function delete_exit_type_record($id){
		$this->db->where('exit_type_id', $id);
		$this->db->delete('xin_employee_exit_type');
		
	}
	// Function to Delete selected record from table
	public function delete_travel_arr_type_record($id){
		$this->db->where('arrangement_type_id', $id);
		$this->db->delete('xin_travel_arrangement_type');
		
	}
	
	// Function to Delete selected record from table
	public function delete_currency_type_record($id){
		$this->db->where('currency_id', $id);
		$this->db->delete('xin_currencies');
		
	}
	
	// Function to Delete selected record from table
	public function delete_company_type_record($id){
		$this->db->where('type_id', $id);
		$this->db->delete('xin_company_type');
		
	}
	
	// get all last 5 employees
	public function last_four_employees()
	{
	  $query = $this->db->query("SELECT * from xin_employees order by user_id desc limit 4");
  	  return $query->result();
	}
	
	// get all last jobs
	public function last_jobs()
	{
	  $query = $this->db->query("SELECT * FROM xin_job_applications order by application_id desc limit 4");
  	  return $query->result();
	}
	
	// get total number of salaries paid
	public function get_total_salaries_paid() {
	  $query = $this->db->query("SELECT SUM(payment_amount) as paid_amount FROM xin_make_payment");
  	  return $query->result();
	}
	
	// get company wise salary > chart
	public function all_companies_chart()
	{
	  $this->db->query("SET SESSION sql_mode = ''");
	  $query = $this->db->query("SELECT m.*, c.* FROM xin_make_payment as m, xin_companies as c where m.company_id = c.company_id group by m.company_id");
  	  return $query->result();
	}
	
	// get company wise salary > chart > make payment
	public function get_company_make_payment($id) {
	
		$sql = 'SELECT SUM(payment_amount) as paidAmount FROM xin_make_payment where company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	// get all currencies
	public function get_currencies() {
	
		$query = $this->db->query("SELECT * from xin_currencies");
		
		return $query->result();
	}
	
	// get location wise salary > chart
	public function all_location_chart()
	{
	  
	  $this->db->query("SET SESSION sql_mode = ''");
	  $query = $this->db->query("SELECT m.*, l.* FROM xin_make_payment as m, xin_office_location as l where m.location_id = l.location_id group by m.location_id");
  	  return $query->result();
	}
	
	// get location wise salary > chart > make payment
	public function get_location_make_payment($id) {
	
		$sql = 'SELECT SUM(payment_amount) as paidAmount FROM xin_make_payment where location_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	// get location wise salary > chart
	public function all_departments_chart()
	{
	  
	  $this->db->query("SET SESSION sql_mode = ''");
	  $query = $this->db->query("SELECT m.*, d.* FROM xin_salary_payslips as m, xin_departments as d where m.department_id = d.department_id group by m.department_id");
  	  return $query->result();
	}
	
	// get department wise salary > chart > make payment
	public function get_department_make_payment($id) {
	
		$query = $this->db->query("SELECT SUM(net_salary) as paidAmount FROM xin_salary_payslips where department_id='".$id."'");
		return $query->result();
	}
	
	// get designation wise salary > chart
	public function all_designations_chart()
	{
	  $query = $this->db->query("SELECT m.*, d.* FROM xin_salary_payslips as m, xin_designations as d where m.designation_id = d.designation_id group by m.designation_id");
  	  return $query->result();
	}
	
	// get designation wise salary > chart > make payment
	public function get_designation_make_payment($id) {
	
		$query = $this->db->query("SELECT SUM(net_salary) as paidAmount FROM xin_salary_payslips where designation_id='".$id."'");
		return $query->result();
	}
	
	// get all jobs
	public function get_all_jobs() {
	  $query = $this->db->get("xin_jobs");
	  return $query->num_rows();
	}
	
	// get all departments
	public function get_all_departments() {
	  $query = $this->db->get("xin_departments");
	  return $query->num_rows();
	}
	
	// get all users
	public function get_all_users() {
	  $query = $this->db->get("xin_users");
	  return $query->num_rows();
	}
	
	// get all tasks
	public function get_all_tasks() {
	  $query = $this->db->get("xin_tasks");
	  return $query->num_rows();
	}
	
	// get all tickets
	public function get_all_tickets() {
	  $query = $this->db->get("xin_support_tickets");
	  return $query->num_rows();
	}
	
	// get all projects
	public function get_all_projects() {
	  $query = $this->db->get("xin_projects");
	  return $query->num_rows();
	}
	
	// get all locations
	public function get_all_locations() {
	  $query = $this->db->get("xin_office_location");
	  return $query->num_rows();
	}
	
	// get all companies
	public function get_all_companies() {
	  $query = $this->db->get("xin_companies");
	  return $query->num_rows();
	}
	
	// get payment history > recently payslips
	public function get_last_payment_history() {
	  $query = $this->db->query("SELECT * from xin_salary_payslips order by payslip_id desc limit 7");
  	  return $query->result();
	}
	
	// get single record > db table > constant
	public function read_contract_type($id) {
	
		$sql = 'SELECT * FROM xin_contract_type where contract_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_document_type($id) {
	
		$sql = 'SELECT * FROM xin_document_type where document_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_payment_method($id) {
	
		$sql = 'SELECT * FROM xin_payment_method where payment_method_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_education_level($id) {
	
		$sql = 'SELECT * FROM xin_qualification_education_level where education_level_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
			
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_qualification_language($id) {
	
		$sql = 'SELECT * FROM xin_qualification_language where language_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
				
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_qualification_skill($id) {
	
		$sql = 'SELECT * FROM xin_qualification_skill where skill_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_award_type($id) {
	
		$sql = 'SELECT * FROM xin_award_type where award_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
				
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
		
	// get single record > db table > constant
	public function read_leave_type($id) {
	
		$sql = 'SELECT * FROM xin_leave_type where leave_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_warning_type($id) {
	
		$sql = 'SELECT * FROM xin_warning_type where warning_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_termination_type($id) {
	
		$sql = 'SELECT * FROM xin_termination_type where termination_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_expense_type($id) {
	
		$sql = 'SELECT * FROM xin_expense_type where expense_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_job_type($id) {
	
		$sql = 'SELECT * FROM xin_job_type where job_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get single record > db table > constant
	public function read_job_category($id) {
	
		$sql = 'SELECT * FROM xin_job_categories where category_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_exit_type($id) {
	
		$sql = 'SELECT * FROM xin_employee_exit_type where exit_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_travel_arr_type($id) {
	
		$sql = 'SELECT * FROM xin_travel_arrangement_type where arrangement_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_company_type($id) {
	
		$sql = 'SELECT * FROM xin_company_type where type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > db table > constant
	public function read_currency_types($id) {
	
		$sql = 'SELECT * FROM xin_currencies where currency_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	/* UPDATE CONSTANTS */
	// Function to update record in table
	public function update_document_type_record($data, $id){
		$this->db->where('document_type_id', $id);
		if( $this->db->update('xin_document_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_contract_type_record($data, $id){
		$this->db->where('contract_type_id', $id);
		if( $this->db->update('xin_contract_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_payment_method_record($data, $id){
		$this->db->where('payment_method_id', $id);
		if( $this->db->update('xin_payment_method',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_education_level_record($data, $id){
		$this->db->where('education_level_id', $id);
		if( $this->db->update('xin_qualification_education_level',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_qualification_language_record($data, $id){
		$this->db->where('language_id', $id);
		if( $this->db->update('xin_qualification_language',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_qualification_skill_record($data, $id){
		$this->db->where('skill_id', $id);
		if( $this->db->update('xin_qualification_skill',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_award_type_record($data, $id){
		$this->db->where('award_type_id', $id);
		if( $this->db->update('xin_award_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_leave_type_record($data, $id){
		$this->db->where('leave_type_id', $id);
		if( $this->db->update('xin_leave_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_warning_type_record($data, $id){
		$this->db->where('warning_type_id', $id);
		if( $this->db->update('xin_warning_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_termination_type_record($data, $id){
		$this->db->where('termination_type_id', $id);
		if( $this->db->update('xin_termination_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_expense_type_record($data, $id){
		$this->db->where('expense_type_id', $id);
		if( $this->db->update('xin_expense_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_currency_type_record($data, $id){
		$this->db->where('currency_id', $id);
		if( $this->db->update('xin_currencies',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get email template
	public function single_email_template($id){
		
		$sql = 'SELECT * FROM xin_email_template where template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	// Function to update record in table
	public function update_job_type_record($data, $id){
		$this->db->where('job_type_id', $id);
		if( $this->db->update('xin_job_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to update record in table
	public function update_job_category_record($data, $id){
		$this->db->where('category_id', $id);
		if( $this->db->update('xin_job_categories',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get single record > db table > email template
	public function read_email_template($id) {
	
		$sql = 'SELECT * FROM xin_email_template where template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to update record in table
	public function update_exit_type_record($data, $id){
		$this->db->where('exit_type_id', $id);
		if( $this->db->update('xin_employee_exit_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_travel_arr_record($data, $id){
		$this->db->where('arrangement_type_id', $id);
		if( $this->db->update('xin_travel_arrangement_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_company_type_record($data, $id){
		$this->db->where('type_id', $id);
		if( $this->db->update('xin_company_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get current month attendance 
	public function current_month_attendance() {
		$current_month = date('Y-m');
		$session = $this->session->userdata('username');
		$sql = 'SELECT * from xin_attendance_time where attendance_date like ? and employee_id = ?  group by attendance_date';
		$binds = array('%'.$current_month.'%',$session['user_id']);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	// get total employee awards 
	public function total_employee_awards() {
		$session = $this->session->userdata('username');
		$id = $session['user_id'];
		$query = $this->db->query("SELECT * FROM xin_awards where employee_id IN($id) order by award_id desc");
		return $query->num_rows();
	}
	
	// get current employee awards 
	public function get_employee_awards() {
		$session = $this->session->userdata('username');
		$id = $session['user_id'];
		$query = $this->db->query("SELECT * FROM xin_awards where employee_id IN($id) order by award_id desc");
		 return $query->result();
	}
	
	// get user role > links > all
	public function user_role_resource(){
		
		// get session
		$session = $this->session->userdata('username');
		// get userinfo and role
		$user = $this->read_user_info($session['user_id']);
		$role_user = $this->read_user_role_info($user[0]->user_role_id);
		
		$role_resources_ids = explode(',',$role_user[0]->role_resources);
		return $role_resources_ids;
	}
	
	// get all opened tickets
	public function all_open_tickets() {
		
		$sql = 'SELECT * FROM xin_support_tickets WHERE ticket_status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	// get all closed tickets
	public function all_closed_tickets() {
		 
		 $sql = 'SELECT * FROM xin_support_tickets WHERE ticket_status = ?';
		 $binds = array(2);
		 $query = $this->db->query($sql, $binds); 
		 return $query->num_rows();
	}
	
	// get selected language
	public function get_selected_language_name($site_lang) {
		//english
		if($site_lang=='english'){
			$name = 'English';
		} else if($site_lang=='chineese'){
			$name = 'Chineese';
		} else if($site_lang=='danish'){
			$name = 'Danish';
		} else if($site_lang=='french'){
			$name = 'French';
		} else if($site_lang=='german'){
			$name = 'German';
		} else if($site_lang=='greek'){
			$name = 'Greek';
		} else if($site_lang=='indonesian'){
			$name = 'Indonesian';
		} else if($site_lang=='italian'){
			$name = 'Italian';
		} else if($site_lang=='japanese'){
			$name = 'Japanese';
		} else if($site_lang=='polish'){
			$name = 'Polish';
		} else if($site_lang=='portuguese'){
			$name = 'Portuguese';
		} else if($site_lang=='romanian'){
			$name = 'Romanian';
		} else if($site_lang=='russian'){
			$name = 'Russian';
		} else if($site_lang=='spanish'){
			$name = 'Spanish';
		} else if($site_lang=='turkish'){
			$name = 'Turkish';
		} else if($site_lang=='vietnamese'){
			$name = 'Vietnamese';
		} else {
			$name = 'English';
		}
		return $name;
	}
	
	// get selected language
	public function get_selected_language_flag($site_lang) {
		//english
		if($site_lang=='english'){
			$flag = 'flag-icon-gb';
		} else if($site_lang=='chineese'){
			$flag = 'flag-icon-cn';
		} else if($site_lang=='danish'){
			$flag = 'dk.gif';
		} else if($site_lang=='french'){
			$flag = 'flag-icon-fr';
		} else if($site_lang=='german'){
			$flag = 'flag-icon-de';
		} else if($site_lang=='greek'){
			$flag = 'gr.gif';
		} else if($site_lang=='indonesian'){
			$flag = 'id.gif';
		} else if($site_lang=='italian'){
			$flag = 'ie.gif';
		} else if($site_lang=='japanese'){
			$flag = 'jp.gif';
		} else if($site_lang=='polish'){
			$flag = 'pl.gif';
		} else if($site_lang=='portuguese'){
			$flag = 'pt.gif';
		} else if($site_lang=='romanian'){
			$flag = 'ro.gif';
		} else if($site_lang=='russian'){
			$flag = 'ru.gif';
		} else if($site_lang=='spanish'){
			$flag = 'es.gif';
		} else if($site_lang=='turkish'){
			$flag = 'tr.gif';
		} else if($site_lang=='vietnamese'){
			$flag = 'vn.gif';
		} else {
			$flag = 'flag-icon-gb';
		}
		return $flag;
	}
	
	// get all languages
	public function all_languages()
	{
	     $sql = 'SELECT * FROM xin_languages WHERE is_active = ? order by language_name asc';
		 $binds = array(1);
		 $query = $this->db->query($sql, $binds); 
		 
  	  	  return $query->result();
	}
	
	// last 4 projects
	public function last_four_projects()
	{
	     $sql = 'SELECT * FROM xin_projects order by project_id desc limit ?';
		 $binds = array(4);
		 $query = $this->db->query($sql, $binds); 
		 
  	  	  return $query->result();
	}
	
	// last 4 projects
	public function last_five_client_projects($id)
	{
	     $sql = 'SELECT * FROM xin_projects where client_id = ? order by project_id desc limit ?';
		 $binds = array($id,5);
		 $query = $this->db->query($sql, $binds); 
		 
  	  	  return $query->result();
	}
	
	// get employees head count > chart
	public function all_head_count_chart()
	{
	  $query = $this->db->query("SELECT * from xin_employees group by created_at");
  	  return $query->result();
	}
	
	// get language info
	public function get_language_info($code) {
	
		$sql = 'SELECT * FROM xin_languages WHERE language_code = ?';
		$binds = array($code);
		$query = $this->db->query($sql, $binds); 
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get employees upcoming birthday
	public function employees_upcoming_birthday() {
	
		//$query = $this->db->query("SELECT * FROM xin_employees WHERE date_of_birth BETWEEN DATE_ADD(NOW(), INTERVAL 1 DAY) AND DATE_ADD( NOW() , INTERVAL 1 MONTH)");
		$query = $this->db->query("SELECT `user_id`, `first_name`, `last_name`, `date_of_birth`,
    DATE_ADD(
        date_of_birth, 
        INTERVAL IF(DAYOFYEAR(date_of_birth) >= DAYOFYEAR(CURDATE()),
            YEAR(CURDATE())-YEAR(date_of_birth),
            YEAR(CURDATE())-YEAR(date_of_birth)+1
        ) YEAR
    ) AS `next_birthday`
FROM `xin_employees` 
WHERE 
    `date_of_birth` IS NOT NULL
HAVING 
    `next_birthday` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
ORDER BY `next_birthday`");
  	  	return $query->result();
	}
	
	// get timezone
	public function all_timezones()
	{
	$timezones = array(
		'Pacific/Midway'       => "(GMT-11:00) Midway Island",
		'US/Samoa'             => "(GMT-11:00) Samoa",
		'US/Hawaii'            => "(GMT-10:00) Hawaii",
		'US/Alaska'            => "(GMT-09:00) Alaska",
		'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
		'America/Tijuana'      => "(GMT-08:00) Tijuana",
		'US/Arizona'           => "(GMT-07:00) Arizona",
		'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
		'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
		'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
		'America/Mexico_City'  => "(GMT-06:00) Mexico City",
		'America/Monterrey'    => "(GMT-06:00) Monterrey",
		'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
		'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
		'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
		'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
		'America/Bogota'       => "(GMT-05:00) Bogota",
		'America/Lima'         => "(GMT-05:00) Lima",
		'America/Caracas'      => "(GMT-04:30) Caracas",
		'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
		'America/La_Paz'       => "(GMT-04:00) La Paz",
		'America/Santiago'     => "(GMT-04:00) Santiago",
		'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
		'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
		'Greenland'            => "(GMT-03:00) Greenland",
		'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
		'Atlantic/Azores'      => "(GMT-01:00) Azores",
		'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
		'Africa/Casablanca'    => "(GMT) Casablanca",
		'Europe/Dublin'        => "(GMT) Dublin",
		'Europe/Lisbon'        => "(GMT) Lisbon",
		'Europe/London'        => "(GMT) London",
		'Africa/Monrovia'      => "(GMT) Monrovia",
		'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
		'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
		'Europe/Berlin'        => "(GMT+01:00) Berlin",
		'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
		'Europe/Brussels'      => "(GMT+01:00) Brussels",
		'Europe/Budapest'      => "(GMT+01:00) Budapest",
		'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
		'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
		'Europe/Madrid'        => "(GMT+01:00) Madrid",
		'Europe/Paris'         => "(GMT+01:00) Paris",
		'Europe/Prague'        => "(GMT+01:00) Prague",
		'Europe/Rome'          => "(GMT+01:00) Rome",
		'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
		'Europe/Skopje'        => "(GMT+01:00) Skopje",
		'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
		'Europe/Vienna'        => "(GMT+01:00) Vienna",
		'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
		'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
		'Europe/Athens'        => "(GMT+02:00) Athens",
		'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
		'Africa/Cairo'         => "(GMT+02:00) Cairo",
		'Africa/Harare'        => "(GMT+02:00) Harare",
		'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
		'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
		'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
		'Europe/Kiev'          => "(GMT+02:00) Kyiv",
		'Europe/Minsk'         => "(GMT+02:00) Minsk",
		'Europe/Riga'          => "(GMT+02:00) Riga",
		'Europe/Sofia'         => "(GMT+02:00) Sofia",
		'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
		'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
		'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
		'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
		'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
		'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
		'Europe/Moscow'        => "(GMT+03:00) Moscow",
		'Asia/Tehran'          => "(GMT+03:30) Tehran",
		'Asia/Baku'            => "(GMT+04:00) Baku",
		'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
		'Asia/Muscat'          => "(GMT+04:00) Muscat",
		'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
		'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
		'Asia/Kabul'           => "(GMT+04:30) Kabul",
		'Asia/Karachi'         => "(GMT+05:00) Karachi",
		'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
		'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
		'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
		'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
		'Asia/Almaty'          => "(GMT+06:00) Almaty",
		'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
		'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
		'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
		'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
		'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
		'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
		'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
		'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
		'Australia/Perth'      => "(GMT+08:00) Perth",
		'Asia/Singapore'       => "(GMT+08:00) Singapore",
		'Asia/Taipei'          => "(GMT+08:00) Taipei",
		'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
		'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
		'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
		'Asia/Seoul'           => "(GMT+09:00) Seoul",
		'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
		'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
		'Australia/Darwin'     => "(GMT+09:30) Darwin",
		'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
		'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
		'Australia/Canberra'   => "(GMT+10:00) Canberra",
		'Pacific/Guam'         => "(GMT+10:00) Guam",
		'Australia/Hobart'     => "(GMT+10:00) Hobart",
		'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
		'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
		'Australia/Sydney'     => "(GMT+10:00) Sydney",
		'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
		'Asia/Magadan'         => "(GMT+12:00) Magadan",
		'Pacific/Auckland'     => "(GMT+12:00) Auckland",
		'Pacific/Fiji'         => "(GMT+12:00) Fiji",
		);
		return $timezones;
	}
	
	// get all messages
	public function get_single_unread_message($to_id) {
		
		$sql = 'SELECT * FROM xin_chat_messages WHERE to_id = ? and is_read = ?';
		$binds = array($to_id,0);
		$query = $this->db->query($sql, $binds); 
		return $query->num_rows();
	}
	
	// check client email
	public function check_client_email($client_email) {
		
		$sql = 'SELECT * FROM xin_clients WHERE email = ?';
		$binds = array($client_email);
		$query = $this->db->query($sql, $binds); 
		return $query->num_rows();
	}	
	
	// get department>employees
	public function get_department_employees($to_id) {
		
		$sql = 'SELECT * FROM xin_employees WHERE department_id = ? and user_role_id!=1';
		$binds = array($to_id);
		$query = $this->db->query($sql, $binds); 
		return $query->result();
	}
	
	// get department>employees>leaves
	public function get_department_employees_leaves($employee_id) {
		
		$sql = 'SELECT * FROM xin_leave_applications WHERE employee_id = ?';
		$binds = array($employee_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get company>department>employees
	public function get_company_department_employees($to_id) {
		
		$sql = 'SELECT * FROM xin_departments WHERE company_id = ?';
		$binds = array($to_id);
		$query = $this->db->query($sql, $binds); 
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get year to date income tax
	public function year_to_date_income_tax($salary_month,$user_id) {
		
		$st_date = date('Y').'-01-01';
		$salary_month = $salary_month.'-01';
		$sql = "SELECT * FROM xin_salary_payslips WHERE (salary_month BETWEEN ? AND ?) and employee_id = ?";
		$binds = array($st_date,$salary_month,$user_id);
		$query = $this->db->query($sql, $binds); 
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get year to date salary_ssempee
	public function year_to_date_ssempee($salary_month,$user_id) {
		//SELECT * FROM `xin_salary_payslips` WHERE  (salary_month BETWEEN '2018-01-01' AND '2018-08-01')
		$st_date = date('Y').'-01-01';
		$salary_month = $salary_month.'-01';
		$sql = "SELECT * FROM xin_salary_payslips WHERE (salary_month BETWEEN ? AND ?) and employee_id = ?";
		$binds = array($st_date,$salary_month,$user_id);
		$query = $this->db->query($sql, $binds); 
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get year to date salary_ssempeer
	public function year_to_date_ssempeer($salary_month,$user_id) {
		
		$st_date = date('Y').'-01-01';
		$salary_month = $salary_month.'-01';
		$sql = "SELECT * FROM xin_salary_payslips WHERE (salary_month BETWEEN ? AND ?) and employee_id = ?";
		$binds = array($st_date,$salary_month,$user_id);
		$query = $this->db->query($sql, $binds); 
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get company>department>employees
	public function get_employee_attendance_location($employee_id,$attendance_date) {
		
		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date = ? order by time_attendance_id desc limit 1';
		$binds = array($employee_id,$attendance_date);
		$query = $this->db->query($sql, $binds); 
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	//get animation
	public function get_content_animate(){
		$val = 'animated fadeInRight';
		return $val;
	}
	
	public function hrsale_version() {
		$current_version = 'v2.0.0';
		return $current_version;
	}
	
	// company license expiry
	public function company_license_expiry() {
		$query = $this->db->query("SELECT `document_id`, `expiry_date`, `license_name`, `license_number`,
    DATE_ADD(
        expiry_date, 
        INTERVAL IF(DAYOFYEAR(expiry_date) >= DAYOFYEAR(CURDATE()),
            YEAR(CURDATE())-YEAR(expiry_date),
            YEAR(CURDATE())-YEAR(expiry_date)+1
        ) YEAR
    ) AS `eexpiry_date`
FROM `xin_company_documents` 
WHERE 
    `expiry_date` IS NOT NULL
HAVING 
    `expiry_date` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
ORDER BY `expiry_date`");
  	  	return $query->result();
	}
	
	public function company_license_expired() {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_company_documents where expiry_date < '".$curr_date."' ORDER BY `expiry_date` asc");
  	  	return $query->result();
	}
	
	//v1.1.2
	// get single employee>>>result!!
	public function read_employee_info_att($id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get company>employees
	public function get_company_employees($company_id) {
		
		$sql = 'SELECT * FROM xin_employees WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds); 
		return $query;
	}
	
	public function count_company_license_expired_all() {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_company_documents where expiry_date < '".$curr_date."' ORDER BY `expiry_date` asc");
  	  	return $query;
	}
	// expired documents > count
	// get documents
	public function count_get_documents_expired_all() {
			
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_documents where date_of_expiry < '".$curr_date."' ORDER BY `date_of_expiry` asc");
  	  	return $query->num_rows();
	}
	// user/
	public function count_get_user_documents_expired_all($employee_id) {
			
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_documents where employee_id = '".$employee_id."' and date_of_expiry < '".$curr_date."' ORDER BY `date_of_expiry` asc");
  	  	return $query->num_rows();
	}
	
	// get immigration documents
	public function count_get_img_documents_expired_all() {
			
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_immigration where expiry_date < '".$curr_date."' ORDER BY `expiry_date` asc");
  	  	return $query->num_rows();
	}
	//user // get immigration documents
	public function count_get_user_img_documents_expired_all($employee_id) {
			
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_employee_immigration where employee_id = '".$employee_id."' and expiry_date < '".$curr_date."' ORDER BY `expiry_date` asc");
  	  	return $query->num_rows();
	}
	public function iicount_company_license_expired_all() {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_company_documents where expiry_date < '".$curr_date."' ORDER BY `expiry_date` asc");
  	  	return $query->num_rows();
	}
	public function count_get_company_license_expired($company_id) {
	
		$curr_date = date('Y-m-d');
		$sql = "SELECT * FROM xin_company_documents WHERE expiry_date < '".$curr_date."' and company_id = ?";
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// company assets warranty all
	// assets warranty all
	public function count_warranty_assets_expired_all() {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_assets where warranty_end_date < '".$curr_date."' ORDER BY `warranty_end_date` asc");
  	  	return $query->num_rows();
	}
	// user assets warranty all
	public function count_user_warranty_assets_expired_all($employee_id) {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_assets where employee_id = '".$employee_id."' and warranty_end_date < '".$curr_date."' ORDER BY `warranty_end_date` asc");
  	  	return $query->num_rows();
	}
	// company assets warranty all
	public function count_company_warranty_assets_expired_all($company_id) {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from xin_assets where company_id = '".$company_id."' and warranty_end_date < '".$curr_date."' ORDER BY `warranty_end_date` asc");
  	  	return $query->num_rows();
	}
	// get client projects
	public function get_client_projects_panel($client_id) {
		
		$sql = 'SELECT * FROM xin_projects WHERE client_id = ?';
		$binds = array($client_id);
		$query = $this->db->query($sql, $binds); 
		return $query->result();
	}
	// get project/tasks
	public function get_client_project_tasks_panel($project_id) {
		
		$sql = 'SELECT * FROM xin_tasks WHERE project_id = ?';
		$binds = array($project_id);
		$query = $this->db->query($sql, $binds); 
		return $query;
	}
	
	// get email setting info
	public function read_email_config_info($id) {
	
		$sql = 'SELECT * FROM xin_email_configuration WHERE email_config_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function get_security_level_type() {
	 	return  $query = $this->db->query("SELECT * from xin_security_level");
	}
	// Function to add record in table
	public function add_security_level($data){
		$this->db->insert('xin_security_level', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// get single record > db table > constant
	public function read_security_level($id) {
	
		$sql = 'SELECT * FROM xin_security_level where type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// Function to update record in table
	public function update_security_level_record($data, $id){
		$this->db->where('type_id', $id);
		if( $this->db->update('xin_security_level',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to Delete selected record from table
	public function delete_security_level_record($id){
		$this->db->where('type_id', $id);
		$this->db->delete('xin_security_level');
		
	}
	// v1.1.7
	// get all table rows 
	public function get_ethnicity_type() {
	 	return  $query = $this->db->query("SELECT * from xin_ethnicity_type");
	}
	// Function to add record in table
	public function add_ethnicity_type($data){
		$this->db->insert('xin_ethnicity_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to Delete selected record from table
	public function delete_ethnicity_type_record($id){
		$this->db->where('ethnicity_type_id', $id);
		$this->db->delete('xin_ethnicity_type');
	}
	// get single record > db table > constant
	public function read_ethnicity_type($id) {
	
		$sql = 'SELECT * FROM xin_ethnicity_type where ethnicity_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// Function to update record in table
	public function update_ethnicity_type_record($data, $id){
		$this->db->where('ethnicity_type_id', $id);
		if( $this->db->update('xin_ethnicity_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all table rows 
	public function get_income_categories() {
	 	return  $query = $this->db->query("SELECT * from xin_income_categories");
	}
	// Function to add record in table
	public function add_income_type($data){
		$this->db->insert('xin_income_categories', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// get single record > db table > constant
	public function read_income_type($id) {
	
		$sql = 'SELECT * FROM xin_income_categories where category_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to update record in table
	public function update_income_type_record($data, $id){
		$this->db->where('category_id', $id);
		if( $this->db->update('xin_income_categories',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to Delete selected record from table
	public function delete_income_type_record($id){
		$this->db->where('category_id', $id);
		$this->db->delete('xin_income_categories');
	}
	
	// awards count
	public function get_employee_awards_count($id) {
		
		$sql = 'SELECT * FROM xin_awards WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query->num_rows();
	}
	// get employee training count
	public function get_employee_training_count($id) {
	
		$sql = "SELECT * FROM `xin_training` where employee_id like '%$id,%' or employee_id like '%,$id%' or employee_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	public function get_employee_warning_count($id) {
	 	
		$sql = 'SELECT * FROM xin_employee_warnings WHERE warning_to = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	public function get_employee_travel_count($id) {
	 	
		$sql = 'SELECT * FROM xin_employee_travels WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	public function get_employee_tickets_count($id) {
	 	
		$sql = 'SELECT st.*, ste.* FROM xin_support_tickets as st, xin_support_tickets_employees as ste WHERE st.ticket_id=ste.ticket_id and (ste.employee_id = ? || st.created_by = ?)';
		$binds = array($id,$id);
		$this->db->group_by("st.ticket_id");
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get employee projects
	public function get_employee_projects_count($id) {
	
		$sql = "SELECT * FROM `xin_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get employee tasks
	public function get_employee_tasks_count($id) {
	
		$sql = "SELECT * FROM `xin_tasks` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	public function get_employee_assets_count($id) {
		
		//$id = $this->db->escape($id);
		$sql = 'SELECT * FROM xin_assets WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
	 	return $query->num_rows();
	}
	public function get_employee_meetings_count($id) {
		
		$sql = "SELECT * FROM xin_meetings WHERE employee_id like '%$id,%' or employee_id like '%,$id%' or employee_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query->num_rows();
	}
	public function get_employee_events_count($id) {
		
		$sql = "SELECT * FROM xin_events WHERE employee_id like '%$id,%' or employee_id like '%,$id%' or employee_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query->num_rows();
	}
	// get all specific department employees
	public function all_active_departments_employees()
	{
	 	$session = $this->session->userdata('username');
		$euser_info = $this->read_user_info($session['user_id']);
		$sql = 'SELECT * FROM xin_employees WHERE is_active = ? and department_id = ?';
		$binds = array(1,$euser_info[0]->department_id);
		$query = $this->db->query($sql, $binds);
  	  	return $query->result();
	}
	// group/chat
	public function get_group_chat() {
		$query = $this->db->query('SELECT * FROM xin_chat_groups');
  	  	return $query->result();
	}
	public function sum_the_time($time1, $time2) {
      $times = array($time1, $time2);
      $seconds = 0;
      foreach ($times as $time)
      {
        list($hour,$minute,$second) = explode(':', $time);
        $seconds += $hour*3600;
        $seconds += $minute*60;
        $seconds += $second;
      }
      $hours = floor($seconds/3600);
      $seconds -= $hours*3600;
      $minutes  = floor($seconds/60);
      $seconds -= $minutes*60;
      if($seconds < 9)
      {
      $seconds = "0".$seconds;
      }
      if($minutes < 9)
      {
      $minutes = "0".$minutes;
      }
        if($hours < 9)
      {
      $hours = "0".$hours;
      }
      return "{$hours}:{$minutes}:{$seconds}";
    }
	// actual hours for timelog > project
	public function actual_hours_timelog($project_id) {
		$sql = 'SELECT * FROM xin_projects_timelogs WHERE project_id = ?';
		$binds = array($project_id);
		$query = $this->db->query($sql, $binds);
		$qry_ac = $query->result();
		$total_hrs = 0;
		$hrs_old_seconds = 0;
		$hrs_old_int1 = 0;
		$Total = 0;
		foreach($qry_ac as $r){
			// total work			
			$timee = $r->total_hours.':00';
			$str_time =$timee;

			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
			
			sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
			
			$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
			
			$hrs_old_int1 += $hrs_old_seconds;
			
			$Total = gmdate("H:i", $hrs_old_int1);
		}
		return $Total;
	}
	
	public function get_company_employees_multi($id) {
		
		$sql = "SELECT * FROM xin_employees WHERE company_id like '%$id,%' or company_id like '%,$id%' or company_id = '$id' and user_role_id!=1";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	public function get_company_clients($id) {
		
		$sql = "SELECT * FROM xin_projects WHERE company_id like '%$id,%' or company_id like '%,$id%' or company_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	// get task category by id
	public function read_task_category_info($id) {
	
		$sql = 'SELECT * FROM xin_task_categories WHERE task_category_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get notifications
	public function hrsale_notifications($module_name,$employee_id) {
	
		$sql = 'SELECT * FROM xin_hrsale_notificaions WHERE module_name = ? and employee_id = ? and is_notify = ?';
		$binds = array($module_name,$employee_id,1);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	// get notifications>count
	public function hrsale_notifications_count($module_name,$employee_id) {
	
		$sql = 'SELECT * FROM xin_hrsale_notificaions WHERE module_name = ? and employee_id = ? and is_notify = ?';
		$binds = array($module_name,$employee_id,1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	// Function to add record in table
	public function add_notifications($data){
		$this->db->insert('xin_hrsale_notificaions', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function update_notification_record($data, $id,$employee_id,$module_name){
	
		$this->db->where('module_id', $id);
		$this->db->where('employee_id', $employee_id);
		$this->db->where('module_name', $module_name);
		if( $this->db->update('xin_hrsale_notificaions',$data)) {
			return true;
		} else {
			return false;
		}
	}
	
}
?>