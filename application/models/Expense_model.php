<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class expense_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
 	// get all expenses
	public function get_expenses() {
	  return $this->db->get("xin_expenses");
	}
	
	// get employee claim expense
	public function get_employee_expenses() {
	  	
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_expenses WHERE employee_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);
		
  	 	return $query;
	}
	
	// get total number of expenses
	public function get_total_expenses() {
	  $query = $this->db->query("SELECT SUM(amount) as exp_amount FROM xin_expenses");
  	  return $query->result();
	}
	
	// get total number of finance expenses
	public function get_total_finance_expenses() {
	  $query = $this->db->query("SELECT SUM(amount) as exp_amount FROM xin_finance_transaction where transaction_type = 'expense'");
  	  return $query->result();
	}
	 
	 public function read_expense_information($id) {
	
		$sql = 'SELECT * FROM xin_expenses WHERE expense_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function read_expense_type_information($id) {
	
		$sql = 'SELECT * FROM xin_expense_type WHERE expense_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all expense types
	public function all_expense_types()
	{
	  $query = $this->db->query("SELECT * from xin_expense_type");
  	  return $query->result();
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_expenses', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('expense_id', $id);
		$this->db->delete('xin_expenses');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('expense_id', $id);
		if( $this->db->update('xin_expenses',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without logo > in table
	public function update_record_no_logo($data, $id){
		$this->db->where('expense_id', $id);
		if( $this->db->update('xin_expenses',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>