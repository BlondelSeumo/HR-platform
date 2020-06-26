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

class Files extends MY_Controller
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
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->database();
          $this->load->library('form_validation');
          //load the models
          $this->load->model('Xin_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Department_model');
		  $this->load->model('Files_model');
		  $this->load->model("Company_model");
     }
	 
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_files_manager').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['breadcrumbs'] = $this->lang->line('xin_files_manager');
		$data['path_url'] = 'files_manager';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['get_company_types'] = $this->Company_model->get_company_types();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_document_types'] = $this->Employees_model->all_document_types();
		if($system[0]->module_files=='true'){
			if(in_array('47',$role_resources_ids)) {
				if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/file_manager/file_manager", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard/');
			}
		} else {
			redirect('admin/dashboard/');
		}
	}
	
	// Validate and update info in database // social info
	public function add_files() {
	
		if($this->input->post('type')=='file_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$file_setting = $this->Xin_model->read_file_setting_info(1);
		$ifilesize = 1000000 * $file_setting[0]->maximum_file_size;
		/* Check if file uploaded..*/
		if($this->input->post('department_id') === ''){
			$Return['error'] = $this->lang->line('xin_employee_error_department');
		} else if($_FILES['xin_file']['size'] == 0 && null ==$this->input->post('remove_profile_picture')) {
			$Return['error'] = $this->lang->line('xin_error_select_file');
		} else if($_FILES['xin_file']['size'] > $ifilesize) {
			$Return['error'] = $this->lang->line('xin_error_file_size_is').' '.$file_setting[0]->maximum_file_size.'MB';
		} else {
			if(is_uploaded_file($_FILES['xin_file']['tmp_name'])) {
				
				//checking image type
				$allowed =  explode( ',',$file_setting[0]->allowed_extensions);
				$filename = $_FILES['xin_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				//if(filesize($_FILES['xin_file']['tmp_name']) > 0) {
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["xin_file"]["tmp_name"];
						$profile = "uploads/files/";
						$set_img = base_url()."uploads/files/";
						// basename() may prevent filesystem traversal attacks;
						// further validation/sanitation of the filename may be appropriate
						$name = basename($_FILES["xin_file"]["name"]);
						$newfilename = 'file_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						// file name
						$fname = $newfilename;
						// file size
						$fsize = $_FILES['xin_file']['size'];
						// file size
						$fext = $ext;
						
						//UPDATE Employee info in DB
						$data = array(
						'department_id' => $this->input->post('department_id'),
						'user_id' => $this->input->post('user_id'),
						'file_name' => $fname,
						'file_size' => $fsize,
						'file_extension' => $fext,
						'created_at' => date('Y-m-d h:i:s')
						);
						
						$result = $this->Files_model->add($data);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('xin_success_file_uploaded');
						} else {
							$Return['error'] = $this->lang->line('xin_error_msg');
						}
						$this->output($Return);
						exit;
						
					} else {
						$Return['error'] = $this->lang->line('xin_upload_file_only_for_resume').' '.$file_setting[0]->allowed_extensions;
					}
				//}
				//else {
//					$Return['error'] = 'File size is greater than .'.$file_setting[0]->maximum_file_size.'MB';
//				}//size
				}
			}
							
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}
	
	// all documents - listing
	public function files_list() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/file_manager/file_manager", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(5);
		if($id=='0'){
			$file = $this->Files_model->get_files();
		} else {
			$file = $this->Files_model->department_files($id);
		}
		
		$data = array();

        foreach($file->result() as $r) {
			
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';	
			}
			$fsize = $this->Files_model->format_size_units($r->file_size);
			  
			$created_at = $this->Xin_model->set_date_time_format($r->created_at);
			if($r->file_name!='' && $r->file_name!='no file') {
			 $functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=files&filename='.$r->file_name.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
			 } else {
				 $functions ='';
			 }
			 		
		$data[] = array(
			$functions.'<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-file_id="'. $r->file_id . '" data-field_type="file_manager"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->file_id . '" data-token_type="document"><span class="fas fa-trash-restore"></span></button></span>',
			$r->file_name,
			$department_name,
			$fsize,
			$r->file_extension,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $file->num_rows(),
			 "recordsFiltered" => $file->num_rows(),
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
			$this->load->view("admin/file_manager/file_manager", $data);
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
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-document_id="'. $r->document_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-document-id="'. $r->document_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('249',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-document_id="'. $r->document_id . '"><span class="fa fa-eye"></span></button></span>';
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
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('file_id');
		$result = $this->Files_model->read_file_information($id);
		$data = array(
				'file_id' => $result[0]->file_id,
				'department_id' => $result[0]->department_id,
				'file_name' => $result[0]->file_name
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/file_manager/dialog_file', $data);
		} else {
			redirect('');
		}
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
		$this->load->view('admin/file_manager/dialog_official_document', $data);
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='file') {
			
		$id = $this->input->post('file_id');
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('file_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_file_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$fname = $this->input->post('file_name').'.'.$this->input->post('ext_name');
		$directory = "uploads/files/";
			
		// get department
		rename($directory.$this->input->post('oldfname'), $directory.$fname);
	
		$data = array(
		'file_name' => $fname
		);
		
		$result = $this->Files_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_file_name_updated');
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
	public function setting_info() {
	
		if($this->input->post('type')=='setting_info') {
			
		$id = 1;
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('maximum_file_size')==='') {
        	$Return['error'] = $this->lang->line('xin_error_max_file_size_required');
		} else if($this->input->post('allowed_extensions')==='') {
        	$Return['error'] = $this->lang->line('xin_error_file_extension_required');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$allowed_extensions = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('allowed_extensions'));
						
		$data = array(
		'maximum_file_size' => $this->input->post('maximum_file_size'),
		'allowed_extensions' => $allowed_extensions,
		'is_enable_all_files' => $this->input->post('view_all_files'),
		'updated_at' => date('Y-m-d h:i:s')
		);
		
		$result = $this->Files_model->update_file_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_file_settings_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 // delete employee record
	public function delete() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Files_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_file_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
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
?>