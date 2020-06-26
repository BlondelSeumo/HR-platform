<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goal_tracking_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	// get _tracking_type
	public function get_goal_tracking_type() {
	  return $this->db->get("xin_goal_tracking_type");
	}
	
	// get goal tracking
	public function get_goal_tracking() {
	  return $this->db->get("xin_goal_tracking");
	}
		
	public function get_company_goal_tracking($id) {
		
		$sql = 'SELECT * FROM xin_goal_tracking WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query;
	}	
	// all tracking_types
	public function all_tracking_types() {
	  $query = $this->db->query("SELECT * from xin_goal_tracking_type");
  	  return $query->result();
	}
	
	// all completed goals
	public function all_goals_completed() {
	  return $this->db->query("SELECT * from xin_goal_tracking where goal_status=2");
	}
	
	// all in completed goals
	public function all_goals_inprogress() {
	  return $this->db->query("SELECT * from xin_goal_tracking where goal_status=1");
	}
	
	// all not started goals
	public function all_goals_not_started() {
	  return $this->db->query("SELECT * from xin_goal_tracking where goal_status=0");
	}
	 
	public function read_goal_information($id) {
	
		$sql = 'SELECT * FROM xin_goal_tracking WHERE tracking_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_tracking_type_information($id) {
	
		$sql = 'SELECT * FROM xin_goal_tracking_type WHERE tracking_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to add record in table
	public function add_goal($data){
		$this->db->insert('xin_goal_tracking', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_type($data){
		$this->db->insert('xin_goal_tracking_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_goal_record($id){
		$this->db->where('tracking_id', $id);
		$this->db->delete('xin_goal_tracking');
		
	}
	
	// Function to Delete selected record from table
	public function delete_type_record($id){
		$this->db->where('tracking_type_id', $id);
		$this->db->delete('xin_goal_tracking_type');
		
	}
	
		
	// Function to update record in table
	public function update_goal_record($data, $id){
		$this->db->where('tracking_id', $id);
		if( $this->db->update('xin_goal_tracking',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_type_record($data, $id){
		$this->db->where('tracking_type_id', $id);
		if( $this->db->update('xin_goal_tracking_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
}
?>