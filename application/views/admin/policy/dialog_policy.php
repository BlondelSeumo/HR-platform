<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['policy_id']) && $_GET['data']=='policy'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_policy');?></h4>
</div>
<?php $attributes = array('name' => 'edit_policy', 'id' => 'edit_policy', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $policy_id, 'ext_name' => $title);?>
<?php echo form_open('admin/policy/update/'.$policy_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="form-group">
      <label for="title"><?php echo $this->lang->line('xin_title');?></label>
      <input type="text" class="form-control" name="title" placeholder="<?php echo $this->lang->line('xin_title');?>" value="<?php echo $title;?>">
    </div>
    <div class="form-group">
      <label for="message"><?php echo $this->lang->line('xin_description');?></label>
      <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description2"><?php echo $description;?></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script> 
<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').trumbowyg();	 
		 Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#edit_policy").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=policy&form="+action,
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
							url : "<?php echo site_url("admin/policy/policy_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['policy_id']) && $_GET['data']=='view_policy'){ ?>
<form class="m-b-1">
  <div class="modal-body">
  <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_policy');?></strong></p>
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?php echo $company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_title');?></th>
          <td style="display: table-cell;"><?php echo $title;?></td>
        </tr>
         <tr>
        <th><?php echo $this->lang->line('xin_attachment');?></th>
            <td style="display: table-cell;"><?php if($attachment!='' && $attachment!='no file') {?>
              <img src="<?php echo base_url().'uploads/company_policy/'.$attachment;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=company_policy&filename=<?php echo $attachment;?>"><?php echo $this->lang->line('xin_download');?></a>
              <?php } ?></td>
          </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
