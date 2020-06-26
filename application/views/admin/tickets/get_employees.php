<?php $result = $this->Tickets_model->ajax_department_employee_info($company_id);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($user_info[0]->user_role_id==1){ ?>
<div class="form-group" id="employee_ajax">
  <label for="employees"><?php echo $this->lang->line('xin_ticket_for_employee');?></label>
  <select multiple="multiple" class="form-control" name="employee_id[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
    <option value=""></option>
    <?php foreach($result as $employee) {?>
    <option value="<?php echo $employee->user_id?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>             
</div>
<?php } else { ?>
<div class="form-group">
  <label for="employees"><?php echo $this->lang->line('xin_ticket_for_employee');?></label>
   <select multiple="multiple" name="employee_id[]" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
    <option value=""></option>
    <?php foreach($result as $employee) {?>
		<?php if($session['user_id'] != $employee->user_id):?>
        	<option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
        <?php endif;?>
    <?php } ?>
  </select>             
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>