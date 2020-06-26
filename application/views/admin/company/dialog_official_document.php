<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['document_id']) && $_GET['data']=='document'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('xin_edit_company');?></h4>
</div>
<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['document_id'], 'ext_name' => $license_name);?>
<?php echo form_open_multipart('admin/company/update_official_document/'.$document_id, $attributes, $hidden);?>
  <div class="modal-body">
<div class="form-body">
  <div class="row">
	<div class="col-md-6">
	  <div class="form-group">
		<label for="license_name"><?php echo $this->lang->line('xin_hr_official_license_name');?></label>
		<input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_official_license_name');?>" name="license_name" type="text" value="<?php echo $license_name;?>">
	  </div>
	  <div class="form-group">
		<div class="row">
        <?php if($user_info[0]->user_role_id==1){ ?>
		  <div class="col-md-6">
			<label for="company_id"><?php echo $this->lang->line('left_company');?></label>
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
			<label for="company_id"><?php echo $this->lang->line('left_company');?></label>
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
			<label for="expiry_date"><?php echo $this->lang->line('xin_expiry_date');?></label>
			<input class="form-control ddate" placeholder="<?php echo $this->lang->line('xin_expiry_date');?>" id="expiry_date" name="expiry_date" type="text" value="<?php echo $expiry_date;?>">
		  </div>
		</div>
		<div class="row">
		  <div class="col-md-6">
			<div class="form-group">
			  <fieldset class="form-group">
				<label for="scan_file"><?php echo $this->lang->line('xin_hr_official_license_scan');?></label>
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
	  <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="relation"><?php echo $this->lang->line('xin_e_details_dtype');?></label>
                  <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                    <option value=""></option>
                    <?php foreach($all_document_types as $document_type) {?>
                    <option value="<?php echo $document_type->document_type_id;?>" <?php if($document_type_id==$document_type->document_type_id):?> selected="selected"<?php endif?>> <?php echo $document_type->document_type;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
		<label for="license_number"><?php echo $this->lang->line('xin_hr_official_license_number');?></label>
		<input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_official_license_number');?>" name="license_number" type="text" value="<?php echo $license_number;?>">
	  </div>
              </div>
              </div>
              <!---->
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
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<style type="text/css">
.datepicker {
    z-index: 100000 !important;
    display: block;
}
</style>
<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
		$('[data-plugin="xin_select"]').select2({ width:'100%' });
		
		// Expiry Date
		$('.ddate').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: true,
			format: 'YYYY-MM-DD'
		});	 
		 Ladda.bind('button[type=submit]');
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
						var xin_official_documents_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/company/document_list") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_official_documents_table.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_document' && isset($_GET['document_id']) ){
?>
<form class="m-b-1">
  <div class="modal-body">
    <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_hr_official_document_view');?></strong></p>
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>                    
         <tr>
          <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
          <td style="display: table-cell;"><?php foreach($all_document_types as $document_type) {?>
		  <?php if($document_type_id==$document_type->document_type_id):?><?php echo $document_type->document_type;?><?php endif?><?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_hr_official_license_name');?></th>
          <td style="display: table-cell;"><?php echo $license_name;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('left_company');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
            <?php if($company_id==$company->company_id){?>
            <?php echo $company->name;?>
            <?php } } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_expiry_date');?></th>
          <td style="display: table-cell;"><?php echo $expiry_date;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_hr_official_license_number');?></th>
          <td style="display: table-cell;"><?php echo $license_number;?></span></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_hr_official_license_alarm');?></th>
          <td style="display: table-cell;"><?php
			if($license_notification==0){
				echo $notification = $this->lang->line('xin_hr_license_no_alarm');
			} else if($license_notification==1){
				echo $notification = $this->lang->line('xin_hr_license_alarm_1');
			} else if($license_notification==2){
				echo $notification = $this->lang->line('xin_hr_license_alarm_3');
			} else {
				echo $notification = $this->lang->line('xin_hr_license_alarm_6');
			}
			?></span></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_hr_official_license_scan');?></th>
          <td style="display: table-cell;"><?php if($document!='' || $document!='no-file'){?>
            <div class="avatar box-48 mr-0-5"> <?php echo $doc = '<a href="'.site_url('admin/download?type=company/official_documents&filename=').$document.'">'.$this->lang->line('xin_view').'</a>';?> </div>
            <?php } ?></td>
        </tr>
      </tbody>
    </table></div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
