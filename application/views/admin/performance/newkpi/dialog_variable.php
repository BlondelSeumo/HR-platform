<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['variable_id']) && $_GET['data']=='variable'){
?>
<?php $session = $this->session->userdata('username'); ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-variable-data"><?php echo $this->lang->line('kpi_variable_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_variable', 'id' => 'edit_variable', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $variable_id, 'ext_name' => $variable_id);?>
<?php echo form_open('admin/performance_variable/edit_variable/'.$variable_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="variable_kpi"><?php echo $this->lang->line('kpi_variable');?></label>
          <textarea name="variable_kpi" id="variable_kpi" rows="2" class="form-control"><?php echo $variable_kpi; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="variable_targeted_date"><?php echo $this->lang->line('kpi_targeted_date');?>(<small>YYYY-MM-DD</small>)</label>
          <input class="form-control edate" name="variable_targeted_date" readonly type="text" value="<?php echo $variable_targeted_date; ?>">
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="result"><?php echo $this->lang->line('kpi_result');?></label>
          <textarea name="result" id="result" rows="2" class="form-control"><?php echo $result; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <label for="status"><?php echo $this->lang->line('kpi_status'); ?></label>
        <select name="status" id="status" class="form-control">
          <?php for($i=1;$i<=4;$i++) : ?>
          <option value="<?php echo $i; ?>" <?php if ($status == $i) {echo 'selected';}else{echo '';} ?> ><?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="feedback"><?php echo $this->lang->line('kpi_feedback');?></label>
          <textarea name="feedback" id="feedback" rows="2" class="form-control"><?php echo $feedback; ?></textarea>
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
  $('.edate').datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat:'yy-mm-dd',
    yearRange: '1900:' + (new Date().getFullYear() + 10),
    beforeShow: function(input) {
      $(input).datepicker("widget").show();
    }
  });
	/* Edit*/
	$("#edit_variable").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=variable&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);

					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-variable-data').modal('toggle');
					var xin_table_variable = $('#xin_table_variable').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
						destroy: true,
						"ajax": {
							url : "<?php echo site_url("admin/performance_variable/variable_list/$user_id") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						  $('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_variable.ajax.reload(function() { 
						toastr.success(JSON.result);
            $('#kpi_quarter_name').val('All');
					}, false);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } ?>
