<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trainers_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_trainers() {
	  return $this->db->get("xin_trainers");
	}
	
	// all trainers
	public function all_trainers() {
	  $query = $this->db->query("SELECT * from xin_trainers");
  	  return $query->result();
	}
	// get company trainers
	public function get_company_trainers($company_id) {
	
		$sql = 'SELECT * FROM xin_trainers WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	 
	 public function read_trainer_information($id) {
	
		$sql = 'SELECT * FROM xin_trainers WHERE trainer_id = ?';
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
		$this->db->insert('xin_trainers', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('trainer_id', $id);
		$this->db->delete('xin_trainers');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('trainer_id', $id);
		if( $this->db->update('xin_trainers',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>