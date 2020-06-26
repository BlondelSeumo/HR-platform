<?php
/* Payslip view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<div class="row">
  <div class="col-md-12">
    <div class="box mb-4">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('xin_payslip');?> - </strong><?php echo date("F, Y", strtotime($payment_date));?></h3>
        <div class="box-tools pull-right"> <a href="<?php echo site_url();?>admin/payroll/pdf_create/p/<?php echo $payslip_key;?>/" class="btn btn-social-icon mb-1 btn-outline-github" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $this->lang->line('xin_payroll_download_payslip');?>"><i class="fa fa-file-pdf-o"></i></a> </div>
      </div>
      <div class="box-body">
        <div class="table-responsive" data-pattern="priority-columns">
          <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
            <tbody>
              <tr>
                <td><strong class="help-split"><?php echo $this->lang->line('dashboard_employee_id');?>: </strong>#<?php echo $employee_id;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('xin_employee_name');?>: </strong><?php echo $first_name.' '.$last_name;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('xin_payslip_number');?>: </strong><?php echo $make_payment_id;?></td>
              </tr>
              <tr>
                <td><strong class="help-split"><?php echo $this->lang->line('xin_phone');?>: </strong><?php echo $contact_no;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('xin_joining_date');?>: </strong><?php echo $this->Xin_model->set_date_format($date_of_joining);?></td>
              </tr>
              <tr>
                <td><strong class="help-split"><?php echo $this->lang->line('left_department');?>: </strong><?php echo $department_name;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('left_designation');?>: </strong><?php echo $designation_name;?></td>
                <td><strong class="help-split">&nbsp;</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $user_id = $employee_id;?>
<?php $pcount = $hours_worked;?>
<div class="row m-b-1">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_payment_details');?> </h3>
      </div>
      <div class="box-body">
        <div id="accordion">
          <div class="card hrsale-payslip mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#basic_salary" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_daily_wages');?></strong> </a> </div>
            <div id="basic_salary" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_payroll_hourly_rate');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($basic_salary);?></span></td>
                      </tr>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_payroll_hours_worked_total');?>:</strong> <span class="pull-right"><?php echo $pcount;?></span></td>
                      </tr>
                      <?php $etotal_count = $pcount * $basic_salary;?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('xin_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($etotal_count);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php $count_allowances = $this->Employees_model->count_employee_allowances_payslip($make_payment_id);?>
          <?php $allowances = $this->Employees_model->set_employee_allowances_payslip($make_payment_id);?>
          <?php if($count_allowances > 0):?>
          <div class="card hrsale-payslip mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_allowances" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_allowances');?></strong> </a> </div>
            <div id="set_allowances" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
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
          <?php $count_commissions = $this->Employees_model->count_employee_commissions_payslip($make_payment_id);?>
          <?php $commissions = $this->Employees_model->set_employee_commissions_payslip($make_payment_id);?>
          <?php if($count_commissions > 0):?>
          <div class="card hrsale-payslip mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_commissions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_hr_commissions');?></strong> </a> </div>
            <div id="set_commissions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
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
          <?php else:?>
          <?php $commissions_amount = 0;?>
          <?php endif;?>
          <?php $count_loan = $this->Employees_model->count_employee_deductions_payslip($make_payment_id);?>
          <?php $loan = $this->Employees_model->set_employee_deductions_payslip($make_payment_id);?>
          <?php if($count_loan > 0):?>
          <div class="card hrsale-payslip mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_loan_deductions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_loan_deductions');?></strong> </a> </div>
            <div id="set_loan_deductions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $loan_de_amount = 0; foreach($loan->result() as $r_loan) { ?>
					  <?php $loan_de_amount += $r_loan->loan_amount;?>
                      <tr>
                        <td><strong><?php echo $r_loan->loan_title;?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($r_loan->loan_amount);?></span></td>
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
          <?php else:?>
          <?php $loan_de_amount = 0;?>
          <?php endif;?>
          <?php $count_statutory_deductions = $this->Employees_model->count_employee_statutory_deductions_payslip($make_payment_id);?>
          <?php $statutory_deductions = $this->Employees_model->set_employee_statutory_deductions_payslip($make_payment_id);?>
          <?php if($count_statutory_deductions > 0):?>
          <div class="card hrsale-payslip mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_statutory_deductions" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></strong> </a> </div>
            <div id="set_statutory_deductions" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
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
							$single_sd = $sl_statutory_deductions->deduction_amount;
                        endif;
                        ?>                      
                      <tr>
                        <td><strong><?php echo $sl_statutory_deductions->deduction_title;?> :</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($single_sd);?></span></td>
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
          <?php else:?>
          <?php $statutory_deductions_amount = 0;?>
          <?php endif;?>
          <?php $count_other_payments = $this->Employees_model->count_employee_other_payments_payslip($make_payment_id);?>
          <?php $other_payments = $this->Employees_model->set_employee_other_payments_payslip($make_payment_id);?>
          <?php if($count_other_payments > 0):?>
          <div class="card hrsale-payslip mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_other_payments" aria-expanded="false"> <strong><?php echo $this->lang->line('xin_employee_set_other_payment');?></strong> </a> </div>
            <div id="set_other_payments" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
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
          <?php else:?>
          <?php $other_payments_amount = 0;?>
          <?php endif;?>
          <?php $count_overtime = $this->Employees_model->count_employee_overtime_payslip($make_payment_id);?>
          <?php $overtime = $this->Employees_model->set_employee_overtime_payslip($make_payment_id);?>
          <?php if($count_overtime > 0):?>
          <div class="card hrsale-payslip mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#overtime" aria-expanded="false"> <strong><?php echo $this->lang->line('dashboard_overtime');?></strong> </a> </div>
            <div id="overtime" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
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
                        <td><?php echo $r_overtime->overtime_title;?></td>
                        <td><?php echo $r_overtime->overtime_no_of_days;?></td>
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
          <?php else:?>
          <?php $overtime_amount = 0;?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_payslip_earning');?> </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                <tbody>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_employee_daily_wages');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($etotal_count);?></span></td>
                  </tr>
                  <?php if($total_allowances!=0 || $total_allowances!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_payroll_total_allowance');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($total_allowances);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($commissions_amount!=0 || $commissions_amount!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_hr_commissions');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($commissions_amount);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($total_loan!=0 || $total_loan!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_payroll_total_loan');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign(number_format($total_loan, 2, '.', ','));?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($total_overtime!=0 || $total_overtime!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_payroll_total_overtime');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($total_overtime);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($statutory_deductions_amount!=0 || $statutory_deductions_amount!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_employee_set_statutory_deductions');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($statutory_deductions_amount);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($other_payments_amount!=0 || $other_payments_amount!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_employee_set_other_payment');?>:</strong> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($other_payments_amount);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($net_salary!=0 || $net_salary!=''):?>
                  <?php
					$total_earning = $total_allowances + $overtime_amount + $commissions_amount + $other_payments_amount;
					$total_deduction = $loan_de_amount + $statutory_deductions_amount;
					$total_net_salary = $total_earning - $total_deduction;
					if($pcount > 0){
						$total_count = $pcount * $basic_salary;
						$fsalary = $total_count + $total_net_salary;
					} else {
						$fsalary = $pcount;
					}
					$net_salary = $fsalary;
				  ?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_paid_amount');?>:</strong> <span class="pull-right"> <?php echo $this->Xin_model->currency_sign($fsalary);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php /*?><?php if($payment_method):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_payment_method');?>:</strong> <span class="pull-right"><?php echo $payment_method;?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($net_salary!=0 || $net_salary!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('xin_payment_comment');?>:</strong> <span class="pull-right"><?php echo $pay_comments;?></span></td>
                  </tr>
                  <?php endif;?><?php */?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>