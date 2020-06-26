<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['complaint_id']) && $_GET['data']=='complaint'){
	$assigned_ids = explode(',',$complaint_against);
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_complaint');?></h4>
</div>
<?php $attributes = array('name' => 'edit_complaint', 'id' => 'edit_complaint', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $complaint_id, 'ext_name' => $complaint_id);?>
<?php echo form_open('admin/complaints/update/'.$complaint_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="title"><?php echo $this->lang->line('xin_complaint_title');?></label>
            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_complaint_title');?>" name="title" type="text" value="<?php echo $title;?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="complaint_date"><?php echo $this->lang->line('xin_complaint_date');?></label>
            <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_complaint_date');?>" readonly name="complaint_date" type="text" value="<?php echo $complaint_date;?>">
          </div>
        </div>
      </div>
      <div class="row">
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
					
		//$('#description2').trumbowyg();
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
			jQuery.get(base_url+"/get_complaint_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#complaint_employee_ajx').html(data);
			});
		});
		Ladda.bind('button[type=submit]');
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		/* Edit data */
		$("#edit_complaint").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=complaint&form="+action,
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
							url : "<?php echo site_url("admin/complaints/complaint_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['complaint_id']) && $_GET['data']=='view_complaint'){
	$assigned_ids = explode(',',$complaint_against);
?>
<form class="m-b-1">
<div class="modal-body">
<p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_complaint');?></strong></p>
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
        <th><?php echo $this->lang->line('xin_complaint_from');?></th>
        <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
          <?php if($complaint_from==$employee->user_id):?>
          <?php echo $employee->first_name.' '.$employee->last_name;?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_complaint_title');?></th>
        <td style="display: table-cell;"><?php echo $title;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_complaint_date');?></th>
        <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($complaint_date);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_complaint_against');?></th>
        <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
          <?php if(in_array($employee->user_id,$assigned_ids)):?>
          <?php echo $employee->first_name.' '.$employee->last_name;?><br />
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_attachment');?></th>
        <td style="display: table-cell;"><?php if($attachment!='' && $attachment!='no file') {?>
          <img src="<?php echo base_url().'uploads/complaints/'.$attachment;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=complaints&filename=<?php echo $attachment;?>"><?php echo $this->lang->line('xin_download');?></a>
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
