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

class Tickets extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Tickets_model");
		$this->load->model("Xin_model");
		$this->load->library('email');
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Custom_fields_model");
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
		if($system[0]->module_inquiry!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_tickets').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_tickets');
		$data['path_url'] = 'tickets';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('43',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/tickets/ticket_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
	 // get company > departments
	 public function get_ticket_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/get_ticket_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
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
			$this->load->view("admin/tickets/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
 
    public function ticket_list(){

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/ticket_list", $data);
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
			$ticket = $this->Tickets_model->get_tickets();
		} else {
			if(in_array('309',$role_resources_ids)) {
				$ticket = $this->Tickets_model->get_company_tickets($user_info[0]->company_id);
			} else {
				$ticket = $this->Tickets_model->get_employee_tickets($session['user_id']);
			}
		}
		$data = array();
		$cdate = strtotime(date('Y-m-d'));
        foreach($ticket->result() as $r) {					
		
		// priority
		if($r->ticket_priority==1):
			$priority = $this->lang->line('xin_low');
		elseif($r->ticket_priority==2):
			$priority = $this->lang->line('xin_medium');
		elseif($r->ticket_priority==3):
			$priority = $this->lang->line('xin_high');
		elseif($r->ticket_priority==4):
			$priority = $this->lang->line('xin_critical');
		endif;
		 $eend_date = strtotime($r->end_date);
		 if($cdate > $eend_date){
			 $xpired = '<span class="badge badge-danger">'.$this->lang->line('xin_expired_title').'</span>';
		 } else {
			 $xpired = '';
		 }
		 $end_date = $this->Xin_model->set_date_format($r->end_date);
		
		 // status 
		if($r->ticket_status==1):
			$status = '<span class="badge badge-info">'.$this->lang->line('xin_open').'</span> '.$xpired;
		else:
			$status = '<span class="badge badge-success">'.$this->lang->line('xin_closed').'</span> '.$xpired;
		endif;
		 // ticket date and time
		 $created_at = date('h:i A', strtotime($r->created_at));
		 $_date = explode(' ',$r->created_at);
		 $edate = $this->Xin_model->set_date_format($_date[0]);
		 $_created_at = $edate. ' '. $created_at;
		 
		 // get company name
		 $p_company = $this->Xin_model->read_company_info($r->company_id);
		 if(!is_null($p_company)){
			$company = $p_company[0]->name;
		 } else {
			$company = '--';	
		 }
		 // created by
		 $created_by = $this->Xin_model->read_user_info($r->created_by);
		 if(!is_null($created_by)){
			$ticket_created_by = $created_by[0]->first_name.' '.$created_by[0]->last_name;
			if($created_by[0]->profile_picture!='' && $created_by[0]->profile_picture!='no file') {
				$eol = '<a href="javascript:void(0);" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$ticket_created_by.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$created_by[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
				} else {
				if($created_by[0]->gender=='Male') { 
					$ede_file = base_url().'uploads/profile/default_male.jpg';
				 } else {
					$ede_file = base_url().'uploads/profile/default_female.jpg';
				 }
				$eol = '<a href="javascript:void(0);" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$ticket_created_by.'"><span class="avatar box-32"><img src="'.$ede_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
				}
				$ticket_created_by = $eol;	
		 } else {
			$ticket_created_by = '';	
		 }
		 // department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';	
			}
		 // ticket attachment
		 if($r->ticket_image!='0'){
			 $timage = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=ticket&filename='.$r->ticket_image.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
		 } else {
			 $timage = '';
		 }
		
		if(in_array('307',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data"  data-ticket_id="'. $r->ticket_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('308',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->ticket_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		//if(in_array('309',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/tickets/details/'.$r->ticket_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			
		$combhr = $timage.$edit.$view.$delete;
		
		$eticket_info = $this->Tickets_model->get_ticket_employees($r->ticket_id);
		$ol = '';
		foreach($eticket_info as $eticket_id) {
			$assigned_to = $this->Xin_model->read_user_info($eticket_id->employee_id);
			if(!is_null($assigned_to)){
					
				 $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					}
				} ////
				else {
					$ol .= '';
				}
		 }
		 $ol .= '';
		$iemployee_name = $ol.'<br><small class="text-muted"><i>'.$this->lang->line('left_department').': '.$department_name.'<i></i></i></small>';
		$iticket_code = $r->ticket_code.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
		$ipriority = $priority.'<br><small class="text-muted"><i>'.$end_date.'<i></i></i></small>';
		$data[] = array(
			$combhr,
			$iticket_code,
			$iemployee_name,
			$r->subject,
			$ipriority,
			$_created_at,
			$ticket_created_by
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $ticket->num_rows(),
			 "recordsFiltered" => $ticket->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function comments_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/ticket_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$comments = $this->Tickets_model->get_comments($id);
		
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
		///
		$link = '<a class="c-user text-black" href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><span class="underline">'.$employee_name.' ('.$designation_name.')</span></a>';

	
		if($employee[0]->user_role_id==1){
		$dlink = '<div class="media-right">
						<div class="c-rating">
						<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'">
							<a class="btn btn-outline-danger btn-sm delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
		  <i class="fas fa-trash-restore m-r-0-5"></i>'.$this->lang->line('xin_delete').'</a></span>
						</div>
					</div>';
		} else {
			$dlink = '';
		}
		
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="b-a-radius-circle" src="'.$u_file.'">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
							</div>
							<div class="c-text">'.$r->ticket_comments.'</div>
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
	 
	 // attachment list
	  public function attachment_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/ticket_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Tickets_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
		$data = array();

        foreach($attachments->result() as $r) {
		$employee = $this->Xin_model->read_user_info($r->upload_by);	 			  				
		if($employee[0]->user_role_id==1){
			
		$delopt = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->ticket_attachment_id . '"><i class="fas fa-trash-restore-o"></i></button></span>';	
		} else {
			$delopt = '';
		}
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=ticket&filename='.$r->attachment_file.'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>'.$delopt,
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
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('ticket_id');
		$result = $this->Tickets_model->read_ticket_information($id);
		$data = array(
				'ticket_id' => $result[0]->ticket_id,
				'company_id' => $result[0]->company_id,
				'ticket_code' => $result[0]->ticket_code,
				'subject' => $result[0]->subject,
				'employee_id' => $result[0]->employee_id,
				'ticket_priority' => $result[0]->ticket_priority,
				'all_companies' => $this->Xin_model->get_companies(),
				'description' => $result[0]->description,
				'all_employees' => $this->Xin_model->all_employees(),
				);
			$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/tickets/dialog_ticket', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_ticket() {
	
		if($this->input->post('add_type')=='ticket') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$assigned_to = $this->input->post('employee_id');
			
		/* Server side PHP input validation */		
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('subject')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_subject');
		} else if($this->input->post('department_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_department');
		} else if(empty($assigned_to)) {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('ticket_priority')==='') {
			 $Return['error'] = $this->lang->line('xin_error_ticket_priority');
		} else if($this->input->post('end_date')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_end_date');
		} 
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		if($_FILES['attachment']['size'] > 0) {
			if(is_uploaded_file($_FILES['attachment']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['attachment']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment"]["tmp_name"];
					$profile = "uploads/ticket/";
					$set_img = base_url()."uploads/ticket/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["attachment"]["name"]);
					$newfilename = 'ticket_attachment_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;			
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		} else {
			$fname = '0';
		}
		
		$ticket_code = $this->Xin_model->generate_random_string();
		$module_attributes = $this->Custom_fields_model->tickets_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_tickets_module_attributes();	
		$i=1;
		if($count_module_attributes > 0){
			 foreach($module_attributes as $mattribute) {
				 if($mattribute->validation == 1){
					 if($i!=1) {
					 } else if($this->input->post($mattribute->attribute)=='') {
						$Return['error'] = $this->lang->line('xin_hrsale_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('xin_hrsale_custom_field_is_required');
					}
				 }
			 }		
			 if($Return['error']!=''){
				$this->output($Return);
			}	
		}
		$assigned_ids = implode(',',$this->input->post('employee_id'));
		$employee_ids = $assigned_ids;
		$session = $this->session->userdata('username');
		$data = array(
		'ticket_code' => $ticket_code,
		'subject' => $this->input->post('subject'),
		'company_id' => $this->input->post('company'),
		'department_id' => $this->input->post('department_id'),
		'ticket_image' => $fname,
		'end_date' => $this->input->post('end_date'),
		'description' => $qt_description,
		'ticket_status' => '1',
		'is_notify' => '1',
		'ticket_priority' => $this->input->post('ticket_priority'),
		'created_by' => $session['user_id'],
		'created_at' => date('d-m-Y h:i:s'),
		);
		$iresult = $this->Tickets_model->add($data);
		if ($iresult) {
			$Return['result'] = $this->lang->line('xin_success_ticket_created');
			foreach($this->input->post('employee_id') as $ticket_emp){
				$eticket_data = array(
				'ticket_id' => $iresult,
				'employee_id' => $ticket_emp,
				'is_notify' => '1',
				'created_at' => date('d-m-Y h:i:s'),
				);
				$eresult = $this->Tickets_model->add_ticket_employees($eticket_data);
			}
			// notificaions
			foreach($this->input->post('employee_id') as $ticket_emp){
				$nticket_data = array(
				'module_name' => 'tickets',
				'module_id' => $iresult,
				'employee_id' => $ticket_emp,
				'is_notify' => '1',
				'created_at' => date('d-m-Y h:i:s'),
				);
				$this->Xin_model->add_notifications($nticket_data);
			}
			$id = $iresult;
			if($count_module_attributes > 0){
				foreach($module_attributes as $mattribute) {
				 	/*$attr_data = array(
						'user_id' => $iresult,
						'module_attributes_id' => $mattribute->custom_field_id,
						'attribute_value' => $this->input->post($mattribute->attribute),
						'created_at' => date('Y-m-d h:i:s')
					);
					$this->Custom_fields_model->add_values($attr_data);*/
					if($mattribute->attribute_type == 'fileupload'){
						if($_FILES[$mattribute->attribute]['size'] != 0) {
							if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
							//checking image type
								$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
								$filename = $_FILES[$mattribute->attribute]['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
									$profile = "uploads/custom_files/";
									$set_img = base_url()."uploads/custom_files/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES[$mattribute->attribute]["name"]);
									$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
									move_uploaded_file($tmp_name, $profile.$newfilename);
									$fname = $newfilename;	
								}
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $fname,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else {
							$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => '',
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
						}
					} else if($mattribute->attribute_type == 'multiselect') {
						$multisel_val = $this->input->post($mattribute->attribute);
						if(!empty($multisel_val)){
							$newdata = implode(',', $this->input->post($mattribute->attribute));
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $newdata,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
						$this->Custom_fields_model->add_values($iattr_data);
					}
					/*$attr_orig_value = $this->Custom_fields_model->read_hrsale_module_attributes_values($result,$mattribute->custom_field_id);
					if($attr_orig_value->module_attributes_id != $mattribute->custom_field_id) {
						$this->Custom_fields_model->add_values($attr_data);
					}*/
				 }
			}
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {

				$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(15);
				//get employee info
				$user_info = $this->Xin_model->read_user_info($this->input->post('employee_id'));
				
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						
				$subject = str_replace('{var ticket_code}',$ticket_code,$template[0]->subject);
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var ticket_code}"),array($cinfo[0]->company_name,site_url(),$ticket_code),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				hrsale_mail($user_info[0]->email,$full_name,$cinfo[0]->email,$subject,$message);				
			}		
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
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
		'ticket_comments' => $qt_xin_comment,
		'ticket_id' => $this->input->post('comment_ticket_id'),
		'user_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		
		);
		$result = $this->Tickets_model->add_comment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_ticket_comment_added');
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
			$allowed =  array('png','jpg','jpeg','pdf','doc','docx','xls','xlsx','txt');
			$filename = $_FILES['attachment_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["attachment_file"]["tmp_name"];
				$attachment_file = "uploads/ticket/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["attachment_file"]["name"]);
				$newfilename = 'ticket_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $attachment_file.$newfilename);
				$fname = $newfilename;
			} else {
				$Return['error'] = $this->lang->line('xin_error_task_file_attachment');
			}
		}
		
		$data = array(
		'ticket_id' => $this->input->post('c_ticket_id'),
		'upload_by' => $this->input->post('user_file_id'),
		'file_title' => $this->input->post('file_name'),
		'file_description' => $file_description,
		'attachment_file' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Tickets_model->add_new_attachment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_ticket_attachment_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='ticket') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('subject')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_subject');
		} else if($this->input->post('ticket_priority')==='') {
			 $Return['error'] = $this->lang->line('xin_error_ticket_priority');
		}
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$module_attributes = $this->Custom_fields_model->tickets_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_tickets_module_attributes();	
		$i=1;
		if($count_module_attributes > 0){
			 foreach($module_attributes as $mattribute) {
				 if($mattribute->validation == 1){
					 if($i!=1) {
					 } else if($this->input->post($mattribute->attribute)=='') {
						$Return['error'] = $this->lang->line('xin_hrsale_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('xin_hrsale_custom_field_is_required');
					}
				 }
			 }		
			 if($Return['error']!=''){
				$this->output($Return);
			}	
		}
		$data = array(
		'subject' => $this->input->post('subject'),
		'description' => $qt_description,
		'ticket_priority' => $this->input->post('ticket_priority')
		);
		
		$result = $this->Tickets_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_ticket_updated');
			if($count_module_attributes > 0){
			foreach($module_attributes as $mattribute) {
				
				//
				$count_exist_values = $this->Custom_fields_model->count_module_attributes_values($id,$mattribute->custom_field_id);
				if($count_exist_values > 0){
					if($mattribute->attribute_type == 'fileupload'){
						if($_FILES[$mattribute->attribute]['size'] != 0) {
							if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
							//checking image type
								$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
								$filename = $_FILES[$mattribute->attribute]['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
									$profile = "uploads/custom_files/";
									$set_img = base_url()."uploads/custom_files/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES[$mattribute->attribute]["name"]);
									$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
									move_uploaded_file($tmp_name, $profile.$newfilename);
									$fname = $newfilename;	
								}
								$iattr_data = array(
									'attribute_value' => $fname
								);
								$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
							}
							
						} else {
						}
					} else if($mattribute->attribute_type == 'multiselect') {
						$multisel_val = $this->input->post($mattribute->attribute);
						if(!empty($multisel_val)){
							$newdata = implode(',', $this->input->post($mattribute->attribute));
							$iattr_data = array(
								'attribute_value' => $newdata,
							);
							$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
						}
					} else {
						$attr_data = array(
							'attribute_value' => $this->input->post($mattribute->attribute),
						);
						$this->Custom_fields_model->update_att_record($attr_data, $id,$mattribute->custom_field_id);
					}
					
				} else {
					if($mattribute->attribute_type == 'fileupload'){
						if($_FILES[$mattribute->attribute]['size'] != 0) {
							if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
							//checking image type
								$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
								$filename = $_FILES[$mattribute->attribute]['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
									$profile = "uploads/custom_files/";
									$set_img = base_url()."uploads/custom_files/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES[$mattribute->attribute]["name"]);
									$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
									move_uploaded_file($tmp_name, $profile.$newfilename);
									$fname = $newfilename;	
								}
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $fname,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					} else if($mattribute->attribute_type == 'multiselect') {
						$multisel_val = $this->input->post($mattribute->attribute);
						if(!empty($multisel_val)){
							$newdata = implode(',', $this->input->post($mattribute->attribute));
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $newdata,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
						$this->Custom_fields_model->add_values($iattr_data);
					}
				}
			 }
		}
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function details()
     {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$id = $this->uri->segment(4);
		$result = $this->Tickets_model->read_ticket_information($id);
		if(is_null($result)){
			redirect('admin/tickets');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Xin_model->update_notification_record($edata,$id,$session['user_id'],'tickets');
		$user = $this->Xin_model->read_user_info($result[0]->created_by);
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$data = array(
				'title' => $this->Xin_model->site_title(),
				'ticket_id' => $result[0]->ticket_id,
				'subject' => $result[0]->subject,
				'ticket_code' => $result[0]->ticket_code,
				'end_date' => $result[0]->end_date,
				'ticket_image' => $result[0]->ticket_image,
				'department_id' => $result[0]->department_id,
				'full_name' => $full_name,
				'ticket_priority' => $result[0]->ticket_priority,
				'created_at' => $result[0]->created_at,
				'description' => $result[0]->description,
				'assigned_to' => $result[0]->assigned_to,
				'ticket_status' => $result[0]->ticket_status,
				'ticket_note' => $result[0]->ticket_note,
				'ticket_remarks' => $result[0]->ticket_remarks,
				'message' => $result[0]->message,
				'all_employees' => $this->Xin_model->all_employees(),
				);
		$data['breadcrumbs'] = $this->lang->line('xin_ticket_details');
		$data['path_url'] = 'tickets_detail';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/tickets/ticket_details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}		  
     }
	 
	// Validate and update info in database // assign_ticket
	public function assign_ticket() {
	
		if($this->input->post('type')=='ticket_user') {		
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
		$id = $this->input->post('ticket_id');
		$result = $this->Tickets_model->assign_ticket_user($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_ticket_assigned_employee');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	 // Validate and update info in database // update_status
	public function update_status() {
	
		if($this->input->post('type')=='update_status') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'ticket_status' => $this->input->post('status'),
		'ticket_remarks' => $this->input->post('remarks'),
		);
		$id = $this->input->post('status_ticket_id');
		$result = $this->Tickets_model->update_status($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_ticket_status_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // add_note
	public function add_note() {
	
		if($this->input->post('type')=='add_note') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'ticket_note' => $this->input->post('ticket_note')
		);
		$id = $this->input->post('token_note_id');
		$result = $this->Tickets_model->update_note($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_ticket_note_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 public function ticket_users() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'ticket_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/get_ticket_users", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	public function delete() {
		if($this->input->post('is_ajax') == 2) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_ticket_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function comment_delete() {
		if($this->input->post('data') == 'ticket_comment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_comment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_ticket_comment_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function attachment_delete() {
		if($this->input->post('data') == 'ticket_attachment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_attachment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_ticket_attachment_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
