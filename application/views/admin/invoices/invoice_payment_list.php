<?php
/*
* All Transactions - View
*/
$session = $this->session->userdata('client_username');
$currency = $this->Xin_model->currency_sign(0);
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php //$transaction = $this->Finance_model->get_transaction();?>
<?php
$balance2 = 0; $total_amount = 0; $transaction_credit = 0; $transaction_debit = 0;
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('121',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/');?>" data-link-data="<?php echo site_url('admin/invoices/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-invoice-dollar"></span> <?php echo $this->lang->line('xin_invoices_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_invoices_title');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('426',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/invoice_calendar/');?>" data-link-data="<?php echo site_url('admin/invoices/invoice_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_invoice_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('330',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/invoices/payments_history/');?>" data-link-data="<?php echo site_url('admin/invoices/payments_history/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-invoice"></span> <?php echo $this->lang->line('xin_acc_invoice_payments');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_invoice_payments');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('122',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/taxes/');?>" data-link-data="<?php echo site_url('admin/invoices/taxes/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('xin_invoice_tax_type');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_invoice_tax_type');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_acc_inv_payments');?></strong></span> </div>
  <div class="card-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <input type="hidden" id="current_currency" value="<?php //$curr = explode('0',$currency); echo $curr[0];?>" />
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_invoice_no');?></th>
          <th><?php echo $this->lang->line('xin_client_name');?></th>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
          <th><?php echo $this->lang->line('xin_amount');?></th>
          <th><?php echo $this->lang->line('xin_payment_method');?></th>
          <th><?php echo $this->lang->line('xin_description');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
</div>