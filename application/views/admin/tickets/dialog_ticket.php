<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['ticket_id']) && $_GET['data']=='ticket'){
	$assigned_ids = explode(',',$employee_id);
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('xin_close');?>"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_ticket').' #'.$ticket_code;?></h4>
</div>
<?php $attributes = array('name' => 'edit_ticket', 'id' => 'edit_ticket', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $ticket_id, 'ext_name' => $ticket_id);?>
<?php echo form_open('admin/tickets/update/'.$ticket_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
          <div class="form-group">
          <label for="task_name"><?php echo $this->lang->line('xin_subject');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_subject');?>" name="subject" type="text" value="<?php echo $subject;?>">
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="ticket_priority" class="control-label"><?php echo $this->lang->line('xin_p_priority');?></label>
              <select name="ticket_priority" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_priority');?>">
                <option value=""></option>
                <option value="1" <?php if($ticket_priority==1):?> selected <?php endif;?>><?php echo $this->lang->line('xin_low');?></option>
                <option value="2" <?php if($ticket_priority==2):?> selected <?php endif;?>><?php echo $this->lang->line('xin_medium');?></option>
                <option value="3" <?php if($ticket_priority==3):?> selected <?php endif;?>><?php echo $this->lang->line('xin_high');?></option>
                <option value="4" <?php if($ticket_priority==4):?> selected <?php endif;?>><?php echo $this->lang->line('xin_critical');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_ticket_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_ticket_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
    <?php $count_module_attributes = $this->Custom_fields_model->count_tickets_module_attributes();?>
    <?php $module_attributes = $this->Custom_fields_model->tickets_hrsale_module_attributes();?>
    <div class="row">
      <?php foreach($module_attributes as $mattribute):?>
      <?php $attribute_info = $this->Custom_fields_model->get_employee_custom_data($ticket_id,$mattribute->custom_field_id);?>
      <?php
            if(!is_null($attribute_info)){
                $attr_val = $attribute_info->attribute_value;
            } else {
                $attr_val = '';
            }
        ?>
      <?php if($mattribute->attribute_type == 'date'){?>
      <div class="col-md-4">
        <div class="form-group">
          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
          <input class="form-control d_award_date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
        </div>
      </div>
      <?php } else if($mattribute->attribute_type == 'select'){?>
      <div class="col-md-4">
        <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
        <div class="form-group">
          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
          <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
            <?php foreach($iselc_val as $selc_val) {?>
            <option value="<?php echo $selc_val->attributes_select_value_id?>" <?php if($attr_val==$selc_val->attributes_select_value_id):?> selected="selected"<?php endif;?>><?php echo $selc_val->select_label?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php } else if($mattribute->attribute_type == 'multiselect'){?>
      <?php $multiselect_values = explode(',',$attr_val);?>
      <div class="col-md-4">
        <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
        <div class="form-group">
          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
          <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
            <?php foreach($imulti_selc_val as $multi_selc_val) {?>
            <option value="<?php echo $multi_selc_val->attributes_select_value_id?>" <?php if(in_array($multi_selc_val->attributes_select_value_id,$multiselect_values)):?> selected <?php endif;?>><?php echo $multi_selc_val->select_label?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php } else if($mattribute->attribute_type == 'textarea'){?>
      <div class="col-md-8">
        <div class="form-group">
          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
          <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
        </div>
      </div>
      <?php } else if($mattribute->attribute_type == 'fileupload'){?>
      <div class="col-md-4">
        <div class="form-group">
          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?>
            <?php if($attr_val!=''):?>
            <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('xin_download');?></a>
            <?php endif;?>
          </label>
          <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
        </div>
      </div>
      <?php } else { ?>
      <div class="col-md-4">
        <div class="form-group">
          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
          <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
        </div>
      </div>
      <?php }	?>
      <?php endforeach;?>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
					
		//$('#description2').trumbowyg();
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
		});
			 
		 Ladda.bind('button[type=submit]');
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 	

		/* Edit data */
		$("#edit_ticket").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'ticket');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						$('.icon-spinner3').hide();
						Ladda.stopAll();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/tickets/ticket_list") ?>",
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
					$('.icon-spinner3').hide();
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} 	        
	   });
	});
	});	
  </script>
<?php }
?>
