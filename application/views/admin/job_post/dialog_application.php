<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['application_id']) && $_GET['data']=='view_application'){
	$result = $this->Job_post_model->read_job_information($job_id);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_jobs_cover_letter_for').' '.$result[0]->job_title;?></h4>
</div>
<form class="m-b-1">
<div class="modal-body" >
  <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <td style="display: table-cell;"><?php echo html_entity_decode($message);?></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php echo form_close(); ?>
<?php } else if(isset($_GET['jd']) && isset($_GET['application_id']) && $_GET['data']=='view_application_status' && $_GET['edit']=='status'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_change_status');?></h4>
</div>
<?php $attributes2 = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
<?php $hidden2 = array('jid' => $application_id);?>
<?php echo form_open('admin/job_candidates/update_status', $attributes2, $hidden2);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
              <option value="0" <?php if($application_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_pending');?></option>
              <option value="1" <?php if($application_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_primary_selected');?></option>
              <option value="2" <?php if($application_status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_call_for_interview');?></option>
              <option value="3" <?php if($application_status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_confirm_del');?></option>
              <option value="4" <?php if($application_status=='4'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_rejected');?></option>
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
<?php
if($_GET['type']=='applicant'){
	$url = site_url("admin/job_candidates/applicants_list/").$job_id;
} else if($_GET['type']=='candidate'){
	$url = site_url("admin/job_candidates/candidate_list/");
} else if($_GET['type']=='employer_applicant'){
	$url = site_url("admin/job_candidates/employer_applicants_list/").$user_id;
}
?>
<script type="text/javascript">
$(document).ready(function(){
	
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });		 
Ladda.bind('button[type=submit]'); 	

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
				Ladda.stopAll();
			} else {
				// On page load: datatable
				var xin_table = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : "<?php echo $url; ?>",
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
				Ladda.stopAll();
			}
			}
		});
	});
});	
  </script>
<?php }
?>
