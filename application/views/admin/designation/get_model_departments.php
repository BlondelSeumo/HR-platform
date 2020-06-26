<?php $result = $this->Company_model->ajax_company_departments_info($company_id);?>

<div class="form-group" id="ajx_department_modal">
  <label for="designation"><?php echo $this->lang->line('xin_hr_main_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="department_id" id="aj_subdepartments_model">
    <option value=""></option>
    <?php foreach($result as $deparment) {?>
    <option value="<?php echo $deparment->department_id?>"><?php echo $deparment->department_name?></option>
    <?php } ?>
  </select>
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
// get sub departments
jQuery("#aj_subdepartments_model").change(function(){
	jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
		jQuery('#subdepartment_ajax_modal').html(data);
	});
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>