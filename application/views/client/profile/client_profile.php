<?php
/* Profile view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
<?php $user = $this->Clients_model->read_client_info($session['client_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php if($client_profile!='' && $client_profile!='no file') {?>
<?php $de_file = base_url().'uploads/clients/'.$client_profile;?>
<?php } else {?>
<?php if($gender=='Male') { ?>
<?php $de_file = base_url().'uploads/clients/default_male.jpg';?>
<?php } else { ?>
<?php $de_file = base_url().'uploads/clients/default_female.jpg';?>
<?php } ?>
<?php } ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general"><?php echo $this->lang->line('xin_e_details_basic');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#change_password"><?php echo $this->lang->line('xin_e_details_cpassword');?></a>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="account-general">

          <div class="card-body media align-items-center">
            <img src="<?php echo $de_file;?>" alt="<?php echo $user[0]->name;?>" class="d-block ui-w-80">
          </div>
          <hr class="border-light m-0">

          <div class="card-block">
          <div class="card-body">
          <?php $attributes = array('name' => 'edit_client', 'id' => 'edit_client', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
          <?php $hidden = array('_method' => 'EDIT', '_token' => $client_id, 'ext_name' => $name);?>
          <?php echo form_open('client/profile/update/'.$client_id, $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="company_name"><?php echo $this->lang->line('xin_client_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_client_name');?>" name="name" type="text" value="<?php echo $name;?>">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text" value="<?php echo $company_name;?>">
                    </div>
                    <div class="col-md-6">
                      <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number" value="<?php echo $contact_number;?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
                    </div>
                    <div class="col-md-6">
                      <label for="website"><?php echo $this->lang->line('xin_website');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>" name="website" value="<?php echo $website_url;?>" type="text">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
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
                    <option value="<?php echo $country->country_id;?>" <?php if($countryid==$country->country_id):?> selected="selected"<?php endif;?>> <?php echo $country->country_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_project_client_photo');?></label>
                  <input type="file" class="form-control-file" id="client_photo" name="client_photo">
                  <br />
                  <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                </fieldset>
              </div>
              <div class="col-md-6">
                <?php if($client_profile!='' || $client_profile!='no-file'){?>
                <span class="avatar box-48 mr-0-5"> <img class="d-block ui-w-40 rounded-circle" src="<?php echo base_url();?>uploads/clients/<?php echo $client_profile;?>" alt="" width="50px"> </span>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
          <?php echo form_close(); ?> </div>
         </div> 
        </div>
        <div class="tab-pane fade" id="change_password">
          <div class="card-body pb-2">
		  <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('client/profile/change_password/', $attributes, $hidden);?>
          <?php
              $data_usr11 = array(
                    'type'  => 'hidden',
                    'name'  => 'client_id',
                    'value' => $session['client_id'],
             );
            echo form_input($data_usr11);
            ?>
            <?php if($this->input->get('change_password')):?>
          <input type="hidden" id="change_pass" value="<?php echo $this->input->get('change_password');?>" />
          <?php endif;?>
            <div class="form-group">
              <label class="form-label"><?php echo $this->lang->line('xin_e_details_enpassword');?></label>
             <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="text">
            </div>

            <div class="form-group">
              <label class="form-label"><?php echo $this->lang->line('xin_e_details_ecnpassword');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
            </div>
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
              </div>
            </div>
          </div>
			<?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
