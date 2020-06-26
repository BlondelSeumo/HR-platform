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
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$data['title'] = $this->Xin_model->site_title();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_job_types'] = $this->Job_post_model->all_job_types();
		$data['all_jobs'] = $this->Job_post_model->all_jobs();
		$data['all_jobs_by_designation'] = $this->Job_post_model->read_all_jobs_by_designation();
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
			$this->load->view("frontend/jobs", $data);
		} else {
			redirect('admin/');
		}
     }
	 
	 public function detail()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Job_post_model->read_job_information($id);
		if(is_null($result)){
			//redirect('admin/job_post');
		}
		$data = array(
				'job_id' => $result[0]->job_id,
				'title' => $this->Xin_model->site_title(),
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
				'created_at' => $result[0]->created_at,
				'all_designations' => $this->Designation_model->all_designations(),
				'all_job_types' => $this->Job_post_model->all_job_types()
				);
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
			$this->load->view('frontend/job_details', $data);
		} else {	
			redirect('admin/');
		}
	}
	
	public function apply()
	{
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
			redirect('');
		}
	}
	
	// Validate and add info in database
	public function apply_job() {
	
		if($this->input->post('add_type')=='apply_job') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$user_id = $this->input->post('user_id');
		$job_id = $this->uri->segment(4);
		$message = $this->input->post('message');	
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		// settting
		$system_setting = $this->Xin_model->read_setting_info(1);
		/* Server side PHP input validation */
		$result = $this->Job_post_model->check_apply_job($job_id,$user_id);
		if($result->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_already_applied_for_this_job');
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if($_FILES['resume']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_upload_your_resume');
		} else if($message == '') {
			$Return['error'] = $this->lang->line('xin_error_recovering_message');
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
	
		$data = array(
		'job_id' => $job_id,
		'user_id' => $user_id,
		'message' => $message,
		'job_resume' => $fname,
		'application_status' => 'Applied',
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Job_post_model->add_resume($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_resume_submitted');
			
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {
			
				$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(11);
				//get employee info
				$user_info = $this->Xin_model->read_user_info($this->input->post('user_id'));
				
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				// get job title
				$result = $this->Job_post_model->read_job_information($job_id);
						
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
							
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var employee_name}","{var job_title}"),array($cinfo[0]->company_name,site_url(),$full_name,$result[0]->job_title),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				$this->email->from($user_info[0]->email, $full_name);
				$this->email->to($cinfo[0]->email);
				
				$this->email->subject($subject);
				$this->email->message($message);
				
				$this->email->send();
			}
			
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
}
