<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['warning_id']) && $_GET['data']=='warning'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_warning_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_warning', 'id' => 'edit_warning', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $warning_id, 'ext_name' => $warning_id);?>
<?php echo form_open('admin/warning/update/'.$warning_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="type"><?php echo $this->lang->line('xin_warning_type');?></label>
            <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_warning_type');?>" name="type">
              <option value=""></option>
              <?php foreach($all_warning_types as $warning_type) {?>
              <option value="<?php echo $warning_type->warning_type_id?>" <?php if($warning_type->warning_type_id==$warning_type_id):?> selected="selected"<?php endif;?>><?php echo $warning_type->type;?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="subject"><?php echo $this->lang->line('xin_subject');?></label>
            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_subject');?>" name="subject" type="text" value="<?php echo $subject;?>">
          </div>
        </div>
      </div>
      <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="warning_date"><?php echo $this->lang->line('xin_warning_date');?></label>
        <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_warning_date');?>" readonly name="warning_date" type="text" value="<?php echo $warning_date;?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
        <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
          <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_pending');?></option>
          <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_accepted');?></option>
          <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_rejected');?></option>
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
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
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
		jQuery.get(base_url+"/get_employees_warning/"+jQuery(this).val(), function(data, status){
			jQuery('#warning_employee_ajx').html(data);
		});
	});
	
	Ladda.bind('button[type=submit]');
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	
	//$('#description2').trumbowyg();	
	
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	
	/* Edit data */
	$("#edit_warning").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=warning&form="+action,
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
						url : "<?php echo site_url("admin/warning/warning_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['warning_id']) && $_GET['data']=='view_warning'){
?>
<form class="m-b-1">
<div class="modal-body">
<p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_warning_view');?></strong></p>
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
        <th><?php echo $this->lang->line('xin_warning_to');?></th>
        <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
          <?php if($warning_to==$employee->user_id):?>
          <?php echo $employee->first_name.' '.$employee->last_name;?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_warning_type');?></th>
        <td style="display: table-cell;"><?php foreach($all_warning_types as $warning_type) {?>
          <?php if($warning_type_id==$warning_type->warning_type_id):?>
          <?php echo $warning_type->type;?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_subject');?></th>
        <td style="display: table-cell;"><?php echo $subject;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_warning_by');?></th>
        <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
          <?php if($warning_by==$employee->user_id):?>
          <?php echo $employee->first_name.' '.$employee->last_name;?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_warning_date');?></th>
        <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($warning_date);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        <td style="display: table-cell;"><?php if($status=='0'): $w_status = $this->lang->line('xin_pending');?>
          <?php endif; ?>
          <?php if($status=='1'): $w_status = $this->lang->line('xin_accepted');?>
          <?php endif; ?>
          <?php if($status=='2'): $w_status = $this->lang->line('xin_rejected');?>
          <?php endif; ?>
          <?php echo $w_status;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_attachment');?></th>
        <td style="display: table-cell;"><?php if($attachment!='' && $attachment!='no file') {?>
          <img src="<?php echo base_url().'uploads/warning/'.$attachment;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=warning&filename=<?php echo $attachment;?>"><?php echo $this->lang->line('xin_download');?></a>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_description');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
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
