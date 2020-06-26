<?php
	
class Exin_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	// get single location
	 public function read_location_info($id) {
	
		$sql = 'SELECT * FROM xin_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "location_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_office_location');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single employee
	public function read_employee_info($id) {
	
		$sql = 'SELECT * FROM xin_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "user_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_employees');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
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
	
		$sql = 'SELECT * FROM xin_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "user_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_employees');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
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
	
	// get employee awards
	public function total_employee_awards_dash() {
		
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_awards WHERE employee_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get employee claim expense
	public function total_employee_expense_dash() {
		
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_expenses WHERE employee_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get employee travel
	public function total_employee_travel_dash() {
		
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_employee_travels WHERE employee_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	
	// task completed
	public function get_completed_tasks($task_id) {
		
		$sql = 'SELECT * FROM xin_tasks WHERE task_id = ? and task_status = ?';
		$binds = array($task_id,2);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	// task overdue
	public function get_overdue_tasks($task_id) {
		
		$date = date('Y-m-d');
		$sql = 'SELECT * FROM xin_tasks WHERE task_id = ? and end_date < ? and task_status != ?';
		$binds = array($task_id,$date,2);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	// task todo
	public function get_todo_tasks($task_id) {
		
		$date = date('Y-m-d');
		$sql = 'SELECT * FROM xin_tasks WHERE task_id = ?  and end_date > ? and task_status != ?';
		$binds = array($task_id,$date,2);
		$query = $this->db->query($sql, $binds);
	
		return $query->num_rows();
	}
	
	public function get_countries()
	{
	  $query = $this->db->query("SELECT * from xin_countries");
  	  return $query->result();
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
	
	// get single company user
	public function read_sx_company_info($id) {
	
		$sql = 'SELECT * FROM xin_companies WHERE company_id = ?';
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
		$binds = array(0000);
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
	
		$sql = 'SELECT * FROM xin_users WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get last user attendance > check if loged in-
	public function attendance_time_checks($id) {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_attendance_time WHERE `employee_id` = ? and clock_out = ? order by time_attendance_id desc limit 1';
		$binds = array($id, '');
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get single user > by designation
	public function read_user_info_bydesignation($id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
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
		return 'HR Software | HRSALE';
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
	
	// get last 5 applications
	public function get_last_leave_applications()
	{
	  $query = $this->db->query("SELECT * from xin_leave_applications order by leave_id desc limit 5");
  	  return $query->result();
	}
	
	//set currency sign
	public function currency_sign($number) {
		
		// get details
		$system_setting = $this->read_setting_info(1);
		// currency code/symbol
		if($system_setting[0]->show_currency=='code'){
			$ar_sc = explode(' -',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[1];
		}
		if($system_setting[0]->currency_position=='Prefix'){
			$sign_value = $sc_show.''.$number;
		} else {
			$sign_value = $number.''.$sc_show;
		}
		return $sign_value;
	}
	
	// get all locations
	public function all_locations()
	{
	  $query = $this->db->query("SELECT * from xin_office_location");
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
	
	// get all employees
	public function all_employees()
	{
	  $query = $this->db->query("SELECT * from xin_employees");
  	  return $query->result();
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
	public function add_exit_type($data){
		$this->db->insert('xin_employee_exit_type', $data);
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
	  $query = $this->db->query("SELECT m.*, d.* FROM xin_make_payment as m, xin_departments as d where m.department_id = d.department_id group by m.department_id");
  	  return $query->result();
	}
	
	// get department wise salary > chart > make payment
	public function get_department_make_payment($id) {
	
		$sql = 'SELECT SUM(payment_amount) as paidAmount FROM xin_make_payment where department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	// get designation wise salary > chart
	public function all_designations_chart()
	{
	  $this->db->query("SET SESSION sql_mode = ''");
	  $query = $this->db->query("SELECT m.*, d.* FROM xin_make_payment as m, xin_designations as d where m.designation_id = d.designation_id group by m.designation_id");
  	  return $query->result();
	}
	
	// get designation wise salary > chart > make payment
	public function get_designation_make_payment($id) {
	
		$sql = 'SELECT SUM(payment_amount) as paidAmount FROM xin_make_payment where designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
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
	
		$sql = 'SELECT * FROM xin_expense_type where expense_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "job_type_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_job_type');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
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
	
	// get current month attendance 
	public function current_month_attendance() {
		$current_month = date('Y-m');
		$session = $this->session->userdata('username');
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * FROM xin_attendance_time where attendance_date like ? and `employee_id` = ? group by attendance_date';
		$binds = array('%'.$current_month.'%', $session['user_id']);
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
		 
		$sql = 'SELECT * FROM xin_support_tickets where ticket_status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get all closed tickets
	public function all_closed_tickets() {
		 
		$sql = 'SELECT * FROM xin_support_tickets where ticket_status = ?';
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
		
}
?>