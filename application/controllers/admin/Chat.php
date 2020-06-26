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

class Chat extends MY_Controller
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
		  $this->load->model('Chat_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Location_model');
		  $this->load->model('Department_model');
     }
	 
	// Logout from admin page
	public function index() {
	
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_chat_box!='true'){
			redirect('admin/dashboard');
		}
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_chat_box').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_chat_box');
		$data['path_url'] = 'chatbox';
		//$data['all_active_employees'] = $this->Xin_model->all_active_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('118',$role_resources_ids)) {
		$data['subview'] = $this->load->view("admin/chatbox/chatbox", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		///} else {
		//	redirect('admin/dashboard');
		//}
	}
	
	public function chat_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/chatbox/single_chat', $data);
		} else {
			redirect('admin/');
		}
	}
	public function department_chat_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/chatbox/department_chat', $data);
		} else {
			redirect('admin/');
		}
	}
	public function location_chat_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/chatbox/location_chat', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function set_chatbox(){
		
		$fid = $this->input->get('from_id');
		$tid = $this->input->get('to_id');
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->get('from_id')) {
		echo '<div class="content-wrapper" id="">
		<div class="content-header row"> </div>
		<div class="content-body">
			<input name="to_id" id="rtid" value="'.$tid.'" type="hidden">
			<input name="from_id" id="rfid" value="'.$fid.'" type="hidden">
		  <section id="chat_app_window" class="chat-app-window scrollable-container">
			<div class="tag tag-default mb-1">Chat History </div>
			<div class="chats">
			  <div class="chats" id="chatbox">';
				foreach($this->Chat_model->get_messages() as $msgs){
					if(($tid==$msgs->to_id && $msgs->from_id==$fid) || ($fid==$msgs->to_id && $msgs->from_id==$tid)) {
						
					if($session['user_id']!=$msgs->from_id){
						$user_info = $this->Xin_model->read_user_info($msgs->from_id);
						//send
						if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
							$de_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
						} else {
							if($user_info[0]->gender=='Male') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else { 
								$de_file = base_url().'uploads/profile/default_female.jpg';
							} 
						}
						$data = array(
						'is_read' => 1,
						);
						$result = $this->Chat_model->update_chat_status($data,$msgs->from_id,$session['user_id'] );
							$tofname = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						echo '<div class="chat-message-left mb-4">
                      <div>
                        <img src="'.$de_file.'" class="ui-w-40 rounded-circle" alt="">
                      </div>
                      <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
                        <div class="font-weight-semibold mb-1">'.$tofname.'</div>
                        '.$msgs->message_content.'
                      </div>
                    </div>';
						} else {
							$fuser_info = $this->Xin_model->read_user_info($msgs->from_id);
							//from
							if($fuser_info[0]->profile_picture!='' && $fuser_info[0]->profile_picture!='no file') {
								$fde_file = base_url().'uploads/profile/'.$fuser_info[0]->profile_picture;
							} else {
								if($fuser_info[0]->gender=='Male') { 
									$fde_file = base_url().'uploads/profile/default_male.jpg';
								} else { 
									$fde_file = base_url().'uploads/profile/default_female.jpg';
								} 
							}
						
						echo '<div class="chat-message-right mb-4">
					  <div>
						<img src="'.$fde_file.'" class="ui-w-40 rounded-circle" alt="">
					  </div>
					  <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
						<div class="font-weight-semibold mb-1">You</div>
						'.$msgs->message_content.'
					  </div>
					</div>';
						}
					}
				}
			  echo '</div>
			</div>
			  </section>
			  <section class="chat-app-form">';
			  $attributes = array('name' => 'edit_transfer', 'id' => 'xin-form', 'autocomplete' => 'off', 'class'=>'chat-app-input');
			  $hidden = array('_method' => 'ADD_CHAT', '_token' => 0);
			 echo form_open('admin/chat/send_chat/', $attributes, $hidden);
			  
				//<form autocomplete="off" class="chat-app-input" id="xin-form" action="'.site_url('admin/chat/send_chat').'">
				 echo '<fieldset class="form-group position-relative has-icon-left col-xs-10 m-0">
				  <input name="to_id" id="tid" value="'.$tid.'" type="hidden">
				  <input name="from_id" id="fid" value="'.$fid.'" type="hidden">
				  <input name="message_frm" id="fid" value="'.$tid.'" type="hidden">
	
					<input type="text" name="message_content" class="form-control" id="message_content" placeholder="Type your message">
				  </fieldset>
				  <fieldset class="form-group position-relative has-icon-left col-xs-2 m-0">
					<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o hidden-lg-up"></i> <span class="hidden-md-down">Send</span></button>
				  </fieldset>
				';
			echo form_close();
			echo '	
			  </section>
			</div>
		  </div>
	  <script type="text/javascript">
	  $(document).ready(function(){
		  $("#xin-form").submit(function(e){
			var fd = new FormData(this);
			var text = $("#message_content").val();
			
			if(text.length == 0){
				return false;
			}			
			var obj = $(this), action = obj.attr("name");
			fd.append("is_ajax", 2);
	
			fd.append("form", action);
		
			e.preventDefault();
			$(".save").prop("disabled", true);
			$.ajax({
				url: e.target.action,
				type: "POST",
				data:  fd,
				contentType: false,
				cache: false,
				processData:false,
				success: function(JSON)
				{
					
					var siteUrl = "'.site_url('admin/chat/set_chatbox').'?from_id='.$fid.'&to_id='.$tid.'";
					$.get(siteUrl, function(data, status){
					jQuery("#chat_box").html(data);
					$("#message_content").val("");
					$("input[name="csrf_hrsale"]").val(data.csrf_hash);
					$("#message_content").focus();
					$("#chatAudioSent")[0].play();
					jQuery(".chat-app-window").animate({ scrollTop: $(".chat-app-window").prop("scrollHeight")}, 0);
					});
					
				},
				error: function() 
				{
					$("input[name="csrf_hrsale"]").val(data.csrf_hash);
					$(".save").prop("disabled", false);
				} 	        
		   });
		});
	});	
	</script>
	  ';
	  }
	}
	
	public function refresh_chatbox(){
		
		$fid = $this->input->get('from_id');
		$tid = $this->input->get('to_id');
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->get('from_id')) {
		
				foreach($this->Chat_model->get_messages() as $msgs){
					
					if(($tid==$msgs->to_id && $msgs->from_id==$fid) || ($fid==$msgs->to_id && $msgs->from_id==$tid)) {
						
					if($session['user_id']!=$msgs->from_id){
						$user_info = $this->Xin_model->read_user_info($msgs->from_id);
						//send
						if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
							$de_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
						} else {
							if($user_info[0]->gender=='Male') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else { 
								$de_file = base_url().'uploads/profile/default_female.jpg';
							} 
						}
						$data = array(
						'is_read' => 1,
						);
						$result = $this->Chat_model->update_chat_status($data,$msgs->from_id,$session['user_id'] );						
						$tofname = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						$last_chat = $this->Chat_model->last_user_message($msgs->from_id,$session['user_id']);
						$last_chat_date = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-left mb-4">
                      <div>
                        <img src="'.$de_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$last_chat_date.'</div>
                      </div>
                      <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
                        <div class="font-weight-semibold mb-1">'.$tofname.'</div>
                        '.$msgs->message_content.'
                      </div>
                    </div>';
						} else {
							$fuser_info = $this->Xin_model->read_user_info($msgs->from_id);
							//from
							if($fuser_info[0]->profile_picture!='' && $fuser_info[0]->profile_picture!='no file') {
								$fde_file = base_url().'uploads/profile/'.$fuser_info[0]->profile_picture;
							} else {
								if($fuser_info[0]->gender=='Male') { 
									$fde_file = base_url().'uploads/profile/default_male.jpg';
								} else { 
									$fde_file = base_url().'uploads/profile/default_female.jpg';
								} 
							}
							$last_chat = $this->Chat_model->last_user_message($session['user_id'],$tid);
							$last_chat_date = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-right mb-4">
					  <div>
						<img src="'.$fde_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$last_chat_date.'</div>
					  </div>
					  <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
						<div class="font-weight-semibold mb-1">You</div>
						'.$msgs->message_content.'
					  </div>
					</div>';
						}
					}
				}
		}
	}
	
	public function refresh_department_chatbox(){
		
		$fid = $this->input->get('from_id');
		$department_id = $this->input->get('department_id');
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->get('from_id')) {
		
				foreach($this->Chat_model->get_department_messages($department_id) as $msgs){
					
					//if(($tid==$msgs->to_id && $msgs->from_id==$fid) || ($fid==$msgs->to_id && $msgs->from_id==$tid)) {
						
					if($session['user_id']!=$msgs->from_id){
						$user_info = $this->Xin_model->read_user_info($msgs->from_id);
						//send
						if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
							$de_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
						} else {
							if($user_info[0]->gender=='Male') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else { 
								$de_file = base_url().'uploads/profile/default_female.jpg';
							} 
						}
						$data = array(
						'is_read' => 1,
						);
						$result = $this->Chat_model->update_chat_status($data,$msgs->from_id,$session['user_id'] );						
						$tofname = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						$last_chat = $this->Chat_model->last_department_user_message($msgs->from_id);
						$last_chat_date = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-left mb-4">
                      <div>
                        <img src="'.$de_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$last_chat_date.'</div>
                      </div>
                      <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
                        <div class="font-weight-semibold mb-1">'.$tofname.'</div>
                        '.$msgs->message_content.'
                      </div>
                    </div>';
						} else {
							$fuser_info = $this->Xin_model->read_user_info($msgs->from_id);
							//from
							if($fuser_info[0]->profile_picture!='' && $fuser_info[0]->profile_picture!='no file') {
								$fde_file = base_url().'uploads/profile/'.$fuser_info[0]->profile_picture;
							} else {
								if($fuser_info[0]->gender=='Male') { 
									$fde_file = base_url().'uploads/profile/default_male.jpg';
								} else { 
									$fde_file = base_url().'uploads/profile/default_female.jpg';
								} 
							}
							$last_chat = $this->Chat_model->last_department_user_message($msgs->from_id);
							$last_chat_date = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-right mb-4">
					  <div>
						<img src="'.$fde_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$last_chat_date.'</div>
					  </div>
					  <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
						<div class="font-weight-semibold mb-1">You</div>
						'.$msgs->message_content.'
					  </div>
					</div>';
						}
					}
				//}
		}
	}
	public function refresh_location_chatbox(){
		
		$fid = $this->input->get('from_id');
		$location_id = $this->input->get('location_id');
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->get('from_id')) {
		
				foreach($this->Chat_model->get_location_messages($location_id) as $msgs){
					
					//if(($tid==$msgs->to_id && $msgs->from_id==$fid) || ($fid==$msgs->to_id && $msgs->from_id==$tid)) {
						
					if($session['user_id']!=$msgs->from_id){
						$user_info = $this->Xin_model->read_user_info($msgs->from_id);
						//send
						if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
							$de_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
						} else {
							if($user_info[0]->gender=='Male') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else { 
								$de_file = base_url().'uploads/profile/default_female.jpg';
							} 
						}
						$data = array(
						'is_read' => 1,
						);
						$result = $this->Chat_model->update_chat_status($data,$msgs->from_id,$session['user_id'] );						
						$tofname = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						$last_chat = $this->Chat_model->last_location_user_message($msgs->from_id);
						$last_chat_date = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-left mb-4">
                      <div>
                        <img src="'.$de_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$last_chat_date.'</div>
                      </div>
                      <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
                        <div class="font-weight-semibold mb-1">'.$tofname.'</div>
                        '.$msgs->message_content.'
                      </div>
                    </div>';
						} else {
							$fuser_info = $this->Xin_model->read_user_info($msgs->from_id);
							//from
							if($fuser_info[0]->profile_picture!='' && $fuser_info[0]->profile_picture!='no file') {
								$fde_file = base_url().'uploads/profile/'.$fuser_info[0]->profile_picture;
							} else {
								if($fuser_info[0]->gender=='Male') { 
									$fde_file = base_url().'uploads/profile/default_male.jpg';
								} else { 
									$fde_file = base_url().'uploads/profile/default_female.jpg';
								} 
							}
							$last_chat = $this->Chat_model->last_location_user_message($msgs->from_id);
							$last_chat_date = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-right mb-4">
					  <div>
						<img src="'.$fde_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$last_chat_date.'</div>
					  </div>
					  <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
						<div class="font-weight-semibold mb-1">You</div>
						'.$msgs->message_content.'
					  </div>
					</div>';
						}
					}
				//}
		}
	}
	
	public function refresh_chat_users_msg() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$unread_msgs = $this->Xin_model->get_single_unread_message($session['user_id']);
		if($unread_msgs > 0) {
			echo $unread_msgs;
		} else {
			echo '';
		}
	}
	
	public function refresh_chat_users() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$fuser_info = $this->Xin_model->read_user_info($session['user_id']);
		/*if($fuser_info[0]->user_role_id==1){
			$all_active_employees = $this->Xin_model->all_active_employees();
		} else {
			$all_active_employees = $this->Xin_model->all_active_departments_employees();
		}*/
		$all_active_employees = $this->Xin_model->all_active_employees();
		foreach($all_active_employees as $active_employees):
		if ($active_employees->is_logged_in == 0):
			$bgm = 'offline';
			$bgmTxt = 'Offline';
        else:
			if($active_employees->online_status==1):
         		$bgm = 'online';
				$bgmTxt = 'Online';
			elseif($active_employees->online_status==3):
				$bgm = 'offline';
				$bgmTxt = 'Offline';
			else:
				$bgm = 'offline';
				$bgmTxt = 'Offline';
			endif;	
		
         endif;
        if($active_employees->user_id!=$session['user_id']):
        
       echo '<button class="all-users list-group-item list-group-item-action media no-border '.$bgm.'" id="set_box_'.$active_employees->user_id.'" data-from-id="'.$session['user_id'].'" data-to-id="'.$active_employees->user_id.'" data-toggle="modal" data-target="#chatbox-single">';
		
          	if($active_employees->profile_picture!='' && $active_employees->profile_picture!='no file') {
            echo '<img class="ui-w-40 rounded-circle" src="'.base_url()."uploads/profile/".$active_employees->profile_picture.'" alt=""> <i></i>';
             } else {
              if($active_employees->gender=='Male') { 
             	$de_file = base_url().'uploads/profile/default_male.jpg';
             } else {
             	$de_file = base_url().'uploads/profile/default_female.jpg';
             } 
            echo '<img class="ui-w-40 rounded-circle" src="'.$de_file.'" alt=""> <i></i>';
              } 
            $fname = $active_employees->first_name.' '.$active_employees->last_name; 
			$unread_msgs = $this->Chat_model->get_unread_message($active_employees->user_id,$session['user_id']);
			$last_chat = $this->Chat_model->last_user_message($active_employees->user_id,$session['user_id']);
			if(!is_null($last_chat)){
				$last_chat_date = $this->Chat_model->timeAgo($last_chat[0]->message_date);
				$message_content = $last_chat[0]->message_content;
			} else {
				$last_chat_date = '--';
				$message_content = 'No Message.';
			}
			echo '</div><div class="media-body ml-3">'.$fname.'<div class="chat-status small">
				  <span class="badge badge-dot"></span>&nbsp; '.$bgmTxt.'</div>
			  </div>';
				if($unread_msgs > 0) {
					echo '<div class="badge badge-outline-success">'.$unread_msgs.'</div>';
				} else {
				} echo '';
         echo '
          
          </button>';
		  endif;
          endforeach;
	}
		
	// send chat
	public function send_chat() {
	
		if($this->input->post('from_id') && $this->input->post('to_id')) {		
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$this->form_validation->set_rules('message_content', 'Message', 'trim|required|xss_clean');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$message = $this->input->post('message_content');
			$qt_message = htmlspecialchars(addslashes($message), ENT_QUOTES);
			//if ($this->form_validation->run() == FALSE) {

			//}
			if($this->input->post('message_content')==='') {
				return false;
			}
		
			$data = array(
			'message_content' => $qt_message,
			'from_id' => $this->input->post('from_id'),
			'to_id' => $this->input->post('to_id'),
			'location_id' => 0,
			'department_id' => 0,
			'message_frm' => $this->input->post('message_frm'),
			'message_date' => date('Y-m-d H:i:s'),
			);
			$result = $this->Chat_model->add_chat($data);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$this->output($Return);
			exit;
		}
	}
	// send chat
	public function send_department_chat() {
	
		if($this->input->post('from_id') && $this->input->post('chat_group_department_id')) {		
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$this->form_validation->set_rules('message_content', 'Message', 'trim|required|xss_clean');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$message = $this->input->post('message_content');
			$qt_message = htmlspecialchars(addslashes($message), ENT_QUOTES);
			//if ($this->form_validation->run() == FALSE) {

			//}
			if($this->input->post('message_content')==='') {
				return false;
			}
		
			$data = array(
			'message_content' => $qt_message,
			'from_id' => $this->input->post('from_id'),
			'to_id' => '0',
			'location_id' => '0',
			'department_id' => $this->input->post('chat_group_department_id'),
			'message_frm' => $this->input->post('message_frm'),
			'message_date' => date('Y-m-d H:i:s'),
			);
			$result = $this->Chat_model->add_chat($data);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$this->output($Return);
			exit;
		}
	}
	
	// send chat
	public function send_location_chat() {
	
		if($this->input->post('from_id') && $this->input->post('chat_group_location_id')) {		
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$this->form_validation->set_rules('message_content', 'Message', 'trim|required|xss_clean');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$message = $this->input->post('message_content');
			$qt_message = htmlspecialchars(addslashes($message), ENT_QUOTES);
			//if ($this->form_validation->run() == FALSE) {

			//}
			if($this->input->post('message_content')==='') {
				return false;
			}
		
			$data = array(
			'message_content' => $qt_message,
			'from_id' => $this->input->post('from_id'),
			'to_id' => '0',
			'department_id' => '0',
			'location_id' => $this->input->post('chat_group_location_id'),
			'message_frm' => $this->input->post('message_frm'),
			'message_date' => date('Y-m-d H:i:s'),
			);
			$result = $this->Chat_model->add_chat($data);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$this->output($Return);
			exit;
		}
	}
	
	// change online status
	public function change_status() {
	
		if($this->input->get('status_id')) {		
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = $this->session->userdata('username');					
			$status_id = $this->input->get('status_id');
			$id = $session['user_id'];
			$data = array(
			'online_status' => $status_id,
			);
			$result = $this->Chat_model->update_online_status($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}
?>