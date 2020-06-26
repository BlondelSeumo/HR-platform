<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
$session = $this->session->userdata('username');
$fdate = $_GET['event_date'];
?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'add_holiday', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php echo form_open('admin/timesheet/add_holiday', $attributes, $hidden);?>
<div class="modal-body">
<h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_role_set');?> <?php echo $this->lang->line('xin_holiday');?></strong></h4>
  <?php if($user_info[0]->user_role_id==1){ ?>
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
  <?php } else {?>
  <?php $ecompany_id = $user_info[0]->company_id;?>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
        <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
          <option value=""></option>
          <?php foreach($get_all_companies as $company) {?>
          <?php if($ecompany_id == $company->company_id):?>
          <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
          <?php endif;?>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="name"><?php echo $this->lang->line('xin_event_name');?></label>
        <input type="text" class="form-control" name="event_name" placeholder="<?php echo $this->lang->line('xin_event_name');?>" id="event_name">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
        <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" id="start_date" value="<?php echo $fdate;?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
        <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" id="end_date" type="text" value="<?php echo $fdate;?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="description"><?php echo $this->lang->line('xin_description');?></label>
        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="is_publish"><?php echo $this->lang->line('dashboard_xin_status');?></label>
        <select name="is_publish" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_status');?>">
          <option value="1"><?php echo $this->lang->line('xin_published');?></option>
          <option value="0"><?php echo $this->lang->line('xin_unpublished');?></option>
        </select>
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
	Ladda.bind('button[type=submit]');
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=holiday&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.modal-slide').modal('hide');
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
