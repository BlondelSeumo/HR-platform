<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
$session = $this->session->userdata('username');	
?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'add_tracking', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php echo form_open('admin/goal_tracking/add_tracking', $attributes, $hidden);?>
<div class="modal-body">
<h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_role_set');?> <?php echo $this->lang->line('xin_hr_goal_title');?></strong></h4>
  <div class="bg-white">
    <div class="box-block">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
          <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="col-md-12">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
                <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_companies as $company) {?>
                  <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php } else {?>
			  <?php $ecompany_id = $user_info[0]->company_id;?>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="company_id"><?php echo $this->lang->line('module_company_title');?></label>
                  <select name="company" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
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
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="xin_subject"><?php echo $this->lang->line('xin_subject');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_subject');?>" name="subject" id="subject" type="text" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="<?php echo $_GET['event_date'];?>" id="start_date">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="tracking_type"><?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?></label>
                <select class="form-control" name="tracking_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?>">
                  <option value=""></option>
                  <?php foreach($all_tracking_types as $tracking_type) {?>
                  <option value="<?php echo $tracking_type->tracking_type_id?>"><?php echo $tracking_type->type_name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="target_achiement"><?php echo $this->lang->line('xin_hr_target_achiement');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_target_achiement');?>" name="target_achiement" type="text" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="<?php echo $_GET['event_date'];?>" id="end_date">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
      <div class="col-md-12">
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('xin_description');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
          </div>
        </div></div>
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
			data: obj.serialize()+"&is_ajax=1&add_type=tracking&form="+action,
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
