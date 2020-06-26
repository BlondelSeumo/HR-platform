<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['timelogs_id']) && $_GET['data']=='project_timelog'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $u_created = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($u_created[0]->user_role_id == '1'){?>
<?php $user_date = 'etimelog_date';?>
<?php } else {?>
<?php $user_date = 'euser_timelog_date';?>
<?php } ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_project_timelog_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_timelog_record', 'id' => 'edit_timelog_record', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('method' => 'EDIT', '_token' => $timelogs_id, 'ext_name' => $timelogs_id);?>
<?php echo form_open('admin/project/update_project_timelog/'.$timelogs_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">  
    <div class="col-md-3">
      <div class="form-group">
        <label for="start_time"><?php echo $this->lang->line('xin_project_timelogs_starttime');?></label>
        <input class="form-control etimepicker" placeholder="<?php echo $this->lang->line('xin_project_timelogs_starttime');?>" name="start_time" id="xstart_time" type="text" value="<?php echo $start_time;?>">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="end_time"><?php echo $this->lang->line('xin_project_timelogs_endtime');?></label>
        <input class="form-control etimepicker" placeholder="<?php echo $this->lang->line('xin_project_timelogs_endtime');?>" name="end_time" id="xend_time" type="text" value="<?php echo $end_time;?>">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
        <input class="form-control <?php echo $user_date;?>" placeholder="<?php echo $this->lang->line('xin_start_date');?>" name="start_date" type="text" id="xstart_date" value="<?php echo $start_date;?>">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
        <input class="form-control <?php echo $user_date;?>" placeholder="<?php echo $this->lang->line('xin_end_date');?>" name="end_date" type="text" id="xend_date" value="<?php echo $end_date;?>">
      </div>
    </div>                
  </div>
  <div class="row">
  <div class="col-md-12">
      <div class="form-group">
        <input type="hidden" name="total_hours" id="xtotal_hours" value="<?php echo $total_hours;?>" />
        <label for="timelogs_memo"><?php echo $this->lang->line('xin_project_timelogs_memo');?> 
         <span id="xtotal_time">&nbsp;</span></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_timelogs_memo');?>" name="timelogs_memo" type="text" value="<?php echo $timelogs_memo;?>">
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
function xprojectTotalHours() {
	var startDate = $('#xstart_date').val();
	var endDate = $('#xend_date').val();
	var startTime = $("#xstart_time").val();
	var endTime = $("#xend_time").val();

	var timeStart = new Date(startDate + " " + startTime);
	var timeEnd = new Date(endDate + " " + endTime);

	var diff = (timeEnd - timeStart) / 60000;

	var minutes = diff % 60;
	var hours = (diff - minutes) / 60;

	if (hours < 0 || minutes < 0) {
		var numberOfDaysToAdd = 1;
		timeEnd.setDate(timeEnd.getDate() + numberOfDaysToAdd);
		var dd = timeEnd.getDate();

		if (dd < 10) {
			dd = "0" + dd;
		}

		var mm = timeEnd.getMonth() + 1;

		if (mm < 10) {
			mm = "0" + mm;
		}
		xprojectTotalHours();
	} else {
		$('#xtotal_time').html(hours + "Hrs " + minutes + "Mins");
		$('#xtotal_hours').val(hours+':'+minutes);
	}
}
$(document).ready(function(){
							
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		// Clock  
var input = $('.etimepicker').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now',
	afterDone: function() {
		var startDate = $('#xstart_date').val();
        var endDate = $('#xend_date').val();
        var startTime = $("#xstart_time").val();
        var endTime = $("#xend_time").val();
		if(startDate!='' && endDate!='' && startTime!='' && endTime!='') {
			xprojectTotalHours();
		}
	}
});
$('.euser_timelog_date').datepicker({
	minDate: -1,
	maxDate: "+0D",
	dateFormat:'yy-mm-dd',
});
$('.etimelog_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1900:' + (new Date().getFullYear() + 15),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
});
		
/* Edit data */
$("#edit_timelog_record").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&edit_type=timelog_record&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				var xin_table = $('#xin_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : "<?php echo site_url('admin/project/timelogs_list');?>",
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
				$('.edit-modal-timelog-data').modal('toggle');
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
});	
jQuery(document).on('click keyup change','.etimepicker,.edate', function () {
	var startDate = $('#xstart_date').val();
	var endDate = $('#xend_date').val();
	var startTime = $("#xstart_time").val();
	var endTime = $("#xend_time").val();
	if(startDate!='' && endDate!='' && startTime!='' && endTime!='') {
		xprojectTotalHours();
	}
});
  </script>
<?php }
?>
