<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['leave_id']) && $_GET['data']=='leave'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_leave');?></h4>
</div>
<?php $attributes = array('name' => 'edit_leave', 'id' => 'edit_leave', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $leave_id, 'ext_name' => $leave_id);?>
<?php echo form_open('admin/timesheet/edit_leave/'.$leave_id, $attributes, $hidden);?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_employee_info($session['user_id']);?>
<?php /*?><?php $leave_categories = $user[0]->leave_categories;?>
<?php $leaave_cat = get_employee_leave_category($leave_categories,$session['user_id']);?>
<?php if($user[0]->user_role_id==1) {?>
<?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
<?php } else {?>
<?php $dep_data = $this->Xin_model->get_company_department_employees($company_id);?>
<?php $result = $this->Xin_model->get_department_employees($user[0]->department_id);?>
<?php } ?><?php */?>
  <div class="modal-body">
    <div class="row">       
      <div class="col-md-12">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" cols="30" rows="3"><?php echo $remarks;?></textarea>
        </div>
      </div>
    <div class="col-md-12">
        <div class="form-group">
          <label for="reason"><?php echo $this->lang->line('xin_leave_reason');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_leave_reason');?>" name="reason" cols="30" rows="3" id="reason"><?php echo $reason;?></textarea>
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
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	Ladda.bind('button[type=submit]');
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_update_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	});
	$('#remarks2').trumbowyg();
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
					Ladda.stopAll();
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
					Ladda.stopAll();
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
</div>
<form class="m-b-1">
  <div class="modal-body">
  <h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_leave');?></strong></h4>
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
        <?php
			$datetime1 = new DateTime($from_date);
			$datetime2 = new DateTime($to_date);
			$interval = $datetime1->diff($datetime2);
			
			if(strtotime($from_date) == strtotime($to_date)){
				$no_of_days =1;
			} else {
				$no_of_days = $interval->format('%a') +1;
			}
			?>
        <tr>
            <th scope="row"><?php echo $this->lang->line('xin_hrsale_total_days');?></th>
            <td>
            <?php 
            if($is_half_day == 1){
                $leave_day_info = $this->lang->line('xin_hr_leave_half_day');
            } else {
                $leave_day_info = $no_of_days;
            }
            echo $leave_day_info;?>
            </td>
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
