<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class employee_exit_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_exit()
	{
	  return $this->db->get("xin_employee_exit");
	}
	 
	 public function read_exit_information($id) {
	
		$sql = 'SELECT * FROM xin_employee_exit WHERE exit_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// filter company exit
	public function filter_company_exit($company_id) {
	
		$sql = 'SELECT * FROM xin_employee_exit WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// filter company|employee exit
	public function filter_company_employee_exit($company_id,$employee_id) {
	
		$sql = 'SELECT * FROM xin_employee_exit WHERE company_id = ? and employee_id = ?';
		$binds = array($company_id,$employee_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// filter company|employee|interview exit
	public function filter_company_employee_status_exit($company_id,$employee_id,$exit_interview) {
	
		$sql = 'SELECT * FROM xin_employee_exit WHERE company_id = ? and employee_id = ? and exit_interview = ?';
		$binds = array($company_id,$employee_id,$exit_interview);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// filter company|interview exit
	public function filter_company_notemployee_status_exit($company_id,$exit_interview) {
	
		$sql = 'SELECT * FROM xin_employee_exit WHERE company_id = ? and exit_interview = ?';
		$binds = array($company_id,$exit_interview);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_exit_type_information($id) {
	
		$sql = 'SELECT * FROM xin_employee_exit_type WHERE exit_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_exit_types() {
	  $query = $this->db->query("SELECT * from xin_employee_exit_type");
  	  return $query->result();
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_employee_exit', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('exit_id', $id);
		$this->db->delete('xin_employee_exit');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('exit_id', $id);
		if( $this->db->update('xin_employee_exit',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>