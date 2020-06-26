<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['holiday_id']) && $_GET['data']=='view_holiday'){
?>
<form class="m-b-1">
<div class="modal-body">
<p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_holiday');?></strong></p>
  <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <th><?php echo $this->lang->line('module_company_title');?></th>
        <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
          <?php if($company_id==$company->company_id):?>
          <?php echo $company->name;?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_event_name');?></th>
        <td style="display: table-cell;"><?php echo $event_name;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_start_date');?></th>
        <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($start_date);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_end_date');?></th>
        <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($end_date);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        <td style="display: table-cell;"><?php if($is_publish=='1'): $status = $this->lang->line('xin_published');?>
          <?php endif; ?>
          <?php if($is_publish=='0'): $status = $this->lang->line('xin_unpublished');?>
          <?php endif; ?>
          <?php echo $status;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_description');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php echo form_close(); ?>
<?php } else if(isset($_GET['jd']) && isset($_GET['holiday_id']) && $_GET['data']=='holiday'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_holiday');?></h4>
</div>
<?php $attributes = array('name' => 'edit_holiday', 'id' => 'edit_holiday', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $holiday_id, 'ext_name' => $holiday_id);?>
<?php echo form_open('admin/timesheet/edit_holiday/'.$holiday_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
              <option value=""></option>
              <?php foreach($get_all_companies as $company) {?>
              <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id) { ?> selected <?php } ?>><?php echo $company->name?></option>
              <?php } ?>
            </select>
          </div>
          <?php } else {?>
          <?php $ecompany_id = $user_info[0]->company_id;?>
          <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
              <option value=""></option>
              <?php foreach($get_all_companies as $company) {?>
              <?php if($ecompany_id == $company->company_id):?>
              <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id) { ?> selected <?php } ?>><?php echo $company->name?></option>
              <?php endif;?>
              <?php } ?>
            </select>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="form-group">
        <label for="title"><?php echo $this->lang->line('xin_event_name');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_event_name');?>" name="event_name" type="text" value="<?php echo $event_name;?>">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
            <input class="form-control mdate" name="start_date" readonly="true" type="text" value="<?php echo $start_date;?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
            <input class="form-control mdate" name="end_date" readonly="true" type="text" value="<?php echo $end_date;?>">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('xin_description');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="designation" class="control-label"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select name="is_publish" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_status');?>">
              <option value="1" <?php if($is_publish=='1') { ?> selected <?php } ?>><?php echo $this->lang->line('xin_published');?></option>
              <option value="0" <?php if($is_publish=='0') { ?> selected <?php } ?>><?php echo $this->lang->line('xin_unpublished');?></option>
            </select>
          </div>
        </div>
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
 $(document).ready(function(){
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	Ladda.bind('button[type=submit]');	
	// Date
	$('.mdate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	/* Edit*/
	$("#edit_holiday").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=holiday&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/timesheet/holidays_list") ?>",
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
});	
</script>
<?php } ?>
