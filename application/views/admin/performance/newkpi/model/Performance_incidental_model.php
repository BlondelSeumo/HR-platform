<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class performance_incidental_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_kpi_incidental($user_id) {
        $year = date('Y');
	    return $query = $this->db->query("SELECT * FROM xin_kpi_incidental where user_id = $user_id AND year_created = $year");
	}

    public function get_incidental_quarterly($user_id, $quarter, $year) {
        if ($quarter == 'All') {
            return $query = $this->db->query("SELECT * FROM xin_kpi_incidental WHERE user_id='$user_id' AND year_created='$year'");
        } else {
            return $query = $this->db->query("SELECT * FROM xin_kpi_incidental WHERE 
                                    (user_id='$user_id' AND 
                                    quarter='$quarter' AND
                                    year_created='$year') OR
                                    (user_id='$user_id' AND 
                                    quarter <= '$quarter' AND
                                    status <= '2' AND
                                    year_created='$year')");
        }
    }

	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_kpi_incidental', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

    // Function to delete incidental kpi
    public function delete_incidental_record($id){
        $this->db->where('id', $id);
        $this->db->delete('xin_kpi_incidental');
    }
	
    public function read_incidental_information($id) {
    
        $condition = "id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('xin_kpi_incidental');
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
    public function update_incidental_record($data, $id){
        $this->db->where('id', $id);
        if( $this->db->update('xin_kpi_incidental',$data)) {
            return true;
        } else {
            return false;
        }       
    }   
}