<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
$session = $this->session->userdata('username');
?>
<?php $user = $this->Xin_model->read_employee_info($session['user_id']);?>
<?php $leave_categories = $user[0]->leave_categories;?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $leaave_cat = get_employee_leave_category($leave_categories,$session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'add_leave', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php echo form_open('admin/timesheet/add_leave', $attributes, $hidden);?>
  <div class="modal-body">
  <h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('left_leave');?></strong></h4>
    <div class="bg-white">
      <div class="box-block">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="leave_type" class="control-label"><?php echo $this->lang->line('xin_leave_type');?></label>
              <select class="form-control" name="leave_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
                <option value=""></option>
                <?php foreach($all_leave_types as $type) {?>
                <option value="<?php echo $type->leave_type_id;?>"> <?php echo $type->type_name;?></option>
                <?php } ?>
              </select>
            </div>
            <?php if($user_info[0]->user_role_id==1){?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="<?php echo $_GET['event_date'];?>" id="start_date">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="<?php echo $_GET['event_date'];?>" id="end_date">
                </div>
              </div>
            </div>
            <?php if($user_info[0]->user_role_id==1){?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="employee_ajax">
                  <label for="employees" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
                  <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <?php } else {?>
            <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $session['user_id'];?>" />
            <input type="hidden" name="company_id" id="company_id" value="<?php echo $user[0]->company_id;?>" />
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <fieldset class="form-group">
                <label for="attachment"><?php echo $this->lang->line('xin_attachment');?></label>
                <input type="file" class="form-control-file" id="attachment" name="attachment">
                <small><?php echo $this->lang->line('xin_leave_file_type');?></small>
              </fieldset>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="attachment"><?php echo $this->lang->line('xin_hr_leave_half_day');?></label><br />
              <input type="checkbox" class="minimal" value="1" id="leave_half_day" name="leave_half_day">
              <?php echo $this->lang->line('xin_hr_leave_half_day');?></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" id="remarks"></textarea>
        </div>
        <div class="form-group">
          <label for="summary"><?php echo $this->lang->line('xin_leave_reason');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_leave_reason');?>" name="reason" cols="30" rows="2" id="reason"></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
  </div>
<?php echo form_close(); ?>
<script type="application/javascript">
$(document).ready(function() {
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_company").change(function(){
		jQuery.get(site_url+"timesheet/get_update_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	// Date
	$('.edate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	Ladda.bind('button[type=submit]');
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'leave');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						$('.icon-spinner3').hide();
						Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					window.location = '';
					
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.modal-slide').modal('hide');
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} 	        
	   });
	});
	$("#xin-form11").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=leave&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.modal-slide').modal('toggle');
					$('#module-opt').hide();
					window.location = '';
				}
			}
		});
	});
});
</script>
<?php } ?>
