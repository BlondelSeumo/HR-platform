<?php $result = $this->Company_model->ajax_company_departments_info($company_id);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<div class="form-group" id="ajx_department">
  <label for="designation"><?php echo $this->lang->line('xin_hr_main_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="department_id" id="aj_subdepartments">
    <option value=""></option>
    <?php foreach($result as $deparment) {?>
    <option value="<?php echo $deparment->department_id?>"><?php echo $deparment->department_name?></option>
    <?php } ?>
  </select>
</div>
<?php
//}
?>
<?php if($system[0]->is_active_sub_departments=='yes'){?>
<script type="text/javascript">
$(document).ready(function(){
// get sub departments
jQuery("#aj_subdepartments").change(function(){
	jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
		jQuery('#subdepartment_ajax').html(data);
	});
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
<?php } else {?>
<script type="text/javascript">
$(document).ready(function(){
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
<?php } ?>