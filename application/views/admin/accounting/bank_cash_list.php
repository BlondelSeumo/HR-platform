<?php
/*
* Bank/Cash - Accounting View
*/
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('286',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/accounting_dashboard/');?>" data-link-data="<?php echo site_url('admin/accounting/accounting_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('xin_hr_finance');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_accounting_dashboard_title');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('72',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/accounting/bank_cash/');?>" data-link-data="<?php echo site_url('admin/accounting/bank_cash/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-ios-cash"></span> <?php echo $this->lang->line('xin_acc_account_list');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_accounts');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('75',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/deposit/');?>" data-link-data="<?php echo site_url('admin/accounting/deposit/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-usd"></span> <?php echo $this->lang->line('xin_acc_deposit');?>
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
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php if(in_array('4',$role_resources_ids)) {?>
  <div class="col-md-4 mt-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_account');?></span> </div>
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
          <button type="submit" class="btn btn-primary"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?> mt-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_acc_accounts');?></span>
        <?php if(in_array('73',$role_resources_ids)) { ?>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark" href="<?php echo site_url('admin/accounting/account_balances');?>">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_acc_account_balances');?></button>
          </a> </div>
        <?php } ?>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
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
