<?php
	
class Recruitment_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	// get single employer
	public function read_employer_info($id) {
	
		$sql = 'SELECT * FROM xin_users WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}
	public function get_all_employers() {
		$query = $this->db->query("SELECT * FROM xin_users where is_active='1'");
		return $query->result();
	}
	
	// get all jobs
	public function get_all_jobs() {
	  $query = $this->db->get("xin_jobs");
	  return $query->num_rows();
	}
	
	// get all jobs
	public function get_all_jobs_desc() {
	
		$query = $this->db->query("SELECT * FROM xin_jobs order by job_id desc");
		return $query->result();
	}
	
	// get last 5 jobs
	public function get_all_jobs_last_desc() {
	
		$query = $this->db->query("SELECT * FROM xin_jobs order by job_id desc limit 5");
		return $query->result();
	}
	
	// get last 5 featured jobs
	public function get_featured_jobs_last_desc() {
	
		$query = $this->db->query("SELECT * FROM xin_jobs where is_featured = '1' order by job_id desc limit 5");
		return $query->result();
	}
	// get all job categories
	public function all_job_categories() {
		//$query = $this->db->query("SELECT jc.*, j.* FROM xin_job_categories as jc, xin_jobs as j where jc.category_id = j.category_id group by jc.category_id");
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT * FROM xin_job_categories");
		 return $query->result();
	}
	
	// get all job categories
	public function first_job_categories() {
		 $this->db->query("SET SESSION sql_mode = ''");
		 $query = $this->db->query("SELECT jc.*, j.* FROM xin_job_categories as jc, xin_jobs as j where jc.category_id = j.category_id group by jc.category_id limit 6");
		 //$query = $this->db->query("SELECT jc.*, j.* FROM xin_job_categories as jc, xin_jobs as j where jc.category_id = j.category_id limit 6");
		 return $query->result();
	}
	
	//Function definition
	function timeAgo($timestamp)  
	 {  
		  $time_ago = strtotime($timestamp);  
		  $current_time = time();  
		  $time_difference = $current_time - $time_ago;  
		  $seconds = $time_difference;  
		  $minutes      = round($seconds / 60 );           // value 60 is seconds  
		  $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
		  $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
		  $weeks          = round($seconds / 604800);          // 7*24*60*60;  
		  $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
		  $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
		  if($seconds <= 60)  
		  {  
		 return "Just Now";  
	   }  
		  else if($minutes <=60)  
		  {  
		 if($minutes==1)  
			   {  
		   return "one minute ago";  
		 }  
		 else  
			   {  
		   return "$minutes minutes ago";  
		 }  
	   }  
		  else if($hours <=24)  
		  {  
		 if($hours==1)  
			   {  
		   return "an hour ago";  
		 }  
			   else  
			   {  
		   return "$hours hrs ago";  
		 }  
	   }  
		  else if($days <= 7)  
		  {  
		 if($days==1)  
			   {  
		   return "yesterday";  
		 }  
			   else  
			   {  
		   return "$days days ago";  
		 }  
	   }  
		  else if($weeks <= 4.3) //4.3 == 52/12  
		  {  
		 if($weeks==1)  
			   {  
		   return "a week ago";  
		 }  
			   else  
			   {  
		   return "$weeks weeks ago";  
		 }  
	   }  
		   else if($months <=12)  
		  {  
		 if($months==1)  
			   {  
		   return "a month ago";  
		 }  
			   else  
			   {  
		   return "$months months ago";  
		 }  
	   }  
		  else  
		  {  
		 if($years==1)  
			   {  
		   return "one year ago";  
		 }  
			   else  
			   {  
		   return "$years years ago";  
		 }  
	   }  
	 }
	 // get single category
	 public function read_category_info($id) {
	
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
	// get single main page
	 public function read_main_page_info($url) {
	
		$condition = "page_url =" . "'" . $url . "'";
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
	
	public function job_record_count() {
        return $this->db->count_all("xin_jobs");
    }
	
	public function job_search_record_count($search) {
	  $query = $this->db->query("SELECT * from xin_jobs where job_title like '%".$search."%' and status='1'");
  	  return $query->num_rows();
	}
	
	public function job_category_record_count($find) {
		$csql = "SELECT * FROM xin_job_categories WHERE category_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$category_info = $cquery->result();
		$query = $this->db->query("SELECT * from xin_jobs where category_id = '".$category_info[0]->category_id."' and status='1'");
		return $query->num_rows();
	}
	
	public function job_type_record_count($find) {
		$csql = "SELECT * FROM xin_job_type WHERE type_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$type_info = $cquery->result();
		$query = $this->db->query("SELECT * from xin_jobs where job_type = '".$type_info[0]->job_type_id."' and status='1'");
		return $query->num_rows();
	}
	
	public function fetch_all_category_jobs($limit, $start, $find) {
        
		$csql = "SELECT * FROM xin_job_categories WHERE category_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$category_info = $cquery->result();
		
		$condition = "status ='1' and category_id = '".$category_info[0]->category_id."' order by job_id desc";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   public function fetch_all_type_jobs($limit, $start, $find) {
        
		$csql = "SELECT * FROM xin_job_type WHERE type_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$type_info = $cquery->result();
		$condition = "status ='1' and job_type = '".$type_info[0]->job_type_id."' order by job_id desc";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
   public function search_fetch_all_jobs($limit, $start, $search) {
        
		$condition = "job_title like '%".$search."%' and status ='1' order by job_id desc";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
   }
   
    public function fetch_all_jobs($limit, $start) {
        
		$condition = "status ='1' order by job_id desc";
		$this->db->select('*');
		$this->db->from('xin_jobs');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

        return $query->result();
       // return false;
   }
	
	// get single sub page
	 public function read_sub_page_info($id) {
	
		$condition = "subpages_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_recruitment_subpages');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// check apply jobs > remove duplicate
	 public function check_apply_job_wlog($job_id,$user_id) {
	
		$sql = 'SELECT * from xin_job_applications where job_id = ? and email = ?';
		$binds = array($job_id,$user_id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function check_jobs_applications($job_id) {
		$query = $this->db->query("SELECT * from xin_job_applications where job_id = '".$job_id."'");
		return $query->num_rows();
	}
	// get all employee applied jobs
	public function get_candidates_jobs_applied($url) {
		$result = $this->Job_post_model->read_job_infor_by_url($url);
		return $query = $this->db->query("SELECT * from xin_job_applications where job_id = '".$result[0]->job_id."'");
	}
	public function get_employers() {
		$query = $this->db->query("SELECT * FROM xin_users where is_active='1'");
		return $query;
	}
}