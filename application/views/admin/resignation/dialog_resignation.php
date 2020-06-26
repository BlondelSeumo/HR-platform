<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['resignation_id']) && $_GET['data']=='resignation'){
?>
<?php $session = $this->session->userdata('username');?>
<?php
$role_resources_ids = $this->Xin_model->user_role_resource();
$user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_resignation');?></h4>
</div>
<?php $attributes = array('name' => 'edit_resign', 'id' => 'edit_resign', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $resignation_id, 'ext_name' => $resignation_id);?>
<?php echo form_open('admin/resignation/update/'.$resignation_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">      
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="notice_date"><?php echo $this->lang->line('xin_notice_date');?></label>
            <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_notice_date');?>" readonly name="notice_date" type="text" value="<?php echo $notice_date;?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="resignation_date"><?php echo $this->lang->line('xin_resignation_date');?></label>
            <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_resignation_date');?>" readonly name="resignation_date" type="text" value="<?php echo $resignation_date;?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="notice_date"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
            
            <option value=""><?php echo $this->lang->line('dashboard_xin_status');?></option>
            <option value="0" <?php if($approval_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_not_approve_payroll_title');?></option>
            <?php if($user_info[0]->user_role_id==1 || in_array('406',$role_resources_ids)){?>
            <option value="1" <?php if($approval_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_manager_level_title');?></option>
            <?php } ?>
            <?php if($user_info[0]->user_role_id==1 || in_array('407',$role_resources_ids)){?>
            <option value="2" <?php if($approval_status=='2'):?> selected <?php endif; ?>> <?php echo $this->lang->line('xin_hrd_level_title');?></option>
            <?php } ?>
            <?php if($user_info[0]->user_role_id==1 || in_array('408',$role_resources_ids)){?>
            <option value="3" <?php if($approval_status=='3'):?> selected <?php endif; ?>> <?php echo $this->lang->line('xin_gm_om_level_title');?></option>
            <?php } ?>
            
          </select>
          </div>
        </div>
      </div>
      
      
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="reason"><?php echo $this->lang->line('xin_resignation_reason');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_resignation_reason');?>" name="reason" cols="30" rows="5" id="reason2"><?php echo $reason;?></textarea>
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
		Ladda.bind('button[type=submit]');		
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});

		/* Edit data */
		$("#edit_resign").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=resignation&form="+action,
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
							url : "<?php echo site_url("admin/resignation/resignation_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['resignation_id']) && $_GET['data']=='view_resignation'){
	if($approval_status == 0){
		$app_status = $this->lang->line('xin_not_approve_payroll_title');
	} else if($approval_status == 1){
		$app_status = $this->lang->line('xin_manager_level_title');
	} else if($approval_status == 2){
		$app_status = $this->lang->line('xin_hrd_level_title');
	} else if($approval_status == 3){
		$app_status = $this->lang->line('xin_gm_om_level_title');
	} else {
		$app_status = $this->lang->line('xin_not_approve_payroll_title');
	}
?>
<form class="m-b-1">
<div class="modal-body">
<p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_resignation');?></strong></p>
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
        <th><?php echo $this->lang->line('xin_resignin_employee');?></th>
        <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
          <?php if($employee_id==$employee->user_id):?>
          <?php echo $employee->first_name.' '.$employee->last_name;?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_notice_date');?></th>
        <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($notice_date);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_resignation_date');?></th>
        <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($resignation_date);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        <td style="display: table-cell;"><?php echo $app_status;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_resignation_reason');?></th>
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
