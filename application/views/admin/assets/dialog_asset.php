<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['asset_id']) && $_GET['data']=='eassets'){ ?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('xin_edit_asset');?></h4>
</div>
<?php $attributes = array('name' => 'update_asset', 'id' => 'update_asset', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $assets_id, 'ext_name' => $name);?>
<?php echo form_open_multipart('admin/assets/update_asset/'.$assets_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('xin_acc_category');?></label>
              <select class="form-control" name="category_id" id="category_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($all_assets_categories as $assets_category) {?>
                <option value="<?php echo $assets_category->assets_category_id?>" <?php if($assets_category_id==$assets_category->assets_category_id):?> selected="selected" <?php endif;?>><?php echo $assets_category->category_name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="asset_name" class="control-label"><?php echo $this->lang->line('xin_asset_name');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_asset_name');?>" name="asset_name" type="text" value="<?php echo $name?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="form-group">
              <label for="company_id"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
            <?php } else {?>
            <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="form-group">
              <label for="company_id"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($all_companies as $company) {?>
                <?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>><?php echo $company->name?></option>
                <?php endif;?>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
          </div>
          <div class="col-md-6">
            <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
            <div class="form-group" id="employee_ajx">
              <label for="first_name"><?php echo $this->lang->line('xin_assets_assign_to');?></label>
              <select class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                <option value=""></option>
                <?php foreach($result as $employee) {?>
                <option value="<?php echo $employee->user_id?>" <?php if($employee_id==$employee->user_id):?> selected="selected" <?php endif;?>><?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="manufacturer"><?php echo $this->lang->line('xin_manufacturer');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_manufacturer');?>" name="manufacturer" type="text" value="<?php echo $manufacturer?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="xin_serial_number" class="control-label"><?php echo $this->lang->line('xin_serial_number');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_serial_number');?>" name="serial_number" type="text" value="<?php echo $serial_number?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <fieldset class="form-group">
                <label for="asset_image"><?php echo $this->lang->line('xin_asset_image');?></label>
                <input type="file" class="form-control-file" id="asset_image" name="asset_image">
                <small><?php echo $this->lang->line('xin_asset_allowed_image_formats');?></small>
              </fieldset>
            </div>
          </div>
          <div class="col-md-6">
            <div class='form-group'>
              <label for="company_asset_code">&nbsp;</label>
			  <?php if($asset_image!='' && $asset_image!='no file') {?>
              <img src="<?php echo base_url().'uploads/asset_image/'.$asset_image;?>" width="70px" id="u_file"> <a href="<?php echo site_url()?>admin/download?type=asset_image&filename=<?php echo $asset_image;?>"><?php echo $this->lang->line('xin_download');?></a>
              <?php } else {?>
              <p>&nbsp;</p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="company_asset_code"><?php echo $this->lang->line('xin_company_asset_code');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_asset_code');?>" name="company_asset_code" type="text" value="<?php echo $company_asset_code?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="is_working" class="control-label"><?php echo $this->lang->line('xin_is_working');?></label>
              <select class="form-control" name="is_working" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_is_working');?>">
                <option value="1" <?php if($is_working==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_yes');?></option>
                <option value="0" <?php if($is_working==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_no');?></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="purchase_date"><?php echo $this->lang->line('xin_purchase_date');?></label>
              <input class="form-control d_assets_date" placeholder="<?php echo $this->lang->line('xin_purchase_date');?>" name="purchase_date" type="text" value="<?php echo $purchase_date?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="role"><?php echo $this->lang->line('xin_invoice_number');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_invoice_number');?>" name="invoice_number" type="text" value="<?php echo $invoice_number?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="warranty_end_date" class="control-label"><?php echo $this->lang->line('xin_warranty_end_date');?></label>
              <input class="form-control d_assets_date" placeholder="<?php echo $this->lang->line('xin_warranty_end_date');?>" name="warranty_end_date" type="text" value="<?php echo $warranty_end_date?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="award_information"><?php echo $this->lang->line('xin_asset_note');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_asset_note');?>" name="asset_note" cols="30" rows="3" id="asset_note"><?php echo $asset_note?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();?>
    <?php $module_attributes = $this->Custom_fields_model->assets_hrsale_module_attributes();?>
    <div class="row">
      <?php foreach($module_attributes as $mattribute):?>
      <?php $attribute_info = $this->Custom_fields_model->get_employee_custom_data($assets_id,$mattribute->custom_field_id);?>
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
          <input class="form-control d_assets_date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
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
    <button type="button" class="btn btn-success " data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	 Ladda.bind('button[type=submit]');
	
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	}); 
	$('.d_assets_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});

	/* Edit data */
	$("#update_asset").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("edit_type", 'update_asset');
		fd.append("form", action);
		e.preventDefault();
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
					Ladda.stopAll();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/assets/assets_list"); ?>",
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
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} 	        
	   });
	});
});	
</script>
<?php } if(isset($_GET['jd']) && isset($_GET['type']) && $_GET['data']=='view_asset'){ ?>
<form class="m-b-1">
  <div class="modal-body">
  <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_asset');?></strong></p>
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('xin_asset_name');?></th>
          <td style="display: table-cell;"><?php echo $name;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_category');?></th>
          <td style="display: table-cell;"><?php foreach($all_assets_categories as $assets_category) {?>
            <?php if($assets_category_id==$assets_category->assets_category_id):?>
            <?php echo $assets_category->category_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_company_asset_code');?></th>
          <td style="display: table-cell;"><?php echo $company_asset_code;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?php echo $company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($employee_id==$employee->user_id):?>
            <?php echo $employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_is_working');?></th>
          <td style="display: table-cell;">
		  <?php
			if($is_working==1){
				echo $working = $this->lang->line('xin_yes');
			} else {
				echo $working = $this->lang->line('xin_no');
			}
		  ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_purchase_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($purchase_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_invoice_number');?></th>
          <td style="display: table-cell;"><?php echo $invoice_number;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_manufacturer');?></th>
          <td style="display: table-cell;"><?php echo $manufacturer;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_serial_number');?></th>
          <td style="display: table-cell;"><?php echo $serial_number;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_warranty_end_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($warranty_end_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_asset_note');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($asset_note);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_asset_image');?></th>
          <td style="display: table-cell;"><?php if($asset_image!='' && $asset_image!='no file') {?>
            <img src="<?php echo base_url().'uploads/asset_image/'.$asset_image;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=asset_image&filename=<?php echo $asset_image;?>"><?php echo $this->lang->line('xin_download');?></a>
            <?php } ?></td>
        </tr>
        <?php $count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();?>
		<?php $module_attributes = $this->Custom_fields_model->assets_hrsale_module_attributes();?>
        <?php foreach($module_attributes as $mattribute):?>
          <?php $attribute_info = $this->Custom_fields_model->get_employee_custom_data($assets_id,$mattribute->custom_field_id);?>
          <?php
                if(!is_null($attribute_info)){
                    $attr_val = $attribute_info->attribute_value;
                } else {
                    $attr_val = '';
                }
            ?>
            <?php if($mattribute->attribute_type == 'date'){?>
            <tr>
                <th><?php echo $mattribute->attribute_label;?></th>
                <td style="display: table-cell;"><?php echo $attr_val;?></td>
          </tr>
          <?php } else if($mattribute->attribute_type == 'select'){?>
          <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
          <tr>
                <th><?php echo $mattribute->attribute_label;?></th>
                <td style="display: table-cell;"><?php foreach($iselc_val as $selc_val) {?> <?php if($attr_val==$selc_val->attributes_select_value_id):?> <?php echo $selc_val->select_label?> <?php endif;?><?php } ?></td>
          </tr>
          <?php } else if($mattribute->attribute_type == 'multiselect'){?>
          <?php $multiselect_values = explode(',',$attr_val);?>
          <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
          <tr>
                <th><?php echo $mattribute->attribute_label;?></th>
                <td style="display: table-cell;"><?php foreach($imulti_selc_val as $multi_selc_val) {?> <?php if(in_array($multi_selc_val->attributes_select_value_id,$multiselect_values)):?><br /> <?php echo $multi_selc_val->select_label?> <?php endif;?><?php } ?></td>
          </tr>
          <?php } else if($mattribute->attribute_type == 'textarea'){?>
          <tr>
                <th><?php echo $mattribute->attribute_label;?></th>
                <td style="display: table-cell;"><?php echo $attr_val;?></td>
          </tr>
          <?php } else if($mattribute->attribute_type == 'fileupload'){?>
          <tr>
                <th><?php echo $mattribute->attribute_label;?></th>
                <td style="display: table-cell;"><?php if($attr_val!='' && $attr_val!='no file') {?>
              <img src="<?php echo base_url().'uploads/custom_files/'.$attr_val;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('xin_download');?></a>
              <?php } ?></td>
          </tr>
          <?php } else { ?>
          <tr>
                <th><?php echo $mattribute->attribute_label;?></th>
                <td style="display: table-cell;"><?php echo $attr_val;?></td>
          </tr>
          <?php } ?>
          
          <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
