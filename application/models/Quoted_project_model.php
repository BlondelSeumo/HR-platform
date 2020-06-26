<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quoted_project_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_projects()
	{
	  return $this->db->get("xin_quoted_projects");
	}
	 
	 public function read_project_information($id) {
	
		$sql = 'SELECT * FROM xin_quoted_projects WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get task categories
	public function get_task_categories() {
		return $this->db->get("xin_task_categories");
	}
	public function get_project_timelogs($project_id) {
		$sql = "SELECT * FROM xin_quoted_projects_timelogs where project_id = ?";
		$binds = array($project_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	public function get_all_project_timelogs() {
		$sql = "SELECT * FROM xin_quoted_projects_timelogs";
		$query = $this->db->query($sql);
		return $query;
	}
	public function get_leads_follow_up_all() {
		$sql = "SELECT * FROM xin_leads_followup";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_estimates_all() {
		$sql = "SELECT * FROM xin_hrsale_quotes";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_all_project_employee_timelogs($user_id) {
		$sql = "SELECT * FROM xin_quoted_projects_timelogs where employee_id = ?";
		$binds = array($user_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_bug_information($id) {
	
		$sql = 'SELECT * FROM xin_projects_bugs WHERE bug_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows()> 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_quoted_projects', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_task_categories($data){
		$this->db->insert('xin_task_categories', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add_project_timelog($data){
		$this->db->insert('xin_quoted_projects_timelogs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_task_category_record($id){
		$this->db->where('task_category_id', $id);
		$this->db->delete('xin_task_categories');
		
	}
	
	// get task category by id
	public function read_task_category_information($id) {
	
		$sql = 'SELECT * FROM xin_task_categories WHERE task_category_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get timelog record by id
	public function read_timelog_info($id) {
	
		$sql = 'SELECT * FROM xin_quoted_projects_timelogs WHERE timelogs_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to update record in table
	public function update_task_category_record($data, $id){
		$this->db->where('task_category_id', $id);
		if( $this->db->update('xin_task_categories',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to update record in table
	public function update_project_timelog_record($data, $id){
		$this->db->where('timelogs_id', $id);
		if( $this->db->update('xin_quoted_projects_timelogs',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('project_id', $id);
		$this->db->delete('xin_quoted_projects');
		
	}
	// Function to Delete selected record from table
	public function delete_timelog_record($id){
		$this->db->where('timelogs_id', $id);
		$this->db->delete('xin_quoted_projects_timelogs');
		
	}
	
	// get attachments > projects
	public function get_attachments($id) {
		
		$sql = 'SELECT * FROM xin_quoted_projects_attachment WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get clients projects
	public function get_client_projects($id) {
		
		$sql = 'SELECT * FROM xin_projects WHERE client_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_all_projects()
	{
	  $query = $this->db->query("SELECT * from xin_quoted_projects");
  	  return $query->result();
	}
	
	// Function to add record in table > add attachment
	public function add_new_attachment($data){
		$this->db->insert('xin_quoted_projects_attachment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_attachment_record($id){
		$this->db->where('project_attachment_id', $id);
		$this->db->delete('xin_quoted_projects_attachment');
		
	}
	
	// get project discussion
	public function get_discussion($id) {
		
		$sql = 'SELECT * FROM xin_quoted_projects_discussion WHERE project_id = ? order by discussion_id desc';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get project bugs/issues
	public function get_bug($id) {
		
		$sql = 'SELECT * FROM xin_projects_bugs WHERE project_id = ? order by bug_id desc';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// Function to add record in table > add discussion
	public function add_discussion($data){
		$this->db->insert('xin_quoted_projects_discussion', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table > add bug
	public function add_bug($data){
		$this->db->insert('xin_projects_bugs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_bug($data, $id){
		$this->db->where('bug_id', $id);
		if( $this->db->update('xin_projects_bugs',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('project_id', $id);
		if( $this->db->update('xin_quoted_projects',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get single record > company | projects
	 public function ajax_company_projects($id) {
	
		$sql = 'SELECT * FROM xin_projects WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get total project tasks 
	public function total_project_tasks($id) {
		
		$sql = 'SELECT * FROM xin_tasks WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get total project bugs 
	public function total_project_bugs($id) {
		
		$sql = 'SELECT * FROM xin_projects_bugs WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get total project files 
	public function total_project_files($id) {
		
		$sql = 'SELECT * FROM xin_projects_attachment WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get total project > deffered
	public function cancelled_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	// get calendar project > deffered
	public function calendar_cancelled_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > deffered
	public function calendar_cancelled_tasks() {
		
		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	// get total project > completed
	public function complete_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get calendar project > completed
	public function calendar_complete_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > completed
	public function calendar_complete_tasks() {
		
		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	// get total project > in progress
	public function inprogress_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get calendar project > in progress
	public function calendar_inprogress_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > in progress
	public function calendar_inprogress_tasks() {
		
		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	// get total project > not started
	public function not_started_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	// get calendar project > not started
	public function calendar_not_started_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > not started
	public function calendar_not_started_tasks() {
		
		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get total project > hold
	public function hold_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	// get calendar project > hold
	public function calendar_hold_projects() {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > hold
	public function calendar_hold_tasks() {
		
		$sql = 'SELECT * FROM xin_tasks WHERE task_status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	//////////////////////////////	
	// get calendar project > hold
	public function calendar_user_hold_projects($id) {
		
		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar project > not started
	public function calendar_user_not_started_projects($id) {
		
		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar project > completed
	public function calendar_user_complete_projects($id) {
		
		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar project > in progress
	public function calendar_user_inprogress_projects($id) {
		
		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar project > deffered
	public function calendar_user_cancelled_projects($id) {
		
		$sql = "SELECT * FROM xin_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	///////////////////////////////////////
	//////////////////////////////	
	// get calendar tasks > hold
	public function calendar_user_hold_tasks($id) {
		
		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > not started
	public function calendar_user_not_started_tasks($id) {
		
		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > completed
	public function calendar_user_complete_tasks($id) {
		
		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > in progress
	public function calendar_user_inprogress_tasks($id) {
		
		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	// get calendar tasks > deffered
	public function calendar_user_cancelled_tasks($id) {
		
		$sql = "SELECT * FROM xin_tasks WHERE task_status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	///////////////////////////////////////
	//clients // get total project > deffered
	public function deffered_client_projects($id) {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(3,$id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	//clients // get total project > completed
	public function complete_client_projects($id) {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(2,$id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	//clients // get total project > in progress
	public function inprogress_client_projects($id) {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(1,$id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	//clients // get total project > not started
	public function not_started_client_projects($id) {
		
		$sql = 'SELECT * FROM xin_projects WHERE status = ? and client_id = ?';
		$binds = array(0,$id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	// get all project tasks>completed
	public function completed_project_bugs($id) {
	
		$sql = 'SELECT * FROM xin_projects_bugs WHERE project_id = ? and status = ?';
		$binds = array($id,1);
		$query = $this->db->query($sql, $binds);
		
		$cTasks = $query->num_rows();
		$pQuery = $this->total_project_bugs($id);
		if($pQuery==0) {
			return $ctTasks = 0;
		} else {
			// get actual data
			$calTasks = $cTasks / $pQuery * 100;
			$ctTasks = round($calTasks);
			return $ctTasks;
		}
	}

	// get all project tasks>completed
	public function completed_project_tasks($id) {
	  
		$sql = 'SELECT * FROM xin_tasks WHERE project_id = ? and task_status = ?';
		$binds = array($id,2);
		$query = $this->db->query($sql, $binds);
		
		$cTasks = $query->num_rows();
		$pQuery = $this->total_project_tasks($id);
		if($pQuery==0) {
			return $ctTasks = 0;
		} else {
			// get actual data
			$calTasks = $cTasks / $pQuery * 100;
			$ctTasks = round($calTasks);
			return $ctTasks;
		}
	}
	// get company projects
	public function get_company_projects($company_id) {
	
		$sql = "SELECT * FROM xin_quoted_projects WHERE company_id like '%$id,%' or company_id like '%,$id%' or company_id = '$id'";
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get employee projects
	public function get_employee_projects($id) {
	
		$sql = "SELECT * FROM `xin_quoted_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
}
?>