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

class Auth extends MY_Controller
{
	
	public function __construct()
     {
          parent::__construct();
			//load the model		
			$this->load->model('Login_model');
			$this->load->model('Employees_model');
			$this->load->model('Users_model');
			$this->load->library('email');
			$this->load->model("Xin_model");
			$this->load->model("Designation_model");
			$this->load->model("Department_model");
			$this->load->model("Location_model");
			$this->load->model("Clients_model");
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
		$data['title'] = 'HR Software';
		$this->load->view('client/auth/login', $data);	
	}
	 
	public function login() {
	
		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		//$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		/*if ($this->form_validation->run() == FALSE)
		{
				//$this->load->view('myform');
		}*/
		$username = $this->input->post('iusername');
		$password = $this->input->post('ipassword');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($username==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} elseif($password===''){
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$result = $this->Clients_model->login($data);	
		
		if ($result == TRUE) {
			
				$result1 = $this->Clients_model->read_client_information($username);
				$session_data = array(
				'client_id' => $result1[0]->client_id,
				'client_username' => $result1[0]->client_username,
				'client_email' => $result1[0]->email
				);
				// Add user data in session
				$this->session->set_userdata('client_username', $session_data);
				$this->session->set_userdata('client_id', $session_data);
				$this->session->set_userdata('client_email', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				 $last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result1[0]->client_id; // user id
				  
				$this->Clients_model->update_record($last_data, $id);
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
				
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
				/*Return*/
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
			}
	}
	
	// forgot password.	
	public function forgot_password() {
		$data['title'] = $this->lang->line('xin_forgot_password_link');
		$this->load->view('client/auth/forgot_password', $data);
	}
		
	public static function AlphaNumeric($length)
      {
          $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
          $clen   = strlen( $chars )-1;
          $id  = '';

          for ($i = 0; $i < $length; $i++) {
                  $id .= $chars[mt_rand(0,$clen)];
          }
          return ($id);
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
	
			$this->email->set_mailtype("html");
			//get company info
			$cinfo = $this->Xin_model->read_company_setting_info(1);
			//get email template
			$template = $this->Xin_model->read_email_template(2);
			//get employee info
			$query = $this->Clients_model->read_client_info_byemail($this->input->post('iemail'));
			
			$user = $query->num_rows();
			if($user > 0) {
				
				$user_info = $query->result();
				$full_name = $user_info[0]->name;
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				//$cid = $this->email->attachment_cid($logo);
				$password = $this->AlphaNumeric(15);
				$options = array('cost' => 12);
				$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
				$last_data = array(
					'client_password' => $password_hash,
				); 
				
				$id = $user_info[0]->client_id; // user id
				  
				$this->Clients_model->update_record($last_data, $id);
				
				$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->name,$user_info[0]->email,$password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
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
?>