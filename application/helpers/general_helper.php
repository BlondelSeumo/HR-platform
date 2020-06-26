<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function initialize_elfinder($value=''){
	$CI =& get_instance();
	$CI->load->helper('path');
	$opts = array(
	    //'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => './uploads/files_manager/', 
	        'URL'    => site_url('uploads/files_manager').'/'
	        // more elFinder options here
	      ) 
	    )
	);
	return $opts;
}
if ( ! function_exists('get_employee_leave_category'))
{
	function get_employee_leave_category($id_nums,$employee_id) {
		$CI =&	get_instance();
		$sql = "select e.leave_categories,e.user_id,l.leave_type_id,l.days_per_year,l.type_name from xin_employees as e, xin_leave_type as l where l.leave_type_id IN ($id_nums) and e.user_id = $employee_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_sub_departments'))
{
	function get_sub_departments($id) {
		$CI =&	get_instance();
		$sql = "select * from xin_sub_departments where department_id = $id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_main_departments_employees'))
{
	function get_main_departments_employees() {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from xin_departments as d, xin_employees as e where d.department_id = e.department_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_sub_departments_employees'))
{
	function get_sub_departments_employees($id,$empid) {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from xin_sub_departments as d, xin_employees as e where d.sub_department_id = e.sub_department_id and e.department_id = '".$id."' and e.employee_id!= '".$empid."' group by e.sub_department_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_sub_departments_designations'))
{
	function get_sub_departments_designations($id,$empid,$mainid) {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from xin_designations as d, xin_employees as e where d.designation_id = e.designation_id and e.employee_id!= '".$empid."' and e.employee_id!= '".$mainid."' and e.designation_id = '".$id."'";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_main_companies_chart'))
{
	function get_main_companies_chart() {
		$CI =&	get_instance();
		$sql = "select * from xin_companies";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_main_companies_location_chart'))
{
	function get_main_companies_location_chart($company_id) {
		$CI =&	get_instance();
		$sql = "select * from xin_office_location where company_id = '".$company_id."'";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_location_departments_head_employees'))
{
	function get_location_departments_head_employees($location_id) {
		$CI =&	get_instance();
		$sql = "select * from xin_departments where location_id = '".$location_id."'";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_main_departments_head_employees'))
{
	function get_main_departments_head_employees() {
		$CI =&	get_instance();
		$sql = "select * from xin_departments";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('hrsale_roles'))
{
	function hrsale_roles() {
		$CI =&	get_instance();
		$sql = "select * from xin_user_roles";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('hrsale_office_shift'))
{
	function hrsale_office_shift() {
		$CI =&	get_instance();
		$sql = "select * from xin_office_shift";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_departments_designations'))
{
	function get_departments_designations($department_id,$employee_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$sql = "select d.*,e.* from xin_designations as d, xin_employees as e where d.department_id= '".$department_id."' and d.designation_id = e.designation_id";
		$CI->db->group_by("d.designation_id");
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('total_salaries_paid'))
{
	function total_salaries_paid() {
			$CI =&	get_instance();
			$CI->db->from('xin_salary_payslips');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('hrsale_payroll'))
{
	function hrsale_payroll($salary_month) {
			$CI =&	get_instance();
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$salary_month);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('ihrsale_user_payroll'))
{
	function ihrsale_user_payroll($salary_month,$employee_id) {
			$CI =&	get_instance();
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$salary_month);
			$CI->db->where('employee_id',$employee_id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('hrsale_payroll_this_month'))
{
	function hrsale_payroll_this_month() {
			$CI =&	get_instance();
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',date('Y-m'));
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('hrsale_user_payroll_this_month'))
{
	function hrsale_user_payroll_this_month($employee_id) {
			$CI =&	get_instance();
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',date('Y-m'));
			$CI->db->where('employee_id',$employee_id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('hrsale_payroll_last_6_month'))
{
	function hrsale_payroll_last_6_month() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 5; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('hrsale_user_payroll_last_6_month'))
{
	function hrsale_user_payroll_last_6_month($employee_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 5; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$CI->db->where('employee_id',$employee_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('hrsale_payroll_last_1year'))
{
	function hrsale_payroll_last_1year() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 11; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('hrsale_user_payroll_last_1year'))
{
	function hrsale_user_payroll_last_1year($employee_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 11; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$CI->db->where('employee_id',$employee_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('hrsale_payroll_last_2years'))
{
	function hrsale_payroll_last_2years() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 23; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('hrsale_user_payroll_last_2years'))
{
	function hrsale_user_payroll_last_2years($employee_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 23; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$CI->db->where('employee_id',$employee_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('hrsale_payroll_last_3years'))
{
	function hrsale_payroll_last_3years() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 35; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('hrsale_user_payroll_last_3years'))
{
	function hrsale_user_payroll_last_3years($employee_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 35; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('xin_salary_payslips');
			$CI->db->where('salary_month',$months);
			$CI->db->where('employee_id',$employee_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}
if ( ! function_exists('total_invoices_paid'))
{
	function total_invoices_paid() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','income');
			$CI->db->where('dr_cr','cr');	
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->amount;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('count_leaves_info'))
{
	function count_leaves_info($leave_type_id,$employee_id) {
			$CI =&	get_instance();
			$CI->db->from('xin_leave_applications');
			$CI->db->where('employee_id',$employee_id);
			$CI->db->where('leave_type_id',$leave_type_id);
			$CI->db->where('status=',2);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$ifrom_date =  $inc->from_date;
				$ito_date =  $inc->to_date;
				$datetime1 = new DateTime($ifrom_date);
				$datetime2 = new DateTime($ito_date);
				$interval = $datetime1->diff($datetime2);
				if(strtotime($inc->from_date) == strtotime($inc->to_date)){
					$tinc +=1;
				} else {
					$tinc += $interval->format('%a') + 1;
				}
				
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('total_tickets'))
{
	function total_tickets() {
		$CI =&	get_instance();
		$CI->db->from('xin_support_tickets');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('total_open_tickets'))
{
	function total_open_tickets() {
		$CI =&	get_instance();
		$CI->db->from('xin_support_tickets');
		$CI->db->where('ticket_status',1);
		$query = $CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('total_closed_tickets'))
{
	function total_closed_tickets() {
		$CI =&	get_instance();
		$CI->db->from('xin_support_tickets');
		$CI->db->where('ticket_status',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('active_employees'))
{
	function active_employees() {
		$CI =&	get_instance();
		$CI->db->from('xin_employees');
		$CI->db->where('is_active',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('inactive_employees'))
{
	function inactive_employees() {
		$CI =&	get_instance();
		$CI->db->from('xin_employees');
		$CI->db->where('is_active',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('completed_tasks'))
{
	function completed_tasks() {
		$CI =&	get_instance();
		$CI->db->from('xin_tasks');
		$CI->db->where('task_status',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('inprogress_tasks'))
{
	function inprogress_tasks() {
		$CI =&	get_instance();
		$CI->db->from('xin_tasks');
		$CI->db->where('task_status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('total_account_balances'))
{
	function total_account_balances() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_bankcash');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->account_balance;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
//after v1.0.11
if ( ! function_exists('system_settings_info'))
{
		function system_settings_info($id) {
			$CI =&	get_instance();
			$CI->db->from('xin_system_setting');
			$CI->db->where('setting_id',$id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}

}
if ( ! function_exists('xin_company_info'))
{
		function xin_company_info($id) {
			$CI =&	get_instance();
			$CI->db->from('xin_company_info');
			$CI->db->where('company_info_id',$id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}

}
if ( ! function_exists('read_invoice_record'))
{
		function read_invoice_record($id) {
			$CI =&	get_instance();
			$CI->db->from('xin_hrsale_invoices');
			$CI->db->where('invoice_id',$id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}
}
if ( ! function_exists('get_invoice_transaction_record'))
{
	function get_invoice_transaction_record($id) {
		$CI =&	get_instance();
		$CI->db->from('xin_finance_transaction');
		$CI->db->where('transaction_type','income');
		$CI->db->where('invoice_id',$id);
		$query=$CI->db->get();
		return $query;
	}
}
if ( ! function_exists('system_currency_sign'))
{
	//set currency sign
	function system_currency_sign($number) {
		
		// get details
		$system_setting = system_settings_info(1);
		// currency code/symbol
		if($system_setting->show_currency=='code'){
			$ar_sc = explode(' -',$system_setting->default_currency_symbol);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$system_setting->default_currency_symbol);
			$sc_show = $ar_sc[1];
		}
		if($system_setting->currency_position=='Prefix'){
			$sign_value = $sc_show.''.$number;
		} else {
			$sign_value = $number.''.$sc_show;
		}
		return $sign_value;
	}
}
//single client 
if ( ! function_exists('clients_invoice_paid_count'))
{
	function clients_invoice_paid_count($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
// all
if ( ! function_exists('all_invoice_paid_count'))
{
	function all_invoice_paid_count() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
// all
if ( ! function_exists('all_invoice_unpaid_count'))
{
	function all_invoice_unpaid_count() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('clients_invoice_unpaid_count'))
{
	function clients_invoice_unpaid_count($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('clients_project_inprogress'))
{
	function clients_project_inprogress($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('clients_project_completed'))
{
	function clients_project_completed($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('clients_project_notstarted'))
{
	function clients_project_notstarted($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('clients_project_deffered'))
{
	function clients_project_deffered($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',3);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('clients_invoice_paid_amount'))
{
	function clients_invoice_paid_amount($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}
// all
if ( ! function_exists('all_invoice_paid_amount'))
{
	function all_invoice_paid_amount() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}
// all
if ( ! function_exists('all_invoice_unpaid_amount'))
{
	function all_invoice_unpaid_amount() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('clients_invoice_unpaid_amount'))
{
	function clients_invoice_unpaid_amount($cid) {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('last_client_invoice_info'))
{
	function last_client_invoice_info() {
		$CI =&	get_instance();
		$sql = 'SELECT * FROM xin_hrsale_invoices order by invoice_id desc limit 1';
		$query = $CI->db->query($sql);		
		if ($query->num_rows() > 0) {
			$inv = $query->result();
			if(!is_null($inv)) {
				return $invid = $inv[0]->invoice_id;
			} else {
				return $invid = 0;
			}
		} else {
			return $invid = 0;
		}
	}
}
if ( ! function_exists('total_travel_expense'))
{
	function total_travel_expense() {
		$CI =&	get_instance();
		$CI->db->from('xin_employee_travels');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->actual_budget;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('total_travel'))
{
	function total_travel() {
		$CI =&	get_instance();
		$CI->db->from('xin_employee_travels');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('pending_travel'))
{
	function pending_travel() {
		$CI =&	get_instance();
		$CI->db->from('xin_employee_travels');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('pending_leave_request'))
{
	function pending_leave_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_leave_applications');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('accepted_leave_request'))
{
	function accepted_leave_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_leave_applications');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('rejected_leave_request'))
{
	function rejected_leave_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_leave_applications');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('rejected_leave_request'))
{
	function rejected_leave_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_leave_applications');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_total_shifts'))
{
	function employee_total_shifts() {
		$CI =&	get_instance();
		$CI->db->from('xin_office_shift');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('accepted_travel'))
{
	function accepted_travel() {
		$CI =&	get_instance();
		$CI->db->from('xin_employee_travels');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('rejected_travel'))
{
	function rejected_travel() {
		$CI =&	get_instance();
		$CI->db->from('xin_employee_travels');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_training'))
{
	function total_training() {
		$CI =&	get_instance();
		$CI->db->from('xin_training');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_pending_training'))
{
	function total_pending_training() {
		$CI =&	get_instance();
		$CI->db->from('xin_training');
		$CI->db->where('training_status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_training'))
{
	function total_training() {
		$CI =&	get_instance();
		$CI->db->from('xin_training');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_started_training'))
{
	function total_started_training() {
		$CI =&	get_instance();
		$CI->db->from('xin_training');
		$CI->db->where('training_status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_completed_training'))
{
	function total_completed_training() {
		$CI =&	get_instance();
		$CI->db->from('xin_training');
		$CI->db->where('training_status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_assets'))
{
	function total_assets() {
		$CI =&	get_instance();
		$CI->db->from('xin_assets');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_projects'))
{
	function total_projects() {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_last_projects'))
{
	function total_last_projects() {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->order_by("project_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_tasks'))
{
	function total_last_tasks() {
		$CI =&	get_instance();
		$CI->db->from('xin_tasks');
		$CI->db->order_by("task_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_invoices'))
{
	function total_last_invoices() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->order_by("invoice_id", "desc");
		$CI->db->limit(4);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_leaves'))
{
	function total_last_leaves() {
		$CI =&	get_instance();
		$CI->db->from('xin_leave_applications');
		$CI->db->order_by("leave_id", "desc");
		$CI->db->limit(5);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_holidays'))
{
	function total_last_holidays() {
		$CI =&	get_instance();
		$CI->db->from('xin_holidays');
		$CI->db->order_by("holiday_id", "desc");
		$CI->db->limit(2);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_overtime_request'))
{
	function total_last_overtime_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_attendance_time_request');
		$CI->db->order_by("time_request_id", "desc");
		$CI->db->limit(2);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_estimates'))
{
	function total_last_estimates() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->order_by("quote_id", "desc");
		$CI->db->limit(4);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_5_invoice_payments'))
{
	function total_last_5_invoice_payments() {
		$CI =&	get_instance();
		$CI->db->from('xin_finance_transaction');
		$CI->db->order_by("transaction_id", "desc");
		$CI->db->where('invoice_id!=','');
		$CI->db->limit(5);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_clients'))
{
	function total_last_clients() {
		$CI =&	get_instance();
		$CI->db->from('xin_clients');
		$CI->db->order_by("client_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_leads'))
{
	function total_last_leads() {
		$CI =&	get_instance();
		$CI->db->from('xin_leads');
		$CI->db->order_by("client_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_last_5_qprojects'))
{
	function total_last_5_qprojects() {
		$CI =&	get_instance();
		$CI->db->from('xin_quoted_projects');
		$CI->db->order_by("project_id", "desc");
		$CI->db->limit(5);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('get_projects_status'))
{
	function get_projects_status() {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$CI->db->from('xin_projects');
		$CI->db->group_by("status");
		$query=$CI->db->get();
		return $query;
	}
}
if ( ! function_exists('get_client_projects_status'))
{
	function get_client_projects_status($client_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$CI->db->from('xin_projects');
		$CI->db->where('client_id',$client_id);
		$CI->db->group_by("status");
		$query=$CI->db->get();
		return $query;
	}
}
if ( ! function_exists('get_tasks_status'))
{
	function get_tasks_status() {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$CI->db->from('xin_tasks');
		$CI->db->group_by("task_status");
		$query=$CI->db->get();
		return $query;
	}
}
if ( ! function_exists('get_user_projects_status'))
{
	function get_user_projects_status($employee_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$sql = "SELECT * FROM `xin_projects` where assigned_to like '%$employee_id,%' or assigned_to like '%,$employee_id%' or assigned_to = '$employee_id' group by status";
		
		$query = $CI->db->query($sql);
		//$CI->db->group_by("status");
		//$query=$CI->db->get();
		return $query;
	}
}
if ( ! function_exists('total_user_projects_status'))
{
	function total_user_projects_status($status) {
		$CI =&	get_instance();
		$sql = "SELECT * FROM `xin_projects` where status = '$status'";
		//$CI->db->group_by("status");
		$query = $CI->db->query($sql);
		//$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('get_user_tasks_status'))
{
	function get_user_tasks_status($employee_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");		
		$sql = "SELECT * FROM `xin_tasks` where assigned_to like '%$employee_id,%' or assigned_to like '%,$employee_id%' or assigned_to = '$employee_id' group by task_status";		
		$query = $CI->db->query($sql);
		return $query;
	}
}
if ( ! function_exists('total_user_tasks_status'))
{
	function total_user_tasks_status($status,$employee_id) {
		$CI =&	get_instance();
		//$CI->db->from('xin_tasks');
		$sql = "SELECT * FROM `xin_tasks` where task_status = '$status'";
		$query = $CI->db->query($sql);
		return $query->num_rows();
	}
}
if ( ! function_exists('total_projects_status'))
{
	function total_projects_status($status) {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('status',$status);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_client_projects_status'))
{
	function total_client_projects_status($status,$client_id) {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('client_id',$client_id);
		$CI->db->where('status',$status);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_tasks_status'))
{
	function total_tasks_status($status) {
		$CI =&	get_instance();
		$CI->db->from('xin_tasks');
		$CI->db->where('task_status',$status);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_tasks'))
{
	function total_tasks() {
		$CI =&	get_instance();
		$CI->db->from('xin_tasks');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_completed_tasks'))
{
	function total_completed_tasks() {
		$CI =&	get_instance();
		$CI->db->from('xin_tasks');
		$CI->db->where('task_status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_inprogress_tasks'))
{
	function total_inprogress_tasks() {
		$CI =&	get_instance();
		$CI->db->from('xin_tasks');
		$CI->db->where('task_status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_cancelled_projects'))
{
	function total_cancelled_projects() {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_completed_projects'))
{
	function total_completed_projects() {
		$CI =&	get_instance();
		$CI->db->from('xin_projects');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_clients'))
{
	function total_clients() {
		$CI =&	get_instance();
		$CI->db->from('xin_clients');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_leads'))
{
	function total_leads() {
		$CI =&	get_instance();
		$CI->db->from('xin_leads');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_leads_converted'))
{
	function total_leads_converted() {
		$CI =&	get_instance();
		$CI->db->from('xin_leads');
		$CI->db->where('is_changed',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_invoices'))
{
	function total_invoices() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_paid_invoices'))
{
	function total_paid_invoices() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_unpaid_invoices'))
{
	function total_unpaid_invoices() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_invoices');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_estimate'))
{
	function total_estimate() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_estimate_converted'))
{
	function total_estimate_converted() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_quoted_projects'))
{
	function total_quoted_projects() {
		$CI =&	get_instance();
		$CI->db->from('xin_quoted_projects');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_assets_working'))
{
	function total_assets_working() {
		$CI =&	get_instance();
		$CI->db->from('xin_assets');
		$CI->db->where('is_working',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('total_assets_not_working'))
{
	function total_assets_not_working() {
		$CI =&	get_instance();
		$CI->db->from('xin_assets');
		$CI->db->where('is_working',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('cr_quote_quoted'))
{
	function cr_quote_quoted() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('cr_quote_project_created'))
{
	function cr_quote_project_created() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('cr_quote_inprogress'))
{
	function cr_quote_inprogress() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('cr_quote_project_completed'))
{
	function cr_quote_project_completed() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('cr_quote_invoiced'))
{
	function cr_quote_invoiced() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',4);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('cr_quote_paid'))
{
	function cr_quote_paid() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',5);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('cr_quote_deffered'))
{
	function cr_quote_deffered() {
		$CI =&	get_instance();
		$CI->db->from('xin_hrsale_quotes');
		$CI->db->where('status',6);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('employee_leave_halfday_cal'))
{
	function employee_leave_halfday_cal($leave_type_id,$employee_id) {
		$CI =&	get_instance();
		$CI->db->from('xin_leave_applications');
		$CI->db->where('employee_id',$employee_id);
		$CI->db->where('leave_type_id',$leave_type_id);
		$CI->db->where('is_half_day',1);
		$CI->db->where('status=',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return $query->result();
		}
	}
}
if ( ! function_exists('employee_request_leaves'))
{
	function employee_request_leaves() {
		$CI =&	get_instance();
		$CI->db->from('xin_leave_applications');
		//$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_holidays'))
{
	function employee_holidays() {
		$CI =&	get_instance();
		$CI->db->from('xin_holidays');
		//$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_published_holidays'))
{
	function employee_published_holidays() {
		$CI =&	get_instance();
		$CI->db->from('xin_holidays');
		$CI->db->where('is_publish',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_unpublished_holidays'))
{
	function employee_unpublished_holidays() {
		$CI =&	get_instance();
		$CI->db->from('xin_holidays');
		$CI->db->where('is_publish',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_overtime_request'))
{
	function employee_overtime_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_attendance_time_request');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_approved_overtime_request'))
{
	function employee_approved_overtime_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_attendance_time_request');
		$CI->db->where('is_approved',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_pending_overtime_request'))
{
	function employee_pending_overtime_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_attendance_time_request');
		$CI->db->where('is_approved',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('employee_rejected_overtime_request'))
{
	function employee_rejected_overtime_request() {
		$CI =&	get_instance();
		$CI->db->from('xin_attendance_time_request');
		$CI->db->where('is_approved',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_total_sales'))
{
	function dashboard_total_sales() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','income');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->amount;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('dashboard_total_expense'))
{
	function dashboard_total_expense() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','expense');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$texp = 0;
			foreach($result as $exp){
				$texp += $exp->amount;
			}
			return $texp;
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('dashboard_total_payees'))
{
	function dashboard_total_payees() {
		$CI =&	get_instance();
		$CI->db->from("xin_finance_payees");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_total_payers'))
{
	function dashboard_total_payers() {
		$CI =&	get_instance();
		$CI->db->from("xin_finance_payers");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_paid_invoices'))
{
	function dashboard_paid_invoices() {
		$CI =&	get_instance();
		$CI->db->from("xin_hrsale_invoices");
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_unpaid_invoices'))
{
	function dashboard_unpaid_invoices() {
		$CI =&	get_instance();
		$CI->db->from("xin_hrsale_invoices");
		$CI->db->where('status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_cancelled_invoices'))
{
	function dashboard_cancelled_invoices() {
		$CI =&	get_instance();
		$CI->db->from("xin_hrsale_invoices");
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_last_two_invoices'))
{
	function dashboard_last_two_invoices() {
			$CI =&	get_instance();
			$CI->db->from('xin_hrsale_invoices');
			$CI->db->order_by('invoice_id','desc');
			$CI->db->limit(2);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}
if ( ! function_exists('dashboard_bankcash'))
{
	function dashboard_bankcash() {
		$CI =&	get_instance();
		$CI->db->from("xin_finance_bankcash");
		$CI->db->order_by('bankcash_id','asc');
		$CI->db->limit(6);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}
if ( ! function_exists('dashboard_last_five_income'))
{
	function dashboard_last_five_income() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','income');
			$CI->db->order_by('transaction_id','desc');
			$CI->db->limit(4);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}

}
if ( ! function_exists('dashboard_last_five_expense'))
{
	function dashboard_last_five_expense() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','expense');
			$CI->db->order_by('transaction_id','desc');
			$CI->db->limit(4);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}

}
if ( ! function_exists('income_transaction_record'))
{
	function income_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','income');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}

}
if ( ! function_exists('awards_transaction_record'))
{
	function awards_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_awards');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}
if ( ! function_exists('travel_transaction_record'))
{
	function travel_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_employee_travels');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}
if ( ! function_exists('payroll_transaction_record'))
{
	function payroll_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_salary_payslips');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}
if ( ! function_exists('training_transaction_record'))
{
	function training_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_training');
			$CI->db->where('training_status',2);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}
if ( ! function_exists('invoice_payments_transaction_record'))
{
	function invoice_payments_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','income');
			$CI->db->where('description','Invoice Payments');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}
if ( ! function_exists('get_reports_to'))
{
	function get_reports_to() {
		$CI =&	get_instance();
		$CI->db->from("xin_employees");
		$CI->db->where('user_role_id!=',1);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('get_reports_team_data'))
{
	function get_reports_team_data($reports_to) {
		$CI =&	get_instance();
		$CI->db->from("xin_employees");
		$CI->db->where('reports_to',$reports_to);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('hrsale_team'))
{
	function hrsale_team() {
		$CI =&	get_instance();
		$CI->db->from("xin_employees");
		$CI->db->where('reports_to!=',0);
		//$CI->db->group_by('reports_to'); 
		$query=$CI->db->get();
		return $query->result();
	}
}
?>