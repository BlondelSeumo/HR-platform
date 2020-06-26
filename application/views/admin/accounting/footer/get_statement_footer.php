<?php $account_statement = $this->Finance_model->account_statement_search($from_date,$to_date,$account_id);?>
<?php
$crd_total = 0; $deb_total = 0;$balance=0; $balance2 = 0;
$acc_bal = $this->Finance_model->read_bankcash_information($account_id);
foreach($account_statement->result() as $r) {
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
}
?>
<tr>
    <th colspan="3">&nbsp;</th>
    <th><?php echo $this->lang->line('xin_acc_credit');?>: <?php echo $this->Xin_model->currency_sign($crd_total);?></th>
    <th><?php echo $this->lang->line('xin_acc_debit');?>: <?php echo $this->Xin_model->currency_sign($deb_total);?></th>
</tr>