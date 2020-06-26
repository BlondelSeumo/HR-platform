<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->library("pagination");
		$this->load->library('email');
		$this->load->model("Users_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function index() {
		
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Jobs | '.$this->Xin_model->site_title();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_job_types'] = $this->Xin_model->get_job_type();
		$data['all_jobs'] = $this->Recruitment_model->get_all_jobs_desc();
		$data['all_featured_jobs'] = $this->Recruitment_model->get_featured_jobs_last_desc();
		$data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
		$data['count_search_jobs'] = '';
		$session = $this->session->userdata('c_user_id');
		if($this->input->get("search")) {
        	$type_record_count = $this->Recruitment_model->job_search_record_count($this->input->get("search"));
			$data['count_search_jobs'] = $this->Recruitment_model->job_search_record_count($this->input->get("search"));
			$baseUrl = site_url() . "jobs/?search=".$this->input->get("search");
		} else {
			$type_record_count = $this->Recruitment_model->job_record_count();
			$data['count_search_jobs'] = $this->Recruitment_model->job_record_count();
			$baseUrl = site_url() . "jobs/";
		}

		$config = array(
			'base_url'          => $baseUrl,
			'total_rows'        => $type_record_count,
			'per_page'          => 10,
			'num_links'         => 10,
			'use_page_numbers'  => true,
			'page_query_string' => true,
			'uri_segment'       => $this->input->get("per_page"),
			'full_tag_open'     => '<ul>',
			'full_tag_close'    => '</ul>',
			'first_link'        => '<<',
			'first_tag_open'    => '<li>',
			'first_tag_close'   => '</li>',
			'last_link'         => '>>',
			'last_tag_open'     => '<li>',
			'last_tag_close'    => '</li>',
			'next_link'         => '>',
			'next_tag_open'     => '<li>',
			'next_tag_close'    => '</li>',
			'prev_link'         => '<',
			'prev_tag_open'     => '<li>',
			'prev_tag_close'    => '</li>',
			'cur_tag_open'      => '<li><a href="#" class="current-page">',
			'cur_tag_close'     => '</a></li>',
			'num_tag_open'      => '<li>',
			'num_tag_close'     => '</li>'
		);

        $this->pagination->initialize($config);

        $page = ($this->input->get("per_page")) ? $this->input->get("per_page") : 0;
       // $data["results"] = $this->Xin_recruitment_model->fetch_all_jobs($config["per_page"], $page);
		if($this->input->get("search")) {
        	$data["results"] = $this->Recruitment_model->search_fetch_all_jobs($config["per_page"], $page, $this->input->get("search"));
		} else {
			$data["results"] = $this->Recruitment_model->fetch_all_jobs($config["per_page"], $page);
		}
        $str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$data['subview'] = $this->load->view("frontend/hrsale/jobs_list", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 	 
	 public function search() {
		
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$this->uri->segment(3);
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_job_types'] = $this->Xin_model->get_job_type();
		$data['all_jobs'] = $this->Recruitment_model->get_all_jobs_desc();
		$data['all_featured_jobs'] = $this->Recruitment_model->get_featured_jobs_last_desc();
		$data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
		$session = $this->session->userdata('c_user_id');
		if($this->uri->segment(3) == 'category') {
        	$type_record_count = $this->Recruitment_model->job_category_record_count($this->uri->segment(4));
			if($type_record_count < 1){
				redirect('jobs/');
			}
			$data['count_search_jobs'] = $this->Recruitment_model->job_category_record_count($this->uri->segment(4));
		} else {
			$type_record_count = $this->Recruitment_model->job_type_record_count($this->uri->segment(4));
			if($type_record_count < 1){
				redirect('jobs/');
			}
			$data['count_search_jobs'] = $this->Recruitment_model->job_type_record_count($this->uri->segment(4));
		}
		$config = array(
			'base_url'          => site_url() . "jobs/search/".$this->uri->segment(3).'/'.$this->uri->segment(4).'/',
			'total_rows'        => $type_record_count,
			'per_page'          => 10,
			'num_links'         => 10,
			'use_page_numbers'  => true,
			'page_query_string' => false,
			'uri_segment'       => 5,
			'full_tag_open'     => '<ul>',
			'full_tag_close'    => '</ul>',
			'first_link'        => '<<',
			'first_tag_open'    => '<li>',
			'first_tag_close'   => '</li>',
			'last_link'         => '>>',
			'last_tag_open'     => '<li>',
			'last_tag_close'    => '</li>',
			'next_link'         => '>',
			'next_tag_open'     => '<li>',
			'next_tag_close'    => '</li>',
			'prev_link'         => '<',
			'prev_tag_open'     => '<li>',
			'prev_tag_close'    => '</li>',
			'cur_tag_open'      => '<li><a href="#" class="current-page">',
			'cur_tag_close'     => '</a></li>',
			'num_tag_open'      => '<li>',
			'num_tag_close'     => '</li>'
		);

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		if($this->uri->segment(3) == 'category') {
        	$data["results"] = $this->Recruitment_model->fetch_all_category_jobs($config["per_page"], $page, $this->uri->segment(4));
		} else {
			$data["results"] = $this->Recruitment_model->fetch_all_type_jobs($config["per_page"], $page, $this->uri->segment(4));
		}
        $str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$data['subview'] = $this->load->view("frontend/hrsale/jobs_search", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }	 
	 
	 public function categories() {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Browser Job Categories';
		$data['path_url'] = 'job_create';
		$session = $this->session->userdata('c_user_id');
		
		//$data['all_job_types'] = $this->Job_post_model->all_job_types();
		$data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
		$data['subview'] = $this->load->view("frontend/hrsale/job_categories", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function detail()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(3);
		$result = $this->Job_post_model->read_job_infor_by_url($id);
		if(is_null($result)){
			redirect('jobs');
		}
		$data = array(
			'path_url' => 'job_detail',
			'job_id' => $result[0]->job_id,
			'title' => $this->Xin_model->site_title(),
			'job_title' => $result[0]->job_title,
			'employer_id' => $result[0]->employer_id,
			'category_id' => $result[0]->category_id,
			'job_type_id' => $result[0]->job_type,
			'job_vacancy' => $result[0]->job_vacancy,
			'gender' => $result[0]->gender,
			'minimum_experience' => $result[0]->minimum_experience,
			'date_of_closing' => $result[0]->date_of_closing,
			'short_description' => $result[0]->short_description,
			'long_description' => $result[0]->long_description,
			'status' => $result[0]->status,
			'created_at' => $result[0]->created_at,
			'all_designations' => $this->Designation_model->all_designations(),
			'all_job_types' => $this->Job_post_model->all_job_types()
		);		
		$session = $this->session->userdata('c_user_id');
		//$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['subview'] = $this->load->view("frontend/hrsale/jobs_detail", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
	}
	
	public function apply()
	{
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('job_id');
		$result = $this->Job_post_model->read_job_information($id);
		$data = array(
				'job_id' => $result[0]->job_id,
				'job_title' => $result[0]->job_title,
				'designation_id' => $result[0]->designation_id,
				'job_type_id' => $result[0]->job_type,
				'job_vacancy' => $result[0]->job_vacancy,
				'gender' => $result[0]->gender,
				'minimum_experience' => $result[0]->minimum_experience,
				'date_of_closing' => $result[0]->date_of_closing,
				'short_description' => $result[0]->short_description,
				'long_description' => $result[0]->long_description,
				'status' => $result[0]->status,
				'all_designations' => $this->Designation_model->all_designations(),
				'all_job_types' => $this->Job_post_model->all_job_types()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('frontend/dialog_job_apply', $data);
		} else {
			redirect('home');
		}
	}
	
	// Validate and add info in database
	public function apply_job() {
	
		if($this->input->post('add_type')=='apply_job') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$user_id = $this->input->post('user_id');
		$job_id = $this->input->post('job_id');
		$message = $this->input->post('message');	
		
		// settting
		$system_setting = $this->Xin_model->read_setting_info(1);
		/* Server side PHP input validation */
		$result = $this->Recruitment_model->check_apply_job_wlog($job_id,$this->input->post('email'));
		if($result->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_already_applied_for_this_job');
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if($this->input->post('full_name')==='') {
			$Return['error'] = $this->lang->line('xin_full_name_field_error');
		} else if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($message === '') {
			$Return['error'] = $this->lang->line('xin_error_recovering_message');
		} else if($_FILES['resume']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_upload_your_resume');
		} else {
		
			if(is_uploaded_file($_FILES['resume']['tmp_name'])) {
				//checking image type
				$allowed =  explode( ',',$system_setting[0]->job_application_format);
				$filename = $_FILES['resume']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["resume"]["tmp_name"];
					$resume = "uploads/resume/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["resume"]["name"]);
					$newfilename = 'resume_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $resume.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_resume_attachment_must_be').': '.$system_setting[0]->job_application_format;
				}
			}
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$job = $this->Job_post_model->read_job_information($job_id);
		if(!is_null($job)){
			$employer_id = $job[0]->employer_id;
		} else {
			$employer_id = 0;	
		}
		$data = array(
		'job_id' => $job_id,
		'user_id' => $employer_id,
		'full_name' => $this->input->post('full_name'),
		'email' => $this->input->post('email'),
		'message' => $message,
		'job_resume' => $fname,
		'application_status' => 'Applied',
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Job_post_model->add_resume($data);
		if ($result == TRUE) {			
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			/*if($setting[0]->enable_email_notification == 'yes') {
			
				$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(11);
				
				$full_name = $this->input->post('full_name');
				// get job title
				$result = $this->Job_post_model->read_job_information($job_id);
						
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
							
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var employee_name}","{var job_title}"),array($cinfo[0]->company_name,site_url(),$full_name,$result[0]->job_title),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				$this->email->from($this->input->post('email'), $full_name);
				$this->email->to($cinfo[0]->email);
				
				$this->email->subject($subject);
				$this->email->message($message);
				
				$this->email->send();
			}*/
			$Return['result'] = $this->lang->line('xin_resume_submitted_success');			
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
}
