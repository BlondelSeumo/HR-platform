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
		$this->load->model("Timesheet_model");
		$this->load->model("Overtime_request_model");
		$this->load->model("Company_model");
		$this->load->model("Finance_model");
		$this->load->helper('string');
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
		$data['title'] = $this->lang->line('left_payroll').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_payroll');
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
		$data['title'] = $this->lang->line('xin_payslip_history');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('xin_payslip_history');
		$data['path_url'] = 'payment_history';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
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
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){
			if($this->input->get("employee_id")==0 && $this->input->get("company_id")==0) {
				$payslip = $this->Employees_model->get_employees_payslip();
			} else if($this->input->get("employee_id")==0 && $this->input->get("company_id")!=0) {
				$payslip = $this->Payroll_model->get_comp_template($this->input->get("company_id"),0);
			} else if($this->input->get("employee_id")!=0 && $this->input->get("company_id")!=0) {
				$payslip = $this->Payroll_model->get_employee_comp_template($this->input->get("company_id"),$this->input->get("employee_id"));
			} else {
				$payslip = $this->Employees_model->get_employees_payslip();
			}
		} else {
			$payslip = $this->Payroll_model->get_employee_comp_template($user_info[0]->company_id,$session['user_id']);
		}
		$system = $this->Xin_model->read_setting_info(1);		
		$data = array();

        foreach($payslip->result() as $r) {
			  // user full name
			$emp_name = $r->first_name.' '.$r->last_name;
			$full_name = '<a target="_blank" class="text-primary" href="'.site_url().'admin/employees/detail/'.$r->user_id.'">'.$emp_name.'</a>';
			
			// get total hours > worked > employee
			$pay_date = $this->input->get('month_year');
			//overtime request
			$overtime_count = $this->Overtime_request_model->get_overtime_request_count($r->user_id,$this->input->get('month_year'));
			$re_hrs_old_int1 = 0;
			$re_hrs_old_seconds =0;
			$re_pcount = 0;
			foreach ($overtime_count as $overtime_hr){
				// total work			
				$request_clock_in =  new DateTime($overtime_hr->request_clock_in);
				$request_clock_out =  new DateTime($overtime_hr->request_clock_out);
				$re_interval_late = $request_clock_in->diff($request_clock_out);
				$re_hours_r  = $re_interval_late->format('%h');
				$re_minutes_r = $re_interval_late->format('%i');			
				$re_total_time = $re_hours_r .":".$re_minutes_r.":".'00';
				
				$re_str_time = $re_total_time;
			
				$re_str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $re_str_time);
				
				sscanf($re_str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$re_hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$re_hrs_old_int1 += $re_hrs_old_seconds;
				
				$re_pcount = gmdate("H", $re_hrs_old_int1);			
			}	
			$result = $this->Payroll_model->total_hours_worked($r->user_id,$pay_date);
			$hrs_old_int1 = 0;
			$pcount = 0;
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
				
				$pcount = gmdate("H", $hrs_old_int1);			
			}
			$pcount = $pcount + $re_pcount;
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
					if($system[0]->is_half_monthly==1){
						$basic_salary = $r->basic_salary / 2;
					} else {
						$basic_salary = $r->basic_salary;
					}
					$p_class = 'emo_monthly_pay';
					$view_p_class = 'payroll_template_modal';
				} else if($r->wages_type==2){
					$wages_type = $this->lang->line('xin_employee_daily_wages');
					if($pcount > 0){
						$basic_salary = $pcount * $r->basic_salary;
					} else {
						$basic_salary = $pcount;
					}
					$p_class = 'emo_hourly_pay';
					$view_p_class = 'hourlywages_template_modal';
				} else {
					$wages_type = $this->lang->line('xin_payroll_basic_salary');
					if($system[0]->is_half_monthly==1){
						$basic_salary = $r->basic_salary / 2;
					} else {
						$basic_salary = $r->basic_salary;
					}
					$p_class = 'emo_monthly_pay';
					$view_p_class = 'payroll_template_modal';
					
				}				
				// 2: all allowances
				$salary_allowances = $this->Employees_model->read_salary_allowances($r->user_id);
				$count_allowances = $this->Employees_model->count_employee_allowances($r->user_id);
				$allowance_amount = 0;
				if($count_allowances > 0) {
					foreach($salary_allowances as $sl_allowances){
						if($system[0]->is_half_monthly==1){
					  	 if($system[0]->half_deduct_month==2){
							 $eallowance_amount = $sl_allowances->allowance_amount/2;
						 } else {
							 $eallowance_amount = $sl_allowances->allowance_amount;
						 }
                      } else {
						  $eallowance_amount = $sl_allowances->allowance_amount;
                      }
					  $allowance_amount += $eallowance_amount;
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
						if($system[0]->is_half_monthly==1){
					  	  if($system[0]->half_deduct_month==2){
							  $er_loan = $sl_salary_loan_deduction->loan_deduction_amount/2;
						  } else {
							  $er_loan = $sl_salary_loan_deduction->loan_deduction_amount;
						  }
                      } else {
						  $er_loan = $sl_salary_loan_deduction->loan_deduction_amount;
                      }
					  $loan_de_amount += $er_loan;
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
						if($system[0]->is_half_monthly==1){
					  	  if($system[0]->half_deduct_month==2){
							  $ecommissions_amount = $sl_salary_commissions->commission_amount/2;
						  } else {
							  $ecommissions_amount = $sl_salary_commissions->commission_amount;
						  }
                      } else {
						  $ecommissions_amount = $sl_salary_commissions->commission_amount;
                      }
					  $commissions_amount += $ecommissions_amount;
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
						if($system[0]->is_half_monthly==1){
					  	  if($system[0]->half_deduct_month==2){
							  $epayments_amount = $sl_other_payments->payments_amount/2;
						  } else {
							  $epayments_amount = $sl_other_payments->payments_amount;
						  }
                      } else {
						  $epayments_amount = $sl_other_payments->payments_amount;
                      }
					  $other_payments_amount += $epayments_amount;
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
						if($system[0]->statutory_fixed!='yes'):
							$sta_salary = $basic_salary;
							$st_amount = $sta_salary / 100 * $sl_salary_statutory_deductions->deduction_amount;
							if($system[0]->is_half_monthly==1){
								   if($system[0]->half_deduct_month==2){
									   $single_sd = $st_amount/2;
								   } else {
									   $single_sd = $st_amount;
								   }
							  } else {
								  $single_sd = $st_amount;
							  }
							  $statutory_deductions_amount += $single_sd;
						else:
							if($system[0]->is_half_monthly==1){
								  if($system[0]->half_deduct_month==2){
									  $single_sd = $sl_salary_statutory_deductions->deduction_amount/2;
								  } else {
									   $single_sd = $sl_salary_statutory_deductions->deduction_amount;
								  }
							  } else {
								  $single_sd = $sl_salary_statutory_deductions->deduction_amount;
							  }
							  $statutory_deductions_amount += $single_sd;
						endif;
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
						if($system[0]->is_half_monthly==1){
							if($system[0]->half_deduct_month==2){
								$eovertime_hours = $sl_overtime->overtime_hours/2;
								$eovertime_rate = $sl_overtime->overtime_rate/2;
							} else {
								$eovertime_hours = $sl_overtime->overtime_hours;
								$eovertime_rate = $sl_overtime->overtime_rate;
							}
						} else {
							$eovertime_hours = $sl_overtime->overtime_hours;
							$eovertime_rate = $sl_overtime->overtime_rate;
						}
						$overtime_total = $eovertime_hours * $eovertime_rate;
						//$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
						$overtime_amount += $overtime_total;
					}
				} else {
					$overtime_amount = 0;
				}
				
				
				
				//$allinfo = $basic_salary  .' - '.  $allowance_amount  .' - '.  $all_other_payment  .' - '.  $loan_de_amount  .' - '.  $overtime_amount  .' - '.  $statutory_deductions; // for testing purpose
				// make payment
				if($system[0]->is_half_monthly==1){
					$payment_check = $this->Payroll_model->read_make_payment_payslip_half_month_check($r->user_id,$p_date);
					$payment_last = $this->Payroll_model->read_make_payment_payslip_half_month_check_last($r->user_id,$p_date);
					if($payment_check->num_rows() > 1) {
						//foreach($payment_last as $payment_half_last){
							$make_payment = $this->Payroll_model->read_make_payment_payslip($r->user_id,$p_date);
							$view_url = site_url().'admin/payroll/payslip/id/'.$make_payment[0]->payslip_key;
							
							$status = '<span class="label label-success">'.$this->lang->line('xin_payroll_paid').'</span>';
							//$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_make_payment').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-employee_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-company_id="'.$this->input->get("company_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
							$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_view_payslip').'"><a href="'.$view_url.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$make_payment[0]->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
							if(in_array('313',$role_resources_ids)){
							$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $make_payment[0]->payslip_id . '"><span class="fas fa-trash-restore"></span></button></span>';
							} else {
								$delete = '';
							}
							$delete = $delete.'<code>'.$this->lang->line('xin_title_first_half').'</code><br>'.'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_view_payslip').'"><a href="'.site_url().'admin/payroll/payslip/id/'.$payment_last[0]->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$payment_last[0]->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $payment_last[0]->payslip_id . '"><span class="fas fa-trash-restore"></span></button></span><code>'.$this->lang->line('xin_title_second_half').'</code>';
						//}
						//detail link
					$detail = '';
					} else if($payment_check->num_rows() > 0){
						$make_payment = $this->Payroll_model->read_make_payment_payslip($r->user_id,$p_date);
						$view_url = site_url().'admin/payroll/payslip/id/'.$make_payment[0]->payslip_key;
						
						$status = '<span class="label label-success">'.$this->lang->line('xin_payroll_paid').'</span>';
						$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_payroll_make_payment').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-employee_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-company_id="'.$this->input->get("company_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
						$mpay .= '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_payroll_view_payslip').'"><a href="'.$view_url.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$make_payment[0]->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
						if(in_array('313',$role_resources_ids)){
						$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $make_payment[0]->payslip_id . '"><span class="fas fa-trash-restore"></span></button></span>';
						} else {
							$delete = '';
						}
						$delete  = $delete.'<code>'.$this->lang->line('xin_title_first_half').'</code>';
						$detail = '';
					} else {
						$status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
						$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_payroll_make_payment').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-employee_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-company_id="'.$this->input->get("company_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
						$delete = '';
						//detail link
					$detail = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#'.$view_p_class.'" data-employee_id="'. $r->user_id . '"><span class="fa fa-eye"></span></button></span>';
					}
					//detail link
					//$detail = '';
				} else {
					$payment_check = $this->Payroll_model->read_make_payment_payslip_check($r->user_id,$p_date);
					if($payment_check->num_rows() > 0){
						$make_payment = $this->Payroll_model->read_make_payment_payslip($r->user_id,$p_date);
						$view_url = site_url().'admin/payroll/payslip/id/'.$make_payment[0]->payslip_key;
						
						$status = '<span class="label label-success">'.$this->lang->line('xin_payroll_paid').'</span>';
						$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_payroll_view_payslip').'"><a href="'.$view_url.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$make_payment[0]->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
						if(in_array('313',$role_resources_ids)){
						$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $make_payment[0]->payslip_id . '"><span class="fas fa-trash-restore"></span></button></span>';
						} else {
							$delete = '';
						}
					} else {
						$status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
						$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_payroll_make_payment').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-employee_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-company_id="'.$this->input->get("company_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
						$delete = '';
					}
					//detail link
				$detail = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#'.$view_p_class.'" data-employee_id="'. $r->user_id . '"><span class="fa fa-eye"></span></button></span>';
				}
				// saudi gosi
				if($system[0]->enable_saudi_gosi != 0){
					$gois_amn = $basic_salary + $allowance_amount;
					$enable_saudi_gosi = $gois_amn / 100 * $system[0]->enable_saudi_gosi;
					$saudi_gosi = $enable_saudi_gosi;
				} else {
					$saudi_gosi = 0;
				}
				// add amount				
				$total_earning = $basic_salary + $allowance_amount + $overtime_amount + $commissions_amount + $other_payments_amount + $saudi_gosi;
				$total_deduction = $loan_de_amount + $statutory_deductions_amount;
				$total_net_salary = $total_earning - $total_deduction;
				//if($r->salary_advance_paid == ''){
				//$data1 = $add_salary. ' - ' .$loan_de_amount. ' - ' .$net_salary . ' - ' .$salary_ssempee . ' - ' .$statutory_deductions;
				//$fnet_salary = $net_salary_default + $statutory_deductions;
			//	$net_salary = $fnet_salary - $loan_de_amount;
				$net_salary = number_format((float)$total_net_salary, 2, '.', '');
				//$basic_salary_cal = $basic_salary * $current_rate; 
				
				$basic_salary = number_format((float)$basic_salary, 2, '.', '');
				//}
				
				if($basic_salary == 0 || $basic_salary == '') {
					$fmpay = '';
				} else {
					$fmpay = $mpay;
				}
				/*$company_info = $this->Company_model->read_company_information($r->company_id);
				if(!is_null($company_info)){
					$basic_salary = $this->Xin_model->company_currency_sign($basic_salary,$r->company_id);
					$net_salary = $this->Xin_model->company_currency_sign($net_salary,$r->company_id);	
				} else {
					$basic_salary = $this->Xin_model->currency_sign($basic_salary);
					$net_salary = $this->Xin_model->currency_sign($net_salary);	
				}*/
				$basic_salary = $this->Xin_model->currency_sign($basic_salary);
				$net_salary = $this->Xin_model->currency_sign($net_salary);	
				
				$iemp_name = $emp_name.'<small class="text-muted"><i> ('.$comp_name.')<i></i></i></small>';
				
				//action link
				$act = $detail.$fmpay.$delete;
				if($r->wages_type==1){
					if($system[0]->is_half_monthly==1){
						$emp_payroll_wage = $wages_type.'<br><small class="text-muted"><i>'.$this->lang->line('xin_half_monthly').'<i></i></i></small>';
					} else {
						$emp_payroll_wage = $wages_type;
					}
				}else {
					$emp_payroll_wage = $wages_type;
				}
				if(in_array('351',$role_resources_ids)) {
					$emp_id = '<a target="_blank" href="'.site_url('admin/employees/setup_salary/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('xin_employee_set_salary').'">'.$r->employee_id.' <i class="fas fa-arrow-circle-right"></i></a>';
				} else {
					$emp_id = $r->employee_id;
				}
				$data[] = array(
					$act,
					$emp_id,
					$iemp_name,
					$emp_payroll_wage,
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
				'daily_wages' => $user[0]->daily_wages,
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_templates', $data);
		} else {
			redirect('admin/');
		}
	}
	// pay hourly read > payslip
	public function hourlywage_template_read()
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
			'euser_id' => $user[0]->user_id,
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
				'location_id' => $user[0]->location_id,
				'user_id' => $user[0]->user_id,
				'wages_type' => $user[0]->wages_type,
				'basic_salary' => $user[0]->basic_salary,
				'daily_wages' => $user[0]->daily_wages
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_make_payment', $data);
		} else {
			redirect('admin/');
		}
	}
	// pay hourly > create payslip
	public function pay_hourly()
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
				'location_id' => $user[0]->location_id,
				'user_id' => $user[0]->user_id,
				'euser_id' => $user[0]->user_id,
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
       		$this->output($Return
			);
    	}*/
		$basic_salary = $this->input->post('basic_salary');
		$system = $this->Xin_model->read_setting_info(1);
		$euser_info = $this->Xin_model->read_user_info($this->input->post('emp_id'));
		if($system[0]->is_half_monthly==1){
			$is_half_monthly_payroll = 1;
		} else {
			$is_half_monthly_payroll = 0;
		}
		
		$jurl = random_string('alnum', 40);	
		$data = array(
		'employee_id' => $this->input->post('emp_id'),
		'department_id' => $this->input->post('department_id'),
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'designation_id' => $this->input->post('designation_id'),
		'salary_month' => $this->input->post('pay_date'),
		'basic_salary' => $basic_salary,
		'net_salary' => $this->input->post('net_salary'),
		'wages_type' => $this->input->post('wages_type'),
		'is_half_monthly_payroll' => $is_half_monthly_payroll,
		'total_commissions' => $this->input->post('total_commissions'),
		'total_statutory_deductions' => $this->input->post('total_statutory_deductions'),
		'total_other_payments' => $this->input->post('total_other_payments'),
		'total_allowances' => $this->input->post('total_allowances'),
		'total_loan' => $this->input->post('total_loan'),
		'total_overtime' => $this->input->post('total_overtime'),
		'saudi_gosi_amount' => $this->input->post('saudi_gosi_amount'),
		'saudi_gosi_percent' => $this->input->post('saudi_gosi_percent'),
		'is_payment' => '1',
		'status' => '0',
		'payslip_type' => 'full_monthly',
		'payslip_key' => $jurl,
		'year_to_date' => date('d-m-Y'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Payroll_model->add_salary_payslip($data);
		
		$system_settings = system_settings_info(1);	
		if($system_settings->online_payment_account == ''){
			$online_payment_account = 0;
		} else {
			$online_payment_account = $system_settings->online_payment_account;
		}
		
		if ($result) {
			
			$ivdata = array(
			'amount' => $this->input->post('net_salary'),
			'account_id' => $online_payment_account,
			'transaction_type' => 'expense',
			'dr_cr' => 'cr',
			'transaction_date' => date('Y-m-d'),
			'payer_payee_id' => $this->input->post('emp_id'),
			'payment_method_id' => 3,
			'description' => 'Payroll Payments',
			'reference' => 'Payroll Payments',
			'invoice_id' => $result,
			'client_id' => $this->input->post('emp_id'),
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($ivdata);
			// update data in bank account
			$account_id = $this->Finance_model->read_bankcash_information($online_payment_account);
			$acc_balance = $account_id[0]->account_balance - $this->input->post('net_salary');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$online_payment_account);
		
			// set allowance
			$salary_allowances = $this->Employees_model->read_salary_allowances($this->input->post('emp_id'));
			$count_allowances = $this->Employees_model->count_employee_allowances($this->input->post('emp_id'));
			$allowance_amount = 0;
			if($count_allowances > 0) {
				foreach($salary_allowances as $sl_allowances){
					 $esl_allowances = $sl_allowances->allowance_amount;
					 if($system[0]->is_half_monthly==1){
					  	 if($system[0]->half_deduct_month==2){
							 $eallowance_amount = $esl_allowances/2;
						 } else {
							 $eallowance_amount = $esl_allowances;
						 }
                      } else {
						  $eallowance_amount = $esl_allowances;
                      }
					$allowance_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'allowance_title' => $sl_allowances->allowance_title,
					'allowance_amount' => $eallowance_amount,
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
					$esl_commission = $sl_commission->commission_amount;
					 if($system[0]->is_half_monthly==1){
					  	 if($system[0]->half_deduct_month==2){
							 $ecommission_amount = $esl_commission/2;
						 } else {
							 $ecommission_amount = $esl_commission;
						 }
                      } else {
						  $ecommission_amount = $esl_commission;
                      }
					$commissions_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'commission_title' => $sl_commission->commission_title,
					'commission_amount' => $ecommission_amount,
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
					$esl_other_payments = $sl_other_payments->payments_amount;
					 if($system[0]->is_half_monthly==1){
					  	 if($system[0]->half_deduct_month==2){
							 $epayments_amount = $esl_other_payments/2;
						 } else {
							 $epayments_amount = $esl_other_payments;
						 }
                      } else {
						  $epayments_amount = $esl_other_payments;
                      }
					 $other_payments_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'payments_title' => $sl_other_payments->payments_title,
					'payments_amount' => $epayments_amount,
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
					$esl_statutory_deduction = $sl_statutory_deduction->deduction_amount;
					 if($system[0]->is_half_monthly==1){
					  	 if($system[0]->half_deduct_month==2){
							 $ededuction_amount = $esl_statutory_deduction/2;
						 } else {
							 $ededuction_amount = $esl_statutory_deduction;
						 }
                      } else {
						  $ededuction_amount = $esl_statutory_deduction;
                      }
					  $statutory_deduction_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'deduction_title' => $sl_statutory_deduction->deduction_title,
					'deduction_amount' => $ededuction_amount,
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
					$esl_salary_loan_deduction = $sl_salary_loan_deduction->loan_deduction_amount;
					 if($system[0]->is_half_monthly==1){
					  	 if($system[0]->half_deduct_month==2){
							 $eloan_deduction_amount = $esl_salary_loan_deduction/2;
						 } else {
							 $eloan_deduction_amount = $esl_salary_loan_deduction;
						 }
                      } else {
						  $eloan_deduction_amount = $esl_salary_loan_deduction;
                      }
					$loan_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'salary_month' => $this->input->post('pay_date'),
					'loan_title' => $sl_salary_loan_deduction->loan_deduction_title,
					'loan_amount' => $eloan_deduction_amount,
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
					$eovertime_hours = $sl_overtime->overtime_hours;
					$eovertime_rate = $sl_overtime->overtime_rate;
					 if($system[0]->is_half_monthly==1){
					  	 if($system[0]->half_deduct_month==2){
							 $esl_overtime_hr = $eovertime_hours/2;
							 $esl_overtime_rate = $eovertime_rate/2;
						 } else {
							 $esl_overtime_hr = $eovertime_hours;
							 $esl_overtime_rate = $eovertime_rate;
						 }
                      } else {
						  $esl_overtime_hr = $eovertime_hours;
						  $esl_overtime_rate = $eovertime_rate;
                      }
					  $overtime_data = array(
					'payslip_id' => $result,
					'employee_id' => $this->input->post('emp_id'),
					'overtime_salary_month' => $this->input->post('pay_date'),
					'overtime_title' => $sl_overtime->overtime_type,
					'overtime_no_of_days' => $sl_overtime->no_of_days,
					'overtime_hours' => $esl_overtime_hr,
					'overtime_rate' => $esl_overtime_rate,
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
	public function add_pay_hourly() {
	
		if($this->input->post('add_type')=='add_pay_hourly') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
				
		/*if($Return['error']!=''){
       		$this->output($Return);
    	}*/
		$basic_salary = $this->input->post('basic_salary');
		$jurl = random_string('alnum', 40);	
		$data = array(
		'employee_id' => $this->input->post('emp_id'),
		'department_id' => $this->input->post('department_id'),
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'designation_id' => $this->input->post('designation_id'),
		'salary_month' => $this->input->post('pay_date'),
		'basic_salary' => $basic_salary,
		'net_salary' => $this->input->post('net_salary'),
		'wages_type' => $this->input->post('wages_type'),
		'is_half_monthly_payroll' => 0,
		'total_commissions' => $this->input->post('total_commissions'),
		'total_statutory_deductions' => $this->input->post('total_statutory_deductions'),
		'total_other_payments' => $this->input->post('total_other_payments'),
		'total_allowances' => $this->input->post('total_allowances'),
		'total_loan' => $this->input->post('total_loan'),
		'total_overtime' => $this->input->post('total_overtime'),
		'hours_worked' => $this->input->post('hours_worked'),
		'saudi_gosi_amount' => $this->input->post('saudi_gosi_amount'),
		'saudi_gosi_percent' => $this->input->post('saudi_gosi_percent'),
		'is_payment' => '1',
		'status' => '0',
		'payslip_type' => 'hourly',
		'payslip_key' => $jurl,
		'year_to_date' => date('d-m-Y'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Payroll_model->add_salary_payslip($data);	
		$system_settings = system_settings_info(1);	
		if($system_settings->online_payment_account == ''){
			$online_payment_account = 0;
		} else {
			$online_payment_account = $system_settings->online_payment_account;
		}
		if ($result) {
			$ivdata = array(
			'amount' => $this->input->post('net_salary'),
			'account_id' => $online_payment_account,
			'transaction_type' => 'expense',
			'dr_cr' => 'cr',
			'transaction_date' => date('Y-m-d'),
			'payer_payee_id' => $this->input->post('emp_id'),
			'payment_method_id' => 3,
			'description' => 'Payroll Payments',
			'reference' => 'Payroll Payments',
			'invoice_id' => $result,
			'client_id' => $this->input->post('emp_id'),
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($ivdata);
			// update data in bank account
			$account_id = $this->Finance_model->read_bankcash_information($online_payment_account);
			$acc_balance = $account_id[0]->account_balance - $this->input->post('net_salary');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$online_payment_account);
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
	public function add_half_pay_to_all() {
	
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		if($this->input->post('add_type')=='payroll') {	
			if($this->input->post('company_id')==0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$result = $this->Xin_model->all_employees();
			} else if($this->input->post('company_id')!=0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_company_payroll_employees($this->input->post('company_id'));
				$result = $eresult->result();
			} else if($this->input->post('company_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_company_location_payroll_employees($this->input->post('company_id'),$this->input->post('location_id'));
				$result = $eresult->result();
			} else if($this->input->post('company_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')!=0) {	
				$eresult = $this->Payroll_model->get_company_location_dep_payroll_employees($this->input->post('company_id'),$this->input->post('location_id'),$this->input->post('department_id'));
				$result = $eresult->result();
			} else {
				$Return['error'] = $this->lang->line('xin_record_not_found');
			}
			$system = $this->Xin_model->read_setting_info(1);
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
			foreach($result as $empid) {
				$user_id = $empid->user_id;
				$user = $this->Xin_model->read_user_info($user_id);
			
			if($system[0]->is_half_monthly==1){
				$is_half_monthly_payroll = 1;
			} else {
				$is_half_monthly_payroll = 0;
			}
			/* Server side PHP input validation */
			if($empid->wages_type==1){
				if($system[0]->is_half_monthly==1){
					$basic_salary = $empid->basic_salary / 2;
				} else {
					$basic_salary = $empid->basic_salary;
				}
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
					if($system[0]->is_half_monthly==1){
					 if($system[0]->half_deduct_month==2){
						 $eallowance_amount = $sl_allowances->allowance_amount/2;
					 } else {
						 $eallowance_amount = $sl_allowances->allowance_amount;
					 }
				  } else {
					  $eallowance_amount = $sl_allowances->allowance_amount;
				  }
				  $allowance_amount += $eallowance_amount;
				//  $allowance_amount += $sl_allowances->allowance_amount;
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
					if($system[0]->is_half_monthly==1){
					  if($system[0]->half_deduct_month==2){
						  $er_loan = $sl_salary_loan_deduction->loan_deduction_amount/2;
					  } else {
						  $er_loan = $sl_salary_loan_deduction->loan_deduction_amount;
					  }
				  } else {
					  $er_loan = $sl_salary_loan_deduction->loan_deduction_amount;
				  }
				  $loan_de_amount += $er_loan;
				 // $loan_de_amount += $sl_salary_loan_deduction->loan_deduction_amount;
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
					//$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
					//$overtime_amount += $overtime_total;
					if($system[0]->is_half_monthly==1){
						if($system[0]->half_deduct_month==2){
							$eovertime_hours = $sl_overtime->overtime_hours/2;
							$eovertime_rate = $sl_overtime->overtime_rate/2;
						} else {
							$eovertime_hours = $sl_overtime->overtime_hours;
							$eovertime_rate = $sl_overtime->overtime_rate;
						}
					} else {
						$eovertime_hours = $sl_overtime->overtime_hours;
						$eovertime_rate = $sl_overtime->overtime_rate;
					}
					$overtime_amount += $eovertime_hours * $eovertime_rate;
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
					//$other_payments_amount += $sl_other_payments->payments_amount;
					if($system[0]->is_half_monthly==1){
					  if($system[0]->half_deduct_month==2){
						  $epayments_amount = $sl_other_payments->payments_amount/2;
					  } else {
						  $epayments_amount = $sl_other_payments->payments_amount;
					  }
				  } else {
					  $epayments_amount = $sl_other_payments->payments_amount;
				  }
				  $other_payments_amount += $epayments_amount;
				}
			endif;
			// all other payment
			$all_other_payment = $other_payments_amount;
			// 5: commissions
			$commissions = $this->Employees_model->set_employee_commissions($user_id);
			if(!is_null($commissions)):
				$commissions_amount = 0;
				foreach($commissions->result() as $sl_commissions) {
					if($system[0]->is_half_monthly==1){
					  if($system[0]->half_deduct_month==2){
						  $ecommissions_amount = $sl_commissions->commission_amount/2;
					  } else {
						  $ecommissions_amount = $sl_commissions->commission_amount;
					  }
				  } else {
					  $ecommissions_amount = $sl_commissions->commission_amount;
				  }
				  $commissions_amount += $ecommissions_amount;
				 // $commissions_amount += $sl_commissions->commission_amount;
				}
			endif;
			// 6: statutory deductions
			$statutory_deductions = $this->Employees_model->set_employee_statutory_deductions($user_id);
			if(!is_null($statutory_deductions)):
				$statutory_deductions_amount = 0;
				foreach($statutory_deductions->result() as $sl_statutory_deductions) {
					if($system[0]->statutory_fixed!='yes'):
						$sta_salary = $basic_salary;
						$st_amount = $sta_salary / 100 * $sl_statutory_deductions->deduction_amount;
						if($system[0]->is_half_monthly==1){
						   if($system[0]->half_deduct_month==2){
							   $single_sd = $st_amount/2;
						   } else {
							   $single_sd = $st_amount;
						   }
					  } else {
						  $single_sd = $st_amount;
					  }
					 $statutory_deductions_amount += $single_sd;
					else:
						if($system[0]->is_half_monthly==1){
						 if($system[0]->half_deduct_month==2){
							$single_sd = $sl_statutory_deductions->deduction_amount/2;
						 } else {
							$single_sd = $sl_statutory_deductions->deduction_amount;
						 }
					  } else {
						  $single_sd = $sl_statutory_deductions->deduction_amount;
					  }
					$statutory_deductions_amount += $single_sd;
					//$statutory_deductions_amount += $sl_statutory_deductions->deduction_amount;
					endif;
				}
			endif;
			
			// add amount
			$add_salary = $allowance_amount + $basic_salary + $overtime_amount + $other_payments_amount + $commissions_amount;
			// add amount
			$net_salary_default = $add_salary - $loan_de_amount - $statutory_deductions_amount;
			$net_salary = $net_salary_default;
			$net_salary = number_format((float)$net_salary, 2, '.', '');
			$jurl = random_string('alnum', 40);		
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
			'is_half_monthly_payroll' => $is_half_monthly_payroll,
			'is_payment' => '1',
			'payslip_type' => 'full_monthly',
			'payslip_key' => $jurl,
			'year_to_date' => date('d-m-Y'),
			'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Payroll_model->add_salary_payslip($data);	
			
			if ($result) {
				$ivdata = array(
				'amount' => $net_salary,
				'account_id' => $online_payment_account,
				'transaction_type' => 'expense',
				'dr_cr' => 'cr',
				'transaction_date' => date('Y-m-d'),
				'payer_payee_id' => $user_id,
				'payment_method_id' => 3,
				'description' => 'Payroll Payments',
				'reference' => 'Payroll Payments',
				'invoice_id' => $result,
				'client_id' => $user_id,
				'created_at' => date('Y-m-d H:i:s')
				);
				$this->Finance_model->add_transactions($ivdata);
				// update data in bank account
				$account_id = $this->Finance_model->read_bankcash_information($online_payment_account);
				$acc_balance = $account_id[0]->account_balance - $net_salary;
				
				$data3 = array(
				'account_balance' => $acc_balance
				);
				$this->Finance_model->update_bankcash_record($data3,$online_payment_account);
				
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
	
	// Validate and add info in database > add monthly payment
	public function add_pay_to_all() {
	
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		if($this->input->post('add_type')=='payroll') {	
			if($this->input->post('company_id')==0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_all_employees();
				$result = $eresult->result();
			} else if($this->input->post('company_id')!=0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_company_payroll_employees($this->input->post('company_id'));
				$result = $eresult->result();
			} else if($this->input->post('company_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_company_location_payroll_employees($this->input->post('company_id'),$this->input->post('location_id'));
				$result = $eresult->result();
			} else if($this->input->post('company_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')!=0) {	
				$eresult = $this->Payroll_model->get_company_location_dep_payroll_employees($this->input->post('company_id'),$this->input->post('location_id'),$this->input->post('department_id'));
				$result = $eresult->result();
			} else {
				$Return['error'] = $this->lang->line('xin_record_not_found');
			}
			$system = $this->Xin_model->read_setting_info(1);
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
			foreach($result as $empid) {
				$user_id = $empid->user_id;
				$user = $this->Xin_model->read_user_info($user_id);			
				/* Server side PHP input validation */
				if($empid->wages_type==1){
					$basic_salary = $empid->basic_salary;
				} else {
					$basic_salary = $empid->daily_wages;
				}
				$pay_count = $this->Payroll_model->read_make_payment_payslip_check($user_id,$this->input->post('month_year'));
				if($pay_count->num_rows() > 0){
					$pay_val = $this->Payroll_model->read_make_payment_payslip($user_id,$this->input->post('month_year'));
					$this->payslip_delete_all($pay_val[0]->payslip_id);
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
							if($system[0]->statutory_fixed!='yes'):
								$sta_salary = $basic_salary;
								$st_amount = $sta_salary / 100 * $sl_statutory_deductions->deduction_amount;
								$statutory_deductions_amount += $st_amount;
							else:
								$statutory_deductions_amount += $sl_statutory_deductions->deduction_amount;
							endif;
						}
					endif;
					
					// add amount
					$add_salary = $allowance_amount + $basic_salary + $overtime_amount + $other_payments_amount + $commissions_amount;
					// add amount
					$net_salary_default = $add_salary - $loan_de_amount - $statutory_deductions_amount;
					$net_salary = $net_salary_default;
					$net_salary = number_format((float)$net_salary, 2, '.', '');
					$jurl = random_string('alnum', 40);		
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
					'payslip_type' => 'full_monthly',
					'payslip_key' => $jurl,
					'year_to_date' => date('d-m-Y'),
					'created_at' => date('d-m-Y h:i:s')
					);
					$result = $this->Payroll_model->add_salary_payslip($data);	
					
					if ($result) {
						$ivdata = array(
						'amount' => $net_salary,
						'account_id' => $online_payment_account,
						'transaction_type' => 'expense',
						'dr_cr' => 'cr',
						'transaction_date' => date('Y-m-d'),
						'payer_payee_id' => $user_id,
						'payment_method_id' => 3,
						'description' => 'Payroll Payments',
						'reference' => 'Payroll Payments',
						'invoice_id' => $result,
						'client_id' => $user_id,
						'created_at' => date('Y-m-d H:i:s')
						);
						$this->Finance_model->add_transactions($ivdata);
						// update data in bank account
						$account_id = $this->Finance_model->read_bankcash_information($online_payment_account);
						$acc_balance = $account_id[0]->account_balance - $net_salary;
						
						$data3 = array(
						'account_balance' => $acc_balance
						);
						$this->Finance_model->update_bankcash_record($data3,$online_payment_account);
						
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
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($this->input->get("ihr")=='true'){
			if($this->input->get("company_id")==0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0){
				if($this->input->get("salary_month") == ''){
					$history = $this->Payroll_model->all_employees_payment_history();
				} else {
					$history = $this->Payroll_model->all_employees_payment_history_month($this->input->get("salary_month"));
				}
			} else if($this->input->get("company_id")!=0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0){
				if($this->input->get("salary_month") == ''){
					$history = $this->Payroll_model->get_company_payslip_history($this->input->get("company_id"));
				} else {
					$history = $this->Payroll_model->get_company_payslip_history_month($this->input->get("company_id"),$this->input->get("salary_month"));
				}
			} else if($this->input->get("company_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")==0 ){
				if($this->input->get("salary_month") == ''){
					$history = $this->Payroll_model->get_company_location_payslips($this->input->get("company_id"),$this->input->get("location_id"));
				} else {
					$history = $this->Payroll_model->get_company_location_payslips_month($this->input->get("company_id"),$this->input->get("location_id"),$this->input->get("salary_month"));
				}
				
			} else if($this->input->get("company_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0){
				if($this->input->get("salary_month") == ''){
					$history = $this->Payroll_model->get_company_location_department_payslips($this->input->get("company_id"),$this->input->get("location_id"),$this->input->get("department_id"));
				} else {
					$history = $this->Payroll_model->get_company_location_department_payslips_month($this->input->get("company_id"),$this->input->get("location_id"),$this->input->get("department_id"),$this->input->get("salary_month"));
				}
				
			}/**/ /*else if($this->input->get("company_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("designation_id")!=0){
				$history = $this->Payroll_model->get_company_location_department_designation_payslips($this->input->get("company_id"),$this->input->get("location_id"),$this->input->get("department_id"),$this->input->get("designation_id"));
			}*/
		} else {
			if($user_info[0]->user_role_id==1){
				$history = $this->Payroll_model->employees_payment_history();
			} else {
				if(in_array('391',$role_resources_ids)) {
					$history = $this->Payroll_model->get_company_payslips($user_info[0]->company_id);
				} else {
					$history = $this->Payroll_model->get_payroll_slip($session['user_id']);
				}
			}
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
			$department_designation = $designation_name.' ('.$department_name.')';
			// get company
			$company = $this->Xin_model->read_company_info($user[0]->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			// bank account
			$bank_account = $this->Employees_model->get_employee_bank_account_last($user[0]->user_id);
			if(!is_null($bank_account)){
				$account_number = $bank_account[0]->account_number;
			} else {
				$account_number = '--';	
			}
			$payslip = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
			
		$ifull_name = nl2br ($full_name."\r\n <small class='text-muted'><i>".$this->lang->line('xin_employees_id').': '.$emp_link."<i></i></i></small>\r\n <small class='text-muted'><i>".$department_designation.'<i></i></i></small>');
               $data[] = array(
					$payslip,
                    $full_name,
					$comp_name,
					$account_number,
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
		$key = $this->uri->segment(5);
		
		$result = $this->Payroll_model->read_salary_payslip_info_key($key);
		if(is_null($result)){
			redirect('admin/payroll/generate_payslip');
		}
		$p_method = '';
		/*$payment_method = $this->Xin_model->read_payment_method($result[0]->payment_method);
		if(!is_null($payment_method)){
		  $p_method = $payment_method[0]->method_name;
		} else {
		  $p_method = '--';
		}*/
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
				'euser_id' => $user[0]->user_id,
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
				'year_to_date' => $result[0]->year_to_date,
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
				'payslip_key' => $result[0]->payslip_key,
				'payslip_type' => $result[0]->payslip_type,
				'hours_worked' => $result[0]->hours_worked,
				'pay_comments' => $result[0]->pay_comments,
				'saudi_gosi_percent' => $result[0]->saudi_gosi_percent,
				'saudi_gosi_amount' => $result[0]->saudi_gosi_amount,
				'is_payment' => $result[0]->is_payment,
				'approval_status' => $result[0]->status,
				);
		$data['breadcrumbs'] = $this->lang->line('xin_payroll_employee_payslip');
		$data['path_url'] = 'payslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
		if($result[0]->payslip_type=='hourly'){
			$data['subview'] = $this->load->view("admin/payroll/hourly_payslip", $data, TRUE);
		} else {
			$data['subview'] = $this->load->view("admin/payroll/payslip", $data, TRUE);
		}
		$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
     }	
	 public function pdf_create(){
		 	
		//$this->load->library('Pdf');
		$system = $this->Xin_model->read_setting_info(1);		
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$key = $this->uri->segment(5);
		$payment = $this->Payroll_model->read_salary_payslip_info_key($key);
		if(is_null($payment)){
			redirect('admin/payroll/generate_payslip');
		}
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
		if(!is_null($_des_name)){
			$_designation_name = $_des_name[0]->designation_name;
		} else {
			$_designation_name = '';
		}
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$_department_name = $department[0]->department_name;
		} else {
			$_department_name = '';
		}
		//$location = $this->Xin_model->read_location_info($department[0]->location_id);
		// company info
		$company = $this->Xin_model->read_company_info($user[0]->company_id);
		
		
		$p_method = '';
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
		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		// set default header data
		//$c_info_address = $address_1.' '.$address_2.', '.$city.' - '.$zipcode.', '.$country_name;
		$c_info_address = $address_1.' '.$address_2.', '.$city.' - '.$zipcode;
		//$email_phone_address = "$c_info_address \n".$this->lang->line('xin_phone')." : $c_info_phone | ".$this->lang->line('dashboard_email')." : $c_info_email ";
		
		$email_phone_address = "$c_info_address \n".$this->lang->line('xin_phone')." : $c_info_phone | ".$this->lang->line('dashboard_email')." : $c_info_email \n";
		
		$header_string = $email_phone_address;		
		// set document information
		$pdf->SetCreator('HRSALE');
		$pdf->SetAuthor('HRSALE');
		//$pdf->SetTitle('Workable-Zone - Payslip');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->SetHeaderData('../../../uploads/logo/payroll/'.$system[0]->payroll_logo, 15, $company_name, $header_string);
			
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
		$pdf->SetAuthor('HRSALE');
		$pdf->SetTitle($company_name.' - '.$this->lang->line('xin_print_payslip'));
		$pdf->SetSubject($this->lang->line('xin_payslip'));
		$pdf->SetKeywords($this->lang->line('xin_payslip'));
		// set font
		$pdf->SetFont('helvetica', 'B', 10);
				
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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
		$pdf->SetFont('dejavusans', '', 10, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();		
		// -----------------------------------------------------------------------------
		$fname = $user[0]->first_name.' '.$user[0]->last_name;
		$created_at = $this->Xin_model->set_date_format($payment[0]->created_at);
		$date_of_joining = $this->Xin_model->set_date_format($user[0]->date_of_joining);
		$salary_month = $this->Xin_model->set_date_format($payment[0]->salary_month);
		// check
		$half_title = '';
		if($system[0]->is_half_monthly==1){
			$payment_check1 = $this->Payroll_model->read_make_payment_payslip_half_month_check_first($payment[0]->employee_id,$payment[0]->salary_month);
			$payment_check2 = $this->Payroll_model->read_make_payment_payslip_half_month_check_last($payment[0]->employee_id,$payment[0]->salary_month);
			$payment_check = $this->Payroll_model->read_make_payment_payslip_half_month_check($payment[0]->employee_id,$payment[0]->salary_month);
			if($payment_check->num_rows() > 1) {
				if($payment_check2[0]->payslip_key == $this->uri->segment(5)){
					$half_title = '('.$this->lang->line('xin_title_second_half').')';
				} else if($payment_check1[0]->payslip_key == $this->uri->segment(5)){
					$half_title = '('.$this->lang->line('xin_title_first_half').')';
				} else {
					$half_title = '';
				}
			} else {
				$half_title = '('.$this->lang->line('xin_title_first_half').')';
			}
			$half_title = $half_title;
		} else {
			$half_title = '';
		}

		// basic salary
		$bs=0;
		$bs = $payment[0]->basic_salary;
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
		//
		$statutory_deduction_amount = 0; $loan_de_amount = 0; $allowances_amount = 0;
		$commissions_amount = 0; $other_payments_amount = 0; $overtime_amount = 0;		
		// laon
		if($count_loan > 0):
			foreach($loan->result() as $r_loan) {
				$loan_de_amount += $r_loan->loan_amount;
			}	
			$loan_de_amount = $loan_de_amount;
		else:
			$loan_de_amount = 0;
		endif;
		// allowances
		$allowances_amount = 0; foreach($allowances->result() as $sl_allowances) {
			$allowances_amount += $sl_allowances->allowance_amount;
		}
		// commission
		$commissions_amount = 0; foreach($commissions->result() as $sl_commissions) {
			$commissions_amount += $sl_commissions->commission_amount;
		}
		// statutory deduction
		$statutory_deduction_amount = 0; foreach($statutory_deductions->result() as $sl_statutory_deductions) {
			//$statutory_deduction_amount += $sl_statutory_deductions->deduction_amount;
			if($system[0]->statutory_fixed!='yes'):
				$sta_salary = $bs;
				$st_amount = $sta_salary / 100 * $sl_statutory_deductions->deduction_amount;
				$statutory_deduction_amount += $st_amount;
			else:
				$statutory_deduction_amount += $sl_statutory_deductions->deduction_amount;
			endif;
		}
		// other amount
		$other_payments_amount = 0; foreach($other_payments->result() as $sl_other_payments) {
			$other_payments_amount += $sl_other_payments->payments_amount;
		}
		// overtime
		$overtime_amount = 0; foreach($overtime->result() as $r_overtime) {
			$overtime_total = $r_overtime->overtime_hours * $r_overtime->overtime_rate;
			$overtime_amount += $overtime_total;
		}
		$tbl = '<br><br>
		<table cellpadding="1" cellspacing="1" border="0">
			<tr>
				<td align="center"><h1>'.$this->lang->line('xin_payslip').'</h1></td>
			</tr>
			<tr>
				<td align="center">'.$this->lang->line('xin_payroll_year_date').': '.$half_title.' <strong>'.date("F Y", strtotime($payment[0]->salary_month)).'</strong></td>
			</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// -----------------------------------------------------------------------------
		// set cell padding
		$pdf->setCellPaddings(1, 1, 1, 1);
		
		// set cell margins
		$pdf->setCellMargins(0, 0, 0, 0);
		
		// set color for background
		$pdf->SetFillColor(255, 255, 127);
		// set some text for example
		//$txt = 'Employee Details';
		// Multicell
		//$pdf->MultiCell(180, 6, $txt, 0, 'L', 11, 0, '', '', true);
		//$pdf->Ln(7);
		$tbl1 = '
		<table cellpadding="3" cellspacing="0" border="1">
			<tr bgcolor="#69e48a">
			<td colspan="4"><strong>Employee Details</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_name').'</td>
				<td>'.$fname.'</td>
				<td>'.$this->lang->line('dashboard_employee_id').'</td>
				<td>'.$user[0]->employee_id.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('left_department').'</td>
				<td>'.$_department_name.'</td>
				<td>'.$this->lang->line('left_designation').'</td>
				<td>'.$_designation_name.'</td>
			</tr>';
			if($payment[0]->payslip_type=='hourly'){
				$hcount = $payment[0]->hours_worked;
				$tbl1 .= '<tr>
				<td>'.$this->lang->line('xin_employee_doj').'</td>
				<td>'.$date_of_joining.'</td>
				<td>'.$this->lang->line('xin_payroll_hours_worked_total').'</td>
				<td>'.$hcount.'</td>
			</tr>';
			} else {
				$date = strtotime($payment[0]->year_to_date);
				$day = date('d', $date);
				$month = date('m', $date);
				$year = date('Y', $date);
				// total days in month
				$daysInMonth = date('t');
				$imonth = date('F', $date);
				$r = $this->Xin_model->read_user_info($user[0]->user_id);
				$pcount = 0;
				$acount = 0;
				$lcount = 0;
				for($i = 1; $i <= $daysInMonth; $i++):
					$i = str_pad($i, 2, 0, STR_PAD_LEFT);
					// get date <
					$attendance_date = $year.'-'.$month.'-'.$i;
					$get_day = strtotime($attendance_date);
					$day = date('l', $get_day);
					$user_id = $r[0]->user_id;
					$office_shift_id = $r[0]->office_shift_id;
					$attendance_status = '';
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
					$leave_date_chck = $this->Timesheet_model->leave_date_check($user_id,$attendance_date);
					$leave_arr = array();
					if($leave_date_chck->num_rows() == 1){
						$leave_date = $this->Timesheet_model->leave_date($user_id,$attendance_date);
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
					$office_shift = $this->Timesheet_model->read_office_shift_information($office_shift_id);
					$check = $this->Timesheet_model->attendance_first_in_check($user_id,$attendance_date);
					// get holiday>events
					if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
						$status = 'H';	
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
						$status = 'H';
						$pcount += 0;
						//$acount -= 1;
					} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
						$status = 'H';
						$pcount += 0;
						//$acount -= 1;
					} else if(in_array($attendance_date,$holiday_arr)) { // holiday
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if(in_array($attendance_date,$leave_arr)) { // on leave
						$status = 'L';
						$pcount += 0;
						$lcount += 1;
					//	$acount += 0;
					} else if($check->num_rows() > 0){
						$pcount += 1;
						//$acount -= 1;
					}	else {
						$status = 'A';
						//$acount += 1;
						$pcount += 0;
						// set to present date
						$iattendance_date = strtotime($attendance_date);
						$icurrent_date = strtotime(date('Y-m-d'));
						if($iattendance_date <= $icurrent_date){
							$acount += 1;
						} else {
							$acount += 0;
						}
					}
				endfor;
				$tbl1 .= '<tr>
				<td>'.$this->lang->line('xin_employee_doj').'</td>
				<td>'.$date_of_joining.'</td>
				<td>'.$this->lang->line('xin_payroll_no_of_days_in_month').'</td>
				<td>'.$pcount.'</td>
			</tr>';
			}
		$tbl1 .= '</table>';
		
		$pdf->writeHTML($tbl1, true, false, true, false, '');
		if($payment[0]->payslip_type=='hourly'){
			$total_earning = $allowances_amount + $commissions_amount + $other_payments_amount + $overtime_amount;	
			$total_deductions = $loan_de_amount + $statutory_deduction_amount;
			$total_count = $hcount * $bs;
		} else {
			$total_earning = $bs + $allowances_amount + $commissions_amount + $other_payments_amount + $overtime_amount;	
			$total_deductions = $loan_de_amount + $statutory_deduction_amount;
		}
		/*<tr>
				<td colspan="2">'.$this->lang->line('xin_payroll_hourly_rate').'</td>
				<td align="center">'.$this->Xin_model->currency_sign($payment[0]->basic_salary).'</td>	
				<td>&nbsp;</td>				
			</tr>*/
		//// break..
		$pdf->Ln(7);
		$tblbrk = '<table cellpadding="3" cellspacing="0" border="1"><tr bgcolor="#69e48a">
				<td colspan="2" align="center"><strong>'.$this->lang->line('xin_description').'</strong></td>
				<td align="center"><strong>'.$this->lang->line('xin_payslip_earning').'</strong></td>	
				<td align="center"><strong>'.$this->lang->line('xin_deductions').'</strong></td>			
			</tr>';
			if($payment[0]->payslip_type!='hourly'){
				$tblbrk .= '<tr>
					<td colspan="2">'.$this->lang->line('xin_payroll_basic_salary').'</td>
					<td align="center"  valign="bottom">'.$this->Xin_model->currency_sign($bs).'</td>	
					<td>&nbsp;</td>				
				</tr>';
			} else {
				$tblbrk .= '<tr>
					<td colspan="2">'.$this->lang->line('xin_payroll_hourly_rate').' x '.$this->lang->line('xin_payroll_hours_worked_total').'<br> '.$this->Xin_model->currency_sign($bs).' x '.$hcount.'</td>
					<td align="center"  valign="bottom">'.$this->Xin_model->currency_sign($total_count).'</td>	
					<td>&nbsp;</td>				
				</tr>';
			}			
			//allowances
			if($count_allowances > 0) {
				foreach($allowances->result() as $sl_allowances) {
				$tblbrk .= '<tr>
					<td colspan="2">'.$sl_allowances->allowance_title.'</td>
					<td align="center">'.$this->Xin_model->currency_sign($sl_allowances->allowance_amount).'</td>	
					<td>&nbsp;</td>				
					</tr>';
				}
			}
			//commissions
			if($count_commissions > 0) {
				foreach($commissions->result() as $sl_commissions) {
				$tblbrk .= '<tr>
					<td colspan="2">'.$sl_commissions->commission_title.'</td>
					<td align="center">'.$this->Xin_model->currency_sign($sl_commissions->commission_amount).'</td>	
					<td>&nbsp;</td>				
					</tr>';
				}
			}
			//other_payments
			if($count_other_payments > 0) {
				foreach($other_payments->result() as $sl_other_payments) {
				$tblbrk .= '<tr>
					<td colspan="2">'.$sl_other_payments->payments_title.'</td>
					<td align="center">'.$this->Xin_model->currency_sign($sl_other_payments->payments_amount).'</td>	
					<td>&nbsp;</td>				
					</tr>';
				}
			}
			//overtime
			if($count_overtime > 0) {
				foreach($overtime->result() as $r_overtime) {
					$overtime_total = $r_overtime->overtime_hours * $r_overtime->overtime_rate;
				$tblbrk .= '<tr>
					<td colspan="2">'.$r_overtime->overtime_title.'</td>
					<td align="center">'.$this->Xin_model->currency_sign($overtime_total).'</td>	
					<td>&nbsp;</td>				
					</tr>';
				}
			}
			//statutory_deductions
			if($count_statutory_deductions > 0) {
				foreach($statutory_deductions->result() as $sl_statutory_deductions) {
					if($system[0]->statutory_fixed!='yes'):
					$sta_salary = $bs;
					$st_amount = $sta_salary / 100 * $sl_statutory_deductions->deduction_amount;
					$xstatutory_deduction_amount = $st_amount;
				else:
					$xstatutory_deduction_amount = $sl_statutory_deductions->deduction_amount;
				endif;
				$tblbrk .= '<tr>
					<td colspan="2">'.$sl_statutory_deductions->deduction_title.'</td>
					<td>&nbsp;</td>
					<td align="center">'.$this->Xin_model->currency_sign($xstatutory_deduction_amount).'</td>			
					</tr>';
				}
			}
			//loan
			if($count_loan > 0) {
				foreach($loan->result() as $r_loan) {
				$tblbrk .= '<tr>
					<td colspan="2">'.$r_loan->loan_title.'</td>
					<td>&nbsp;</td>	
					<td align="center">'.$this->Xin_model->currency_sign($r_loan->loan_amount).'</td>	
					</tr>';
				}
			}
			if($payment[0]->payslip_type=='hourly'){
				$total_earning = $allowances_amount + $overtime_amount + $commissions_amount + $other_payments_amount;
				$total_deduction = $loan_de_amount + $statutory_deduction_amount;
				$total_net_salary = $total_earning - $total_deduction;
				$etotal_count = $hcount * $bs;
				$fsalary = $etotal_count + $total_net_salary;
				$etotal_earning = $total_earning + $etotal_count;
			
			$tblbrk .= '
			<tr><td colspan="2" align="center"><strong>Total</strong></td>
					<td align="center"><strong>'.$this->Xin_model->currency_sign($etotal_earning).'</strong></td>
					<td align="center"><strong>'.$this->Xin_model->currency_sign($total_deductions).'</strong></td>	
					</tr></table>
					<table cellpadding="3" cellspacing="0" border="1">
					<tr><td colspan="2" align="center">&nbsp;</td>
					<td colspan="2" align="center" bgcolor="#69e48a"><strong>NET PAY</strong></td>
					</tr><tr><td colspan="2" align="center">'.ucwords($this->Xin_model->convertNumberToWord($fsalary)).'</td>
					<td colspan="2" align="center"><strong>'.$this->Xin_model->currency_sign($fsalary).'</strong></td>
					</tr></table>';
			} else {
				$total_earning = $bs +$allowances_amount + $overtime_amount + $commissions_amount + $other_payments_amount;
				$total_deduction = $loan_de_amount + $statutory_deduction_amount;
				$total_net_salary = $total_earning - $total_deduction;
				$tblbrk .= '
			<tr><td colspan="2" align="center"><strong>Total</strong></td>
					<td align="center"><strong>'.$this->Xin_model->currency_sign($total_earning).'</strong></td>
					<td align="center"><strong>'.$this->Xin_model->currency_sign($total_deductions).'</strong></td>	
					</tr></table>
					<table cellpadding="3" cellspacing="0" border="1">
					<tr><td colspan="2" align="center">&nbsp;</td>
					<td colspan="2" align="center" bgcolor="#69e48a"><strong>NET PAY</strong></td>
					</tr><tr><td colspan="2" align="center">'.ucwords($this->Xin_model->convertNumberToWord($total_net_salary)).'</td>
					<td colspan="2" align="center"><strong>'.$this->Xin_model->currency_sign($total_net_salary).'</strong></td>
					</tr></table>';
			}
		$pdf->writeHTML($tblbrk, true, false, true, false, '');
		
		////////////////// end break salary..
		/*$pdf->Ln(7);
		$tblc = '<table cellpadding="3" cellspacing="0" border="1"><tr>
				<td colspan="2">'.$this->lang->line('xin_payroll_total_earning').'</td>
				<td colspan="2">'.$this->lang->line('xin_payroll_total_deductions').'</td>				
			</tr>
			<tr>
				<td colspan="2">'.$this->Xin_model->currency_sign($total_earning).'</td>
				<td colspan="2">'.$this->Xin_model->currency_sign($total_deductions).'</td>				
			</tr>
			</table>';
		$pdf->writeHTML($tblc, true, false, true, false, '');*/
			
		/*if(null!=$this->uri->segment(4) && $this->uri->segment(4)=='p') {
		// -----------------------------------------------------------------------------		
		$tbl2 = '';
		// -----------------------------------------------------------------------------
		$txt = 'Payslip Details';

		// Multicell test
		$pdf->MultiCell(180, 6, $txt, 0, 'L', 11, 0, '', '', true);
		$pdf->Ln(7);
		$tbl2 .= '
		<table cellpadding="3" cellspacing="0" border="1">';
			 if($payment[0]->wages_type == 1){
			$tbl2 .= ' <tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_basic_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->basic_salary).'</td>
			</tr>';
			} else {
				$tbl2 .= ' <tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_employee_daily_wages').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->daily_wages).'</td>
			</tr>';
			}
			if($payment[0]->total_allowances!=0 || $payment[0]->total_allowances!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_allowance').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_allowances).'</td>
			</tr>';
			endif;
			if($payment[0]->total_commissions!=0 || $payment[0]->total_commissions!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_hr_commissions').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_commissions).'</td>
			</tr>';
			endif;
			if($payment[0]->total_loan!=0 || $payment[0]->total_loan!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_loan').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_loan).'</td>
			</tr>';
			endif;
			if($payment[0]->total_overtime!=0 || $payment[0]->total_overtime!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_overtime').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_overtime).'</td>
			</tr>';
			endif;
			if($payment[0]->total_statutory_deductions!=0 || $payment[0]->total_statutory_deductions!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_employee_set_statutory_deductions').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_statutory_deductions).'</td>
			</tr>';
			endif;
			if($payment[0]->total_other_payments!=0 || $payment[0]->total_other_payments!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_employee_set_other_payment').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_other_payments).'</td>
			</tr>';
			endif;
			
			$total_earning = $bs + $allowances_amount + $overtime_amount + $commissions_amount + $other_payments_amount;
			$total_deduction = $loan_de_amount + $statutory_deduction_amount;
			$total_net_salary = $total_earning - $total_deduction;
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_net_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign(number_format($total_net_salary, 2, '.', ',')).'</td>
			</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl2, true, false, false, false, '');
		}*/		
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td align="right" colspan="1">This is a computer generated slip and does not require signature.</td>
			</tr>
		</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
				
		// ---------------------------------------------------------
		
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y", strtotime($payment[0]->year_to_date)));
		//Close and output PDF document
		ob_start();
		$pdf->Output('payslip_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
	 }	 
	 public function pdf_createv2(){
		 	
			//$this->load->library('Pdf');
		$system = $this->Xin_model->read_setting_info(1);		
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$id = $this->uri->segment(5);
		$payment = $this->Payroll_model->read_salary_payslip_info($id);
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
		if(!is_null($_des_name)){
			$_designation_name = $_des_name[0]->designation_name;
		} else {
			$_designation_name = '';
		}
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$_department_name = $department[0]->department_name;
		} else {
			$_department_name = '';
		}
		//$location = $this->Xin_model->read_location_info($department[0]->location_id);
		// company info
		$company = $this->Xin_model->read_company_info($user[0]->company_id);
		
		
		$p_method = '';
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
		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
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
		$pdf->SetHeaderData('../../../uploads/logo/payroll/'.$system[0]->payroll_logo, 40, $company_name, $header_string);
			
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
		$pdf->SetAuthor('HRSALE');
		$pdf->SetTitle($company_name.' - '.$this->lang->line('xin_print_payslip'));
		$pdf->SetSubject($this->lang->line('xin_payslip'));
		$pdf->SetKeywords($this->lang->line('xin_payslip'));
		// set font
		$pdf->SetFont('helvetica', 'B', 10);
				
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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
		$pdf->SetFont('dejavusans', '', 10, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();		
		// -----------------------------------------------------------------------------
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
		//
		$statutory_deduction_amount = 0; $loan_de_amount = 0; $allowances_amount = 0;
		$commissions_amount = 0; $other_payments_amount = 0; $overtime_amount = 0;		
		// laon
		if($count_loan > 0):
			foreach($loan->result() as $r_loan) {
				$loan_de_amount += $r_loan->loan_amount;
			}	
			$loan_de_amount = $loan_de_amount;
		else:
			$loan_de_amount = 0;
		endif;
		// allowances
		$allowances_amount = 0; foreach($allowances->result() as $sl_allowances) {
			$allowances_amount += $sl_allowances->allowance_amount;
		}
		// commission
		$commissions_amount = 0; foreach($commissions->result() as $sl_commissions) {
			$commissions_amount += $sl_commissions->commission_amount;
		}
		// statutory deduction
		$statutory_deduction_amount = 0; foreach($statutory_deductions->result() as $sl_statutory_deductions) {
			//$statutory_deduction_amount += $sl_statutory_deductions->deduction_amount;
			if($system[0]->statutory_fixed!='yes'):
				$sta_salary = $bs;
				$st_amount = $sta_salary / 100 * $sl_statutory_deductions->deduction_amount;
				$statutory_deduction_amount += $st_amount;
			else:
				$statutory_deduction_amount += $sl_statutory_deductions->deduction_amount;
			endif;
		}
		// other amount
		$other_payments_amount = 0; foreach($other_payments->result() as $sl_other_payments) {
			$other_payments_amount += $sl_other_payments->payments_amount;
		}
		// overtime
		$overtime_amount = 0; foreach($overtime->result() as $r_overtime) {
			$overtime_total = $r_overtime->overtime_hours * $r_overtime->overtime_rate;
			$overtime_amount += $overtime_total;
		}
		$tbl = '<br><br>
		<table cellpadding="1" cellspacing="1" border="0">
			<tr>
				<td align="center"><h1>'.$this->lang->line('xin_payslip').'</h1></td>
			</tr>
			<tr>
				<td align="center"><strong>'.$this->lang->line('xin_payslip_number').':</strong> #'.$payment[0]->payslip_id.'</td>
			</tr>
			<tr>
				<td align="center"><strong>'.$this->lang->line('xin_salary_month').':</strong> '.date("F Y", strtotime($payment[0]->year_to_date)).'</td>
			</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// -----------------------------------------------------------------------------
		// set cell padding
		$pdf->setCellPaddings(1, 1, 1, 1);
		
		// set cell margins
		$pdf->setCellMargins(0, 0, 0, 0);
		
		// set color for background
		$pdf->SetFillColor(255, 255, 127);
		// set some text for example
		$txt = 'Employee Details';
		// Multicell
		$pdf->MultiCell(180, 6, $txt, 0, 'L', 11, 0, '', '', true);
		$pdf->Ln(7);
		$tbl1 = '
		<table cellpadding="3" cellspacing="0" border="1">
			<tr>
				<td>'.$this->lang->line('xin_name').'</td>
				<td>'.$fname.'</td>
				<td>'.$this->lang->line('dashboard_employee_id').'</td>
				<td>'.$user[0]->employee_id.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('left_department').'</td>
				<td>'.$_department_name.'</td>
				<td>'.$this->lang->line('left_designation').'</td>
				<td>'.$_designation_name.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_e_details_date').'</td>
				<td>'.date("d F, Y").'</td>
				<td>'.$this->lang->line('xin_payslip_number').'</td>
				<td>'.$payment[0]->payslip_id.'</td>
			</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl1, true, false, true, false, '');
		
		$total_earning = $bs + $allowances_amount + $commissions_amount + $other_payments_amount + $overtime_amount;	
		$total_deductions = $loan_de_amount + $statutory_deduction_amount;
		$pdf->Ln(7);
		$tblc = '<table cellpadding="3" cellspacing="0" border="1"><tr>
				<td colspan="2">'.$this->lang->line('xin_payroll_total_earning').'</td>
				<td colspan="2">'.$this->lang->line('xin_payroll_total_deductions').'</td>				
			</tr>
			<tr>
				<td colspan="2">'.$this->Xin_model->currency_sign($total_earning).'</td>
				<td colspan="2">'.$this->Xin_model->currency_sign($total_deductions).'</td>				
			</tr>
			</table>';
		$pdf->writeHTML($tblc, true, false, true, false, '');
		
		if(null!=$this->uri->segment(4) && $this->uri->segment(4)=='p') {
		// -----------------------------------------------------------------------------		
		$tbl2 = '';
		// -----------------------------------------------------------------------------
		$txt = 'Payslip Details';

		// Multicell test
		$pdf->MultiCell(180, 6, $txt, 0, 'L', 11, 0, '', '', true);
		$pdf->Ln(7);
		$tbl2 .= '
		<table cellpadding="3" cellspacing="0" border="1">';
			 if($payment[0]->wages_type == 1){
			$tbl2 .= ' <tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_basic_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->basic_salary).'</td>
			</tr>';
			} else {
				$tbl2 .= ' <tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_employee_daily_wages').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->daily_wages).'</td>
			</tr>';
			}
			if($payment[0]->total_allowances!=0 || $payment[0]->total_allowances!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_allowance').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_allowances).'</td>
			</tr>';
			endif;
			if($payment[0]->total_commissions!=0 || $payment[0]->total_commissions!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_hr_commissions').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_commissions).'</td>
			</tr>';
			endif;
			if($payment[0]->total_loan!=0 || $payment[0]->total_loan!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_loan').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_loan).'</td>
			</tr>';
			endif;
			if($payment[0]->total_overtime!=0 || $payment[0]->total_overtime!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_overtime').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_overtime).'</td>
			</tr>';
			endif;
			if($payment[0]->total_statutory_deductions!=0 || $payment[0]->total_statutory_deductions!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_employee_set_statutory_deductions').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_statutory_deductions).'</td>
			</tr>';
			endif;
			if($payment[0]->total_other_payments!=0 || $payment[0]->total_other_payments!=''):
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_employee_set_other_payment').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_other_payments).'</td>
			</tr>';
			endif;
			/*if($payment[0]->wages_type == 1){
				$bs = $payment[0]->basic_salary;
			} else {
				$bs = $payment[0]->daily_wages;
			}*/
			$total_earning = $bs + $allowances_amount + $overtime_amount + $commissions_amount + $other_payments_amount;
			$total_deduction = $loan_de_amount + $statutory_deduction_amount;
			$total_net_salary = $total_earning - $total_deduction;
			$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_net_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign(number_format($total_net_salary, 2, '.', ',')).'</td>
			</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl2, true, false, false, false, '');
		}		
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td align="right" colspan="1">This is a computer generated slip and does not require signature.</td>
			</tr>
		</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
				
		// ---------------------------------------------------------
		
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y", strtotime($payment[0]->year_to_date)));
		//Close and output PDF document
		ob_start();
		$pdf->Output('payslip_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
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
				//'is_half_monthly' => $user[0]->is_half_monthly,
				//'half_deduct_month' => $user[0]->half_deduct_month,
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
	public function payslip_delete_all($id) {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $id;
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$this->Payroll_model->delete_record($id);
		$this->Payroll_model->delete_payslip_allowances_items($id);
		$this->Payroll_model->delete_payslip_commissions_items($id);
		$this->Payroll_model->delete_payslip_other_payment_items($id);
		$this->Payroll_model->delete_payslip_statutory_deductions_items($id);
		$this->Payroll_model->delete_payslip_overtime_items($id);
		$this->Payroll_model->delete_payslip_loan_items($id);
	}
	
	// get company > locations
	 public function get_company_plocations() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'company_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/payroll/get_company_plocations", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get location > departments
	 public function get_location_pdepartments() {

		$data['title'] = $this->Xin_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
		
			$data = array(
				'location_id' => $id
				);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/payroll/get_location_pdepartments", $data);
			} else {
				redirect('admin/');
			}
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 public function get_department_pdesignations() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/get_department_pdesignations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	  // Validate and update info in database // update_status
	public function update_payroll_status() {
	
		if($this->input->post('type')=='update_status') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
		if($this->input->post('status')==='') {
			$Return['error'] = $this->lang->line('xin_error_template_status');
		}	
		if($Return['error']!=''){
			$this->output($Return);
    	}
		$data = array(
		'status' => $this->input->post('status'),
		);
		$id = $this->input->post('payroll_id');
		$result = $this->Payroll_model->update_payroll_status($data,$id);
		if ($result == TRUE) {
			if($this->input->post('status') == 1){
				$Return['result'] = $this->lang->line('xin_role_first_level_approved');
			} else if($this->input->post('status') == 2) {
				$Return['result'] = $this->lang->line('xin_approved_final_payroll_title');
			} else {
				$Return['result'] = $this->lang->line('xin_disabled_payroll_title');
			}
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
}
