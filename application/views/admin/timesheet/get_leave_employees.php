<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_employee_info($session['user_id']); ?>
<?php if($user[0]->user_role_id==1) {?>
<?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
<?php } else {?>
<?php $dep_data = $this->Xin_model->get_company_department_employees($company_id);?>
<?php $result = $this->Xin_model->get_department_employees($user[0]->department_id);?>
<?php } ?>
<div class="form-group">
   <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
   <select name="employee_id" id="employee_idx" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
    <option value=""></option>
    <?php foreach($result as $employee) {?>
    <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
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
	jQuery("#employee_idx").change(function(){
		var employee_id = jQuery(this).val();
		jQuery.get(base_url+"/get_employee_assigned_leave_types/"+employee_id, function(data, status){
			jQuery('#get_leave_types').html(data);
		});		
	});
	
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