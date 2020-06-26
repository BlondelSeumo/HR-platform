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

class Assets extends MY_Controller
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
          //load the models
          $this->load->model('Xin_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Department_model');
		  $this->load->model('Assets_model');
		  $this->load->model('Custom_fields_model');
     }
	 	
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_assets!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_assets').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_assets');
		$data['path_url'] = 'assets';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_assets_categories'] = $this->Assets_model->get_all_assets_categories();
		if(in_array('25',$role_resources_ids)) {
			$id = $this->uri->segment(4);
			$edata = array(
				'is_notify' => 0,
			);
			$this->Xin_model->update_notification_record($edata,$id,$session['user_id'],'asset');
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/assets/assets_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function category() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_assets_category').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_assets_category');
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'assets_category';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('26',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/assets/assets_category_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
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
			$this->load->view("admin/assets/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
			 	 
	 // category list
	public function category_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/languages_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$assets_category = $this->Assets_model->get_assets_categories();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();
		
          foreach($assets_category->result() as $r) {						
		  			
			if(in_array('267',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->assets_category_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('268',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->assets_category_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $edit.$delete;
									 			  				
			$data[] = array($combhr,
				$r->category_name
			);
		}
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $assets_category->num_rows(),
                 "recordsFiltered" => $assets_category->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// assets list
	public function assets_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/languages_list", $data);
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
			$assets = $this->Assets_model->get_assets();
		} else {
			if(in_array('265',$role_resources_ids)) {
				$assets = $this->Assets_model->get_company_assets($user_info[0]->company_id);
			} else {
				$assets = $this->Assets_model->get_employee_assets($session['user_id']);
			}
		}
		$data = array();
		
          foreach($assets->result() as $r) {						
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
			 	$comp_name = '--';	
			}
			// get category
			$assets_category = $this->Assets_model->read_assets_category_info($r->assets_category_id);
			if(!is_null($assets_category)){
				$category = $assets_category[0]->category_name;
			} else {
			 	$category = '--';	
			}
			//working?
			if($r->is_working==1){
				$working = $this->lang->line('xin_yes');
			} else {
				$working = $this->lang->line('xin_no');
			}
			// get user > added by
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			if(in_array('263',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->assets_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('264',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->assets_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('265',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-asset_id="'. $r->assets_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			$iname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_created_at').': '.$created_at.'<i></i></i></small>';					 			  				
			$data[] = array($combhr,
				$iname,
				$category,
				$r->company_asset_code,
				$working,
				$full_name,
				$comp_name
			);
		}
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $assets->num_rows(),
                 "recordsFiltered" => $assets->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	public function asset_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('asset_id');
		$result = $this->Assets_model->read_assets_info($id);
		$data = array(
				'assets_id' => $result[0]->assets_id,
				'assets_category_id' => $result[0]->assets_category_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'company_asset_code' => $result[0]->company_asset_code,
				'name' => $result[0]->name,
				'purchase_date' => $result[0]->purchase_date,
				'invoice_number' => $result[0]->invoice_number,
				'manufacturer' => $result[0]->manufacturer,
				'serial_number' => $result[0]->serial_number,
				'warranty_end_date' => $result[0]->warranty_end_date,
				'asset_note' => $result[0]->asset_note,
				'asset_image' => $result[0]->asset_image,
				'is_working' => $result[0]->is_working,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_assets_categories' => $this->Assets_model->get_all_assets_categories(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/assets/dialog_asset', $data);
		} else {
			redirect('admin/');
		}
	}
	 	 	 
	// Validate and add info in database
	public function add_category() {
	
		if($this->input->post('add_type')=='add_category') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// set data
		$data = array(
		'category_name' => $this->input->post('name'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Assets_model->add_assets_category($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_assets_category_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_asset() {
	
		if($this->input->post('add_type')=='add_asset') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('category_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_category_field');
		} else if($this->input->post('asset_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_name_field');
		} /*else if($this->input->post('company_asset_code')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		}*/ else if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} /*else if($this->input->post('manufacturer')==='') {
        	$Return['error'] = $this->lang->line('xin_error_manufacturer_field');
		} else if($this->input->post('asset_note')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_note_field');
		}*/ 
		/* Check if file uploaded..*/
		/*else if($_FILES['asset_image']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_asset_image_field');
		} else {
			if(is_uploaded_file($_FILES['asset_image']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['asset_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["asset_image"]["tmp_name"];
					$asset_image = "uploads/asset_image/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["asset_image"]["name"]);
					$newfilename = 'asset_image_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $asset_image.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_asset_image_attachment');
				}
			}
		}*/
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		if(is_uploaded_file($_FILES['asset_image']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','gif');
			$filename = $_FILES['asset_image']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["asset_image"]["tmp_name"];
				$asset_image = "uploads/asset_image/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$lname = basename($_FILES["asset_image"]["name"]);
				$newfilename = 'asset_image_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $asset_image.$newfilename);
				$fname = $newfilename;
			} else {
				$Return['error'] = $this->lang->line('xin_error_asset_image_attachment');
			}
		} else {
			$fname = '';
		}
		$module_attributes = $this->Custom_fields_model->assets_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();	
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
		// set data
		$data = array(
		'assets_category_id' => $this->input->post('category_id'),
		'name' => $this->input->post('asset_name'),
		'company_asset_code' => $this->input->post('company_asset_code'),
		'is_working' => $this->input->post('is_working'),
		'company_id' => $this->input->post('company_id'),
		'employee_id' => $this->input->post('employee_id'),
		'purchase_date' => $this->input->post('purchase_date'),
		'invoice_number' => $this->input->post('invoice_number'),
		'manufacturer' => $this->input->post('manufacturer'),
		'serial_number' => $this->input->post('serial_number'),
		'warranty_end_date' => $this->input->post('warranty_end_date'),
		'asset_note' => $this->input->post('asset_note'),
		'asset_image' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$iresult = $this->Assets_model->add_asset($data);
		if ($iresult) {
			$Return['result'] = $this->lang->line('xin_success_asset_added');
			$id = $iresult;
			// notificaions
			$nticket_data = array(
			'module_name' => 'asset',
			'module_id' => $id,
			'employee_id' => $this->input->post('employee_id'),
			'is_notify' => '1',
			'created_at' => date('d-m-Y h:i:s'),
			);
			$this->Xin_model->add_notifications($nticket_data);
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
	
	// Validate and add info in database
	public function update_asset() {
	
		if($this->input->post('edit_type')=='update_asset') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');		
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('category_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_category_field');
		} else if($this->input->post('asset_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_name_field');
		} /*else if($this->input->post('company_asset_code')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		}*/ else if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} /*else if($this->input->post('manufacturer')==='') {
        	$Return['error'] = $this->lang->line('xin_error_manufacturer_field');
		} else if($this->input->post('asset_note')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_note_field');
		}*/ 
		/* Check if file uploaded..*/
		else if($_FILES['asset_image']['size'] == 0) {
			// set data
			$module_attributes = $this->Custom_fields_model->assets_hrsale_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();	
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
			'assets_category_id' => $this->input->post('category_id'),
			'name' => $this->input->post('asset_name'),
			'company_asset_code' => $this->input->post('company_asset_code'),
			'is_working' => $this->input->post('is_working'),
			'company_id' => $this->input->post('company_id'),
			'employee_id' => $this->input->post('employee_id'),
			'purchase_date' => $this->input->post('purchase_date'),
			'invoice_number' => $this->input->post('invoice_number'),
			'manufacturer' => $this->input->post('manufacturer'),
			'serial_number' => $this->input->post('serial_number'),
			'warranty_end_date' => $this->input->post('warranty_end_date'),
			'asset_note' => $this->input->post('asset_note')
			);
			
			$result = $this->Assets_model->update_assets_record($data,$id);
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
			$module_attributes = $this->Custom_fields_model->assets_hrsale_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();	
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
			if(is_uploaded_file($_FILES['asset_image']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['asset_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["asset_image"]["tmp_name"];
					$asset_image = "uploads/asset_image/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["asset_image"]["name"]);
					$newfilename = 'asset_image_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $asset_image.$newfilename);
					$fname = $newfilename;
					
					// set data
					$data = array(
					'assets_category_id' => $this->input->post('category_id'),
					'name' => $this->input->post('asset_name'),
					'company_asset_code' => $this->input->post('company_asset_code'),
					'is_working' => $this->input->post('is_working'),
					'company_id' => $this->input->post('company_id'),
					'employee_id' => $this->input->post('employee_id'),
					'purchase_date' => $this->input->post('purchase_date'),
					'invoice_number' => $this->input->post('invoice_number'),
					'manufacturer' => $this->input->post('manufacturer'),
					'serial_number' => $this->input->post('serial_number'),
					'warranty_end_date' => $this->input->post('warranty_end_date'),
					'asset_note' => $this->input->post('asset_note'),
					'asset_image' => $fname
					);
					
					$result = $this->Assets_model->update_assets_record($data,$id);
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
					$Return['error'] = $this->lang->line('xin_error_asset_image_attachment');
				}
			}
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_asset_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_assets_category() {
	
		if($this->input->post('edit_type')=='assets_category') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// set data
		$data = array(
		'category_name' => $this->input->post('name')
		);
		
		$result = $this->Assets_model->update_assets_category_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_assets_category_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function read_assets_category() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('assets_category_id');
		$result = $this->Assets_model->read_assets_category_info($id);
		$data = array(
				'assets_category_id' => $result[0]->assets_category_id,
				'company_id' => $result[0]->company_id,
				'category_name' => $result[0]->category_name,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/assets/dialog_assets_category', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// delete record > table
	public function delete_asset() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Assets_model->delete_assets_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_asset_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record > table
	public function delete_assets_category() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Assets_model->delete_assets_category_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_assets_category_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>