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

class User extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		$this->load->model("Awards_model");
		$this->load->model("Xin_model");
		$this->load->model("Exin_model");
		$this->load->model("Transfers_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
		$this->load->model("Promotion_model");
		$this->load->model("Complaints_model");
		$this->load->model("Warning_model");
		$this->load->model("Training_model");
		$this->load->model("Trainers_model");
		$this->load->model("Designation_model");
		$this->load->model("Performance_appraisal_model");
		$this->load->model('Files_model');
		$this->load->model("Timesheet_model");
		$this->load->model("Employees_model");
		$this->load->model("Roles_model");
		$this->load->model("Tickets_model");
		$this->load->model("Project_model");
		$this->load->model("Job_post_model");
		$this->load->model("Announcement_model");
		$this->load->model("Company_model");
		$this->load->model("Expense_model");
		$this->load->model("Travel_model");
		$this->load->model("Payroll_model");
		$this->load->model("Assets_model");
		$this->load->model("Clients_model");
		$this->load->library('email');
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}	
	/* Awards *////////////////////////////////////////////
	public function awards()
     {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_awards').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_award_types'] = $this->Awards_model->all_award_types();
		$data['breadcrumbs'] = $this->lang->line('left_awards');
		$data['path_url'] = 'user/user_awards';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/awards", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	 
	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('award_id');
		$result = $this->Awards_model->read_award_information($id);
		$data = array(
				'award_id' => $result[0]->award_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'award_type_id' => $result[0]->award_type_id,
				'gift_item' => $result[0]->gift_item,
				'award_photo' => $result[0]->award_photo,
				'cash_price' => $result[0]->cash_price,
				'award_month_year' => $result[0]->award_month_year,
				'award_information' => $result[0]->award_information,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_award_types' => $this->Awards_model->all_award_types(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('employee/user/dialog_award', $data);
		} else {
			redirect('admin/');
		}
	}
 
    public function award_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/awards", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$award = $this->Awards_model->get_employee_awards($session['user_id']);
		
		$data = array();

        foreach($award->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Exin_model->read_user_info($r->employee_id);		
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			$emp_id = $user[0]->employee_id;
		} else {
			$full_name = '--';	
			$emp_id = '--';
		}
		// get award type
		$award_type = $this->Awards_model->read_award_type_information($r->award_type_id);
		if(!is_null($award_type)){
			$award_type = $award_type[0]->award_type;
		} else {
			$award_type = '--';	
		}
		
		$d = explode('-',$r->award_month_year);
		$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
		$award_date = $get_month.', '.$d[0];
		// get currency
		$currency = $this->Xin_model->currency_sign($r->cash_price);
				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-award_id="'. $r->award_id . '"><span class="fa fa-eye"></span></button></span>',
			$emp_id,
			$full_name,
			$award_type,
			$r->gift_item,
			$currency,
			$award_date
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $award->num_rows(),
			 "recordsFiltered" => $award->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }	 
	/* Transfers *////////////////////////////////////////
	 public function transfer()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_transfers').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_locations'] = $this->Xin_model->all_locations();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['breadcrumbs'] = $this->lang->line('xin_transfers');
		$data['path_url'] = 'user/user_transfer';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/transfer_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	 
	 /* assets *////////////////////////////////////////
	 public function assets() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_assets!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_assets').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_assets');
		$data['path_url'] = 'user/user_assets';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_assets_categories'] = $this->Assets_model->get_all_assets_categories();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/assets/assets_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}
	
	// assets list
	public function assets_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/languages_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$assets = $this->Assets_model->get_employee_assets($session['user_id']);
		
		$data = array();
		
          foreach($assets->result() as $r) {						
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
			 	$comp_name = '--';	
			}
			// get category
			$assets_category = $this->Assets_model->read_assets_category_info($r->assets_category_id);
			if(!is_null($assets_category)){
				$category = $assets_category[0]->category_name;
			} else {
			 	$category = '--';	
			}
			//working?
			if($r->is_working==1){
				$working = $this->lang->line('xin_yes');
			} else {
				$working = $this->lang->line('xin_no');
			}
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-asset_id="'. $r->assets_id . '"><span class="fa fa-eye"></span></button></span>',
			$r->name,
			$category,
			$r->company_asset_code,
			$working,
			$comp_name
		);
		}
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $assets->num_rows(),
                 "recordsFiltered" => $assets->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
 
    public function transfer_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/transfer_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transfer = $this->Transfers_model->get_employee_transfers($session['user_id']);
		
		$data = array();

          foreach($transfer->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Exin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		
		// get user > employee_
		$employee = $this->Exin_model->read_user_info($r->employee_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
		} else {
			$employee_name = '--';	
		}
		// get date
		$transfer_date = $this->Xin_model->set_date_format($r->transfer_date);
		// get department by id
		$department = $this->Department_model->read_department_information($r->transfer_department);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		// get location by id
		$location = $this->Location_model->read_location_information($r->transfer_location);
		if(!is_null($location)){
			$location_name = $location[0]->location_name;
		} else {
			$location_name = '--';	
		}
		// get status
		if($r->status==0): $status = $this->lang->line('xin_pending');
		elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-transfer_id="'. $r->transfer_id . '"><span class="fa fa-eye"></span></button></span>',
			$employee_name,
			$transfer_date,
			$department_name,
			$location_name,
			$status,
			$full_name
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
	 
	 public function transfer_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('transfer_id');
		$result = $this->Transfers_model->read_transfer_information($id);
		$data = array(
				'transfer_id' => $result[0]->transfer_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'transfer_date' => $result[0]->transfer_date,
				'transfer_department' => $result[0]->transfer_department,
				'transfer_location' => $result[0]->transfer_location,
				'description' => $result[0]->description,
				'status' => $result[0]->status,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_locations' => $this->Xin_model->all_locations(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_departments' => $this->Department_model->all_departments()
				);
		if(!empty($session)){ 
			$this->load->view('admin/transfers/dialog_transfer', $data);
		} else {
			redirect('admin/');
		}
	}	
	/* Promotion */////////////////////////////////////////
	public function promotion()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_promotions').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('left_promotions');
		$data['path_url'] = 'user/user_promotion';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/promotion_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	 
	 public function promotion_read() {
		 
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('promotion_id');
		$result = $this->Promotion_model->read_promotion_information($id);
		$data = array(
				'promotion_id' => $result[0]->promotion_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
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
	
    public function promotion_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/promotion_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$promotion = $this->Promotion_model->get_employee_promotions($session['user_id']);
		
		$data = array();

        foreach($promotion->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Exin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		
		// get user > employee_
		$employee = $this->Exin_model->read_user_info($r->employee_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
		} else {
			$employee_name = '--';	
		}
		// get promotion date
		$promotion_date = $this->Xin_model->set_date_format($r->promotion_date);
		// description
		$description =  html_entity_decode($r->description);
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-promotion_id="'. $r->promotion_id . '"><span class="fa fa-eye"></span></button></span>',
			$employee_name,
			$r->title,
			$promotion_date,
			$full_name
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
	/* Complaints *////////////////////////////////////////
	public function complaints()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_complaints').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('left_complaints');
		$data['path_url'] = 'user/user_complaints';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/complaint_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	 
	public function complaints_read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('complaint_id');
		$result = $this->Complaints_model->read_complaint_information($id);
		$data = array(
				'complaint_id' => $result[0]->complaint_id,
				'company_id' => $result[0]->company_id,
				'complaint_from' => $result[0]->complaint_from,
				'title' => $result[0]->title,
				'complaint_date' => $result[0]->complaint_date,
				'complaint_against' => $result[0]->complaint_against,
				'description' => $result[0]->description,
				'status' => $result[0]->status,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
			$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/complaints/dialog_complaint', $data);
		} else {
			redirect('admin/');
		}
	}
	
    public function complaint_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/complaint_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$complaint = $this->Complaints_model->get_complaints();
		
		$data = array();

        foreach($complaint->result() as $r) {
			
		 $aim = explode(',',$r->complaint_against);
		 foreach($aim as $dIds) {
		 if($session['user_id'] == $dIds) {	
			 			  
		// get user > added by
		$user = $this->Exin_model->read_user_info($r->complaint_from);
		// user full name
		if(!is_null($user)){
			$complaint_from = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$complaint_from = '--';	
		}
		// get complaint date
		$complaint_date = $this->Xin_model->set_date_format($r->complaint_date);
		
		if($r->complaint_against == '') {
			$ol = '--';
		} else {
			$ol = '<ol class="nl">';
			foreach(explode(',',$r->complaint_against) as $desig_id) {
				$_comp_name = $this->Exin_model->read_user_info($desig_id);
				if(!is_null($_comp_name)){
					$ol .= '<li>'.$_comp_name[0]->first_name.' '.$_comp_name[0]->last_name.'</li>';
				} else {
					$ol .= '';
				}
			 }
			 $ol .= '</ol>';
		}
		
		// get status
		if($r->status==0): $status = $this->lang->line('xin_pending');
		elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
		
		// description
		$description =  html_entity_decode($r->description);
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-complaint_id="'. $r->complaint_id . '"><span class="fa fa-eye"></span></button></span>',
			$complaint_from,
			$ol,
			$r->title,
			$complaint_date,
			$status,
			$description
		);
      }
		 } } // e-complaints
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $complaint->num_rows(),
			 "recordsFiltered" => $complaint->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	/* Warning *///////////////////////////////////////////
	public function warning()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_warnings').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_warning_types'] = $this->Warning_model->all_warning_types();
		$data['breadcrumbs'] = $this->lang->line('left_warnings');
		$data['path_url'] = 'user/user_warning';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/warning_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function warning_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/warning_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$warning = $this->Warning_model->get_employee_warning($session['user_id']);
		
		$data = array();

        foreach($warning->result() as $r) {

		// get user > warning by
		$user_by = $this->Exin_model->read_user_info($r->warning_by);
		// user full name
		if(!is_null($user_by)){
			$warning_by = $user_by[0]->first_name.' '.$user_by[0]->last_name;
		} else {
			$warning_by = '--';	
		}
		// get warning date
		$warning_date = $this->Xin_model->set_date_format($r->warning_date);
				
		// get status
		if($r->status==0): $status = $this->lang->line('xin_pending');
		elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
		// get warning type
		$warning_type = $this->Warning_model->read_warning_type_information($r->warning_type_id);
		if(!is_null($warning_type)){
			$wtype = $warning_type[0]->type;
		} else {
			$wtype = '--';	
		}
		// description
		$description =  html_entity_decode($r->description);
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-warning_id="'. $r->warning_id . '"><span class="fa fa-eye"></span></button></span>',
			$warning_date,
			$r->subject,
			$wtype,
			$status,
			$warning_by,
			$description
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $warning->num_rows(),
			 "recordsFiltered" => $warning->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function warning_read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('warning_id');
		$result = $this->Warning_model->read_warning_information($id);
		$data = array(
				'warning_id' => $result[0]->warning_id,
				'company_id' => $result[0]->company_id,
				'warning_to' => $result[0]->warning_to,
				'warning_by' => $result[0]->warning_by,
				'warning_date' => $result[0]->warning_date,
				'warning_type_id' => $result[0]->warning_type_id,
				'subject' => $result[0]->subject,
				'description' => $result[0]->description,
				'status' => $result[0]->status,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_warning_types' => $this->Warning_model->all_warning_types(),
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/warning/dialog_warning', $data);
		} else {
			redirect('admin/');
		}
	}
	/* Training *//////////////////////////////////////////
	public function training()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_training').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_trainers'] = $this->Trainers_model->all_trainers();
		$data['all_training_types'] = $this->Training_model->all_training_types();
		$data['breadcrumbs'] = $this->lang->line('left_training');
		$data['path_url'] = 'user/user_training';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/training_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function training_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/training_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$training = $this->Training_model->get_training();
		
		$data = array();

        foreach($training->result() as $r) {
			
		 $aim = explode(',',$r->employee_id);
		 foreach($aim as $dIds) {
		 if($session['user_id'] == $dIds) {
		
		// get training type
		$type = $this->Training_model->read_training_type_information($r->training_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		// get trainer
		$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';	
		}
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$finish_date = $this->Xin_model->set_date_format($r->finish_date);
		// training date
		$training_date = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
		// set currency
		$training_cost = $this->Xin_model->currency_sign($r->training_cost);
		/* get Employee info*/
		if($r->employee_id == '') {
			$ol = '--';
		} else {
			$ol = '<ol class="nl">';
			foreach(explode(',',$r->employee_id) as $uid) {
				$user = $this->Exin_model->read_user_info($uid);
				$ol .= '<li>'.$user[0]->first_name.' '.$user[0]->last_name.'</li>';
			 }
			 $ol .= '</ol>';
		}
		// status
		if($r->training_status==0): $status = $this->lang->line('xin_pending');
		elseif($r->training_status==1): $status = $this->lang->line('xin_started'); elseif($r->training_status==2): $status = $this->lang->line('xin_completed');
		else: $status = $this->lang->line('xin_terminated'); endif;
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/user/training_details/'.$r->training_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
			$ol,
			$itype,
			$trainer_name,
			$training_date,
			$training_cost,
			$status
		);
      }
		 } } // e- training
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $training->num_rows(),
			 "recordsFiltered" => $training->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // training details
	public function training_details()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title().' | '.$this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Training_model->read_training_information($id);
		if(is_null($result)){
			redirect('admin/user/training');
		}
		// get training type
		$type = $this->Training_model->read_training_type_information($result[0]->training_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		// get trainer
		$trainer = $this->Trainers_model->read_trainer_information($result[0]->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';	
		}
		$data = array(
				'title' => $this->lang->line('xin_training_details').' | '.$this->Xin_model->site_title(),
				'training_id' => $result[0]->training_id,
				'company_id' => $result[0]->company_id,
				'type' => $itype,
				'trainer_name' => $trainer_name,
				'training_cost' => $result[0]->training_cost,
				'start_date' => $result[0]->start_date,
				'finish_date' => $result[0]->finish_date,
				'created_at' => $result[0]->created_at,
				'description' => $result[0]->description,
				'performance' => $result[0]->performance,
				'training_status' => $result[0]->training_status,
				'remarks' => $result[0]->remarks,
				'employee_id' => $result[0]->employee_id,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$data['breadcrumbs'] = $this->lang->line('xin_training_details');
		$data['path_url'] = 'user/user_training_details';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/training_details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}		  
     }
	/* Office Shift *//////////////////////////////////////
	public function office_shift()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_office_shift').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('left_office_shift');
		$data['path_url'] = 'user/user_office_shift';
		if(!empty($session)){
			$data['subview'] = $this->load->view("employee/user/office_shift", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function office_shift_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/office_shift", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$user = $this->Xin_model->get_employee_row($session['user_id']);
		
		$data = array();

      //  foreach($user->result() as $r) {
			 			  
		// get from date
		//$from_date = $this->Xin_model->set_date_format($r->from_date);
		// get to date
		//$to_date = $this->Xin_model->set_date_format($r->to_date);
		//shift date
		//$shift_date = $from_date .' ' . $this->lang->line('dashboard_to').' '.$to_date;
		// status info
		$shift = $this->Xin_model->get_employee_shift_office($user[0]->office_shift_id);
		if(!is_null($shift)){
			$shift_name = $shift[0]->shift_name;
		} else {
			$shift_name = '--';	
		}
		
		$data[] = array(
			$shift_name
		);
    //  }

	  $output = array(
		   "draw" => $draw,
			// "recordsTotal" => $user->num_rows(),
			// "recordsFiltered" => $user->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	/* Performance *///////////////////////////////////////
	public function performance()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_performance').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('left_performance');
		$data['path_url'] = 'user/user_performance';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/performance_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function appraisal_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/performance_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$appraisal = $this->Performance_appraisal_model->get_employee_performance_appraisal($session['user_id']);
		
		$data = array();

        foreach($appraisal->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Exin_model->read_user_info($r->employee_id);
		// user full name
		if(!is_null($user)){
				
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			// department
			$department = $this->Department_model->read_department_information($user[0]->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';
			}
			// get designation
			$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}
		} else {
			$full_name = '--';
			$designation_name = '--';
			$department_name = '--';
		}
		
		$d = explode('-',$r->appraisal_year_month);
		$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
		$ap_date = $get_month.', '.$d[0];
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light view-data" data-toggle="modal" data-target="#edit-modal-data" data-p_appraisal_id="'. $r->performance_appraisal_id . '"><span class="fa fa-eye"></span></button></span>',
			$full_name,
			$designation_name,
			$department_name,
			$ap_date
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $appraisal->num_rows(),
			 "recordsFiltered" => $appraisal->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function performance_read() {
		 
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('performance_appraisal_id');
		$result = $this->Performance_appraisal_model->read_appraisal_information($id);
		$data = array(
				'performance_appraisal_id' => $result[0]->performance_appraisal_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'appraisal_year_month' => $result[0]->appraisal_year_month,
				'customer_experience' => $result[0]->customer_experience,
				'marketing' => $result[0]->marketing,
				'management' => $result[0]->management,
				'administration' => $result[0]->administration,
				'presentation_skill' => $result[0]->presentation_skill,
				'quality_of_work' => $result[0]->quality_of_work,
				'efficiency' => $result[0]->efficiency,
				'integrity' => $result[0]->integrity,
				'professionalism' => $result[0]->professionalism,
				'team_work' => $result[0]->team_work,
				'critical_thinking' => $result[0]->critical_thinking,
				'conflict_management' => $result[0]->conflict_management,
				'attendance' => $result[0]->attendance,
				'ability_to_meet_deadline' => $result[0]->ability_to_meet_deadline,
				'remarks' => $result[0]->remarks,
				'get_all_companies' => $this->Xin_model->get_companies(),
				'all_employees' => $this->Xin_model->all_employees()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/performance/dialog_appraisal', $data);
		} else {
			redirect('admin/');
		}
	}
	/* Attendance *////////////////////////////////////////
	// date wise date_wise_attendance > employee > attendance
	 public function attendance()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('dashboard_attendance').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('dashboard_attendance');
		$data['path_url'] = 'user/user_attendance';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/attendance", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	// date wise attendance list > timesheet
    public function date_wise_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$employee_id = $this->input->get("user_id");
		$employee = $this->Exin_model->read_user_info($employee_id);
		
		$start_date = new DateTime( $this->input->get("start_date"));
		$end_date = new DateTime( $this->input->get("end_date") );
		$end_date = $end_date->modify( '+1 day' ); 
		
		$interval_re = new DateInterval('P1D');
		$date_range = new DatePeriod($start_date, $interval_re ,$end_date);
		$attendance_arr = array();
		
		$data = array();
		foreach($date_range as $date) {
		$attendance_date =  $date->format("Y-m-d");
       // foreach($employee->result() as $r) {
			 			  		
		// user full name
	//	$full_name = $r->first_name.' '.$r->last_name;	
		// get office shift for employee
		$get_day = strtotime($attendance_date);
		$day = date('l', $get_day);
		
		// office shift
		$office_shift = $this->Timesheet_model->read_office_shift_information($employee[0]->office_shift_id);
		
		// get clock in/clock out of each employee
		if($day == 'Monday') {
			if($office_shift[0]->monday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->monday_in_time;
				$out_time = $office_shift[0]->monday_out_time;
			}
		} else if($day == 'Tuesday') {
			if($office_shift[0]->tuesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->tuesday_in_time;
				$out_time = $office_shift[0]->tuesday_out_time;
			}
		} else if($day == 'Wednesday') {
			if($office_shift[0]->wednesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->wednesday_in_time;
				$out_time = $office_shift[0]->wednesday_out_time;
			}
		} else if($day == 'Thursday') {
			if($office_shift[0]->thursday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->thursday_in_time;
				$out_time = $office_shift[0]->thursday_out_time;
			}
		} else if($day == 'Friday') {
			if($office_shift[0]->friday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->friday_in_time;
				$out_time = $office_shift[0]->friday_out_time;
			}
		} else if($day == 'Saturday') {
			if($office_shift[0]->saturday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->saturday_in_time;
				$out_time = $office_shift[0]->saturday_out_time;
			}
		} else if($day == 'Sunday') {
			if($office_shift[0]->sunday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->sunday_in_time;
				$out_time = $office_shift[0]->sunday_out_time;
			}
		}
		// check if clock-in for date
		$attendance_status = '';
		$check = $this->Timesheet_model->attendance_first_in_check($employee[0]->user_id,$attendance_date);		
		if($check->num_rows() > 0){
			// check clock in time
			$attendance = $this->Timesheet_model->attendance_first_in($employee[0]->user_id,$attendance_date);
			// clock in
			$clock_in = new DateTime($attendance[0]->clock_in);
			$clock_in2 = $clock_in->format('h:i a');
			
			$office_time =  new DateTime($in_time.' '.$attendance_date);
			//time diff > total time late
			$office_time_new = strtotime($in_time.' '.$attendance_date);
			$clock_in_time_new = strtotime($attendance[0]->clock_in);
			if($clock_in_time_new <= $office_time_new) {
				$total_time_l = '00:00';
			} else {
				$interval_late = $clock_in->diff($office_time);
				$hours_l   = $interval_late->format('%h');
				$minutes_l = $interval_late->format('%i');			
				$total_time_l = $hours_l ."h ".$minutes_l."m";
			}
			
			// total hours work/ed
			$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($employee[0]->user_id,$attendance_date);
			$hrs_old_int1 = '';
			$Total = '';
			$Trest = '';
			$total_time_rs = '';
			$hrs_old_int_res1 = '';
			foreach ($total_hrs->result() as $hour_work){		
				// total work			
				$timee = $hour_work->total_work.':00';
				$str_time =$timee;
	
				$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
				
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$hrs_old_int1 += $hrs_old_seconds;
				
				$Total = gmdate("H:i", $hrs_old_int1);	
			}
			if($Total=='') {
				$total_work = '00:00';
			} else {
				$total_work = $Total;
			}
			
			// total rest > 
			$total_rest = $this->Timesheet_model->total_rest_attendance($employee[0]->user_id,$attendance_date);
			foreach ($total_rest->result() as $rest){			
				// total rest
				$str_time_rs = $rest->total_rest.':00';
				//$str_time_rs =$timee_rs;
	
				$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
				
				sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
				
				$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
				
				$hrs_old_int_res1 += $hrs_old_seconds_rs;
				
				$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
			}
			
			// check attendance status
			$status = $attendance[0]->attendance_status;
			if($total_time_rs=='') {
				$Trest = '00:00';
			} else {
				$Trest = $total_time_rs;
			}
		
		} else {
			$clock_in2 = '-';
			$total_time_l = '00:00';
			$total_work = '00:00';
			$Trest = '00:00';
			// get holiday/leave or absent
			/* attendance status */
			// get holiday
			$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
			$holiday_arr = array();
			if($h_date_chck->num_rows() == 1){
				$h_date = $this->Timesheet_model->holiday_date($attendance_date);
				$begin = new DateTime( $h_date[0]->start_date );
				$end = new DateTime( $h_date[0]->end_date);
				$end = $end->modify( '+1 day' ); 
				
				$interval = new DateInterval('P1D');
				$daterange = new DatePeriod($begin, $interval ,$end);
				
				foreach($daterange as $date){
					$holiday_arr[] =  $date->format("Y-m-d");
				}
			} else {
				$holiday_arr[] = '99-99-99';
			}
			
			
			// get leave/employee
			$leave_date_chck = $this->Timesheet_model->leave_date_check($employee[0]->user_id,$attendance_date);
			$leave_arr = array();
			if($leave_date_chck->num_rows() == 1){
				$leave_date = $this->Timesheet_model->leave_date($employee[0]->user_id,$attendance_date);
				$begin1 = new DateTime( $leave_date[0]->from_date );
				$end1 = new DateTime( $leave_date[0]->to_date);
				$end1 = $end1->modify( '+1 day' ); 
				
				$interval1 = new DateInterval('P1D');
				$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
				
				foreach($daterange1 as $date1){
					$leave_arr[] =  $date1->format("Y-m-d");
				}	
			} else {
				$leave_arr[] = '99-99-99';
			}
				
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = $this->lang->line('xin_holiday');	
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = $this->lang->line('xin_holiday');
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = $this->lang->line('xin_on_leave');
			} 
			else {
				$status = $this->lang->line('xin_absent');
			}
		}
		
		// check if clock-out for date
		$check_out = $this->Timesheet_model->attendance_first_out_check($employee[0]->user_id,$attendance_date);		
		if($check_out->num_rows() == 1){
			/* early time */
			$early_time =  new DateTime($out_time.' '.$attendance_date);
			// check clock in time
			$first_out = $this->Timesheet_model->attendance_first_out($employee[0]->user_id,$attendance_date);
			// clock out
			$clock_out = new DateTime($first_out[0]->clock_out);
			
			if ($first_out[0]->clock_out!='') {
				$clock_out2 = $clock_out->format('h:i a');
				// early leaving
				$early_new_time = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new = strtotime($first_out[0]->clock_out);
			
				if($early_new_time <= $clock_out_time_new) {
					$total_time_e = '00:00';
				} else {			
					$interval_lateo = $clock_out->diff($early_time);
					$hours_e   = $interval_lateo->format('%h');
					$minutes_e = $interval_lateo->format('%i');			
					$total_time_e = $hours_e ."h ".$minutes_e."m";
				}
				
				/* over time */
				$over_time =  new DateTime($out_time.' '.$attendance_date);
				$overtime2 = $over_time->format('h:i a');
				// over time
				$over_time_new = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new1 = strtotime($first_out[0]->clock_out);
				
				if($clock_out_time_new1 <= $over_time_new) {
					$overtime2 = '00:00';
				} else {			
					$interval_lateov = $clock_out->diff($over_time);
					$hours_ov   = $interval_lateov->format('%h');
					$minutes_ov = $interval_lateov->format('%i');			
					$overtime2 = $hours_ov ."h ".$minutes_ov."m";
				}				
				
			} else {
				$clock_out2 =  '-';
				$total_time_e = '00:00';
				$overtime2 = '00:00';
			}
					
		} else {
			$clock_out2 =  '-';
			$total_time_e = '00:00';
			$overtime2 = '00:00';
		}		
		// user full name
			$full_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get company
			$company = $this->Xin_model->read_company_info($employee[0]->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}	
			// attendance date
			$tdate = $this->Xin_model->set_date_format($attendance_date);
		
		$data[] = array(
			$full_name,
			$comp_name,
			$tdate,
			$status,
			$clock_in2,
			$clock_out2,
			$total_time_l,
			$total_time_e,
			$overtime2,
			$total_work,
			$Trest
		);
		
		/*$data[] = array(
			$status,
			$tdate,
			$clock_in2,
			$clock_out2,
			$total_time_l,
			$total_time_e,
			$overtime2,
			$total_work,
			$Trest
		);*/
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => count($date_range),
			 "recordsFiltered" => count($date_range),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	/* Leave */////////////////////////////////////////////
	 public function leave()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_leave').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$data['breadcrumbs'] = $this->lang->line('left_leave');
		$data['path_url'] = 'user/user_leave';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/leave", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('hr');
		}
		  
     }
	 
	 // leave list 
	 public function leave_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/leave", $data);
		} else {
			redirect('hr');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));		
		
		$leave = $this->Timesheet_model->get_employee_leaves($session['user_id']);
		
		$data = array();

        foreach($leave->result() as $r) {
			  
			 // get start date and end date
			 $user = $this->Xin_model->read_user_info($r->employee_id);
			 if(!is_null($user)){
				$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			 
			 // get leave type
		 	 $leave_type = $this->Timesheet_model->read_leave_type_information($r->leave_type_id);
			 if(!is_null($leave_type)){
				$type_name = $leave_type[0]->type_name;
			} else {
				$type_name = '--';	
			}
			 
			 $applied_on = $this->Xin_model->set_date_format($r->applied_on);
			 $duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
			 
			if($r->status==1): $status = $this->lang->line('xin_pending'); elseif($r->status==2): $status = $this->lang->line('xin_approved'); elseif($r->status==3): $status = $this->lang->line('xin_rejected'); endif;
			
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/user/leave_details/id/'.$r->leave_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
				$full_name,
				$type_name,
				$duration,
				$applied_on,
				$r->reason,
				$status
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $leave->num_rows(),
			 "recordsFiltered" => $leave->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 // Validate and add info in database
	public function add_leave() {
	
		if($this->input->post('add_type')=='leave') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$remarks = $this->input->post('remarks');
	
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
		
		/* Server side PHP input validation */		
		if($this->input->post('leave_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_leave_type_field');
		} else if($this->input->post('start_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
        	$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} /*else if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		}*/ else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('reason')==='') {
			$Return['error'] = $this->lang->line('xin_error_leave_type_reason');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$remaining_leave = $this->Timesheet_model->count_total_leaves($this->input->post('leave_type'),$this->input->post('employee_id'));
		$type = $this->Timesheet_model->read_leave_type_information($this->input->post('leave_type'));
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
			$total = $type[0]->days_per_year;
			$leave_remaining_total = $total - $remaining_leave;
		} else {
			$type_name = '--';	
			$leave_remaining_total = 0;
		}
		
		if($leave_remaining_total == 0){
			$Return['error'] = $this->lang->line('xin_leave_limit_msg');
		}
		if($Return['error']!=''){
       		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
    	}	
		
		$user = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		if(!is_null($user)){
			$company_id = $user[0]->company_id;
		} else {
			$company_id = 1;	
		}
			
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $company_id,
		'leave_type_id' => $this->input->post('leave_type'),
		'from_date' => $this->input->post('start_date'),
		'to_date' => $this->input->post('end_date'),
		'applied_on' => date('Y-m-d h:i:s'),
		'reason' => $this->input->post('reason'),
		'remarks' => $qt_remarks,
		'status' => '1',
		'created_at' => date('Y-m-d h:i:s')
		);
		$result = $this->Timesheet_model->add_leave_record($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_leave_added');
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {
				
				$this->email->set_mailtype("html");
				//get company info
				$cinfo = $this->Xin_model->read_company_setting_info(1);
				//get email template
				$template = $this->Xin_model->read_email_template(5);
				//get employee info
				$user_info = $this->Xin_model->read_user_info($this->input->post('employee_id'));
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var employee_name}"),array($cinfo[0]->company_name,site_url(),$full_name),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				$this->email->from($user_info[0]->email, $full_name);
				$this->email->to($cinfo[0]->email);
				
				$this->email->subject($subject);
				$this->email->message($message);
				
				$this->email->send();
			}
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// leave > timesheet
	 public function leave_details() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->lang->line('xin_leave_detail').' | '.$this->Xin_model->site_title();
		$leave_id = $this->uri->segment(5);
		// leave applications
		$result = $this->Timesheet_model->read_leave_information($leave_id);
		if(is_null($result)){
			redirect('admin/user/leave');
		}
		// get leave types
		$type = $this->Timesheet_model->read_leave_type_information($result[0]->leave_type_id);
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
		} else {
			$type_name = '--';	
		}
		// get employee
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
		if(!is_null($user)){
			$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
			$u_role_id = $user[0]->user_role_id;
		} else {
			$full_name = '--';	
			$u_role_id = '--';
		}			 
		
		$data = array(
				'title' => $this->lang->line('xin_leave_detail').' | '.$this->Xin_model->site_title(),
				'type' => $type_name,
				'role_id' => $u_role_id,
				'full_name' => $full_name,
				'leave_id' => $result[0]->leave_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'leave_type_id' => $result[0]->leave_type_id,
				'from_date' => $result[0]->from_date,
				'to_date' => $result[0]->to_date,
				'applied_on' => $result[0]->applied_on,
				'reason' => $result[0]->reason,
				'remarks' => $result[0]->remarks,
				'status' => $result[0]->status,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_leave_types' => $this->Timesheet_model->all_leave_types(),
				);
		$data['breadcrumbs'] = $this->lang->line('xin_leave_detail');
		$data['path_url'] = 'user/user_leave_details';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/leave_details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	/* Tickets *///////////////////////////////////////////
	public function tickets()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_tickets').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_tickets');
		$data['path_url'] = 'user/user_tickets';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/ticket_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}		  
     }
	  
    public function ticket_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/ticket_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$ticket = $this->Tickets_model->get_employee_tickets($session['user_id']);
		
		$data = array();

        foreach($ticket->result() as $r) {
			 			  		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->employee_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
		} else {
			$employee_name = '--';	
		}
		// priority
		if($r->ticket_priority==1): $priority = $this->lang->line('xin_low'); elseif($r->ticket_priority==2): $priority = $this->lang->line('xin_medium'); elseif($r->ticket_priority==3): $priority = $this->lang->line('xin_high'); elseif($r->ticket_priority==4): $priority = $this->lang->line('xin_critical');  endif;
		 
		 // status
		 if($r->ticket_status==1): $status = $this->lang->line('xin_open'); elseif($r->ticket_status==2): $status = $this->lang->line('xin_closed'); endif;
		 // ticket date and time
		 $created_at = date('h:i A', strtotime($r->created_at));
		 $_date = explode(' ',$r->created_at);
		 $edate = $this->Xin_model->set_date_format($_date[0]);
		 $_created_at = $edate. ' '. $created_at;
		$p_company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($p_company)){
			$company = $p_company[0]->name;
		} else {
			$company = '--';	
		}
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/user/ticket_details/'.$r->ticket_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->ticket_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$r->ticket_code,
			$company,
			$employee_name,
			$r->subject,
			$priority,
			$status,
			$_created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $ticket->num_rows(),
			 "recordsFiltered" => $ticket->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function comments_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		$ses_user = $this->Xin_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("employee/user/ticket_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$comments = $this->Tickets_model->get_comments($id);
		
		$data = array();

        foreach($comments->result() as $r) {
			 			  		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->user_id);
		// employee full name
		if(!is_null($employee)){
		$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
		// get designation
		$_designation = $this->Designation_model->read_designation_information($employee[0]->designation_id);
		if(!is_null($_designation)){
			$designation_name = $_designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		
		// profile picture
		if($employee[0]->profile_picture!='' && $employee[0]->profile_picture!='no file') {
			$u_file = base_url().'uploads/profile/'.$employee[0]->profile_picture;
        } else {
			if($employee[0]->gender=='Male') { 
				$u_file = base_url().'uploads/profile/default_male.jpg';
			} else {
				$u_file = base_url().'uploads/profile/default_female.jpg';
			}
        } 
		} else {
			$employee_name = '--';
			$designation_name = '--';
			$u_file = '--';
		}
		// created at
		$created_at = date('h:i A', strtotime($r->created_at));
		$_date = explode(' ',$r->created_at);
		$date = $this->Xin_model->set_date_format($_date[0]);
		///
		if($ses_user[0]->user_role_id==1){
			$link = '<span class="underline">'.$employee_name.' ('.$designation_name.')</span>';
		} else{
			$link = '<span class="underline">'.$employee_name.' ('.$designation_name.')</span>';
		}
		
		if($ses_user[0]->user_role_id==1 || $ses_user[0]->user_id==$r->user_id){
			$dlink = '<div class="media-right">
							<div class="c-rating">
							<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'">
								<a class="btn btn-outline-danger btn-sm delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
			  <i class="fas fa-trash-restore m-r-0-5"></i>'.$this->lang->line('xin_delete').'</a></span>
							</div>
						</div>';
		} else {
			$dlink = '';
		}
		
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="b-a-radius-circle" src="'.$u_file.'">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
							</div>
							<div class="c-text">'.$r->ticket_comments.'</div>
						</div>
						'.$dlink.'
					</div>
				</div>';
		
		$data[] = array(
			$function
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $comments->num_rows(),
			 "recordsFiltered" => $comments->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // attachment list
	  public function attachment_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/ticket_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Tickets_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
		$data = array();

        foreach($attachments->result() as $r) {
			 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=ticket&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->ticket_attachment_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$r->file_title,
			$r->file_description,
			$r->created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $attachments->num_rows(),
			 "recordsFiltered" => $attachments->num_rows(),
			 "data" => $data
		);
		} else {
			$data[] = array('','','','');
      

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => 0,
			 "recordsFiltered" => 0,
			 "data" => $data
		);
		}
	  echo json_encode($output);
	  exit();
     }
	
	// Validate and add info in database
	public function add_ticket() {
	
		if($this->input->post('add_type')=='ticket') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('subject')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_subject');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('ticket_priority')==='') {
			 $Return['error'] = $this->lang->line('xin_error_ticket_priority');
		}
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$ticket_code = $this->Xin_model->generate_random_string();
	
		$data = array(
		'ticket_code' => $ticket_code,
		'subject' => $this->input->post('subject'),
		'company_id' => $this->input->post('company'),
		'employee_id' => $this->input->post('employee_id'),
		'description' => $qt_description,
		'ticket_status' => '1',
		'ticket_priority' => $this->input->post('ticket_priority'),
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Tickets_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_ticket_created');			
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function set_ticket_comment() {
	
		if($this->input->post('add_type')=='set_comment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('xin_comment')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_comment_field');
		} 
		$xin_comment = $this->input->post('xin_comment');
		$qt_xin_comment = htmlspecialchars(addslashes($xin_comment), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'ticket_comments' => $qt_xin_comment,
		'ticket_id' => $this->input->post('comment_ticket_id'),
		'user_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		
		);
		$result = $this->Tickets_model->add_comment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_ticket_comment_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_ticket_attachment() {
	
		if($this->input->post('add_type')=='dfile_attachment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('file_name')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_task_file_name');
		} else if($_FILES['attachment_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_task_file');
		} else if($this->input->post('file_description')==='') {
			 $Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
		$description = $this->input->post('file_description');
		$file_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// is file upload
		if(is_uploaded_file($_FILES['attachment_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','doc','docx','xls','csv','xlsx','txt');
			$filename = $_FILES['attachment_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["attachment_file"]["tmp_name"];
				$attachment_file = "uploads/ticket/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["attachment_file"]["name"]);
				$newfilename = 'ticket_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $attachment_file.$newfilename);
				$fname = $newfilename;
			} else {
				$Return['error'] = $this->lang->line('xin_error_task_file_attachment');
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'ticket_id' => $this->input->post('c_ticket_id'),
		'upload_by' => $this->input->post('user_file_id'),
		'file_title' => $this->input->post('file_name'),
		'file_description' => $file_description,
		'attachment_file' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Tickets_model->add_new_attachment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_ticket_attachment_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function ticket_details()
     {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Tickets_model->read_ticket_information($id);
		if(is_null($result)){
			redirect('admin/user/tickets');
		}
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$data = array(
				'title' => $this->lang->line('xin_ticket_details').' | '.$this->Xin_model->site_title(),
				'ticket_id' => $result[0]->ticket_id,
				'subject' => $result[0]->subject,
				'ticket_code' => $result[0]->ticket_code,
				'employee_id' => $result[0]->employee_id,
				'full_name' => $full_name,
				'ticket_priority' => $result[0]->ticket_priority,
				'created_at' => $result[0]->created_at,
				'description' => $result[0]->description,
				'assigned_to' => $result[0]->assigned_to,
				'ticket_status' => $result[0]->ticket_status,
				'ticket_note' => $result[0]->ticket_note,
				'ticket_remarks' => $result[0]->ticket_remarks,
				'message' => $result[0]->message,
				'all_employees' => $this->Xin_model->all_employees(),
				);
		$data['breadcrumbs'] = $this->lang->line('xin_ticket_details');
		$data['path_url'] = 'user/user_tickets_detail';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/ticket_details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}		  
     }
	 	
	 // Validate and update info in database // update_status
	public function update_ticket_status() {
	
		if($this->input->post('type')=='update_status') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'ticket_status' => $this->input->post('status'),
		'ticket_remarks' => $this->input->post('remarks'),
		);
		$id = $this->input->post('status_ticket_id');
		$result = $this->Tickets_model->update_status($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_ticket_status_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // add_note
	public function add_ticket_note() {
	
		if($this->input->post('type')=='add_note') {		

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'ticket_note' => $this->input->post('ticket_note')
		);
		$id = $this->input->post('token_note_id');
		$result = $this->Tickets_model->update_note($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_ticket_note_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	public function ticket_comment_delete() {
		if($this->input->post('data') == 'ticket_comment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_comment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_ticket_comment_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function ticket_attachment_delete() {
		if($this->input->post('data') == 'ticket_attachment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_attachment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_ticket_attachment_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// Validate and update info in database // add_note
	public function add_project_note() {
	
		if($this->input->post('type')=='add_note') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'project_note' => $this->input->post('project_note')
		);
		$id = $this->input->post('note_project_id');
		$result = $this->Project_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_project_note_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 // delete attachment
	 public function project_attachment_delete() {
		if($this->input->post('is_ajax') == '8') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Project_model->delete_attachment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_project_file_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	/* Tasks */////////////////////////////////////////////
	public function tasks() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_tasks').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('left_tasks');
		$data['path_url'] = 'user/user_tasks';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/tasks", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	 
	 // task > details
	 public function task_details() {
		 
		$data['title'] = $this->lang->line('xin_task_detail').' | '.$this->Xin_model->site_title();
		
		$task_id = $this->uri->segment(5);
		$result = $this->Timesheet_model->read_task_information($task_id);
		if(is_null($result)){
			redirect('admin/user/tasks');
		}
		/* get User info*/
		$u_created = $this->Xin_model->read_user_info($result[0]->created_by);
		
		if(!is_null($u_created)){
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
		} else {
			$f_name = '--';	
		}
		
		// task project
		$prj_task = $this->Project_model->read_project_information($result[0]->project_id);
		if(!is_null($prj_task)){
			$prj_name = $prj_task[0]->title;
		} else {
			$prj_name = '--';
		}
		
		$data = array(
		'title' => $this->lang->line('xin_task_detail').' | '.$this->Xin_model->site_title(),
		'task_id' => $result[0]->task_id,
		'project_name' => $prj_name,
		'created_by' => $f_name,
		'task_name' => $result[0]->task_name,
		'assigned_to' => $result[0]->assigned_to,
		'start_date' => $result[0]->start_date,
		'end_date' => $result[0]->end_date,
		'task_hour' => $result[0]->task_hour,
		'task_status' => $result[0]->task_status,
		'task_note' => $result[0]->task_note,
		'progress' => $result[0]->task_progress,
		'description' => $result[0]->description,
		'created_at' => $result[0]->created_at,
		'all_employees' => $this->Xin_model->all_employees()
		);
		$data['breadcrumbs'] = $this->lang->line('xin_task_detail');
		$data['path_url'] = 'user/user_task_details';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/task_details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	 	 
	 // task list > timesheet
	 public function task_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/tasks", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$task = $this->Timesheet_model->get_tasks();
		
		$data = array();

          foreach($task->result() as $r) {
			  
			 $aim = explode(',',$r->assigned_to);
			 foreach($aim as $dIds) {
			 if($session['user_id'] == $dIds) {
			  
			if($r->assigned_to == '' || $r->assigned_to == 'None') {
				$ol = 'None';
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->assigned_to) as $uid) {
					$user = $this->Exin_model->read_user_info($uid);
					$ol .= '<li>'.$user[0]->first_name. ' '.$user[0]->last_name.'</li>';
				 }
			 $ol .= '</ol>';
			}
			//$ol = 'A';
			/* get User info*/
			$u_created = $this->Exin_model->read_user_info($r->created_by);
			if(!is_null($u_created)){
				$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			} else {
				$f_name = '--';	
			}
			
			// task project
			$prj_task = $this->Project_model->read_project_information($r->project_id);
			if(!is_null($prj_task)){
				$prj_name = $prj_task[0]->title;
			} else {
				$prj_name = '--';
			}
			
			/// set task progress
			if($r->task_progress=='' || $r->task_progress==0): $progress = 0; else: $progress = $r->task_progress; endif;
			
			
			// task progress
			if($r->task_progress <= 20) {
			$progress_class = 'progress-danger';
			} else if($r->task_progress > 20 && $r->task_progress <= 50){
			$progress_class = 'progress-warning';
			} else if($r->task_progress > 50 && $r->task_progress <= 75){
			$progress_class = 'progress-info';
			} else {
			$progress_class = 'progress-success';
			}
			
			$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->task_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->task_progress.'" max="100">'.$r->task_progress.'%</progress>';
			
			// task status
			if($r->task_status == 0) {
				$status = $this->lang->line('xin_not_started');
			} else if($r->task_status ==1){
				$status = $this->lang->line('xin_in_progress');
			} else if($r->task_status ==2){
				$status = $this->lang->line('xin_completed');
			} else {
				$status = $this->lang->line('xin_deffered');
			}
			// task end date
			$tdate = $this->Xin_model->set_date_format($r->end_date);
			 			
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/user/task_details/id/'.$r->task_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
				$r->task_name.'<br>'.$this->lang->line('xin_project').': <a href="'.site_url().'admin/user/project_details/'.$r->project_id.'">'.$prj_name.'</a>',
				$tdate,
				$status,
				$ol,
				$f_name,
				$progress_bar
		   );
	  }
		} } // e-task
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $task->num_rows(),
			 "recordsFiltered" => $task->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
			 
     }
	 public function task_comments_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		$ses_user = $this->Xin_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("employee/user/tasks", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$comments = $this->Timesheet_model->get_comments($id);
		
		$data = array();

        foreach($comments->result() as $r) {
			 			  		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->user_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get designation
			$_designation = $this->Designation_model->read_designation_information($employee[0]->designation_id);
			if(!is_null($_designation)){
				$designation_name = $_designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			
			// profile picture
			if($employee[0]->profile_picture!='' && $employee[0]->profile_picture!='no file') {
				$u_file = base_url().'uploads/profile/'.$employee[0]->profile_picture;
			} else {
				if($employee[0]->gender=='Male') { 
					$u_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$u_file = base_url().'uploads/profile/default_female.jpg';
				}
			} 
		} else {
			$employee_name = '--';
			$designation_name = '--';
			$u_file = '--';
		}
		// created at
		$created_at = date('h:i A', strtotime($r->created_at));
		$_date = explode(' ',$r->created_at);
		$date = $this->Xin_model->set_date_format($_date[0]);
		//
		$link = '<span class="underline">'.$employee_name.' ('.$designation_name.')</span>';
		////
		$dlink = '<div class="media-right">
						<div class="c-rating">
						<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->comment_id . '"><span class="far fa-trash-alt"></span></button></span>
						
						</div>
					</div>';
		
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="ui-w-30 rounded-circle" src="'.$u_file.'">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
							</div>
							<div class="c-text">'.$r->task_comments.'</div>
						</div>
						'.$dlink.'
					</div>
				</div>';
		
		$data[] = array(
			$function
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $comments->num_rows(),
			 "recordsFiltered" => $comments->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// Validate and add info in database
	public function set_task_comment() {
	
		if($this->input->post('add_type')=='set_comment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('xin_comment')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_comment_field');
		} 
		$xin_comment = $this->input->post('xin_comment');
		$qt_xin_comment = htmlspecialchars(addslashes($xin_comment), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'task_comments' => $qt_xin_comment,
		'task_id' => $this->input->post('comment_task_id'),
		'user_id' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Timesheet_model->add_comment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_comment_task');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // add_note
	public function add_task_note() {
	
		if($this->input->post('type')=='add_note') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'task_note' => $this->input->post('task_note')
		);
		$id = $this->input->post('note_task_id');
		$result = $this->Timesheet_model->update_task_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_note_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function task_comment_delete() {
		if($this->input->post('data') == 'task_comment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_comment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_comment_task_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// Validate and add info in database
	public function add_task_attachment() {
	
		if($this->input->post('add_type')=='dfile_attachment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('file_name')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_task_file_name');
		} else if($_FILES['attachment_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_task_file');
		} else if($this->input->post('file_description')==='') {
			 $Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
		$description = $this->input->post('file_description');
		$file_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// is file upload
		if(is_uploaded_file($_FILES['attachment_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx','txt');
			$filename = $_FILES['attachment_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["attachment_file"]["tmp_name"];
				$attachment_file = "uploads/task/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["attachment_file"]["name"]);
				$newfilename = 'task_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $attachment_file.$newfilename);
				$fname = $newfilename;
			} else {
				$Return['error'] = $this->lang->line('xin_error_task_file_attachment');
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'task_id' => $this->input->post('c_task_id'),
		'upload_by' => $this->input->post('user_id'),
		'file_title' => $this->input->post('file_name'),
		'file_description' => $file_description,
		'attachment_file' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Timesheet_model->add_new_attachment($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_task_att_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	  // attachment list
	  public function task_attachment_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/tasks", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Timesheet_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
		$data = array();

        foreach($attachments->result() as $r) {
			 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=task&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->task_attachment_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$r->file_title,
			$r->file_description,
			$r->created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $attachments->num_rows(),
			 "recordsFiltered" => $attachments->num_rows(),
			 "data" => $data
		);
		} else {
			$data[] = array('','','','');
      

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => 0,
			 "recordsFiltered" => 0,
			 "data" => $data
		);
		}
	  echo json_encode($output);
	  exit();
     }
	 
	 // delete task attachment
	 public function task_attachment_delete() {
		if($this->input->post('data') == 'task_attachment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_attachment_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_task_att_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	/* Projects *//////////////////////////////////////////
	 public function projects()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_projects').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_projects');
		$data['path_url'] = 'user/user_projects';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/projects", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function project_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/projects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$project = $this->Project_model->get_projects();
		
		$data = array();

        foreach($project->result() as $r) {
			 			  
		 $aim = explode(',',$r->assigned_to);
		 foreach($aim as $dIds) {
		 if($session['user_id'] == $dIds) {
				 // get user > added by
		$user = $this->Exin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		// get date
		$pdate = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($r->end_date);
		
		//project_progress
		if($r->project_progress <= 20) {
			$progress_class = 'progress-danger';
		} else if($r->project_progress > 20 && $r->project_progress <= 50){
			$progress_class = 'progress-warning';
		} else if($r->project_progress > 50 && $r->project_progress <= 75){
			$progress_class = 'progress-info';
		} else {
			$progress_class = 'progress-success';
		}
		
		// progress
		
		$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->project_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->project_progress.'" max="100">'.$r->project_progress.'%</progress>';
				
		//status
		if($r->status == 0) {
			$status = $this->lang->line('xin_not_started');
		} else if($r->status ==1){
			$status = $this->lang->line('xin_in_progress');
		} else if($r->status ==2){
			$status = $this->lang->line('xin_completed');
		} else {
			$status = $this->lang->line('xin_deffered');
		}
		
		// priority
		if($r->priority == 1) {
			$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_highest').'</span>';
		} else if($r->priority ==2){
			$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_high').'</span>';
		} else if($r->priority ==3){
			$priority = '<span class="tag tag-primary">'.$this->lang->line('xin_normal').'</span>';
		} else {
			$priority = '<span class="tag tag-success">'.$this->lang->line('xin_low').'</span>';
		}
		
		//assigned user
		if($r->assigned_to == '') {
			$ol = $this->lang->line('xin_not_assigned');
		} else {
			$ol = '';
			foreach(explode(',',$r->assigned_to) as $desig_id) {
				$assigned_to = $this->Exin_model->read_user_info($desig_id);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
                    $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                    } else {
                    if($assigned_to[0]->gender=='Male') { 
                    	$de_file = base_url().'uploads/profile/default_male.jpg';
                     } else {
                     	$de_file = base_url().'uploads/profile/default_female.jpg';
                     }
                    $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                    }
				} ////
				else {
					$ol .= '';
				}
			 }
			 $ol .= '';
		}
		
		$project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/user/project_details/'.$r->project_id . '">'.$r->title.'</a></div>
					        <div class="text-muted">'.$r->summary.'</div>';
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/user/project_details/'.$r->project_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
			$project_summary,
			$priority,
			$pdate,
			$pbar,
			$ol
		);
      }
		 } } // e-project

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $project->num_rows(),
			 "recordsFiltered" => $project->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function bug_read()
	{
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('hr/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('bug_id');
		$result = $this->Project_model->read_bug_information($id);
		$data = array(
				'bug_id' => $result[0]->bug_id,
				'project_id' => $result[0]->project_id,
				'status' => $result[0]->status,
				);
		$this->load->view('employee/user/dialog_project_bug', $data);
	}
	
	public function change_bug_status() {
		if($this->input->post('data') == 'change_status') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$data = array(
			'status' => $this->input->post('status'),
			);
			$result = $this->Project_model->update_bug($data,$id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_project_bug_status_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function bug_delete() {
		if($this->input->post('data') == 'bug') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Project_model->delete_bug_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_project_bug_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	 // project details
	 public function project_details()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		//$data['all_employees'] = $this->Xin_model->all_employees();
		//$data['all_companies'] = $this->Xin_model->get_companies();
		//$data['breadcrumbs'] = $this->lang->line('xin_project_detail');
		$id = $this->uri->segment(4);
		$result = $this->Project_model->read_project_information($id);
		if(is_null($result)){
			redirect('admin/user/projects');
		}
		// get user > added by
		$user = $this->Xin_model->read_user_info($result[0]->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$result2 = $this->Clients_model->read_client_info($result[0]->client_id);
		if(!is_null($result2)) {
			$client_name = $result2[0]->name;
		} else {
			$client_name = '--';
		}
		$data = array(
			'breadcrumbs' => $this->lang->line('xin_project_detail'),
			'project_id' => $result[0]->project_id,
			'title' => $result[0]->title,
			'project_note' => $result[0]->project_note,
			'summary' => $result[0]->summary,
			'client_name' => $client_name,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'company_id' => $result[0]->company_id,
			'assigned_to' => $result[0]->assigned_to,
			'created_at' => $result[0]->created_at,
			'priority' => $result[0]->priority,
			'added_by' => $full_name,
			'description' => $result[0]->description,
			'progress' => $result[0]->project_progress,
			'status' => $result[0]->status,
			'path_url' => 'user/user_project_details',
			'all_employees' => $this->Xin_model->all_employees(),
			'all_companies' => $this->Xin_model->get_companies()
			);

		if(!empty($session)){ 
		$data['subview'] = $this->load->view("employee/user/project_details", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}		  
     }
	 
	 // Validate and update info in database
	public function update_project_status() {
	
		if($this->input->post('type')=='update_status') {
			
		$id = $this->input->post('project_id');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		$data = array(
		'project_progress' => $this->input->post('progres_val')
		);
		
		$result = $this->Project_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_project');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 // attachment list
	  public function project_attachment_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Project_model->get_attachments($id);

		$data = array();

        foreach($attachments->result() as $r) {
			 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=project/files&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light fidelete" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->project_attachment_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$r->file_title,
			$r->file_description,
			$r->created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $attachments->num_rows(),
			 "recordsFiltered" => $attachments->num_rows(),
			 "data" => $data
		);

	  echo json_encode($output);
	  exit();
     }
	 
	 // project task list > details
	 public function project_task_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);		
		$task = $this->Timesheet_model->get_project_tasks($id);
		
		$data = array();

          foreach($task->result() as $r) {
			  
			if($r->assigned_to == '' || $r->assigned_to == 'None') {
				$ol = $this->lang->line('xin_performance_none');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $uid) {
					$assigned_to = $this->Xin_model->read_user_info($uid);
					if(!is_null($assigned_to)){
					$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
					if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
						if($assigned_to[0]->gender=='Male') { 
							$de_file = base_url().'uploads/profile/default_male.jpg';
						 } else {
							$de_file = base_url().'uploads/profile/default_female.jpg';
						 }
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
						}
					//
					}
				 }
			 $ol .= '';
			}
			//$ol = 'A';
			/* get User info*/
			$u_created = $this->Xin_model->read_user_info($r->created_by);
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			
			/// set task progress
			if($r->task_progress=='' || $r->task_progress==0): $progress = 0; else: $progress = $r->task_progress; endif;
			
			
			// task progress
			if($r->task_progress <= 20) {
			$progress_class = 'progress-danger';
			} else if($r->task_progress > 20 && $r->task_progress <= 50){
			$progress_class = 'progress-warning';
			} else if($r->task_progress > 50 && $r->task_progress <= 75){
			$progress_class = 'progress-info';
			} else {
			$progress_class = 'progress-success';
			}
			
			$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->task_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->task_progress.'" max="100">'.$r->task_progress.'%</progress>';
			
			
			// task status
			if($r->task_status == 0) {
				$status = $this->lang->line('xin_not_started');
			} else if($r->task_status ==1){
				$status = $this->lang->line('xin_in_progress');
			} else if($r->task_status ==2){
				$status = $this->lang->line('xin_completed');
			} else {
				$status = $this->lang->line('xin_deffered');
			}
			// task end date
			$tdate = $this->Xin_model->set_date_format($r->end_date);
			 			
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/user/task_details/id/'.$r->task_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
				$r->task_name,
				$tdate,
				$status,
				$ol,
				$f_name,
				
				$progress_bar
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $task->num_rows(),
			 "recordsFiltered" => $task->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function project_bug_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$ses_user = $this->Xin_model->read_user_info($session['user_id']);
		$this->load->view("admin/project/project_details", $data);
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$bug = $this->Project_model->get_bug($id);
		
		$data = array();

        foreach($bug->result() as $r) {
			 			  		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->user_id);
		// employee full name
		if(!is_null($employee)){
			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get designation
			$_designation = $this->Designation_model->read_designation_information($employee[0]->designation_id);
			if(!is_null($_designation)){
				$designation_name = $_designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			
			// profile picture
			if($employee[0]->profile_picture!='' && $employee[0]->profile_picture!='no file') {
				$u_file = base_url().'uploads/profile/'.$employee[0]->profile_picture;
			} else {
				if($employee[0]->gender=='Male') { 
					$u_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$u_file = base_url().'uploads/profile/default_female.jpg';
				}
			} 
		} else {
			$employee_name = '--';
			$designation_name = '--';
			$u_file = '--';
		}
		// created at
		$created_at = date('h:i A', strtotime($r->created_at));
		$_date = explode(' ',$r->created_at);
		$date = $this->Xin_model->set_date_format($_date[0]);
		//
		$link = '<span class="underline">'.$employee_name.' ('.$designation_name.')</span>';
		
		
		if($r->attachment_file!='' && $r->attachment_file!='no_file'){
			$at_file = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'" href="'.site_url().'admin/download?type=project/bug&filename='.$r->attachment_file.'"> <i class="oi oi-cloud-download"></i> </a>';
		} else {
			$at_file = '';
		}
		
		$dlink = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_update_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-bug_id="'. $r->bug_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			
		if($r->status==0) {
			$status = '<select name="status" id="status" class="bug_status" data-bug-id="'.$r->bug_id.'">
							<option value="0" selected="selected">'.$this->lang->line('xin_pending').'</option>
							<option value="1">'.$this->lang->line('xin_project_status_solved').'</option>
							</select>';
			$st_tag = '<span class="badge badge-warning">'.$this->lang->line('xin_pending').'</span>';				
		} else {
			$status = '<select name="status" id="status" class="bug_status" data-bug-id="'.$r->bug_id.'">
							<option value="0">'.$this->lang->line('xin_pending').'</option>
							<option value="1" selected="selected">'.$this->lang->line('xin_project_status_solved').'</option>
							</select>';
			$st_tag = '<span class="badge badge-success">'.$this->lang->line('xin_project_status_solved').'</span>';				
		}
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="d-block ui-w-30" src="'.$u_file.'">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.' &nbsp; '.$st_tag.'
							</div>
							<div class="c-text">'.$r->title.'<br> '.$at_file.'</div>
						</div>
						'.$dlink.'
					</div>
				</div>
				';
		
		$data[] = array(
			$function
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $bug->num_rows(),
			 "recordsFiltered" => $bug->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 public function project_discussion_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		
		$ses_user = $this->Xin_model->read_user_info($session['user_id']);
		$this->load->view("admin/project/project_details", $data);
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$discussion = $this->Project_model->get_discussion($id);
		
		$data = array();

        foreach($discussion->result() as $r) {
			 			  		
		// get user > employee_
		$employee = $this->Xin_model->read_user_info($r->user_id);
		// employee full name
		if(!is_null($employee)){

			$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get designation
			$_designation = $this->Designation_model->read_designation_information($employee[0]->designation_id);
			if(!is_null($_designation)){
				$designation_name = $_designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			
			// profile picture
			if($employee[0]->profile_picture!='' && $employee[0]->profile_picture!='no file') {
				$u_file = base_url().'uploads/profile/'.$employee[0]->profile_picture;
			} else {
				if($employee[0]->gender=='Male') { 
					$u_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$u_file = base_url().'uploads/profile/default_female.jpg';
				}
			} 
		} else {
			$employee_name = '--';
			$designation_name = '--';
			$u_file = '--';
		}
		// created at
		$created_at = date('h:i A', strtotime($r->created_at));
		$_date = explode(' ',$r->created_at);
		$date = $this->Xin_model->set_date_format($_date[0]);
		//
		$link = '<span class="underline">'.$employee_name.' ('.$designation_name.')</span>';
		
		if($r->attachment_file!='' && $r->attachment_file!='no_file'){
			$at_file = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'" href="'.site_url().'admin/download?type=project/discussion&filename='.$r->attachment_file.'"> <span class="oi oi-cloud-download"></span> </a>';
		} else {
			$at_file = '';
		}
				
		$function = '<div class="c-item">
					<div class="media">
						<div class="media-left">
							<div class="avatar box-48">
							<img class="d-block ui-w-30" src="'.$u_file. '">
							</div>
						</div>
						<div class="media-body">
							<div class="mb-0-5">
								'.$link.'
								<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
							</div>
							<div class="c-text">'.$r->message.'<br> '.$at_file.'</div>
						</div>
					</div>
				</div>';
		
		$data[] = array(
			$function
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $discussion->num_rows(),
			 "recordsFiltered" => $discussion->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	/* Jobs applied > Recruitment *////////////////////////
	public function jobs_applied()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_jobs_applied').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_jobs_applied');
		$data['path_url'] = 'user/user_job_applied';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/job_applied_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function jobs_applied_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/job_applied_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$candidates = $this->Job_post_model->get_employee_jobs_applied($session['user_id']);
		
		$data = array();

        foreach($candidates->result() as $r) {
			 			  
		// get user
		$user = $this->Exin_model->read_user_info($r->user_id);
		// get full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name. ' ' .$user[0]->last_name;
			$uemail = $user[0]->email;
		} else {
			$full_name = '--';	
			$uemail = '--';
		}
		// get job title
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '--';	
		}
		// get date
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="Download">
			<a href="'.site_url().'hr/download?type=resume&filename='.$r->job_resume.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light" title="Download"><i class="oi oi-cloud-download"></i></button></a></span><a href="'.site_url().'frontend/jobs/detail/'.$r->job_id.'/" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a>',
			$job_title,
			$full_name,
			$uemail,
			$r->application_status,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $candidates->num_rows(),
			 "recordsFiltered" => $candidates->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	/* Jobs interview > Recruitment *//////////////////////
	public function jobs_interviews()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_job_interviews').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_interview_jobs'] = $this->Job_post_model->all_interview_jobs();
		$data['breadcrumbs'] = $this->lang->line('left_job_interviews');
		$data['path_url'] = 'user/user_job_interviews';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/job_interviews", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function jobs_interview_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/job_interviews", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$interview = $this->Job_post_model->all_interviews();
		
		$data = array();

        foreach($interview->result() as $r) {
			
		$aim = explode(',',$r->interviewees_id);
		foreach($aim as $dIds) {
		if($session['user_id'] == $dIds) {
		
		// get job title
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '--';	
		}
		// get date
		$interview_date = $this->Xin_model->set_date_format($r->interview_date);		
				
		// get interviewers
		/*if($r->interviewers_id == '') {
			$interviewers = '-';
		} else {
			$interviewers = '<ol class="nl">';
		foreach(explode(',',$r->interviewers_id) as $interviewers_id) {
			$user_intwer = $this->Xin_model->read_user_info($interviewers_id);
			$interviewers .= '<li>'.$user_intwer[0]->first_name. ' '.$user_intwer[0]->last_name.'</li>';
			}
			$interviewers .= '</ol>';
		}*/
		
		// get time
		$interview_time = $r->interview_date.' '.$r->interview_time;
		$interview_ex_time =  new DateTime($interview_time);
		$int_time = $interview_ex_time->format('h:i a');
		
		// interview date and time
		$interview_d_t = $interview_date.' '.$int_time;
		// interview added by
		$u_added = $this->Exin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($u_added)){
			$int_addedby = $u_added[0]->first_name. ' '.$u_added[0]->last_name;
		} else {
			$int_addedby = '--';	
		}
		// interview message
		$description = html_entity_decode($r->description);
		$data[] = array(
			'<a href="'.site_url().'frontend/jobs/detail/'.$r->job_id.'/" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a>',
			$job_title,
			$description,
			$r->interview_place,
			$interview_d_t,
			$int_addedby
		);
      }
		} } // e-interviews
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $interview->num_rows(),
			 "recordsFiltered" => $interview->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	/* Announcements */////////////////////////////////////
	public function announcement()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_announcements').' | '.$this->Xin_model->site_title();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['breadcrumbs'] = $this->lang->line('xin_announcements');
		$data['path_url'] = 'user/user_announcement';
		if(!empty($session)){
			$data['subview'] = $this->load->view("employee/user/announcement_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
 
    public function announcement_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/announcement_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$announcement = $this->Announcement_model->get_announcements();
		
		$data = array();

        foreach($announcement->result() as $r) {
						 			  
		// get user > added by
		$user = $this->Exin_model->read_user_info($r->published_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		// get date
		$sdate = $this->Xin_model->set_date_format($r->start_date);
		$edate = $this->Xin_model->set_date_format($r->end_date);
		
		$department = $this->Department_model->read_department_information($r->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-announcement_id="'. $r->announcement_id . '"><span class="fa fa-eye"></span></button></span>',
			$r->title,
			$r->summary,
			$department_name,
			$sdate,
			$edate,
			$full_name
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $announcement->num_rows(),
			 "recordsFiltered" => $announcement->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	  public function announcement_read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('announcement_id');
		$result = $this->Announcement_model->read_announcement_information($id);
		$data = array(
				'announcement_id' => $result[0]->announcement_id,
				'title' => $result[0]->title,
				'company_id' => $result[0]->company_id,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'company_id' => $result[0]->company_id,
				'department_id' => $result[0]->department_id,
				'published_by' => $result[0]->published_by,
				'summary' => $result[0]->summary,
				'description' => $result[0]->description,
				'get_all_companies' => $this->Company_model->get_all_companies(),
				'all_office_locations' => $this->Location_model->all_office_locations(),
				'all_departments' => $this->Department_model->all_departments()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('employee/user/dialog_announcement', $data);
		} else {
			redirect('admin/');
		}
	}
	/* Expense Claims *////////////////////////////////////
	public function expense_claims()
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
		$data['path_url'] = 'user/user_expense_claims';
		$data['subview'] = $this->load->view("employee/user/expense_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
     }
 
    public function expense_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/expense_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$expense = $this->Expense_model->get_employee_expenses();
		
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
			  
			if($r->status==0): $status = $this->lang->line('xin_pending'); 
			elseif($r->status==1): $status = $this->lang->line('xin_approved'); 
			else: $status = $this->lang->line('xin_cancel'); endif;
			
			if($r->billcopy_file!='' && $r->billcopy_file!='no file') {
				$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'hr/download?type=expense&filename='.$r->billcopy_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light" title="'.$this->lang->line('xin_download').'"><span class="oi oi-cloud-download"></span></button></a></span>';
			}

               $data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-expense_id="'. $r->expense_id . '"><span class="fas fa-pencil-alt"></span></button></span>'.$download.'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-expense_id="'. $r->expense_id . '"><span class="fa fa-eye"></span></button></span>',
                    $comp_name,
					$full_name,
                    $expensen,
                    $currency,
                    $edate,
                    $status,
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
	/* Travel *////////////////////////////////////////////
	public function travel()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_travels').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['travel_arrangement_types'] = $this->Travel_model->travel_arrangement_types();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_travels');
		$data['path_url'] = 'user/user_travel';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/travel_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
     }
 
    public function travel_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/travel_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$travel = $this->Travel_model->get_employee_travel($session['user_id']);
		
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
		if($r->status==0): $status = $this->lang->line('xin_pending');
		elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-travel_id="'. $r->travel_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-travel_id="'. $r->travel_id . '"><span class="fa fa-eye"></span></button></span>',
			$employee_name,
			$comp_name,
			$r->visit_purpose,
			$r->visit_place,
			$start_date,
			$end_date,
			$status
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
	/* Payslip *///////////////////////////////////////////
	public function payslip()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_payslip').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('xin_payslip');
		$data['path_url'] = 'user/user_payslip';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("employee/user/payslips", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		  
     }
	 
	 // all payslips list
	 public function employee_payslip_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/payslips", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$history = $this->Payroll_model->get_payroll_slip($session['user_id']);
		
		$data = array();

          foreach($history->result() as $r) {

			  // get addd by > template
			  $user = $this->Exin_model->read_user_info($r->employee_id);
			  // user full name
			  $full_name = $user[0]->first_name.' '.$user[0]->last_name;
			  		  
			  $month_payment = date("F, Y", strtotime($r->payment_date));
			   //$month_payment = $this->xin_model->set_date_format($r->payment_date);
			  $p_amount = $this->Xin_model->currency_sign($r->payment_amount);
	
			  // get date > created at > and format
			  $created_at = $this->Xin_model->set_date_format($r->created_at);
			   // get hourly rate
			  // payslip
		 	 $payslip = '<a class="text-success" href="'.site_url().'admin/user/upayslip/id/'.$r->make_payment_id.'/">'.$this->lang->line('left_generate_payslip').'</a>';
			 // view
			 $functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".detail_modal_data" data-employee_id="'. $r->employee_id . '" data-pay_id="'. $r->make_payment_id . '"><span class="fa fa-arrow-circle-right"></span></button></span>';
			  
			  if($r->payment_method==1){
			  	$p_method = 'Online';
			  } else if($r->payment_method==2){
				  $p_method = 'PayPal';
			  } else if($r->payment_method==3) {
				  $p_method = 'Payoneer';
			  } else if($r->payment_method==4){
				  $p_method = 'Bank Transfer';
			  } else if($r->payment_method==5) {
				  $p_method = 'Cheque';
			  } else {
				  $p_method = 'Cash';
			  }

               $data[] = array(
			   		$functions,
					'#'.$r->make_payment_id,
                    $p_amount,
                    $month_payment,
                    $created_at,
					$p_method,
					$payslip
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $history->num_rows(),
                 "recordsFiltered" => $history->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // payment history
	 public function upayslip()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$payment_id = $this->uri->segment(5);
		
		$result = $this->Payroll_model->read_make_payment_information($payment_id);
		if(is_null($result)){
			redirect('admin/user/payslip');
		}
		$p_method = '';
		if($result[0]->payment_method==1){
		  $p_method = 'Online';
		} else if($result[0]->payment_method==2){
		  $p_method = 'PayPal';
		} else if($result[0]->payment_method==3) {
		  $p_method = 'Payoneer';
		} else if($result[0]->payment_method==4){
		  $p_method = 'Bank Transfer';
		} else if($result[0]->payment_method==5) {
		  $p_method = 'Cheque';
		} else {
		  $p_method = 'Cash';
		}
		// get addd by > template
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
		// user full name
		if(!is_null($user)){
			$first_name = $user[0]->first_name;
			$last_name = $user[0]->last_name;
		} else {
			$first_name = '--';
			$last_name = '--';
		}
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		
		// department
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		//$department_designation = $designation[0]->designation_name.'('.$department[0]->department_name.')';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data = array(
				'title' => $this->lang->line('xin_payroll_employee_payslip').' | '.$this->Xin_model->site_title(),
				'first_name' => $first_name,
				'last_name' => $last_name,
				'employee_id' => $user[0]->employee_id,
				'contact_no' => $user[0]->contact_no,
				'date_of_joining' => $user[0]->date_of_joining,
				'department_name' => $department_name,
				'designation_name' => $designation_name,
				'date_of_joining' => $user[0]->date_of_joining,
				'profile_picture' => $user[0]->profile_picture,
				'gender' => $user[0]->gender,
				'monthly_grade_id' => $user[0]->monthly_grade_id,
				'hourly_grade_id' => $user[0]->hourly_grade_id,
				'make_payment_id' => $result[0]->make_payment_id,
				'basic_salary' => $result[0]->basic_salary,
				'payment_date' => $result[0]->payment_date,
				'is_advance_salary_deduct' => $result[0]->is_advance_salary_deduct,
				'advance_salary_amount' => $result[0]->advance_salary_amount,
				'payment_amount' => $result[0]->payment_amount,
				'payment_method' => $p_method,
				'overtime_rate' => $result[0]->overtime_rate,
				'hourly_rate' => $result[0]->hourly_rate,
				'total_hours_work' => $result[0]->total_hours_work,
				'is_payment' => $result[0]->is_payment,
				'house_rent_allowance' => $result[0]->house_rent_allowance,
				'medical_allowance' => $result[0]->medical_allowance,
				'travelling_allowance' => $result[0]->travelling_allowance,
				'dearness_allowance' => $result[0]->dearness_allowance,
				'provident_fund' => $result[0]->provident_fund,
				'security_deposit' => $result[0]->security_deposit,
				'tax_deduction' => $result[0]->tax_deduction,
				'gross_salary' => $result[0]->gross_salary,
				'total_allowances' => $result[0]->total_allowances,
				'total_deductions' => $result[0]->total_deductions,
				'net_salary' => $result[0]->net_salary,
				'comments' => $result[0]->comments,
				);
		$data['breadcrumbs'] = $this->lang->line('xin_payroll_employee_payslip');
		$data['path_url'] = 'payslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
		$data['subview'] = $this->load->view("employee/user/payslip_details", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
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
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
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
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
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
			$this->load->view('employee/user/dialog_expense', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and update info in database
	public function update_expense() {
	
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
		'amount' => $this->input->post('amount'),
		'remarks' => $qt_remarks,
		);
			
		/* Server side PHP input validation */
		if($this->input->post('expense_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_expense_type');
		} else if($this->input->post('purchase_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_purchase_date');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_expense_amount');
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
	
	 public function read_travel()
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
			$this->load->view('employee/user/dialog_travel', $data);
		} else {
			redirect('employee/');
		}
	}
	public function read_awards()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('award_id');
		$result = $this->Awards_model->read_award_information($id);
		$data = array(
				'award_id' => $result[0]->award_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'award_type_id' => $result[0]->award_type_id,
				'gift_item' => $result[0]->gift_item,
				'award_photo' => $result[0]->award_photo,
				'cash_price' => $result[0]->cash_price,
				'award_month_year' => $result[0]->award_month_year,
				'award_information' => $result[0]->award_information,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_award_types' => $this->Awards_model->all_award_types(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/awards/dialog_award', $data);
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
			$Return['result'] = $this->lang->line('xin_success_travel_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_travel() {
	
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
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_travel_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
		
	 // advance salary
	 public function advance_salary()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_advance_salary').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_advance_salary');
		$data['path_url'] = 'user/user_advance_salary';
		$data['subview'] = $this->load->view("employee/user/advance_salary", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
     }
	 
	  // advance salary report
	 public function advance_salary_report()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_advance_salary_report').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_advance_salary_report');
		$data['path_url'] = 'user/user_advance_salary_report';
		$data['subview'] = $this->load->view("employee/user/advance_salary_report", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
     }
	 
	 // Validate and add info in database
	public function add_advance_salary() {
	
		if($this->input->post('add_type')=='advance_salary') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			
		/* Server side PHP input validation */		
		if($this->input->post('company')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_error_advance_salary_month_year');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// get one time value
		if($this->input->post('one_time_deduct')==1){
			$monthly_installment = 0;
		} else {
			$monthly_installment = $this->input->post('monthly_installment');
		}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company'),
		'reason' => $qt_reason,
		'month_year' => $this->input->post('month_year'),
		'advance_amount' => $this->input->post('amount'),
		'monthly_installment' => $monthly_installment,
		'total_paid' => 0,
		'one_time_deduct' => $this->input->post('one_time_deduct'),
		'status' => $this->input->post('status'),
		'created_at' => date('Y-m-d h:i:s')
		);
		
		$result = $this->Payroll_model->add_advance_salary_payroll($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_request_sent_advance_salary');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 
	// advance salary list
    public function advance_salary_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/advance_salary", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$advance_salary = $this->Payroll_model->get_advance_salaries();
		
		$data = array();

          foreach($advance_salary->result() as $r) {

			// get addd by > template
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			$d = explode('-',$r->month_year);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			// get net salary
			$advance_amount = $this->Xin_model->currency_sign($r->advance_amount);
			// get date > created at > and format
			$cdate = $this->Xin_model->set_date_format($r->created_at);
			// get status
			if($r->status==0): $status = $this->lang->line('xin_pending'); elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
			// get monthly installment
			$monthly_installment = $this->Xin_model->currency_sign($r->monthly_installment);
			
			// get onetime deduction value
			if($r->one_time_deduct==1): $onetime = $this->lang->line('xin_yes'); else: $onetime = $this->lang->line('xin_no'); endif;
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			$data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-advance_salary_id="'. $r->advance_salary_id . '"><span class="fa fa-eye"></span></button></span>',
                    $comp_name,
                    $advance_amount,
                    $month_year,
					$onetime,
					$monthly_installment,
					$cdate,
					$status
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $advance_salary->num_rows(),
                 "recordsFiltered" => $advance_salary->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // get advance salary info by id
	public function advance_salary_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('advance_salary_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->read_advance_salary_info($id);
		$data = array(
				'advance_salary_id' => $result[0]->advance_salary_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'month_year' => $result[0]->month_year,
				'advance_amount' => $result[0]->advance_amount,
				'one_time_deduct' => $result[0]->one_time_deduct,
				'monthly_installment' => $result[0]->monthly_installment,
				'reason' => $result[0]->reason,
				'status' => $result[0]->status,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('employee/user/dialog_advance_salary', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get advance salary info by id
	public function advance_salary_report_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('hr/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->advance_salaries_report_view($id);
		$data = array(
				'advance_salary_id' => $result[0]->advance_salary_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'month_year' => $result[0]->month_year,
				'advance_amount' => $result[0]->advance_amount,
				'total_paid' => $result[0]->total_paid,
				'one_time_deduct' => $result[0]->one_time_deduct,
				'monthly_installment' => $result[0]->monthly_installment,
				'reason' => $result[0]->reason,
				'status' => $result[0]->status,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('employee/user/dialog_advance_salary', $data);
		} else {
			redirect('hr/');
		}
	}
	 
	 // advance salary report list
    public function advance_salary_report_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/advance_salary", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$advance_salary = $this->Payroll_model->get_advance_salaries_report();
		
		$data = array();

          foreach($advance_salary->result() as $r) {

			// get addd by > template
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			$d = explode('-',$r->month_year);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			// get net salary
			$advance_amount = $this->Xin_model->currency_sign($r->advance_amount);
			// get date > created at > and format
			$cdate = $this->Xin_model->set_date_format($r->created_at);
			// get status
			if($r->status==0): $status = $this->lang->line('xin_pending'); elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
			// get monthly installment
			$monthly_installment = $this->Xin_model->currency_sign($r->monthly_installment);
			
			$remainig_amount = $r->advance_amount - $r->total_paid;
			$ramount = $this->Xin_model->currency_sign($remainig_amount);
			
			// get onetime deduction value
			if($r->one_time_deduct==1): $onetime = $this->lang->line('xin_yes'); else: $onetime = $this->lang->line('xin_no'); endif;
			if($r->advance_amount == $r->total_paid){
				$all_paid = '<span class="tag tag-success">'.$this->lang->line('xin_all_paid').'</span>';
			} else {
				$all_paid = '<span class="tag tag-warning">'.$this->lang->line('xin_remaining').'</span>';
			}
			//total paid
			$total_paid = $this->Xin_model->currency_sign($r->total_paid);
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			$data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-employee_id="'. $r->employee_id . '"><span class="fa fa-eye"></span></button></span>',
                    $comp_name,
                    $advance_amount,
                    $total_paid,
					$ramount,
					$all_paid,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $advance_salary->num_rows(),
                 "recordsFiltered" => $advance_salary->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	/* Policy Read *///////////////////////////////////////////
	public function policy_read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('employee/user/dialog_policy', $data);
		} else {
			redirect('admin/');
		}
	}
}
