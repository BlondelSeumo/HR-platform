<?php
/* Job List/Post view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/job_post/');?>" data-link-data="<?php echo site_url('admin/job_post/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-newspaper"></span> <?php echo $this->lang->line('left_job_posts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('header_apply_jobs_frontend');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('51',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_candidates/');?>" data-link-data="<?php echo site_url('admin/job_candidates/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('left_job_candidates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_job_candidates');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('52',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_post/employer/');?>" data-link-data="<?php echo site_url('admin/job_post/employer/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-ninja"></span> <?php echo $this->lang->line('xin_jobs_employer');?>
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
<?php if(in_array('291',$role_resources_ids)) {?>
<?php
$all_employers = $this->Recruitment_model->get_all_employers();
$all_job_types = $this->Xin_model->get_job_type();
$all_job_categories = $this->Recruitment_model->all_job_categories();
?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_job');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_job', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/job_post/add_job', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="company_name"><?php echo $this->lang->line('xin_jobs_employer');?></label>
                      <select class="form-control" name="user_id" id="user_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_jobs_employer');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <?php foreach($all_employers as $employer) {?>
                        <option value="<?php echo $employer->user_id;?>"> <?php echo $employer->first_name.' '.$employer->last_name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title"><?php echo $this->lang->line('xin_e_details_jtitle');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_jtitle');?>" name="job_title" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="job_type"><?php echo $this->lang->line('xin_job_type');?></label>
                      <select class="form-control" name="job_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_job_type');?>">
                        <option value=""></option>
                        <?php foreach($all_job_types->result() as $ijob_type) {?>
                        <option value="<?php echo $ijob_type->job_type_id;?>"><?php echo $ijob_type->type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="designation"><?php echo $this->lang->line('xin_acc_category');?></label>
                      <select class="form-control" name="category_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_category');?>">
                        <option value=""></option>
                        <?php foreach($all_job_categories as $category):?>
                        <option value="<?php echo $category->category_id;?>"><?php echo $category->category_name;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="vacancy"><?php echo $this->lang->line('xin_number_of_positions');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_number_of_positions');?>" name="vacancy" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="is_featured"><?php echo $this->lang->line('xin_job_is_featured');?></label>
                      <select class="form-control" name="is_featured" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_job_is_featured');?>">
                        <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                      <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                        <option value="1"><?php echo $this->lang->line('xin_published');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_unpublished');?></option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="date_of_closing" class="control-label"><?php echo $this->lang->line('xin_date_of_closing');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_date_of_closing');?>" readonly name="date_of_closing" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender"><?php echo $this->lang->line('xin_employee_gender');?></label>
                      <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                        <option value="0"><?php echo $this->lang->line('xin_gender_male');?></option>
                        <option value="1"><?php echo $this->lang->line('xin_gender_female');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_job_no_preference');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="experience" class="control-label"><?php echo $this->lang->line('xin_job_minimum_experience');?></label>
                      <select class="form-control" name="experience" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_job_minimum_experience');?>">
                        <option value="0"><?php echo $this->lang->line('xin_job_fresh');?></option>
                        <option value="1"><?php echo $this->lang->line('xin_job_experience_define_1year');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_job_experience_define_2years');?></option>
                        <option value="3"><?php echo $this->lang->line('xin_job_experience_define_3years');?></option>
                        <option value="4"><?php echo $this->lang->line('xin_job_experience_define_4years');?></option>
                        <option value="5"><?php echo $this->lang->line('xin_job_experience_define_5years');?></option>
                        <option value="6"><?php echo $this->lang->line('xin_job_experience_define_6years');?></option>
                        <option value="7"><?php echo $this->lang->line('xin_job_experience_define_7years');?></option>
                        <option value="8"><?php echo $this->lang->line('xin_job_experience_define_8years');?></option>
                        <option value="9"><?php echo $this->lang->line('xin_job_experience_define_9years');?></option>
                        <option value="10"><?php echo $this->lang->line('xin_job_experience_define_10years');?></option>
                        <option value="11"><?php echo $this->lang->line('xin_job_experience_define_plus_10years');?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="long_description"><?php echo $this->lang->line('xin_long_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_long_description');?>" name="long_description" cols="" rows="10" id="long_description"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="short_description"><?php echo $this->lang->line('xin_short_description');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_short_description');?>" name="short_description" cols="30" rows="3"></textarea>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_jobs');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark" href="<?php echo site_url('jobs');?>" target="_blank">
        <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-eye"></span> <?php echo $this->lang->line('left_jobs_listing');?></button>
        </a> </div>
    </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th ><?php echo $this->lang->line('dashboard_position');?></th>
            <th><?php echo $this->lang->line('xin_jobs_employer');?></th>
            <th><?php echo $this->lang->line('xin_posted_date');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_closing_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 175px; }</style>