<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class performance_report_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_variable_statistic($user_id, $quarter, $year) {
        $query = $this->db->query("SELECT * FROM xin_kpi_variable WHERE 
                                    user_id='$user_id' AND
                                    quarter='$quarter' AND
                                    year_created='$year'");
        return $query;
    }

    public function get_incidental_statistic($user_id, $quarter, $year) {
        $query = $this->db->query("SELECT * FROM xin_kpi_incidental WHERE 
                                    user_id='$user_id' AND
                                    quarter='$quarter' AND
                                    year_created='$year'");
        return $query;
    }

    public function get_all_variable($user_id, $year) {
        $query = $this->db->query("SELECT * FROM xin_kpi_variable WHERE
                                    user_id='$user_id' AND
                                    year_created='$year'");
        return $query;
    }

    public function get_all_incidental($user_id, $year) {
        $query = $this->db->query("SELECT * FROM xin_kpi_incidental WHERE
                                    user_id='$user_id' AND
                                    year_created='$year'");
        return $query;
    }
}