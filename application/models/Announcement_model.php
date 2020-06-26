<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class announcement_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_announcements()
	{
	  return $this->db->get("xin_announcements");
	}
	
	public function get_new_announcements() {
		$query = $this->db->query("SELECT * from xin_announcements");
		return $query->result();
	}
	public function get_company_announcements($company_id) {
	
		$sql = 'SELECT * FROM xin_announcements WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	public function get_department_announcements($department_id) {
	
		$sql = 'SELECT * FROM xin_announcements WHERE department_id = ?';
		$binds = array($department_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	 public function read_announcement_information($id) {
	
		$sql = 'SELECT * FROM xin_announcements WHERE announcement_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_announcements', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('announcement_id', $id);
		$this->db->delete('xin_announcements');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('announcement_id', $id);
		if( $this->db->update('xin_announcements',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>