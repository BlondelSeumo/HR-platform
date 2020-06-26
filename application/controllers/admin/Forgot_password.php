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

class Forgot_password extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('email');
		//load the model
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
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
		$data['title'] = $this->lang->line('xin_forgot_password_link');
		$this->load->view('admin/auth/forgot_password', $data);
	}
	
	public function send_mail() {
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($this->input->post('iemail')==='') {
			$Return['error'] = $this->lang->line('xin_error_enter_email_address');
		} else if(!filter_var($this->input->post('iemail'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		if($this->input->post('iemail')) {
	
			//$this->email->set_mailtype("html");
			//get company info
			$cinfo = $this->Xin_model->read_company_setting_info(1);
			//get email template
			$template = $this->Xin_model->read_email_template(2);
			//get employee info
			$query = $this->Xin_model->read_user_info_byemail($this->input->post('iemail'));
			
			$user = $query->num_rows();
			if($user > 0) {
				
				$user_info = $query->result();
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
				//$cid = $this->email->attachment_cid($logo);
				
				$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->username,$user_info[0]->email,$user_info[0]->password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				$this->email->from($cinfo[0]->email, $cinfo[0]->company_name);
				$this->email->to($this->input->post('iemail'));
				
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
			
				$Return['result'] = $this->lang->line('xin_success_sent_forgot_password');
			} else {
				/* Unsuccessful attempt: Set error message */
				$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
			}
			$this->output($Return);
			exit;
		}
	}
}
