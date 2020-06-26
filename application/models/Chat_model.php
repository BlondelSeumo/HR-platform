<?php
class Chat_model extends CI_Model {
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }
	// get all messages
	public function get_messages() {
		$query = $this->db->query("SELECT * FROM xin_chat_messages where department_id ='0' and location_id = '0' ORDER BY message_id asc");
		return $query->result();
	}
	// get all department messages
	public function get_department_messages($department_id) {
		$query = $this->db->query("SELECT * FROM xin_chat_messages where department_id = '$department_id' and location_id = '0' ORDER BY message_id asc");
		return $query->result();
	}
	// get all location messages
	public function get_location_messages($location_id) {
		$query = $this->db->query("SELECT * FROM xin_chat_messages where location_id = '$location_id' and department_id ='0' ORDER BY message_id asc");
		return $query->result();
	}
	
	// get all messages
	public function get_unread_message($from_id,$to_id) {
		
		$sql = 'SELECT * FROM xin_chat_messages WHERE from_id = ? and to_id = ? and is_read = ?';
		$binds = array($from_id,$to_id,0);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	// get all messages
	public function last_user_message($from_id,$to_id) {
		
		$sql = "SELECT * FROM xin_chat_messages WHERE from_id = ? and to_id = ? and department_id ='0' and location_id = '0' ORDER BY message_id desc";
		$binds = array($from_id, $to_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	//	$query = $this->db->query("SELECT * FROM xin_chat_messages where from_id='".$from_id."' and to_id='".$to_id."' ORDER BY message_id desc");
		//return $query->result();
	}
	public function last_department_user_message($from_id) {
		
		$sql = "SELECT * FROM xin_chat_messages WHERE from_id = ? and department_id !='0' and location_id = '0' ORDER BY message_id desc";
		$binds = array($from_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function last_location_user_message($from_id) {
		
		$sql = "SELECT * FROM xin_chat_messages WHERE from_id = ? and location_id !='0' and department_id = '0' ORDER BY message_id desc";
		$binds = array($from_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function timeAgo($timestamp){
		//$time_now = mktime(date('h')+0,date('i')+30,date('s'));
		$datetime1=new DateTime("now");
		$datetime2=date_create($timestamp);
		$diff=date_diff($datetime1, $datetime2);
		$timemsg='';
		if($diff->y > 0){
			$timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');
	
		}
		else if($diff->m > 0){
			$timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
		}
		else if($diff->d > 0){
			$timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
		}
		else if($diff->h > 0){
			$timemsg = $diff->h .' hr'.($diff->h > 1 ? "'s":'');
		}
		else if($diff->i > 0){
			$timemsg = $diff->i .' min'. ($diff->i > 1?"'s":'');
		}
		else if($diff->s > 0){
			$timemsg = $diff->s .' sec'. ($diff->s > 1?"'s":'');
		}
	
		$timemsg = $timemsg.' ago';
		return $timemsg;
	}
	
	// Function to add record in table
	public function add_chat($data){
		$this->db->insert('xin_chat_messages', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_online_status($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_chat_status($data, $from_id, $to_id){
		$this->db->where('from_id', $from_id);
		$this->db->where('to_id', $to_id);
		if( $this->db->update('xin_chat_messages',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get chat list
	public function read_chat_from_info($from_id) {
	
		$sql = 'SELECT * FROM xin_chat_messages WHERE from_id = ?';
		$binds = array($from_id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	// get chat list
	public function read_chat_to_info($to_id) {
	
		$sql = 'SELECT * FROM xin_chat_messages WHERE to_id = ?';
		$binds = array($to_id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

}
?>