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

class Invoices extends MY_Controller
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
		  $this->load->model("Project_model");
		  $this->load->model("Tax_model");
		  $this->load->model("Invoices_model");
		  $this->load->model("Clients_model");
     }
	 
	// invoices page
	public function index() {
	
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$data['title'] = $this->lang->line('xin_invoices_title');
		$data['breadcrumbs'] = $this->lang->line('xin_invoices_title');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrsale_invoices';
		$data['subview'] = $this->load->view("client/invoices/invoices_list", $data, TRUE);
		$this->load->view('client/layout/layout_main', $data); //page load
	}
	// invoice payments page
	public function payments_history() {
	
		$session = $this->session->userdata('client_username');
		if(empty($session)){
			redirect('client/');
		}
		$data['title'] = $this->lang->line('xin_acc_invoice_payments').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_invoice_payments');
		$data['path_url'] = 'xin_invoice_payment';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("client/invoices/invoice_payment_list", $data, TRUE);
			$this->load->view('client/layout/layout_main', $data); //page load
		} else {
			redirect('client/');
		}
	}
	
	// view invoice page
	public function view() {
	
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		if(is_null($invoice_info)){
			redirect('client/invoices');
		}
		// get project
		$project = $this->Project_model->read_project_information($invoice_info[0]->project_id);
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		if(!is_null($project)){
			$project_name = $project[0]->title;
			$project_id = $project[0]->project_id;
			$project_no = $project[0]->purchase_no;
		} else {
			$project_name = '--';	
			$project_no = '--';
			$project_id = '--';
		}
		
		$data = array(
			'title' => 'View Invoice #'.$invoice_info[0]->invoice_id,
			'breadcrumbs' => 'View Invoice',
			'path_url' => 'create_hrsale_invoice',
			'invoice_id' => $invoice_info[0]->invoice_id,
			'status' => $invoice_info[0]->status,
			'invoice_number' => $invoice_info[0]->invoice_number,
			'project_id' => $project_id,
			'project_no' => $project_no,
			'project_name' => $project_name,
			'invoice_date' => $invoice_info[0]->invoice_date,
			'invoice_due_date' => $invoice_info[0]->invoice_due_date,
			'sub_total_amount' => $invoice_info[0]->sub_total_amount,
			'discount_type' => $invoice_info[0]->discount_type,
			'discount_figure' => $invoice_info[0]->discount_figure,
			'total_tax' => $invoice_info[0]->total_tax,
			'total_discount' => $invoice_info[0]->total_discount,
			'grand_total' => $invoice_info[0]->grand_total,
			'invoice_note' => $invoice_info[0]->invoice_note,
			'company_name' => $company[0]->company_name,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_country' => $ccountry[0]->country_name,
			'name' => $invoice_info[0]->name,
			'client_company_name' => $invoice_info[0]->company_name,
			'client_profile' => $invoice_info[0]->client_profile,
			'email' => $invoice_info[0]->email,
			'contact_number' => $invoice_info[0]->contact_number,
			'website_url' => $invoice_info[0]->website_url,
			'address_1' => $invoice_info[0]->address_1,
			'address_2' => $invoice_info[0]->address_2,
			'city' => $invoice_info[0]->city,
			'state' => $invoice_info[0]->state,
			'zipcode' => $invoice_info[0]->zipcode,
			'countryid' => $invoice_info[0]->countryid,
			'all_projects' => $this->Project_model->get_projects(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("client/invoices/invoice_view", $data, TRUE);
			$this->load->view('client/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 
	 // preview invoice page
	public function preview() {
	
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		if(is_null($invoice_info)){
			redirect('client/invoices');
		}
		// get project
		$project = $this->Project_model->read_project_information($invoice_info[0]->project_id);
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		if(!is_null($project)){
			$project_name = $project[0]->title;
			$project_id = $project[0]->project_id;
			$project_no = $project[0]->purchase_no;
		} else {
			$project_name = '--';	
			$project_no = '--';
		}
		
		$data = array(
			'title' => 'View Invoice #'.$invoice_info[0]->invoice_id,
			'breadcrumbs' => 'View Invoice',
			'path_url' => 'log',
			'invoice_id' => $invoice_info[0]->invoice_id,
			'status' => $invoice_info[0]->status,
			'invoice_number' => $invoice_info[0]->invoice_number,
			'project_id' => $project_id,
			'project_no' => $project_no,
			'project_name' => $project_name,
			'invoice_date' => $invoice_info[0]->invoice_date,
			'invoice_due_date' => $invoice_info[0]->invoice_due_date,
			'sub_total_amount' => $invoice_info[0]->sub_total_amount,
			'discount_type' => $invoice_info[0]->discount_type,
			'discount_figure' => $invoice_info[0]->discount_figure,
			'total_tax' => $invoice_info[0]->total_tax,
			'total_discount' => $invoice_info[0]->total_discount,
			'grand_total' => $invoice_info[0]->grand_total,
			'invoice_note' => $invoice_info[0]->invoice_note,
			'company_name' => $company[0]->company_name,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_country' => $ccountry[0]->country_name,
			'name' => $invoice_info[0]->name,
			'client_company_name' => $invoice_info[0]->company_name,
			'client_profile' => $invoice_info[0]->client_profile,
			'email' => $invoice_info[0]->email,
			'contact_number' => $invoice_info[0]->contact_number,
			'website_url' => $invoice_info[0]->website_url,
			'address_1' => $invoice_info[0]->address_1,
			'address_2' => $invoice_info[0]->address_2,
			'city' => $invoice_info[0]->city,
			'state' => $invoice_info[0]->state,
			'zipcode' => $invoice_info[0]->zipcode,
			'countryid' => $invoice_info[0]->countryid,
			'all_projects' => $this->Project_model->get_projects(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("client/invoices/invoice_preview", $data, TRUE);
			$this->load->view('client/layout/pre_layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 
	// invoice payment list
	public function invoice_payment_list()
     {

		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("client/invoices/invoice_payment_list", $data);
		} else {
			redirect('client/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transaction = $this->Invoices_model->get_client_payment_invoices($session['client_id']);
		$data = array();
		$balance2 = 0;
          foreach($transaction->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			// credit
			$cr_dr = $r->dr_cr=="dr" ? "Debit" : "Credit";
			
			$invoice_info = $this->Invoices_model->read_invoice_info($r->invoice_id);
			if(!is_null($invoice_info)){
				$inv_no = $invoice_info[0]->invoice_number;
			} else {
				$inv_no = '--';	
			}
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}	
			$invoice_number = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$inv_no.'</a>';					
			$data[] = array(
				$invoice_number,
				$transaction_date,
				$total_amount,
				$method_name,
				$r->description
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
	 public function invoices_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("client/invoices/invoices_list", $data);
		} else {
			redirect('client/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$client = $this->Invoices_model->get_client_invoices($session['client_id']);
		
		$data = array();

          foreach($client->result() as $r) {
			  
			// get country
			$grand_total = $this->Xin_model->currency_sign($r->grand_total);
			// get project
			$project = $this->Project_model->read_project_information($r->project_id); 
			if(!is_null($project)){
				$project_name = $project[0]->title;
			} else {
				$project_name = '--';
			}
			if($r->status == 0){
				$istatus = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
			} else {
				$istatus = '<span class="label label-success">'.$this->lang->line('xin_payment_paid').'</span>';
			}
			 
		  $invoice_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_date);
		  $invoice_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_due_date);
		  //invoice_number
		  $invoice_number = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$r->invoice_number.'</a>';
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>',
				$invoice_number,
				$project_name,
				$grand_total,
				$invoice_date,
				$invoice_due_date,
				$istatus,
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $client->num_rows(),
                 "recordsFiltered" => $client->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
} 
?>