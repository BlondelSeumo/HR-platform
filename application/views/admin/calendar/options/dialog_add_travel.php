<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
$session = $this->session->userdata('username');
?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'add_travel', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php echo form_open('admin/travel/add_travel', $attributes, $hidden);?>
  <div class="modal-body">
  <h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_travel');?></strong></h4>
    <div class="bg-white">
      <div class="box-block">
        <div class="row">
          <div class="col-md-6">
          <?php if($user_info[0]->user_role_id==1){?>
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" id="start_date" value="<?php echo $_GET['event_date'];?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" id="end_date" value="<?php echo $_GET['event_date'];?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="travel_mode"><?php echo $this->lang->line('xin_travel_mode');?></label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_travel_mode');?>" name="travel_mode">
                    <option value="1"><?php echo $this->lang->line('xin_by_bus');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_by_train');?></option>
                    <option value="3"><?php echo $this->lang->line('xin_by_plane');?></option>
                    <option value="4"><?php echo $this->lang->line('xin_by_taxi');?></option>
                    <option value="5"><?php echo $this->lang->line('xin_by_rental_car');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="expected_budget"><?php echo $this->lang->line('xin_expected_travel_budget');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_expected_travel_budget');?>" name="expected_budget" type="text">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
          <?php if($user_info[0]->user_role_id==1){?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="employee_ajax">
                  <label for="employee_id"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                  <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <?php } else {?>
            <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $session['user_id'];?>" />
            <input type="hidden" name="company_id" id="company_id" value="<?php echo $user_info[0]->company_id;?>" />
            <?php } ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="visit_purpose"><?php echo $this->lang->line('xin_visit_purpose');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_visit_purpose');?>" name="visit_purpose" type="text" id="visit_purpose">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="arrangement_type"><?php echo $this->lang->line('xin_arragement_type');?></label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_arragement_type');?>" name="arrangement_type">
                    <?php foreach($travel_arrangement_types as $travel_arr_type) {?>
                    <option value="<?php echo $travel_arr_type->arrangement_type_id;?>"> <?php echo $travel_arr_type->type;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="actual_budget"><?php echo $this->lang->line('xin_actual_travel_budget');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_actual_travel_budget');?>" name="actual_budget" type="text">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="visit_place"><?php echo $this->lang->line('xin_visit_place');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_visit_place');?>" name="visit_place" type="text">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo $this->lang->line('xin_description');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
            </div>
          </div>
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
	Ladda.bind('button[type=submit]');
	// Date
	$('.edate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	jQuery("#aj_company").change(function(){
		jQuery.get(site_url+"travel/get_employees/"+jQuery(this).val(), function(data, status){
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
			data: obj.serialize()+"&is_ajax=1&add_type=travel&form="+action,
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
