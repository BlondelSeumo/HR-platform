<?php $result = $this->Employees_model->ajax_company_officeshift_information($company_id);?>
<div class="form-group">
  <label class="form-label"><?php echo $this->lang->line('xin_employee_office_shift');?><i class="hrsale-asterisk">*</i></label>
  <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_office_shift');?>">
    <option value=""><?php echo $this->lang->line('xin_employee_office_shift');?></option>
    <?php foreach($result as $shift) {?>
    <option value="<?php echo $shift->office_shift_id?>"><?php echo $shift->shift_name?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>