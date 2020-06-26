<?php $expense_types = $this->Finance_model->ajax_company_expense_types_info($company_id);?>
<div class="form-group">
   <select required name="type_id" id="type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_select_expense_type');?>">
    <option value="0"><?php echo $this->lang->line('xin_acc_all_types');?></option>
    <?php foreach($expense_types as $expense_type) {?>
    <option value="<?php echo $expense_type->expense_type_id;?>"> <?php echo $expense_type->name;?></option>
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