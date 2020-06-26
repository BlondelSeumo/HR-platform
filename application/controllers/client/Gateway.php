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

class Gateway extends MY_Controller {

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
		$this->load->model('Invoices_model');
		$this->load->model('Xin_model');
		$this->load->model('Finance_model');
		/*cash control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    }
	public function pay(){
	  
	  $data['title'] = $this->Xin_model->site_title();
	  $session = $this->session->userdata('username');
		
	  $invoice_id = $this->input->post("invoice_id");
	  $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
	  $Return['csrf_hash'] = $this->security->get_csrf_hash();
	 // $token = $this->input->post("token");  
	 // $data['gateway'] = $this->input->post("gateway");
	  
	  $invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
	  $data = array(
		'invoice_id' => $invoice_info[0]->invoice_id,
		'invoice_number' => $invoice_info[0]->invoice_number,
		'invoice_date' => $invoice_info[0]->invoice_date,
		'invoice_due_date' => $invoice_info[0]->invoice_due_date,
		'sub_total_amount' => $invoice_info[0]->sub_total_amount,
		'discount_type' => $invoice_info[0]->discount_type,
		'discount_figure' => $invoice_info[0]->discount_figure,
		'total_tax' => $invoice_info[0]->total_tax,
		'total_discount' => $invoice_info[0]->total_discount,
		'grand_total' => $invoice_info[0]->grand_total,
		'invoice_note' => $invoice_info[0]->invoice_note,
		'gateway' => $this->input->post("gateway")
		);
	  //if(varify_invoice($invoice_id,$token)){
	  //  $data['invoice']=$this->Invoice_model->get_by($invoice_id);
		//$this->load->view("admin/gateway/".$data['gateway'],$data);
		$this->load->view("client/gateway/".$data['gateway'],$data);
	}
	


    //Paypal Process
	public function paypal_process($param1 = '',$param2='')
    {
        $ipaypal = $this->uri->segment(4);
		$ipaypal_invid = $this->uri->segment(5);
		
		if ($param1 == '') {
         
            /****TRANSFERRING USER TO PAYPAL****/
			$invoice_id=$this->input->post('invoice_id');
			$token=$this->input->post('token');
			$invoice = read_invoice_record($invoice_id);
			$system_settings = system_settings_info(1);
            $this->paypal->add_field('rm', 1);
            $this->paypal->add_field('no_note', 0);
            $this->paypal->add_field('item_name', "Invoice: #".$invoice->invoice_number);
            $this->paypal->add_field('amount',$invoice->grand_total);
			$this->paypal->add_field('custom',$invoice->invoice_id);
            $this->paypal->add_field('business', $system_settings->paypal_email);
            $this->paypal->add_field('notify_url', site_url() . 'client/gateway/paypal_process/paypal_ipn');
            $this->paypal->add_field('cancel_return', site_url() . 'client/gateway/paypal_process/paypal_cancel/'.$invoice->invoice_id);
            $this->paypal->add_field('return', site_url() . 'client/gateway/paypal_process/paypal_success/'.$invoice->invoice_id);
            
            $this->paypal->submit_paypal_post();
            // submit the fields to paypal
        }
        if ($param1 == 'paypal_ipn') {
            if ($this->paypal->validate_ipn() == true) {			       
           }
        }
        if ($param1 == 'paypal_cancel') {
            $this->session->set_flashdata('error', 'Sorry Could not complete the process, Please try again');
			redirect('client/invoices/view/'.$param2, 'refresh');
        }
		//redirect('admin/invoices/view/'.$param2, 'refresh');
        if ($param1 == 'paypal_success') {
            $this->session->set_flashdata('success', 'Thank you payment has done sucessfully.');
			$invoice = $this->Invoices_model->read_invoice_info($param2);
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
				
       		$amount = $invoice[0]->grand_total;
			$ivdata = array(
			'amount' => $amount,
			'account_id' => $online_payment_account,
			'transaction_type' => 'income',
			'dr_cr' => 'cr',
			'transaction_date' => date('Y-m-d'),
			'payer_payee_id' => $invoice[0]->client_id,
			'payment_method_id' => 1,
			'description' => 'Invoice Payments',
			'reference' => 'Invoice Payments',
			'invoice_id' => $param2,
			'client_id' => $invoice[0]->client_id,
			'created_at' => date('Y-m-d H:i:s')
			);
			$iresult = $this->Finance_model->add_transactions($ivdata);
			if ($iresult == TRUE) {			
				$data = array(
					'status' => 1,
				);
				$result = $this->Invoices_model->update_invoice_record($data,$param2);
			}
			redirect('client/invoices/view/'.$param2, 'refresh');

        }
    }

    //Stripe Process
	public function stripe_charge($id){

       if($this->input->post('stripeToken')) {
            $invoice_id=$this->input->post('invoice_id');
			$token=$this->input->post('token');
			
			/*if(!varify_invoice($invoice_id,$token)){
			  show_404();
			}  */  
			$system_settings = system_settings_info(1);
			$invoice = $this->Invoices_model->read_invoice_info($invoice_id);
			$stripe_api_key = $system_settings->stripe_secret_key;
			require_once(APPPATH . 'libraries/stripe-php/init.php');
			\Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
			//get customer email
			$customer_email = $invoice[0]->email;
			
			$vendora = \Stripe\Customer::create(array(
				'email' => $customer_email,
				'card'  => $_POST['stripeToken']
			));
			
			$charge = \Stripe\Charge::create(array(
				'customer'  => $vendora->id,
				'amount'    => ($invoice[0]->grand_total-0)*100,
				'currency'  => 'USD'
			));

			if($charge->paid == true){
				$vendora = (array) $vendora;
				$charge = (array) $charge;
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}	
       		$amount = $invoice[0]->grand_total;
			$ivdata = array(
			'amount' => $amount,
			'account_id' => $online_payment_account,
			'transaction_type' => 'income',
			'dr_cr' => 'cr',
			'transaction_date' => date('Y-m-d'),
			'payer_payee_id' => $invoice[0]->client_id,
			'payment_method_id' => 2,
			'description' => 'Invoice Payments',
			'reference' => 'Invoice Payments',
			'invoice_id' => $invoice_id,
			'client_id' => $invoice[0]->client_id,
			'created_at' => date('Y-m-d H:i:s')
			);
			$iresult = $this->Finance_model->add_transactions($ivdata);
			if ($iresult == TRUE) {			
				$data = array(
					'status' => 1,
				);
				$result = $this->Invoices_model->update_invoice_record($data,$invoice_id);
			}		
			$this->session->set_flashdata('success', 'Thank you payment has done sucessfully.');
			redirect('client/invoices/view/'.$id.'/', 'refresh');
			
			} else {
				$this->session->set_flashdata('error', 'Sorry Could not complete the process, Please try again');
			    redirect('client/invoices/view/'.$id.'/', 'refresh');
			}

		} else{
		   $this->session->set_flashdata('error', 'Something went wrong please try again.');
		   redirect('client/invoices/view/'.$id.'/', 'refresh');
		}
	
	}
}