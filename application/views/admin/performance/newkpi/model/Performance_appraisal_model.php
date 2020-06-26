<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class performance_appraisal_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_performance_appraisal() {
	  return $this->db->get("xin_performance_appraisal");
	}
	
	public function get_employee_performance_appraisal($id) {
	 	return $query = $this->db->query("SELECT * from xin_performance_appraisal where employee_id = '".$id."'");
	}
	 
	 public function read_appraisal_information($id) {
	
		$condition = "performance_appraisal_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_performance_appraisal');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_performance_appraisal', $data);
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
}
?>