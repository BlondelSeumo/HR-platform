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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          //load the login model
          $this->load->model('Company_model');
		  $this->load->model('Xin_model');
		  $this->load->model('Events_model');
		  $this->load->model('Meetings_model');
		  $this->load->model('Department_model');
     }
	 
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_hr_events').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_events');
		$data['path_url'] = 'events';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('98',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/events_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	//events calendar
	public function calendar() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		/*if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}*/
		$data['title'] = $this->lang->line('xin_hrsale_events_calendar');
		$data['breadcrumbs'] = $this->lang->line('xin_hrsale_events_calendar');
		$data['all_events'] = $this->Events_model->get_events();
		$data['all_meetings'] = $this->Meetings_model->get_meetings();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'event_calendar';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('98',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/calendar_events", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/events/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	// events_list > Events
	 public function events_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/events/events_list", $data);
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
			$events = $this->Events_model->get_events();
		} else {
			if(in_array('272',$role_resources_ids)) {
				$events = $this->Events_model->get_company_events($user_info[0]->company_id);
			} else {
				$events = $this->Events_model->get_employee_events($session['user_id']);
			}
		}
		$data = array();

        foreach($events->result() as $r) {
			  
			 // get start date and end date
			 $sdate = $this->Xin_model->set_date_format($r->event_date);
			 // get time am/pm
			 $event_time = new DateTime($r->event_time);
			 // get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			// get user > added by
			if($r->employee_id == '') {
				$ol = $this->lang->line('xin_not_assigned');
			} else {
				$ol = '';
				foreach(explode(',',$r->employee_id) as $desig_id) {
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
			$full_name = $ol;
			if(in_array('270',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-event_id="'. $r->event_id.'"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('271',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->event_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('272',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-event_id="'. $r->event_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
		   $combhr = $edit.$view.$delete;
		   $event_title = '<span class="badge" style="background:'.$r->event_color.';color:#fff;">'.$r->event_title.'</span>';
		   $data[] = array(
				$combhr,
				$comp_name,
				$full_name,
				$event_title,
				$sdate,
				$event_time->format('h:i a')
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $events->num_rows(),
			 "recordsFiltered" => $events->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // Validate and add info in database
	public function add_event() {
	
		if($this->input->post('add_type')=='event') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$event_date = $this->input->post('event_date');
		$current_date = date('Y-m-d');
		$event_note = $this->input->post('event_note');
		$ev_date = strtotime($event_date);
		$ct_date = strtotime($current_date);
		$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);
		$assigned_to = $this->input->post('employee_id');
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if(empty($assigned_to)) {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('event_title')==='') {
        	$Return['error'] = $this->lang->line('xin_error_event_title_field');
		} else if($this->input->post('event_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_date_field');
		} else if($ev_date < $ct_date) {
			$Return['error'] = $this->lang->line('xin_error_event_date_current_date');
		} else if($this->input->post('event_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_time_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$assigned_ids = implode(',',$this->input->post('employee_id'));
		$employee_ids = $assigned_ids;
		$data = array(
		'company_id' => $this->input->post('company_id'),
		'employee_id' => $employee_ids,
		'event_title' => $this->input->post('event_title'),
		'event_date' => $this->input->post('event_date'),
		'event_time' => $this->input->post('event_time'),
		'event_color' => $this->input->post('event_color'),
		'event_note' => $qt_event_note,
		'created_at' => date('Y-m-d')
		);
		$result = $this->Events_model->add($data);
		
		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('event_id',"DESC")->get("xin_events")->row();
			$Return['result'] = $this->lang->line('xin_hr_success_event_added');
			$Return['re_event_id'] = $row->event_id;
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function edit_event() {
	
		if($this->input->post('edit_type')=='event') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$event_date = $this->input->post('event_date');
		$current_date = date('Y-m-d');
		$event_note = $this->input->post('event_note');
		$ev_date = strtotime($event_date);
		$ct_date = strtotime($current_date);
		$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);
			
		/* Server side PHP input validation */		
		if($this->input->post('event_title')==='') {
        	$Return['error'] = $this->lang->line('xin_error_event_title_field');
		} else if($this->input->post('event_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_date_field');
		} else if($ev_date < $ct_date) {
			$Return['error'] = $this->lang->line('xin_error_event_date_current_date');
		} else if($this->input->post('event_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_time_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'event_title' => $this->input->post('event_title'),
		'event_date' => $this->input->post('event_date'),
		'event_time' => $this->input->post('event_time'),
		'event_color' => $this->input->post('event_color'),
		'event_note' => $qt_event_note
		);
		$result = $this->Events_model->update_record($data,$id);
				
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_success_event_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// get record of event
	public function read_event_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$event_id = $this->input->get('event_id');
		$result = $this->Events_model->read_event_information($event_id);
		
		$data = array(
				'event_id' => $result[0]->event_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'event_title' => $result[0]->event_title,
				'event_date' => $result[0]->event_date,
				'event_time' => $result[0]->event_time,
				'event_note' => $result[0]->event_note,
				'event_color' => $result[0]->event_color,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/events/dialog_events', $data);
		} else {
			redirect('admin/');
		}
	}
		
	public function delete_event() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Events_model->delete_event_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_hr_success_event_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	 
	 
	 
} 
?>