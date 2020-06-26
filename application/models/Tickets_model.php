<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_tickets() {
	  return $this->db->get("xin_support_tickets");
	}
	 
	 public function read_ticket_information($id) {
	
		$sql = 'SELECT * FROM xin_support_tickets WHERE ticket_id = ?';
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
		$this->db->insert('xin_support_tickets', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_comment($data){
		$this->db->insert('xin_tickets_comments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_new_attachment($data){
		$this->db->insert('xin_tickets_attachment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('ticket_id', $id);
		$this->db->delete('xin_support_tickets');
		
	}
	
	// Function to Delete selected record from table
	public function delete_comment_record($id){
		$this->db->where('comment_id', $id);
		$this->db->delete('xin_tickets_comments');
		
	}
	
	// Function to Delete selected record from table
	public function delete_attachment_record($id){
		$this->db->where('ticket_attachment_id', $id);
		$this->db->delete('xin_tickets_attachment');
		
	}
	
	public function get_employees_tickets($id) {
	 	
		/*$this->db->select('st.*, ste.*');
		$this->db->from('xin_support_tickets as st, xin_support_tickets_employees as ste');
		$this->db->where('st.ticket_id=ste.ticket_id');
		$this->db->where('ste.employee_id',$id. '|| st.created_by = "'.$id.'"');
		$this->db->group_by('st.ticket_id');*/
		
		$sql = 'SELECT st.*, ste.* FROM xin_support_tickets as st, xin_support_tickets_employees as ste WHERE st.ticket_id=ste.ticket_id and (ste.employee_id = ? || st.created_by = ?)';
		$binds = array($id,$id);
		//$this->db->group_by("st.ticket_id");
		//$query = $this->db->get();
		$query = $this->db->query($sql,$binds);
		return $query;
	}
	public function get_employee_tickets($id) {		
		$sql = 'SELECT st.*, ste.* FROM xin_support_tickets as st, xin_support_tickets_employees as ste WHERE st.ticket_id=ste.ticket_id and (ste.employee_id = ? || st.created_by = ?)';
		$binds = array($id,$id);
		//$this->db->group_by("st.ticket_id");
		//$query = $this->db->get();
		$query = $this->db->query($sql,$binds);
		return $query;
	}
	public function get_company_tickets($id) {
	 	
		$sql = 'SELECT * FROM xin_support_tickets WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('xin_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function assign_ticket_user($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('xin_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_status($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('xin_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_note($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('xin_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get comments
	public function get_comments($id) {
	
		$sql = 'SELECT * FROM xin_tickets_comments WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get attachments
	public function get_attachments($id) {
	
		$sql = 'SELECT * FROM xin_tickets_attachment WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get all ticket users
	public function read_ticket_users_information($id) {
	
		$sql = 'SELECT * FROM xin_support_tickets WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	///
	// Function to add record in table
	public function add_ticket_employees($data){
		$this->db->insert('xin_support_tickets_employees', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// get ticket_employees
	public function get_ticket_employees($id) {
	
		$sql = 'SELECT * FROM xin_support_tickets_employees WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	public function update_employee_ticket_record($data, $id,$employee_id){
	
		$this->db->where('ticket_id', $id);
		$this->db->where('employee_id', $employee_id);
		if( $this->db->update('xin_support_tickets_employees',$data)) {
			return true;
		} else {
			return false;
		}
	}
	// get single record > company | employees
	 public function ajax_department_employee_info($id) {
	
		//$sql = "SELECT * FROM xin_employees WHERE company_id = ? and user_role_id!='1' and is_logged_in='1'";
		$sql = "SELECT * FROM xin_employees WHERE department_id = ? and user_role_id!='1'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}
?>