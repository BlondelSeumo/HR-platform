<?php
/* Profile view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_xuinfo($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php if($profile_photo!='' && $profile_photo!='no file') {?>
<?php $de_file = base_url().'uploads/users/'.$profile_photo;?>
<?php } else {?>
<?php if($gender=='Male') { ?>
<?php $de_file = base_url().'uploads/users/default_male.jpg';?>
<?php } else { ?>
<?php $de_file = base_url().'uploads/users/default_female.jpg';?>
<?php } ?>
<?php } ?>
<?php
	if($user[0]->profile_background == ''):
		$profile_bg = base_url().'skin/app-assets/images/carousel/22.jpg';
	else:
		$profile_bg = base_url().'uploads/users/background/'.$user[0]->profile_background;
	endif;
?>

<div class="content-body">
  <div id="user-profile">
    <div class="row">
      <div class="col-xs-12">
        <div class="card profile-with-cover">
          <div class="card-img-top img-fluid bg-cover height-300" style="background: url('<?php echo $profile_bg;?>') 50%;"></div>
          <div class="media profil-cover-details">
            <div class="media-left pl-2 pt-2"> <a href="#" class="profile-image"> <img src="<?php echo $de_file;?>" class="rounded-circle img-border height-100" alt="User image"> </a> </div>
            <div class="media-body media-middle row">
              <div class="col-xs-6">
                <h3 class="card-title"><?php echo $first_name. ' ' .$last_name;?></h3>
              </div>
              <form name="profile_background" id="profile_background" enctype="multipart/form-data">
                <div class="col-xs-4 text-xs-right">
                  <div class="btn-group hidden-md-down" role="group" aria-label="Basic example"> <span class="btn btn-primary btn-file"> <?php echo $this->lang->line('xin_browse');?>
                    <input type="file" name="p_file" id="p_file">
                    </span> </div>
                </div>
                <div class="col-xs-2">
                  <div class="btn-group hidden-md-down" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-success save"><i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?></button>
                  </div>
                </div>
              <?php echo form_close(); ?>
            </div>
          </div>
          <nav class="navbar navbar-light navbar-profile">
            <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2" aria-controls="exCollapsingNavbar2" aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
              <ul class="nav navbar-nav float-xs-right">
                <li class="nav-item active"> <a class="nav-link"> <?php echo $this->lang->line('dashboard_last_login');?>:
                  <?php 
                          $gdate = explode(' ',$last_login_date);
                          $login_date = $this->Xin_model->set_date_format($gdate[0]);
                          echo $login_date.' '.date('h:i A', strtotime($last_login_date));?>
                  <?php echo $this->lang->line('xin_e_details_from');?> <?php echo $last_login_ip;?></span> </a> </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body add-form collapse in">
        <div class="card-block">
          <form class="m-b-1" action="<?php echo site_url("admin/users/update").'/'.$user_id; ?>" method="post" name="edit_user" id="edit_user">
            <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="username"><?php echo $this->lang->line('dashboard_username');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $username;?>">
                      </div>
                      <div class="col-md-6">
                        <label for="password"><?php echo $this->lang->line('xin_employee_password');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text" value="<?php echo $password;?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" value="<?php echo $contact_number;?>" type="number">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                        <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                          <option value="Male" <?php if('Male'==$gender):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_gender_male');?></option>
                          <option value="Female"<?php if('Female'==$gender):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_gender_female');?></option>
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
                    <div class="col-md-6">
                      <?php if($profile_photo!='' || $profile_photo!='no-file'){?>
                      <span class="box-96 mr-0-5"> <img class="b-a-radius-circle" src="<?php echo site_url();?>uploads/users/<?php echo $profile_photo;?>" alt=""> </span>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
                  </div>
                  <div class="form-group">
                    <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
                    <br>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
                      </div>
                    </div>
                    <br>
                    <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <?php foreach($all_countries as $country) {?>
                      <option value="<?php echo $country->country_id;?>" <?php if($country->country_id==$icountry):?> selected="selected"<?php endif;?>> <?php echo $country->country_name;?></option>
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>skin/app-assets/css/pages/users.css">
