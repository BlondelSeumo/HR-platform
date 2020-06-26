<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_user');?></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
            <li><a data-action="close"><i class="ft-x"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-body add-form collapse">
        <div class="card-block">
          <form class="form" method="post" name="add_company" id="xin-form" enctype="multipart/form-data" action="<?php echo site_url('admin/users/add_user');?>">
            <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                 <div class="form-group">
                        <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="">
                      </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    
                    <div class="row">
                <div class="col-md-6">
                  <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text">
                </div>
                <div class="col-md-6">
                  <label for="website"><?php echo $this->lang->line('xin_employee_password');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text">
                </div>
              </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number">
                      </div>
                      <div class="col-md-6">
                  		<div class="form-group">
                        <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                        <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                          <option value="Male"><?php echo $this->lang->line('xin_gender_male');?></option>
                          <option value="Female"><?php echo $this->lang->line('xin_gender_female');?></option>
                        </select>
                      </div>
                </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                  <fieldset class="form-group">
                    <label for="photo"><?php echo $this->lang->line('xin_user_photo');?></label>
                    <input type="file" class="form-control-file" id="photo" name="photo">
                    <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                  </fieldset>
                </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="">
                  </div>
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
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<section id="decimal">
  <div class="row">
    <div class="col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_users');?></h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="card-body collapse in">
          <div class="card-block card-dashboard">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="table table-striped table-bordered dataTable" id="xin_table" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_name');?></th>
                    <th><?php echo $this->lang->line('xin_email');?></th>
                    <th><?php echo $this->lang->line('dashboard_username');?></th>
                    <th><?php echo $this->lang->line('xin_employee_password');?></th>
                    <th><?php echo $this->lang->line('xin_country');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
