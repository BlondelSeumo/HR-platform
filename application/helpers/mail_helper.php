<?php

//Process String
if( !function_exists('hrsale_mail') ){

	function hrsale_mail($from,$from_name,$to,$subject,$body){
	  
	  $CI=& get_instance();
	  if(email_type()=="codeigniter"){
		$CI->load->library('email');
		$CI->email->set_mailtype("html");
		$CI->email->from($from,$from_name);
		$CI->email->to($to);
	
		$CI->email->subject($subject);
		$CI->email->message($body);
	
		$CI->email->send();
	 
	 
	  } else if(email_type()=="smtp"){
		$CI->load->library('email');
		$CI->email->set_mailtype("html");
		$config['protocol']    = 'smtp';
		$config['smtp_crypto'] = get_smtp_secure();
		$config['smtp_host']    = get_smtp("smtp_host");
		$config['smtp_port']    = get_smtp("smtp_port");
		$config['smtp_timeout'] = '60';
		$config['smtp_user']    = get_smtp("smtp_username");
		$config['smtp_pass']    = get_smtp("smtp_password");
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = "html"; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not      
	
		$CI->email->initialize($config);
	
		$CI->email->from($from,$from_name);
		$CI->email->to($to); 
	
		$CI->email->subject($subject);
		$CI->email->message($body);  
	   
		$CI->email->send();
	  } else if(email_type()=="phpmail"){
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: ' .$from. "\r\n";
		
		mail($to,$subject,$body,$headers); 
	 
	  }
	  
	}
}

// company info
if( !function_exists('hrsale_company_name') ){

 function hrsale_company_name(){
  $CI=& get_instance();
  $query =  $CI->db->query("SELECT company_name FROM xin_company_info")->row()->company_name;
  return $query;
 }
}
if( !function_exists('hrsale_company_email') ){

 function hrsale_company_email(){
  $CI=& get_instance();
  $query =  $CI->db->query("SELECT email FROM xin_company_info")->row()->email;
  return $query;
 }
}
//Process String
if( !function_exists('email_type') ){

 function email_type(){
  $CI=& get_instance();
  $query =  $CI->db->query("SELECT email_type FROM xin_email_configuration")->row()->email_type;
  return $query;
 }

}

//Process String
if( !function_exists('get_smtp_secure') ){

 function get_smtp_secure(){
  $CI=& get_instance();
  $query = $CI->db->query("SELECT smtp_secure FROM xin_email_configuration")->row()->smtp_secure;
  return $query;
 }

}

//Process String
if( !function_exists('get_smtp') ){

 function get_smtp($name){
  $CI=& get_instance();
  $query = $CI->db->query("SELECT $name FROM xin_email_configuration")->row()->$name;
  return $query;
 }
}