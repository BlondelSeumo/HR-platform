<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Overtime_request_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
 
 	// Function to add record in table
	public function add_employee_overtime_request($data){
		$this->db->insert('xin_attendance_time_request', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_request_record($data, $id){
		$this->db->where('time_request_id', $id);
		if( $this->db->update('xin_attendance_time_request',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get record of attendance by id
	 public function read_overtime_request_info($id) {
	
		$sql = 'SELECT * FROM xin_attendance_time_request WHERE time_request_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_overtime_request_record($id){ 
		$this->db->where('time_request_id', $id);
		$this->db->delete('xin_attendance_time_request');
		
	}
	
	// get overtime request
	public function employee_overtime_requests($emp_id) {
		
		$sql = 'SELECT * FROM xin_attendance_time_request where employee_id = ?';
		$binds = array($emp_id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get overtime request>admin>all
	public function all_employee_overtime_requests() {
		
		$sql = 'SELECT * FROM xin_attendance_time_request';
		$query = $this->db->query($sql);
		
		return $query;
	}
	// get overtime request>admin>all
	public function get_overtime_request_count($employee_id,$pay_date) {
		
		$sql = 'SELECT * FROM `xin_attendance_time_request` where employee_id = ? and is_approved = ? and request_date_request = ?';
		$binds = array($employee_id,2,$pay_date);
		$query = $this->db->query($sql, $binds);
		$result = $query->result();
		return $result;
	}
}
?>