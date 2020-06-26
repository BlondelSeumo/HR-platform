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

class Languages extends MY_Controller
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
		  $this->load->model('Finance_model');
		  $this->load->model('Expense_model');
		  $this->load->model('Languages_model');
     }
	 	
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_language!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_languages').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_languages');
		$data['path_url'] = 'languages';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('89',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/languages/languages_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
			 	 
	 // languages list
	public function languages_list()
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
		
		
		$language = $this->Languages_model->get_languages();
		
		$data = array();
		
          foreach($language->result() as $r) {
			  
			$site_lang = $this->load->helper('language');
			$wz_lang = $site_lang->session->userdata('site_lang');
			$flag = '<img src="'.base_url().'uploads/languages_flag/'.$r->language_flag.'">';
			$name_flg = $flag.' '.$r->language_name;
			
			if($r->language_id=='1' ){
				$del = '';
				$success = $this->lang->line('xin_selected');
			} else {
				
				if($r->is_active==1){
					$success = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_employees_inactive').'"><button type="button" class="btn icon-btn btn-sm btn-success active-lang mr-1" data-language_id="'. $r->language_id . '" data-is_active="0"><span class="fa fa-check-circle"></span></button></span>';
				} else {
					$success = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_employees_active').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary active-lang mr-1" data-language_id="'. $r->language_id . '" data-is_active="1"><span class="fa fa-times-circle"></span></button></span>';
				}
			$del = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->language_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			}  			
			$data[] = array(
				$del,
				$name_flg,
				$r->language_code,
				$success,
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $language->num_rows(),
                 "recordsFiltered" => $language->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // Validate and update info in database
	public function active_language() {
	
		if($this->input->get('language_id')) {
			
		$id = $this->input->get('language_id');
		$is_active = $this->input->get('is_active');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($is_active == 1) {
			$data = array(
			'is_active' => '1'
			);
			$msg = $this->lang->line('xin_success_lang_activated');
		} else {
			$data = array(
			'is_active' => '0'
			);
			$msg = $this->lang->line('xin_success_lang_deactivated');
		}
		
		$result = $this->Languages_model->active_lang_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $msg;
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 	 
	// Validate and add info in database
	public function add_language() {
	
		if($this->input->post('add_type')=='add_language') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');

			
		/* Server side PHP input validation */		
		if($this->input->post('language_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_lang_name');
		} else if($this->input->post('language_code')==='') {
        	$Return['error'] = $this->lang->line('xin_error_lang_code');
		}
				
		/* Check if file uploaded..*/
		else if($_FILES['language_flag']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_lang_flag');
		} else {
			if(is_uploaded_file($_FILES['language_flag']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['language_flag']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["language_flag"]["tmp_name"];
					$language_flag = "uploads/languages_flag/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["language_flag"]["name"]);
					$newfilename = 'language_flag_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $language_flag.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_flag_allow_files');
				}
			}
		}
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		//The name of the directory that we need to create.
	//	$directoryName = 'images';
		$new_dir 	= 'application/language/'.$this->input->post('language_code');
		$directoryName 	= $new_dir.'/hrsale_lang.php';
		$directoryName2 	= $new_dir.'/index.html';
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir(dirname($directoryName), 0777, true);
		}
		// create language file
		$fp = fopen('hrsale_lang.php','w');
		fwrite($fp, 'data to be written');
		fclose($fp);
		// create index-html file
		$fp1 = fopen('index.html','w');
		fwrite($fp1, 'data to be written');
		fclose($fp1);
		
		$srcfile 	= 'application/language/english/hrsale_lang.php';
		$srcfile2 	= 'application/language/english/index.html';
		// copy files
		copy($srcfile2, $directoryName2);
		copy($srcfile, $directoryName);
		
		// set data
		$data = array(
		'language_name' => $this->input->post('language_name'),
		'language_code' => $this->input->post('language_code'),
		'language_flag' => $fname,
		'is_active' => 1,
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Languages_model->add($data);
		if ($result == TRUE) {
			//$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$Return['result'] = $this->lang->line('xin_success_lang_added');
		} else {
			//$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		//$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$this->output($Return);
		exit;
		}
	}
	 		
	// delete record
	public function delete_language() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$lang = $this->Languages_model->read_language_information($id);
			$new_dir 	= 'application/language/'.$lang[0]->language_code.'/';
			
			$files = glob($new_dir.'*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
				unlink($file); // delete file
			}
			rmdir($new_dir);
			
			// delete a flag
			$language_flag = "uploads/languages_flag/";
			$filename = $language_flag.$lang[0]->language_flag;
			unlink($filename);
			
			// delete record from db
			$result = $this->Languages_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_lang_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>