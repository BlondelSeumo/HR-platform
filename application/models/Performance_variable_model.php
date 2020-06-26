<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class performance_variable_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_kpi_variable($user_id) {
        $year = date('Y');
	    return $query = $this->db->query("SELECT * FROM xin_kpi_variable where user_id = $user_id AND year_created = $year");
	}

    public function get_variable_quarterly($user_id, $quarter, $year) {
        if ($quarter == 'All') {
            return $query = $this->db->query("SELECT * FROM xin_kpi_variable WHERE user_id='$user_id' AND year_created='$year'");   
        } else {
            return $query = $this->db->query("SELECT * FROM xin_kpi_variable WHERE  (user_id='$user_id' AND 
                quarter='$quarter' AND
                year_created='$year') OR
                (user_id='$user_id' AND 
                quarter <= '$quarter' AND
                status <= '2' AND
                year_created='$year')");
        }
    }

    public function get_variable_statistic($user_id, $quarter, $year) {
		if($quarter == 'All'){
			$query = $this->db->query("SELECT * FROM xin_kpi_variable WHERE user_id='$user_id' AND year_created='$year'");
		} else {
        	$query = $this->db->query("SELECT * FROM xin_kpi_variable WHERE user_id='$user_id' AND quarter='$quarter' AND year_created='$year'");
		}
        return $query;
    }

    public function get_all_variable_statistic($user_id) {
        $query = $this->db->query("SELECT * FROM xin_kpi_variable WHERE user_id='$user_id'");
        return $query;
    }

	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_kpi_variable', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
    // Function to delete incidental kpi
    public function delete_variable_record($id){
        $this->db->where('id', $id);
        $this->db->delete('xin_kpi_variable');
    }
    
    public function read_variable_information($id) {
    
        $condition = "id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('xin_kpi_variable');
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
    public function update_variable_record($data, $id){
        $this->db->where('id', $id);
        if( $this->db->update('xin_kpi_variable',$data)) {
            return true;
        } else {
            return false;
        }       
    }  

    // Function to update variable approve_status field to approved
    public function approve_variable($id){
        $this->db->where('id', $id);
        $this->db->set('approve_status', 'approved');
        if( $this->db->update('xin_kpi_variable')) {
            return true;
        } else {
            return false;
        }       
    }
}