<?php
/*
* Accounting View
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active">
      <a href="#smartwizard-2-step-1" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-ios-keypad"></span>
        <?php echo $this->lang->line('hr_accounting_dashboard_title');?>
        <div class="text-muted small">Set up shortcuts</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-2" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-ios-color-wand"></span>
        <?php echo $this->lang->line('xin_acc_account_list');?>
        <div class="text-muted small">Add effects</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-3" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-md-copy"></span>
        <?php echo $this->lang->line('xin_hr_new_deposit');?>
        <div class="text-muted small">Select pager options</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-4" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-md-notifications-outline"></span>
        <?php echo $this->lang->line('xin_hr_new_expense');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-5" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-md-notifications-outline"></span>
        <?php echo $this->lang->line('xin_acc_transfer');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
  </ul>
  <hr class="border-light m-0">
  <div class="mb-3 sw-container tab-content">
    <div id="smartwizard-2-step-1" class="animated fadeIn tab-pane step-content mt-3" style="display: block;">
      <div class="row">
      <div class="d-flex col-xl-12 align-items-stretch">
    
        <!-- Stats + Links -->
        <div class="card d-flex w-100 mb-4">
          <div class="row no-gutters row-bordered h-100">
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
    
              <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                <i class="lnr lnr-chart-bars display-4 d-block text-primary"></i>
                <span class="media-body d-block ml-3">
                  <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->currency_sign(dashboard_total_sales());?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('xin_total_deposit');?></small>
                </span>
              </a>
    
            </div>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
    
              <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                <i class="lnr lnr-hourglass display-4 d-block text-primary"></i>
                <span class="media-body d-block ml-3">
                  <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->currency_sign(dashboard_total_expense());?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('xin_total_expenses');?></small>
                </span>
              </a>
    
            </div>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
    
              <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
                <span class="media-body d-block ml-3">
                  <span class="text-big font-weight-bolder"><?php echo dashboard_total_payees();?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('xin_total_payees');?></small>
                </span>
              </a>
    
            </div>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
    
              <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                <i class="lnr lnr-license display-4 d-block text-primary"></i>
                <span class="media-body d-block ml-3">
                  <span class="text-big font-weight-bolder"><?php echo dashboard_total_payers();?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('xin_total_payers');?></small>
                </span>
              </a>
    
            </div>
          </div>
        </div>
        <!-- / Stats + Links -->
      </div>
    </div>
    <div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
          <h6 class="card-header with-elements mb-2">
            <div class="card-header-title"><?php echo $this->lang->line('xin_invoices_summary');?></div>
            <div class="card-header-elements ml-auto">
              <a href="<?php echo site_url('admin/invoices/');?>"><button type="button" class="btn btn-default btn-xs md-btn-flat"><?php echo $this->lang->line('dashboard_show_more');?></button></a>
            </div>
          </h6>
          <div class="row">
          <div class="col-xs-6 col-md-6 text-center">
            <input type="text" class="knob" value="<?php echo dashboard_unpaid_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#f96868" data-readonly="true">
            <div class="knob-label"><?php echo $this->lang->line('xin_payroll_unpaid');?></div>
          </div>
          <!-- ./col -->
          <div class="col-xs-6 col-md-6 text-center">
            <input type="text" class="knob" value="<?php echo dashboard_paid_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#46be8a" data-readonly="true">
            <div class="knob-label"><?php echo $this->lang->line('xin_payment_paid');?></div>
          </div>
          <!-- ./col --> 
        </div>
          <div class="table-responsive">
            <table class="table card-table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('xin_invoice_no');?></th>
                  <th width="130px;"><?php echo $this->lang->line('xin_project');?></th>
                  <th width="100px;"><?php echo $this->lang->line('xin_amount');?></th>
                  <th><?php echo $this->lang->line('xin_invoice_date');?></th>
                  <th><?php echo $this->lang->line('xin_invoice_due_date');?></th>
                  <th width="80px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach(dashboard_last_two_invoices() as $linvoices){?>
            <?php
				// get project
                  $project = $this->Project_model->read_project_information($linvoices->project_id); 
                  if(!is_null($project)){
                    $project_name = $project[0]->title;
                  } else {
                      $project_name = '--';	
                  }
				// get grand_total
			 	$grand_total = $this->Xin_model->currency_sign($linvoices->grand_total);
				$invoice_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($linvoices->invoice_date);
			  	$invoice_due_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($linvoices->invoice_due_date);
				if($linvoices->status == 0){
					$status = '<span class="badge badge-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
				} else if($linvoices->status == 1) {
					$status = '<span class="badge badge-success">'.$this->lang->line('xin_payment_paid').'</span>';
				} else {
					$status = '<span class="badge badge-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
				}
			?>
            <tr>
              <td><a href="<?php echo site_url('admin/invoices/view/');?><?php echo $linvoices->invoice_id;?>" target="_blank"> <?php echo $linvoices->invoice_number;?> </a></td>
              <td><?php echo $project_name;?></td>
              <td class="amount"><?php echo $grand_total;?></td>
              <td><?php echo $invoice_date;?></td>
              <td><?php echo $invoice_due_date;?></td>
              <td><?php echo $status;?></td>
            </tr>
            <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- / Sale stats -->

      </div>
      <div class="col-sm-6 col-xl-4">
        <div class="card mb-4">
        <h6 class="card-header with-elements">
            <div class="card-header-title"><?php echo $this->lang->line('xin_deposit_vs_expense');?></div>
          </h6>
          <div class="card-body pb-0">
            
            <div class="row">
              <div class="col-md-12">
                <div class="my-1" style="height: 140px;">
                  <canvas id="hrsale_expense_deposit" width="460" height="146" style="display: block; height: 117px; width: 368px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-center py-3">
            <div class="row">
              <div class="col">
                <div class="text-muted small"><?php echo $this->lang->line('xin_total_deposit');?></div>
                <strong class="text-big"><?php echo $this->Xin_model->currency_sign(dashboard_total_sales());?></strong>
              </div>
              <div class="col">
                <div class="text-muted small"><?php echo $this->lang->line('xin_total_expenses');?></div>
                <strong class="text-big"><?php echo $this->Xin_model->currency_sign(dashboard_total_expense());?></strong>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div id="smartwizard-2-step-2" class="animated fadeIn tab-pane step-content mt-3">
      <div class="row m-b-1">
        <?php if(in_array('4',$role_resources_ids)) {?>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_account');?></span>
            </div>
              <div class="card-body">
                <?php $attributes = array('name' => 'add_bankcash', 'id' => 'xin-form', 'autocomplete' => 'off');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/accounting/add_bankcash', $attributes, $hidden);?>
                <div class="form-group">
                  <label for="account_name"><?php echo $this->lang->line('xin_acc_account_name');?></label>
                  <input type="text" class="form-control" name="account_name" placeholder="<?php echo $this->lang->line('xin_acc_account_name');?>">
                </div>
                <div class="form-group">
                  <label for="account_balance"><?php echo $this->lang->line('xin_acc_initial_balance');?></label>
                  <input type="text" class="form-control" name="account_balance" placeholder="<?php echo $this->lang->line('xin_acc_initial_balance');?>">
                </div>
                <div class="form-group">
                  <label for="account_number"><?php echo $this->lang->line('xin_e_details_acc_number');?></label>
                  <input type="text" class="form-control" name="account_number" placeholder="<?php echo $this->lang->line('xin_e_details_acc_number');?>">
                </div>
                <div class="form-group">
                  <label for="branch_code"><?php echo $this->lang->line('xin_acc_branch_code');?></label>
                  <input type="text" class="form-control" name="branch_code" placeholder="<?php echo $this->lang->line('xin_acc_branch_code');?>">
                </div>
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_e_details_bank_branch');?></label>
                  <textarea class="form-control" name="bank_branch" placeholder="<?php echo $this->lang->line('xin_e_details_bank_branch');?>" rows="5"></textarea>
                </div>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
                <?php echo form_close(); ?> </div>
            </div>
          </div>
          <?php $colmdval = 'col-md-8';?>
          <?php } else {?>
          <?php $colmdval = 'col-md-12';?>
          <?php } ?>
          <div class="<?php echo $colmdval;?>">
            <div class="card">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_acc_accounts');?></span>
              <?php if(in_array('73',$role_resources_ids)) { ?>
              <div class="card-header-elements ml-md-auto">
                <a class="text-dark" href="<?php echo site_url('admin/accounting/account_balances');?>">
                <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_acc_account_balances');?></button>
                </a> </div>
                <?php } ?>
            </div>
              <div class="card-body">
                <div class="box-datatable table-responsive">
                  <table class="datatables-demo table table-striped table-bordered" id="xin_bank_cash_table">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('xin_action');?></th>
                        <th><?php echo $this->lang->line('xin_acc_accounts');?></th>
                        <th><?php echo $this->lang->line('xin_acc_account_no');?></th>
                        <th><?php echo $this->lang->line('xin_acc_branch_code');?></th>
                        <th><?php echo $this->lang->line('xin_acc_balance');?></th>
                        <th><?php echo $this->lang->line('xin_e_details_bank_branch');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

    </div>
    <div id="smartwizard-2-step-3" class="animated fadeIn tab-pane step-content mt-3">
      <?php if(in_array('15',$role_resources_ids)) {?>
        <div class="card mb-4">
          <div id="accordion">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_deposit');?></span>
              <div class="card-header-elements ml-md-auto">
                <a class="text-dark collapsed" data-toggle="collapse" href="#add_deposit_form" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
                </a> </div>
            </div>
            <div id="add_deposit_form" class="collapse add-form" data-parent="#accordion" style="">
              <div class="card-body">
                <?php $attributes = array('name' => 'add_deposit', 'id' => 'xin-form', 'autocomplete' => 'off');?>
                <?php $hidden = array('_user' => $session['user_id']);?>
                <?php echo form_open('admin/accounting/add_deposit', $attributes, $hidden);?>
                <div class="bg-white">
                  <div class="box-block">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="award_type"><?php echo $this->lang->line('xin_acc_account');?></label>
                          <select name="bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
                            <option value=""></option>
                            <?php foreach($all_bank_cash as $bank_cash) {?>
                            <option value="<?php echo $bank_cash->bankcash_id;?>"><?php echo $bank_cash->account_name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
                              <input class="form-control" name="amount" type="text" placeholder="<?php echo $this->lang->line('xin_amount');?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="deposit_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                              <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" readonly name="deposit_date" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="employee"><?php echo $this->lang->line('xin_acc_category');?></label>
                              <select name="category_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_category');?>">
                                <option value=""></option>
                                <?php foreach($all_income_categories_list as $income_category) {?>
                                <option value="<?php echo $income_category->category_id;?>"> <?php echo $income_category->name;?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="employee"><?php echo $this->lang->line('xin_acc_payer');?></label>
                              <select name="payer_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_a_payer');?>">
                                <option value=""></option>
                                <?php foreach($all_payers as $payer) {?>
                                <option value="<?php echo $payer->payer_id;?>"> <?php echo $payer->payer_name;?></option>
        
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                        </div>
                        <div class='form-group'>
                          <fieldset class="form-group">
                            <label for="logo"><?php echo $this->lang->line('xin_acc_attach_file');?></label>
                            <input type="file" class="form-control-file" id="deposit_file" name="deposit_file">
                          </fieldset>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
                          <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
                            <option value=""></option>
                            <?php foreach($get_all_payment_method as $payment_method) {?>
                            <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="employee"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="deposit_reference" type="text">
                          <br />
                        </div>
                      </div>
                    </div>
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?> </div>
            </div>
          </div>
        </div>
        <?php } ?>
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_acc_deposit');?></span>
            </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_deposit_table">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_acc_account');?></th>
                    <th><?php echo $this->lang->line('xin_acc_payer');?></th>
                    <th><?php echo $this->lang->line('xin_amount');?></th>
                    <th><?php echo $this->lang->line('xin_acc_category');?></th>
                    <th><?php echo $this->lang->line('xin_acc_ref_no');?></th>
                    <th><?php echo $this->lang->line('xin_acc_payment');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_date');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
    </div>
    <div id="smartwizard-2-step-4" class="animated fadeIn tab-pane step-content mt-3">
      <?php if(in_array('358',$role_resources_ids)) {?>
        <div class="card mb-4">
          <div id="accordion">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_expense');?></span>
              <div class="card-header-elements ml-md-auto">
                <a class="text-dark collapsed" data-toggle="collapse" href="#add_expense_form" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
                </a> </div>
            </div>
            <div id="add_expense_form" class="collapse add-form" data-parent="#accordion" style="">
              <div class="card-body">
                <?php $attributes = array('name' => 'add_expense', 'id' => 'xin-form', 'autocomplete' => 'off');?>
                <?php $hidden = array('_user' => $session['user_id']);?>
                <?php echo form_open('admin/accounting/add_expense', $attributes, $hidden);?>
                <div class="bg-white">
                  <div class="box-block">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="form-group">
                          <label for="bank_cash_id"><?php echo $this->lang->line('xin_acc_account');?> <span id="acc_balance" style="display:none; font-weight:600; color:#F00;"></span></label>
                          <select name="bank_cash_id" class="from-account form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
                            <option value=""></option>
                            <?php foreach($all_bank_cash as $bank_cash) {?>
                            <option value="<?php echo $bank_cash->bankcash_id;?>" account-balance="<?php echo $bank_cash->account_balance;?>"><?php echo $bank_cash->account_name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
                              <input class="form-control" name="amount" type="text" placeholder="<?php echo $this->lang->line('xin_amount');?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="expense_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                              <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" readonly name="expense_date" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <?php if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){ ?>
                          <div class="col-md-4">
                            <?php if($user_info[0]->user_role_id==1){ ?>
                            <div class="form-group">
                              <label for="department"><?php echo $this->lang->line('module_company_title');?></label>
                              <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
                                <option value=""><?php echo $this->lang->line('module_company_title');?></option>
                                <?php foreach($all_companies as $company) {?>
                                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <?php } else {?>
                            <?php $ecompany_id = $user_info[0]->company_id;?>
                            <div class="form-group">
                              <label for="department"><?php echo $this->lang->line('module_company_title');?></label>
                              <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
                                <option value=""><?php echo $this->lang->line('module_company_title');?></option>
                                <?php foreach($all_companies as $company) {?>
                                <?php if($ecompany_id == $company->company_id):?>
                                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                                <?php endif;?>
                                <?php } ?>
                              </select>
                            </div>
                            <?php } ?>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="trainer_option"><?php echo $this->lang->line('xin_payee_option');?></label>
                              <select disabled="disabled" class="form-control" name="payee_option" id="payee_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_payee_option');?>">
                                <option value="1"><?php echo $this->lang->line('xin_internal_title');?></option>
                                <option value="2"><?php echo $this->lang->line('xin_external_title');?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group" id="payee_data">
                              <label for="department"><?php echo $this->lang->line('xin_acc_payee');?></label>
                              <select id="payee_id" name="payee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_a_payee');?>">
                                <option value=""><?php echo $this->lang->line('xin_acc_payee');?></option>
                              </select>
                            </div>
                          </div>
                          <?php } else {?>
                          <input type="hidden" name="payee_id" id="payee_id" value="<?php echo $session['user_id'];?>" />
                          <input type="hidden" name="payee_option" id="payee_option" value="1" />
                          <input type="hidden" name="company" id="company" value="<?php echo $user_info[0]->company_id;?>" />
                          <?php } ?>
                          
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                        </div>
                        <div class='form-group'>
                          <fieldset class="form-group">
                            <label for="logo"><?php echo $this->lang->line('xin_acc_attach_file');?></label>
                            <input type="file" class="form-control-file" id="expense_file" name="expense_file">
                          </fieldset>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <?php if($user_info[0]->user_role_id==1){ ?>
                        <div class="col-md-3">
                            <div class="form-group" id="category_ajax">
                              <input type="hidden" name="account_balance" id="account_balance" value="" />
                              <label for="employee"><?php echo $this->lang->line('xin_acc_category');?></label>
                              <select name="category_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_category');?>">
                                <option value=""></option>
                              </select>
                            </div>
                          </div>
                          <?php } else {?>
                          <?php $eecompany_id = $user_info[0]->company_id;?>
                          <?php $expense_types = $this->Finance_model->ajax_company_expense_types_info($eecompany_id);?>
                          <div class="col-md-3">
                            <div class="form-group" id="category_ajax">
                              <input type="hidden" name="account_balance" id="account_balance" value="" />
                              <label for="employee"><?php echo $this->lang->line('xin_acc_category');?></label>
                              <select name="category_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_category');?>">
                                <option value=""></option>
                                <?php foreach($expense_types as $expense_type) {?>
                                <option value="<?php echo $expense_type->expense_type_id;?>"> <?php echo $expense_type->name;?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <?php } ?>
                          <div class="col-md-3">
                        <div class="form-group">
                          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
                          <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
                            <option value=""></option>
                            <?php foreach($get_all_payment_method as $payment_method) {?>
                            <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="expense_reference"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="expense_reference" type="text">
                          <br />
                        </div>
                      </div>
                    </div>
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?> </div>
            </div>
          </div>
        </div>
        <?php } ?>
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_acc_expense');?></span>
            </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_expense_table">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_acc_account');?></th>
                    <th><?php echo $this->lang->line('xin_acc_payee');?></th>
                    <th><?php echo $this->lang->line('xin_amount');?></th>
                    <th><?php echo $this->lang->line('xin_acc_category');?></th>
                    <th><?php echo $this->lang->line('xin_acc_ref_no');?></th>
                    <th><?php echo $this->lang->line('xin_acc_payment');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_date');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>

    </div>
    <div id="smartwizard-2-step-5" class="animated fadeIn tab-pane step-content mt-3">
      <?php if(in_array('17',$role_resources_ids)) {?>
        <div class="card mb-4">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_transfer');?></span>
            </div>
              <div class="card-body">
                <?php $attributes = array('name' => 'add_transfer', 'id' => 'xin-form', 'autocomplete' => 'off');?>
                <?php $hidden = array('_user' => $session['user_id']);?>
                <?php echo form_open('admin/accounting/add_transfer', $attributes, $hidden);?>
                <div class="bg-white">
                  <div class="box-block">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="bank_cash_id"><?php echo $this->lang->line('xin_acc_from_account');?> <span id="acc_balance" style="display:none; font-weight:600; color:#F00;"></span></label>
                          <select name="from_bank_cash_id" class="from-account form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
                            <option value=""></option>
                            <?php foreach($all_bank_cash as $bank_cash) {?>
                            <option value="<?php echo $bank_cash->bankcash_id;?>" account-balance="<?php echo $bank_cash->account_balance;?>"><?php echo $bank_cash->account_name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="transfer_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                          <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" readonly name="transfer_date" type="text">
                        </div>
                        <div class="form-group">
                          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
                          <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
                            <option value=""></option>
                            <?php foreach($get_all_payment_method as $payment_method) {?>
                            <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
                            <?php } ?>
                          </select>
                          <input type="hidden" name="account_balance" id="account_balance" value="" />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="bank_cash_id"><?php echo $this->lang->line('xin_acc_to_account');?></label>
                          <select name="to_bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
                            <option value=""></option>
                            <?php foreach($all_bank_cash as $bank_cash) {?>
                            <option value="<?php echo $bank_cash->bankcash_id;?>"><?php echo $bank_cash->account_name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
                          <input class="form-control" name="amount" type="text" placeholder="<?php echo $this->lang->line('xin_amount');?>">
                        </div>
                        <div class="form-group">
                          <label for="transfer_reference"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="transfer_reference" type="text">
                          <br />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?> </div>
          </div>
        <?php } ?>
    </div>
  </div>
</div>