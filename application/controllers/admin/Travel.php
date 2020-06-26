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

class Travel extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Travel_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Finance_model");
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
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_travel!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_travels').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['travel_arrangement_types'] = $this->Travel_model->travel_arrangement_types();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_travels');
		$data['path_url'] = 'travel';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('17',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/travel/travel_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
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
			$this->load->view("admin/travel/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 
 
    public function travel_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/travel/travel_list", $data);
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
			$travel = $this->Travel_model->get_travel();
		} else {
			if(in_array('235',$role_resources_ids)) {
				$travel = $this->Travel_model->get_company_travel($user_info[0]->company_id);
			} else {
				$travel = $this->Travel_model->get_employee_travel($session['user_id']);
			}
		}
		$data = array();

        foreach($travel->result() as $r) {
			 			  	
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->employee_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
		} else {
			$employee_name = '--';	
		}
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$end_date = $this->Xin_model->set_date_format($r->end_date);
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		// status
		//if($r->status==0): $status = $this->lang->line('xin_pending');
		//elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
		if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
			elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected'); endif;
		
		if(in_array('217',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-travel_id="'. $r->travel_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('218',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->travel_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		if(in_array('235',$role_resources_ids)) { //view
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-travel_id="'. $r->travel_id . '"><span class="fa fa-eye"></span></button></span>';
		} else {
			$view = '';
		}
		if($r->status==1) {
			$combhr = $view;
		} else {
			$combhr = $edit.$view.$delete;
		}
		
		$expected_budget = $this->Xin_model->currency_sign($r->expected_budget);
		$actual_budget = $this->Xin_model->currency_sign($r->actual_budget);
		$iemployee_name = $employee_name.'<br><small class="text-muted"><i>'.$r->visit_purpose.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_expected_travel_budget').': '.$expected_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_actual_travel_budget').': '.$actual_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
		
		$data[] = array(
			$combhr,
			$iemployee_name,
			$comp_name,
			$r->visit_place,
			$start_date,
			$end_date
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $travel->num_rows(),
			 "recordsFiltered" => $travel->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('travel_id');
		$result = $this->Travel_model->read_travel_information($id);
		$data = array(
				'travel_id' => $result[0]->travel_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'visit_purpose' => $result[0]->visit_purpose,
				'visit_place' => $result[0]->visit_place,
				'travel_mode' => $result[0]->travel_mode,
				'arrangement_type' => $result[0]->arrangement_type,
				'expected_budget' => $result[0]->expected_budget,
				'actual_budget' => $result[0]->actual_budget,
				'description' => $result[0]->description,
				'status' => $result[0]->status,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'travel_arrangement_types' => $this->Travel_model->travel_arrangement_types(),
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/travel/dialog_travel', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_travel() {
	
		if($this->input->post('add_type')=='travel') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('visit_purpose')==='') {
			$Return['error'] = $this->lang->line('xin_error_travel_purpose');
		} else if($this->input->post('visit_place')==='') {
			$Return['error'] = $this->lang->line('xin_error_travel_visit_place');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'visit_purpose' => $this->input->post('visit_purpose'),
		'visit_place' => $this->input->post('visit_place'),
		'travel_mode' => $this->input->post('travel_mode'),
		'arrangement_type' => $this->input->post('arrangement_type'),
		'expected_budget' => $this->input->post('expected_budget'),
		'actual_budget' => $this->input->post('actual_budget'),
		'description' => $qt_description,
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Travel_model->add($data);
		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('travel_id',"DESC")->get("xin_employee_travels")->row();
			$Return['result'] = $this->lang->line('xin_success_travel_added');	
			$Return['re_last_id'] = $row->travel_id;
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='travel') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('visit_purpose')==='') {
			$Return['error'] = $this->lang->line('xin_error_travel_purpose');
		} else if($this->input->post('visit_place')==='') {
			$Return['error'] = $this->lang->line('xin_error_travel_visit_place');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'visit_purpose' => $this->input->post('visit_purpose'),
		'visit_place' => $this->input->post('visit_place'),
		'travel_mode' => $this->input->post('travel_mode'),
		'arrangement_type' => $this->input->post('arrangement_type'),
		'expected_budget' => $this->input->post('expected_budget'),
		'actual_budget' => $this->input->post('actual_budget'),
		'description' => $qt_description,
		'status' => $this->input->post('status'),		
		);
		
		$result = $this->Travel_model->update_record($data,$id);	
		if($this->input->post('status') == 1){
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
			$trv_info = $this->Travel_model->read_travel_information($id);
			$ivdata = array(
			'amount' => $this->input->post('actual_budget'),
			'account_id' => $online_payment_account,
			'transaction_type' => 'expense',
			'dr_cr' => 'cr',
			'transaction_date' => date('Y-m-d'),
			'payer_payee_id' => $trv_info[0]->employee_id,
			'payment_method_id' => 3,
			'description' => 'Travel Expense',
			'reference' => 'Travel Expense',
			'invoice_id' => $id,
			'client_id' => $trv_info[0]->employee_id,
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($ivdata);
			// update data in bank account
			$account_id = $this->Finance_model->read_bankcash_information($online_payment_account);
			$acc_balance = $account_id[0]->account_balance - $this->input->post('actual_budget');
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$online_payment_account);	
		}
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_travel_updated');
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
		$result = $this->Travel_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_travel_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
