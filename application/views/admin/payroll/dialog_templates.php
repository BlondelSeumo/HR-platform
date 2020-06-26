<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='payroll_approve' && $_GET['type']=='payroll_approve'){ ?>
<div class="modal-header animated fadeInRight">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Approve Payroll</h4>
</div>
<div class="modal-body animated fadeInRight">
Testt...
</div>
<?php }
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='payroll_template' && $_GET['type']=='payroll_template'){ ?>
<?php
$system = $this->Xin_model->read_setting_info(1);
$salary_allowances = $this->Employees_model->read_salary_allowances($employee_id);
$count_allowances = $this->Employees_model->count_employee_allowances($employee_id);
$allowance_amount = 0;
if($count_allowances > 0) {
	foreach($salary_allowances as $sl_allowances){
		$allowance_amount += $sl_allowances->allowance_amount;
	}
} else {
	$allowance_amount = 0;
}
$sta_salary = $allowance_amount + $basic_salary;
?>
<?php
if($profile_picture!='' && $profile_picture!='no file') {
	$u_file = 'uploads/profile/'.$profile_picture;
} else {
	if($gender=='Male') { 
		$u_file = 'uploads/profile/default_male.jpg';
	} else {
		$u_file = 'uploads/profile/default_female.jpg';
	}
}
?>
<div class="modal-body">
<h4 class="text-center font-weight-bol"><?php echo $this->lang->line('xin_payroll_employee_salary_details');?></h4>
<div class="container-m-nx container-m-ny ml-1">
  <div class="media col-md-12 col-lg-8 col-xl-12 py-5 mx-auto">
    <img src="<?php echo base_url().$u_file;?>" alt="<?php echo $first_name.' '.$last_name;?>" class="d-block ui-w-100 rounded-circle">
    <div class="media-body ml-3">
      <h4 class="font-weight-bold mb-1"><?php echo $first_name.' '.$last_name;?></h4>
      <div class="text-muted mb-4">
        <?php echo $designation_name;?>
      </div>
      <a href="javascript:void(0)" class="d-inline-block text-body">
        <strong><?php echo $this->lang->line('xin_emp_id');?>: &nbsp;<span class="pull-right"><?php echo $employee_id;?></span></strong>
      </a>
      <a href="javascript:void(0)" class="d-inline-block text-body">
        <strong><?php echo $this->lang->line('xin_joining_date');?>: &nbsp;<span class="pull-right"><?php echo $date_of_joining;?></span></strong>
      </a>
    </div>
  </div>
</div>
  <div class="row mb-1">
    <div class="col-sm-12 col-xs-12 col-xl-12">
      <div class="card-header text-uppercase"><b><?php echo $this->lang->line('xin_payroll_salary_details');?></b></div>
      <div class="card-block">
        <div id="accordion">
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#basic_salary" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_payroll_basic_salary');?></strong> </a> </div>
            <div id="basic_salary" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                <?php
				if($system[0]->is_half_monthly==1){
					//if($half_deduct_month==2){
						$basic_salary = $basic_salary / 2;
					//} else {
						//$basic_salary = $basic_salary;
					//}
				} else {
					$basic_salary = $basic_salary;
				}
				?>
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_payroll_basic_salary');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($basic_salary);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php $allowances = $this->Employees_model->set_employee_allowances($user_id);?>
          <?php if(!is_null($allowances)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_allowances" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_allowances');?></strong> </a> </div>
            <div id="set_allowances" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $allowance_amount = 0; foreach($allowances->result() as $sl_allowances) { ?>
                      <?php 
					  $pg_allowance_amount = $sl_allowances->allowance_amount;
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
                      ?>
                      <tr>
                        <td><strong><?php echo $sl_allowances->allowance_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($eallowance_amount);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($allowance_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          <?php $commissions = $this->Employees_model->set_employee_commissions($user_id);?>
          <?php if(!is_null($commissions)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_commissions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_hr_commissions');?></strong> </a> </div>
            <div id="set_commissions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $commissions_amount = 0; foreach($commissions->result() as $sl_commissions) { ?>
                      <?php 
					  $pg_commissions_amount = $sl_commissions->commission_amount;
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
                      ?>
					  <?php //$commissions_amount += $sl_commissions->commission_amount;?>
                      <tr>
                        <td><strong><?php echo $sl_commissions->commission_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($ecommissions_amount);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($commissions_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          <?php $loan = $this->Employees_model->set_employee_deductions($user_id);?>
          <?php if(!is_null($loan)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_loan_deductions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_loan_deductions');?></strong> </a> </div>
            <div id="set_loan_deductions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $loan_de_amount = 0; foreach($loan->result() as $r_loan) { ?>
                      <?php 
					  $pg_r_loan = $r_loan->loan_deduction_amount;
					  if($system[0]->is_half_monthly==1){
					  	  if($system[0]->half_deduct_month==2){
							  $er_loan = $r_loan->loan_deduction_amount/2;
						  } else {
							  $er_loan = $r_loan->loan_deduction_amount;
						  }
                      } else {
						  $er_loan = $r_loan->loan_deduction_amount;
                      }
					  $loan_de_amount += $er_loan;
                      ?>
					  <?php //$loan_de_amount += $r_loan->loan_deduction_amount;?>
                      <tr>
                        <td><strong><?php echo $r_loan->loan_deduction_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($er_loan);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($loan_de_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          <?php $statutory_deductions = $this->Employees_model->set_employee_statutory_deductions($user_id);?>
          <?php if(!is_null($statutory_deductions)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#statutory_deductions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></strong> </a> </div>
            <div id="statutory_deductions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
						<?php $statutory_deductions_amount = 0; foreach($statutory_deductions->result() as $sl_statutory_deductions) { ?>
                        <?php
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
							  //$loan_de_amount += $er_loan;
							  $statutory_deductions_amount += $st_amount;
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
                        endif;
                        ?>
                      <tr>
                        <td><strong><?php echo $sl_statutory_deductions->deduction_title;?>: </strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($single_sd);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($statutory_deductions_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          
          <?php $other_payments = $this->Employees_model->set_employee_other_payments($user_id);?>
          <?php if(!is_null($other_payments)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_other_payments" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_other_payment');?></strong> </a> </div>
            <div id="set_other_payments" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $other_payments_amount = 0; foreach($other_payments->result() as $sl_other_payments) { ?>
                      <?php
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
					  //$other_payments_amount += $sl_other_payments->payments_amount;?>
                      <tr>
                        <td><strong><?php echo $sl_other_payments->payments_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($epayments_amount);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($other_payments_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
		  
          <?php $overtime = $this->Employees_model->set_employee_overtime($user_id);?>
          <?php if(!is_null($overtime)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#overtime" aria-expanded="false"> <strong><?php echo $this->lang->line('dashboard_overtime');?></strong> </a> </div>
            <div id="overtime" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_title');?></th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_no_of_days');?></th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_hour');?></th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_rate');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; $overtime_amount = 0; foreach($overtime->result() as $r_overtime) { ?>
                      <?php
						
						if($system[0]->is_half_monthly==1){
							if($system[0]->half_deduct_month==2){
								$eovertime_hours = $r_overtime->overtime_hours/2;
								$eovertime_rate = $r_overtime->overtime_rate/2;
							} else {
								$eovertime_hours = $r_overtime->overtime_hours;
								$eovertime_rate = $r_overtime->overtime_rate;
							}
						} else {
							$eovertime_hours = $r_overtime->overtime_hours;
							$eovertime_rate = $r_overtime->overtime_rate;
						}
						//$other_payments_amount += $eovertime_total;
						$overtime_amount += $eovertime_hours * $eovertime_rate;
						?>
                      <tr>
                        <th scope="row"><?php echo $i;?></th>
                        <td><?php echo $r_overtime->overtime_type;?></td>
                        <td><?php echo $r_overtime->no_of_days;?></td>
                        <td><?php echo $eovertime_hours;?></td>
                        <td><?php echo $eovertime_rate;?></td>
                      </tr>
                      <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4" align="right"><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong></td>
                        <td><?php echo $this->Xin_model->currency_sign($overtime_amount);?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  
</div>
<div class="modal-footer mt-1">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php } else if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='hourly_payslip' && $_GET['type']=='read_hourly_payment'){ ?>
<?php
$system = $this->Xin_model->read_setting_info(1);
$salary_allowances = $this->Employees_model->read_salary_allowances($employee_id);
$count_allowances = $this->Employees_model->count_employee_allowances($employee_id);
$allowance_amount = 0;
if($count_allowances > 0) {
	foreach($salary_allowances as $sl_allowances){
		$allowance_amount += $sl_allowances->allowance_amount;
	}
} else {
	$allowance_amount = 0;
}
$sta_salary = $allowance_amount + $basic_salary;
?>
<?php
if($profile_picture!='' && $profile_picture!='no file') {
	$u_file = 'uploads/profile/'.$profile_picture;
} else {
	if($gender=='Male') { 
		$u_file = 'uploads/profile/default_male.jpg';
	} else {
		$u_file = 'uploads/profile/default_female.jpg';
	}
} ?>
<div class="modal-body animated fadeInRight">
<h4 class="text-center font-weight-bol"><?php echo $this->lang->line('xin_payroll_employee_salary_details');?></h4>
  <div class="container-m-nx container-m-ny ml-1">
  <div class="media col-md-12 col-lg-8 col-xl-12 py-5 mx-auto">
    <img src="<?php echo base_url().$u_file;?>" alt="<?php echo $first_name.' '.$last_name;?>" class="d-block ui-w-100 rounded-circle">
    <div class="media-body ml-3">
      <h4 class="font-weight-bold mb-1"><?php echo $first_name.' '.$last_name;?></h4>
      <div class="text-muted mb-4">
        <?php echo $designation_name;?>
      </div>

      <a href="javascript:void(0)" class="d-inline-block text-body">
        <strong><?php echo $this->lang->line('xin_emp_id');?>: &nbsp;<span class="pull-right"><?php echo $employee_id;?></span></strong>
      </a>
      <a href="javascript:void(0)" class="d-inline-block text-body">
        <strong><?php echo $this->lang->line('xin_joining_date');?>: &nbsp;<span class="pull-right"><?php echo $date_of_joining;?></span></strong>
      </a>
    </div>
  </div>
</div>
  <div class="row mb-1">
    <div class="col-sm-12 col-xs-12 col-xl-12">
      <div class="card-header text-uppercase"><b><?php echo $this->lang->line('xin_payroll_salary_details');?></b></div>
      <div class="card-block">
        <div id="accordion">
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#basic_salary" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_daily_wages');?></strong> </a> </div>
            <div id="basic_salary" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_payroll_hourly_rate');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($basic_salary);?></span></td>
                      </tr>
                        <?php
						$pay_date = $_GET['pay_date'];
						//overtime request
						$overtime_count = $this->Overtime_request_model->get_overtime_request_count($euser_id,$pay_date);
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
						$result = $this->Payroll_model->total_hours_worked($euser_id,$pay_date);
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
						?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_payroll_hours_worked_total');?>:</strong> <span class="pull-right"><?php echo $pcount;?></span></td>
                      </tr>
                      <?php $total_count = $pcount * $basic_salary;?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($total_count);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php $allowances = $this->Employees_model->set_employee_allowances($user_id);?>
          <?php if(!is_null($allowances)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_allowances" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_allowances');?></strong> </a> </div>
            <div id="set_allowances" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $allowance_amount = 0; foreach($allowances->result() as $sl_allowances) { ?>
                      <?php $allowance_amount += $sl_allowances->allowance_amount;?>
                      <tr>
                        <td><strong><?php echo $sl_allowances->allowance_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($sl_allowances->allowance_amount);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($allowance_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          <?php $commissions = $this->Employees_model->set_employee_commissions($user_id);?>
          <?php if(!is_null($commissions)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_commissions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_hr_commissions');?></strong> </a> </div>
            <div id="set_commissions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $commissions_amount = 0; foreach($commissions->result() as $sl_commissions) { ?>
                      <?php $commissions_amount += $sl_commissions->commission_amount;?>
                      <tr>
                        <td><strong><?php echo $sl_commissions->commission_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($sl_commissions->commission_amount);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($commissions_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          <?php $loan = $this->Employees_model->set_employee_deductions($user_id);?>
          <?php if(!is_null($loan)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_loan_deductions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_loan_deductions');?></strong> </a> </div>
            <div id="set_loan_deductions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $loan_de_amount = 0; foreach($loan->result() as $r_loan) { ?>
                      <?php $loan_de_amount += $r_loan->loan_deduction_amount;?>
                      <tr>
                        <td><strong><?php echo $r_loan->loan_deduction_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($r_loan->loan_deduction_amount);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($loan_de_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          <?php $statutory_deductions = $this->Employees_model->set_employee_statutory_deductions($user_id);?>
          <?php if(!is_null($statutory_deductions)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#statutory_deductions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></strong> </a> </div>
            <div id="statutory_deductions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
						<?php $statutory_deductions_amount = 0; foreach($statutory_deductions->result() as $sl_statutory_deductions) { ?>
                        <?php
                        if($system[0]->statutory_fixed!='yes'):
                            $sta_salary = $basic_salary;
                            $st_amount = $sta_salary / 100 * $sl_statutory_deductions->deduction_amount;
                            $statutory_deductions_amount += $st_amount;
							$single_sd = $st_amount;
                        else:
                            $statutory_deductions_amount += $sl_statutory_deductions->deduction_amount;
							$st_amount = $statutory_deductions_amount;
							$single_sd = $sl_statutory_deductions->deduction_amount;
                        endif;
                        ?>
                      <tr>
                        <td><strong><?php echo $sl_statutory_deductions->deduction_title;?>: </strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($single_sd);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($statutory_deductions_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
          
          <?php $other_payments = $this->Employees_model->set_employee_other_payments($user_id);?>
          <?php if(!is_null($other_payments)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_other_payments" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_other_payment');?></strong> </a> </div>
            <div id="set_other_payments" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $other_payments_amount = 0; foreach($other_payments->result() as $sl_other_payments) { ?>
                      <?php $other_payments_amount += $sl_other_payments->payments_amount;?>
                      <tr>
                        <td><strong><?php echo $sl_other_payments->payments_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($sl_other_payments->payments_amount);?></span></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($other_payments_amount);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif;?>
		  
          <?php $overtime = $this->Employees_model->set_employee_overtime($user_id);?>
          <?php if(!is_null($overtime)):?>
          <div class="card hrsale-payslip">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#overtime" aria-expanded="false"> <strong><?php echo $this->lang->line('dashboard_overtime');?></strong> </a> </div>
            <div id="overtime" class="collapse" data-parent="#accordion" style="">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_title');?></th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_no_of_days');?></th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_hour');?></th>
                        <th><?php echo $this->lang->line('xin_employee_overtime_rate');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; $overtime_amount = 0; foreach($overtime->result() as $r_overtime) { ?>
                      <?php
						$overtime_total = $r_overtime->overtime_hours * $r_overtime->overtime_rate;
						$overtime_amount += $overtime_total;
						?>
                      <tr>
                        <th scope="row"><?php echo $i;?></th>
                        <td><?php echo $r_overtime->overtime_type;?></td>
                        <td><?php echo $r_overtime->no_of_days;?></td>
                        <td><?php echo $r_overtime->overtime_hours;?></td>
                        <td><?php echo $r_overtime->overtime_rate;?></td>
                      </tr>
                      <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4" align="right"><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong></td>
                        <td><?php echo $this->Xin_model->currency_sign($overtime_amount);?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer mt-1">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php }
?>
