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

class View_applicants extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
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
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_job_candidates').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_job_candidates');
		$data['path_url'] = 'job_candidates';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/job_candidates", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
 
    public function candidate_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/job_candidates", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('387',$role_resources_ids)) {
			$candidates = $this->Job_post_model->get_employee_jobs_applied($session['user_id']);
		} else {
			$candidates = $this->Job_post_model->get_jobs_candidates();
		}
		
		$data = array();

        foreach($candidates->result() as $r) {
		// get job title
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '-';	
		}
		// get date
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		
		if(in_array('294',$role_resources_ids)) { //download
			$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'">
			<a href="'.site_url('admin/download').'?type=resume&filename='.$r->job_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
		} else {
			$download = '';
		}
		if(in_array('295',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
		} else {
			$delete = '';
		}
		$iticket_code = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
		$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '">'.$this->lang->line('xin_view').'</button></a>';
		$combhr = $download.$delete;
		
		$data[] = array(
			$combhr,
			$job_title,
			$r->full_name,
			$cover_letter,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $candidates->num_rows(),
			 "recordsFiltered" => $candidates->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read_application()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('application_id');
		$result = $this->Job_post_model->read_job_application_info($id);
		$data = array(
				'application_id' => $result[0]->application_id,
				'job_id' => $result[0]->job_id,
				'message' => $result[0]->message
				);
		if(!empty($session)){ 
			$this->load->view('admin/job_post/dialog_application', $data);
		} else {
			redirect('admin/');
		}
	}
	 	
	// delete job candidate / job application	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Job_post_model->delete_application_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_error_job_application');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
