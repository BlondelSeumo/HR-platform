<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['bug_id']) && $_GET['data']=='bug'){

?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_project_bug_status');?></h4>
</div>
<?php $attributes = array('name' => 'edit_bug', 'id' => 'edit_bug', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('method' => 'EDIT', '_token' => $bug_id, 'ext_name' => $bug_id);?>
<?php echo form_open('admin/project/change_bug_status/'.$bug_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="award_date"><?php echo $this->lang->line('dashboard_xin_status');?></label>
          <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="Status">
            <option value=""></option>
            <option value="0" <?php if($status==0):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_pending');?></option>
            <option value="1" <?php if($status==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_project_status_solved');?></option>
          </select>
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
		Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#edit_bug").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&data=change_status&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						var xin_bug_table = $('#xin_bug_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/project/bug_list").'/'.$project_id; ?>",
								type : 'GET'
							},
							"iDisplayLength": 25,
							"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_bug_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.add-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php }
?>
