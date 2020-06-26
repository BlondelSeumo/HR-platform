<?php
/* Client view
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
    <li class="nav-item active"> <a href="<?php echo site_url('admin/leads/');?>" data-link-data="<?php echo site_url('admin/leads/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_leads');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_leads');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('430',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/timelogs/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('428',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('xin_quoted_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_quoted_projects');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-cart display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small">Total Leads</div>
            <div class="text-large"><?php echo $this->Clients_model->get_total_leads();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-earth display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small">Total Client Convert</div>
            <div class="text-large"><?php echo $this->Clients_model->get_total_client_convert();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small">Total Pending Follow Up</div>
            <div class="text-large"><?php echo $this->Clients_model->get_total_pending_followup();?></div>
          </div>
        </div>
      </div>
    </div>
    </div>
</div>
<?php if(in_array('323',$role_resources_ids)) {?>

<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_lead');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_lead', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/leads/add_lead', $attributes, $hidden);?>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_leads');?></span> </div>
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
