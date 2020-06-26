<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
$session = $this->session->userdata('username');
?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'add_meeting', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php echo form_open('admin/meetings/add_meeting', $attributes, $hidden);?>
  <div class="modal-body">
  <h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_hr_meeting');?></strong></h4>
    <div class="row">
    <?php if($user_info[0]->user_role_id==1){ ?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php } else {?>
	  <?php $ecompany_id = $user_info[0]->company_id;?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="company_id"><?php echo $this->lang->line('module_company_title');?></label>
          <select name="company_id" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
            <option value=""></option>
            <?php foreach($all_companies as $company) {?>
            <?php if($ecompany_id == $company->company_id):?>
            <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
            <?php endif;?>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php } ?>
      <div class="col-md-6">
      <div class="form-group" id="employee_ajax">
        <label for="first_name"><?php echo $this->lang->line('dashboard_single_employee');?></label>
        <select class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
          <option value=""></option>
        </select>
      </div>
    </div>
    </div>
    
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="meeting_title"><?php echo $this->lang->line('xin_hr_meeting_title');?></label>
          <input type="text" class="form-control" name="meeting_title" id="meeting_title" placeholder="<?php echo $this->lang->line('xin_hr_meeting_title');?>">
          <input type="hidden" value="#605ca8" name="meeting_color" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="meeting_date"><?php echo $this->lang->line('xin_hr_meeting_date');?></label>
          <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_hr_meeting_date');?>" readonly name="meeting_date" type="text" value="<?php echo $_GET['event_date'];?>" id="m_meeting_date" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="meeting_time"><?php echo $this->lang->line('xin_hr_meeting_time');?></label>
          <input class="form-control etimepicker" placeholder="<?php echo $this->lang->line('xin_hr_meeting_time');?>" readonly name="meeting_time" type="text" id="m_meeting_time">
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="meeting_room"><?php echo $this->lang->line('xin_meeting_room');?></label>
            <input type="text" class="form-control" name="meeting_room" placeholder="<?php echo $this->lang->line('xin_meeting_room');?>">
          </div>
        </div>
      </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="event_note"><?php echo $this->lang->line('xin_hr_meeting_note');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_hr_meeting_note');?>" name="meeting_note" id="meeting_note"></textarea>
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
	// Date
	$('.edate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	$('.etimepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	Ladda.bind('button[type=submit]');
	jQuery("#aj_company").change(function(){
		jQuery.get(site_url +"events/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=meeting&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.view-modal-data').modal('toggle');
					$('#module-opt').hide();
					Ladda.stopAll();
					window.location = '';
				}
			}
		});
	});
});
</script>
<?php } ?>
