<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_post_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 	
	// get jobs
	public function get_jobs() {
	  return $this->db->get("xin_jobs");
	}
	// get jobs/cms pages
	public function get_cms_pages() {
	  return $this->db->get("xin_job_pages");
	}
			
	// get all job candidates
	public function get_jobs_candidates() {
	  return $this->db->get("xin_job_applications");
	}
	
	// get all employee applied jobs
	public function get_employee_jobs_applied($id) {
		return $query = $this->db->query("SELECT * from xin_job_applications where user_id = '".$id."'");
	}
	// get jobs applicants
	public function get_jobs_single_candidate($id) {
		return $query = $this->db->query("SELECT * from xin_job_applications where job_id = '".$id."'");
	}
	// get employer applicants
	public function get_jobs_employer_candidate($user_id) {
		return $query = $this->db->query("SELECT * from xin_job_applications where user_id = '".$user_id."'");
	}
	
	// get all employer/company jobs
	public function get_employer_jobs($id) {
		return $query = $this->db->query("SELECT * from xin_jobs where employer_id = '".$id."' order by job_id desc");
	}
	// get all applied jobs > if available
	public function get_user_jobs_applied($id) {
		return $query = $this->db->query("SELECT j.*, a.* from xin_job_applications as a, xin_jobs as j where a.job_id=j.job_id and a.user_id = '".$id."'");
	}
	// read job info
	public function read_job_information($id) {
	
		$condition = "job_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// read job applications
	public function read_job_application_info($id) {
	
		$condition = "application_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_job_applications');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// read job info
	public function read_cms_pages($id) {
	
		$condition = "page_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_job_pages');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// 4 jobs - dashboard >>
	public function five_latest_jobs() {
	  $query = $this->db->query("SELECT * from xin_jobs limit 5");
  	  return $query->result();
	}
	
	public function read_job_infor_by_url($url) {
	
		$condition = "job_url =" . "'" . $url . "'";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// read job category info
	 public function read_job_category_info($id) {
	
		$condition = "category_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_job_categories');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all jobtype jobs
	 public function read_all_jobs_by_type() {
	
		
		$this->db->query("SET SESSION sql_mode = ''");
		$condition = "job_type !='' group by job_type";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit(1000);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all job types
	public function all_job_types() {
	  
	  $this->db->query("SET SESSION sql_mode = ''");
	  $query = $this->db->query("SELECT jt.*, j.* from xin_job_type as jt, xin_jobs as j where jt.type_url = j.type_url group by jt.job_type_id");
	  //$query = $this->db->query("SELECT jt.*, j.* from xin_job_type as jt, xin_jobs as j where jt.type_url = j.type_url");
  	  return $query->result();
	}
	
	// get all jobs by designation
	 public function read_all_jobs_by_designation() {
	
		$this->db->query("SET SESSION sql_mode = ''");
		$condition = "designation_id !='' group by designation_id";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit(1000);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// check apply jobs > remove duplicate
	 public function check_apply_job($job_id,$user_id) {
	
		$condition = "job_id='".$job_id."' and user_id='".$user_id."'";
		$this->db->select('*');
		$this->db->from('xin_job_applications');
		$this->db->where($condition);
		$this->db->limit(1);
		return $query = $this->db->get();
		
		
		// $query->result();
	}
	
	// get all interview jobs > 
	public function all_interview_jobs()
	{
	  $this->db->query("SET SESSION sql_mode = ''");
	  $query = $this->db->query("SELECT j.*, jap.* FROM xin_jobs as j, xin_job_applications as jap where j.job_id = jap.job_id group by j.job_id");
	  //$query = $this->db->query("SELECT j.*, jap.* FROM xin_jobs as j, xin_job_applications as jap where j.job_id = jap.job_id");
  	  return $query->result();
	}
	
	// read job type info
	 public function read_job_type_information($id) {
	
		$condition = "job_type_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_job_type');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all interviews
	public function all_interviews() {
	  return $this->db->get("xin_job_interviews");
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_jobs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_resume($data){
		$this->db->insert('xin_job_applications', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// get all job > frontend
	public function all_jobs() {
	  $query = $this->db->query("SELECT * from xin_jobs");
  	  return $query->result();
	}
	
	// get all job > frontend
	public function all_active_jobs() {
	  $query = $this->db->query("SELECT * from xin_jobs where status='1'");
  	  return $query->num_rows();
	}
	public function job_applications_available($job_id) {
	  $query = $this->db->query("SELECT * from xin_job_applications where job_id='".$job_id."'");
  	  return $query->num_rows();
	}
	//user_id = employer id
	public function employer_applications_available($user_id) {
	  $query = $this->db->query("SELECT * from xin_job_applications where user_id='".$user_id."'");
  	  return $query->num_rows();
	}
	
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('job_id', $id);
		$this->db->delete('xin_jobs');
		
	}
	
	// Function to Delete selected record from table
	public function delete_employer_record($id){
		$this->db->where('user_id', $id);
		$this->db->delete('xin_users');
		
	}
	
	// Function to Delete selected record from table
	public function delete_application_record($id){
		$this->db->where('application_id', $id);
		$this->db->delete('xin_job_applications');
		
	}
	
	// Function to Delete selected record from table
	public function delete_interview_record($id){
		$this->db->where('job_interview_id', $id);
		$this->db->delete('xin_job_interviews');
		
	}
	
	// get department > designations
	public function ajax_job_user_information($id) {
	
		$condition = "job_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_job_applications');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_interview($data){
		$this->db->insert('xin_job_interviews', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('job_id', $id);
		if( $this->db->update('xin_jobs',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	public function update_page_record($data, $id){
		$this->db->where('page_id', $id);
		if( $this->db->update('xin_job_pages',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	public function update_applicant_status($data, $id){
		$this->db->where('application_id', $id);
		if( $this->db->update('xin_job_applications',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>