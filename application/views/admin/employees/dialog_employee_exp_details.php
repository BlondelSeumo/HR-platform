<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_document' && $_GET['type']=='emp_document'){
?>
<div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_e_details_edit_document');?></h4>
</div>
<?php $attributes = array('name' => 'e_document_info', 'id' => 'e_document_info', 'autocomplete' => 'off');?>
<?php $hidden = array('u_document_info' => 'UPDATE');?>
<?php echo form_open_multipart('admin/employees/e_document_info', $attributes, $hidden);?>
<?php
$edata_usr3 = array(
	'type'  => 'hidden',
	'id'  => 'user_id',
	'name'  => 'user_id',
	'value' => $d_employee_id,
);
echo form_input($edata_usr3);
?>
<?php
$edata_usr4 = array(
	'type'  => 'hidden',
	'id'  => 'e_field_id',
	'name'  => 'e_field_id',
	'value' => $document_id,
);
echo form_input($edata_usr4);
?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="relation"><?php echo $this->lang->line('xin_e_details_dtype');?><i class="hrsale-asterisk">*</i></label>
        <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
          <option value=""></option>
          <?php foreach($all_document_types as $document_type) {?>
          <option value="<?php echo $document_type->document_type_id;?>" <?php if($document_type->document_type_id==$document_type_id) {?> selected="selected" <?php } ?>> <?php echo $document_type->document_type;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="date_of_expiry" class="control-label"><?php echo $this->lang->line('xin_e_details_doe');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control e_date" readonly placeholder="<?php echo $this->lang->line('xin_e_details_doe');?>" name="date_of_expiry" type="text" value="<?php echo $date_of_expiry;?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="title" class="control-label"><?php echo $this->lang->line('xin_e_details_dtitle');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_dtitle');?>" name="title" type="text" value="<?php echo $title;?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="email" class="control-label"><?php echo $this->lang->line('xin_e_details_notifyemail');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_notifyemail');?>" name="email" type="email" value="<?php echo $notification_email;?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="description" class="control-label"><?php echo $this->lang->line('xin_description');?></label>
        <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"><?php echo $description;?></textarea>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <fieldset class="form-group">
          <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
          <input type="file" class="form-control-file" id="document_file" name="document_file">
          <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
          <?php if($document_file!='' && $document_file!='no file') {?>
          <br />
          <a href="<?php echo site_url('admin/download/');?>?type=document&filename=<?php echo $document_file;?>"><?php echo $document_file;?></a>
          <?php } ?>
        </fieldset>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="send_mail"><?php echo $this->lang->line('xin_e_details_send_notifyemail');?></label>
        <select name="send_mail" id="send_mail" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($is_alert=='1') {?> selected="selected" <?php } ?>><?php echo $this->lang->line('xin_yes');?></option>
          <option value="2" <?php if($is_alert=='2') {?> selected="selected" <?php } ?>><?php echo $this->lang->line('xin_no');?></option>
        </select>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_update'))); ?> </div>
<?php echo form_close(); ?> 
<script type="text/javascript">
$(document).ready(function(){			
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	Ladda.bind('button[type=submit]');
	// Date
	$('.e_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
			
	/* Update document info */
	$("#e_document_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 9);
		fd.append("type", 'e_document_info');
		fd.append("data", 'e_document_info');
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
					$('.edit-modal-data').modal('toggle');
					// On page load: table_contacts
					var xin_table_document = $('#xin_table_document').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/employees/expired_documents_list") ?>/"+$('#user_id').val(),
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_document.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='e_imgdocument' && $_GET['type']=='e_imgdocument'){
?>
<div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_immigration');?></h4>
</div>
<?php $attributes = array('name' => 'e_imgdocument_info', 'id' => 'e_imgdocument_info', 'autocomplete' => 'off');?>
<?php $hidden = array('u_document_info' => 'UPDATE');?>
<?php echo form_open_multipart('admin/employees/e_immigration_info', $attributes, $hidden);?>
<?php
$edata_usr5 = array(
	'type'  => 'hidden',
	'id'  => 'user_id',
	'name'  => 'user_id',
	'value' => $d_employee_id,
);
echo form_input($edata_usr5);
?>
<?php
$edata_usr6 = array(
	'type'  => 'hidden',
	'id'  => 'e_field_id',
	'name'  => 'e_field_id',
	'value' => $immigration_id,
);
echo form_input($edata_usr6);
?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="relation"><?php echo $this->lang->line('xin_e_details_document');?><i class="hrsale-asterisk">*</i></label>
        <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
          <option value=""></option>
          <?php foreach($all_document_types as $document_type) {?>
          <option value="<?php echo $document_type->document_type_id;?>" <?php if($document_type->document_type_id==$document_type_id) {?> selected="selected" <?php } ?>> <?php echo $document_type->document_type;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="document_number" class="control-label"><?php echo $this->lang->line('xin_employee_document_number');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_document_number');?>" name="document_number" type="text" value="<?php echo $document_number;?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="issue_date" class="control-label"><?php echo $this->lang->line('xin_issue_date');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control e_date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_issue_date');?>" name="issue_date" type="text" value="<?php echo $issue_date;?>">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="expiry_date" class="control-label"><?php echo $this->lang->line('xin_expiry_date');?><i class="hrsale-asterisk">*</i></label>
        <input class="form-control e_date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_expiry_date');?>" name="expiry_date" type="text" value="<?php echo $expiry_date;?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <fieldset class="form-group">
          <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?><i class="hrsale-asterisk">*</i></label>
          <input type="file" class="form-control-file" id="p_file2" name="document_file">
          <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
          <?php if($document_file!='' && $document_file!='no file') {?>
          <br />
          <a href="<?php echo site_url('admin/download/');?>?type=document/immigration&filename=<?php echo $document_file;?>"><?php echo $document_file;?></a>
          <?php } ?>
        </fieldset>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="eligible_review_date" class="control-label"><?php echo $this->lang->line('xin_eligible_review_date');?></label>
        <input class="form-control e_date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_eligible_review_date');?>" name="eligible_review_date" type="text" value="<?php echo $eligible_review_date;?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="send_mail"><?php echo $this->lang->line('xin_country');?></label>
        <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
          <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
          <?php foreach($all_countries as $scountry) {?>
          <option value="<?php echo $scountry->country_id;?>" <?php if($scountry->country_id==$country_id) {?> selected="selected" <?php } ?>> <?php echo $scountry->country_name;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
</div>
<?php echo form_close(); ?> 
<!--<link rel="stylesheet" href="http://localhost/hrsale_final/skin/hrsale_assets/theme_assets/bower_components/select2/dist/css/select2.min.css">
<script src="http://localhost/hrsale_final/skin/hrsale_assets/vendor/select2/dist/js/select2.min.js"></script>-->
<script type="text/javascript">
$(document).ready(function(){				
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	Ladda.bind('button[type=submit]');
	// Date
	$('.e_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});			
	/* Update document info */
	$("#e_imgdocument_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 9);
		fd.append("type", 'e_immigration_info');
		fd.append("data", 'e_immigration_info');
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
					$('.edit-modal-data').modal('toggle');
					// On page load: table_contacts
					var xin_table_immigration = $('#xin_table_imgdocument').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/employees/expired_immigration_list") ?>/"+$('#user_id').val(),
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_immigration.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='edocument_id' && $_GET['type']=='edocument_id'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('xin_edit_company');?></h4>
</div>
<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['field_id'], 'ext_name' => $license_name);?>
<?php echo form_open_multipart('admin/company/update_official_document/'.$document_id, $attributes, $hidden);?>
  <div class="modal-body">
<div class="form-body">
  <div class="row">
	<div class="col-md-6">
	  <div class="form-group">
		<label for="license_name"><?php echo $this->lang->line('xin_hr_official_license_name');?><i class="hrsale-asterisk">*</i></label>
		<input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_official_license_name');?>" name="license_name" type="text" value="<?php echo $license_name;?>">
	  </div>
	  <div class="form-group">
		<div class="row">
        <?php if($user_info[0]->user_role_id==1){ ?>
		  <div class="col-md-6">
			<label for="company_id"><?php echo $this->lang->line('left_company');?><i class="hrsale-asterisk">*</i></label>
			<select class="form-control" name="company_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_company');?>">
			  <option value=""></option>
			  <?php foreach($get_all_companies as $company) {?>
			  <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected="selected"<?php endif?>><?php echo $company->name?></option>
			  <?php } ?>
			</select>
		  </div>
          <?php } else {?>
          <?php $ecompany_id = $user_info[0]->company_id;?>
          <div class="col-md-6">
			<label for="company_id"><?php echo $this->lang->line('left_company');?><i class="hrsale-asterisk">*</i></label>
			<select class="form-control" name="company_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_company');?>">
			  <option value=""></option>
			  <?php foreach($get_all_companies as $company) {?>
              <?php if($ecompany_id == $company->company_id):?>
			  <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected="selected"<?php endif?>><?php echo $company->name?></option>
              <?php endif;?>
			  <?php } ?>
			</select>
		  </div>
          <?php } ?>
		  <div class="col-md-6">
			<label for="expiry_date"><?php echo $this->lang->line('xin_expiry_date');?><i class="hrsale-asterisk">*</i></label>
			<input class="form-control ddate" placeholder="<?php echo $this->lang->line('xin_expiry_date');?>" name="expiry_date" type="text" value="<?php echo $expiry_date;?>">
		  </div>
		</div>
		<div class="row">
		  <div class="col-md-6">
			<div class="form-group">
			  <fieldset class="form-group">
				<label for="scan_file"><?php echo $this->lang->line('xin_hr_official_license_scan');?><i class="hrsale-asterisk">*</i></label>
				<input type="file" class="form-control-file" id="scan_file" name="scan_file">
				<small><?php echo $this->lang->line('xin_company_file_type');?></small>
			  </fieldset>
              <?php echo $doc_view='<a href="'.site_url('admin/download?type=company/official_documents&filename=').$document.'">'.$this->lang->line('xin_view').'</a>';?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-md-6">
	  <div class="form-group">
		<label for="license_number"><?php echo $this->lang->line('xin_hr_official_license_number');?><i class="hrsale-asterisk">*</i></label>
		<input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_official_license_number');?>" name="license_number" type="text" value="<?php echo $license_number;?>">
	  </div>
	  <div class="form-group">
		<label for="xin_gtax"><?php echo $this->lang->line('xin_hr_official_license_alarm');?></label>
		<select class="form-control" name="license_notification" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_hr_official_license_alarm');?>">
		  <option value="0" <?php if(0==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('xin_hr_license_no_alarm');?></option>
		  <option value="1" <?php if(1==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('xin_hr_license_alarm_1');?></option>
		  <option value="3" <?php if(3==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('xin_hr_license_alarm_3');?></option>
		  <option value="6" <?php if(6==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('xin_hr_license_alarm_6');?></option>
		</select>
	  </div>
	</div>
  </div>
</div
></div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?>asd</button>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
		$('[data-plugin="xin_select"]').select2({ width:'100%' });	 
		Ladda.bind('button[type=submit]');
		// Expiry Date
		$('.ddate').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		/* Edit data */
		$("#edit_document").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'document');
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
						var xxin_table = $('#xin_table_company_license').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/employees/exp_company_license_list") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xxin_table.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='eassets_warranty' && $_GET['type']=='eassets_warranty'){ ?>
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
              <label for="first_name"><?php echo $this->lang->line('xin_acc_category');?><i class="hrsale-asterisk">*</i></label>
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
              <label for="asset_name" class="control-label"><?php echo $this->lang->line('xin_asset_name');?><i class="hrsale-asterisk">*</i></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_asset_name');?>" name="asset_name" type="text" value="<?php echo $name?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="form-group">
              <label for="company_id"><?php echo $this->lang->line('left_company');?><i class="hrsale-asterisk">*</i></label>
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
              <label for="company_id"><?php echo $this->lang->line('left_company');?><i class="hrsale-asterisk">*</i></label>
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
              <label for="first_name"><?php echo $this->lang->line('xin_assets_assign_to');?><i class="hrsale-asterisk">*</i></label>
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
                <label for="asset_image"><?php echo $this->lang->line('xin_asset_image');?><i class="hrsale-asterisk">*</i></label>
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
	
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	}); 	 
	Ladda.bind('button[type=submit]');
	// Asset Date
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
					var xin_table = $('#xin_table_assets_warranty').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/employees/assets_warranty_list"); ?>",
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
<?php }?>
