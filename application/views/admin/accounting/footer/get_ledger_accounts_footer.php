<?php $acc_ledger = $this->Finance_model->get_ledger_accounts($this->input->get('from_date'),$this->input->get('to_date'));?>
<?php
$crd_total = 0; $deb_total = 0;$balance=0; $balance2 = 0;
foreach($acc_ledger->result() as $r) {
	// transaction date
	$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
	// get currency
	$total_amount = $this->Xin_model->currency_sign($r->amount);
	$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
	if(!is_null($acc_type)){
		$account_balance = $acc_type[0]->account_opening_balance;
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
	$fbalance = $account_balance + $balance2;
}
?>

<tr>
    <th colspan="3">&nbsp;</th>
    <th><?php echo $this->lang->line('xin_acc_credit');?>: <?php echo $this->Xin_model->currency_sign($crd_total);?></th>
    <th><?php echo $this->lang->line('xin_acc_debit');?>: <?php echo $this->Xin_model->currency_sign($deb_total);?></th>
    <th><?php echo $this->lang->line('xin_acc_balance');?>: <?php echo $this->Xin_model->currency_sign($fbalance);?></th>
</tr>
