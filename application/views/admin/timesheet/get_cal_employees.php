<?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
<div class="form-group">
   <label class="form-label"><?php echo $this->lang->line('xin_employee');?></label>
   <select name="employee_id" id="cal_employee_id" class="form-control custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
    <option value=""></option>
    <?php foreach($result as $employee) {?>
    <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>                
</div>
<?php
//}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>