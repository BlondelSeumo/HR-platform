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

class Company extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Company_model");
		$this->load->model("Xin_model");
		$this->load->model("Custom_fields_model");
		$this->load->model("Employees_model");
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
		$data['title'] = $this->lang->line('module_company_title').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['get_company_types'] = $this->Company_model->get_company_types();
		$data['breadcrumbs'] = $this->lang->line('module_company_title');
		$data['path_url'] = 'company';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('5',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/company/company_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }    
	 public function official_documents() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_official_documents').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['get_company_types'] = $this->Company_model->get_company_types();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_document_types'] = $this->Employees_model->all_document_types();
		$data['breadcrumbs'] =$this->lang->line('xin_hr_official_documents');
		$data['path_url'] = 'company_license';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('5',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/company/official_document_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
	 public function company_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/company/company_list", $data);
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
			$company = $this->Company_model->get_companies();
		} else {
			$company = $this->Company_model->get_company_single($user_info[0]->company_id);
		}
		$data = array();

          foreach($company->result() as $r) {
			  
			  // get country
			  $country = $this->Xin_model->read_country_info($r->country);
			  if(!is_null($country)){
			  	$c_name = $country[0]->country_name;
			  } else {
				  $c_name = '--';	
			  }
			 /*
			  // get user
			  $user = $this->Xin_model->read_user_info($r->added_by);
			 
			  if(!is_null($user)){
			  	$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			  } else {
				  $full_name = '--';	
			  }*/
			  // company type
			  $ctype = $this->Company_model->read_company_type($r->type_id);
			  if(!is_null($ctype)){
			  	$type_name = $ctype[0]->name;
			  } else {
				 $type_name = '--';	
			  }
			  
			  if(in_array('247',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-company_id="'. $r->company_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->company_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('249',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-company_id="'. $r->company_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;//
			$icname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_type').': '.$type_name.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('dashboard_contact').'#: '.$r->contact_number.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_website').': '.$r->website_url.'<i></i></i></small>';
		   $data[] = array(
				$combhr,
				$icname,
				$r->email,
				$r->city,
				$c_name,
				$r->default_currency,
				$r->default_timezone
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $company->num_rows(),
                 "recordsFiltered" => $company->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 public function document_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/company/official_document_list", $data);
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
			$company = $this->Company_model->get_company_documents();
		} else {
			$company = $this->Company_model->get_company_documents_single($user_info[0]->company_id);
		}
		$data = array();

          foreach($company->result() as $r) {
			  			  
			$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->document_type;
			} else {
				$document_d = '--';
			}
			
			if(in_array('247',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-document_id="'. $r->document_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('249',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-document_id="'. $r->document_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$company_id = $this->Company_model->read_company_information($r->company_id);
			if(!is_null($company_id)){
				$company_name = $company_id[0]->name;
			} else {
				$company_name = '--';	
			}
			if($r->license_notification==0){
				$notification = $this->lang->line('xin_hr_license_no_alarm');
			} else if($r->license_notification==1){
				$notification = $this->lang->line('xin_hr_license_alarm_1');
			} else if($r->license_notification==2){
				$notification = $this->lang->line('xin_hr_license_alarm_3');
			} else {
				$notification = $this->lang->line('xin_hr_license_alarm_6');
			}
			$doc_view='<a href="'.site_url('admin/download?type=company/official_documents&filename=').$r->document.'">'.$this->lang->line('xin_view').'</a>';
			$combhr = $edit.$view.$delete;
			$ilicense_name = $r->license_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_hr_official_license_number').': '.$r->license_number.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_hr_view_document').': '.$doc_view.'<i></i></i></small>';
		   $data[] = array(
				$combhr,
				$document_d,
				$ilicense_name,
				$company_name,
				$r->expiry_date,
				$notification
		   );
          }
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $company->num_rows(),
                 "recordsFiltered" => $company->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('company_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_information($id);
		$data = array(
				'company_id' => $result[0]->company_id,
				'name' => $result[0]->name,
				'username' => $result[0]->username,
				'password' => $result[0]->password,
				'type_id' => $result[0]->type_id,
				'government_tax' => $result[0]->government_tax,
				'trading_name' => $result[0]->trading_name,
				'registration_no' => $result[0]->registration_no,
				'email' => $result[0]->email,
				'logo' => $result[0]->logo,
				'contact_number' => $result[0]->contact_number,
				'website_url' => $result[0]->website_url,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'idefault_currency' => $result[0]->default_currency,
				'idefault_timezone' => $result[0]->default_timezone,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/company/dialog_company', $data);
	}
	public function read_document() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('document_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_document_info($id);
		$data = array(
				'document_id' => $result[0]->document_id,
				'license_name' => $result[0]->license_name,
				'document_type_id' => $result[0]->document_type_id,
				'company_id' => $result[0]->company_id,
				'expiry_date' => $result[0]->expiry_date,
				'license_number' => $result[0]->license_number,
				'license_notification' => $result[0]->license_notification,
				'document' => $result[0]->document,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_document_types' => $this->Employees_model->all_document_types(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/company/dialog_official_document', $data);
	}
	public function read_info()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('company_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Company_model->read_company_information($id);
		$data = array(
				'company_id' => $result[0]->company_id,
				'name' => $result[0]->name,
				'username' => $result[0]->username,
				'password' => $result[0]->password,
				'type_id' => $result[0]->type_id,
				'government_tax' => $result[0]->government_tax,
				'trading_name' => $result[0]->trading_name,
				'registration_no' => $result[0]->registration_no,
				'email' => $result[0]->email,
				'logo' => $result[0]->logo,
				'contact_number' => $result[0]->contact_number,
				'website_url' => $result[0]->website_url,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'idefault_currency' => $result[0]->default_currency,
				'idefault_timezone' => $result[0]->default_timezone,
				'all_countries' => $this->Xin_model->get_countries(),
				'get_company_types' => $this->Company_model->get_company_types()
				);
		$this->load->view('admin/company/view_company.php', $data);
	}
	
	// Validate and add info in database
	public function add_company() {
	
		if($this->input->post('add_type')=='company') {
		// Check validation for user input
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		
		$name = $this->input->post('name');
		$trading_name = $this->input->post('trading_name');
		$registration_no = $this->input->post('registration_no');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$website = $this->input->post('website');
		$address_1 = $this->input->post('address_1');
		$address_2 = $this->input->post('address_2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zipcode = $this->input->post('zipcode');
		$country = $this->input->post('country');
		$user_id = $this->input->post('user_id');
		$file = $_FILES['logo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if( $this->input->post('company_type')==='') {
			$Return['error'] = $this->lang->line('xin_error_ctype_field');
		} else if($contact_number==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($website==='') {
			$Return['error'] = $this->lang->line('xin_error_website_field');
		}  else if($city==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($zipcode==='') {
			$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		} else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		} else if($this->input->post('default_currency')==='') {
			$Return['error'] = $this->lang->line('xin_default_currency_field_error');
		} else if($this->input->post('default_timezone')==='') {
			$Return['error'] = $this->lang->line('xin_default_timezone_field_error');
		}
		
		/* Check if file uploaded..*/
		else if($_FILES['logo']['size'] == 0) {
			$fname = 'no file';
			 $Return['error'] = $this->lang->line('xin_error_logo_field');
		} else {
			if(is_uploaded_file($_FILES['logo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['logo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["logo"]["tmp_name"];
					$bill_copy = "uploads/company/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["logo"]["name"]);
					$newfilename = 'logo_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$module_attributes = $this->Custom_fields_model->company_hrsale_module_attributes();
		$count_module_attributes = $this->Custom_fields_model->count_company_module_attributes();	
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
		'name' => $this->input->post('name'),
		'type_id' => $this->input->post('company_type'),
		'username' => $this->input->post('username'),
		'password' => $this->input->post('password'),
		'government_tax' => $this->input->post('xin_gtax'),
		'trading_name' => $this->input->post('trading_name'),
		'registration_no' => $this->input->post('registration_no'),
		'email' => $this->input->post('email'),
		'contact_number' => $this->input->post('contact_number'),
		'website_url' => $this->input->post('website'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		'default_currency' => $this->input->post('default_currency'),
		'default_timezone' => $this->input->post('default_timezone'),
		'added_by' => $this->input->post('user_id'),
		'logo' => $fname,
		'created_at' => date('d-m-Y'),
		
		);
		$iresult = $this->Company_model->add($data);
		if ($iresult) {
			$Return['result'] = $this->lang->line('xin_success_add_company');
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
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
		// Validate and add info in database
	public function add_official_document() {
	
		if($this->input->post('add_type')=='official_document') {
		// Check validation for user input
		$this->form_validation->set_rules('license_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('company_id', 'Company', 'trim|required|xss_clean');
		$this->form_validation->set_rules('license_number', 'License Number', 'trim|required|xss_clean');
		
		$license_name = $this->input->post('license_name');
		$company_id = $this->input->post('company_id');
		$expiry_date = $this->input->post('expiry_date');
		$license_number = $this->input->post('license_number');
		$license_notification = $this->input->post('license_notification');
		$user_id = $this->input->post('user_id');
		$file = $_FILES['scan_file']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($license_name==='') {
			$Return['error'] = $this->lang->line('xin_co_error_license_name');
		} else if($this->input->post('document_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} else if($license_number==='') {
			$Return['error'] = $this->lang->line('xin_co_error_license_number');
		} else if( $this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($expiry_date==='') {
			$Return['error'] = $this->lang->line('xin_co_error_license_exp_date');
		} 		
		/* Check if file uploaded..*/
		else if($_FILES['scan_file']['size'] == 0) {
			 $fname = 'no file';
			 $Return['error'] = $this->lang->line('xin_co_error_license_off_doc');
		} else {
			if(is_uploaded_file($_FILES['scan_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx');
				$filename = $_FILES['scan_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["scan_file"]["tmp_name"];
					$bill_copy = "uploads/company/official_documents/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["scan_file"]["name"]);
					$newfilename = 'official_documents_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'document_type_id' => $this->input->post('document_type_id'),
		'license_name' => $license_name,
		'company_id' => $company_id,
		'expiry_date' => $expiry_date,
		'license_number' => $license_number,
		'license_notification' => $license_notification,
		'added_by' => $this->input->post('user_id'),
		'document' => $fname,
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Company_model->add_document($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_official_document_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_official_document() {
	
		if($this->input->post('edit_type')=='document') {
		$id = $this->uri->segment(4);
		// Check validation for user input
		$this->form_validation->set_rules('license_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('company_id', 'Company', 'trim|required|xss_clean');
		$this->form_validation->set_rules('license_number', 'Number', 'trim|required|xss_clean');
		$license_name = $this->input->post('license_name');
		$company_id = $this->input->post('company_id');
		$expiry_date = $this->input->post('expiry_date');
		$license_number = $this->input->post('license_number');
		$license_notification = $this->input->post('license_notification');
		$user_id = $this->input->post('user_id');
		$file = $_FILES['scan_file']['tmp_name'];
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($license_name==='') {
			$Return['error'] = $this->lang->line('xin_co_error_license_name');
		} else if($this->input->post('document_type_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} else if($license_number==='') {
			$Return['error'] = $this->lang->line('xin_co_error_license_number');
		} else if( $this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($expiry_date==='') {
			$Return['error'] = $this->lang->line('xin_co_error_license_exp_date');
		}		
		/* Check if file uploaded..*/
		else if($_FILES['scan_file']['size'] == 0) {
			 $fname = 'no file';
			 $no_logo_data = array(
				'document_type_id' => $this->input->post('document_type_id'),
				'license_name' => $license_name,
				'company_id' => $company_id,
				'expiry_date' => $expiry_date,
				'license_number' => $license_number,
				'license_notification' => $license_notification
			 );
			 $result = $this->Company_model->update_company_document_record($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['scan_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx');
				$filename = $_FILES['scan_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["scan_file"]["tmp_name"];
					$bill_copy = "uploads/company/official_documents/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["scan_file"]["name"]);
					$newfilename = 'official_documents_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'document_type_id' => $this->input->post('document_type_id'),
					'license_name' => $license_name,
					'company_id' => $company_id,
					'expiry_date' => $expiry_date,
					'license_number' => $license_number,
					'license_notification' => $license_notification,
					'document' => $fname,
					);
					// update record > model
					$result = $this->Company_model->update_company_document_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_official_document_updated');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='company') {
		$id = $this->uri->segment(4);
		// Check validation for user input
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		$name = $this->input->post('name');
		$trading_name = $this->input->post('trading_name');
		$registration_no = $this->input->post('registration_no');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$website = $this->input->post('website');
		$address_1 = $this->input->post('address_1');
		$address_2 = $this->input->post('address_2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zipcode = $this->input->post('zipcode');
		$country = $this->input->post('country');
		$user_id = $this->input->post('user_id');
		$file = $_FILES['logo']['tmp_name'];
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if( $this->input->post('company_type')==='') {
			$Return['error'] = $this->lang->line('xin_error_ctype_field');
		} else if($contact_number==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($website==='') {
			$Return['error'] = $this->lang->line('xin_error_website_field');
		} else if($city==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($zipcode==='') {
			$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		} else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->input->post('default_currency')==='') {
			$Return['error'] = $this->lang->line('xin_default_currency_field_error');
		} else if($this->input->post('default_timezone')==='') {
			$Return['error'] = $this->lang->line('xin_default_timezone_field_error');
		}
		
		/* Check if file uploaded..*/
		else if($_FILES['logo']['size'] == 0) {
			 $fname = 'no file';
			 $module_attributes = $this->Custom_fields_model->company_hrsale_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_company_module_attributes();	
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
			 $no_logo_data = array(
			'name' => $this->input->post('name'),
			'type_id' => $this->input->post('company_type'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'government_tax' => $this->input->post('xin_gtax'),
			'trading_name' => $this->input->post('trading_name'),
			'registration_no' => $this->input->post('registration_no'),
			'email' => $this->input->post('email'),
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'default_currency' => $this->input->post('default_currency'),
			'default_timezone' => $this->input->post('default_timezone'),
			);
			 $result = $this->Company_model->update_record_no_logo($no_logo_data,$id);
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
			$module_attributes = $this->Custom_fields_model->company_hrsale_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_company_module_attributes();	
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
			if(is_uploaded_file($_FILES['logo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['logo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["logo"]["tmp_name"];
					$bill_copy = "uploads/company/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["logo"]["name"]);
					$newfilename = 'logo_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'name' => $this->input->post('name'),
					'type_id' => $this->input->post('company_type'),
					'government_tax' => $this->input->post('xin_gtax'),
					'trading_name' => $this->input->post('trading_name'),
					'registration_no' => $this->input->post('registration_no'),
					'email' => $this->input->post('email'),
					'contact_number' => $this->input->post('contact_number'),
					'website_url' => $this->input->post('website'),
					'address_1' => $this->input->post('address_1'),
					'address_2' => $this->input->post('address_2'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zipcode' => $this->input->post('zipcode'),
					'country' => $this->input->post('country'),
					'logo' => $fname,		
					);
					// update record > model
					$result = $this->Company_model->update_record($data,$id);
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
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_company');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
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
			$result = $this->Company_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_company');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function delete_document() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Company_model->delete_doc_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_hr_official_document_deleted');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
