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

class Promotion extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Promotion_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Employees_model");
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
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_promotions').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_promotions');
		$data['path_url'] = 'promotion';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('18',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/promotion/promotion_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function promotion_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/promotion/promotion_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$promotion = $this->Promotion_model->get_promotions();
		} else {
			if(in_array('236',$role_resources_ids)) {
				$promotion = $this->Promotion_model->get_company_promotions($user_info[0]->company_id);
			} else {
				$promotion = $this->Promotion_model->get_employee_promotions($session['user_id']);
			}
		}
		$data = array();

        foreach($promotion->result() as $r) {
			 			  		
			// get user > employee_
			$employee = $this->Xin_model->read_user_info($r->employee_id);
			// employee full name
			if(!is_null($employee)){
				$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			} else {
				$employee_name = '--';	
			}
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			// get promotion date
			$promotion_date = $this->Xin_model->set_date_format($r->promotion_date);
			if(in_array('220',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-promotion_id="'. $r->promotion_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('221',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->promotion_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('236',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-promotion_id="'. $r->promotion_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$pro_desc = $employee_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_description').': '.$r->description.'<i></i></i></small>';
			$promoted_to = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('xin_promoted_to_title').': '.$designation_name.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$pro_desc,
				$comp_name,
				$promoted_to,
				$promotion_date
			);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $promotion->num_rows(),
			 "recordsFiltered" => $promotion->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
    }
	 // get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/promotion/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > employee > designations
	 public function get_employee_designations() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		// get user > employee_
		
		$data = array(
			'employee_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/promotion/get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 public function read() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('promotion_id');
		$result = $this->Promotion_model->read_promotion_information($id);
		// get designation
		$designation = $this->Designation_model->read_designation_information($result[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		$data = array(
				'promotion_id' => $result[0]->promotion_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'designation_name' => $designation_name,
				'title' => $result[0]->title,
				'promotion_date' => $result[0]->promotion_date,
				'description' => $result[0]->description,
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_employees' => $this->Xin_model->all_employees()
				);
			$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/promotion/dialog_promotion', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_promotion() {
	
		if($this->input->post('add_type')=='promotion') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('designation_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_designation_field');
		} else if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('promotion_date')==='') {
			 $Return['error'] = $this->lang->line('xin_error_promotion_date');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'designation_id' => $this->input->post('designation_id'),
		'title' => $this->input->post('title'),
		'promotion_date' => $this->input->post('promotion_date'),
		'description' => $qt_description,
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Promotion_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_promotion_added');
			$user_data = array(
				'designation_id' => $this->input->post('designation_id'),
			);
			$user_info = $this->Employees_model->basic_info($user_data,$this->input->post('employee_id'));
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='promotion') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('promotion_date')==='') {
			 $Return['error'] = $this->lang->line('xin_error_promotion_date');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'title' => $this->input->post('title'),
		'promotion_date' => $this->input->post('promotion_date'),
		'description' => $qt_description,		
		);
		
		$result = $this->Promotion_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_promotion_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Promotion_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_promotion_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
