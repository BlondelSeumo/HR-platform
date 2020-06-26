<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['department_id']) && $_GET['data']=='department'){
?>

<div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_department_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_department', 'id' => 'edit_department', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $sub_department_id, 'ext_name' => $department_name);?>
<?php echo form_open('admin/department/update_sub_record/'.$sub_department_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="department-name" class="form-control-label"><?php echo $this->lang->line('xin_name');?>:</label>
    <input type="text" class="form-control" name="department_name" value="<?php echo $department_name?>">
  </div>
  <div class="form-group">
      <label for="xin_hr_main_department"><?php echo $this->lang->line('xin_hr_main_department');?></label>
      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="department_id">
        <option value=""></option>
        <?php foreach($all_departments as $deparment) {?>
        <option value="<?php echo $deparment->department_id;?>" <?php if($deparment->department_id==$department_id):?> selected="selected"<?php endif;?>><?php echo $deparment->department_name;?></option>
        <?php } ?>
      </select>
    </div>
</div>
<div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_update'))); ?> </div>
<?php echo form_close(); ?> 
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#edit_department").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=department&form="+action,
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
							url : "<?php echo htmlspecialchars(site_url("admin/department/sub_department_list")); ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php }
?>
