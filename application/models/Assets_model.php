<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Assets_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_assets_categories() {
	  return $this->db->get("xin_assets_categories");
	}
	
	public function get_assets() {
	  return $this->db->get("xin_assets");
	}
	
	public function get_employee_assets($id) {
		
		//$id = $this->db->escape($id);
		$sql = 'SELECT * FROM xin_assets WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
	 	return $query;
	}
	public function get_company_assets($company_id) {
	
		$sql = 'SELECT * FROM xin_assets WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
		
	public function get_all_assets_categories() {
	  $query = $this->db->get("xin_assets_categories");
	  return $query->result();
	}
	 
	public function read_assets_info($id) {
	
		$sql = 'SELECT * FROM xin_assets WHERE assets_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function read_assets_category_info($id) {
	
		$sql = 'SELECT * FROM xin_assets_categories WHERE assets_category_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_asset($data){
		$this->db->insert('xin_assets', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_assets_category($data){
		$this->db->insert('xin_assets_categories', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
		
	// Function to Delete selected record from table
	public function delete_assets_record($id){
		$this->db->where('assets_id', $id);
		$this->db->delete('xin_assets');
		
	}
	
	// Function to Delete selected record from table
	public function delete_assets_category_record($id){
		$this->db->where('assets_category_id', $id);
		$this->db->delete('xin_assets_categories');
		
	}
	
	// Function to update record in table
	public function update_assets_record($data, $id){
		$this->db->where('assets_id', $id);
		if( $this->db->update('xin_assets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_assets_category_record($data, $id){
		$this->db->where('assets_category_id', $id);
		if( $this->db->update('xin_assets_categories',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without photo > in table
	public function update_record_no_photo($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_users',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>