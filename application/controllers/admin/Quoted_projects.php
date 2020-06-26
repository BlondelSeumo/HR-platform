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

class Quoted_projects extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Project_model");
		$this->load->model("Xin_model");
		$this->load->model("Company_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Clients_model");
		$this->load->model("Quoted_project_model");
		$this->load->library('email');
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
		if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_quoted_projects').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['breadcrumbs'] = $this->lang->line('xin_quoted_projects');
		$data['path_url'] = 'quoted_project';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('44',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/quoted_projects/project_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
     }
	 public function timelogs()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_project_timelogs').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_projects'] = $this->Quoted_project_model->get_all_projects();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['breadcrumbs'] = $this->lang->line('xin_project_timelogs');
		$data['path_url'] = 'quoted_project_timelogs';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('44',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/quoted_projects/project_timelogs_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
     }
	 
	//quote_calendar
	public function quote_calendar() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_quote_calendar');
		$data['breadcrumbs'] = $this->lang->line('xin_quote_calendar');
		$data['estimates_all'] = $this->Quoted_project_model->get_estimates_all();
		$data['leads_follow_up_all'] = $this->Quoted_project_model->get_leads_follow_up_all();
		$data['path_url'] = 'projects_calendar';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('44',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quoted_projects/quote_calendar", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	 // get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get("cid");//$this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 
	 // get company > project employees
	 public function get_project_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Quoted_project_model->read_project_information($id);
		if(is_null($result)){
			redirect('admin/quoted_projects/timelogs');
		}
		$data = array(
			'project_id' => $id,
			'assigned_to' => $result[0]->assigned_to,
			'company_id' => $result[0]->company_id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/get_project_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 	 
	 public function detail()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		/*if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}*/
		/*$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('318',$role_resources_ids)) { //view
			redirect('admin/project');
		}*/
		$data['title'] = $this->Xin_model->site_title();
		//$data['all_employees'] = $this->Xin_model->all_employees();
		//$data['all_companies'] = $this->Xin_model->get_companies();
		//$data['breadcrumbs'] = $this->lang->line('xin_project_detail');
		$id = $this->uri->segment(4);
		$result = $this->Quoted_project_model->read_project_information($id);
		if(is_null($result)){
			redirect('admin/quoted_projects');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Quoted_project_model->update_record($edata,$id);
		// get user > added by
		$user = $this->Xin_model->read_user_info($result[0]->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$result2 = $this->Clients_model->read_client_info($result[0]->client_id);
		if(!is_null($result2)) {
			$client_name = $result2[0]->name;
		} else {
			$client_name = '--';
		}
		
		$data = array(
			'breadcrumbs' => $this->lang->line('xin_quoted_project_details'),
			'project_id' => $result[0]->project_id,
			'title' => $result[0]->title . ' | '. $this->lang->line('xin_quoted_project_details'),
			'project_note' => $result[0]->project_note,
			'summary' => $result[0]->summary,
			'client_id' => $result[0]->client_id,
			'client_name' => $client_name,
			'estimate_date' => $result[0]->estimate_date,
			'company_id' => $result[0]->company_id,
			'assigned_to' => $result[0]->assigned_to,
			'created_at' => $result[0]->created_at,
			'priority' => $result[0]->priority,
			'added_by' => $full_name,
			'description' => $result[0]->description,
			'progress' => $result[0]->project_progress,
			'project_no' => $result[0]->project_no,
			'estimate_hrs' => $result[0]->estimate_hrs,
			'status' => $result[0]->status,
			'path_url' => 'quoted_project_detail',
			'all_clients' => $this->Clients_model->get_all_clients(),
			'all_employees' => $this->Xin_model->all_employees(),
			'all_companies' => $this->Xin_model->get_companies()
			);

		//$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('7',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/quoted_projects/project_details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		/*} else {
			redirect('dashboard/');
		}*/		  
     }
 
    public function project_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/project_list", $data);
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
			$project = $this->Quoted_project_model->get_projects();
		} else {
			if(in_array('318',$role_resources_ids)) {
				$project = $this->Quoted_project_model->get_company_projects($user_info[0]->company_id);
			} else {
				$project = $this->Quoted_project_model->get_employee_projects($session['user_id']);
			}
		}
		$data = array();

        foreach($project->result() as $r) {
			$aim = explode(',',$r->assigned_to);
					 // get user > added by
			$user = $this->Xin_model->read_user_info($r->added_by);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			// get date
			$estimate_date = $this->Xin_model->set_date_format($r->estimate_date);			
			//project_progress
			if($r->project_progress <= 20) {
				$progress_class = 'progress-bar-danger';
			} else if($r->project_progress > 20 && $r->project_progress <= 50){
				$progress_class = 'progress-bar-warning';
			} else if($r->project_progress > 50 && $r->project_progress <= 75){
				$progress_class = 'progress-bar-info';
			} else {
				$progress_class = 'progress-bar-success';
			}
			
			// progress
			$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->project_progress.'%</span>
	<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$r->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$r->project_progress.'%"></div></div></p>';
	
					
			//status
			if($r->status == 0) {
				$status = '<span class="label label-warning">'.$this->lang->line('xin_not_started').'</span>';
			} else if($r->status ==1){
				$status = '<span class="label label-primary">'.$this->lang->line('xin_in_progress').'</span>';
			} else if($r->status ==2){
				$status = '<span class="label label-success">'.$this->lang->line('xin_completed').'</span>';
			} else if($r->status ==3){
				$status = '<span class="label label-danger">'.$this->lang->line('xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.$this->lang->line('xin_project_hold').'</span>';
			}
			
			// priority
			if($r->priority == 1) {
				$priority = '<span class="label label-danger">'.$this->lang->line('xin_highest').'</span>';
			} else if($r->priority ==2){
				$priority = '<span class="label label-danger">'.$this->lang->line('xin_high').'</span>';
			} else if($r->priority ==3){
				$priority = '<span class="label label-primary">'.$this->lang->line('xin_normal').'</span>';
			} else {
				$priority = '<span class="label label-success">'.$this->lang->line('xin_low').'</span>';
			}
			
			//assigned user
			if($r->assigned_to == '') {
				$ol = $this->lang->line('xin_not_assigned');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $desig_id) {
					$assigned_to = $this->Xin_model->read_user_info($desig_id);
					if(!is_null($assigned_to)){
						
					  $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
					 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
						} else {
						if($assigned_to[0]->gender=='Male') { 
							$de_file = base_url().'uploads/profile/default_male.jpg';
						 } else {
							$de_file = base_url().'uploads/profile/default_female.jpg';
						 }
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
						}
					} ////
					else {
						$ol .= '';
					}
				 }
				 $ol .= '';
			}
			
			
			if(in_array('316',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-project_id="'. $r->project_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
				
				$add_users = ' <a href="javascript:void(0)" class="text-muted" data-toggle="modal" data-target=".edit-modal-data"  data-project_id="'. $r->project_id . '"><span class="ion ion-md-add" data-placement="top" data-state="primary" data-toggle="tooltip" title="'.$this->lang->line('xin_add_member').'"></span></a>';
			} else {
				$edit = '';
				$add_users = '';
			}
			if(in_array('317',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->project_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$client = $this->Clients_model->read_client_info($r->client_id);
			if(!is_null($client)) {
				$client_name = $client[0]->name;
			} else {
				$client_name = '--';
			}
					
			//$new_time = $this->Xin_model->actual_hours_timelog($r->project_id);
			$project_summary = $r->title.'<br><small>'.$this->lang->line('xin_project_client').': '.$client_name.'</small><br><small>'.$this->lang->line('xin_estimate_hrs').': '.$r->estimate_hrs.'</small>';
			
			// progress
			$project_progress = $pbar.$status;
			$project_no = $r->project_no;
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$project_no,
				//$r->phase_no,
				$project_summary,
				$priority,
				$ol.$add_users,
				$estimate_date,
				$project_progress,
				
			);
			// } //}
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $project->num_rows(),
			 "recordsFiltered" => $project->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('project_id');
		$result = $this->Quoted_project_model->read_project_information($id);
		$result2 = $this->Clients_model->read_client_info($result[0]->client_id);
		if(!is_null($result2)) {
			$client_name = $result2[0]->name;
		} else {
			$client_name = '--';
		}
		$data = array(
				'project_id' => $result[0]->project_id,
				'title' => $result[0]->title,
				'client_id' => $result[0]->client_id,
				'client_name' => $client_name,
				'estimate_date' => $result[0]->estimate_date,
				'company_id' => $result[0]->company_id,
				'priority' => $result[0]->priority,
				'summary' => $result[0]->summary,
				'project_no' => $result[0]->project_no,
				'phase_no' => $result[0]->phase_no,
				'estimate_hrs' => $result[0]->estimate_hrs,
				'assigned_to' => $result[0]->assigned_to,
				'description' => $result[0]->description,
				'project_progress' => $result[0]->project_progress,
				'status' => $result[0]->status,
				'all_clients' => $this->Clients_model->get_all_clients(),
				'all_employees' => $this->Xin_model->all_employees(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/quoted_projects/dialog_project', $data);
		} else {
			redirect('admin/');
		}
	}
	// Validate and add info in database
	public function add_project() {
	
		if($this->input->post('add_type')=='project') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$estimate_date = $this->input->post('estimate_date');
		$description = $this->input->post('description');
		
		$qt_description = $description;
		$assigned_to = $this->input->post('assigned_to');
		$company_id_multi = $this->input->post('company_id');
		
		if($this->input->post('title')==='') {
        	$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('project_no')==='') {
			$Return['error'] = $this->lang->line('xin_project_projectno_field_error');
		} else if($this->input->post('client_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_client_name');
		} else if(empty($company_id_multi)) {
			$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('estimate_date')==='') {
			$Return['error'] = $this->lang->line('xin_quote_date_field_error');
		} else if($this->input->post('estimate_hrs')==='') {
			$Return['error'] = $this->lang->line('xin_estimate_hrs_field_error');
		} else if(empty($assigned_to)) {
			 $Return['error'] = $this->lang->line('xin_error_project_manager');
		} else if($this->input->post('summary')==='') {
			$Return['error'] = $this->lang->line('xin_error_summary');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$assigned_ids = implode(',',$this->input->post('assigned_to'));
		$employee_ids = $assigned_ids;
		$company_ids = implode(',',$this->input->post('company_id'));
		$c_ids = $company_ids;
		
		$data = array(
		'title' => $this->input->post('title'),
		'project_no' => $this->input->post('project_no'),
		'client_id' => $this->input->post('client_id'),
		'company_id' => $c_ids,
		'estimate_date' => $this->input->post('estimate_date'),
		'summary' => $this->input->post('summary'),
		'estimate_hrs' => $this->input->post('estimate_hrs'),
		'priority' => $this->input->post('priority'),
		'purchase_no' => $this->input->post('purchase_no'),
		'assigned_to' => $employee_ids,
		'description' => $qt_description,
		'project_progress' => '0',
		'status' => '0',
		'is_notify' => '1',
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Quoted_project_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_project');	
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='project') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$estimate_date = $this->input->post('estimate_date');
		$description = $this->input->post('description');
		$qt_description = $description;
		//$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		$assigned_to = $this->input->post('assigned_to');
		$company_id_multi = $this->input->post('company_id');
		
		if($this->input->post('title')==='') {
        	$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('project_no')==='') {
			$Return['error'] = $this->lang->line('xin_project_projectno_field_error');
		} else if($this->input->post('client_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_client_name');
		} else if($this->input->post('estimate_date')==='') {
			$Return['error'] = $this->lang->line('xin_quote_date_field_error');
		} else if($this->input->post('estimate_hrs')==='') {
			$Return['error'] = $this->lang->line('xin_estimate_hrs_field_error');
		} else if(empty($company_id_multi)) {
			$Return['error'] = $this->lang->line('xin_error_company');
		} else if(empty($assigned_to)) {
			 $Return['error'] = $this->lang->line('xin_error_project_manager');
		} else if($this->input->post('summary')==='') {
			$Return['error'] = $this->lang->line('xin_error_summary');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if(null!=$this->input->post('assigned_to')) {
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
			$employee_ids = $assigned_ids;
		} else {
			$employee_ids = 'all-employees';
		}
		
		$company_ids = implode(',',$this->input->post('company_id'));
		$c_ids = $company_ids;
			
		$data = array(
		'title' => $this->input->post('title'),
		'project_no' => $this->input->post('project_no'),
		'client_id' => $this->input->post('client_id'),
		'estimate_date' => $this->input->post('estimate_date'),
		'summary' => $this->input->post('summary'),
		'priority' => $this->input->post('priority'),
		'company_id' => $c_ids,
		'estimate_hrs' => $this->input->post('estimate_hrs'),
		'assigned_to' => $employee_ids,
		'description' => $qt_description,
		'project_progress' => $this->input->post('progres_val'),
		'status' => $this->input->post('status'),		
		);
		
		$result = $this->Quoted_project_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_project');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_status() {
	
		if($this->input->post('type')=='update_status') {
			
		$id = $this->input->post('project_id');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		$data = array(
		'priority' => $this->input->post('priority'),
		'project_progress' => $this->input->post('progres_val'),
		'status' => $this->input->post('status'),		
		);
		
		$result = $this->Quoted_project_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_project');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // assign_ticket
	public function assign_project() {
	
		if($this->input->post('type')=='project_user') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		
		if(null!=$this->input->post('assigned_to')) {
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
			$employee_ids = $assigned_ids;
		} else {
			$employee_ids = '';
		}
	
		$data = array(
		'assigned_to' => $employee_ids
		);
		$id = $this->input->post('project_id');
		$result = $this->Quoted_project_model->update_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_employees_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// update task user > task details
	public function project_users() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(3);
		
		$data = array(
			'project_id' => $id,
			'all_employees' => $this->Xin_model->all_employees(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("project/get_project_users", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	public function discussion_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		
		$ses_user = $this->Xin_model->read_user_info($session['user_id']);
		$this->load->view("admin/quoted_projects/project_details", $data);
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$discussion = $this->Quoted_project_model->get_discussion($id);
		
		$data = array();

        foreach($discussion->result() as $r) {
			 			  		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->user_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get designation
			$_designation = $this->Designation_model->read_designation_information($employee[0]->designation_id);
			if(!is_null($_designation)){
				$designation_name = $_designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			
			// profile picture
			if($employee[0]->profile_picture!='' && $employee[0]->profile_picture!='no file') {
				$u_file = base_url().'uploads/profile/'.$employee[0]->profile_picture;
			} else {
				if($employee[0]->gender=='Male') { 
					$u_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$u_file = base_url().'uploads/profile/default_female.jpg';
				}
			} 
		} else {
			$employee_name = '--';
			$designation_name = '--';
			$u_file = $u_file;
		}
		// created at
		$created_at = date('h:i A', strtotime($r->created_at));
		$_date = explode(' ',$r->created_at);
		$date = $this->Xin_model->set_date_format($_date[0]);
		//
		if($ses_user[0]->user_role_id==1){
			$link = '<a class="c-user text-black" href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><span class="underline">'.$employee_name.' ('.$designation_name.')</span></a>';
		} else {
			$link = '<span class="underline">'.$employee_name.' ('.$designation_name.')</span>';
		}
		
		if($r->attachment_file!='' && $r->attachment_file!='no_file'){
			$at_file = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'" href="'.site_url().'admin/download?type=project/discussion&filename='.$r->attachment_file.'"> <i class="oi oi-cloud-download"></i> </a>';
		} else {
			$at_file = '';
		}
				
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="user-image-hr-prj d-block ui-w-30 rounded-circle" src="'.$u_file.'">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
							</div>
							<div class="c-text">'.$r->message.'<br> '.$at_file.'</div>
						</div>
					</div>
				</div>';
		
		$data[] = array(
			$function
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $discussion->num_rows(),
			 "recordsFiltered" => $discussion->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }	 
	 
	// Validate and add info in database
	public function set_discussion() {
	
		if($this->input->post('add_type')=='set_discussion') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('xin_message')==='') {
       		 $Return['error'] = $this->lang->line('xin_project_message');
		} 
		$xin_message = $this->input->post('xin_message');
		$qt_xin_message = htmlspecialchars(addslashes($xin_message), ENT_QUOTES);
		
		if($_FILES['attachment_discussion']['size'] == 0) {
			$fname = 'no_file';
		} else {
			// is file upload
			if(is_uploaded_file($_FILES['attachment_discussion']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','gif','jpeg','pdf','doc','docx','xls','xlsx','txt','zip','rar','gzip','ppt');
				$filename = $_FILES['attachment_discussion']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment_discussion"]["tmp_name"];
					$attachment_file = "uploads/project/discussion/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["attachment_discussion"]["name"]);
					$newfilename = 'discussion_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $attachment_file.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_project_file');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'message' => $qt_xin_message,
		'attachment_file' => $fname,
		'project_id' => $this->input->post('discussion_project_id'),
		'user_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Quoted_project_model->add_discussion($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_project_message_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
	
	// Validate and add info in database
	public function add_attachment() {
	
		if($this->input->post('add_type')=='dfile_attachment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('file_name')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_project_file_title');
		} else if($_FILES['attachment_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_task_file');
		} else if($this->input->post('file_description')==='') {
			 $Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
		$description = $this->input->post('file_description');
		$file_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// is file upload
		if(is_uploaded_file($_FILES['attachment_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','gif','jpeg','pdf','doc','docx','xls','xlsx','txt','zip','rar','gzip','ppt');
			$filename = $_FILES['attachment_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["attachment_file"]["tmp_name"];
				$attachment_file = "uploads/project/files/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["attachment_file"]["name"]);
				$newfilename = 'project_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $attachment_file.$newfilename);
				$fname = $newfilename;
			} else {
				$Return['error'] = $this->lang->line('xin_error_project_file');
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'project_id' => $this->input->post('project_id'),
		'upload_by' => $this->input->post('user_id'),
		'file_title' => $this->input->post('file_name'),
		'file_description' => $file_description,
		'attachment_file' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Quoted_project_model->add_new_attachment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_project_file_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// attachment list
	  public function attachment_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Quoted_project_model->get_attachments($id);

		$data = array();

        foreach($attachments->result() as $r) {
			 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=project/files&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light fidelete" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->project_attachment_id . '"><span class="fas fa-trash-restore"></span></button></span>',
			$r->file_title,
			$r->file_description,
			$r->created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $attachments->num_rows(),
			 "recordsFiltered" => $attachments->num_rows(),
			 "data" => $data
		);

	  echo json_encode($output);
	  exit();
     }
	 
	 // delete attachment
	 public function attachment_delete() {
		if($this->input->post('is_ajax') == '8') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Quoted_project_model->delete_attachment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_project_file_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// Validate and update info in database // add_note
	public function add_note() {
	
		if($this->input->post('type')=='add_note') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();		
			
		$data = array(
		'project_note' => $this->input->post('project_note')
		);
		$id = $this->input->post('note_project_id');
		$result = $this->Quoted_project_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_project_note_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 public function timelogs_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/project_timelogs_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id == '1'){
			$timelogs = $this->Quoted_project_model->get_all_project_timelogs();
		} else {
			$timelogs = $this->Quoted_project_model->get_all_project_employee_timelogs($session['user_id']);
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

        foreach($timelogs->result() as $r) {
						
			// get user > added by
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$project = $this->Quoted_project_model->read_project_information($r->project_id);
			if(!is_null($project)){
				$project_name = '<a target="_blank" href="'.site_url('admin/quoted_projects/detail/').$r->project_id.'">'.$project[0]->title.'</a>';
			} else {
				$project_name = '--';
			}
			$start_date = $this->Xin_model->set_date_format($r->start_date);
			$end_date = $this->Xin_model->set_date_format($r->end_date);
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-timelog-data"  data-timelogs_id="'. $r->timelogs_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->timelogs_id . '"><span class="fas fa-trash-restore"></span></button></span>';		
			if($user_info[0]->user_role_id == '1'){
				$combhr = $edit.$delete;
			} else {
				$combhr = $edit;
			}
			
					
			$data[] = array(
			$combhr,
			$project_name,
			$full_name,
			$start_date,
			$end_date,
			$r->total_hours,
			$r->timelogs_memo,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $timelogs->num_rows(),
			 "recordsFiltered" => $timelogs->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 public function project_timelogs_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/project_details", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$timelogs = $this->Quoted_project_model->get_project_timelogs($id);
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

        foreach($timelogs->result() as $r) {
						
			// get user > added by
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$start_date = $this->Xin_model->set_date_format($r->start_date);
			$end_date = $this->Xin_model->set_date_format($r->end_date);
			//if(in_array('346',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-timelog-data"  data-timelogs_id="'. $r->timelogs_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			//} else {
			//	$edit = '';
			//}
			//if(in_array('347',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-timelog" data-toggle="modal" data-target=".delete-modal-timelogs" data-record-id="'. $r->timelogs_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		//	} else {
		//		$delete = '';
		//	}
			if($user_info[0]->user_role_id == '1'){
				$combhr = $edit.$delete;
			} else {
				$combhr = $edit;
			}
					
			$data[] = array(
			$combhr,
			$full_name,
			$start_date,
			$end_date,
			$r->total_hours,
			$r->timelogs_memo,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $timelogs->num_rows(),
			 "recordsFiltered" => $timelogs->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	// Validate and add info in database
	public function add_project_timelog() {
	
		if($this->input->post('add_type')=='timelog') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		
		/* Server side PHP input validation */		
		if($this->input->post('project_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_project_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('start_time')==='') {
        	$Return['error'] = $this->lang->line('xin_project_time_start_field_error');
		} else if($this->input->post('end_time')==='') {
        	$Return['error'] = $this->lang->line('xin_project_time_end_field_error');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('timelogs_memo')==='') {
			$Return['error'] = $this->lang->line('xin_project_memo_field_error');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$project = $this->Quoted_project_model->read_project_information($this->input->post('project_id'));	
		if(!is_null($project)){
			$cid = $project[0]->company_id;
		} else {
			$cid = 0;	
		}
		$data = array(
		'project_id' => $this->input->post('project_id'),
		'company_id' => $cid,
		'employee_id' => $this->input->post('employee_id'),
		'start_time' => $this->input->post('start_time'),
		'end_time' => $this->input->post('end_time'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'total_hours' => $this->input->post('total_hours'),
		'timelogs_memo' => $this->input->post('timelogs_memo'),
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Quoted_project_model->add_project_timelog($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_timelogs_added_success');	
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database
	public function update_project_timelog() {
	
		if($this->input->post('edit_type')=='timelog_record') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		/* Server side PHP input validation */		
		if($this->input->post('start_time')==='') {
        	$Return['error'] = $this->lang->line('xin_project_time_start_field_error');
		} else if($this->input->post('end_time')==='') {
        	$Return['error'] = $this->lang->line('xin_project_time_end_field_error');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('timelogs_memo')==='') {
			$Return['error'] = $this->lang->line('xin_project_memo_field_error');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'start_time' => $this->input->post('start_time'),
		'end_time' => $this->input->post('end_time'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'total_hours' => $this->input->post('total_hours'),
		'timelogs_memo' => $this->input->post('timelogs_memo')
		);
		
		$result = $this->Quoted_project_model->update_project_timelog_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_timelogs_updated_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	public function read_timelog_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('timelogs_id');
		$result = $this->Quoted_project_model->read_timelog_info($id);
		$data = array(
			'timelogs_id' => $result[0]->timelogs_id,
			'project_id' => $result[0]->project_id,
			'company_id' => $result[0]->company_id,
			'employee_id' => $result[0]->employee_id,
			'start_time' => $result[0]->start_time,
			'end_time' => $result[0]->end_time,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'total_hours' => $result[0]->total_hours,
			'timelogs_memo' => $result[0]->timelogs_memo,
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/quoted_projects/dialog_project_timelogs', $data);
		} else {
			redirect('admin/');
		}
	}
	public function read_project_timelog_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('timelogs_id');
		$result = $this->Quoted_project_model->read_timelog_info($id);
		$data = array(
			'timelogs_id' => $result[0]->timelogs_id,
			'project_id' => $result[0]->project_id,
			'company_id' => $result[0]->company_id,
			'employee_id' => $result[0]->employee_id,
			'start_time' => $result[0]->start_time,
			'end_time' => $result[0]->end_time,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'total_hours' => $result[0]->total_hours,
			'timelogs_memo' => $result[0]->timelogs_memo,
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/quoted_projects/dialog_project_timelogs_record', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Quoted_project_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_delete_project');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
	public function delete_timelog() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Quoted_project_model->delete_timelog_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_project_timelogs_deleted_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
