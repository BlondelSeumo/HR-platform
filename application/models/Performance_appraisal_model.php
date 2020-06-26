<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_appraisal_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_performance_appraisal() {
	  return $this->db->get("xin_performance_appraisal");
	}
	
	public function get_employee_performance_appraisal($id) {
	 	
		$sql = 'SELECT * FROM xin_performance_appraisal WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	public function get_company_performance_appraisal($id) {
	 	
		$sql = 'SELECT * FROM xin_performance_appraisal WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	 
	 public function read_appraisal_information($id) {
	
		$sql = 'SELECT * FROM xin_performance_appraisal WHERE performance_appraisal_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_appraisal_technical_options($ikey,$id) {
	
		$sql = 'SELECT * FROM xin_performance_appraisal_options WHERE appraisal_type = "technical" and appraisal_option_id = ? and appraisal_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_appraisal_organizational_options($ikey,$id) {
	
		$sql = 'SELECT * FROM xin_performance_appraisal_options WHERE appraisal_type = "organizational" and appraisal_option_id = ? and appraisal_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_performance_appraisal', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add_appraisal_options($data){
		$this->db->insert('xin_performance_appraisal_options', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('performance_appraisal_id', $id);
		$this->db->delete('xin_performance_appraisal');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('performance_appraisal_id', $id);
		if( $this->db->update('xin_performance_appraisal',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_appraisal_technical_record($key,$data, $id){
		$this->db->where('appraisal_id', $id);
		$this->db->where('appraisal_option_id', $key);
		$this->db->where('appraisal_type', 'technical');
		if( $this->db->update('xin_performance_appraisal_options',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to update record in table
	public function update_appraisal_organizational_record($key,$data, $id){
		$this->db->where('appraisal_id', $id);
		$this->db->where('appraisal_option_id', $key);
		$this->db->where('appraisal_type', 'organizational');
		if( $this->db->update('xin_performance_appraisal_options',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	//check if available
	public function read_appraisal_technical_options_available($ikey,$id) {
	
		$sql = 'SELECT * FROM xin_performance_appraisal_options WHERE appraisal_type = "technical" and appraisal_option_id = ? and appraisal_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	//check if available
	public function read_appraisal_organizational_options_available($ikey,$id) {
	
		$sql = 'SELECT * FROM xin_performance_appraisal_options WHERE appraisal_type = "organizational" and appraisal_option_id = ? and appraisal_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
}
?>