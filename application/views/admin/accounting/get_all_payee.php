<?php $payee = $this->Finance_model->get_payees();?>
<div class="form-group">
  <label for="payee_id"><?php echo $this->lang->line('xin_acc_payee');?></label>
   <select name="payee_id" id="payee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_payee');?>">
    <option value=""></option>
    <?php foreach($payee->result() as $paye) {?>
    <option value="<?php echo $paye->payee_id?>"><?php echo $paye->payee_name;?></option>
    <?php } ?>
  </select>             
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>