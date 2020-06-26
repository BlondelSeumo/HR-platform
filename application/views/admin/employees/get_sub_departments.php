<?php $result = get_sub_departments($department_id);?>

<div class="form-group" id="subdepartment_ajax">
  <label class="form-label"><?php echo $this->lang->line('xin_hr_sub_department');?><i class="hrsale-asterisk">*</i></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="subdepartment_id" id="aj_subdepartment" >
    <option value=""><?php echo $this->lang->line('xin_hr_sub_department');?></option>
    <?php foreach($result as $deparment) {?>
    <option value="<?php echo $deparment->sub_department_id?>"><?php echo $deparment->department_name?></option>
    <?php } ?>
  </select>
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
// get designations
jQuery("#aj_subdepartment").change(function(){
	jQuery.get(base_url+"/designation/"+jQuery(this).val(), function(data, status){
		jQuery('#designation_ajax').html(data);
	});
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>