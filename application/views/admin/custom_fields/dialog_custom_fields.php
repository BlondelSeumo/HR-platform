<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['custom_field_id']) && $_GET['data']=='custom_field'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_hrsale_custom_field_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_custom_field', 'id' => 'edit_custom_field', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $custom_field_id, 'ext_name' => $attribute);?>
<?php echo form_open('admin/custom_fields/update/'.$custom_field_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="module_id"><?php echo $this->lang->line('xin_modules');?><i class="hrsale-asterisk">*</i></label>
        <select class="form-control" id="module_id" name="module_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
            <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
            <option value="1" <?php if($module_id == 1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('dashboard_employees');?></option>
            <option value="2" <?php if($module_id == 2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_awards');?></option>
            <option value="3"<?php if($module_id == 3):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('dashboard_announcements');?></option>
            <option value="4"<?php if($module_id == 4):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_company');?></option>
            <option value="5"<?php if($module_id == 5):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_training');?></option>
            <option value="6"<?php if($module_id == 6):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_tickets');?></option>
            <option value="7"<?php if($module_id == 7):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_assets');?></option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="name"><?php echo $this->lang->line('xin_name');?></label>
        <small>(Can't Update)</small><br />
        <div class="hrsale-custom-field-option"><?php echo $attribute;?></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="email"><?php echo $this->lang->line('xin_hrsale_field_label');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_hrsale_field_label');?>" name="attribute_label" type="text" value="<?php echo $attribute_label;?>">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="priority"><?php echo $this->lang->line('xin_p_priority');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_p_priority');?>" name="priority" type="text" value="<?php echo $priority;?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="xin_faxn"><?php echo $this->lang->line('xin_hrsale_field_validation');?><i class="hrsale-asterisk">*</i></label>
        <select class="form-control" id="validation" name="validation" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
          <option value="0" <?php if($validation == 0):?> selected="selected"<?php endif;?>>None</option>
          <option value="1"<?php if($validation == 1):?> selected="selected"<?php endif;?> >Required</option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="phone"><?php echo $this->lang->line('xin_hrsale_field_types');?></label>
        <small>(Can't Update)</small><br />
        <div class="hrsale-custom-field-option">
          <?php if($attribute_type == 'text'):?>
          Text Field
          <?php endif;?>
          <?php if($attribute_type == 'textarea'):?>
          Text Area
          <?php endif;?>
          <?php if($attribute_type == 'select'):?>
          Select
          <?php endif;?>
          <?php if($attribute_type == 'select2multi'):?>
          Multi Select
          <?php endif;?>
          <?php if($attribute_type == 'fileupload'):?>
          File Upload
          <?php endif;?>
          <?php if($attribute_type == 'date'):?>
          Date
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_update');?></button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		 Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#edit_custom_field").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=custom_field&form="+action,
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
								url : "<?php echo site_url("admin/custom_fields/custom_fields_list") ?>",
								type : 'GET'
							},
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
<?php }
?>
