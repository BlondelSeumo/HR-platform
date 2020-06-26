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

class Announcement extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Announcement_model");
		$this->load->model("Xin_model");
		$this->load->model("Company_model");
		$this->load->model("Location_model");
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
		$data['title'] = $this->lang->line('xin_announcements').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_announcements');
		$data['path_url'] = 'announcements';
		$data['get_all_companies'] = $this->Company_model->get_all_companies();
		$data['all_office_locations'] = $this->Location_model->all_office_locations();
		$data['all_departments'] = $this->Department_model->all_departments();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('11',$role_resources_ids)) {
		$id = $this->uri->segment(4);
		$edata = array(
			'is_notify' => 0,
		);
		$this->Xin_model->update_notification_record($edata,$id,$session['user_id'],'announcement');
		$data['subview'] = $this->load->view("admin/announcement/announcement_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load	
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function announcement_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$this->load->view("admin/announcement/announcement_list", $data);
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$announcement = $this->Announcement_model->get_announcements();
		} else {
			if(in_array('257',$role_resources_ids)) {
				$announcement = $this->Announcement_model->get_company_announcements($user_info[0]->company_id);
			} else {
				$announcement = $this->Announcement_model->get_department_announcements($user_info[0]->department_id);
			}
		}
		$data = array();

        foreach($announcement->result() as $r) {
			 			  
		// get date
		$sdate = $this->Xin_model->set_date_format($r->start_date);
		$edate = $this->Xin_model->set_date_format($r->end_date);
		
		$department = $this->Department_model->read_department_information($r->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		// get location
		$location = $this->Xin_model->read_location_info($r->location_id);
		if(!is_null($location)){
			$location_name = $location[0]->location_name;
		} else {
			$location_name = '--';	
		}
		if(in_array('255',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-announcement_id="'. $r->announcement_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('256',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->announcement_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		if(in_array('257',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-announcement_id="'. $r->announcement_id . '"><span class="fa fa-eye"></span></button></span>';
		} else {
			$view = '';
		}
		$combhr = $edit.$view.$delete;
		$ititle = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('xin_published_for').': '.$location_name.'('.$department_name.')'.'<i></i></i></small>';
		$data[] = array(
			$combhr,
			$ititle,
			$comp_name,
			$sdate,
			$edate
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $announcement->num_rows(),
			 "recordsFiltered" => $announcement->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('announcement_id');
		$result = $this->Announcement_model->read_announcement_information($id);
		$data = array(
				'announcement_id' => $result[0]->announcement_id,
				'title' => $result[0]->title,
				'company_id' => $result[0]->company_id,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'company_id' => $result[0]->company_id,
				'location_id' => $result[0]->location_id,
				'department_id' => $result[0]->department_id,
				'published_by' => $result[0]->published_by,
				'summary' => $result[0]->summary,
				'description' => $result[0]->description,
				'get_all_companies' => $this->Company_model->get_all_companies(),
				'all_office_locations' => $this->Location_model->all_office_locations(),
				'all_departments' => $this->Department_model->all_departments()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/announcement/dialog_announcement', $data);
		} else {
			redirect('admin/');
		}
	}
	 // get company > locations
	 public function get_company_elocations_dialog() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'company_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/announcement/get_company_elocations_dialog", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	// get location > departments
	 public function get_location_departments_dialog() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'location_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/announcement/get_location_departments_dialog", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get location > departments
	 public function get_location_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'location_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/employees/get_location_departments", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > departments
	 public function get_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/announcement/get_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	// Validate and add info in database
	public function add_announcement() {
	
		if($this->input->post('add_type')=='announcement') {		
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
		
		if($this->input->post('title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('company_id')==='') {
       		$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('location_id')==='') {
       		$Return['error'] = $this->lang->line('error_location_dept_field');
		} else if($this->input->post('department_id')==='') {
       		$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('summary')==='') {
       		$Return['error'] = $this->lang->line('xin_error_summary_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
			
		$module_attributes = $this->Custom_fields_model->announcements_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_announcements_module_attributes();	
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
		'title' => $this->input->post('title'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'department_id' => $this->input->post('department_id'),
		'description' => $qt_description,
		'summary' => $this->input->post('summary'),
		'is_notify' => 1,
		'published_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		
		);
		$iresult = $this->Announcement_model->add($data);
		if ($iresult) {
			$Return['result'] = $this->lang->line('xin_success_add_announcement');
			$id = $iresult;
			// notificaions
			$dep_employees = $this->Xin_model->get_department_employees($this->input->post('department_id'));
			foreach($dep_employees as $demployees){
				$nticket_data = array(
				'module_name' => 'announcement',
				'module_id' => $id,
				'employee_id' => $demployees->user_id,
				'is_notify' => '1',
				'created_at' => date('d-m-Y h:i:s'),
				);
				$this->Xin_model->add_notifications($nticket_data);
			}
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
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='announcement') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date_modal');
		$end_date = $this->input->post('end_date_modal');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('summary')==='') {
       		$Return['error'] = $this->lang->line('xin_error_summary_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$module_attributes = $this->Custom_fields_model->announcements_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_announcements_module_attributes();	
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
		'title' => $this->input->post('title'),
		'start_date' => $this->input->post('start_date_modal'),
		'end_date' => $this->input->post('end_date_modal'),
		'description' => $qt_description,
		'summary' => $this->input->post('summary')		
		);
		
		$result = $this->Announcement_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_announcement');
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
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Announcement_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_announcement');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
