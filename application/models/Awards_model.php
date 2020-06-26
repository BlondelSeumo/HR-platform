<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class awards_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_awards()
	{
	  return $this->db->get("xin_awards");
	}
	 
	 public function read_award_type_information($id) {
	
		$sql = 'SELECT * FROM xin_award_type WHERE award_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get company awards
	public function get_company_awards($company_id) {
	
		$sql = 'SELECT * FROM xin_awards WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function all_award_types()
	{
	  $query = $this->db->query("SELECT * from xin_award_type");
  	  return $query->result();
	}
	
	public function get_employee_awards($id) {
		
		$sql = 'SELECT * FROM xin_awards WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query;
	}
	
	public function read_award_information($id) {
	
		$sql = 'SELECT * FROM xin_awards WHERE award_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_awards', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('award_id', $id);
		$this->db->delete('xin_awards');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('award_id', $id);
		if( $this->db->update('xin_awards',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>