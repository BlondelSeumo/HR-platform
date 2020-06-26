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

class Application_update extends MY_Controller
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
		  $this->load->library('unzip');
		  $this->load->library('zip');
     }
	 
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$user = $this->Xin_model->read_user_info($session['user_id']);
		$data['title'] = $this->lang->line('xin_hr_update_application');
		$data['breadcrumbs'] = $this->lang->line('xin_hr_update_application');
		$data['path_url'] = 'update_app';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if($user[0]->user_role_id==1) {
			$data['subview'] = $this->load->view("admin/application/update", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function upload_sql_only() {
	
		$id = $this->uri->segment(4);
		if($id=='is_ajax') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
				
			$db = array('default' => array());
			
					// assuming file.zip is in the same directory as the executing script.
					$remote_file_url = 'http://www.hrsale.com/hrsale_updates/abc.zip';
					
					// get the absolute path to $file
					$local_file = base_url();//'http://localhost/hrsale/uploads/csv/';//pathinfo(realpath($file), PATHINFO_DIRNAME);
					
			
					$full_path = 'http://localhost/hrsale/abc.zip';
             
					/**** without library ****/
					$zip = new ZipArchive;
		 
					if ($zip->open($full_path) === TRUE) 
					{
						$zip->extractTo(FCPATH);
						$zip->close();
					}
			// get db credentials
			/*require 'application/config/database.php';
			$hostname = $db['default']['hostname'];
			$username = $db['default']['username'];
			$password = $db['default']['password'];
			$database = $db['default']['database'];
				
			$sql = file_get_contents('http://www.hrsale.com/hrsale_updates/update_v1.1.7_to_v1.1.8test.sql');
			
			$conn = new PDO("mysql:host=$hostname;dbname=$database","$username","$password");
			if($conn->exec($sql)){				 
				 $Return['result'] = "Successfully imported to the $database.";
			}*/
			if($Return['error']!=''){
				$this->output($Return);
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function file_upload()
	 {
		 $local_file = 'http://localhost/hrsale/uploads/csv/';
	 $config['upload_path'] = $local_file;
	 $config['allowed_types'] = 'zip';
	 $config['max_size'] = '';
	 $this->load->library('upload', $config);
	 if ( ! $this->upload->do_upload())
	 {
	// $error = array('error' => $this->upload->display_errors());
	 $Return['error'] = "Doh! I couldn't open ==";
	 }
	 else
	 {
	 $data = array('upload_data' => $this->upload->data());
	 $zip = new ZipArchive;
	 $file = $data['upload_data']['full_path'];
	 chmod($file,0777);
	 if ($zip->open($file) === TRUE) {
		 $zip->extractTo($local_file);
		 $zip->close();
		 $Return['result'] =  "WOOT! extracted -- ll";
	 } else {
		 $Return['error'] = "Doh! I couldn't open 22==";
	 }
	 $Return['result'] =  "WOOT! extracted -- ll";
	 }
	 }
	
	public function update_app() {
	
		if($this->input->post('etype')=='update_application') {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'');
			//checking image type
			$config['upload_path']          = '../../uploads/csv/update_application/';
       		//$config['allowed_types']        = 'zip';
			$this->load->library('upload', $config);
			
			if($_FILES['file_zip']['size'] == 0) {
			 $Return['error'] = $this->lang->line('xin_hr_error_zip_installation');
			} else {
					
					
				$allowed =  array('zip');
				$filename = $_FILES['file_zip']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$zip = new ZipArchive;
					// assuming file.zip is in the same directory as the executing script.
					$remote_file_url = 'http://localhost/hrsale/ziptest.zip';
					
					// get the absolute path to $file
					$local_file = 'http://localhost/hrsale/uploads/csv/';//pathinfo(realpath($file), PATHINFO_DIRNAME);
					
					// or specify a destination directory
					if ($zip->open($remote_file_url) === TRUE) {
						 $zip->extractTo($local_file);
						 $zip->close();
						 $Return['result'] =  "WOOT! $remote_file_url extracted to $local_file";
					 } else {
						 $Return['error'] = "Doh! I couldn't open $remote_file_url";
					 }
					 $zip = new ZipArchive;
					 $res = $zip->open("uploads/".$filename);
					 if ($res === TRUE) {
		
					   // Unzip path
					   $extractpath = "files/";
		
					   // Extract file
					   $zip->extractTo($extractpath);
					   $zip->close();
		
					   $this->session->set_flashdata('msg','Upload & Extract successfully.');
					 } else {
					   $this->session->set_flashdata('msg','Failed to extract.');
					 }
					/*$zip = new ZipArchive;
					$res = $zip->open('http://localhost/hrsale/uploads/csv/ziptest.zip');
					if ($res === TRUE) {
					  // extract it to the path we determined above
					  $zip->extractTo('http://localhost/hrsale/uploads/csv/');
					  $zip->close();
					  $Return['result'] =  "WOOT! $file extracted to $path";
					} else {
					  $Return['error'] = "Doh! I couldn't open $file";
					}*/
					//$tmp_name = $_FILES["file_zip"]["tmp_name"];
					//$bill_copy = "uploads/csv/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					//$lname = basename($_FILES["file_zip"]["name"]);
					//$newfilename = 'file_zip_'.round(microtime(true)).'.'.$ext;
				//	move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					//$fname = $newfilename;
						
				} else {
						$Return['error'] = $this->lang->line('xin_error_attatchment_type_zip');
					}
			}
			//}	
			//else if($_FILES['file_sql']['size'] == 0) {
			 //$Return['error'] = $this->lang->line('xin_hr_error_mysql_installation');
			//}
			 /*else {
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
			}*/
		
			if($Return['error']!=''){
				$this->output($Return);
			}
			$this->output($Return);
		}
	}
} 
?>





