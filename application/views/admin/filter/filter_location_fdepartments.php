<?php $result = $this->Department_model->ajax_location_departments_information($location_id);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<div class="form-group" id="ajx_department">
  <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" name="department_id" id="filter_department" >
    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
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
// get designations
jQuery("#filter_department").change(function(){
	if(jQuery(this).val() == 0){
		jQuery('#filter_company').prop('selectedIndex', 0);	
		jQuery('#filter_department').prop('selectedIndex', 0);
		jQuery('#filter_location').prop('selectedIndex', 0);
		jQuery('#filter_designation').prop('selectedIndex', 0);
	}
	jQuery.get(site_url+"employees/filter_location_fdesignation/"+jQuery(this).val(), function(data, status){
	jQuery('#designation_ajaxflt').html(data);
	});
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
<?php /*?><?php } ?><?php */?>