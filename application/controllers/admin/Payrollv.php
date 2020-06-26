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

class Payroll extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		$this->load->library('Pdf');
		//load the model
		$this->load->model("Payroll_model");
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 // payroll templates
	 public function templates()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_payroll_templates').' | '.$this->Xin_model->site_title();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_payroll_templates');
		$data['path_url'] = 'payroll_templates';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('34',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/payroll/templates", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
	 // generate payslips
	 public function generate_payslip()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_generate_payslip').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_generate_payslip');
		$data['path_url'] = 'generate_payslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('36',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/payroll/generate_payslip", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 	 
	 // payment history
	 public function payment_history()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_payment_history').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('left_payment_history');
		$data['path_url'] = 'payment_history';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('37',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/payroll/payment_history", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 	 
	 // payslip > employees
	 public function payslip_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/generate_payslip", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		// date and employee id/company id
		$p_date = $this->input->get("month_year");
		if($this->input->get("employee_id")==0 && $this->input->get("company_id")==0) {
			$payslip = $this->Employees_model->get_employees();
		} else if($this->input->get("employee_id")==0 && $this->input->get("company_id")!=0) {
			$payslip = $this->Payroll_model->get_comp_template($this->input->get("company_id"),0);
		} else if($this->input->get("employee_id")!=0 && $this->input->get("company_id")!=0) {
			$payslip = $this->Payroll_model->get_employee_comp_template($this->input->get("company_id"),$this->input->get("employee_id"));
		} else {
			$payslip = $this->Employees_model->get_employees();
		}
		
		$system = $this->Xin_model->read_setting_info(1);
		/*$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
		
		$data = array();

          foreach($payslip->result() as $r) {
			  // user full name
			$emp_name = $r->first_name.' '.$r->last_name;
			$full_name = '<a target="_blank" class="text-primary" href="'.site_url().'admin/employees/detail/'.$r->user_id.'">'.$emp_name.'</a>';
			
			// get total hours > worked > employee
			$result = $this->Payroll_model->total_hours_worked_payslip($r->user_id,$this->input->get('month_year'));
			/* total work clock-in > clock-out  */
			$hrs_old_int1 = 0;//'';
			$Total = 0;
			$Trest = 0;
			$total_time_rs = 0;
			$hrs_old_int_res1 = 0;
			foreach ($result->result() as $hour_work){
				// total work			
				$clock_in =  new DateTime($hour_work->clock_in);
				$clock_out =  new DateTime($hour_work->clock_out);
				$interval_late = $clock_in->diff($clock_out);
				$hours_r  = $interval_late->format('%h');
				$minutes_r = $interval_late->format('%i');			
				$total_time = $hours_r .":".$minutes_r.":".'00';
				
				$str_time = $total_time;
			
				$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
				
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$hrs_old_int1 += $hrs_old_seconds;
				
				$Total = gmdate("H", $hrs_old_int1);			
			}
				// get company
				$company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($company)){
					$comp_name = $company[0]->name;
				} else {
					$comp_name = '--';	
				}
				
				// 1: salary type
				if($r->wages_type==1){
					$wages_type = $this->lang->line('xin_payroll_basic_salary');
					$basic_salary = $r->basic_salary;
					$p_class = 'emo_monthly_pay';
				} else {
					$wages_type = $this->lang->line('xin_employee_daily_wages');
					$basic_salary = $r->daily_wages;
					$p_class = 'emo_monthly_pay';
				}
				
				// 2: all allowances
				$salary_allowances = $this->Employees_model->read_salary_allowances($r->user_id);
				$count_allowances = $this->Employees_model->count_employee_allowances($r->user_id);
				$allowance_amount = 0;
				if($count_allowances > 0) {
					foreach($salary_allowances as $sl_allowances){
						$allowance_amount += $sl_allowances->allowance_amount;
					}
				} else {
					$allowance_amount = 0;
				}
				
				// 3: all loan/deductions
				$salary_loan_deduction = $this->Employees_model->read_salary_loan_deductions($r->user_id);
				$count_loan_deduction = $this->Employees_model->count_employee_deductions($r->user_id);
				$loan_de_amount = 0;
				if($count_loan_deduction > 0) {
					foreach($salary_loan_deduction as $sl_salary_loan_deduction){
						$loan_de_amount += $sl_salary_loan_deduction->loan_deduction_amount;
					}
				} else {
					$loan_de_amount = 0;
				}
				
				// commissions
				$count_commissions = $this->Employees_model->count_employee_commissions($r->user_id);
				$commissions = $this->Employees_model->set_employee_commissions($r->user_id);
				$commissions_amount = 0;
				if($count_commissions > 0) {
					foreach($commissions->result() as $sl_salary_commissions){
						$commissions_amount += $sl_salary_commissions->commission_amount;
					}
				} else {
					$commissions_amount = 0;
				}
				// otherpayments
				$count_other_payments = $this->Employees_model->count_employee_other_payments($r->user_id);
				$other_payments = $this->Employees_model->set_employee_other_payments($r->user_id);
				$other_payments_amount = 0;
				if($count_other_payments > 0) {
					foreach($other_payments->result() as $sl_other_payments) {
						$other_payments_amount += $sl_other_payments->payments_amount;
					}
				} else {
					$other_payments_amount = 0;
				}
				// statutory_deductions
				$count_statutory_deductions = $this->Employees_model->count_employee_statutory_deductions($r->user_id);
				$statutory_deductions = $this->Employees_model->set_employee_statutory_deductions($r->user_id);
				$statutory_deductions_amount = 0;
				if($count_statutory_deductions > 0) {
					foreach($statutory_deductions->result() as $sl_salary_statutory_deductions){
						//$sta_salary = $allowance_amount + $basic_salary;
						//$st_amount = $sta_salary / 100 * $sl_statutory_deductions->deduction_amount;
						$statutory_deductions_amount += $sl_salary_statutory_deductions->deduction_amount;
					}
				} else {
					$statutory_deductions_amount = 0;
				}				
				
				// 5: overtime
				$salary_overtime = $this->Employees_model->read_salary_overtime($r->user_id);
				$count_overtime = $this->Employees_model->count_employee_overtime($r->user_id);
				$overtime_amount = 0;
				if($count_overtime > 0) {
					foreach($salary_overtime as $sl_overtime){
						$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
						$overtime_amount += $overtime_total;
					}
				} else {
					$overtime_amount = 0;
				}
				
				// add amount				
				$total_earning = $basic_salary + $allowance_amount + $overtime_amount + $commissions_amount + $other_payments_amount;
				$total_deduction = $loan_de_amount + $statutory_deductions_amount;
				$total_net_salary = $total_earning - $total_deduction;
				//if($r->salary_advance_paid == ''){
				//$data1 = $add_salary. ' - ' .$loan_de_amount. ' - ' .$net_salary . ' - ' .$salary_ssempee . ' - ' .$statutory_deductions;
				//$fnet_salary = $net_salary_default + $statutory_deductions;
			//	$net_salary = $fnet_salary - $loan_de_amount;
				$net_salary = number_format((float)$total_net_salary, 2, '.', '');
				
				//$allinfo = $basic_salary  .' - '.  $allowance_amount  .' - '.  $all_other_payment  .' - '.  $loan_de_amount  .' - '.  $overtime_amount  .' - '.  $statutory_deductions; // for testing purpose
				// make payment
				$payment_check = $this->Payroll_model->read_make_payment_payslip_check($r->user_id,$p_date);
				if($payment_check->num_rows() > 0){
					$make_payment = $this->Payroll_model->read_make_payment_payslip($r->user_id,$p_date);
					$status = '<span class="label label-success">'.$this->lang->line('xin_payroll_paid').'</span>';
					$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_view_payslip').'"><a href="'.site_url().'admin/payroll/payslip/id/'.$make_payment[0]->payslip_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$make_payment[0]->payslip_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span>';
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $make_payment[0]->payslip_id . '"><span class="fa fa-trash"></span></button></span>';
				} else {
					$status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
					$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_make_payment').'"><button type="button" class="btn icon-btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-employee_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-company_id="'.$this->input->get("company_id").'"><span class="fa fas fa-money"></span></button></span>';
					$delete = '';
				}
				
				//$basic_salary_cal = $basic_salary * $current_rate; 
			//	$net_salary_cal = $net_salary * $current_rate; 
				if($basic_salary == 0 || $basic_salary == '') {
					$fmpay = '';
				} else {
					$fmpay = $mpay;
				}
				$basic_salary = number_format((float)$basic_salary, 2, '.', '');
				$basic_salary = $this->Xin_model->currency_sign($basic_salary);
				$net_salary = $this->Xin_model->currency_sign($net_salary);
				
				//detail link
				$detail = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-employee_id="'. $r->user_id . '"><span class="fa fa-eye"></span></button></span>';
				$iemp_name = $emp_name.'<small class="text-muted"><i> ('.$comp_name.')<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_employees_id').': '.$r->employee_id.'<i></i></i></small>';
				
				//action link
				$act = $detail.$fmpay.$delete;
				$data[] = array(
					$act,
					$iemp_name,
					$wages_type,
					$basic_salary,
					$net_salary,
					$status
				);
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payslip->num_rows(),
                 "recordsFiltered" => $payslip->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // get payroll template info by id
	public function payroll_template_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
		// get addd by > template
		$user = $this->Xin_model->read_user_info($id);
		// user full name
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
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
		$data = array(
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'employee_id' => $user[0]->employee_id,
				'user_id' => $user[0]->user_id,
				'department_name' => $department_name,
				'designation_name' => $designation_name,
				'date_of_joining' => $user[0]->date_of_joining,
				'profile_picture' => $user[0]->profile_picture,
				'gender' => $user[0]->gender,
				'wages_type' => $user[0]->wages_type,
				'basic_salary' => $user[0]->basic_salary,
				'daily_wages' => $user[0]->daily_wages
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_templates', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// pay monthly > create payslip
	public function pay_salary()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
        // get addd by > template
		$user = $this->Xin_model->read_user_info($id);
		$result = $this->Payroll_model->read_template_information($user[0]->monthly_grade_id);
		//$department = $this->Department_model->read_department_information($user[0]->department_id);
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation)){
			$designation_id = $designation[0]->designation_id;
		} else {
			$designation_id = 1;	
		}
		// department
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$department_id = $department[0]->department_id;
		} else {
			$department_id = 1;	
		}
		//$location = $this->Location_model->read_location_information($department[0]->location_id);
		$data = array(
				'department_id' => $department_id,
				'designation_id' => $designation_id,
				'company_id' => $user[0]->company_id,
				'user_id' => $user[0]->user_id,
				'wages_type' => $user[0]->wages_type,
				'basic_salary' => $user[0]->basic_salary,
				'daily_wages' => $user[0]->daily_wages,
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_make_payment', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database > add monthly payment
	public function add_pay_monthly() {
	
		if($this->input->post('add_type')=='add_monthly_payment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
				
		/*if($Return['error']!=''){
       		$this->output($Return);
    	}*/
		$basic_salary = $this->input->post('basic_salary');
			
		$data = array(
		'employee_id' => $this->input->post('emp_id'),
		'department_id' => $this->input->post('department_id'),
		'company_id' => $this->input->post('company_id'),
		'designation_id' => $this->input->post('designation_id'),
		'salary_month' => $this->input->post('pay_date'),
		'basic_salary' => $basic_salary,
		'net_salary' => $this->input->post('net_salary'),
		'wages_type' => $this->input->post('wages_type'),
		'total_commissions' => $this->input->post('total_commissions'),
		'total_statutory_deductions' => $this->input->post('total_statutory_deductions'),
		'total_other_payments' => $this->input->post('total_other_payments'),
		'total_allowances' => $this->input->post('total_allowances'),
		'total_loan' => $this->input->post('total_loan'),
		'total_overtime' => $this->input->post('total_overtime'),
		'is_payment' => '1',
		'year_to_date' => date('d-m-Y'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Payroll_model->add_salary_payslip($data);	
		
		if ($result) {
			// set allowance
			$salary_allowances = $this->Employees_model->read_salary_allowances($this->input->post('emp_id'));
			$count_allowances = $this->Employees_model->count_employee_allowances($this->input->post('emp_id'));
			$allowance_amount = 0;
			if($count_allowances > 0) {
				foreach($salary_allowances as $sl_allowances){
					$allowance_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'allowance_title' => $sl_allowances->allowance_title,
					'allowance_amount' => $sl_allowances->allowance_amount,
					'created_at' => date('d-m-Y h:i:s')
					);
					$_allowance_data = $this->Payroll_model->add_salary_payslip_allowances($allowance_data);
				}
			}
			// set commissions
			$salary_commissions = $this->Employees_model->read_salary_commissions($this->input->post('emp_id'));
			$count_commission = $this->Employees_model->count_employee_commissions($this->input->post('emp_id'));
			$commission_amount = 0;
			if($count_commission > 0) {
				foreach($salary_commissions as $sl_commission){
					$commissions_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'commission_title' => $sl_commission->commission_title,
					'commission_amount' => $sl_commission->commission_amount,
					'created_at' => date('d-m-Y h:i:s')
					);
					$this->Payroll_model->add_salary_payslip_commissions($commissions_data);
				}
			}
			// set other payments
			$salary_other_payments = $this->Employees_model->read_salary_other_payments($this->input->post('emp_id'));
			$count_other_payment = $this->Employees_model->count_employee_other_payments($this->input->post('emp_id'));
			$other_payment_amount = 0;
			if($count_other_payment > 0) {
				foreach($salary_other_payments as $sl_other_payments){
					$other_payments_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'payments_title' => $sl_other_payments->payments_title,
					'payments_amount' => $sl_other_payments->payments_amount,
					'created_at' => date('d-m-Y h:i:s')
					);
					$this->Payroll_model->add_salary_payslip_other_payments($other_payments_data);
				}
			}
			// set statutory_deductions
			$salary_statutory_deductions = $this->Employees_model->read_salary_statutory_deductions($this->input->post('emp_id'));
			$count_statutory_deductions = $this->Employees_model->count_employee_statutory_deductions($this->input->post('emp_id'));
			$statutory_deductions_amount = 0;
			if($count_statutory_deductions > 0) {
				foreach($salary_statutory_deductions as $sl_statutory_deduction){
					$statutory_deduction_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'deduction_title' => $sl_statutory_deduction->deduction_title,
					'deduction_amount' => $sl_statutory_deduction->deduction_amount,
					'created_at' => date('d-m-Y h:i:s')
					);
					$this->Payroll_model->add_salary_payslip_statutory_deductions($statutory_deduction_data);
				}
			}
			// set loan
			$salary_loan_deduction = $this->Employees_model->read_salary_loan_deductions($this->input->post('emp_id'));
			$count_loan_deduction = $this->Employees_model->count_employee_deductions($this->input->post('emp_id'));
			$loan_de_amount = 0;
			if($count_loan_deduction > 0) {
				foreach($salary_loan_deduction as $sl_salary_loan_deduction){
					$loan_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'loan_title' => $sl_salary_loan_deduction->loan_deduction_title,
					'loan_amount' => $sl_salary_loan_deduction->loan_deduction_amount,
					'created_at' => date('d-m-Y h:i:s')
					);
					$_loan_data = $this->Payroll_model->add_salary_payslip_loan($loan_data);
				}
			}
			// set overtime
			$salary_overtime = $this->Employees_model->read_salary_overtime($this->input->post('emp_id'));
			$count_overtime = $this->Employees_model->count_employee_overtime($this->input->post('emp_id'));
			$overtime_amount = 0;
			if($count_overtime > 0) {
				foreach($salary_overtime as $sl_overtime){
					//$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
					$overtime_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'overtime_salary_month' => $this->input->post('pay_date'),
					'overtime_title' => $sl_overtime->overtime_type,
					'overtime_no_of_days' => $sl_overtime->no_of_days,
					'overtime_hours' => $sl_overtime->overtime_hours,
					'overtime_rate' => $sl_overtime->overtime_rate,
					'created_at' => date('d-m-Y h:i:s')
					);
					$_overtime_data = $this->Payroll_model->add_salary_payslip_overtime($overtime_data);
				}
			}
			
		$Return['result'] = $this->lang->line('xin_success_payment_paid');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database > add monthly payment
	public function add_pay_to_all() {
	
		if($this->input->post('add_type')=='payroll') {		
		$result = $this->Xin_model->all_employees();
		foreach($result as $empid) {
			$user_id = $empid->user_id;
			$user = $this->Xin_model->read_user_info($user_id);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($empid->wages_type==1){
			$basic_salary = $empid->basic_salary;
		} else {
			$basic_salary = $empid->daily_wages;
		}
		if($basic_salary > 0) {
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation)){
			$designation_id = $designation[0]->designation_id;
		} else {
			$designation_id = 1;	
		}
		// department
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$department_id = $department[0]->department_id;
		} else {
			$department_id = 1;	
		}
		
		$salary_allowances = $this->Employees_model->read_salary_allowances($user_id);
		$count_allowances = $this->Employees_model->count_employee_allowances($user_id);
		$allowance_amount = 0;
		if($count_allowances > 0) {
			foreach($salary_allowances as $sl_allowances){
				$allowance_amount += $sl_allowances->allowance_amount;
			}
		} else {
			$allowance_amount = 0;
		}
		// 3: all loan/deductions
		$salary_loan_deduction = $this->Employees_model->read_salary_loan_deductions($user_id);
		$count_loan_deduction = $this->Employees_model->count_employee_deductions($user_id);
		$loan_de_amount = 0;
		if($count_loan_deduction > 0) {
			foreach($salary_loan_deduction as $sl_salary_loan_deduction){
				$loan_de_amount += $sl_salary_loan_deduction->loan_deduction_amount;
			}
		} else {
			$loan_de_amount = 0;
		}
		
		
		// 5: overtime
		$salary_overtime = $this->Employees_model->read_salary_overtime($user_id);
		$count_overtime = $this->Employees_model->count_employee_overtime($user_id);
		$overtime_amount = 0;
		if($count_overtime > 0) {
			foreach($salary_overtime as $sl_overtime){
				$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
				$overtime_amount += $overtime_total;
			}
		} else {
			$overtime_amount = 0;
		}
		
		
		
		// 6: statutory deductions
		// 4: other payment
		$other_payments = $this->Employees_model->set_employee_other_payments($user_id);
		$other_payments_amount = 0;
		if(!is_null($other_payments)):
			foreach($other_payments->result() as $sl_other_payments) {
				$other_payments_amount += $sl_other_payments->payments_amount;
			}
		endif;
		// all other payment
		$all_other_payment = $other_payments_amount;
		// 5: commissions
		$commissions = $this->Employees_model->set_employee_commissions($user_id);
		if(!is_null($commissions)):
			$commissions_amount = 0;
			foreach($commissions->result() as $sl_commissions) {
				$commissions_amount += $sl_commissions->commission_amount;
			}
		endif;
		// 6: statutory deductions
		$statutory_deductions = $this->Employees_model->set_employee_statutory_deductions($user_id);
		if(!is_null($statutory_deductions)):
			$statutory_deductions_amount = 0;
			foreach($statutory_deductions->result() as $sl_statutory_deductions) {
				//$sta_salary = $allowance_amount + $basic_salary;
				$st_amount = $sl_statutory_deductions->deduction_amount;
				$statutory_deductions_amount += $sl_statutory_deductions->deduction_amount;
			}
		endif;
		
		// add amount
		$add_salary = $allowance_amount + $basic_salary + $overtime_amount + $other_payments_amount + $commissions_amount;
		// add amount
		$net_salary_default = $add_salary - $loan_de_amount - $statutory_deductions_amount;
		$net_salary = $net_salary_default;
		$net_salary = number_format((float)$net_salary, 2, '.', '');
			
		$data = array(
		'employee_id' => $user_id,
		'department_id' => $department_id,
		'company_id' => $user[0]->company_id,
		'designation_id' => $designation_id,
		'salary_month' => $this->input->post('month_year'),
		'basic_salary' => $basic_salary,
		'net_salary' => $net_salary,
		'wages_type' => $empid->wages_type,
		
		'total_allowances' => $allowance_amount,
		'total_loan' => $loan_de_amount,
		'total_overtime' => $overtime_amount,
		'total_commissions' => $commissions_amount,
		'total_statutory_deductions' => $statutory_deductions_amount,
		'total_other_payments' => $other_payments_amount,
		'is_payment' => '1',
		'year_to_date' => date('d-m-Y'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Payroll_model->add_salary_payslip($data);	
		
		if ($result) {
			$salary_allowances = $this->Employees_model->read_salary_allowances($user_id);
			$count_allowances = $this->Employees_model->count_employee_allowances($user_id);
			$allowance_amount = 0;
			if($count_allowances > 0) {
				foreach($salary_allowances as $sl_allowances){
					$allowance_data = array(
					'payslip_id' => $result,
					'employee_id' => $user_id,
					'salary_month' => $this->input->post('month_year'),
					'allowance_title' => $sl_allowances->allowance_title,
					'allowance_amount' => $sl_allowances->allowance_amount,
					'created_at' => date('d-m-Y h:i:s')
					);
					$_allowance_data = $this->Payroll_model->add_salary_payslip_allowances($allowance_data);
				}
			}
			// set commissions
		$salary_commissions = $this->Employees_model->read_salary_commissions($user_id);
		$count_commission = $this->Employees_model->count_employee_commissions($user_id);
		$commission_amount = 0;
		if($count_commission > 0) {
			foreach($salary_commissions as $sl_commission){
				$commissions_data = array(
				'payslip_id' => $result,
				'employee_id' => $user_id,
				'salary_month' => $this->input->post('month_year'),
				'commission_title' => $sl_commission->commission_title,
				'commission_amount' => $sl_commission->commission_amount,
				'created_at' => date('d-m-Y h:i:s')
				);
				$this->Payroll_model->add_salary_payslip_commissions($commissions_data);
			}
		}
		// set other payments
		$salary_other_payments = $this->Employees_model->read_salary_other_payments($user_id);
		$count_other_payment = $this->Employees_model->count_employee_other_payments($user_id);
		$other_payment_amount = 0;
		if($count_other_payment > 0) {
			foreach($salary_other_payments as $sl_other_payments){
				$other_payments_data = array(
				'payslip_id' => $result,
				'employee_id' => $user_id,
				'salary_month' => $this->input->post('month_year'),
				'payments_title' => $sl_other_payments->payments_title,
				'payments_amount' => $sl_other_payments->payments_amount,
				'created_at' => date('d-m-Y h:i:s')
				);
				$this->Payroll_model->add_salary_payslip_other_payments($other_payments_data);
			}
		}
		// set statutory_deductions
		$salary_statutory_deductions = $this->Employees_model->read_salary_statutory_deductions($user_id);
		$count_statutory_deductions = $this->Employees_model->count_employee_statutory_deductions($user_id);
		$statutory_deductions_amount = 0;
		if($count_statutory_deductions > 0) {
			foreach($salary_statutory_deductions as $sl_statutory_deduction){
				$statutory_deduction_data = array(
				'payslip_id' => $result,
				'employee_id' => $user_id,
				'salary_month' => $this->input->post('month_year'),
				'deduction_title' => $sl_statutory_deduction->deduction_title,
				'deduction_amount' => $sl_statutory_deduction->deduction_amount,
				'created_at' => date('d-m-Y h:i:s')
				);
				$this->Payroll_model->add_salary_payslip_statutory_deductions($statutory_deduction_data);
			}
		}
		$salary_loan_deduction = $this->Employees_model->read_salary_loan_deductions($user_id);
			$count_loan_deduction = $this->Employees_model->count_employee_deductions($user_id);
			$loan_de_amount = 0;
			if($count_loan_deduction > 0) {
				foreach($salary_loan_deduction as $sl_salary_loan_deduction){
					$loan_data = array(
					'payslip_id' => $result,
					'employee_id' => $user_id,
					'salary_month' => $this->input->post('month_year'),
					'loan_title' => $sl_salary_loan_deduction->loan_deduction_title,
					'loan_amount' => $sl_salary_loan_deduction->loan_deduction_amount,
					'created_at' => date('d-m-Y h:i:s')
					);
					$_loan_data = $this->Payroll_model->add_salary_payslip_loan($loan_data);
				}
			}
			$salary_overtime = $this->Employees_model->read_salary_overtime($user_id);
			$count_overtime = $this->Employees_model->count_employee_overtime($user_id);
			$overtime_amount = 0;
			if($count_overtime > 0) {
				foreach($salary_overtime as $sl_overtime){
					//$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
					$overtime_data = array(
					'payslip_id' => $result,
					'employee_id' => $user_id,
					'overtime_salary_month' => $this->input->post('month_year'),
					'overtime_title' => $sl_overtime->overtime_type,
					'overtime_no_of_days' => $sl_overtime->no_of_days,
					'overtime_hours' => $sl_overtime->overtime_hours,
					'overtime_rate' => $sl_overtime->overtime_rate,
					'created_at' => date('d-m-Y h:i:s')
					);
					$_overtime_data = $this->Payroll_model->add_salary_payslip_overtime($overtime_data);
				}
			}
			
			$Return['result'] = $this->lang->line('xin_success_payment_paid');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		
		} // if basic salary
		}
		$Return['result'] = $this->lang->line('xin_success_payment_paid');
		$this->output($Return);
		exit;
		} // f
	}
	
	// hourly_list > templates
	 public function payment_history_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/payment_history", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('391',$role_resources_ids)) {
			$history = $this->Payroll_model->employees_payment_history();
		} else {
			$history = $this->Payroll_model->get_payroll_slip($session['user_id']);
		}
		$data = array();

          foreach($history->result() as $r) {

			// get addd by > template
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			$emp_link = $user[0]->employee_id;			  		  
			$month_payment = date("F, Y", strtotime($r->salary_month));
			
			$p_amount = $this->Xin_model->currency_sign($r->net_salary);
			
			// get date > created at > and format
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			
			$payslip = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->payslip_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span>';
			
		$ifull_name = $full_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_employees_id').': '.$emp_link.'<i></i></i></small>';
               $data[] = array(
					$payslip,
                    $ifull_name,
                    $p_amount,
                    $month_payment,
                    $created_at,
               );
          }
		  } // if employee available

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
	 public function payslip()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		//$data['title'] = $this->Xin_model->site_title();
		$payment_id = $this->uri->segment(5);
		
		$result = $this->Payroll_model->read_salary_payslip_info($payment_id);
		/*if(is_null($result)){
			redirect('admin/payroll/payment_history');
		}*/
		$p_method = '';
		$payment_method = $this->Xin_model->read_payment_method($result[0]->payment_method);
		if(!is_null($payment_method)){
		  $p_method = $payment_method[0]->method_name;
		} else {
		  $p_method = '--';
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
				'make_payment_id' => $result[0]->payslip_id,
				'wages_type' => $result[0]->wages_type,
				'payment_date' => $result[0]->salary_month,
				'basic_salary' => $result[0]->basic_salary,
				'daily_wages' => $result[0]->daily_wages,
				'payment_method' => $p_method,				
				'total_allowances' => $result[0]->total_allowances,
				'total_loan' => $result[0]->total_loan,
				'total_overtime' => $result[0]->total_overtime,
				'total_commissions' => $result[0]->total_commissions,
				'total_statutory_deductions' => $result[0]->total_statutory_deductions,
				'total_other_payments' => $result[0]->total_other_payments,
				'net_salary' => $result[0]->net_salary,
				'other_payment' => $result[0]->other_payment,
				'pay_comments' => $result[0]->pay_comments,
				'is_payment' => $result[0]->is_payment,
				);
		$data['breadcrumbs'] = $this->lang->line('xin_payroll_employee_payslip');
		$data['path_url'] = 'payslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
		$data['subview'] = $this->load->view("admin/payroll/payslip", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
     }
	 
	 public function pddf_create() {
		 
		//$this->load->library('Pdf');
		$system = $this->Xin_model->read_setting_info(1);
		
		
		
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$id = $this->uri->segment(5);
		$payment = $this->Payroll_model->read_payslip_information($id);
		$user = $this->Xin_model->read_user_info($payment[0]->employee_id);
		
		// if password generate option enable
		if($system[0]->is_payslip_password_generate==1) {
			/**
			* Protect PDF from being printed, copied or modified. In order to being viewed, the user needs
			* to provide password as selected format in settings module.
			*/
			if($system[0]->payslip_password_format=='dateofbirth') {
				$password_val = date("dmY", strtotime($user[0]->date_of_birth));
			} else if($system[0]->payslip_password_format=='contact_no') {
				$password_val = $user[0]->contact_no;
			} else if($system[0]->payslip_password_format=='full_name') {
				$password_val = $user[0]->first_name.$user[0]->last_name;
			} else if($system[0]->payslip_password_format=='email') {
				$password_val = $user[0]->email;
			} else if($system[0]->payslip_password_format=='password') {
				$password_val = $user[0]->password;
			} else if($system[0]->payslip_password_format=='user_password') {
				$password_val = $user[0]->username.$user[0]->password;
			} else if($system[0]->payslip_password_format=='employee_id') {
				$password_val = $user[0]->employee_id;
			} else if($system[0]->payslip_password_format=='employee_id_password') {
				$password_val = $user[0]->employee_id.$user[0]->password;
			} else if($system[0]->payslip_password_format=='dateofbirth_name') {
				$dob = date("dmY", strtotime($user[0]->date_of_birth));
				$fname = $user[0]->first_name;
				$lname = $user[0]->last_name;
				$password_val = $dob.$fname[0].$lname[0];
			}
			$pdf->SetProtection(array('print', 'copy','modify'), $password_val, $password_val, 0, null);
		}
		
		
		$_des_name = $this->Designation_model->read_designation_information($user[0]->designation_id);
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		//$location = $this->Xin_model->read_location_info($department[0]->location_id);
		// company info
		$company = $this->Xin_model->read_company_info($user[0]->company_id);
		
		
		$p_method = '';
		/*$payment_method = $this->Xin_model->read_payment_method($payment[0]->payment_method);
		if(!is_null($payment_method)){
		  $p_method = $payment_method[0]->method_name;
		} else {
		  $p_method = '--';
		}*/
		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		if(!is_null($company)){
		  $company_name = $company[0]->name;
		  $address_1 = $company[0]->address_1;
		  $address_2 = $company[0]->address_2;
		  $city = $company[0]->city;
		  $state = $company[0]->state;
		  $zipcode = $company[0]->zipcode;
		  $country = $this->Xin_model->read_country_info($company[0]->country);
		  if(!is_null($country)){
			  $country_name = $country[0]->country_name;
		  } else {
			  $country_name = '--';
		  }
		  $c_info_email = $company[0]->email;
		  $c_info_phone = $company[0]->contact_number;
		} else {
		  $company_name = '--';
		  $address_1 = '--';
		  $address_2 = '--';
		  $city = '--';
		  $state = '--';
		  $zipcode = '--';
		  $country_name = '--';
		  $c_info_email = '--';
		  $c_info_phone = '--';
		}
		
		// set default header data
		
		
		
		$c_info_address = $address_1.' '.$address_2.', '.$city.' - '.$zipcode.', '.$country_name;
		$email_phone_address = "".$this->lang->line('dashboard_email')." : $c_info_email | ".$this->lang->line('xin_phone')." : $c_info_phone \n".$this->lang->line('xin_address').": $c_info_address";
		$header_string = $email_phone_address;
		
		
		// set document information
		$pdf->SetCreator('HRSALE');
		$pdf->SetAuthor('HRSALE');
		//$pdf->SetTitle('Workable-Zone - Payslip');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		//$pdf->SetHeaderData('../../../uploads/logo/payroll/'.$system[0]->payroll_logo, 40, $company_name, $header_string);
			
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		
		// set margins
		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);
		
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor($company_name);
		$pdf->SetTitle($company_name.' - '.$this->lang->line('xin_print_payslip'));
		$pdf->SetSubject($this->lang->line('xin_payslip'));
		$pdf->SetKeywords($this->lang->line('xin_payslip'));
		// set font
		$pdf->SetFont('helvetica', 'B', 10);
				
		// set header and footer fonts
	//	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		
		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 8, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
		
		// set text shadow effect
		$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		
		// -----------------------------------------------------------------------------
		$clogo = base_url().'uploads/logo/payroll/'.$system[0]->payroll_logo;
		$fname = $user[0]->first_name.' '.$user[0]->last_name;
		$created_at = $this->Xin_model->set_date_format($payment[0]->created_at);
		$date_of_joining = $this->Xin_model->set_date_format($user[0]->date_of_joining);
		$salary_month = $this->Xin_model->set_date_format($payment[0]->salary_month);
		// basic salary
		$bs=0;
		if($payment[0]->basic_salary != '') {
			$bs = $payment[0]->basic_salary;
		} else {
			$bs = $payment[0]->daily_wages;
		}
		//
		$tbl = '<div style="border:1px solid #ccc; padding:2px; border-bottom: 2px solid #000;"><table cellpadding="5" cellspacing="0" border="0">
			<tr>
			<td rowspan="5" valign="middle"><img src="'.$clogo.'" width="80" height="80" /></td>
			<td valign="top"><strong>'.$this->lang->line('xin_payroll_pdf_co_name').'</strong><br /><br /><br /> <strong>'.$this->lang->line('xin_payroll_pdf_emp_code').'</strong> <br /> <strong>'.$this->lang->line('xin_payroll_pdf_emp_name').'</strong> <br /> <strong>'.$this->lang->line('xin_payroll_pdf_emp_address').'</strong></td>
			<td valign="top">'.$company_name.' <br/> <br /><br />'.$user[0]->employee_id.' <br />'.$fname.' <br />'.$user[0]->address.'</td>
			
			<td valign="top"><strong>'.$this->lang->line('xin_payroll_pdf_pay_date').'</strong><br /><br /> <br /><strong>'.$this->lang->line('xin_payroll_pdf_dt_engage').'</strong> <br /><strong>'.$this->lang->line('xin_payroll_pdf_emp_salary_month').'</strong></td>
			<td valign="top">'.$created_at.' <br/> <br /><br />'.$date_of_joining.' <br />'.$salary_month.'</td>
			</tr>
		</table></div>
		<br /><br />';
		// allowances
		$count_allowances = $this->Employees_model->count_employee_allowances_payslip($payment[0]->payslip_id);
		$allowances = $this->Employees_model->set_employee_allowances_payslip($payment[0]->payslip_id);
		// commissions
		$count_commissions = $this->Employees_model->count_employee_commissions_payslip($payment[0]->payslip_id);
		$commissions = $this->Employees_model->set_employee_commissions_payslip($payment[0]->payslip_id);
		// otherpayments
		$count_other_payments = $this->Employees_model->count_employee_other_payments_payslip($payment[0]->payslip_id);
		$other_payments = $this->Employees_model->set_employee_other_payments_payslip($payment[0]->payslip_id);
		// statutory_deductions
		$count_statutory_deductions = $this->Employees_model->count_employee_statutory_deductions_payslip($payment[0]->payslip_id);
		$statutory_deductions = $this->Employees_model->set_employee_statutory_deductions_payslip($payment[0]->payslip_id);
		// overtime
		$count_overtime = $this->Employees_model->count_employee_overtime_payslip($payment[0]->payslip_id);
        $overtime = $this->Employees_model->set_employee_overtime_payslip($payment[0]->payslip_id);
		// loan
		$count_loan = $this->Employees_model->count_employee_deductions_payslip($payment[0]->payslip_id);
		$loan = $this->Employees_model->set_employee_deductions_payslip($payment[0]->payslip_id);
		$statutory_deduction_amount = 0; $loan_de_amount = 0; $allowances_amount = 0;
		$commissions_amount = 0; $other_payments_amount = 0; $overtime_amount = 0;
		$tbl .= '<table cellpadding="5" cellspacing="0" border="0">
	<tr style="height:17px;">
							<td style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;text-decoration:underline;min-width:50px">
								<nobr>EARNINGS</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;text-decoration:underline;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;text-decoration:underline;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;text-decoration:underline;min-width:50px">
								<nobr>DEDUCTIONS</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
						</tr>
						<tr style="height:17px;">
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
								<nobr>'.$this->lang->line('xin_payroll_gross_salary').'</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
								<nobr>'.number_format($bs, 2, '.', ',').'</nobr>
							</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
								';
								if($count_loan > 0):
								$tbl .= '<nobr>'.$this->lang->line('xin_employee_set_loan_deductions').'</nobr>';
								endif;
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';
								if($count_loan > 0):
								foreach($loan->result() as $r_loan) {
									$loan_de_amount += $r_loan->loan_amount;
								}	
								$tbl .= '<nobr>('.number_format($loan_de_amount, 2, '.', ',').')</nobr>';
								else:
								$loan_de_amount = 0;
								endif;
							$tbl .= '
							</td>
						</tr>
						<tr style="height:17px;">
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
							if($count_allowances > 0):
								$tbl .= '<nobr>'.$this->lang->line('xin_employee_set_allowances').'</nobr>';
								endif;
							$tbl .= '	
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
								';
								if($count_allowances > 0):
								foreach($allowances->result() as $r_allowances) {
									$allowances_amount += $r_allowances->allowance_amount;
								}	
								$tbl .= '<nobr>('.number_format($allowances_amount, 2, '.', ',').')</nobr>';
								else:
								$allowances_amount = 0;
								endif;
							$tbl .= '</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
								';
								if($count_statutory_deductions > 0):
								$tbl .= '<nobr>'.$this->lang->line('xin_employee_set_statutory_deductions').'</nobr>';
								endif;
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';
								if($count_statutory_deductions > 0):
								foreach($statutory_deductions->result() as $r_statutory_deductions) {
									//$sta_salary = $allowances_amount + $bs;
									$st_amount = $r_statutory_deductions->deduction_amount;
									$statutory_deduction_amount += $r_statutory_deductions->deduction_amount;
								}	
								$tbl .= '<nobr>('.number_format($statutory_deduction_amount, 2, '.', ',').')</nobr>';
								else:
								$statutory_deduction_amount = 0;
								endif;
							$tbl .= '
							</td>
						</tr>
						<tr style="height:17px;">
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
								if($count_commissions > 0):
								$tbl .= '<nobr>'.$this->lang->line('xin_hr_commissions').'</nobr>';
								endif;
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';
								if($count_commissions > 0):
								foreach($commissions->result() as $r_commissions) {
									$commissions_amount += $r_commissions->commission_amount;
								}	
								$tbl .= '<nobr>('.number_format($commissions_amount, 2, '.', ',').')</nobr>';
								else:
								$commissions_amount = 0;
								endif;
							$tbl .= '</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
								';
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
							$tbl .= '
							</td>
						</tr>
						<tr style="height:17px;">
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
								if($count_other_payments > 0):
								$tbl .= '<nobr>'.$this->lang->line('xin_employee_set_other_payment').'</nobr>';
								endif;
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
								';
								if($count_other_payments > 0):
								foreach($other_payments->result() as $r_other_payments) {
									$other_payments_amount += $r_other_payments->payments_amount;
								}	
								$tbl .= '<nobr>('.number_format($other_payments_amount, 2, '.', ',').')</nobr>';
								else:
								$other_payments_amount = 0;
								endif;
							$tbl .= '</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
								';
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
							$tbl .= '
							</td>
						</tr>
						<tr style="height:17px;">
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
								if($count_overtime > 0):
								$tbl .= '<nobr>'.$this->lang->line('dashboard_overtime').'</nobr>';
								endif;
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
								';
								if($count_overtime > 0):
								foreach($overtime->result() as $r_overtime) {
									$overtime_total = $r_overtime->overtime_hours * $r_overtime->overtime_rate;
									$overtime_amount += $overtime_total;
								}	
								$tbl .= '<nobr>('.number_format($overtime_amount, 2, '.', ',').')</nobr>';
								else:
								$overtime_amount = 0;
								endif;
							$tbl .= '</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
								';
							$tbl .= '</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
							$tbl .= '
							</td>
						</tr>
						<tr style="height:17px;">
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;min-width:50px">';
							$tbl .= '	
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
								$i=1;								
								$total_earning = $bs + $allowances_amount + $overtime_amount + $commissions_amount + $other_payments_amount;
								$total_deduction = $loan_de_amount + $statutory_deduction_amount;
								$total_net_salary = $total_earning - $total_deduction;
							$tbl .= '</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
								</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
						</tr>
						<tr style="height:17px;">
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
						</tr>
						<tr style="height:18px;">
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
						</tr>
						
						<tr style="height:18px;">
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>TOTAL EARNING</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="text-align:right;font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>'.number_format($total_earning, 2, '.', ',').'</nobr>
							</td>
							<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>TOTAL DEDUCTIONS</nobr>
							</td>
							<td style="font-family:Calibri;font-size:10px;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="text-align:right;font-family:Calibri;font-size:10px;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
								<nobr>'.number_format($total_deduction, 2, '.', ',').'</nobr>
							</td>
						</tr>
						<tr style="height:17px;">
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
						</tr>
						<tr style="height:22px;">
							<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td colspan="3" style="font-family:Arial;font-size:12px;font-weight:bold;border-bottom:1px solid #000000;border-top:1px solid #000000;min-width:50px">
								<nobr>TOTAL NETT SALARY</nobr>
							</td>
							<td style="text-align:right;font-family:Arial;font-size:12px;font-weight:bold;border-bottom:1px solid #000000;border-top:1px solid #000000;min-width:50px">
								<nobr>'.number_format($total_net_salary, 2, '.', ',').'</nobr>
							</td>
						</tr>
						<tr style="height:17px;">
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
							<td style="min-width:50px">
								<nobr>&nbsp;</nobr>
							</td>
						</tr>
						</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');		
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y", strtotime($payment[0]->salary_month)));
		//Close and output PDF document
		ob_start();
		$pdf->Output('payslip_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
		//$pdf->Output('payslip_'.$fname.'_'.$pay_month.'.pdf', 'D');
		
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
			$this->load->view("admin/payroll/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }  
	 
	// make payment info by id
	public function make_payment_view()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('pay_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->read_make_payment_information($id);
		// get addd by > template
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
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
		
		$data = array(
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'employee_id' => $user[0]->employee_id,
				'department_name' => $department_name,
				'designation_name' => $designation_name,
				'date_of_joining' => $user[0]->date_of_joining,
				'profile_picture' => $user[0]->profile_picture,
				'gender' => $user[0]->gender,
				'monthly_grade_id' => $user[0]->monthly_grade_id,
				'hourly_grade_id' => $user[0]->hourly_grade_id,
				'basic_salary' => $result[0]->basic_salary,
				'payment_date' => $result[0]->payment_date,
				'payment_method' => $result[0]->payment_method,
				'overtime_rate' => $result[0]->overtime_rate,
				'hourly_rate' => $result[0]->hourly_rate,
				'total_hours_work' => $result[0]->total_hours_work,
				'is_payment' => $result[0]->is_payment,
				'is_advance_salary_deduct' => $result[0]->is_advance_salary_deduct,
				'advance_salary_amount' => $result[0]->advance_salary_amount,
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
				'payment_amount' => $result[0]->payment_amount,
				'comments' => $result[0]->comments,
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_payslip', $data);
		} else {
			redirect('admin/');
		}
	}
	public function payslip_delete() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Payroll_model->delete_record($id);
		if(isset($id)) {
			$this->Payroll_model->delete_payslip_allowances_items($id);
			$this->Payroll_model->delete_payslip_commissions_items($id);
			$this->Payroll_model->delete_payslip_other_payment_items($id);
			$this->Payroll_model->delete_payslip_statutory_deductions_items($id);
			$this->Payroll_model->delete_payslip_overtime_items($id);
			$this->Payroll_model->delete_payslip_loan_items($id);
			$Return['result'] = $this->lang->line('xin_hr_payslip_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
