<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header  with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_employee_import_csv_file');?></h3>
    </div>
  <div class="box-body">
    <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line1');?></p>
    <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line2');?></p>
    <h6><a href="<?php echo base_url();?>uploads/csv/sample-csv-employees.csv" class="btn btn-primary"> <i class="fa fa-download"></i> <?php echo $this->lang->line('xin_employee_import_download_sample');?> </a></h6>
    <?php $attributes = array('name' => 'import_attendance', 'id' => 'xin-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open_multipart('admin/employees/import_employees', $attributes, $hidden);?>
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
