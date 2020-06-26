<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['maingoals_id']) && $_GET['data']=='maingoals'){
?>
<?php $session = $this->session->userdata('username'); ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-incidental-data"><?php echo $this->lang->line('kpi_maingoals_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_maingoals', 'id' => 'edit_maingoals', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $maingoals_id, 'ext_name' => $maingoals_id);?>
<?php echo form_open('admin/performance_maingoals/edit_maingoals/'.$maingoals_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <!-- echo ($approve_status == 'approved' || $session['user_id'] != $user_id)?'readonly':''; -->
        <div class="form-group">
          <label for="main_kpi"><?php echo $this->lang->line('kpi_maingoals');?></label>
          <textarea name="main_kpi" id="main_kpi" rows="2" class="form-control" ><?php echo $main_kpi; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="q1"><?php echo $this->lang->line('kpi_q1');?></label>
          <textarea name="q1" id="q1" rows="2" class="form-control"><?php echo $q1; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="q2"><?php echo $this->lang->line('kpi_q2');?></label>
          <textarea name="q2" id="q2" rows="2" class="form-control"><?php echo $q2; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="q3"><?php echo $this->lang->line('kpi_q3');?></label>
          <textarea name="q3" id="q3" rows="2" class="form-control"><?php echo $q3; ?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="q3"><?php echo $this->lang->line('kpi_q4');?></label>
          <textarea name="q4" id="q4" rows="2" class="form-control"><?php echo $q4; ?></textarea>
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

	/* Edit*/
	$("#edit_maingoals").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=maingoals&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);

					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-maingoals-data').modal('toggle');
					var xin_table_maingoals = $('#xin_table_maingoals').dataTable({
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/performance_maingoals/maingoals_list/$user_id") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings) {
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_maingoals.api().ajax.reload(function(){ 
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
