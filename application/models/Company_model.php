<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class company_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_companies() {
	  return $this->db->get("xin_companies");
	}
	
	public function get_company_documents() {
	  return $this->db->get("xin_company_documents");
	}
	
	// company types
	public function get_company_types() {
		$query = $this->db->get("xin_company_type");
		return $query->result();
	}
	public function get_company_single($company_id) {
	
		$sql = 'SELECT * FROM xin_companies WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	public function get_company_documents_single($company_id) {
	
		$sql = 'SELECT * FROM xin_company_documents WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_all_companies() {
	  $query = $this->db->get("xin_companies");
	  return $query->result();
	}
	 
	public function read_company_information($id) {
	
		$sql = 'SELECT * FROM xin_companies WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_company_type($id) {
	
		$sql = 'SELECT * FROM xin_company_type WHERE type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_company_document_info($id) {
	
		$sql = 'SELECT * FROM xin_company_documents WHERE document_id = ?';
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
		$this->db->insert('xin_companies', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_document($data){
		$this->db->insert('xin_company_documents', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('company_id', $id);
		$this->db->delete('xin_companies');
		
	}
	
	// Function to Delete selected record from table
	public function delete_doc_record($id){
		$this->db->where('document_id', $id);
		$this->db->delete('xin_company_documents');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('company_id', $id);
		if( $this->db->update('xin_companies',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without logo > in table
	public function update_record_no_logo($data, $id){
		$this->db->where('company_id', $id);
		if( $this->db->update('xin_companies',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without logo > in table
	public function update_company_document_record($data, $id){
		$this->db->where('document_id', $id);
		if( $this->db->update('xin_company_documents',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get company > departments
	public function ajax_company_departments_info($id) {
	
		$condition = "company_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_departments');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
?>