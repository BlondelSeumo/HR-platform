<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['exit_id']) && $_GET['data']=='exit'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_employee_exit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_exit', 'id' => 'edit_exit', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $exit_id, 'ext_name' => $exit_id);?>
<?php echo form_open('admin/employee_exit/update/'.$exit_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exit_date"><?php echo $this->lang->line('xin_exit_date');?><i class="hrsale-asterisk">*</i></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_exit_date');?>" readonly name="exit_date" type="text" value="<?php echo $exit_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="type"><?php echo $this->lang->line('xin_type_of_exit');?><i class="hrsale-asterisk">*</i></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_type_of_exit');?>" name="type">
                <option value=""></option>
                <?php foreach($all_exit_types as $exit_type) {?>
                <option value="<?php echo $exit_type->exit_type_id?>" <?php if($exit_type->exit_type_id==$exit_type_id):?> selected="selected"<?php endif;?>><?php echo $exit_type->type;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <input type="hidden" name="employee_id" value="<?php echo $employee_id;?>" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exit_interview"><?php echo $this->lang->line('xin_exit_interview');?><i class="hrsale-asterisk">*</i></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_exit_interview');?><" name="exit_interview">
                <option value="1" <?php if(1==$exit_interview):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_yes');?></option>
                <option value="0" <?php if(0==$exit_interview):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_no');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="is_inactivate_account"><?php echo $this->lang->line('xin_exit_inactive_employee_account');?><i class="hrsale-asterisk">*</i></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_exit_inactive_employee_account');?>" name="is_inactivate_account">
                <option value="1" <?php if(1==$is_inactivate_account):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_yes');?></option>
                <option value="0" <?php if(0==$is_inactivate_account):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_no');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
          <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="reason" cols="30" rows="5" id="reason2"><?php echo $reason;?></textarea>
        </div>
      </div>
    </div>
    
    </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
				
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	
	//$('#reason2').trumbowyg();	 
	Ladda.bind('button[type=submit]');
	
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});

	/* Edit data */
	$("#edit_exit").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=exit&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : "<?php echo site_url("admin/employee_exit/exit_list") ?>",
						type : 'GET'
					},
					dom: 'lBfrtip',
					"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
					"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();          
					}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['exit_id']) && $_GET['data']=='view_exit'){
?>
<form class="m-b-1">
  <div class="modal-body">
  <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_employee_exit');?></strong></p>
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?php echo $company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_employee_to_exit');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($employee_id==$employee->user_id):?>
            <?php echo $employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_exit_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($exit_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_type_of_exit');?></th>
          <td style="display: table-cell;"><?php foreach($all_exit_types as $exit_type) {?>
            <?php if($exit_type_id==$exit_type->exit_type_id):?>
            <?php echo $exit_type->type;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_exit_interview');?></th>
          <td style="display: table-cell;"><?php if($is_inactivate_account=='1'): $in_active = $this->lang->line('xin_yes');?>
            <?php endif; ?>
            <?php if($is_inactivate_account=='0'): $in_active = $this->lang->line('xin_no');?>
            <?php endif; ?>
            <?php echo $in_active;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_exit_inactive_employee_account');?></th>
          <td style="display: table-cell;"><?php if($is_inactivate_account=='1'): $account = $this->lang->line('xin_yes');?>
            <?php endif; ?>
            <?php if($is_inactivate_account=='0'): $account = $this->lang->line('xin_no');?>
            <?php endif; ?>
            <?php echo $account;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($reason);?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
