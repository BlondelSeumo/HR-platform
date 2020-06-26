<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transfers_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_transfers() {
	  return $this->db->get("xin_employee_transfer");
	}
	
	public function get_employee_transfers($id) {
	 	
		$sql = 'SELECT * FROM xin_employee_transfer WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	// get company transfers
	public function get_company_transfers($company_id) {
	
		$sql = 'SELECT * FROM xin_employee_transfer WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	 
	public function read_transfer_information($id) {
	
		$sql = 'SELECT * FROM xin_employee_transfer WHERE transfer_id = ?';
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
		$this->db->insert('xin_employee_transfer', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('transfer_id', $id);
		$this->db->delete('xin_employee_transfer');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('transfer_id', $id);
		if( $this->db->update('xin_employee_transfer',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>