<?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
<div class="form-group">
  <label for="xin_department_head"><?php echo $this->lang->line('xin_acc_payee');?></label>
   <select name="payee_id" id="payee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_a_payee');?>">
    <option value=""><?php echo $this->lang->line('xin_acc_payee');?></option>
    <?php foreach($result as $employee) {?>
    <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
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