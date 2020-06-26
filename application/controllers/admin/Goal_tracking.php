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

class Goal_tracking extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Xin_model");
		$this->load->model("Goal_tracking_model");
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
		if($system[0]->module_goal_tracking!='true'){
			redirect('admin/dashboard');
		}
		/*if($system[0]->performance_option!='goal'){
			redirect('admin/performance_appraisal');
		}*/
		$data['title'] = $this->lang->line('xin_hr_goal_tracking').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_goal_tracking');
		$data['path_url'] = 'goal_tracking';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_tracking_types'] = $this->Goal_tracking_model->all_tracking_types();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('107',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/goal_tracking/goal_tracking_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 public function type()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_goal_tracking!='true'){
			redirect('admin/dashboard');
		}
		/*if($system[0]->performance_option!='goal'){
			redirect('admin/performance_appraisal');
		}*/
		$data['title'] = $this->lang->line('xin_hr_goal_tracking_type').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_goal_tracking_type');
		$data['path_url'] = 'goal_tracking_type';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('108',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/goal_tracking/goal_tracking_type", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }

	//goal calendar
	public function calendar() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_goal_tracking!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_hr_goal_tracking_calendar_se');
		$data['breadcrumbs'] = $this->lang->line('xin_hr_goal_tracking_calendar_se');
		$data['all_goals_completed'] = $this->Goal_tracking_model->all_goals_completed();
		$data['all_goals_inprogress'] = $this->Goal_tracking_model->all_goals_inprogress();
		$data['all_goals_not_started'] = $this->Goal_tracking_model->all_goals_not_started();
		$data['path_url'] = 'event_calendar';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('109',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/goal_tracking/calendar_goal", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
    public function type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/goal_tracking/goal_tracking_type", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$tracking_type = $this->Goal_tracking_model->get_goal_tracking_type();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

        foreach($tracking_type->result() as $r) {
			
			if(in_array('339',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-tracking_type_id="'. $r->tracking_type_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('340',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tracking_type_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		
		$combhr = $edit.$delete;	
		$data[] = array(
			$combhr,
			$r->type_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $tracking_type->num_rows(),
			 "recordsFiltered" => $tracking_type->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function goal_tracking_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/goal_tracking/goal_tracking_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$tracking = $this->Goal_tracking_model->get_goal_tracking();
		} else {
			$tracking = $this->Goal_tracking_model->get_company_goal_tracking($user_info[0]->company_id);
		}
		$data = array();

        foreach($tracking->result() as $r) {
			
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
			 	$comp_name = '--';	
			}
			// get tracking type
			$type = $this->Goal_tracking_model->read_tracking_type_information($r->tracking_type_id);
			if(!is_null($type)){
				$itype = $type[0]->type_name;
			} else {
				$itype = '--';	
			}
			// get start date
			$start_date = $this->Xin_model->set_date_format($r->start_date);
			// get end date
			$end_date = $this->Xin_model->set_date_format($r->end_date);
			
			//project_progress
			if($r->goal_progress <= 20) {
				$progress_class = 'bg-danger';
			} else if($r->goal_progress > 20 && $r->goal_progress <= 50){
				$progress_class = 'bg-warning';
			} else if($r->goal_progress > 50 && $r->goal_progress <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			// progress
			$pbar = '<p class="mb-1">'.$this->lang->line('xin_completed').' '.$r->goal_progress.'%</p><div class="progress"><div class="progress-bar '.$progress_class.' progress-sm" style="width: '.$r->goal_progress.'%;"></div></div>';
			//$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->goal_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->goal_progress.'" max="100">'.$r->goal_progress.'%</progress>';
			if(in_array('335',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-tracking_id="'. $r->tracking_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('336',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tracking_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('337',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-tracking_id="'. $r->tracking_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;	
			$iitype = $itype.'<br><small class="text-muted"><i>'.$this->lang->line('xin_subject').': '.$r->subject.'<i></i></i></small>';
			
			$data[] = array(
			$combhr,
			$iitype,
			$comp_name,
			$r->target_achiement,
			$start_date,
			$end_date,
			$pbar,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $tracking->num_rows(),
			 "recordsFiltered" => $tracking->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	public function read_goal()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('tracking_id');
		$result = $this->Goal_tracking_model->read_goal_information($id);
		$data = array(
				'title' => $this->Xin_model->site_title(),
				'tracking_id' => $result[0]->tracking_id,
				'company_id' => $result[0]->company_id,
				'tracking_type_id' => $result[0]->tracking_type_id,
				'subject' => $result[0]->subject,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'target_achiement' => $result[0]->target_achiement,
				'goal_progress' => $result[0]->goal_progress,
				'goal_status' => $result[0]->goal_status,
				'description' => $result[0]->description,
				'all_tracking_types' => $this->Goal_tracking_model->all_tracking_types(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/goal_tracking/dialog_tracking_goal', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_type()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('tracking_type_id');
		$result = $this->Goal_tracking_model->read_tracking_type_information($id);
		$data = array(
				'tracking_type_id' => $result[0]->tracking_type_id,
				'type_name' => $result[0]->type_name,
				'all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/goal_tracking/dialog_tracking_type', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_tracking() {
	
		if($this->input->post('add_type')=='tracking') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('tracking_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_tracking_type_field');
		} else if($this->input->post('subject')==='') {
			$Return['error'] = $this->lang->line('xin_error_subject_field');
		} else if($this->input->post('target_achiement')==='') {
			$Return['error'] = $this->lang->line('xin_error_target_achiement_field');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'tracking_type_id' => $this->input->post('tracking_type'),
		'company_id' => $this->input->post('company'),
		'subject' => $this->input->post('subject'),
		'target_achiement' => $this->input->post('target_achiement'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'description' => $qt_description,
		'goal_progress' => 0,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Goal_tracking_model->add_goal($data);
		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('tracking_id',"DESC")->get("xin_goal_tracking")->row();
			$Return['result'] = $this->lang->line('xin_success_goal_added');	
			$Return['re_last_id'] = $row->tracking_id;		
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_goal() {
	
		if($this->input->post('edit_type')=='tracking') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		$id = $this->uri->segment(4);
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('tracking_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_tracking_type_field');
		} else if($this->input->post('subject')==='') {
			$Return['error'] = $this->lang->line('xin_error_subject_field');
		} else if($this->input->post('target_achiement')==='') {
			$Return['error'] = $this->lang->line('xin_error_target_achiement_field');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date >= $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'tracking_type_id' => $this->input->post('tracking_type'),
		'company_id' => $this->input->post('company'),
		'subject' => $this->input->post('subject'),
		'target_achiement' => $this->input->post('target_achiement'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'goal_progress' => $this->input->post('progres_val'),
		'goal_status' => $this->input->post('status'),
		'description' => $qt_description
		);
		
		$result = $this->Goal_tracking_model->update_goal_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_tracking_type_updated');			
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_type() {
	
		if($this->input->post('add_type')=='tracking_type') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('type_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_tracking_type_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type_name' => $this->input->post('type_name'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Goal_tracking_model->add_type($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_tracking_type_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_type() {
	
		if($this->input->post('edit_type')=='tracking_type') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		/* Server side PHP input validation */		
		if($this->input->post('type_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_tracking_type_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'type_name' => $this->input->post('type_name'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Goal_tracking_model->update_type_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_tracking_type_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function tracking_delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Goal_tracking_model->delete_goal_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_tracking_type_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
	
	public function tracking_type_delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Goal_tracking_model->delete_type_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_tracking_type_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
