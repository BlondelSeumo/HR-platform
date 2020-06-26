<?php $expense_types = $this->Finance_model->ajax_company_expense_types_info($company_id);?>
<div class="form-group">
   <label for="employee"><?php echo $this->lang->line('xin_acc_category');?></label>
   <select required name="category_id" id="category_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_category');?>">
    <option value=""><?php echo $this->lang->line('xin_acc_category');?></option>
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