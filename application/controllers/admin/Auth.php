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
			/*	$this->load->library('session');
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->database();
			$this->load->library('form_validation');*/
		
			$this->load->model('Login_model');
			$this->load->model('Employees_model');
			$this->load->model('Users_model');
			$this->load->library('email');
			$this->load->model("Xin_model");
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
			$Return['error'] = $this->lang->line('xin_employee_error_username');
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
		$result = $this->Login_model->login($data);	
		
		if ($result == TRUE) {
			
				$result = $this->Login_model->read_user_information($username);
				$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'email' => $result[0]->email,
				);
				// Add user data in session
				$this->session->set_userdata('username', $session_data);
				$this->session->set_userdata('user_id', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				 $last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result[0]->user_id; // user id
				  
				$this->Xin_model->login_update_record($last_data, $id);
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->session->set_flashdata('expire_official_document', 'expire_official_document');
				$this->output($Return);
				
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
				/*Return*/
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
			}
	}
	public function login_pincode() {
	
		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		//$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$pincode = $this->input->post('ipincode');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($pincode==='') {
			$Return['error'] = $this->lang->line('xin_enter_pincode');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$data = array(
			'pincode' => $pincode,
			);
		$result = $this->Login_model->pincode_login($data);	
		
		if ($result == TRUE) {
			
				$result = $this->Login_model->read_user_info_pin($pincode);
				$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'email' => $result[0]->email,
				);
				// Add user data in session
				$this->session->set_userdata('username', $session_data);
				$this->session->set_userdata('user_id', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				 $last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result[0]->user_id; // user id
				  
				$this->Xin_model->login_update_record($last_data, $id);
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->session->set_flashdata('expire_official_document', 'expire_official_document');
				$this->output($Return);
				
			} else {
				$Return['error'] = $this->lang->line('xin_invalid_pincode');
				/*Return*/
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
			}
	}
	
	// forgot password.	
	public function forgot_password() {
		$data['title'] = $this->lang->line('xin_forgot_password_link');
		$this->load->view('admin/auth/forgot_password', $data);
	}
	
	// unlock user.	
	public function lock() {
		
		//$session_id = $this->session->userdata('user_id');
		$data['title'] = $this->lang->line('xin_lock_user');

		$session = $this->session->userdata('username');
		$this->session->unset_userdata('username');
		$Return['result'] = 'Locked User.';
		$this->load->view('admin/auth/user_lock', $data);
	}
	
	//unlock user.
	public function unlock() {
	
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$password = $this->input->post('ipassword');
		$session_id = $this->session->userdata('user_id');
		$iresult = $this->Login_model->read_user_info_session_id($session_id['user_id']);
		
		/* Server side PHP input validation */
		if($password===''){
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$username = $iresult[0]->username;
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$result = $this->Login_model->login($data);	
		
		if ($result == TRUE) {
			
				$result = $this->Login_model->read_user_information($username);
				$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'email' => $result[0]->email,
				);
				// Add user data in session
				$this->session->set_userdata('username', $session_data);
				$this->session->set_userdata('user_id', $session_data);
				$Return['result'] = $this->lang->line('xin_success_logged_in');
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				$last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result[0]->user_id; // user id
				  
				$this->Xin_model->login_update_record($last_data, $id);
				$this->output($Return);
				
			} else {
				$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
				/*Return*/
				$this->output($Return);
			}
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
			$query = $this->Xin_model->read_user_info_byemail($this->input->post('iemail'));
			
			$user = $query->num_rows();
			if($user > 0) {
				
				$user_info = $query->result();
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;				
				$body = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var email}"),array($cinfo[0]->company_name,site_url(),$user_info[0]->email),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				hrsale_mail($cinfo[0]->email,$cinfo[0]->company_name,$this->input->post('iemail'),$subject,$body);			
				$Return['result'] = $this->lang->line('xin_reset_password_link_success_sent_email');
			} else {
				/* Unsuccessful attempt: Set error message */
				$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function reset_password() {
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($this->input->get('change') == 'true'){
				
			if($this->input->get('email')) {
		
				$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(17);
				//get employee info
				$query = $this->Xin_model->read_user_info_byemail($this->input->get('email'));
				
				$user = $query->num_rows();
				if($user > 0) {
					
					$user_info = $query->result();
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					
					$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					//$cid = $this->email->attachment_cid($logo);
					$password = $this->AlphaNumeric(15);
					$options = array('cost' => 12);
					$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
					$last_data = array(
						'password' => $password_hash,
					); 
					
					$id = $user_info[0]->user_id; // user id
					  
					$this->Xin_model->login_update_record($last_data, $id);
					
				$body = '<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;"><img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->username,$user_info[0]->pincode,$user_info[0]->email,$password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					
					hrsale_mail($cinfo[0]->email,$cinfo[0]->company_name,$this->input->get('email'),$subject,$body);				
					$this->session->set_flashdata('reset_password_success', 'reset_password_success');
					redirect(site_url('admin/'));
				} else {
					/* Unsuccessful attempt: Set error message */
					//$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
				}
				//$this->output($Return);
				//exit;
			}
		}
	}
} 
?>