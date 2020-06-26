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

class Awards extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Awards_model");
		$this->load->model("Xin_model");
		$this->load->library('email');
		$this->load->model("Department_model");
		$this->load->model("Custom_fields_model");
		$this->load->model("Finance_model");
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
		if($system[0]->module_awards!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_awards').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_award_types'] = $this->Awards_model->all_award_types();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_awards');
		$data['path_url'] = 'awards';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('14',$role_resources_ids)) {
			$id = $this->uri->segment(4);
			$edata = array(
				'is_notify' => 0,
			);
			$this->Xin_model->update_notification_record($edata,$id,$session['user_id'],'awards');
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/awards/award_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function award_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/awards/award_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		//get_company_awards
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$award = $this->Awards_model->get_awards();
		} else {
			if(in_array('232',$role_resources_ids)) {
				$award = $this->Awards_model->get_company_awards($user_info[0]->company_id);
			} else {
				$award = $this->Awards_model->get_employee_awards($session['user_id']);
			}
		}			
		
		$data = array();

        foreach($award->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Xin_model->read_user_info($r->employee_id);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		// get award type
		$award_type = $this->Awards_model->read_award_type_information($r->award_type_id);
		if(!is_null($award_type)){
			$award_type = $award_type[0]->award_type;
		} else {
			$award_type = '--';	
		}
		
		$d = explode('-',$r->award_month_year);
		$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
		$award_date = $get_month.', '.$d[0];
		// get currency
		if($r->cash_price == '') {
			$currency = $this->Xin_model->currency_sign(0);
		} else {
			$currency = $this->Xin_model->currency_sign($r->cash_price);
		}		
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		
		if(in_array('208',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-award_id="'. $r->award_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('209',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->award_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		if(in_array('232',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-award_id="'. $r->award_id . '"><span class="fa fa-eye"></span></button></span>';
		} else {
			$view = '';
		}
		$award_info = $award_type.'<br><small class="text-muted"><i>'.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_cash_price').': '.$currency.'<i></i></i></small>';
		$combhr = $edit.$view.$delete;
				
		$data[] = array(
			$combhr,
			$award_info,
			$full_name,
			$comp_name,
			$r->gift_item,
			$award_date
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $award->num_rows(),
			 "recordsFiltered" => $award->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
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
			$this->load->view("admin/awards/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('award_id');
		$result = $this->Awards_model->read_award_information($id);
		$data = array(
				'award_id' => $result[0]->award_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'award_type_id' => $result[0]->award_type_id,
				'gift_item' => $result[0]->gift_item,
				'award_photo' => $result[0]->award_photo,
				'cash_price' => $result[0]->cash_price,
				'award_month_year' => $result[0]->award_month_year,
				'award_information' => $result[0]->award_information,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_award_types' => $this->Awards_model->all_award_types(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/awards/dialog_award', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_award() {
	
		if($this->input->post('add_type')=='award') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('award_type_id')==='') {
			$Return['error'] = $this->lang->line('xin_award_error_award_type');
		} else if($this->input->post('award_date')==='') {
			$Return['error'] = $this->lang->line('xin_award_error_award_date');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_award_error_award_month');
		}  else if($this->input->post('cash')!='' && $_FILES['award_picture']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_award_error_award_photo');
		} else {
			if(is_uploaded_file($_FILES['award_picture']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['award_picture']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["award_picture"]["tmp_name"];
					$profile = "uploads/award/";
					$set_img = base_url()."uploads/award/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["award_picture"]["name"]);
					$newfilename = 'award_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;			
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			} else {
				$fname = '';
			}
		}	
		if($Return['error']!=''){
			$this->output($Return);
    	}
		
		$module_attributes = $this->Custom_fields_model->awards_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();	
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
		$system_settings = system_settings_info(1);	
		if($system_settings->online_payment_account == ''){
			$online_payment_account = 0;
		} else {
			$online_payment_account = $system_settings->online_payment_account;
		}		
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'award_type_id' => $this->input->post('award_type_id'),
		'created_at' => $this->input->post('award_date'),
		'award_photo' => $fname,
		'award_month_year' => $this->input->post('month_year'),
		'gift_item' => $this->input->post('gift'),
		'cash_price' => $this->input->post('cash'),
		'description' => $qt_description,
		'award_information' => $this->input->post('award_information'),		
		);
		$iresult = $this->Awards_model->add($data);
		if ($iresult) {
			$Return['result'] = $this->lang->line('xin_award_success_added');
			$id = $iresult;
			// notificaions
			$nticket_data = array(
			'module_name' => 'awards',
			'module_id' => $id,
			'employee_id' => $this->input->post('employee_id'),
			'is_notify' => '1',
			'created_at' => date('d-m-Y h:i:s'),
			);
			$this->Xin_model->add_notifications($nticket_data);
			$ivdata = array(
			'amount' => $this->input->post('cash'),
			'account_id' => $online_payment_account,
			'transaction_type' => 'expense',
			'dr_cr' => 'cr',
			'transaction_date' => date('Y-m-d'),
			'payer_payee_id' => $this->input->post('employee_id'),
			'payment_method_id' => 3,
			'description' => 'Award Payments',
			'reference' => 'Award Payments',
			'invoice_id' => $id,
			'client_id' => $this->input->post('employee_id'),
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($ivdata);
			// update data in bank account
			$account_id = $this->Finance_model->read_bankcash_information($online_payment_account);
			$acc_balance = $account_id[0]->account_balance - $this->input->post('cash');
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$online_payment_account);
			
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
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {
		
			$this->email->set_mailtype("html");
			//get company info
			$cinfo = $this->Xin_model->read_company_setting_info(1);
			//get email template
			$template = $this->Xin_model->read_email_template(10);
			//get employee info
			$user_info = $this->Xin_model->read_user_info($this->input->post('employee_id'));
			
			$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
			// get award type
			$award_type = $this->Awards_model->read_award_type_information($this->input->post('award_type_id'));
					
			$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
			$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
			
			$d = explode('-',$this->input->post('month_year'));
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$award_date = $get_month.', '.$d[0];
			
			$message = '
		<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
		<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var employee_name}","{var award_name}","{var award_month}"),array($cinfo[0]->company_name,site_url(),$full_name,$award_type[0]->award_type,$award_date),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
			
			hrsale_mail($cinfo[0]->email,$cinfo[0]->company_name,$user_info[0]->email,$subject,$message);
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
	
		if($this->input->post('edit_type')=='award') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('award_type_id')==='') {
			$Return['error'] = $this->lang->line('xin_award_error_award_type');
		} else if($this->input->post('award_date')==='') {
			$Return['error'] = $this->lang->line('xin_award_error_award_date');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_award_error_award_month');
		}  		
		/* Check if file uploaded..*/
		else if($_FILES['award_picture']['size'] == 0) {
			$module_attributes = $this->Custom_fields_model->awards_hrsale_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();	
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
			$fname = '';
			 $data = array(
			'award_type_id' => $this->input->post('award_type_id'),
			'created_at' => $this->input->post('award_date'),
			'award_month_year' => $this->input->post('month_year'),
			'gift_item' => $this->input->post('gift'),
			'cash_price' => $this->input->post('cash'),
			'description' => $qt_description,
			'award_information' => $this->input->post('award_information'),		
			);
			 $result = $this->Awards_model->update_record($data,$id);
		} else {
			$module_attributes = $this->Custom_fields_model->awards_hrsale_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();	
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
			if(is_uploaded_file($_FILES['award_picture']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['award_picture']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["award_picture"]["tmp_name"];
					$bill_copy = "uploads/award/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["award_picture"]["name"]);
					$newfilename = 'award_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					 $data = array(
					'employee_id' => $this->input->post('employee_id'),
					'company_id' => $this->input->post('company_id'),
					'award_type_id' => $this->input->post('award_type_id'),
					'created_at' => $this->input->post('award_date'),
					'award_photo' => $fname,
					'award_month_year' => $this->input->post('month_year'),
					'gift_item' => $this->input->post('gift'),
					'cash_price' => $this->input->post('cash'),
					'description' => $qt_description,
					'award_information' => $this->input->post('award_information'),		
					);
					// update record > model
					$result = $this->Awards_model->update_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_award_success_updated');
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
						if(!empty($this->input->post($mattribute->attribute))){
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
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Awards_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_award_success_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
