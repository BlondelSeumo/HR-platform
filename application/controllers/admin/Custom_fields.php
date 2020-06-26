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

class Custom_fields extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Custom_fields_model");
		$this->load->model("Department_model");
		$this->load->model("Xin_model");
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
		$data['title'] = $this->lang->line('xin_hrsale_custom_fields').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('xin_hrsale_custom_fields');
		$data['path_url'] = 'custom_fields';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('393',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/custom_fields/custom_fields_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function custom_fields_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/custom_fields/custom_fields_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$custom_fields = $this->Custom_fields_model->get_hrsale_module_attributes();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($custom_fields->result() as $r) {
			  
			  if(in_array('395',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-custom_field_id="'. $r->custom_field_id . '"><span class="fas fa-pencil-alt"></span></button></span></span>';
			} else {
				$edit = '';
			}
			if(in_array('396',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->custom_field_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if($r->validation == 0){
				$validation = $this->lang->line('xin_no');
			} else {
				$validation = $this->lang->line('xin_yes');
			}
			if($r->module_id == 1){
				$module = $this->lang->line('dashboard_employees');
			} else if($r->module_id == 2){
				$module = $this->lang->line('left_awards');
			} else if($r->module_id == 3){
				$module = $this->lang->line('dashboard_announcements');
			} else if($r->module_id == 4){
				$module = $this->lang->line('left_company');
			} else if($r->module_id == 5){
				$module = $this->lang->line('left_training');
			} else if($r->module_id == 6){
				$module = $this->lang->line('left_tickets');
			} else if($r->module_id == 7){
				$module = $this->lang->line('xin_assets');
			} else if($r->module_id == 8){
				$module = $this->lang->line('left_leave');
			} else {
				$module = $this->lang->line('left_training');
			}
			
			$combhr = $edit.$delete;

               $data[] = array(
			   		$combhr,
                    $module,
					$r->attribute,
					$r->attribute_label,
                    $r->attribute_type,
                    $validation,
					$r->priority
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $custom_fields->num_rows(),
                 "recordsFiltered" => $custom_fields->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
    }
	 	
	public function read_info()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('custom_field_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Custom_fields_model->read_hrsale_module_attributes($id);
		$data = array(
				'custom_field_id' => $result[0]->custom_field_id,
				'attribute' => $result[0]->attribute,
				'attribute_label' => $result[0]->attribute_label,
				'attribute_type' => $result[0]->attribute_type,
				'validation' => $result[0]->validation,
				'module_id' => $result[0]->module_id,
				'priority' => $result[0]->priority
				);
		if(!empty($session)){ 
			$this->load->view('admin/custom_fields/dialog_custom_fields', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_custom_field() {
	
		if($this->input->post('add_type')=='custom_field') {
		// Check validation for user input		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('module_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_modules_field');
		} else if($this->input->post('attribute')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		} else if (!ctype_alnum($this->input->post('attribute'))) {
			$Return['error'] = $this->lang->line('xin_field_name_lowercase_error');
		} else if($this->input->post('attribute_label')==='') {
			$Return['error'] = $this->lang->line('xin_hrsale_field_label_error');
		} else if($this->input->post('priority')==='') {
			$Return['error'] = $this->lang->line('xin_hrsale_field_priority_error');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'module_id' => $this->input->post('module_id'),
		'attribute' => $this->input->post('attribute'),
		'attribute_label' => $this->input->post('attribute_label'),
		'attribute_type' => $this->input->post('attribute_type'),
		'validation' => $this->input->post('validation'),
		'priority' => $this->input->post('priority'),
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Custom_fields_model->add($data);
		if ($result) {
			foreach($this->input->post('select_value') as $items){
				if($items !=''){
					$select_val = array(
					'custom_field_id' => $result,
					'select_label' => $items,
					);
					$this->Custom_fields_model->add_select_value($select_val);
				}
			}
			$Return['result'] = $this->lang->line('xin_hrsale_field_added_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->post('edit_type')=='custom_field') {
			
		$id = $this->uri->segment(4);
		
		// Check validation for user input		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('module_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_modules_field');
		} else if($this->input->post('attribute')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		} else if($this->input->post('attribute_label')==='') {
			$Return['error'] = $this->lang->line('xin_hrsale_field_label_error');
		} else if($this->input->post('priority')==='') {
			$Return['error'] = $this->lang->line('xin_hrsale_field_priority_error');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'module_id' => $this->input->post('module_id'),
		'attribute_label' => $this->input->post('attribute_label'),
		'validation' => $this->input->post('validation'),
		'priority' => $this->input->post('priority'),	
		);	
		
		$result = $this->Custom_fields_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hrsale_field_updated_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Custom_fields_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_hrsale_field_deleted_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
