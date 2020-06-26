<?php
/* Client view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('312',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_dashboard/');?>" data-link-data="<?php echo site_url('admin/project/projects_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_overview');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('44',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/');?>" data-link-data="<?php echo site_url('admin/project/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('left_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('left_projects');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('119',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/clients/');?>" data-link-data="<?php echo site_url('admin/clients/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_project_clients');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_clients');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('94',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/timelogs/');?>" data-link-data="<?php echo site_url('admin/project/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('424',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_calendar/');?>" data-link-data="<?php echo site_url('admin/project/projects_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_acc_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('425',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_scrum_board/');?>" data-link-data="<?php echo site_url('admin/project/projects_scrum_board/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('xin_projects_scrm_board');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_projects_scrm_board');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('323',$role_resources_ids)) {?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_project_client');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_client', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/clients/add_client', $attributes, $hidden);?>
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
                    <label for="client_name"><?php echo $this->lang->line('xin_clcontact_person');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_clcontact_person');?>" name="name" type="text">
                  </div>
                  <div class="col-md-6">
                    <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
                  </div>
                  <div class="col-md-6">
                    <label for="website"><?php echo $this->lang->line('xin_website');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>" name="website" type="text">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text">
                <br>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text">
                <br>
                <div class="row">
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                  </div>
                </div>
                <br>
                <select class="form-control" name="country" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?php echo $country->country_id;?>"> <?php echo $country->country_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row"> 
            <!--<div class="col-md-3">
              <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text">
            </div>-->
            <div class="col-md-3">
              <label for="website"><?php echo $this->lang->line('xin_employee_password');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text">
            </div>
            <div class="col-md-3">
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('xin_project_client_photo');?></label>
                <input type="file" class="form-control-file" id="client_photo" name="client_photo">
                <small><?php echo $this->lang->line('xin_company_file_type');?></small>
              </fieldset>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_project_clients');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_client_name');?></th>
            <th><?php echo $this->lang->line('module_company_title');?></th>
            <th><?php echo $this->lang->line('xin_email');?></th>
            <th><?php echo $this->lang->line('xin_website');?></th>
            <th><?php echo $this->lang->line('xin_country');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
