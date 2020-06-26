<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_fields_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
	// get hrsale module attributes
	public function get_hrsale_module_attributes() {
		return $this->db->get("xin_hrsale_module_attributes");
	}
	 
	 public function read_hrsale_module_attributes($id) {
	
		$sql = 'SELECT * FROM xin_hrsale_module_attributes WHERE custom_field_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function get_attribute_selection_values($id) {
	
		$sql = 'SELECT * FROM xin_hrsale_module_attributes_select_value WHERE custom_field_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_hrsale_module_attributes', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add_select_value($data){
		$this->db->insert('xin_hrsale_module_attributes_select_value', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table> attribute values
	public function add_values($data){
		$this->db->insert('xin_hrsale_module_attributes_values', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function read_hrsale_module_attributes_values($user_id,$id) {
	
		$sql = 'SELECT * FROM xin_hrsale_module_attributes_values WHERE module_attributes_id = ? and user_id = ?';
		$binds = array($id,$user_id);
		$query = $this->db->query($sql, $binds)->row();
		return $query;
	}
	public function get_employee_custom_data($user_id,$module_attributes_id) {
	
		$this->db->select('*');
		$this->db->from('xin_hrsale_module_attributes_values');
		$this->db->where('module_attributes_id', $module_attributes_id);
		$this->db->where('user_id', $user_id);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return null;
		}
		
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('custom_field_id', $id);
		$this->db->delete('xin_hrsale_module_attributes');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('custom_field_id', $id);
		if( $this->db->update('xin_hrsale_module_attributes',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table>custom fields
	public function update_att_record($data, $user_id,$module_attributes_id){
		$this->db->where('module_attributes_id', $module_attributes_id);
		$this->db->where('user_id', $user_id);
		if( $this->db->update('xin_hrsale_module_attributes_values',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// count data
	public function count_module_attributes_values($user_id,$module_attributes_id){
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes_values where module_attributes_id = '".$module_attributes_id."' and user_id = '".$user_id."'");
  	  return $query->num_rows();
	}
	
	// get all hrsale module attributes
	public function all_hrsale_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '1' order by priority asc");
  	  return $query->result();
	}
	// get all hrsale module attributes>count
	public function count_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '1'");
  	  return $query->num_rows();
	}
	// get all hrsale module attributes>Awards
	public function awards_hrsale_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '2' order by priority asc");
  	  return $query->result();
	}
	// get all hrsale module attributes>count
	public function count_awards_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '2'");
  	  return $query->num_rows();
	}
	public function announcements_hrsale_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '3' order by priority asc");
  	  return $query->result();
	}
	// get all hrsale module attributes>count
	public function count_announcements_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '3'");
  	  return $query->num_rows();
	}
	public function company_hrsale_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '4' order by priority asc");
  	  return $query->result();
	}
	// get all hrsale module attributes>count
	public function count_company_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '4'");
  	  return $query->num_rows();
	}
	public function training_hrsale_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '5' order by priority asc");
  	  return $query->result();
	}
	// get all hrsale module attributes>count
	public function count_training_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '5'");
  	  return $query->num_rows();
	}
	public function tickets_hrsale_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '6' order by priority asc");
  	  return $query->result();
	}
	// get all hrsale module attributes>count
	public function count_tickets_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '6'");
  	  return $query->num_rows();
	}
	public function assets_hrsale_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '7' order by priority asc");
  	  return $query->result();
	}
	// get all hrsale module attributes>count
	public function count_assets_module_attributes() {
	  $query = $this->db->query("SELECT * from xin_hrsale_module_attributes where `module_id` = '7'");
  	  return $query->num_rows();
	}
}
?>