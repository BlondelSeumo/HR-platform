<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['incidental_id']) && $_GET['data']=='incidental'){
?>
<?php $session = $this->session->userdata('username'); ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-incidental-data"><?php echo $this->lang->line('kpi_incidental_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_incidental', 'id' => 'edit_incidental', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $incidental_id, 'ext_name' => $incidental_id);?>
<?php echo form_open('admin/performance_incidental/edit_incidental/'.$incidental_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="incidental_kpi"><?php echo $this->lang->line('kpi_incidental');?></label>
          <textarea name="incidental_kpi" id="incidental_kpi" rows="2" class="form-control"><?php echo $incidental_kpi; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="incidental_targeted_date"><?php echo $this->lang->line('kpi_targeted_date');?></label>
          <input class="form-control edate" name="incidental_targeted_date" readonly type="text" value="<?php echo $incidental_targeted_date; ?>">
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="result"><?php echo $this->lang->line('kpi_result');?></label>
          <textarea name="result" id="result" rows="2" class="form-control" <?php echo ($session['user_id'] != $user_id)?'readonly':'';?>><?php echo $result; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <label for="status"><?php echo $this->lang->line('kpi_status'); ?></label>
        <select name="status" id="status" class="form-control" <?php echo ($session['user_id'] != $user_id)?'disabled':'';?>>
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
	$("#edit_incidental").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=incidental&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);

					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-incidental-data').modal('toggle');
					var xin_table_incidental = $('#xin_table_incidental').dataTable({
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/performance_incidental/incidental_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_incidental.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
            $('#kpi_quarter_name').val('All');
					}, true);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } ?>
