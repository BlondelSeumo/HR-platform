<?php
/* Database Backup Log view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/');?>" data-link-data="<?php echo site_url('admin/settings/');?>" class="mb-3 nav-link hrsale-link"><span class="sw-icon fas fa-cog"></span> <?php echo $this->lang->line('xin_system');?>
        <div class="text-muted small"><?php echo $this->lang->line('header_configuration');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/constants/');?>" data-link-data="<?php echo site_url('admin/settings/constants/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-adjust"></span> <?php echo $this->lang->line('left_constants');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up_all_types');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/modules/');?>" data-link-data="<?php echo site_url('admin/settings/modules/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-life-ring"></span> <?php echo $this->lang->line('xin_setup_modules');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_enable_disable_modules');?></div>
        </a> </li>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/settings/database_backup/');?>" data-link-data="<?php echo site_url('admin/settings/database_backup/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-database"></span> <?php echo $this->lang->line('header_db_log');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_database_backup_restore');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/email_template/');?>" data-link-data="<?php echo site_url('admin/settings/email_template/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-envelope"></span> <?php echo $this->lang->line('left_email_templates');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_email_templates');?></div>
        </a> </li>
    </ul>
 </div>   
<hr class="border-light m-0">
<div class="row mt-3">
  <div class="col-md-8 card">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_backup_log');?></span>
      <div class="card-header-elements ml-md-auto"> <span class="badge">
        <?php $attributes = array('name' => 'del_backup', 'id' => 'del_backup', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/settings/delete_db_backup', $attributes, $hidden);?>
        <button type="submit" class="btn btn-xs btn-primary save"><?php echo $this->lang->line('xin_delete_old_backup');?></button>
        <?php echo form_close(); ?></span> <span class="badge">
        <?php $attributes = array('name' => 'db_backup', 'id' => 'db_backup', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/settings/create_database_backup', $attributes, $hidden);?>
        <button type="submit" class="btn btn-xs btn-primary save"><?php echo $this->lang->line('xin_create_backup');?></button>
        <?php echo form_close(); ?></span> </div>
    </div>
    <div class="card-body">
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('xin_database_file');?></th>
              <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4 card">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_restore');?></strong> <?php echo $this->lang->line('xin_database');?></span> </div>
    <div class="card-body pb-2">
      <?php $attributes = array('name' => 'db_restore', 'id' => 'db_restore', 'autocomplete' => 'off');?>
      <?php $hidden = array('u_profile_picture' => 'UPDATE');?>
      <?php echo form_open_multipart('admin/settings/restore_database_backup/', $attributes, $hidden);?>
      <div class="box">
        <div class="box-body">
          <div class="card-block">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="ajx_restore">
                  <label class="form-label"><?php echo $this->lang->line('xin_database_choose_backup');?></label>
                  <select class="form-control" name="restore_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_database_choose_backup');?>">
                    <?php $db_backup = $this->Xin_model->all_db_backup();?>
                    <option value=""><?php echo $this->lang->line('xin_database_choose_backup');?></option>
                    <?php  foreach($db_backup->result() as $dbr) { ?>
                    <option value="<?php echo $dbr->backup_id;?>"><?php echo $dbr->backup_file;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-database"></i> '.$this->lang->line('xin_restore'))); ?> </div>
            <div class="row">
              <div class="col-md-12">
                <label class="form-label control-label"><?php echo $this->lang->line('xin_database_restore_lost_current_data');?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>
