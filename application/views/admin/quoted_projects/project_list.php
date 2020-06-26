<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('415',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quotes/');?>" data-link-data="<?php echo site_url('admin/quotes/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-tasks"></span> <?php echo $this->lang->line('xin_estimates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_create_quote');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('427',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_quote_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_quote_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('429',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/leads/');?>" data-link-data="<?php echo site_url('admin/leads/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_leads');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_leads');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('430',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/timelogs/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('428',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/quoted_projects/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('xin_quoted_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_quoted_projects');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('315',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $project_no = $this->Xin_model->generate_random_string();?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_project');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_project', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/quoted_project/add_project', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="title"><?php echo $this->lang->line('xin_title');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_title');?>" name="title" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="project_no"><?php echo $this->lang->line('xin_quoted_project_no');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_quoted_project_no');?>" name="project_no" type="text" value="<?php echo $project_no;?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="client_id"><?php echo $this->lang->line('xin_project_client');?></label>
                      <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_client');?>">
                        <option value=""></option>
                        <?php foreach($all_clients as $client) {?>
                        <option value="<?php echo $client->client_id;?>"> <?php echo $client->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php if($user_info[0]->user_role_id==1){ ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_id"><?php echo $this->lang->line('module_company_title');?></label>
                      <select multiple="multiple" name="company_id[]" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                        <option value=""><?php echo $this->lang->line('module_company_title');?></option>
                        <?php foreach($all_companies as $company) {?>
                        <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else {?>
                  <?php $ecompany_id = $user_info[0]->company_id;?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_id"><?php echo $this->lang->line('module_company_title');?></label>
                      <select multiple="multiple" name="company_id[]" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                        <option value=""><?php echo $this->lang->line('module_company_title');?></option>
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
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="estimate_date"><?php echo $this->lang->line('xin_quote_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_quote_date');?>" readonly name="estimate_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="estimate_hrs"><?php echo $this->lang->line('xin_estimate_hrs');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_estimate_hrs');?>" name="estimate_hrs" type="text">
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
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_project_manager');?></label>
                  <select multiple name="assigned_to[]" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_manager');?>">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="summary"><?php echo $this->lang->line('xin_summary');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
                </div>
              </div>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_quoted_projects');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_project');?>#</th>
            <!--<th><?php echo $this->lang->line('xin_phase_no');?></th>-->
            <th width="180"><?php echo $this->lang->line('xin_project_summary');?></th>
            <?php //if(!in_array('386',$role_resources_ids)) {?>
            <th><?php echo $this->lang->line('xin_p_priority');?></th>
            <?php //} ?>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_project_users');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_quote_date');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
