<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
class designation_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_designations()
	{
	  return $this->db->get("xin_designations");
	}
	 
	 public function read_designation_information($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_designations', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('designation_id', $id);
		$this->db->delete('xin_designations');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('designation_id', $id);
		if( $this->db->update('xin_designations',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all designations
	public function all_designations()
	{
	  $query = $this->db->query("SELECT * from xin_designations");
  	  return $query->result();
	}
	
	// get department > designations
	public function ajax_designation_information($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	// get department > designations
	public function ajax_is_designation_information($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// get company > designations
	public function ajax_company_designation_info($id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_company_designations($company_id) {
	
		$sql = 'SELECT * FROM xin_designations WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
}
?>