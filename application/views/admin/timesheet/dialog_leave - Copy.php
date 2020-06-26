<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['leave_id']) && $_GET['data']=='leave'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_leave');?></h4>
</div>
<?php $attributes = array('name' => 'edit_leave', 'id' => 'edit_leave', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $leave_id, 'ext_name' => $leave_id);?>
<?php echo form_open('admin/timesheet/edit_leave/'.$leave_id, $attributes, $hidden);?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_employee_info($session['user_id']);?>
<?php $leave_categories = $user[0]->leave_categories;?>
<?php $leaave_cat = get_employee_leave_category($leave_categories,$session['user_id']);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="leave_type" class="control-label"><?php echo $this->lang->line('xin_leave_type');?></label>
          <select class="form-control" name="leave_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
            <option value=""></option>
            <?php foreach($leaave_cat as $type) {?>
            <option value="<?php echo $type->leave_type_id?>" <?php if($type->leave_type_id==$leave_type_id):?> selected <?php endif;?>> <?php echo $type->type_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
              <input class="form-control e_date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $from_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
              <input class="form-control e_date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $to_date;?>">
            </div>
          </div>
        </div>
        <?php $role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('383',$role_resources_ids)) { ?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected <?php endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" id="employee_ajx">
             <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
              <label for="employees" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
              <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                <option value=""></option>
                <?php foreach($result as $employee) {?>
                <option value="<?php echo $employee->user_id?>" <?php if($employee->user_id==$employee_id):?> selected <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <?php } else {?>
        
        <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $session['user_id'];?>" />
        <input type="hidden" name="company_id" id="company_id" value="<?php echo $user[0]->company_id;?>" />
        <?php } ?>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" rows="5"><?php echo $remarks;?></textarea>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="reason"><?php echo $this->lang->line('xin_leave_reason');?></label>
      <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_leave_reason');?>" name="reason" cols="30" rows="3" id="reason"><?php echo $reason;?></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
							
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_update_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	});
	$('#remarks2').trumbowyg();	
	// Date
	$('.e_date').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: '1900:' + (new Date().getFullYear() + 15),
	});
	/* Edit*/
	$("#edit_leave").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=leave&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-data').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/timesheet/leave_list") ?>",
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
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['leave_id']) && $_GET['data']=='view_leave'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_leave');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
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
        <?php $employee = $this->Xin_model->read_user_info($employee_id); ?>
			<?php if(!is_null($employee)):?><?php $eName = $employee[0]->first_name. ' '.$employee[0]->last_name;?>
			<?php else:?><?php $eName='';?><?php endif;?>
        <tr>
          <th><?php echo $this->lang->line('xin_employee');?></th>
          <td style="display: table-cell;"><?php echo $eName;?></td>
        </tr>    
        <tr>
          <th><?php echo $this->lang->line('xin_leave_type');?></th>
          <td style="display: table-cell;"><?php foreach($all_leave_types as $type) {?>
            <?php if($type->leave_type_id==$leave_type_id):?> <?php echo $type->type_name;?> <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_start_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($from_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_end_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($to_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_remarks');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($remarks);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_leave_reason');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($reason);?></td>
        </tr>
        <?php if($status=='1'):?> <?php $status_lv = $this->lang->line('xin_pending');?> <?php endif; ?>
        <?php if($status=='2'):?> <?php $status_lv = $this->lang->line('xin_approved');?> <?php endif; ?>
        <?php if($status=='3'):?> <?php $status_lv = $this->lang->line('xin_rejected');?> <?php endif; ?>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php echo $status_lv;?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }?>
