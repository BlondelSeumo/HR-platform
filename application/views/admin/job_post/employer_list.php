<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_post/');?>" data-link-data="<?php echo site_url('admin/job_post/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-newspaper"></span> <?php echo $this->lang->line('left_job_posts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('header_apply_jobs_frontend');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('51',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_candidates/');?>" data-link-data="<?php echo site_url('admin/job_candidates/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('left_job_candidates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_job_candidates');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('52',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/job_post/employer/');?>" data-link-data="<?php echo site_url('admin/job_post/employer/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-ninja"></span> <?php echo $this->lang->line('xin_jobs_employer');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_jobs_employer');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('296',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_post/pages/');?>" data-link-data="<?php echo site_url('admin/job_post/pages/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-ios-paper"></span> <?php echo $this->lang->line('xin_jobs_cms_pages');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_update');?> <?php echo $this->lang->line('xin_jobs_cms_pages');?></div>
      </a> </li>
     <?php } ?> 
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('246',$role_resources_ids)) {?>

<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_jobs_employer');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employer', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/job_post/add_employer', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
                  </div>
                  <div class="col-md-6">
                    <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="text">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  	<div class="form-group">
                    <label for="email"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                  	<div class="form-group">
                    <label for="trading_name"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="website"><?php echo $this->lang->line('xin_employee_password');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                  <fieldset class="form-group">
                    <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
                    <input type="file" class="form-control-file" id="company_logo" name="company_logo">
                    <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                  </fieldset>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_jobs_employers');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employee_first_name');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employee_last_name');?></th>
            <th><i class="fa fa-building-o"></i> <?php echo $this->lang->line('xin_company_name');?></th>
            <th><i class="fa fa-envelope"></i> <?php echo $this->lang->line('xin_email');?></th>
            <th><?php echo $this->lang->line('xin_e_details_contact');?>#</th>
            <th><?php echo $this->lang->line('xin_job_applicants_title');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
