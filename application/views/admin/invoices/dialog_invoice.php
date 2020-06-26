<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['invoice_id']) && $_GET['data']=='view_invoice_status' && $_GET['edit']=='status'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_change_status');?></h4>
</div>
<?php $attributes2 = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
<?php $hidden2 = array('invoice_id' => $invoice_id);?>
<?php echo form_open('admin/invoices/update_invoice_status', $attributes2, $hidden2);?>
<div class="modal-body">
  <div class="alert alert-success">
        <strong><?php echo $this->lang->line('xin_pay_invoice_confirm');?></strong>
      </div>
      <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
              <option value="0" <?php if($invoice_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_payroll_unpaid');?></option>
              <option value="1" <?php if($invoice_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_payment_paid');?></option>
            </select>
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
	
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 	

/* Edit data */
$("#update_status").submit(function(e){
	e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&edit_type=update_status&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} else {
				// On page load: datatable
				var xin_table = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : "<?php echo site_url('admin/invoices/invoices_list'); ?>",
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
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}, true);
				$('.add-modal-data').modal('toggle');
				$('.save').prop('disabled', false);
			}
			}
		});
	});
});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['invoice_id']) && $_GET['data']=='invoice_status' && $_GET['edit']=='estatus'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_change_status');?> 2 </h4>
</div>
<?php $attributes2 = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
<?php $hidden2 = array('invoice_id' => $invoice_id);?>
<?php echo form_open('admin/invoices/update_invoice_status', $attributes2, $hidden2);?>
<div class="modal-body">
  <div class="alert alert-success">
        <strong><?php echo $this->lang->line('xin_pay_invoice_confirm');?></strong>
      </div>
      <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
              <option value="0" <?php if($invoice_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_payroll_unpaid');?></option>
              <option value="1" <?php if($invoice_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_payment_paid');?></option>
            </select>
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
	
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 	

/* Edit data */
$("#update_status").submit(function(e){
	e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&edit_type=update_status&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} else {
				toastr.success(JSON.result);
				window.location = '';
				$('.add-modal-data').modal('toggle');
				$('.save').prop('disabled', false);
			}
			}
		});
	});
});	
  </script>
<?php }
?>
