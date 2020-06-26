<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['quote_id']) && $_GET['data']=='po_quote'){
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_title_quote_hash').$quote_number;?></h4>
</div>
<?php $attributes = array('name' => 'econvert_to_project', 'id' => 'econvert_to_project', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $quote_id, 'ext_name' => $quote_id);?>
<?php echo form_open('admin/quotes/convert_to_invoice/'.$quote_id, $attributes, $hidden);?>
  <div class="alert alert-success">
        <strong><?php echo $this->lang->line('xin_convert_estimate_invoice_confirm');?></strong>
      </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_confirm_del');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
	
	/* Edit data */
	$("#econvert_to_invoice").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=econvert_to_invoice&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					toastr.success(JSON.result);
					window.location = '';
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.view-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php }
?>
