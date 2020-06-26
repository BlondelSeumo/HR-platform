<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['page_id']) && $_GET['data']=='cms_pages'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_jobs_edit_cms_page');?></h4>
</div>
<?php $attributes = array('name' => 'update_page', 'id' => 'update_page', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $page_id, 'ext_name' => $page_id);?>
<?php echo form_open('admin/job_post/update_pages/'.$page_id, $attributes, $hidden);?>
<div class="modal-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('dashboard_xin_title');?></label>
          <input class="form-control" style="border:0px solid #fff;" name="page_title" type="text" value="<?php echo $page_title;?>" readonly="readonly">
        </div>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <label for="subject"><?php echo $this->lang->line('xin_jobs_page_url');?></label>
          <input class="form-control" style="border:0px solid #fff;" name="page_url" type="text" value="<?php echo $page_url;?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="message"><?php echo $this->lang->line('xin_jobs_page_content');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_jobs_page_content');?>" name="page_details" id="summernote"><?php echo $page_details;?></textarea>
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
	
	/* Edit*/
	$("#update_page").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=update_page&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/job_post/pages_list") ?>",
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
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } ?>
