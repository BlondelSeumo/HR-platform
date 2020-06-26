<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class performance_maingoals_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_kpi_maingoals($user_id) {
        $year = date('Y');
	    return $query = $this->db->query("SELECT * FROM xin_kpi_maingoals where user_id = $user_id AND year_created = $year");
	}

    public function get_kpi_maingoals_by_year($year, $user_id) {
       return $query = $this->db->query("SELECT * FROM xin_kpi_maingoals WHERE year_created ='$year' AND user_id='$user_id'");
    }

	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_kpi_maingoals', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
    // Function to delete incidental kpi
    public function delete_maingoals_record($id){
        $this->db->where('id', $id);
        $this->db->delete('xin_kpi_maingoals');
    }

    public function read_maingoals_information($id) {
        $condition = "id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('xin_kpi_maingoals');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return null;
        }
    }

    // Function to update record in table
    public function update_maingoals_record($data, $id){
        $this->db->where('id', $id);
        if( $this->db->update('xin_kpi_maingoals',$data)) {
            return true;
        } else {
            return false;
        }       
    } 

    // Function to update maingoals approve_status field to approved
    public function approve_maingoals($id){
        $this->db->where('id', $id);
        $this->db->set('approve_status', 'approved');
        if( $this->db->update('xin_kpi_maingoals')) {
            return true;
        } else {
            return false;
        }       
    } 
}