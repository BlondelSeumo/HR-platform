<?php $assigned_ids = explode(',',$assigned_to);?>
<?php $result = $this->Xin_model->all_employees();?>
<div class="form-group">
  <label for="xin_department_head"><?php echo $this->lang->line('xin_employee');?></label>
   <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee');?>">
    <option value=""></option>
    <?php foreach($result as $e_employee) {?>
	  <?php if(in_array($e_employee->user_id,$assigned_ids)){ ?>
      <option value="<?php echo $e_employee->user_id?>"> <?php echo $e_employee->first_name.' '.$e_employee->last_name;?></option>
      <?php } ?>
      <?php } ?>
  </select>             
</div>
<?php
//}
?>
<input type="hidden" value="<?php echo $company_id;?>" name="company_id" />
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>