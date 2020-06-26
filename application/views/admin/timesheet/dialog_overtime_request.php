<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='add_attendance'){
	// get addd by > template
		$session = $this->session->userdata('username');
		$user = $this->Xin_model->read_user_info($session['user_id']);
		$ful_name = $user[0]->first_name. ' '.$user[0]->last_name;
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_add_request_attendance_for');?> <?php echo $ful_name; ?></h4>
</div>
<?php $attributes = array('name' => 'add_attendance', 'id' => 'add_attendance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'ADD');?>
<?php echo form_open('admin/overtime_request/add_request_attendance/', $attributes, $hidden);?>
<?php
	$data = array(
	  'name'        => 'employee_id_m',
	  'id'          => 'employee_id_m',
	  'value'       => $session['user_id'],
	  'type'  		=> 'hidden',
	  'class'       => 'form-control',
	);

echo form_input($data);
?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group"> </div>
        <?php if($user[0]->user_role_id==1){ ?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
          <div class="form-group" id="jemployee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
                  <select disabled="disabled" name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                  </select>
                </div>
            </div>    
         </div> 
        <?php } else {?>
        <input type="hidden" name="employee_id" value="<?php echo $session['user_id'];?>" />
        <input type="hidden" name="company_id" value="<?php echo $user[0]->company_id;?>" />
        <?php } ?> 
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="date"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control attendance_date_m" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly="true" id="attendance_date_m" name="attendance_date_m" type="text">
            </div>
          </div>
          <div class="col-md-4">
                <div class="form-group">
                  <label for="project_no"><?php echo $this->lang->line('xin_project_no');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_no');?>" name="project_no" type="text" value="">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label for="project_no"><?php echo $this->lang->line('xin_phase_no');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phase_no');?>" name="purchase_no" type="text" value="">
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('xin_in_time');?></label>
              <input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="true" id="clock_in_m" name="clock_in_m" type="text">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_out"><?php echo $this->lang->line('xin_out_time');?></label>
              <input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="true" id="clock_out_m" name="clock_out_m" type="text">
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="task_name"><?php echo $this->lang->line('xin_task');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_task');?>" name="task_name" type="text">
              </div>
            </div>
         </div>     
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('xin_reason');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_reason');?>" rows="3" id="xin_reason" name="xin_reason" type="text"></textarea>
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
			shortTime: true,
			format: 'HH:mm'
		});
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_update_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#jemployee_ajax').html(data);
			});
		});
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
		// attendance date
		$('.attendance_date_m').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});	 
		Ladda.bind('button[type=submit]');
				  
		/* Add Attendance*/
		$("#add_attendance").submit(function(e){
			var attendance_date_m = $("#attendance_date_m").val();
			var emp_id = $("#employee_id_m").val();
			var clock_in_m = $("#clock_in_m").val();
			var clock_out_m = $("#clock_out_m").val();
			
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
							if(attendance_date_m!='' && emp_id!='' && clock_in_m!='' && clock_out_m!='') {
								var xin_table = $('#xin_table').dataTable({
								"bDestroy": true,
								"ajax": {
									url : "<?php echo site_url("admin/overtime_request/overtime_request_list") ?>?employee_id="+emp_id+"&attendance_date="+attendance_date_m,
									type : 'GET'
								},
								"fnDrawCallback": function(settings){
								$('[data-toggle="tooltip"]').tooltip();          
								}
							});
							}
							xin_table.api().ajax.reload(function(){ 
								toastr.success(JSON.result);
							}, true);
							$('.add-modal-data').modal('toggle');
							
							$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['time_request_id']) && $_GET['type']=='attendance' && $_GET['data']=='attendance'){?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_request_attendance_for');?> <?php echo $full_name;?></h4>
</div>
<?php $attributes = array('name' => 'edit_attendance', 'id' => 'edit_attendance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['time_request_id']);?>
<?php echo form_open('admin/overtime_request/edit_attendance/'.$time_request_id, $attributes, $hidden);?>
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
    <?php if($user[0]->user_role_id==1){ ?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected="selected" <?php endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
          <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
          <div class="form-group" id="employee_ajax">
              <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
              <select name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
               <?php foreach($result as $employee) {?>
                    <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id):?> selected="selected"<?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                    <?php } ?>
              </select>
            </div>
            </div>    
         </div> 
        <?php } else {?>
        <input type="hidden" name="employee_id" value="<?php echo $employee_id;?>" />
        <input type="hidden" name="company_id" value="<?php echo $company_id;?>" />
        <?php } ?> 
        <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="date"><?php echo $this->lang->line('xin_e_details_date');?></label>
          <input class="form-control attendance_date_e" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly="true" id="attendance_date_e" name="attendance_date_e" type="text" value="<?php echo $request_date;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('xin_in_time');?></label>
              <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="true" name="clock_in" type="text" value="<?php echo $request_clock_in;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_out"><?php echo $this->lang->line('xin_out_time');?></label>
              <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="true" name="clock_out" type="text" value="<?php echo $request_clock_out;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('xin_reason');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_reason');?>" rows="3" id="xin_reason" name="xin_reason" type="text"><?php echo $request_reason;?></textarea>
            </div>
          </div>
        </div>
        <?php if($user[0]->user_role_id == 1) {?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
                <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                  <option value="1" <?php if($is_approved=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_pending');?></option>
                  <option value="2" <?php if($is_approved=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_approved');?></option>
                  v<option value="3" <?php if($is_approved=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_rejected');?></option>
                </select>
          </div>
          </div>
      </div>
      <?php } ?>
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
	$('.timepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_update_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});	 
	Ladda.bind('button[type=submit]');
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	// attendance date
	$('.attendance_date_e').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});  
	/* Edit Attendance*/
	$("#edit_attendance").submit(function(e){
	var attendance_date_e = $("#attendance_date_e").val();
	var emp_att = $("#emp_att").val();
	var xin_table2 = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : "<?php echo site_url("admin/overtime_request/overtime_request_list") ?>?employee_id="+emp_att+"&attendance_date="+attendance_date_e,
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
