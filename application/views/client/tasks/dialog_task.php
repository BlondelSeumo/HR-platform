<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['task_id']) && $_GET['data']=='view_task'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_task');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
          <td style="display: table-cell;"><?php echo $task_name;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_estimated_hour');?></th>
          <td style="display: table-cell;"><?php echo $task_hour;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_start_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($start_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_end_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($end_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
          <td style="display: table-cell;"><?php echo $this->lang->line('xin_completed').' '.$task_progress;?>%</td>
        </tr>
        <?php if($task_status=='0'):?> <?php $taskStatus = $this->lang->line('xin_not_started');?>
        <?php elseif($task_status=='1'):?> <?php $taskStatus = $this->lang->line('xin_in_progress');?>
        <?php elseif($task_status=='2'):?> <?php $taskStatus = $this->lang->line('xin_completed');?>
        <?php elseif($task_status=='3'):?> <?php $taskStatus = $this->lang->line('xin_deffered');?> <?php endif; ?>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php echo $taskStatus;?></td>
        </tr>
        <?php $assigned_ids = explode(',',$assigned_to); ?>
        <tr>
          <th><?php echo $this->lang->line('xin_assigned_to');?></th>
          <td style="display: table-cell;"><ol><?php foreach($all_employees as $employee) {?>
		<?php if(in_array($employee->user_id,$assigned_ids)):?> <li><?php echo $employee->first_name.' '.$employee->last_name;?> </li>
        <?php endif;?>
        <?php } ?></ol></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_description');?> <?php echo str_word_count($description);?></th>
          <td style="display: table-cell;">
          <?php if(str_word_count($description) > 65) { ?>
		  <div style="overflow:auto; height:200px;"><?php echo html_entity_decode($description);?></div>
          <?php } else { ?> <?php echo html_entity_decode($description);?> <?php } ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php } else if(isset($_GET['jd']) && isset($_GET['task_id']) && $_GET['data']=='task'){
	$assigned_ids = explode(',',$assigned_to);
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_task');?></h4>
</div>
<?php $attributes = array('name' => 'edit_task', 'id' => 'edit_task', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $task_id, 'ext_name' => $task_id);?>
<?php echo form_open('admin/timesheet/edit_task/'.$task_id, $attributes, $hidden);?>
 <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="task_name"><?php echo $this->lang->line('dashboard_xin_title');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="task_name" type="text" value="<?php echo $task_name;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="task_hour" class="control-label"><?php echo $this->lang->line('xin_estimated_hour');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_estimated_hour');?>" name="task_hour" type="text" value="<?php echo $task_hour;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="employees" class="control-label"><?php echo $this->lang->line('xin_project');?></label>
              <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
                <option value=""></option>
                <?php foreach($all_projects as $project) {?>
                <option value="<?php echo $project->project_id;?>" <?php if($projectid==$project->project_id):?> selected="selected"<?php endif;?>> <?php echo $project->title;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
        <?php if($user_info[0]->user_role_id==1){ ?>
        	<?php $all_employees = $all_employees;?>
        <?php } else {?>
        	<?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
            <?php $all_employees = $result;?>
        <?php } ?>
          <div class="col-md-12">
            <div class="form-group">
              <label for="employees" class="control-label"><?php echo $this->lang->line('xin_assigned_to');?></label>
              <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                <option value=""></option>
                <?php foreach($all_employees as $employee) {?>
                <option value="<?php echo $employee->user_id?>" <?php if(in_array($employee->user_id,$assigned_ids)):?> selected 
				<?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 105px; }</style>
<script type="text/javascript">var site_url = '<?php //echo site_url().$_GET['mname']; ?>/';</script>
<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').trumbowyg();
		// Date
		$('.edate').datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat:'yy-mm-dd',
		  yearRange: new Date().getFullYear() + ':' + (new Date().getFullYear() + 10)
		});

		/* Edit data */
		$("#edit_task").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=task&form="+action,
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
							url : "<?php echo site_url('admin/timesheet/task_list/');?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}
				}
			});
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['task_id']) && $_GET['data']=='project_task'){
	$assigned_ids = explode(',',$assigned_to);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_task');?></h4>
</div>
<?php $attributes = array('name' => 'edit_task', 'id' => 'edit_task', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $task_id, 'ext_name' => $task_id);?>
<?php echo form_open('admin/timesheet/edit_task/'.$task_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="task_name"><?php echo $this->lang->line('dashboard_xin_title');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="task_name" type="text" value="<?php echo $task_name;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <input type="hidden" name="project_id" id="tproject_id" value="<?php echo $project_id;?>" />
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="task_hour" class="control-label"><?php echo $this->lang->line('xin_estimated_hour');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_estimated_hour');?>" name="task_hour" type="text" value="<?php echo $task_hour;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="employees" class="control-label"><?php echo $this->lang->line('xin_assigned_to');?></label>
              <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                <option value=""></option>
                <?php foreach($all_employees as $employee) {?>
                <option value="<?php echo $employee->user_id?>" <?php if(in_array($employee->user_id,$assigned_ids)):?> selected 
				<?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 105px; }</style>
<script type="text/javascript">var site_url = '<?php //echo site_url().$_GET['mname']; ?>/';</script>
<script type="text/javascript">
 $(document).ready(function(){
					
		// On page load: datatable		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').trumbowyg();
		// Date
		$('.edate').datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat:'yy-mm-dd',
		  yearRange: '1900:' + (new Date().getFullYear() + 10)
		});

		/* Edit data */
		$("#edit_task").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=task&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url('admin/timesheet/project_task_list');?>/"+$('#tproject_id').val(),
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
					}
				}
			});
		});
	});	
  </script>
<?php }
?>
