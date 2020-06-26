<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_events()
	{
	  return $this->db->get("xin_events");
	}
	 
	 public function read_event_information($id) {
	
		$sql = 'SELECT * FROM xin_events WHERE event_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}	
	public function get_company_events($company_id) {
	
		$sql = 'SELECT * FROM xin_events WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}	
	public function get_employee_events($id) {
		
		$sql = "SELECT * FROM xin_events WHERE employee_id like '%$id,%' or employee_id like '%,$id%' or employee_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query;
	}
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_events', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_event_record($id){
		$this->db->where('event_id', $id);
		$this->db->delete('xin_events');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('event_id', $id);
		if( $this->db->update('xin_events',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>