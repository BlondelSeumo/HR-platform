<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Login_model extends CI_Model
	{
     public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	// get setting info
	public function read_setting_info($id) {
	
		$sql = 'SELECT * FROM xin_system_setting WHERE setting_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Read data using username and password
	public function login($data) {
	
		$system = $this->read_setting_info(1);
		if($system[0]->employee_login_id=='username'):		
			$sql = 'SELECT * FROM xin_employees WHERE username = ? AND is_active = ?';
			$binds = array($data['username'],1);
			$query = $this->db->query($sql, $binds);
			
		else:
			$sql = 'SELECT * FROM xin_employees WHERE email = ? AND is_active = ?';
			$binds = array($data['username'],1);
			$query = $this->db->query($sql, $binds);
			
		endif;		
		
	    $options = array('cost' => 12);
		$password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if(password_verify($data['password'],$rw_password[0]->password)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	// Read data using username and password
	public function pincode_login($data) {
	
		$system = $this->read_setting_info(1);	
		$sql = 'SELECT * FROM xin_employees WHERE pincode = ? AND is_active = ?';
		$binds = array($data['pincode'],1);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			$res_pic = $query->result();
			return true;
		} else {
			return false;
		}
	}
	
	// Read data using email and password > frontend user
	public function frontend_user_login($data) {
	
		$sql = 'SELECT * FROM xin_users WHERE email = ? and is_active = ?';
		$binds = array($data['email'],1);
		$query = $this->db->query($sql, $binds);
	
		$options = array('cost' => 12);
		$password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if(password_verify($data['password'],$rw_password[0]->password)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	// Read data from database to show data in admin page
	public function read_user_information($username) {
	
		$system = $this->read_setting_info(1);
		if($system[0]->employee_login_id=='username'):
			$sql = 'SELECT * FROM xin_employees WHERE username = ?';
			$binds = array($username);
			$query = $this->db->query($sql, $binds);
		else:
			$sql = 'SELECT * FROM xin_employees WHERE email = ?';
			$binds = array($username);
			$query = $this->db->query($sql, $binds);
		endif;
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	// Read data from database to show data in admin page
	public function read_user_info_pin($pincode) {
	
		$system = $this->read_setting_info(1);
		$sql = 'SELECT * FROM xin_employees WHERE pincode = ?';
		$binds = array($pincode);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Read data from database to show data in admin page
	public function read_user_info_session_id($user_id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($user_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Read data from database to show data in admin page
	public function read_frontend_user_info_session($email) {
	
		$sql = 'SELECT * FROM xin_users WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	

}
?>