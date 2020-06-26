<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='add_attendance'){
	// get addd by > template
		$user = $this->Xin_model->read_user_info($_GET['employee_id']);
		$ful_name = $user[0]->first_name. ' '.$user[0]->last_name;
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_add_attendance_for');?> <?php echo $ful_name; ?></h4>
</div>
<?php $attributes = array('name' => 'add_attendance', 'id' => 'add_attendance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'ADD');?>
<?php echo form_open('admin/timesheet/add_attendance/', $attributes, $hidden);?>
<?php
	$data = array(
	  'name'        => 'employee_id_m',
	  'id'          => 'employee_id_m',
	  'value'       => $_GET['employee_id'],
	  'type'  		=> 'hidden',
	  'class'       => 'form-control',
	);

echo form_input($data);
?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group"> </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="date"><?php echo $this->lang->line('xin_attendance_date');?></label>
              <input class="form-control attendance_date_m" placeholder="<?php echo $this->lang->line('xin_attendance_date');?>" readonly="true" id="attendance_date_m" name="attendance_date_m" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('xin_office_in_time');?></label>
              <input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('xin_office_in_time');?>" readonly="true" id="clock_in_m" name="clock_in_m" type="text">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_out"><?php echo $this->lang->line('xin_office_out_time');?></label>
              <input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('xin_office_out_time');?>" readonly="true" id="clock_out_m" name="clock_out_m" type="text">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_save');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
							
		// Clock
		$('.timepicker_m').bootstrapMaterialDatePicker({
			date: false,
			format: 'HH:mm'
		});	 
		Ladda.bind('button[type=submit]');
		// attendance date
		$('.attendance_date_m').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: true,
			format: 'YYYY-MM-DD'
		});	 
				  
		/* Add Attendance*/
		$("#add_attendance").submit(function(e){
			var attendance_date_m = $("#attendance_date_m").val();
			var emp_id = $("#employee_id_m").val();
			var clock_in_m = $("#clock_in_m").val();
			var clock_out_m = $("#clock_out_m").val();
			if(attendance_date_m!='' && emp_id!='' && clock_in_m!='' && clock_out_m!='') {
				var xin_table = $('#xin_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : "<?php echo site_url("admin/timesheet/update_attendance_list") ?>?employee_id="+emp_id+"&attendance_date="+attendance_date_m,
					type : 'GET'
				},
				"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
				}
			});
			}
		/*Form Submit*/
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=4&add_type=attendance&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						$('.add-modal-data').modal('toggle');
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
<?php } else if(isset($_GET['jd']) && isset($_GET['attendance_id']) && $_GET['type']=='attendance' && $_GET['data']=='attendance'){?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_attendance_for');?> <?php echo $full_name;?></h4>
</div>
<?php $attributes = array('name' => 'edit_attendance', 'id' => 'edit_attendance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['attendance_id']);?>
<?php echo form_open('admin/timesheet/edit_attendance/'.$time_attendance_id, $attributes, $hidden);?>
<?php
	$data = array(
	  'name'        => 'emp_att',
	  'id'          => 'emp_att',
	  'value'       => $employee_id,
	  'type'  		=> 'hidden',
	  'class'       => 'form-control',
	);

echo form_input($data);
?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="date"><?php echo $this->lang->line('xin_attendance_date');?></label>
          <input class="form-control attendance_date_e" placeholder="<?php echo $this->lang->line('xin_attendance_date');?>" readonly="true" id="attendance_date_e" name="attendance_date_e" type="text" value="<?php echo $attendance_date;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('xin_office_in_time');?></label>
              <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_office_in_time');?>" readonly="true" name="clock_in" type="text" value="<?php echo $clock_in;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_out"><?php echo $this->lang->line('xin_office_out_time');?></label>
              <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_office_out_time');?>" readonly="true" name="clock_out" type="text" value="<?php echo $clock_out;?>">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
	
	// Clock	
	// attendance date
	$('.attendance_date_e').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: true,
		format: 'YYYY-MM-DD'
	});	 
	Ladda.bind('button[type=submit]'); 
	$('.timepicker').bootstrapMaterialDatePicker({
		date: false,
		format: 'HH:mm'
	});
  
	/* Edit Attendance*/
		$("#edit_attendance").submit(function(e){
		var attendance_date_e = $("#attendance_date_e").val();
		var emp_att = $("#emp_att").val();
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : "<?php echo site_url("admin/timesheet/update_attendance_list") ?>?employee_id="+emp_att+"&attendance_date="+attendance_date_e,
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		/*Form Submit*/
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=3&edit_type=attendance&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						$('.edit-modal-data').modal('toggle');
						xin_table2.api().ajax.reload(function(){ 
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
<?php }
?>
