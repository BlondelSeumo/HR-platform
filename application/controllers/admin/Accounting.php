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

class Accounting extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct() {
          parent::__construct();
          //load the models
          $this->load->model('Xin_model');
		  $this->load->model('Finance_model');
		  $this->load->model('Expense_model');
		  $this->load->model('Invoices_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Department_model');
		  $this->load->model('Project_model');
		  $this->load->model('Awards_model');
		  $this->load->model('Training_model');
     }
	public function index()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_finance').' | '.$this->Xin_model->site_title();
		
		$data['breadcrumbs'] = $this->lang->line('xin_hr_finance');
		$data['path_url'] = 'accounting';
		$data['get_invoice_payments'] = $this->Finance_model->get_invoice_payments();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('72',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/finance", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 public function accounting_dashboard()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('hr_accounting_dashboard_title').' | '.$this->Xin_model->site_title();
		
		$data['breadcrumbs'] = $this->lang->line('hr_accounting_dashboard_title');
		$data['path_url'] = 'projects_dashboard';
		$data['get_invoice_payments'] = $this->Finance_model->get_invoice_payments();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('286',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/accounting_dashboard", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     } 
	public function deposit() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_deposit').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_deposit');
		$data['path_url'] = 'accounting_deposit';
		$data['all_payers'] = $this->Finance_model->all_payers();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('75',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/deposit_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transfer() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_transfer').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_transfer');
		$data['path_url'] = 'accounting_transfer';
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('77',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/transfer_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function expense() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_expense').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_expense');
		$data['path_url'] = 'accounting_expense';
		$data['all_payees'] = $this->Finance_model->all_payees();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_expense_types'] = $this->Expense_model->all_expense_types();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('76',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/expense_list", $data, TRUE);
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
			$this->load->view("admin/accounting/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > expense_types
	 public function get_company_expense_types() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/get_company_expense_types", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > expense_types
	 public function get_expense_types() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/get_expense_types", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > expense_types
	 public function get_expense_type_reports() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/get_expense_type_reports", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	public function payers() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_payers').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_payers');
		$data['path_url'] = 'accounting_payers';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('81',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/payers_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function payees() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_payees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_payees');
		$data['path_url'] = 'accounting_payees';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('80',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/payees_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	public function bank_cash() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_accounts').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_accounts');
		$data['path_url'] = 'accounting_bank_cash';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('72',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/bank_cash_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function account_balances() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_account_balances').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_account_balances');
		$data['path_url'] = 'accounting_account_balances';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('73',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/account_balances", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transactions() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_view_transactions').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_view_transactions');
		$data['path_url'] = 'accounting_transactions';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('78',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/transaction_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	 
	 public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('bankcash_id');
		$result = $this->Finance_model->read_bankcash_information($id);
		$data = array(
				'bankcash_id' => $result[0]->bankcash_id,
				'account_name' => $result[0]->account_name,
				'account_balance' => $result[0]->account_balance,
				'account_number' => $result[0]->account_number,
				'branch_code' => $result[0]->branch_code,
				'bank_branch' => $result[0]->bank_branch,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	public function read_payer() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('payer_id');
		$result = $this->Finance_model->read_payer_info($id);
		$data = array(
				'payer_id' => $result[0]->payer_id,
				'payer_name' => $result[0]->payer_name,
				'contact_number' => $result[0]->contact_number,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_payee() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('payee_id');
		$result = $this->Finance_model->read_payee_info($id);
		$data = array(
				'payee_id' => $result[0]->payee_id,
				'payee_name' => $result[0]->payee_name,
				'contact_number' => $result[0]->contact_number,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	// payers list
	public function payers_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/payers_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$payer = $this->Finance_model->get_payers();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($payer->result() as $r) {
			  
		   // create at
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			if(in_array('368',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".add-modal-data"  data-payer_id="'. $r->payer_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('369',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->payer_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$r->payer_name,
				$r->contact_number,
				$created_at
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payer->num_rows(),
                 "recordsFiltered" => $payer->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // payees list
	public function payees_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/payees_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$payee = $this->Finance_model->get_payees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($payee->result() as $r) {
			  
		   // create at
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			if(in_array('365',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".add-modal-data"  data-payee_id="'. $r->payee_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('366',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->payee_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$r->payee_name,
				$r->contact_number,
				$created_at
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payee->num_rows(),
                 "recordsFiltered" => $payee->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // bank and cash list
	public function bank_cash_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/bank_cash_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$bankcash = $this->Finance_model->get_bankcash();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($bankcash->result() as $r) {
			  
			// get currency
			$account_balance = $this->Xin_model->currency_sign($r->account_balance);
			$bank_cash = $this->Finance_model->read_transaction_by_bank_info($r->bankcash_id);
			if(!is_null($bank_cash)){
				$account = '<a data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_acc_ledger_view').'" href="'.site_url('admin/accounting/accounts_ledger/'.$r->bankcash_id.'').'" target="_blank">'.$r->account_name.'</a>';
			} else {
				$account = $r->account_name;
			}
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-bankcash_id="'. $r->bankcash_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->bankcash_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			
			$combhr = $edit.$delete;

		   $data[] = array(
				$combhr,
				$account,
				$r->account_number,
				$r->branch_code,
				$account_balance,
				$r->bank_branch
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $bankcash->num_rows(),
                 "recordsFiltered" => $bankcash->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // account balances list
	public function account_balances_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/account_balances", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$bankcash = $this->Finance_model->get_bankcash();
		
		$data = array();

          foreach($bankcash->result() as $r) {
			  
			  // get currency
			  $account_balance = $this->Xin_model->currency_sign($r->account_balance);
			  $bank_cash = $this->Finance_model->read_transaction_by_bank_info($r->bankcash_id);
			  if(!is_null($bank_cash)){
			  	$account = '<a data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_acc_ledger_view').'" href="'.site_url('admin/accounting/accounts_ledger/'.$r->bankcash_id.'').'" target="_blank">'.$r->account_name.'</a>';
			  } else {
				  $account = $r->account_name;
			  }

               $data[] = array(
                    $account,
                    $account_balance
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $bankcash->num_rows(),
                 "recordsFiltered" => $bankcash->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // deposit list
	public function deposit_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/deposit_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$deposit = $this->Finance_model->get_deposit();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($deposit->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get user > added by
			$payer = $this->Finance_model->read_payer_info($r->payer_payee_id);
			// user full name
			if(!is_null($payer)){
				$full_name = $payer[0]->payer_name;
			} else {
				$full_name = '--';	
			}
			
			// deposit date
			$deposit_date = $this->Xin_model->set_date_format($r->transaction_date);
			// category
			$category_id = $this->Finance_model->read_income_category($r->transaction_cat_id);
			if(!is_null($category_id)){
				$category = $category_id[0]->name;
			} else {
				$category = '--';	
			}
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-deposit_id="'. $r->transaction_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transaction_id . '"><span class="fas fa-trash-restore"></span></button></span>';			
			$combhr = $edit.$delete;

		   $data[] = array(
				$combhr,
				$account,
				$full_name,
				$amount,
				$category,
				$r->reference,
				$method_name,
				$deposit_date
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $deposit->num_rows(),
			 "recordsFiltered" => $deposit->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // expense list
	public function expense_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/expense_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$expense = $this->Finance_model->get_expense();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($expense->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get user > added by
			if($r->payee_option == 1){
				$payee = $this->Xin_model->read_user_info($r->payer_payee_id);
				// user full name
				if(!is_null($payee)){
					$full_name = $payee[0]->first_name.' '.$payee[0]->last_name;
				} else {
					$full_name = '--';	
				}
			} else {
				$payee = $this->Finance_model->read_payee_info($r->payer_payee_id);
				// user full name
				if(!is_null($payee)){
					$full_name = $payee[0]->payee_name;
				} else {
					$full_name = '--';	
				}
			}
			//
			
						
			// deposit date
			$expense_date = $this->Xin_model->set_date_format($r->transaction_date);
			// category
			$expense_type = $this->Expense_model->read_expense_type_information($r->transaction_cat_id);
			if(!is_null($expense_type)){
				$category = $expense_type[0]->name;
			} else {
				$category = '--';	
			}
			
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-expense_id="'. $r->transaction_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transaction_id . '"><span class="fas fa-trash-restore"></span></button></span>';			
			$combhr = $edit.$delete;

		   	$data[] = array(
				$combhr,
				$account,
				$full_name,
				$amount,
				$category,
				$r->reference,
				$method_name,
				$expense_date
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
	 
	// transactions list
	public function transaction_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/transaction_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transaction = $this->Finance_model->get_transaction();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();
		$balance2 = 0;
          foreach($transaction->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			// credit
			$cr_dr = $r->dr_cr=="dr" ? "Debit" : "Credit";
			
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account = '<a href="'.site_url('admin/accounting/accounts_ledger/'.$r->account_id.'').'" title="'.$this->lang->line('xin_acc_ledger_view').'" target="_blank">'.$acc_type[0]->account_name.'</a>';
			} else {
				$account = '--';	
			}
			//
			if($r->dr_cr=="cr"){
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".view-modal-data-bg"  data-deposit_id="'. $r->transaction_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-expense_id="'. $r->transaction_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			}
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transaction_id . '"><span class="fas fa-trash-restore"></span></button></span>';			
			$combhr = $edit.$delete;
			
			$data[] = array(
				$transaction_date,
				$account,
				$cr_dr,
				$r->transaction_type,
				$total_amount,
				$r->reference
			);
		  }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $transaction->num_rows(),
                 "recordsFiltered" => $transaction->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // Validate and add info in database
	public function add_deposit() {
	
		if($this->input->post('add_type')=='deposit') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('deposit_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		}
		else if($_FILES['deposit_file']['size'] == 0) {
			$fname = 'no_file';
		}
		else if(is_uploaded_file($_FILES['deposit_file']['tmp_name'])) {
			//checking image type
			//$Return['error'] = $this->lang->line('xin_acc_error_attachment');
			$allowed =  array('PNG','JPG','JPEG','PDF','GIF','png','jpg','jpeg','pdf','gif','txt','doc','docx','xls','xlsx');
			$filename = $_FILES['deposit_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["deposit_file"]["tmp_name"];
				$profile = "uploads/accounting/deposit/";
				$set_img = base_url()."uploads/accounting/deposit/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["deposit_file"]["name"]);
				$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;					
			} else {
				$Return['error'] = $this->lang->line('xin_acc_error_attachment');
			}
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'account_id' => $this->input->post('bank_cash_id'),
		'amount' => $this->input->post('amount'),
		'transaction_type' => 'income',
		'dr_cr' => 'dr',
		'transaction_date' => $this->input->post('deposit_date'),
		'attachment_file' => $fname,
		'transaction_cat_id' => $this->input->post('category_id'),
		'payer_payee_id' => $this->input->post('payer_id'),
		'payment_method_id' => $this->input->post('payment_method'),
		'description' => 'Deposit Amount',
		'reference' => $this->input->post('deposit_reference'),
		'invoice_id' => 0,
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_transactions($data);
		if ($result == TRUE) {			
			// add data to bank account>cr
			$account_id = $this->Finance_model->read_bankcash_information($this->input->post('bank_cash_id'));
			$acc_balance = $account_id[0]->account_balance + $this->input->post('amount');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$this->input->post('bank_cash_id'));
		
			$Return['result'] = $this->lang->line('xin_acc_success_deposit_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	} 
	
	// Validate and add info in database
	public function add_expense() {
	
		if($this->input->post('add_type')=='expense') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		$bank_cash = $this->Finance_model->read_bankcash_information($this->input->post('bank_cash_id'));
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('amount') > $bank_cash[0]->account_balance) {
			$Return['error'] = $this->lang->line('xin_acc_error_amount_should_be_less_than_current');
		} else if($this->input->post('expense_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_expense_date');
		} else if($this->input->post('company')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('payee_id')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_payee_name');
		}
		else if($_FILES['expense_file']['size'] == 0) {
			$fname = 'no_file';
		}
		else if(is_uploaded_file($_FILES['expense_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif','txt','doc','docx','xls','xlsx');
			$filename = $_FILES['expense_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["expense_file"]["tmp_name"];
				$profile = "uploads/accounting/expense/";
				$set_img = base_url()."uploads/accounting/expense/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["expense_file"]["name"]);
				$newfilename = 'expense_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;					
			} else {
				$Return['error'] = $this->lang->line('xin_acc_error_attachment');
			}
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'account_id' => $this->input->post('bank_cash_id'),
		'amount' => $this->input->post('amount'),
		'transaction_type' => 'expense',
		'dr_cr' => 'cr',
		'transaction_date' => $this->input->post('expense_date'),
		'attachment_file' => $fname,
		'transaction_cat_id' => $this->input->post('category_id'),
		'payer_payee_id' => $this->input->post('payee_id'),
		'payee_option' => $this->input->post('payee_option'),
		'company_id' => $this->input->post('company'),
		'payment_method_id' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'reference' => $this->input->post('expense_reference'),
		'invoice_id' => 0,
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_transactions($data);
		if ($result == TRUE) {			
			// update data in bank account
			$account_id = $this->Finance_model->read_bankcash_information($this->input->post('bank_cash_id'));
			$acc_balance = $account_id[0]->account_balance - $this->input->post('amount');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$this->input->post('bank_cash_id'));
			
			$Return['result'] = $this->lang->line('xin_acc_success_expense_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	} 
	
	// Validate and add info in database
	public function add_invoice_payment() {
	
		if($this->input->post('add_type')=='invoice_payment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		$invoice_tr = $this->Finance_model->read_invoice_transaction($this->input->post('invoice_id'));
		if ($invoice_tr->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_acc_inv_paid_already');
		} 
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		if($this->input->post('bank_cash_id')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('add_invoice_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		} else if($this->input->post('payment_method')==='') {
			$Return['error'] = $this->lang->line('xin_error_makepayment_payment_method');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$invoice_id = $this->input->post('invoice_id');
		$data = array(
		'account_id' => $this->input->post('bank_cash_id'),
		'amount' => $this->input->post('amount'),
		'transaction_type' => 'income',
		'invoice_type' => 'customer',
		'dr_cr' => 'dr',
		'transaction_date' => $this->input->post('add_invoice_date'),
		'attachment_file' => '',
		'transaction_cat_id' => $this->input->post('category_id'),
		'payer_payee_id' => $this->input->post('payer_id'),
		'payment_method_id' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'reference' => $this->input->post('reference'),
		'invoice_id' => $invoice_id,
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_transactions($data);
		if ($result == TRUE) {			
			// add data to bank account>cr
			$account_id = $this->Finance_model->read_bankcash_information($this->input->post('bank_cash_id'));
			$acc_balance = $account_id[0]->account_balance + $this->input->post('amount');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$this->input->post('bank_cash_id'));
			$data = array(
				'status' => 1,
			);
			$result = $this->Invoices_model->update_invoice_record($data,$invoice_id);
		
			$Return['result'] = $this->lang->line('xin_acc_success_deposit_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	}
	// Validate and add info in database
	public function add_direct_invoice_payment() {
	
		if($this->input->post('add_type')=='invoice_payment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		$invoice_tr = $this->Finance_model->read_invoice_transaction($this->input->post('invoice_id'));
		if ($invoice_tr->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_acc_inv_paid_already');
		} 
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		if($this->input->post('bank_cash_id')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('add_invoice_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		} else if($this->input->post('payment_method')==='') {
			$Return['error'] = $this->lang->line('xin_error_makepayment_payment_method');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$invoice_id = $this->input->post('invoice_id');
		$data = array(
		'account_id' => $this->input->post('bank_cash_id'),
		'amount' => $this->input->post('amount'),
		'transaction_type' => 'income',
		'invoice_type' => 'direct',
		'dr_cr' => 'dr',
		'transaction_date' => $this->input->post('add_invoice_date'),
		'attachment_file' => '',
		'transaction_cat_id' => $this->input->post('category_id'),
		'payer_payee_id' => $this->input->post('payer_id'),
		'payment_method_id' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'reference' => $this->input->post('reference'),
		'invoice_id' => $invoice_id,
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_transactions($data);
		if ($result == TRUE) {			
			// add data to bank account>cr
			$account_id = $this->Finance_model->read_bankcash_information($this->input->post('bank_cash_id'));
			$acc_balance = $account_id[0]->account_balance + $this->input->post('amount');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$this->input->post('bank_cash_id'));
			$data = array(
				'status' => 1,
			);
			$result = $this->Invoices_model->update_direct_invoice_record($data,$invoice_id);
		
			$Return['result'] = $this->lang->line('xin_acc_success_deposit_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	}
	
	// Validate and add info in database
	public function add_transfer() {
	
		if($this->input->post('add_type')=='transfer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('from_bank_cash_id')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_from_account');
		} else if($this->input->post('to_bank_cash_id')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_to_account');
		} else if($this->input->post('from_bank_cash_id')== $this->input->post('to_bank_cash_id')) {
        	$Return['error'] = $this->lang->line('xin_acc_error_transer_to_same_account');
		} else if($this->input->post('transfer_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_transer_date');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('amount') > $this->input->post('account_balance')) {
			$Return['error'] = $this->lang->line('xin_acc_error_amount_should_be_less_than_current');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$from_account_id = $this->Finance_model->read_bankcash_information($this->input->post('from_bank_cash_id'));
		$frm_acc = $from_account_id[0]->account_balance - $this->input->post('amount');
		
		$to_bank_cash_id = $this->Finance_model->read_bankcash_information($this->input->post('to_bank_cash_id'));
		$to_acc = $to_bank_cash_id[0]->account_balance + $this->input->post('amount');
		
		$data = array(
		'account_id' => $this->input->post('from_bank_cash_id'),
		'amount' => $this->input->post('amount'),
		'transaction_type' => 'transfer',
		'dr_cr' => 'cr',
		'transaction_date' => $this->input->post('transfer_date'),
		'attachment_file' => '',
		'transaction_cat_id' => 0,
		'payer_payee_id' => 0,
		'payment_method_id' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'reference' => $this->input->post('transfer_reference'),
		'invoice_id' => 0,
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_transactions($data);
		
		$data2 = array(
		'account_balance' => $frm_acc
		);
		$result2 = $this->Finance_model->update_bankcash_record($data2,$this->input->post('from_bank_cash_id'));
		
		$data3 = array(
		'account_balance' => $to_acc
		);
		$result3 = $this->Finance_model->update_bankcash_record($data3,$this->input->post('to_bank_cash_id'));
		
		if ($result == TRUE) {
			
			$data4 = array(
				'account_id' => $this->input->post('to_bank_cash_id'),
				'amount' => $this->input->post('amount'),
				'transaction_type' => 'transfer',
				'dr_cr' => 'dr',
				'transaction_date' => $this->input->post('transfer_date'),
				'attachment_file' => '',
				'transaction_cat_id' => 0,
				'payer_payee_id' => 0,
				'payment_method_id' => $this->input->post('payment_method'),
				'description' => $qt_description,
				'reference' => $this->input->post('transfer_reference'),
				'invoice_id' => 0,
				'created_at' => date('Y-m-d H:i:s')
			);
			$result4 = $this->Finance_model->add_transactions($data4);
			
			$Return['result'] = $this->lang->line('xin_acc_success_transfer_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	}
	
	// Validate and add info in database> add bank-cash
	public function add_bankcash() {
	
		if($this->input->post('add_type')=='bankcash') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$bank_branch = $this->input->post('bank_branch');
		$qt_bank_branch = htmlspecialchars(addslashes($bank_branch), ENT_QUOTES);
			
		/* Server side PHP input validation */
		if($this->input->post('account_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_account_name_field');
		} else if($this->input->post('account_balance')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_account_balance_field');
		} else if($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'account_name' => $this->input->post('account_name'),
		'account_balance' => $this->input->post('account_balance'),
		'account_opening_balance' => $this->input->post('account_balance'),
		'account_number' => $this->input->post('account_number'),
		'branch_code' => $this->input->post('branch_code'),
		'bank_branch' => $qt_bank_branch,
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Finance_model->add_bankcash($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_bank_cash_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
	
	// Validate and add info in database> add bank-cash
	public function bankcash_update() {
	
		if($this->input->post('edit_type')=='bankcash') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$bank_branch = $this->input->post('bank_branch');
		$qt_bank_branch = htmlspecialchars(addslashes($bank_branch), ENT_QUOTES);
			
		/* Server side PHP input validation */
		if($this->input->post('account_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_account_name_field');
		} else if($this->input->post('account_balance')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_account_balance_field');
		} else if($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		} 
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'account_name' => $this->input->post('account_name'),
		'account_balance' => $this->input->post('account_balance'),
		'account_number' => $this->input->post('account_number'),
		'branch_code' => $this->input->post('branch_code'),
		'bank_branch' => $qt_bank_branch,
		);
		$result = $this->Finance_model->update_bankcash_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_bank_cash_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
		 
	 // delete record
	public function delete() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_bankcash_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_bank_cash_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_deposit_transaction() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_transaction_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_deposit_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_expense() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_transaction_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_expense_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_transaction() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_transaction_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_transaction_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function read_invoice()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$invoice_id = $this->input->get('invoice_id');
		$invoice_type = $this->input->get('data');
		if($invoice_type == 'customer'){
			$result = $this->Invoices_model->read_invoice_info($invoice_id);
		} else {
			$result = $this->Invoices_model->read_direct_invoice_info($invoice_id);
		}
		$data = array(
				'invoice_id' => $result[0]->invoice_id,
				'invoice_number' => $result[0]->invoice_number,
				'grand_total' => $result[0]->grand_total,
				'all_payers' => $this->Customers_model->get_all_customers(),
				'all_bank_cash' => $this->Finance_model->all_bank_cash(),
				'all_income_categories_list' => $this->Finance_model->all_income_categories_list(),
				'get_all_payment_method' => $this->Finance_model->get_all_payment_method()
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_deposit()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('deposit_id');
		$result = $this->Finance_model->read_transaction_information($id);
		$data = array(
				'deposit_id' => $result[0]->transaction_id,
				'account_type_id' => $result[0]->account_id,
				'amount' => $result[0]->amount,
				'deposit_date' => $result[0]->transaction_date,
				'categoryid' => $result[0]->transaction_cat_id,
				'payer_id' => $result[0]->payer_payee_id,
				'payment_method_id' => $result[0]->payment_method_id,
				'deposit_reference' => $result[0]->reference,
				'deposit_file' => $result[0]->attachment_file,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_payers' => $this->Finance_model->all_payers(),
				'all_bank_cash' => $this->Finance_model->all_bank_cash(),
				'all_income_categories_list' => $this->Finance_model->all_income_categories_list(),
				'get_all_payment_method' => $this->Finance_model->get_all_payment_method()
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and update info in database
	public function deposit_update() {
	
		if($this->input->post('edit_type')=='deposit') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('deposit_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		}		
		/* Check if file uploaded..*/
		else if($_FILES['deposit_file']['size'] == 0) {
			 $fname = 'no_file';
			 $data = array(
			'account_id' => $this->input->post('bank_cash_id'),
			'amount' => $this->input->post('amount'),
			'transaction_date' => $this->input->post('deposit_date'),
			'transaction_cat_id' => $this->input->post('category_id'),
			'payer_payee_id' => $this->input->post('payer_id'),
			'payment_method_id' => $this->input->post('payment_method'),
			'description' => $qt_description,
			'reference' => $this->input->post('deposit_reference'),		
			);
			 $result = $this->Finance_model->update_transaction_record($data,$id);
		} else {
			if(is_uploaded_file($_FILES['deposit_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['deposit_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["deposit_file"]["tmp_name"];
					$bill_copy = "uploads/accounting/deposit/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["deposit_file"]["name"]);
					$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					 $data = array(
					'account_id' => $this->input->post('bank_cash_id'),
					'amount' => $this->input->post('amount'),
					'transaction_date' => $this->input->post('deposit_date'),
					'attachment_file' => $fname,
					'transaction_cat_id' => $this->input->post('category_id'),
					'payer_payee_id' => $this->input->post('payer_id'),
					'payment_method_id' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'reference' => $this->input->post('deposit_reference'),	
					);
					// update record > model
					$result = $this->Finance_model->update_transaction_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_deposit_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function transaction_update() {
	
		if($this->input->post('edit_type')=='deposit') {
			
		$id = $this->uri->segment(4);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('deposit_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		}		
		/* Check if file uploaded..*/
		else if($_FILES['deposit_file']['size'] == 0) {
			 $fname = 'no_file';
			 $data = array(
			'transaction_date' => $this->input->post('deposit_date'),
			'transaction_cat_id' => $this->input->post('category_id'),
			'payer_payee_id' => $this->input->post('payer_id'),
			'payment_method_id' => $this->input->post('payment_method'),
			'description' => $qt_description,
			'reference' => $this->input->post('deposit_reference'),		
			);
			 $result = $this->Finance_model->update_transaction_record($data,$id);
		} else {
			if(is_uploaded_file($_FILES['deposit_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['deposit_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["deposit_file"]["tmp_name"];
					$bill_copy = "uploads/accounting/deposit/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["deposit_file"]["name"]);
					$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					 $data = array(
					'transaction_date' => $this->input->post('deposit_date'),
					'attachment_file' => $fname,
					'transaction_cat_id' => $this->input->post('category_id'),
					'payer_payee_id' => $this->input->post('payer_id'),
					'payment_method_id' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'reference' => $this->input->post('deposit_reference'),	
					);
					// update record > model
					$result = $this->Finance_model->update_transaction_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_inv_transaction_edited_successfully');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function read_expense()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('expense_id');
		$result = $this->Finance_model->read_transaction_information($id);
		$data = array(
				'expense_id' => $result[0]->transaction_id,
				'account_type_id' => $result[0]->account_id,
				'amount' => $result[0]->amount,
				'expense_date' => $result[0]->transaction_date,
				'categoryid' => $result[0]->transaction_cat_id,
				'payee_id' => $result[0]->payer_payee_id,
				'payee_option' => $result[0]->payee_option,
				'company_id' => $result[0]->company_id,
				'payment_method_id' => $result[0]->payment_method_id,
				'expense_reference' => $result[0]->reference,
				'expense_file' => $result[0]->attachment_file,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_payees' => $this->Finance_model->all_payees(),
				'all_bank_cash' => $this->Finance_model->all_bank_cash(),
				'all_expense_types' => $this->Expense_model->all_expense_types(),
				'all_income_categories_list' => $this->Finance_model->all_income_categories_list(),
				'get_all_payment_method' => $this->Finance_model->get_all_payment_method(),
				'all_employees' => $this->Xin_model->all_employees(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and update info in database
	public function expense_update() {
	
		if($this->input->post('edit_type')=='expense') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} /*else if($this->input->post('amount') > $this->input->post('account_balance')) {
			$Return['error'] = $this->lang->line('xin_acc_error_amount_should_be_less_than_current');
		}*/ else if($this->input->post('expense_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_expense_date');
		} else if($this->input->post('company')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		}	
		/* Check if file uploaded..*/
		else if($_FILES['expense_file']['size'] == 0) {
			 $fname = 'no_file';
			 $data = array(
			'account_id' => $this->input->post('bank_cash_id'),
			'amount' => $this->input->post('amount'),
			'transaction_date' => $this->input->post('expense_date'),
			'transaction_cat_id' => $this->input->post('category_id'),
			'payer_payee_id' => $this->input->post('payee_id'),
			'company_id' => $this->input->post('company'),
			'payment_method_id' => $this->input->post('payment_method'),
			'description' => $qt_description,
			'reference' => $this->input->post('expense_reference'),		
			);
			 $result = $this->Finance_model->update_transaction_record($data,$id);
		} else {
			if(is_uploaded_file($_FILES['expense_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['expense_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["expense_file"]["tmp_name"];
					$bill_copy = "uploads/accounting/deposit/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["expense_file"]["name"]);
					$newfilename = 'expense_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					 $data = array(
					'account_id' => $this->input->post('bank_cash_id'),
					'amount' => $this->input->post('amount'),
					'transaction_date' => $this->input->post('expense_date'),
					'attachment_file' => $fname,
					'transaction_cat_id' => $this->input->post('category_id'),
					'payer_payee_id' => $this->input->post('payee_id'),
					'company_id' => $this->input->post('company'),
					'payment_method_id' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'reference' => $this->input->post('expense_reference'),	
					);
					// update record > model
					$result = $this->Finance_model->update_transaction_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_expense_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
		}
	}
	
	/****AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA*/////	
	public function accounts_ledger() {
	
		$id = $this->uri->segment(4);
		$bac_id = $this->Finance_model->read_transaction_by_bank_info($id);
		if(is_null($bac_id)){
			redirect('admin/accounting/transactions');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_acc_ledger_account').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_ledger_account');
		$data['path_url'] = 'accounting_bankwise_transactions';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
			if(in_array('4',$role_resources_ids)) {
				$data['subview'] = $this->load->view("admin/accounting/ledger_account_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/dashboard');
			}
		} else {
			redirect('admin/');
		}
	}
	
	public function ledger_accounts() {
	
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_acc_ledger_account').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_ledger_account');
		$data['path_url'] = 'xin_ledger_accounts';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
			if(in_array('4',$role_resources_ids)) {
				$data['subview'] = $this->load->view("admin/accounting/full_ledger_account_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/dashboard');
			}
		} else {
			redirect('admin/');
		}
	}
	
	public function account_statement() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_account_statement').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_account_statement');
		$data['path_url'] = 'accounting_report_statement';
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('83',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_account_statement", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function expense_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_expense_reports').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_expense_reports');
		$data['path_url'] = 'accounting_report_expense';
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_expense_types'] = $this->Expense_model->all_expense_types();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('84',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_expense", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function income_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_income_reports').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_income_reports');
		$data['path_url'] = 'accounting_report_income';
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('85',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_income", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transfer_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_transfer_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_transfer_report');
		$data['path_url'] = 'accounting_report_transfer';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('86',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_transfer", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
		
	public function read_transfer()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('transfer_id');
		$result = $this->Finance_model->read_transfer_information($id);
		$data = array(
				'transfer_id' => $result[0]->transfer_id,
				'from_account_id' => $result[0]->from_account_id,
				'to_account_id' => $result[0]->to_account_id,
				'transfer_date' => $result[0]->transfer_date,
				'transfer_amount' => $result[0]->transfer_amount,
				'payment_method_id' => $result[0]->payment_method,
				'transfer_reference' => $result[0]->transfer_reference,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_bank_cash' => $this->Finance_model->all_bank_cash(),
				'get_all_payment_method' => $this->Finance_model->get_all_payment_method()
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	 
	 /****Reports ***/
    	 
	// report account statement > search
	public function report_statement_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_account_statement", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
				
		$transactions = $this->Finance_model->account_statement_search($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('account_id'));
		
		$data = array();
		$crd_total = 0; $deb_total = 0;$balance=0; $balance2 = 0;
        foreach($transactions->result() as $r) {
			  
		   // transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account_balance = $acc_type[0]->account_opening_balance;
			} else {
				$account_balance = 0;	
			}
			
			if($r->dr_cr == 'cr') {
				$balance2 = $balance2 - $r->amount;
			} else {
				$balance2 = $balance2 + $r->amount;
			}
			if($r->credit!=0):
				$crd = $r->credit;
				$crd_total += $crd;
			else:
				$crd = 0;	
				$crd_total += $crd;
			endif;
			if($r->debit!=0):
				$deb = $r->debit;
				$deb_total += $deb;
			else:
				$deb = 0;	
				$deb_total += $deb;
			endif;
			//$fbalance = $account_balance + $balance2;
			
			$data[] = array(
				$transaction_date,
				$r->transaction_type,
				$r->description,
				$this->Xin_model->currency_sign($crd),
				$this->Xin_model->currency_sign($deb)
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $transactions->num_rows(),
                 "recordsFiltered" => $transactions->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // get statement footer - data
	 public function get_statement_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'account_id' => $this->input->get('account_id')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_statement_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 // report expense list
	public function report_expense_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_expense", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$expense = $this->Finance_model->get_expense_search($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('type_id'),$this->input->get('company_id'));
		
		$data = array();

          foreach($expense->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get payee
			$payee = $this->Xin_model->read_user_info($r->payer_payee_id);
			// user full name
			if(!is_null($payee)){
				$full_name = $payee[0]->first_name.' '.$payee[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			// deposit date
			$expense_date = $this->Xin_model->set_date_format($r->transaction_date);
			// category
			$expense_type = $this->Expense_model->read_expense_type_information($r->transaction_cat_id);
			if(!is_null($expense_type)){
				$category = $expense_type[0]->name;
			} else {
				$category = '--';	
			}
			
		   $data[] = array(
				$expense_date,
				$account,
				$category,
				$full_name,
				$amount,
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
	 
	 // get expense footer - data
	 public function get_expense_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'type_id' => $this->input->get('type_id'),
			'company_id' => $this->input->get('company_id')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_expense_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 // income report list
	public function report_income_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_income", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$deposit = $this->Finance_model->get_deposit_search($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('type_id'));
		
		$data = array();

          foreach($deposit->result() as $r) {
			  
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get payee
			$payer = $this->Finance_model->read_payer_info($r->payer_payee_id);
			// user full name
			if(!is_null($payer)){
				$full_name = $payer[0]->payer_name;
			} else {
				$full_name = '--';	
			}
			
			// deposit date
			$deposit_date = $this->Xin_model->set_date_format($r->transaction_date);
			// category
			$category_id = $this->Finance_model->read_income_category($r->transaction_cat_id);
			if(!is_null($category_id)){
				$category = $category_id[0]->name;
			} else {
				$category = '--';	
			}
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);

		   $data[] = array(
				$deposit_date,
				$account,
				$category,
				$full_name,
				$amount		
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $deposit->num_rows(),
			 "recordsFiltered" => $deposit->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	// report transfer list
	public function report_transfer_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_transfer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transfer = $this->Finance_model->get_transfer_search($this->input->get('from_date'),$this->input->get('to_date'));
		
		$data = array();

        foreach($transfer->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			if($r->dr_cr == 'cr') {
				$xin_acc = $this->lang->line('xin_acc_credit');
			} else {
				$xin_acc = $this->lang->line('xin_acc_debit');
			}			
			// transfer date
			$transfer_date = $this->Xin_model->set_date_format($r->transaction_date);
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			$r->dr_cr=="dr" ? $this->lang->line('xin_acc_debit') : $this->lang->line('xin_acc_credit');
			$r->debit!=NULL ? $db_am = "- ".$this->Xin_model->currency_sign($r->debit) : $db_am ="";
			$r->credit!=NULL ? $cr_am = "+ ".$this->Xin_model->currency_sign($r->credit) : $cr_am ="";
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
		   $data[] = array(
				$transfer_date,
				$r->description,
				$account,
				$xin_acc,
				$db_am,
				$cr_am
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $transfer->num_rows(),
			 "recordsFiltered" => $transfer->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	 // report income vs expense > search
	public function report_income_expense_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
				
		$account_statement = $this->Finance_model->get_income_expense_search($this->input->get('from_date'),$this->input->get('to_date'));
		
		$data = array();
		$debit="";
		$debit_total=0;
		$credit="";
		$credit_total=0;
        foreach($account_statement->result() as $r) {
			  		  
			if($r->transaction_credit!=0.00 && $r->transaction_credit > 0){
				$credit_total=$credit_total+$r->transaction_credit;
			}
			else if($r->transaction_debit!=0.00 && $r->transaction_debit > 0){
				$debit_total = $debit_total+$r->transaction_debit;
			}
		 }
		 
		 $totalD = "<b class='pull-right'>".$this->lang->line('xin_acc_total_credit').": ".$this->Xin_model->currency_sign($debit_total)."</b>";
		 $totalC = "<b class='pull-right'>".$this->lang->line('xin_acc_total_debit').": ".$this->Xin_model->currency_sign($credit_total)."</b>";
		 $data[] = array(
			$totalC.' '.$totalC,
			$totalD.' '.$totalD
	   );
          
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $account_statement->num_rows(),
                 "recordsFiltered" => $account_statement->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // ***** LISTING 
	 // sales_report_list
	public function accounts_ledger_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/full_ledger_account_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$acc_ledger = $this->Finance_model->get_ledger_accounts($this->input->get('from_date'),$this->input->get('to_date'));
		
		$data = array();
		$crd_total = 0; $deb_total = 0;$balance=0; $balance2 = 0;
        foreach($acc_ledger->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account_balance = $acc_type[0]->account_opening_balance;
			} else {
				$account_balance = 0;	
			}
			
			if($r->dr_cr == 'cr') {
				$balance2 = $balance2 - $r->amount;
			} else {
				$balance2 = $balance2 + $r->amount;
			}
			if($r->credit!=0):
				$crd = $r->credit;
				$crd_total += $crd;
			else:
				$crd = 0;	
				$crd_total += $crd;
			endif;
			if($r->debit!=0):
				$deb = $r->debit;
				$deb_total += $deb;
			else:
				$deb = 0;	
				$deb_total += $deb;
			endif;
			$fbalance = $account_balance + $balance2;
			
		   $data[] = array(
				$transaction_date,
				$r->transaction_type,
				$r->description,
				$this->Xin_model->currency_sign($crd),
				$this->Xin_model->currency_sign($deb),
				$this->Xin_model->currency_sign($fbalance)
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $acc_ledger->num_rows(),
			 "recordsFiltered" => $acc_ledger->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	 // get sales footer - data
	 public function get_accounts_ledger_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_ledger_accounts_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // Validate and add info in database
	public function add_payer() {
	
		if($this->input->post('add_type')=='add_payer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('payer_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payer_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payer_name' => $this->input->post('payer_name'),
		'contact_number' => $this->input->post('contact_number'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Finance_model->add_payer_record($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_payer_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_payee() {
	
		if($this->input->post('add_type')=='add_payee') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('payee_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payee_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payee_name' => $this->input->post('payee_name'),
		'contact_number' => $this->input->post('contact_number'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Finance_model->add_payee_record($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_payee_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_payer() {
	
		if($this->input->post('edit_type')=='payer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('payer_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payer_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payer_name' => $this->input->post('payer_name'),
		'contact_number' => $this->input->post('contact_number'),
		);
		
		$result = $this->Finance_model->update_payer_record($data,$id);
		if ($id) {
			$Return['result'] = $this->lang->line('xin_acc_success_payer_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_payee() {
	
		if($this->input->post('edit_type')=='payee') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('payee_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payee_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payee_name' => $this->input->post('payee_name'),
		'contact_number' => $this->input->post('contact_number'),
		);
		
		$result = $this->Finance_model->update_payee_record($data,$id);
		if ($id) {
			$Return['result'] = $this->lang->line('xin_acc_success_payee_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// delete record
	public function delete_payer() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_payer_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_payer_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_payee() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_payee_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_payee_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// bank wise transactions list
	public function bankwise_transactions_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/full_ledger_account_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$ac_id = $this->uri->segment(4);
		$transactions = $this->Finance_model->get_bankwise_transactions($ac_id);
		
		$data = array();
		$balance2 = 0;
          foreach($transactions->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			// credit
			//$transaction_credit = $this->Xin_model->currency_sign($r->transaction_credit);
			// debit
			//$transaction_debit = $this->Xin_model->currency_sign($r->transaction_debit);			
			// total credit
			// balance
			/*if($r->transaction_debit == 0) {
				$balance2 = $balance2 - $r->transaction_credit;
			} else {
				$balance2 = $balance2 + $r->transaction_debit;
			}
			$balance = $this->Xin_model->currency_sign($balance2);*/
			
			$data[] = array(
				$transaction_date,
				$r->transaction_type,
				$r->description,
				$total_amount,
				$r->description,
				$r->description
			);
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $transactions->num_rows(),
                 "recordsFiltered" => $transactions->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     } 	
	 // get income footer - data
	 public function get_income_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'type_id' => $this->input->get('type_id')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_income_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get transfer footer - data
	 public function get_transfer_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_transfer_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > payee
	 public function get_all_payee() {

		$data['title'] = $this->Xin_model->site_title();
		$id = 1;		
		$data = array(
		'hrsale' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$data = $this->security->xss_clean($data);
			$this->load->view("admin/accounting/get_all_payee", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
} 
?>