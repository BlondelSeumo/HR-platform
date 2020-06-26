<?php
/* Accounting > New Deposit view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('286',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/accounting_dashboard/');?>" data-link-data="<?php echo site_url('admin/accounting/accounting_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('xin_hr_finance');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_accounting_dashboard_title');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('72',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/bank_cash/');?>" data-link-data="<?php echo site_url('admin/accounting/bank_cash/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-ios-cash"></span> <?php echo $this->lang->line('xin_acc_account_list');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_accounts');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('75',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/accounting/deposit/');?>" data-link-data="<?php echo site_url('admin/accounting/deposit/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-usd"></span> <?php echo $this->lang->line('xin_acc_deposit');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_deposit');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('76',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/expense/');?>" data-link-data="<?php echo site_url('admin/accounting/expense/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-money-check-alt"></span> <?php echo $this->lang->line('xin_acc_expense');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_expense');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('77',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/transfer/');?>" data-link-data="<?php echo site_url('admin/accounting/transfer/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-swap"></span> <?php echo $this->lang->line('xin_acc_transfer');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_transfer_funds');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('78',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/transactions/');?>" data-link-data="<?php echo site_url('admin/accounting/transactions/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-cube"></span> <?php echo $this->lang->line('xin_acc_transactions');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view_all');?> <?php echo $this->lang->line('xin_acc_transactions');?></div>
      </a> </li>
    <?php } ?>  
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('15',$role_resources_ids)) {?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_deposit');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
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
              <button type="submit" class="btn btn-primary"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_acc_deposit');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
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
