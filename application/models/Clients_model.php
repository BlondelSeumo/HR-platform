<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Clients_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_clients() {
	  return $query = $this->db->query("SELECT * from xin_clients");
	}
		
	public function get_all_clients() {
	  $query = $this->db->query("SELECT * from xin_clients");
	  return $query->result();
	}
	 
	public function read_client_info($id) {
	
		$sql = "SELECT * FROM xin_clients WHERE client_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Read data using username and password
	public function login($data) {
	
		$sql = "SELECT * FROM xin_clients WHERE email = ? AND is_active = ?";
		$binds = array($data['username'],1);
		$query = $this->db->query($sql, $binds);		
		
	    $options = array('cost' => 12);
		$password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if(password_verify($data['password'],$rw_password[0]->client_password)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	// get single user > by email
	public function read_client_info_byemail($email) {
	
		$sql = "SELECT * FROM xin_clients WHERE email = ?";
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// Read data from database to show data in admin page
	public function read_client_information($username) {
	
		$sql = "SELECT * FROM xin_clients WHERE email = ?";
		$binds = array($username);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_clients', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('client_id', $id);
		$this->db->delete('xin_clients');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('client_id', $id);
		if( $this->db->update('xin_clients',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	/// leads
	public function get_leads() {
	  return $query = $this->db->query("SELECT * from xin_leads");
	}
	public function get_lead_followup($lead_id) {
	    $sql = "SELECT * FROM xin_leads_followup WHERE lead_id = ?";
		$binds = array($lead_id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
		
	public function get_all_leads() {
	  $query = $this->db->query("SELECT * from xin_leads");
	  return $query->result();
	}
	 
	public function read_lead_info($id) {
	
		$sql = "SELECT * FROM xin_leads WHERE client_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
		
	// get single user > by email
	public function read_lead_info_byemail($email) {
	
		$sql = "SELECT * FROM xin_leads WHERE email = ?";
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// Read data from database to show data in admin page
	public function read_lead_information($username) {
	
		$sql = "SELECT * FROM xin_leads WHERE email = ?";
		$binds = array($username);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	// Read data from database to show data in admin page
	public function read_lead_followup_info($leads_followup_id) {
	
		$sql = "SELECT * FROM xin_leads_followup WHERE leads_followup_id = ?";
		$binds = array($leads_followup_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_lead($data){
		$this->db->insert('xin_leads', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// Function to add record in table
	public function add_lead_followup($data){
		$this->db->insert('xin_leads_followup', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_lead_record($id){
		$this->db->where('client_id', $id);
		$this->db->delete('xin_leads');
		
	}
	// Function to Delete selected record from table
	public function delete_lead_followup($id){
		$this->db->where('leads_followup_id', $id);
		$this->db->delete('xin_leads_followup');
		
	}
	// Function to Delete selected record from table
	public function delete_main_lead_followup($id){
		$this->db->where('lead_id', $id);
		$this->db->delete('xin_leads_followup');
		
	}
	
	// Function to update record in table
	public function update_lead_record($data, $id){
		$this->db->where('client_id', $id);
		if( $this->db->update('xin_leads',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to update record in table
	public function update_lead_followup_record($data, $id){
		$this->db->where('leads_followup_id', $id);
		if( $this->db->update('xin_leads_followup',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// get total leads
	public function get_total_leads() {
	
		$sql = "SELECT * FROM xin_leads";
		$query = $this->db->query($sql);		
		return $query->num_rows();
	}
	// get total clients
	public function get_total_clients() {
	
		$sql = "SELECT * FROM xin_clients";
		$query = $this->db->query($sql);		
		return $query->num_rows();
	}
	// get total client convert
	public function get_total_client_convert() {
	
		$sql = "SELECT * FROM xin_leads WHERE is_changed = ?";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get total pending followup
	public function get_total_pending_followup() {
	
		$query = $this->db
              ->select('lead_id')
              ->group_by('lead_id')
              ->get('xin_leads_followup');
		return $query->num_rows();
	}
	// get lead followup
	public function get_total_lead_followup($lead_id) {
	
		$sql = "SELECT * FROM xin_leads_followup WHERE lead_id = ?";
		$binds = array($lead_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
}
?>