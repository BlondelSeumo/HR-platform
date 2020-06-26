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

class Expense extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the login model
		$this->load->model("Expense_model");
		$this->load->model("Department_model");
		$this->load->model("Xin_model");
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
		$data['title'] = $this->lang->line('xin_expenses').' | '.$this->Xin_model->site_title();
		$data['all_expense_types'] = $this->Expense_model->all_expense_types();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_expenses');
		$data['path_url'] = 'expense';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('10',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/expense/expense_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function expense_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/expense/expense_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('389',$role_resources_ids)) {
			$expense = $this->Expense_model->get_employee_expenses();
		} else {
			$expense = $this->Expense_model->get_expenses();
		}
		$data = array();

          foreach($expense->result() as $r) {
			  
			// get country
			$expense_type = $this->Expense_model->read_expense_type_information($r->expense_type_id);
			if(!is_null($expense_type)){
				$expensen = $expense_type[0]->name;
			} else {
				$expensen = '--';	
			}
			// get user
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			// get date
			$edate = $this->Xin_model->set_date_format($r->purchase_date);
			// get currency
			$currency = $this->Xin_model->currency_sign($r->amount);
			// download
			$download = '';
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			  
			if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
			elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_approved').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_cancel').'</span>'; endif;
			
			
			
				if(in_array('311',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-expense_id="'. $r->expense_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('312',$role_resources_ids)) { // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->expense_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$delete = '';
				}
				if(in_array('313',$role_resources_ids)) { //view
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-expense_id="'. $r->expense_id . '"><span class="fa fa-eye"></span></button></span>';
				} else {
					$view = '';
				}
				if(in_array('314',$role_resources_ids)) { //download
					if($r->billcopy_file!='' && $r->billcopy_file!='no file') {
						$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="download?type=expense&filename='.$r->billcopy_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('xin_download').'"><span class="oi oi-cloud-download"></span></button></a></span>';
					} else {
						$download = '';
					}
				} else {
					$download = '';
				}
				$combhr = $edit.$download.$view.$delete;
				$iexpensen = $expensen.'<br><small class="text-muted"><i>'.$this->lang->line('xin_purchased_by').': '.$full_name.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
               $data[] = array(
			   		$combhr,
					$iexpensen,
					$comp_name,                    
                    $currency,
                    $edate,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $expense->num_rows(),
                 "recordsFiltered" => $expense->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('expense_id');
		$result = $this->Expense_model->read_expense_information($id);
		$data = array(
				'expense_id' => $result[0]->expense_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'expense_type_id' => $result[0]->expense_type_id,
				'billcopy_file' => $result[0]->billcopy_file,
				'amount' => $result[0]->amount,
				'purchase_date' => $result[0]->purchase_date,
				'remarks' => $result[0]->remarks,
				'status' => $result[0]->status,
				'all_expense_types' => $this->Expense_model->all_expense_types(),
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/expense/dialog_expense', $data);
		} else {
			redirect('admin/');
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
			$this->load->view("admin/expense/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	// Validate and add info in database
	public function add_expense() {
	
		if($this->input->post('add_type')=='expense') {
		// Check validation for user input
		$file = $_FILES['bill_copy']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		$remarks = $this->input->post('remarks');
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);	
		/* Server side PHP input validation */
		if($this->input->post('expense_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_expense_type');
		} else if($this->input->post('purchase_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_purchase_date');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_expense_amount');
		} else if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} 
		
		/* Check if file uploaded..*/
		else if($_FILES['bill_copy']['size'] == 0) {
			$fname = 'no file';
		} else {
			if(is_uploaded_file($_FILES['bill_copy']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['bill_copy']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["bill_copy"]["tmp_name"];
					$bill_copy = "uploads/expense/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["bill_copy"]["name"]);
					$newfilename = 'bill_copy_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_expense_file_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'expense_type_id' => $this->input->post('expense_type'),
		'company_id' => $this->input->post('company_id'),
		'purchase_date' => $this->input->post('purchase_date'),
		'amount' => $this->input->post('amount'),
		'employee_id' => $this->input->post('employee_id'),
		'billcopy_file' => $fname,
		'remarks' => $qt_remarks,
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Expense_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_expense');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='expense') {
		$id = $this->uri->segment(4);
		// Check validation for user input
		$file = $_FILES['bill_copy']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		$remarks = $this->input->post('remarks');
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);		
		
		$no_logo_data = array(
		'expense_type_id' => $this->input->post('expense_type'),
		'purchase_date' => $this->input->post('purchase_date'),
		'company_id' => $this->input->post('company_id'),
		'amount' => $this->input->post('amount'),
		'employee_id' => $this->input->post('employee_id'),
		'status' => $this->input->post('status'),
		'remarks' => $qt_remarks,
		);
			
		/* Server side PHP input validation */
		if($this->input->post('expense_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_expense_type');
		} else if($this->input->post('purchase_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_purchase_date');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_expense_amount');
		} else if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		}  
		
		/* Check if file uploaded..*/
		else if($_FILES['bill_copy']['size'] == 0) {
			$fname = 'no file';
			 $result = $this->Expense_model->update_record_no_logo($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['bill_copy']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['bill_copy']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["bill_copy"]["tmp_name"];
					$bill_copy = "uploads/expense/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["bill_copy"]["name"]);
					$newfilename = 'bill_copy_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'expense_type_id' => $this->input->post('expense_type'),
					'purchase_date' => $this->input->post('purchase_date'),
					'amount' => $this->input->post('amount'),
					'company_id' => $this->input->post('company_id'),
					'employee_id' => $this->input->post('employee_id'),
					'status' => $this->input->post('status'),
					'billcopy_file' => $fname,
					'remarks' => $qt_remarks,		
					);
					// update record > model
					$result = $this->Expense_model->update_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_expense_file_type');
				}
			}
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_expense');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Expense_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_expense');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
