<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='payment' && $_GET['type']=='monthly_payment'){ ?>
<?php
$system = $this->Xin_model->read_setting_info(1);
$payment_month = strtotime($this->input->get('pay_date'));
$p_month = date('F Y',$payment_month);
if($wages_type==1){
	if($system[0]->is_half_monthly==1){
		//if($half_deduct_month==2){
			$basic_salary = $basic_salary / 2;
		//} else {
			//$basic_salary = $basic_salary;
		//}
	} else {
		$basic_salary = $basic_salary;
	}
} else {
	$basic_salary = $daily_wages;
}
?>
<?php
$salary_allowances = $this->Employees_model->read_salary_allowances($user_id);
$count_allowances = $this->Employees_model->count_employee_allowances($user_id);
$allowance_amount = 0;
if($count_allowances > 0) {
	foreach($salary_allowances as $sl_allowances){
		//$allowance_amount += $sl_allowances->allowance_amount;
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
	}
} else {
	$loan_de_amount = 0;
}
// 4: other payment
$other_payments = $this->Employees_model->set_employee_other_payments($user_id);
$other_payments_amount = 0;
if(!is_null($other_payments)):
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
		  //$commissions_amount += $sl_commissions->commission_amount;
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
			//$statutory_deductions_amount += $st_amount;
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
		endif;
	}
endif;

// 7: overtime
$salary_overtime = $this->Employees_model->read_salary_overtime($user_id);
$count_overtime = $this->Employees_model->count_employee_overtime($user_id);
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
		$overtime_amount += $eovertime_hours * $eovertime_rate;
		//$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
		//$overtime_amount += $overtime_total;
	}
} else {
	$overtime_amount = 0;
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
$add_salary = $allowance_amount + $basic_salary + $overtime_amount + $all_other_payment + $commissions_amount + $saudi_gosi;
// add amount
$net_salary_default = $add_salary - $loan_de_amount - $statutory_deductions_amount;
$sta_salary = $allowance_amount + $basic_salary;

$estatutory_deductions = $statutory_deductions_amount;
// net salary + statutory deductions
$net_salary = $net_salary_default;
$net_salary = number_format((float)$net_salary, 2, '.', '');
// check
$half_title = '1';
if($system[0]->is_half_monthly==1){
	$payment_check = $this->Payroll_model->read_make_payment_payslip_half_month_check($user_id,$this->input->get('pay_date'));
	if($payment_check->num_rows() > 1) {
		$half_title = '';
	} else if($payment_check->num_rows() > 0){
		$half_title = '('.$this->lang->line('xin_title_second_half').')';
	} else {
		$half_title = '('.$this->lang->line('xin_title_first_half').')';
	}
	$half_title = $half_title;
} else {
	$half_title = '';
}
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><strong><?php echo $this->lang->line('xin_payment_for');?></strong> <?php echo $half_title;?> <?php echo $p_month;?></h4>
</div>
<div class="modal-body" style="overflow:auto; height:530px;">
<?php $attributes = array('name' => 'pay_monthly', 'id' => 'pay_monthly', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'ADD');?>
<?php echo form_open('admin/payroll/add_pay_monthly/', $attributes, $hidden);?>
   <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <input type="hidden" name="department_id" value="<?php echo $department_id;?>" />
          <input type="hidden" name="designation_id" value="<?php echo $designation_id;?>" />
          <input type="hidden" name="company_id" value="<?php echo $company_id;?>" />
          <input type="hidden" name="location_id" value="<?php echo $location_id;?>" />
          <label for="name"><?php echo $this->lang->line('xin_payroll_basic_salary');?></label>
          <input type="text" name="gross_salary" class="form-control" value="<?php echo $basic_salary;?>">
          <input type="hidden" id="emp_id" value="<?php echo $user_id?>" name="emp_id">
          <input type="hidden" value="<?php echo $user_id;?>" name="u_id">
          <input type="hidden" value="<?php echo $basic_salary;?>" name="basic_salary">
          <input type="hidden" value="<?php echo $wages_type;?>" name="wages_type">
          <input type="hidden" value="<?php echo $this->input->get('pay_date');?>" name="pay_date" id="pay_date">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_allowance');?></label>
          <input type="text" name="total_allowances" class="form-control" value="<?php echo $allowance_amount;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_hr_commissions');?></label>
          <input type="text" name="total_commissions" class="form-control" value="<?php echo $commissions_amount;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_loan');?></label>
          <input type="text" name="total_loan" class="form-control" value="<?php echo $loan_de_amount;?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_overtime');?></label>
          <input type="text" name="total_overtime" class="form-control" value="<?php echo $overtime_amount;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></label>
          <input type="text" name="total_statutory_deductions" class="form-control" value="<?php echo $estatutory_deductions;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_employee_set_other_payment');?></label>
          <input type="text" name="total_other_payments" class="form-control" value="<?php echo $all_other_payment;?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="row">
     <?php if($system[0]->enable_saudi_gosi != 0){ ?>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_title_saudi_gosi');?></label>
          <input type="text" readonly="readonly" name="saudi_gosi_amount" class="form-control" value="<?php echo $saudi_gosi;?>">
          <input type="hidden" readonly="readonly" name="saudi_gosi_percent" value="<?php echo $system[0]->enable_saudi_gosi;?>">
        </div>
      </div>
      <?php } else {?>
      <input type="hidden" name="saudi_gosi_amount" value="0" />
      <input type="hidden" name="saudi_gosi_percent" value="0" />
      <?php } ?>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_net_salary');?></label>
          <input type="text" readonly="readonly" name="net_salary" class="form-control" value="<?php echo $net_salary;?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_payment_amount');?></label>
          <input type="text" readonly="readonly" name="payment_amount" class="form-control" value="<?php echo $net_salary;?>">
        </div>
      </div>
    </div>   
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <span><strong>NOTE:</strong> <?php echo $this->lang->line('xin_payroll_total_allowance');?>,<?php echo $this->lang->line('xin_hr_commissions');?>,<?php echo $this->lang->line('xin_payroll_total_loan');?>,<?php echo $this->lang->line('xin_payroll_total_overtime');?>,<?php echo $this->lang->line('xin_employee_set_statutory_deductions');?>,<?php echo $this->lang->line('xin_employee_set_other_payment');?> are not editable.</span>
        </div>
      </div>
    </div> 
    <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_pay'))); ?> </div>
  <?php echo form_close(); ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	// On page load: datatable					
	$("#pay_monthly").submit(function(e){
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		//$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=11&data=monthly&add_type=add_monthly_payment&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.emo_monthly_pay').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/payroll/payslip_list") ?>?employee_id=0&company_id=<?php echo $company_id;?>&month_year=<?php echo $this->input->get('pay_date');?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='hourly_payment' && $_GET['type']=='fhourly_payment'){ ?>
<?php
$system = $this->Xin_model->read_setting_info(1);
$payment_month = strtotime($this->input->get('pay_date'));
$p_month = date('F Y',$payment_month);
$basic_salary = $basic_salary;
?>
<?php
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

// 7: overtime
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

//overtime request
$overtime_count = $this->Overtime_request_model->get_overtime_request_count($euser_id,$this->input->get('pay_date'));
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
// saudi gosi
if($system[0]->enable_saudi_gosi != 0){
	$gois_amn = $basic_salary + $allowance_amount;
	$enable_saudi_gosi = $gois_amn / 100 * $system[0]->enable_saudi_gosi;
	$saudi_gosi = $enable_saudi_gosi;
} else {
	$saudi_gosi = 0;
}
// add amount
$add_salary = $allowance_amount + $overtime_amount + $all_other_payment + $commissions_amount + $saudi_gosi;
// add amount
$net_salary_default = $add_salary - $loan_de_amount - $statutory_deductions_amount;
$sta_salary = $allowance_amount + $basic_salary;

$estatutory_deductions = $statutory_deductions_amount;
// net salary + statutory deductions
$pay_date = $_GET['pay_date'];
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
if($pcount > 0){
	$total_count = $pcount * $basic_salary;
	$fsalary = $total_count + $net_salary_default;
} else {
	$fsalary = $pcount;
}
$net_salary = $fsalary;
$net_salary = number_format((float)$net_salary, 2, '.', '');
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><strong><?php echo $this->lang->line('xin_payment_for');?></strong> <?php echo $p_month;?></h4>
</div>
<div class="modal-body" style="overflow:auto; height:530px;">
<?php $attributes = array('name' => 'pay_hourly', 'id' => 'pay_hourly', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'ADD');?>
<?php echo form_open('admin/payroll/add_pay_hourly/', $attributes, $hidden);?>
   <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="hidden" name="department_id" value="<?php echo $department_id;?>" />
          <input type="hidden" name="designation_id" value="<?php echo $designation_id;?>" />
          <input type="hidden" name="company_id" value="<?php echo $company_id;?>" />
          <input type="hidden" name="location_id" value="<?php echo $location_id;?>" />
          <label for="name"><?php echo $this->lang->line('xin_payroll_hourly_rate');?></label>
          <input type="text" name="gross_salary" class="form-control" value="<?php echo $basic_salary;?>">
          <input type="hidden" id="emp_id" value="<?php echo $user_id?>" name="emp_id">
          <input type="hidden" value="<?php echo $user_id;?>" name="u_id">
          <input type="hidden" value="<?php echo $basic_salary;?>" name="basic_salary">
          <input type="hidden" value="<?php echo $wages_type;?>" name="wages_type">
          <input type="hidden" value="<?php echo $this->input->get('pay_date');?>" name="pay_date" id="pay_date">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
         <label for="name"><?php echo $this->lang->line('xin_payroll_hours_worked_total');?></label>
         <input type="text" readonly="readonly" name="hours_worked" class="form-control" value="<?php echo $pcount;?>">
        </div>
      </div>
    </div>
   <?php
	
	?>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_allowance');?></label>
          <input type="text" name="total_allowances" class="form-control" value="<?php echo $allowance_amount;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_hr_commissions');?></label>
          <input type="text" name="total_commissions" class="form-control" value="<?php echo $commissions_amount;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_loan');?></label>
          <input type="text" name="total_loan" class="form-control" value="<?php echo $loan_de_amount;?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_overtime');?></label>
          <input type="text" name="total_overtime" class="form-control" value="<?php echo $overtime_amount;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></label>
          <input type="text" name="total_statutory_deductions" class="form-control" value="<?php echo $estatutory_deductions;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_employee_set_other_payment');?></label>
          <input type="text" name="total_other_payments" class="form-control" value="<?php echo $all_other_payment;?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="row">
    <?php if($system[0]->enable_saudi_gosi != 0){ ?>
      <div class="col-md-4">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_title_saudi_gosi');?></label>
          <input type="text" readonly="readonly" name="saudi_gosi_amount" class="form-control" value="<?php echo $saudi_gosi;?>">
          <input type="hidden" readonly="readonly" name="saudi_gosi_percent" value="<?php echo $system[0]->enable_saudi_gosi;?>">
        </div>
      </div>
      <?php } else {?>
      <input type="hidden" name="saudi_gosi_amount" value="0" />
      <input type="hidden" name="saudi_gosi_percent" value="0" />
      <?php } ?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_net_salary');?></label>
          <input type="text" readonly="readonly" name="net_salary" class="form-control" value="<?php echo $net_salary;?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_payment_amount');?></label>
          <input type="text" readonly="readonly" name="payment_amount" class="form-control" value="<?php echo $net_salary;?>">
        </div>
      </div>
    </div>   
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <span><strong>NOTE:</strong> <?php echo $this->lang->line('xin_payroll_total_allowance');?>,<?php echo $this->lang->line('xin_hr_commissions');?>,<?php echo $this->lang->line('xin_payroll_total_loan');?>,<?php echo $this->lang->line('xin_payroll_total_overtime');?>,<?php echo $this->lang->line('xin_employee_set_statutory_deductions');?>,<?php echo $this->lang->line('xin_employee_set_other_payment');?> are not editable.</span>
        </div>
      </div>
    </div> 
    <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_pay'))); ?> </div>
  <?php echo form_close(); ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	// On page load: datatable					
	$("#pay_hourly").submit(function(e){
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		//$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=11&data=hourly&add_type=add_pay_hourly&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.emo_hourly_pay').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/payroll/payslip_list") ?>?employee_id=0&company_id=<?php echo $company_id;?>&month_year=<?php echo $this->input->get('pay_date');?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php }?>
