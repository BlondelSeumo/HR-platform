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

class Tasks extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Timesheet_model");
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");
		$this->load->library('email');
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Project_model");
		$this->load->model("Location_model");
		$this->load->model("Clients_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}	 
	// tasks > timesheet
	 public function index() {
		
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		/*if($system[0]->module_projects_tasks!='true'){
			redirect('client/dashboard');
		}*/
		$data['title'] = $this->lang->line('left_tasks').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_projects'] = $this->Project_model->get_all_projects();
		$data['breadcrumbs'] = $this->lang->line('left_tasks');
		$data['path_url'] = 'tasks_clients';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("client/tasks/task_list", $data, TRUE);
			$this->load->view('client/layout/layout_main', $data); //page load
		} else {
			redirect('client/');
		}	  
     }
	 
	 // Validate and add info in database
	public function add_task() {
	
		if($this->input->post('add_type')=='task') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('task_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_name');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('task_hour')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_hour');
		} else if($this->input->post('project_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_project_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$cproject = $this->Project_model->read_project_information($this->input->post('project_id'));
		//$result2 = $this->Clients_model->read_client_info($result[0]->client_id);
		if(!is_null($cproject)) {
			$company_id = $cproject[0]->company_id;
		} else {
			$company_id = 0;
		}
		
		$assigned_ids = 0;// implode(',',$this->input->post('assigned_to'));
		// get company name by project id
		$co_info  = $this->Project_model->read_project_information($this->input->post('project_id'));
			
		$data = array(
		'project_id' => $this->input->post('project_id'),
		'company_id' => $company_id,
		'created_by' => 0,
		'task_name' => $this->input->post('task_name'),
		'assigned_to' => $assigned_ids,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'task_hour' => $this->input->post('task_hour'),
		'task_progress' => '0',
		'is_notify' => '1',
		'description' => $qt_description,
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Timesheet_model->add_task_record($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// task list > timesheet
	 public function task_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/leave", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$cproject = $this->Xin_model->get_client_projects_panel($session['client_id']);
		//$result2 = $this->Clients_model->read_client_info($result[0]->client_id);
		if(!is_null($cproject)) {
			$task = $this->Xin_model->get_client_project_tasks_panel($cproject[0]->project_id);
			if(!is_null($task)) {
					
			$data = array();

            foreach($task->result() as $r) {				  
								
				// task project
				$prj_task = $this->Project_model->read_project_information($r->project_id);
				if(!is_null($prj_task)){
					$prj_name = $prj_task[0]->title;
				} else {
					$prj_name = '--';
				}
				
				/// set task progress
				if($r->task_progress=='' || $r->task_progress==0): $progress = 0; else: $progress = $r->task_progress; endif;				
				// task progress
				if($r->task_progress <= 20) {
					$progress_class = 'progress-danger';
				} else if($r->task_progress > 20 && $r->task_progress <= 50){
					$progress_class = 'progress-warning';
				} else if($r->task_progress > 50 && $r->task_progress <= 75){
					$progress_class = 'progress-info';
				} else {
					$progress_class = 'progress-success';
				}
				
				$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->task_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->task_progress.'" max="100">'.$r->task_progress.'%</progress>';
				
				// task status
				if($r->task_status == 0) {
					$status = $this->lang->line('xin_not_started');
				} else if($r->task_status ==1){
					$status = $this->lang->line('xin_in_progress');
				} else if($r->task_status ==2){
					$status = $this->lang->line('xin_completed');
				} else {
					$status = $this->lang->line('xin_deffered');
				}
				// task end date
				$tdate = $this->Xin_model->set_date_format($r->end_date);
				//if(in_array('320',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-task_id="'. $r->task_id.'" data-mname="admin"><span class="fa fa-pencil"></span></button></span>';
				
				
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->task_id . '"><span class="fa fa-trash"></span></button></span>';
				
				
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/task_details/id/'.$r->task_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
				
				$combhr = $edit.$view.$delete;
				$pname = '<a href="'.site_url().'client/projects/detail/'.$r->project_id.'">'.$prj_name.'</a>';
			   $data[] = array(
					$r->task_name,
					$pname,
					$tdate,
					$status,
					$progress_bar
			   );
	  } } }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $task->num_rows(),
			 "recordsFiltered" => $task->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 // leave > timesheet
	 public function task_details() {
		$data['title'] = $this->Xin_model->site_title();
		
		$task_id = $this->uri->segment(5);
		$result = $this->Timesheet_model->read_task_information($task_id);
		if(is_null($result)){
			redirect('admin/timesheet/tasks');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Timesheet_model->update_task_record($edata,$task_id);
		/* get User info*/
		$u_created = $this->Xin_model->read_user_info($result[0]->created_by);
		
		if(!is_null($u_created)){
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
		} else {
			$f_name = '--';	
		}
		
		// task project
		$prj_task = $this->Project_model->read_project_information($result[0]->project_id);
		if(!is_null($prj_task)){
			$prj_name = $prj_task[0]->title;
		} else {
			$prj_name = '--';
		}
		
		$data = array(
		'title' => $this->lang->line('xin_task_detail').' | '.$this->Xin_model->site_title(),
		'task_id' => $result[0]->task_id,
		'project_name' => $prj_name,
		'created_by' => $f_name,
		'task_name' => $result[0]->task_name,
		'assigned_to' => $result[0]->assigned_to,
		'start_date' => $result[0]->start_date,
		'end_date' => $result[0]->end_date,
		'task_hour' => $result[0]->task_hour,
		'task_status' => $result[0]->task_status,
		'task_note' => $result[0]->task_note,
		'progress' => $result[0]->task_progress,
		'description' => $result[0]->description,
		'created_at' => $result[0]->created_at,
		'all_employees' => $this->Xin_model->all_employees()
		);
		$data['breadcrumbs'] = $this->lang->line('xin_task_detail');
		$data['path_url'] = 'task_details';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$session = $this->session->userdata('client_username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('45',$role_resources_ids)) {
		if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/tasks/task_details", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
		  
     }
	 
	// Validate and update info in database // assign_ticket
	public function assign_task() {
	
		if($this->input->post('type')=='task_user') {		
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
		$id = $this->input->post('task_id');
		$result = $this->Timesheet_model->assign_task_user($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_assigned');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// update task user > task details
	public function task_users() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'task_id' => $id,
			'all_employees' => $this->Xin_model->all_employees(),
			);
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/get_task_users", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	  // Validate and update info in database // update_status
	public function update_task_status() {
	
		if($this->input->post('type')=='update_status') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();		
			
		$data = array(
		'task_progress' => $this->input->post('progres_val'),
		'task_status' => $this->input->post('status'),
		);
		$id = $this->input->post('task_id');
		$result = $this->Timesheet_model->update_task_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_status');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 public function comments_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/task_details", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$comments = $this->Timesheet_model->get_comments($id);
		
		$data = array();

        foreach($comments->result() as $r) {
			 			  		
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
			$u_file = '--';
		}
		// created at
		$created_at = date('h:i A', strtotime($r->created_at));
		$_date = explode(' ',$r->created_at);
		$date = $this->Xin_model->set_date_format($_date[0]);
		//
			$link = '<a class="c-user text-black" href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><span class="underline">'.$employee_name.' ('.$designation_name.')</span></a>';

			$dlink = '<div class="media-right">
							<div class="c-rating">
							<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'">
								<a class="btn icon-btn btn-xs btn-danger delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
			  <span class="fa fa-trash m-r-0-5"></span></a></span>
							</div>
						</div>';
		
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="user-image-hr-prj ui-w-30 rounded-circle" src="'.$u_file.'">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
							</div>
							<div class="c-text">'.$r->task_comments.'</div>
						</div>
						'.$dlink.'
					</div>
				</div>';
		
		$data[] = array(
			$function
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $comments->num_rows(),
			 "recordsFiltered" => $comments->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// Validate and add info in database
	public function set_comment() {
	
		if($this->input->post('add_type')=='set_comment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('xin_comment')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_comment_field');
		} 
		$xin_comment = $this->input->post('xin_comment');
		$qt_xin_comment = htmlspecialchars(addslashes($xin_comment), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'task_comments' => $qt_xin_comment,
		'task_id' => $this->input->post('comment_task_id'),
		'user_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Timesheet_model->add_comment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_comment_task');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function comment_delete() {
		if($this->input->post('data') == 'task_comment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_comment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_comment_task_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
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
       		 $Return['error'] = $this->lang->line('xin_error_task_file_name');
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
			$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx','txt');
			$filename = $_FILES['attachment_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["attachment_file"]["tmp_name"];
				$attachment_file = "uploads/task/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["attachment_file"]["name"]);
				$newfilename = 'task_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $attachment_file.$newfilename);
				$fname = $newfilename;
			} else {
				$Return['error'] = $this->lang->line('xin_error_task_file_attachment');
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'task_id' => $this->input->post('c_task_id'),
		'upload_by' => $this->input->post('user_id'),
		'file_title' => $this->input->post('file_name'),
		'file_description' => $file_description,
		'attachment_file' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Timesheet_model->add_new_attachment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_att_added');
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
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tasks/task_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Timesheet_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
		$data = array();

        foreach($attachments->result() as $r) {
			 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=task&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->task_attachment_id . '"><span class="fa fa-trash"></span></button></span>',
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
		} else {
			$data[] = array('','','','');
      

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => 0,
			 "recordsFiltered" => 0,
			 "data" => $data
		);
		}
	  echo json_encode($output);
	  exit();
     }
	 
	 // delete task attachment
	 public function attachment_delete() {
		if($this->input->post('data') == 'task_attachment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_attachment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_task_att_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	
	
	// Validate and add info in database
	public function edit_task() {
	
		if($this->input->post('edit_type')=='task') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('project_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_project_field');
		} else if($this->input->post('task_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_name');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('task_hour')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_hour');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if(null!=$this->input->post('assigned_to')) {
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
		} else {
			$assigned_ids = 'None';
		}
			
		$data = array(
		'task_name' => $this->input->post('task_name'),
		'project_id' => $this->input->post('project_id'),
		'assigned_to' => $assigned_ids,
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'task_hour' => $this->input->post('task_hour'),
		'description' => $qt_description
		);
		
		$result = $this->Timesheet_model->update_task_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// get record of leave by id > modal
	public function read_task_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$task_id = $this->input->get('task_id');
		$result = $this->Timesheet_model->read_task_information($task_id);
		
		$data = array(
				'task_id' => $result[0]->task_id,
				'project_id' => $result[0]->project_id,
				'company_id' => $result[0]->company_id,
				'projectid' => $result[0]->project_id,
				'created_by' => $result[0]->created_by,
				'task_name' => $result[0]->task_name,
				'assigned_to' => $result[0]->assigned_to,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'task_hour' => $result[0]->task_hour,
				'task_status' => $result[0]->task_status,
				'task_progress' => $result[0]->task_progress,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_projects' => $this->Project_model->get_all_projects()
				);
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/tasks/dialog_task', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function delete_task() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_task_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_task_deleted');
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
		'task_note' => $this->input->post('task_note')
		);
		$id = $this->input->post('note_task_id');
		$result = $this->Timesheet_model->update_task_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_note_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
}
