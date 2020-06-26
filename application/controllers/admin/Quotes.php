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

class Quotes extends MY_Controller
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
		  $this->load->model("Quotes_model");
		  $this->load->model("Clients_model");
		  $this->load->model("Department_model");
     }
	 
	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_title_quotes').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_title_quotes');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrsale_quotes';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('121',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/quotes_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// create invoice page
	public function create() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$company = $this->Xin_model->read_company_info($this->input->get("c"));
		if(is_null($company)){
			redirect('admin/quotes/');
		}
		$data['title'] = $this->lang->line('xin_create_quote').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_create_quote');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'create_hrsale_quote';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('120',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/create_quote", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
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
			$this->load->view("admin/quotes/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > employees
	 public function get_co_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quotes/get_co_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	// edit invoice page
	public function edit() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quote_info($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('328',$role_resources_ids)) { //edit
			redirect('admin/quotes');
		}
		// get project
		$project = $this->Project_model->read_project_information($quote_info[0]->project_id);
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		if(!is_null($project)){
			$project_name = $project[0]->title;
		} else {
			$project_name = '--';	
		}
		$data = array(
			'title' => 'Edit Estimate #'.$quote_info[0]->quote_number,
			'breadcrumbs' => 'Edit Estimate',
			'path_url' => 'create_hrsale_quote',
			'quote_id' => $quote_info[0]->quote_id,
			'project_id' => $project[0]->project_id,
			'status' => $quote_info[0]->status,
			'quote_number' => $quote_info[0]->quote_number,
			'eclient_id' => $quote_info[0]->client_id,
			'ecompany_id' => $quote_info[0]->company_id,
			'quote_date' => $quote_info[0]->quote_date,
			'quote_due_date' => $quote_info[0]->quote_due_date,
			'quote_type' => $quote_info[0]->quote_type,
			'sub_total_amount' => $quote_info[0]->sub_total_amount,
			'discount_type' => $quote_info[0]->discount_type,
			'discount_figure' => $quote_info[0]->discount_figure,
			'tax_type' => $quote_info[0]->tax_type,
			'tax_figure' => $quote_info[0]->tax_figure,
			'total_tax' => $quote_info[0]->total_tax,
			'total_discount' => $quote_info[0]->total_discount,
			'grand_total' => $quote_info[0]->grand_total,
			'quote_note' => $quote_info[0]->quote_note,
			'company_name' => $company[0]->company_name,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_country' => $ccountry[0]->country_name,
			'all_projects' => $this->Project_model->get_projects(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
			'all_employees' => $this->Xin_model->all_employees(),
			'all_companies' => $this->Xin_model->get_companies(),
			'all_clients' => $this->Clients_model->get_all_clients(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/edit_quote", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	
	// view invoice page
	public function view() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quote_info($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('330',$role_resources_ids)) { //view
			redirect('admin/quotes');
		}
		// get project
		$project = $this->Project_model->read_project_information($quote_info[0]->project_id);
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Company_model->read_company_information($quote_info[0]->company_id);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$clientinfo = $this->Clients_model->read_client_info($quote_info[0]->client_id);
		if(!is_null($clientinfo)){
			$cname = $clientinfo[0]->name;
			$client_company_name = $clientinfo[0]->company_name;
			$client_profile = $clientinfo[0]->client_profile;
			$email = $clientinfo[0]->email;
			$contact_number = $clientinfo[0]->contact_number;
			$website_url = $clientinfo[0]->website_url;
			$address_1 = $clientinfo[0]->address_1;
			$address_2 = $clientinfo[0]->address_2;
			$city = $clientinfo[0]->city;
			$state = $clientinfo[0]->state;
			$zipcode = $clientinfo[0]->zipcode;
			$countryid = $clientinfo[0]->country;
		} else {
			$cname = '';
			$client_company_name = '';
			$client_profile = '';
			$contact_number = '';
			$website_url = '';
			$address_1 = '';
			$address_2 = '';
			$city = '';
			$state = '';
			$zipcode = '';
			$countryid = 0;
		}
		if(!is_null($project)){
			$project_name = $project[0]->title;
			$project_no = $project[0]->purchase_no;
		} else {
			$project_name = '--';	
			$project_no = '--';
		}
		$data = array(
			'title' => 'View Estimate #'.$quote_info[0]->quote_number,
			'breadcrumbs' => 'View Estimate',
			'path_url' => 'view_hrsale_quote',
			'quote_id' => $quote_info[0]->quote_id,
			'status' => $quote_info[0]->status,
			'quote_number' => $quote_info[0]->quote_number,
			'project_id' => $project[0]->project_id,
			'ecompany_id' => $quote_info[0]->company_id,
			'project_no' => $project_no,
			'project_name' => $project_name,
			'quote_date' => $quote_info[0]->quote_date,
			'quote_due_date' => $quote_info[0]->quote_due_date,
			'sub_total_amount' => $quote_info[0]->sub_total_amount,
			'discount_type' => $quote_info[0]->discount_type,
			'discount_figure' => $quote_info[0]->discount_figure,
			'total_tax' => $quote_info[0]->total_tax,
			'total_discount' => $quote_info[0]->total_discount,
			'grand_total' => $quote_info[0]->grand_total,
			'quote_note' => $quote_info[0]->quote_note,
			'company_name' => $company[0]->name,
			'company_address' => $company[0]->address_1,
			'company_address2' => $company[0]->address_2,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_state' => $company[0]->state,
			'company_phone' => $company[0]->contact_number,
			'company_country' => $ccountry[0]->country_name,
			'government_tax' => $company[0]->government_tax,
			'name' => $cname,
			'client_company_name' => $client_company_name,
			'client_profile' => $client_profile,
			'email' => $email,
			'contact_number' => $contact_number,
			'website_url' => $website_url,
			'address_1' => $address_1,
			'address_2' => $address_2,
			'city' => $city,
			'state' => $state,
			'zipcode' => $zipcode,
			'countryid' => $countryid,
			'all_projects' => $this->Project_model->get_projects(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/quote_view", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 
	public function quotes_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quotes/quotes_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$quotes = $this->Quotes_model->get_quotes();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($quotes->result() as $r) {
			  
			  // get country
			   $company_info = $this->Company_model->read_company_information($r->company_id);
				if(!is_null($company_info)){
					$grand_total = $this->Xin_model->company_currency_sign($r->grand_total,$r->company_id);	
				} else {
					$grand_total = $this->Xin_model->currency_sign($r->grand_total);
				}
						
						
			   // get project
			  $project = $this->Project_model->read_project_information($r->project_id); 
			  if(!is_null($project)){
			  	$project_name = $project[0]->title;
			  } else {
				  $project_name = '--';	
			  }
			$quote_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->quote_date);
			$quote_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->quote_due_date);
			//invoice_number
			$quote_number = '';
			if(in_array('330',$role_resources_ids)) { //view
				$quote_number = '<a href="'.site_url().'admin/quotes/view/'.$r->quote_id.'/">'.$r->quote_number.'</a>';
			} else {
				$quote_number = $r->quote_number;
			}
			if(in_array('328',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/quotes/edit/'.$r->quote_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';
			} else {
				$edit = '';
			}
			if(in_array('329',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->quote_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('330',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/quotes/view/'.$r->quote_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			if($r->status == 0){
				$status = '<span class="label label-warning">'.$this->lang->line('xin_quoted_title').'</span>';
			} else {
				$status = '<span class="label label-success">'.$this->lang->line('xin_quote_invoiced').'</span>';
			}
			$quote_convert_record = $this->Quotes_model->read_quote_converted_info($r->quote_id);
			if ($quote_convert_record < 1) {
				$combhr = $edit.$view.$delete;
			} else {
				$combhr = $view.$delete;
			}
			
		   $data[] = array(
				$combhr,
				$quote_number,
				$project_name,
				$grand_total,
				$quote_date,
				$quote_due_date,
				$status,
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $quotes->num_rows(),
                 "recordsFiltered" => $quotes->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 public function quote_po_read()
	{
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('quote_id');
		$quote_info = $this->Quotes_model->read_quote_info($id);
		$data = array(
			'quote_id' => $quote_info[0]->quote_id,
			'quote_number' => $quote_info[0]->quote_number,
			);
		$this->load->view('admin/quotes/dialog_po_quote', $data);
	}
	public function convert_to_project() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('project_po')==='') {
       		$Return['error'] = "The Project P.O field is required.";
		} else if($this->Quotes_model->quote_po_check($this->input->post('project_po')) > 0) {
			$Return['error'] = "The Project P.O should be unique.";
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quote_info($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes/view/'.$quote_id);
		}
		
		// get customer
		//$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		//$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$data = array(
		'title' => $quote_info[0]->xin_title,
		'quote_po' => $this->input->post('project_po'),
		'client_id' => $quote_info[0]->client_id,
		'company_id' => $quote_info[0]->company_id,
		'quote_id' => $quote_info[0]->quote_id,
		'start_date' => date('Y-m-d'),
		'end_date' => $quote_info[0]->quote_due_date,
		'summary' => $quote_info[0]->quote_note,
		'project_manager' => $quote_info[0]->project_manager,
		'project_coordinator' => $quote_info[0]->project_coordinator,
		'priority' => 4,
		'assigned_to' => 0,
		'description' => $quote_info[0]->quote_note,
		'project_progress' => '0',
		'status' => '0',
		'added_by' => 1,
		'created_at' => date('d-m-Y'),
		);
		$result = $this->Project_model->add($data);
		if ($result == TRUE) {
			$data2 = array(
			'status' => '1',
			'quote_po' => $this->input->post('project_po'),
			);
			$this->Quotes_model->update_quote_record($data2,$quote_id);
		}
		
		$this->session->set_flashdata('response',"Converted to project successfully.");
		$Return['result'] = 'Project P.O added.';
		$this->output($Return);
		exit;
		//redirect('admin/quotes/view/'.$quote_id);
	 }
	// Validate and add info in database
	public function create_new_quote() {
	
		if($this->input->post('add_type')=='quote_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */	
		
		if($this->input->post('quote_number')==='') {
       		$Return['error'] = "The quote number field is required.";
		} else if($this->Quotes_model->quote_no_check($this->input->post('quote_number')) > 0) {
			$Return['error'] = "The Quote number should be unique.";
		} else if($this->input->post('company_id')==='') {
       		$Return['error'] = "The company field is required.";
		} else if($this->input->post('client_id')==='') {
       		$Return['error'] = "The client field is required.";
		} else if($this->input->post('project')==='') {
       		$Return['error'] = "The project title field is required.";
		} else if($this->input->post('quote_date')==='') {
       		$Return['error'] = "The quote date field is required.";
		} else if($this->input->post('quote_due_date')==='') {
			$Return['error'] = "The project start date field is required.";
		} else if($this->input->post('unit_price')==='') {
			$Return['error'] = "The unit price field is required.";
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$j=0; foreach($this->input->post('item_name') as $items){
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$j];
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$j];
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$j];
				
				if($iname==='') {
					$Return['error'] = "The Item field is required.";
				} else if($qty==='') {
					$Return['error'] = "The Qty/hrs field is required.";
				} else if($price==='' || $price===0) {
					$Return['error'] = $j. " The Price field is required.";
				}
				$j++;
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$proj_info = $this->Project_model->read_project_information($this->input->post('project'));			
		$client_id = $this->input->post('client_id');
		$company_id = $this->input->post('company_id');
		$clientinfo = $this->Clients_model->read_client_info($client_id);
		$data = array(
		'quote_number' => $this->input->post('quote_number'),
		'company_id' => $company_id,
		'project_id' => $this->input->post('project'),
		'quote_date' => $this->input->post('quote_date'),
		'quote_due_date' => $this->input->post('quote_due_date'),
		'client_id' => $client_id,
		'sub_total_amount' => $this->input->post('items_sub_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'total_tax' => $this->input->post('items_tax_total'),
		'grand_total' => $this->input->post('fgrand_total'),
		'quote_note' => $this->input->post('quote_note'),
		'name' => $clientinfo[0]->name,
		'company_name' => $clientinfo[0]->company_name,
		'client_profile' => $clientinfo[0]->client_profile,
		'email' => $clientinfo[0]->email,
		'contact_number' => $clientinfo[0]->contact_number,
		'website_url' => $clientinfo[0]->website_url,
		'address_1' => $clientinfo[0]->address_1,
		'address_2' => $clientinfo[0]->address_2,
		'city' => $clientinfo[0]->city,
		'state' => $clientinfo[0]->state,
		'zipcode' => $clientinfo[0]->zipcode,
		'countryid' => $clientinfo[0]->country,
		'status' => '0',
		'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Quotes_model->add_quote_record($data);
		if ($result) {
			$key=0;
			foreach($this->input->post('item_name') as $items){

				/* get items info */
				// item name
				//$iname = $items['item_name']; 
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$key]; 
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$key]; 
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$key]; 
				// item tax_id
				$taxt = $this->input->post('tax_type');
				$tax_type = $taxt[$key]; 
				// item tax_rate
				$tax_rate_item = $this->input->post('tax_rate_item');
				$tax_rate = $tax_rate_item[$key];
				// item sub_total
				$sub_total_item = $this->input->post('sub_total_item');
				$item_sub_total = $sub_total_item[$key];
				// add values  
				$data2 = array(
				'quote_id' => $result,
				'project_id' => $this->input->post('project'),
				'item_name' => $iname,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Quotes_model->add_quote_items_record($data2);
				
			$key++; }
			$Return['result'] = 'Quote created.';
		} else {
			$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$this->output($Return);
		exit;
		}
	}
	
	 public function convert_to_invoice() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quote_info($id);
		if(is_null($quote_info)){
			redirect('admin/quotes/');
		}
		// get customer
		//$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		//$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$data = array(
		'invoice_number' => $quote_info[0]->quote_number,
		'client_id' => $quote_info[0]->client_id,
		'project_id' => $quote_info[0]->project_id,
		'invoice_date' => $quote_info[0]->quote_date,
		'invoice_due_date' => $quote_info[0]->quote_due_date,
		'company_id' => $quote_info[0]->company_id,
		'sub_total_amount' => $quote_info[0]->sub_total_amount,
		'discount_type' => $quote_info[0]->discount_type,
		'discount_figure' => $quote_info[0]->discount_figure,
		'total_tax' => $quote_info[0]->total_tax,
		//'tax_type' => $quote_info[0]->tax_type,
		'tax_figure' => $quote_info[0]->tax_figure,
		'total_discount' => $quote_info[0]->total_discount,
		'invoice_type' => $quote_info[0]->quote_type,
		'grand_total' => $quote_info[0]->grand_total,
		'invoice_note' => $quote_info[0]->quote_note,
		'name' => $quote_info[0]->name,
		'company_name' => $quote_info[0]->company_name,
		'client_profile' => $quote_info[0]->client_profile,
		'email' => $quote_info[0]->email,
		'contact_number' => $quote_info[0]->contact_number,
		'website_url' => $quote_info[0]->website_url,
		'address_1' => $quote_info[0]->address_1,
		'address_2' => $quote_info[0]->address_2,
		'city' => $quote_info[0]->city,
		'state' => $quote_info[0]->state,
		'zipcode' => $quote_info[0]->zipcode,
		'countryid' => $quote_info[0]->countryid,
		'status' => '0',
		'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Invoices_model->add_invoice_record($data);
		if ($result == TRUE) {
			foreach($this->Quotes_model->get_quote_items($quote_info[0]->quote_id) as $_item):
				$data2 = array(
				'invoice_id' => $result,
				'project_id' => $quote_info[0]->project_id,
				'item_name' => $_item->item_name,
				'item_qty' => $_item->item_qty,
				'item_unit_price' => $_item->item_unit_price,
				'item_sub_total' => $_item->item_sub_total,
				'sub_total_amount' => $_item->sub_total_amount,
				'item_tax_type' => $_item->item_tax_type,
				'item_tax_rate' => $_item->item_tax_rate,
				'total_tax' => $_item->total_tax,
				'discount_type' => $_item->discount_type,
				'discount_figure' => $_item->discount_figure,
				'total_discount' => $_item->total_discount,
				'grand_total' => $_item->grand_total,
				'created_at' => date('d-m-Y H:i:s')
				);
				
				$result_item = $this->Invoices_model->add_invoice_items_record($data2);
			endforeach;
			$data3 = array(
			'status' => 1,
		);
		$eresult = $this->Quotes_model->update_quote_record($data3,$quote_info[0]->quote_id);
		}
		
		$this->session->set_flashdata('response',"Converted to invoice successfully.");
		redirect('admin/quotes/view/'.$quote_info[0]->quote_id);
	 }
	
	// Validate and add info in database
	public function update_quote() {
	
		if($this->input->post('add_type')=='quote_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->uri->segment(4);
	
		// add purchase items
		foreach($this->input->post('item') as $eitem_id=>$key_val){
			
			/* get items info */
			// item qty
			$item_name = $this->input->post('eitem_name');
			$iname = $item_name[$key_val]; 
			// item qty
			$qty = $this->input->post('eqty_hrs');
			$qtyhrs = $qty[$key_val]; 
			// item price
			$unit_price = $this->input->post('eunit_price');
			$price = $unit_price[$key_val]; 
			// item tax_id
			$taxt = $this->input->post('etax_type');
			$tax_type = $taxt[$key_val]; 
			//item tax_rate
			$tax_rate_item = $this->input->post('etax_rate_item');
			$tax_rate = $tax_rate_item[$key_val];
			// item sub_total
			$sub_total_item = $this->input->post('esub_total_item');
			$item_sub_total = $sub_total_item[$key_val];
			
			// update item values  
			$data = array(
				'item_name' => $iname,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
			);
			$result_item = $this->Quotes_model->update_quote_items_record($data,$eitem_id);
			
		}
		
		////
		$proj_info = $this->Project_model->read_project_information($this->input->post('project'));	
		$data = array(
		'quote_number' => $this->input->post('quote_number'),
		'project_id' => $this->input->post('project'),
		'quote_date' => $this->input->post('quote_date'),
		'quote_due_date' => $this->input->post('quote_due_date'),
		'client_id' => $this->input->post('client_id'),
		'company_id' => $this->input->post('company_id'),
		'sub_total_amount' => $this->input->post('items_sub_total'),
		//'tax_type' => $this->input->post('tax_type'),
		//'tax_figure' => $this->input->post('tax_figure'),
		'total_tax' => $this->input->post('items_tax_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'grand_total' => $this->input->post('fgrand_total'),
		'quote_note' => $this->input->post('quote_note'),
		);
		$result = $this->Quotes_model->update_quote_record($data,$id);
	

		if($this->input->post('item_name')) {
			$key=0;
			foreach($this->input->post('item_name') as $items){

				/* get items info */
				// item name
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$key]; 
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$key]; 
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$key]; 
				// item tax_id
				$taxt = $this->input->post('tax_type');
				$tax_type = $taxt[$key]; 
				// item tax_rate
				$tax_rate_item = $this->input->post('tax_rate_item');
				$tax_rate = $tax_rate_item[$key];
				// item sub_total
				$sub_total_item = $this->input->post('sub_total_item');
				$item_sub_total = $sub_total_item[$key];
				// add values  
				$data2 = array(
				'quote_id' => $id,
				'project_id' => $this->input->post('project'),
				'item_name' => $iname,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Quotes_model->add_quote_items_record($data2);
				
			$key++; }
			$Return['result'] = 'Quote updated.';
		} else {
			//$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$Return['result'] = 'Quote updated.';
		$this->output($Return);
		exit;
		}
	}
	
	// delete a purchase record
	public function delete_item() {
		
		if($this->uri->segment(5) == 'isajax') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			
			$result = $this->Quotes_model->delete_quotes_items_record($id);
			if(isset($id)) {
				$Return['result'] = 'Quote Item deleted.';
			} else {
				$Return['error'] = 'Bug. Something went wrong, please try again.';
			}
			$this->output($Return);
		}
	}
	
	// delete a purchase record
	public function delete() {
		
		if($this->input->post('is_ajax') == '2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Quotes_model->delete_record($id);
			if(isset($id)) {
				$this->Quotes_model->delete_quote_items($id);
				$Return['result'] = 'Quote deleted.';
			} else {
				$Return['error'] = 'Bug. Something went wrong, please try again.';
			}
			$this->output($Return);
			exit;
		}
	}
	// get clients > Projects
	 public function get_client_projects() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'client_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quotes/get_client_projects", $data);
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