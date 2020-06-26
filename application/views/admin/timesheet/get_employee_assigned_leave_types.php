<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($employee_id); ?>
<?php $leave_categories = explode(',',$user[0]->leave_categories);?>
<div class="form-group">
   <label for="employee"><?php echo $this->lang->line('xin_leave_type');?></label>
   <select class="form-control" id="leave_type" name="leave_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
    <option value=""></option>
    <?php foreach($leave_categories as $leave_cat) {?>
    <?php if($leave_cat!=0):?>
    <?php
		$remaining_leave = $this->Timesheet_model->employee_count_total_leaves($leave_cat,$employee_id);
		$type = $this->Timesheet_model->read_leave_type_information($leave_cat);
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
			$total = $type[0]->days_per_year;
			$leave_remaining_total = $total - $remaining_leave;	
	?>
    <option value="<?php echo $leave_cat;?>"> <?php echo $type_name.' ('.$leave_remaining_total.' '.$this->lang->line('xin_remaining').')';?></option>
    <?php }  endif;?>
    <?php } ?>
  </select>  
  <span id="remaining_leave" style="display:none; font-weight:600; color:#F00;">&nbsp;</span>           
</div>
<?php
//}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	/*jQuery("#leave_type").change(function(){
		var employee_id = jQuery('#employee_id').val();
		var leave_type_id = jQuery(this).val();
		if(leave_type_id == '' || leave_type_id == 0) {
			jQuery('#remaining_leave').show();
			jQuery('#remaining_leave').html('<?php echo $this->lang->line('xin_error_leave_type_field');?>');
		} else {
			jQuery.get(base_url+"/get_employees_leave/"+leave_type_id+"/"+employee_id, function(data, status){
				jQuery('#remaining_leave').show();
				jQuery('#remaining_leave').html(data);
			});
		}
		alert(employee_id + ' - - '+leave_type_id);
		
	});*/
});
</script>