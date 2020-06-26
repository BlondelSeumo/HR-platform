<?php
/*
* All Transactions - Finance View
*/
$session = $this->session->userdata('username');
$currency = $this->Xin_model->currency_sign(0);
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $transaction = $this->Finance_model->get_transaction();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
$balance2 = 0; $total_amount = 0; $transaction_credit = 0; $transaction_debit = 0;
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
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
    <li class="nav-item active"> <a href="<?php echo site_url('admin/accounting/transactions/');?>" data-link-data="<?php echo site_url('admin/accounting/transactions/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-cube"></span> <?php echo $this->lang->line('xin_acc_transactions');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view_all');?> <?php echo $this->lang->line('xin_acc_transactions');?></div>
      </a> </li>
    <?php } ?>  
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_acc_transactions');?></span> </div>
  <div class="card-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
          <th><?php echo $this->lang->line('xin_acc_accounts');?></th>
          <th><?php echo $this->lang->line('xin_acc_dr_cr');?></th>
          <th><?php echo $this->lang->line('xin_type');?></th>
          <th><?php echo $this->lang->line('xin_amount');?></th>
          <th><?php echo $this->lang->line('xin_acc_ref_no');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
</div>