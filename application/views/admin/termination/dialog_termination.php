<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['termination_id']) && $_GET['data']=='termination'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_termination');?></h4>
</div>
<?php $attributes = array('name' => 'edit_termination', 'id' => 'edit_termination', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $termination_id, 'ext_name' => $termination_id);?>
<?php echo form_open('admin/termination/update/'.$termination_id, $attributes, $hidden);?>
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
              <label for="termination_date"><?php echo $this->lang->line('xin_termination_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_termination_date');?>" readonly name="termination_date" type="text" value="<?php echo $termination_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="type"><?php echo $this->lang->line('xin_termination_type');?></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_termination_type_select');?>" name="type">
                <option value=""></option>
                <?php foreach($all_termination_types as $termination_type) {?>
                <option value="<?php echo $termination_type->termination_type_id?>" <?php if($termination_type->termination_type_id==$termination_type_id):?> selected="selected"<?php endif;?>><?php echo $termination_type->type;?></option>
                <?php } ?>
              </select>
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
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="6" id="description3"><?php echo $description;?></textarea>
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
	
	$('#description2').trumbowyg();	 
	 Ladda.bind('button[type=submit]');
	
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});

	/* Edit data */
	$("#edit_termination").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=termination&form="+action,
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
						url : "<?php echo site_url("admin/termination/termination_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['termination_id']) && $_GET['data']=='view_termination'){
?>
<form class="m-b-1">
  <div class="modal-body">
  <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_termination');?></strong></p>
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
          <th><?php echo $this->lang->line('xin_employee_terminated');?></th>
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
          <th><?php echo $this->lang->line('xin_termination_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($termination_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_termination_type');?></th>
          <td style="display: table-cell;"><?php foreach($all_termination_types as $termination_type) {?>
            <?php if($termination_type_id==$termination_type->termination_type_id):?>
            <?php echo $termination_type->type;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php if($status=='0'): $t_status = $this->lang->line('xin_pending');?>
            <?php endif; ?>
            <?php if($status=='1'): $t_status = $this->lang->line('xin_accepted');?>
            <?php endif; ?>
            <?php if($status=='2'): $t_status = $this->lang->line('xin_rejected');?>
            <?php endif; ?>
            <?php echo $t_status;?></td>
        </tr>
        <tr>
        <th><?php echo $this->lang->line('xin_attachment');?></th>
        <td style="display: table-cell;"><?php if($attachment!='' && $attachment!='no file') {?>
          <img src="<?php echo base_url().'uploads/termination/'.$attachment;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=termination&filename=<?php echo $attachment;?>"><?php echo $this->lang->line('xin_download');?></a>
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
