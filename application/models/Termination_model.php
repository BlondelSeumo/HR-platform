<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Termination_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_terminations()
	{
	  return $this->db->get("xin_employee_terminations");
	}
	 
	 public function read_termination_information($id) {
	
		$sql = 'SELECT * FROM xin_employee_terminations WHERE termination_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get company termination
	public function get_company_terminations($company_id) {
	
		$sql = 'SELECT * FROM xin_employee_terminations WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
		
	public function get_employee_termination($id) {
		
		$sql = 'SELECT * FROM xin_employee_terminations WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query;
	}
	
	public function read_termination_type_information($id) {
	
		$sql = 'SELECT * FROM xin_termination_type WHERE termination_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_termination_types() {
	  $query = $this->db->query("SELECT * from xin_termination_type");
  	  return $query->result();
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_employee_terminations', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('termination_id', $id);
		$this->db->delete('xin_employee_terminations');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('termination_id', $id);
		if( $this->db->update('xin_employee_terminations',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>