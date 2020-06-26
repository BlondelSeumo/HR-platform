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

class Job_interviews extends MY_Controller {
	
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
		$data['title'] = $this->lang->line('left_job_interviews').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_interview_jobs'] = $this->Job_post_model->all_interview_jobs();
		$data['breadcrumbs'] = $this->lang->line('left_job_interviews');
		$data['path_url'] = 'job_interviews';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('52',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/job_interviews", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
     }
 
    public function interview_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/job_interviews", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$interview = $this->Job_post_model->all_interviews();
		
		$data = array();

        foreach($interview->result() as $r) {
			if(in_array('388',$role_resources_ids)) {
				$aim = explode(',',$r->interviewees_id);
				foreach($aim as $dIds) {
				if($session['user_id'] == $dIds) {
				
				// get job title
				$job = $this->Job_post_model->read_job_information($r->job_id);
				if(!is_null($job)){
					$job_title = $job[0]->job_title;
				} else {
					$job_title = '--';	
				}
				// get date
				$interview_date = $this->Xin_model->set_date_format($r->interview_date);			
				// get time
				$interview_time = $r->interview_date.' '.$r->interview_time;
				$interview_ex_time =  new DateTime($interview_time);
				$int_time = $interview_ex_time->format('h:i a');
				
				// interview date and time
				$interview_d_t = $interview_date.' '.$int_time;
				// interview added by
				$u_added = $this->Xin_model->read_user_info($r->added_by);
				// user full name
				if(!is_null($u_added)){
					$int_addedby = $u_added[0]->first_name. ' '.$u_added[0]->last_name;
				} else {
					$int_addedby = '--';	
				}
				// interview message
				$description = html_entity_decode($r->description);
				$data[] = array(
					'<a href="'.site_url().'frontend/jobs/detail/'.$r->job_id.'/" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a>',
					$job_title,
					$description,
					$r->interview_place,
					$interview_d_t,
					$int_addedby
				);
			  }
			} // e-interviews
		} else {
			// get job title
			$job = $this->Job_post_model->read_job_information($r->job_id);
			if(!is_null($job)){
				$job_title = $job[0]->job_title;
			} else {
				$job_title = '--';	
			}
			// get date
			$interview_date = $this->Xin_model->set_date_format($r->interview_date);		
			// get interviewees
			if($r->interviewees_id == '') {
				$interviewees = '-';
			} else {
				$interviewees = '<ol class="nl">';
					foreach(explode(',',$r->interviewees_id) as $interviewees_id) {
					$user_intwee = $this->Xin_model->read_user_info($interviewees_id);
						if(!is_null($user_intwee)){
							$interviewees .= '<li>'.$user_intwee[0]->first_name. ' '.$user_intwee[0]->last_name.'</li>';
						} else {
							$interviewees .= '';	
						}
					}
				$interviewees .= '</ol>';
			}
			
			// get interviewers
			if($r->interviewers_id == '') {
				$interviewers = '-';
			} else {
				$interviewers = '<ol class="nl">';
				foreach(explode(',',$r->interviewers_id) as $interviewers_id) {
					$user_intwer = $this->Xin_model->read_user_info($interviewers_id);
						if(!is_null($user_intwer)){
							$interviewers .= '<li>'.$user_intwer[0]->first_name. ' '.$user_intwer[0]->last_name.'</li>';
						} else {
							$interviewers .= '';	
						}
					}
					$interviewers .= '</ol>';
				}
				
				// get time
				$interview_time = $r->interview_date.' '.$r->interview_time;
				$interview_ex_time =  new DateTime($interview_time);
				$int_time = $interview_ex_time->format('h:i a');
				
				// interview date and time
				$interview_d_t = $interview_date.' '.$int_time;
				// interview added by
				$u_added = $this->Xin_model->read_user_info($r->added_by);
				// user full name
				if(!is_null($u_added)){
					$int_addedby = $u_added[0]->first_name. ' '.$u_added[0]->last_name;
				} else {
					$int_addedby = '--';	
				}		
				
				if(in_array('297',$role_resources_ids)) { // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->job_interview_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$delete = '';
				}
				
				$data[] = array(
					$delete,
					$job_title,
					$interviewees,
					$r->interview_place,
					$interview_d_t,
					$interviewers,
					$int_addedby
				);
			}
		
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $interview->num_rows(),
			 "recordsFiltered" => $interview->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 	
	// Validate and add info in database
	public function add_interview() {
	
		if($this->input->post('add_type')=='interview') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');	
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('job_id')==='') {
       		$Return['error'] = $this->lang->line('xin_interview_job_post');
		} else if($this->input->post('interview_date')==='') {
			$Return['error'] = $this->lang->line('xin_interview_job_interview_date');
		} else if($this->input->post('interviewees')==='') {
			$Return['error'] = $this->lang->line('xin_interview_job_candidate');
		} else if($this->input->post('interview_place')==='') {
			$Return['error'] = $this->lang->line('xin_interview_job_interview_place');
		} else if($this->input->post('interview_time')==='') {
       		$Return['error'] = $this->lang->line('xin_interview_job_interview_time');
		} else if($this->input->post('interviewers')==='') {
       		$Return['error'] = $this->lang->line('xin_interview_job_interviewers');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if($this->input->post('interviewees')!=='') {
			$interviewees_ids = implode(',',$this->input->post('interviewees'));
		} else {
			$interviewees_ids = '';
		}
		
		if($this->input->post('interviewers')!=='') {
			$interviewers_ids = implode(',',$this->input->post('interviewers'));
		} else {
			$interviewers_ids = '';
		}
	
		$data = array(
		'job_id' => $this->input->post('job_id'),
		'interview_date' => $this->input->post('interview_date'),
		'interviewees_id' => $interviewees_ids,
		'description' => $qt_description,
		'interview_place' => $this->input->post('interview_place'),
		'interview_time' => $this->input->post('interview_time'),
		'interviewers_id' => $interviewers_ids,
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('Y-m-d h:i:s')		
		);
		
		$result = $this->Job_post_model->add_interview($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_job_interview_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}	
	
	// get job employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'job_id' => $id,
			'all_employees' => $this->Xin_model->all_employees(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/get_job_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$result = $this->Job_post_model->delete_interview_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_job_interview_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
