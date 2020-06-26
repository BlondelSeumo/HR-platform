<?php
/* Employee Details view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php //$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);?>
<?php
$eid = $this->uri->segment(4);
$eresult = $this->Employees_model->read_employee_information($eid);
?>
<?php
$ar_sc = explode('- ',$system[0]->default_currency_symbol);
$sc_show = $ar_sc[1];
$leave_user = $this->Xin_model->read_user_info($eid);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $leave_categories_ids = explode(',',$leave_categories);?>
<?php $view_companies_ids = explode(',',$view_companies_id);?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
// reports to 
$reports_to = get_reports_team_data($session['user_id']); ?>
<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      	<?php if(in_array('351',$role_resources_ids)) { ?>  
      <li class="nav-item active"> <a href="<?php echo site_url('admin/employees/setup_salary/').$eid.'/';?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-highlight"></span> <span class="sw-icon lnr lnr-highlight"></span> <?php echo $this->lang->line('xin_employee_set_salary');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up').' '. $this->lang->line('xin_employee_set_salary');?></div>
        </a> </li>
        <?php } ?>
        <?php if(in_array('13',$role_resources_ids) || $reports_to>0) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/employees/');?>" data-link-data="<?php echo site_url('admin/employees/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('dashboard_employees');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('dashboard_employees');?></div>
      </a> </li>
    <?php } ?>
    </ul>
    <hr class="border-light m-0">
    <div class="mb-3 sw-container tab-content">
      
      <?php if(in_array('351',$role_resources_ids)) { ?> 
      <div id="smartwizard-2-step-2" class="animated fadeIn tab-pane step-content mt-3" style="display: block;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-update_salary"> <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_update_salary');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-allowances"> <i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_allowances');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-commissions"> <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_hr_commissions');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-loan_deductions"> <i class="lnr lnr-location text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_loan_deductions');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-statutory_deductions"> <i class="lnr lnr-store text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-other_payment"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_other_payment');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-overtime"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('dashboard_overtime');?></a> </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-update_salary">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_salary', 'id' => 'employee_update_salary', 'autocomplete' => 'off');?>
                      <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/update_salary_option', $attributes, $hidden);?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="wages_type"><?php echo $this->lang->line('xin_employee_type_wages');?><i class="hrsale-asterisk">*</i></label>
                              <select name="wages_type" id="wages_type" class="form-control" data-plugin="select_hrm">
                                <option value="1" <?php if($wages_type==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_payroll_basic_salary');?></option>
                                <option value="2" <?php if($wages_type==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_employee_daily_wages');?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="basic_salary"><?php echo $this->lang->line('xin_salary_title');?><i class="hrsale-asterisk">*</i></label>
                              <input class="form-control basic_salary" placeholder="<?php echo $this->lang->line('xin_salary_title');?>" name="basic_salary" type="text" value="<?php echo $basic_salary;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-allowances">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_allowances');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_allowances" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_salary_allowance_options');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_allowances');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_allowance', 'id' => 'employee_update_allowance', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/employee_allowance_option', $attributes, $hidden);?>
                      <?php
                              $data_usr4 = array(
                                'type'  => 'hidden',
                                'name'  => 'user_id',
                                'value' => $user_id,
                             );
                            echo form_input($data_usr4);
                          ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_allowance_taxable"><?php echo $this->lang->line('xin_salary_allowance_options');?><i class="hrsale-asterisk">*</i></label>
                            <select name="is_allowance_taxable" id="is_allowance_taxable" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_salary_allowance_non_taxable');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_salary_allowance_taxable');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="account_title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="allowance_title" type="text" value="" id="allowance_title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="account_number"><?php echo $this->lang->line('xin_amount');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="allowance_amount" type="text" value="" id="allowance_amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-commissions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_hr_commissions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_commissions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_hr_commissions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_commissions', 'id' => 'employee_update_commissions', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/employee_commissions_option', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="amount"><?php echo $this->lang->line('xin_amount');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-loan_deductions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_loan_deductions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_deductions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_employee_set_loan_deductions');?></th>
                                <th><?php echo $this->lang->line('xin_employee_monthly_installment_title');?></th>
                                <th><?php echo $this->lang->line('xin_employee_loan_time');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_loan_deductions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'add_loan_info', 'id' => 'add_loan_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/employee_loan_info', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
									'type'  => 'hidden',
									'name'  => 'user_id',
									'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="loan_options"><?php echo $this->lang->line('xin_salary_loan_options');?><i class="hrsale-asterisk">*</i></label>
                            <select name="loan_options" id="loan_options" class="form-control" data-plugin="select_hrm">
                              <option value="1"><?php echo $this->lang->line('xin_loan_ssc_title');?></option>
                              <option value="2"><?php echo $this->lang->line('xin_loan_hdmf_title');?></option>
                              <option value="0"><?php echo $this->lang->line('xin_loan_other_sd_title');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="month_year"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="loan_deduction_title" type="text">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="edu_role"><?php echo $this->lang->line('xin_employee_monthly_installment_title');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_monthly_installment_title');?>" name="monthly_installment" type="text" id="m_monthly_installment">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="month_year"><?php echo $this->lang->line('xin_start_date');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="readonly" name="start_date" type="text">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="end_date"><?php echo $this->lang->line('xin_end_date');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_end_date');?>" name="end_date" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description"><?php echo $this->lang->line('xin_reason');?></label>
                            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_reason');?>" name="reason" cols="30" rows="2" id="reason2"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-statutory_deductions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_statutory_deductions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_statutory_deductions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_salary_sd_options');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?>
                                  <?php if($system[0]->statutory_fixed!='yes'):?>
                                  (%)
                                  <?php endif;?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'statutory_deductions_info', 'id' => 'statutory_deductions_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/set_statutory_deductions', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="statutory_options"><?php echo $this->lang->line('xin_salary_sd_options');?><i class="hrsale-asterisk">*</i></label>
                            <select name="statutory_options" id="statutory_options" class="form-control" data-plugin="select_hrm">
                              <option value="1"><?php echo $this->lang->line('xin_sd_ssc_title');?></option>
                              <option value="2"><?php echo $this->lang->line('xin_sd_phic_title');?></option>
                              <option value="3"><?php echo $this->lang->line('xin_sd_hdmf_title');?></option>
                              <option value="4"><?php echo $this->lang->line('xin_sd_wht_title');?></option>
                              <option value="0"><?php echo $this->lang->line('xin_sd_other_sd_title');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount"><?php echo $this->lang->line('xin_amount');?>
                              <?php if($system[0]->statutory_fixed!='yes'):?>
                              (%)
                              <?php endif;?>
                              <i class="hrsale-asterisk">*</i> </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-other_payment">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_other_payment');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_other_payments" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_other_payment');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'other_payments_info', 'id' => 'other_payments_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/set_other_payments', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="amount"><?php echo $this->lang->line('xin_amount');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-overtime">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('dashboard_overtime');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_emp_overtime" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_title');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_no_of_days');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_hour');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_rate');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('dashboard_overtime');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'overtime_info', 'id' => 'overtime_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/set_overtime', $attributes, $hidden);?>
                      <?php
						  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
						 );
						echo form_input($data_usr4);
					  ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_type"><?php echo $this->lang->line('xin_employee_overtime_title');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_title');?>" name="overtime_type" type="text" value="" id="overtime_type">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="no_of_days"><?php echo $this->lang->line('xin_employee_overtime_no_of_days');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_no_of_days');?>" name="no_of_days" type="text" value="" id="no_of_days">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_hours"><?php echo $this->lang->line('xin_employee_overtime_hour');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_hour');?>" name="overtime_hours" type="text" value="" id="overtime_hours">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_rate"><?php echo $this->lang->line('xin_employee_overtime_rate');?><i class="hrsale-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_rate');?>" name="overtime_rate" type="text" value="" id="overtime_rate">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php }?>
    </div>
  </div>
</div>
