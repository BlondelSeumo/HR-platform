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
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_acc_inv_payments');?></strong></span> </div>
  <div class="card-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <input type="hidden" id="current_currency" value="<?php //$curr = explode('0',$currency); echo $curr[0];?>" />
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_invoice_no');?></th>
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