<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='scrum_board'){
$session = $this->session->userdata('username');
?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_project');?></h4>
</div>
<?php $project_no = $this->Xin_model->generate_random_string();?>
<?php $attributes = array('name' => 'add_project', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php echo form_open('admin/project/add_scrum_board_project', $attributes, $hidden);?>
  <div class="modal-body">
    <div class="bg-white">
      <div class="box-block">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title"><?php echo $this->lang->line('xin_title');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_title');?>" id="title" name="title" type="text">
            </div>
            <div class="row">
            <?php if($user_info[0]->user_role_id==1){ ?>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="award_date"><?php echo $this->lang->line('module_company_title');?></label>
                  <select name="company_id" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                    <option value=""></option>
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
            </div>
            <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                      <input type="hidden" name="project_status" value="<?php echo $project_status;?>" />
                      <label for="budget_hours"><?php echo $this->lang->line('xin_project_budget_hrs');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_budget_hrs');?>" name="budget_hours" type="text">
                    </div>
                  </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label for="employee"><?php echo $this->lang->line('xin_p_priority');?></label>
                  <select name="priority" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_p_priority');?>">
                    <option value="1"><?php echo $this->lang->line('xin_highest');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_high');?></option>
                    <option value="3"><?php echo $this->lang->line('xin_normal');?></option>
                    <option value="4"><?php echo $this->lang->line('xin_low');?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                      <label for="project_no"><?php echo $this->lang->line('xin_project_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_no');?>" name="project_no" type="text" value="<?php echo $project_no;?>">
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label for="client_name"><?php echo $this->lang->line('xin_client_name');?></label>
                  <select name="client_id" id="client_name" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_client');?>">
                    <option value=""></option>
                    <?php foreach($all_clients as $client) {?>
                    <option value="<?php echo $client->client_id;?>"> <?php echo $client->name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="" id="start_date">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="" id="end_date">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_project_manager');?></label>
                  <select multiple name="assigned_to[]" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_manager');?>">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="summary"><?php echo $this->lang->line('xin_summary');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
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
	$('#description').trumbowyg({
		btns: [
			['formatting'],
			'btnGrp-semantic',
			['superscript', 'subscript'],
			['removeformat'],
		],
		autogrowOnEnter: true
	});
	// Date
	$('.edate').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: new Date().getFullYear() + ':' + (new Date().getFullYear() + 10),
	});
	jQuery("#aj_company").change(function(){
		jQuery.get(site_url+"project/get_employees/"+jQuery(this).val(), function(data, status){
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
			data: obj.serialize()+"&is_ajax=1&add_type=project&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
					window.location = '';
				}
			}
		});
	});
});
</script>
<?php } ?>
