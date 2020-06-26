<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['designation_id']) && $_GET['data']=='designation'){
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_designation_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_designation', 'id' => 'edit_designation', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $designation_id, 'ext_name' => $designation_name);?>
<?php echo form_open('admin/designation/update/'.$designation_id, $attributes, $hidden);?>
  <div class="modal-body">
     <div class="row">
      <div class="col-md-4">
        <?php if($user_info[0]->user_role_id==1){ ?>
        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id) {?> selected="selected" <?php } ?>><?php echo $company->name?></option>
            <?php } ?>
          </select>
        </div>
        <?php } else {?>
        <?php $ecompany_id = $user_info[0]->company_id;?>
        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
				<?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id) {?> selected="selected" <?php } ?>><?php echo $company->name?></option>
                <?php endif;?>
            <?php } ?>
          </select>
        </div>
        <?php } ?>
      </div>
      <div class="col-md-4">
        <div class="form-group" id="ajx_department_modal">
          <label for="name"><?php echo $this->lang->line('xin_hr_main_department');?></label>
          <?php $result = $this->Company_model->ajax_company_departments_info($company_id);?>
          <select name="department_id" id="aj_subdepartments_model" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>">
            <option value=""></option>
            <?php foreach($result as $deparment) {?>
            <option value="<?php echo $deparment->department_id?>" <?php if($deparment->department_id==$department_id) {?> selected="selected" <?php } ?>><?php echo $deparment->department_name?></option>
            <?php } ?>
          </select>
        </div>
       </div>
       <?php if($system[0]->is_active_sub_departments=='yes'){?>
       <div class="col-md-4">
        <div class="form-group" id="subdepartment_ajax_modal">
          <label for="name"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
          <?php $dresult = get_sub_departments($department_id);?>
          <select name="subdepartment_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>">
            <option value=""></option>
            <?php foreach($dresult as $_deparment) {?>
            <option value="<?php echo $_deparment->sub_department_id?>" <?php if($_deparment->sub_department_id==$sub_department_id) {?> selected="selected" <?php } ?>><?php echo $_deparment->department_name?></option>
            <?php } ?>
          </select>
        </div>
       </div>
       <?php } else {?>
        <input type="hidden" name="subdepartment_id" value="0" />
        <?php } ?>
     	<div class="col-md-4">   
        <div class="form-group">
        <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
        <input type="text" class="form-control" name="designation_name" value="<?php echo $designation_name;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea type="text" class="form-control" name="description" placeholder="<?php echo $this->lang->line('xin_description');?>"><?php echo $description;?></textarea>
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
	
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_model_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#ajx_department_modal').html(data);
		});
	});	
	jQuery("#aj_subdepartments_model").change(function(){
		jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#subdepartment_ajax_modal').html(data);
		});
	});	 
	Ladda.bind('button[type=submit]');
	
	/* Edit data */
	$("#edit_designation").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=designation&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/designation/designation_list") ?>",
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
					$('.edit-modal-data').modal('toggle');
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
