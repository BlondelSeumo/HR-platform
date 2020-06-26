<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_files()
	{
	  return $this->db->get("xin_file_manager");
	} 
	 
	 public function read_file_information($id) {
	
		$condition = "file_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_file_manager');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function department_files($id)
	{
	  return $this->db->query("SELECT * from xin_file_manager where department_id = '".$id."'");
	}
	
	public function get_employee_awards($id) {
	 	return $query = $this->db->query("SELECT * from xin_awards where employee_id = '".$id."'");
	}
	
	public function read_award_information($id) {
	
		$condition = "award_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_awards');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_file_manager', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('file_id', $id);
		$this->db->delete('xin_file_manager');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('file_id', $id);
		if( $this->db->update('xin_file_manager',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_file_record($data, $id){
		$this->db->where('setting_id', $id);
		if( $this->db->update('xin_file_manager_settings',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	function format_size_units($bytes) {
		
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}
}
?>