<?php
/*
* All Transactions> Bank Wise - Finance View
*/
$session = $this->session->userdata('username');
$currency = $this->Xin_model->currency_sign(0);
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php
$ac_id = $this->uri->segment(4);
$transactions = $this->Finance_model->get_bankwise_transactions($ac_id);
$acc_bal = $this->Finance_model->read_bankcash_information($ac_id);
?>
<?php
$balance2 = 0;
foreach($transactions->result() as $r) {
	$balance2 = $r->amount;
}
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_acc_ledger_account_of');?></strong> <?php echo $acc_bal[0]->account_name;?></span>
    </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
        <thead>
            <tr>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('xin_type');?></th>
            <th><?php echo $this->lang->line('xin_description');?></th>
            <th><?php echo $this->lang->line('xin_acc_credit');?></th>
            <th><?php echo $this->lang->line('xin_acc_debit');?></th>
            <th><?php echo $this->lang->line('xin_acc_balance');?></th>
          </tr>
          <tr>
              <th colspan="3" class="text-right">Opening Balance</th>
              <th>&nbsp;</th><th>&nbsp;</th>
              <th><?php echo $this->Xin_model->currency_sign($acc_bal[0]->account_opening_balance);?></td>
            </tr>
        </thead>
        <tbody>
        <?php $crd_total = 0; $deb_total = 0;$balance=0; $balance2 = 0;
		foreach($transactions->result() as $r) { ?>
        <?php
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			$account_balance = 0;
			if(!is_null($acc_type)){
				$account_balance = str_replace(',','',$acc_type[0]->account_opening_balance);
			} else {
				$account_balance = 0;	
			}
			
			if($r->dr_cr == 'cr') {
				$balance2 = $balance2 - $r->amount;
			} else {
				$balance2 = $balance2 + $r->amount;
			}
			if($r->credit!=0):
				$crd = $r->credit;
				$crd_total += $crd;
			else:
				$crd = 0;	
				$crd_total += $crd;
			endif;
			if($r->debit!=0):
				$deb = $r->debit;
				$deb_total += $deb;
			else:
				$deb = 0;	
				$deb_total += $deb;
			endif;
			if($account_balance == ''){
				$account_balance = 0;
			} else {
				$account_balance = $account_balance;
			}
			$fbalance = $account_balance + $balance2;
		?>
          <tr>
            <td><?php echo $transaction_date;?></td>
            <td><?php echo $r->transaction_type;?></td>
            <td><?php echo $r->description;?></td>
            <td><?php echo $this->Xin_model->currency_sign($crd); ?></td>
            <td><?php echo $this->Xin_model->currency_sign($deb); ?></td>
            <td><?php echo $this->Xin_model->currency_sign($fbalance);?></td>
          </tr>
         <?php } ?> 
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3">&nbsp;</th>
            <th><?php echo $this->lang->line('xin_acc_credit');?>: <?php echo $this->Xin_model->currency_sign($crd_total);?></th>
            <th><?php echo $this->lang->line('xin_acc_debit');?>: <?php echo $this->Xin_model->currency_sign($deb_total);?></th>
            <th><?php echo $this->lang->line('xin_acc_balance');?>: <?php echo $this->Xin_model->currency_sign($acc_bal[0]->account_balance);?></th>
          </tr>
        </tfoot>
      </table>
      <input type="hidden" value="<?php echo $ac_id;?>" id="current_segment" />
    </div>
  </div>
</div>
