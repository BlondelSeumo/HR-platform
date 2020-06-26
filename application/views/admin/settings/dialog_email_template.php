<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['template_id']) && $_GET['data']=='email_template'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_template', 'id' => 'update_template', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $template_id, 'ext_name' => $template_id);?>
<?php echo form_open('admin/settings/update_template/'.$template_id, $attributes, $hidden);?>
<div class="modal-body">
<p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_edit_email_template');?></strong></p>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_template_name');?></label>
          <input class="form-control" name="name" type="text" value="<?php echo $name;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7">
        <div class="form-group">
          <label for="subject"><?php echo $this->lang->line('xin_subject');?></label>
          <input class="form-control" name="subject" type="text" value="<?php echo $subject;?>">
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group">
          <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
          <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
            <option value=""></option>
            <option value="1" <?php if($status==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_employees_active');?></option>
            <option value="0" <?php if($status==0):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_employees_inactive');?></option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="message"><?php echo $this->lang->line('xin_message');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_message');?>" name="message" id="summernote">
		  <?php echo stripslashes($message);?></textarea>
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
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#summernote').trumbowyg();	 
	Ladda.bind('button[type=submit]');

  $('.md-editor .fa-header').removeClass('fa fa-header').addClass('fas fa-heading');
  $('.md-editor .fa-picture-o').removeClass('fa fa-picture-o').addClass('far fa-image');
	
	/* Edit*/
	$("#update_template").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=update_template&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('#modals-slide').modal('toggle');
					var xin_email_table = $('#xin_email_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/settings/email_template_list") ?>",
							type : 'GET'
						},
						"iDisplayLength": 20,
						"aLengthMenu": [[20, 30, 50, 100, -1], [20, 30, 50, 100, "All"]],
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_email_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } ?>
