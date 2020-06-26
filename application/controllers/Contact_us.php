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

class Contact_us extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->library('email');
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
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_rec_contact_us');
		$data['path_url'] = 'job_contact';
		$data['subview'] = $this->load->view("frontend/hrsale/contact", $data, TRUE);
		$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
     }
	 
	 public function send_mail() {
				
		if($this->input->post('type')=='contact') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			/* Server side PHP input validation */
			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('xin_error_name_field');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('xin_error_cemail_field');
			} else if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
			} else if($this->input->post('message')==='') {
				$Return['error'] = "Message field is required.";
			}
			$fd_message = $this->input->post('message');	
			$qfd_message = htmlspecialchars(addslashes($fd_message), ENT_QUOTES);
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if($this->input->post('email')) {
		
				//$this->email->set_mailtype("html");
				//get setting info 
				$setting = $this->Xin_model->read_setting_info(1);
				$company = $this->Xin_model->read_company_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {
					$this->email->set_mailtype("html");
					
					//get company info
					$cinfo = $this->Xin_model->read_company_setting_info(1);
					//get email template
					$template = $this->Xin_model->read_email_template(8);
							
					$subject = 'Contact - '.$cinfo[0]->company_name;
					$logo = base_url().'uploads/logo/signin/'.$company[0]->sign_in_logo;
					
					// get user full name
					$full_name = $this->input->post('name');
					//
					$message = '
				<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
				<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>Full Name: '.$this->input->post('name').'<br>Email: '.$this->input->post('email').'<br>Message: '.htmlspecialchars_decode(stripslashes($qfd_message)).'</div>';
					
					$this->email->from($this->input->post('email'));
					$this->email->to($cinfo[0]->email);
					
					$this->email->subject($subject);
					$this->email->message($message);
					
					$this->email->send();
					$Return['result'] ='Message has been sent.';
					$this->session->set_flashdata('sent_message', 'Message has been sent.');
				}
				$this->output($Return);
				exit;
			}
		}
	}
}
