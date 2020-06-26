<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('92',$role_resources_ids)) { ?>
    <li class="nav-item active">
      <a href="#smartwizard-2-step-1" class="mb-3 nav-link">
        <span class="sw-done-icon fas fa-user-edit"></span>
        <span class="sw-icon fas fa-user-edit"></span>
        <?php echo $this->lang->line('xin_import_employees');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_import_employees');?></div>
      </a>
    </li>
    <?php } ?> 
    <?php if(in_array('443',$role_resources_ids)) { ?>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-2" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-clock"></span>
        <span class="sw-icon ion ion-md-clock"></span>
        <?php echo $this->lang->line('left_import_attendance');?>
        <div class="text-muted small"><?php echo $this->lang->line('left_import_attendance');?></div>
      </a>
    </li>
    <?php } ?> 
    <?php if(in_array('444',$role_resources_ids)) { ?>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-3" class="mb-3 nav-link">
        <span class="sw-done-icon fas fa-user-plus"></span>
        <span class="sw-icon fas fa-user-plus"></span>
        <?php echo $this->lang->line('xin_import_leads');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_import_leads');?></div>
      </a>
    </li>
    <?php } ?> 
  </ul>
  <hr class="border-light m-0 mb-3">
  <div class="sw-container tab-content">
    <?php if(in_array('92',$role_resources_ids)) { ?>
    <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content" style="display: block;">    
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_import_employees');?></strong> <?php echo $this->lang->line('xin_employee_import_csv_file');?></span></div>      
      <div class="card-body">
        <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line1');?></p>
        <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line2');?></p>
        <h6><a href="<?php echo base_url();?>uploads/csv/sample-csv-employees.csv" class="btn btn-primary"> <i class="fa fa-download"></i> <?php echo $this->lang->line('xin_employee_import_download_sample');?> </a></h6>
        <?php $attributes = array('name' => 'import_users', 'id' => 'import_users', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/import/import_employees', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('xin_employee_upload_file');?><i class="hrsale-asterisk">*</i></label>
                <input type="file" class="form-control-file" id="file" name="file">
                <small><?php echo $this->lang->line('xin_employee_imp_allowed_size');?></small>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="mt-1">
          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
    <?php } ?>
    <?php if(in_array('443',$role_resources_ids)) { ?>
    <div id="smartwizard-2-step-2" class="card animated fadeIn tab-pane step-content">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('left_import_attendance');?></strong> <?php echo $this->lang->line('xin_attendance_import_csv_file');?></span></div>
      <div class="card-body">
        <p class="card-text"><?php echo $this->lang->line('xin_attendance_description_line1');?></p>
        <p class="card-text"><?php echo $this->lang->line('xin_attendance_description_line2');?></p>
        <h6><a href="<?php echo base_url();?>uploads/csv/sample-csv-attendance.csv" class="btn btn-primary"> <i class="fa fa-download"></i> <?php echo $this->lang->line('xin_attendance_download_sample');?> </a></h6>
        <?php $attributes = array('name' => 'import_attendance', 'id' => 'import_time', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/import/import_attendance', $attributes, $hidden);?>
        <fieldset class="form-group">
          <label for="logo"><?php echo $this->lang->line('xin_attendance_upload_file');?></label>
          <input type="file" class="form-control-file" id="file" name="file">
          <small><?php echo $this->lang->line('xin_attendance_allowed_size');?></small>
        </fieldset>
        <div class="mt-1">
          <div class="form-actions box-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_attendance_import');?> </button>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
    <?php } ?>
    <?php if(in_array('444',$role_resources_ids)) { ?>
    <div id="smartwizard-2-step-3" class="card animated fadeIn tab-pane step-content">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_import_leads');?></strong> <?php echo $this->lang->line('xin_employee_import_csv_file');?></span></div>
      <div class="card-body">
        <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line1');?></p>
        <p class="card-text"><?php echo $this->lang->line('xin_leads_import_description_line2');?></p>
        <h6><a href="<?php echo base_url();?>uploads/csv/sample-csv-leads.csv" class="btn btn-primary"> <i class="fa fa-download"></i> <?php echo $this->lang->line('xin_employee_import_download_sample');?> </a></h6>
        <?php $attributes = array('name' => 'import_leads', 'id' => 'import_leads_data', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/leads/import_leads', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('xin_employee_upload_file');?><i class="hrsale-asterisk">*</i></label>
                <input type="file" class="form-control-file" id="file" name="file">
                <small><?php echo $this->lang->line('xin_employee_imp_allowed_size');?></small>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="mt-1">
          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
    <?php } ?>
  </div>
</div>
