<?php $expense = $this->Finance_model->get_expense_search($from_date,$to_date,$type_id,$company_id);?>
<?php
$total_amount = 0;
foreach($expense->result() as $r) {
	// amount
	$total_amount += $r->amount;
}
?>

<tr>
  <th colspan="3">&nbsp;</th>
  <th style="float:right;"><?php echo $this->lang->line('xin_acc_total');?></th>
  <th><?php echo $this->Xin_model->currency_sign($total_amount);?></th>
</tr>
