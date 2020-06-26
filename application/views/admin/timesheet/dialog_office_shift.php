<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['office_shift_id']) && $_GET['data']=='shift'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_office_shift');?></h4>
</div>
<?php $attributes = array('name' => 'edit_office_shift', 'id' => 'edit_office_shift', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $office_shift_id, 'ext_name' => $office_shift_id);?>
<?php echo form_open('admin/timesheet/edit_office_shift/'.$office_shift_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <?php if($user_info[0]->user_role_id==1){ ?>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('left_company');?></label>
          <div class="col-md-4">
            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected="selected"<?php endif;?>><?php echo $company->name?></option>
            <?php } ?>
          </select>
          </div>
        </div>
        <?php } else {?>
        <?php $ecompany_id = $user_info[0]->company_id;?>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('left_company');?></label>
          <div class="col-md-4">
            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
				<?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected="selected"<?php endif;?>><?php echo $company->name?></option>
                <?php endif;?>
            <?php } ?>
          </select>
          </div>
        </div>
        <?php } ?>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_shift_name');?></label>
          <div class="col-md-4">
            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_shift_name');?>" name="shift_name" type="text" id="name" value="<?php echo $shift_name;?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_monday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-1" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="1" name="monday_in_time" type="text" value="<?php echo $monday_in_time;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-1" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="1" name="monday_out_time" type="text" value="<?php echo $monday_out_time;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="1"><?php echo $this->lang->line('xin_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_tuesday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-2" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="1" name="tuesday_in_time" type="text" value="<?php echo $tuesday_in_time;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-2" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="1" name="tuesday_out_time" type="text" value="<?php echo $tuesday_out_time;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="2"><?php echo $this->lang->line('xin_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_wednesday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-3" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="1" name="wednesday_in_time" type="text" value="<?php echo $wednesday_in_time;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-3" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="1" name="wednesday_out_time" type="text" value="<?php echo $wednesday_out_time;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="3"><?php echo $this->lang->line('xin_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_thursday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-4" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="1" name="thursday_in_time" type="text" value="<?php echo $thursday_in_time;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-4" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="1" name="thursday_out_time" type="text" value="<?php echo $thursday_out_time;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="4"><?php echo $this->lang->line('xin_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_friday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-5" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="1" name="friday_in_time" type="text" value="<?php echo $friday_in_time;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-5" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="1" name="friday_out_time" type="text" value="<?php echo $friday_out_time;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="5"><?php echo $this->lang->line('xin_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_saturday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-6" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="1" name="saturday_in_time" type="text" value="<?php echo $saturday_in_time;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-6" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="1" name="saturday_out_time" type="text" value="<?php echo $saturday_out_time;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="6"><?php echo $this->lang->line('xin_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_sunday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-7" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly="1" name="sunday_in_time" type="text" value="<?php echo $sunday_in_time;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-7" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly="1" name="sunday_out_time" type="text" value="<?php echo $sunday_out_time;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="7"><?php echo $this->lang->line('xin_clear');?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
								
	// Clock
	$('.etimepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	Ladda.bind('button[type=submit]');
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	/* Edit data */
	$("#edit_office_shift").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&edit_type=shift&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-data').modal('toggle');
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/timesheet/office_shift_list") ?>",
								type : 'GET'
							},
							dom: 'lBfrtip',
							"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
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
	$(".clear-time").click(function(){
		var clear_id  = $(this).data('clear-id');
		$(".clear-"+clear_id).val('');
	});
});	
</script>
<?php } ?>
