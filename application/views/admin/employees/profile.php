<?php
/* Profile view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php if($profile_picture!='' && $profile_picture!='no file') {?>
<?php $de_file = base_url().'uploads/profile/'.$profile_picture;?>
<?php } else {?>
<?php if($gender=='Male') { ?>
<?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
<?php } ?>
<?php $full_name = $user[0]->first_name.' '.$user[0]->last_name;?>
<?php $designation = $this->Designation_model->read_designation_information($user[0]->designation_id);?>
<?php
	if(!is_null($designation)){
		$designation_name = $designation[0]->designation_name;
	} else {
		$designation_name = '--';	
	}
	$leave_user = $this->Xin_model->read_user_info($session['user_id']);
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <li class="nav-item active"> <a href="#smartwizard-2-step-1" class="mb-3 nav-link"> <span class="sw-done-icon ion lnr lnr-users"></span> <span class="sw-icon lnr lnr-users"></span> <?php echo $this->lang->line('xin_general');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_e_details_basic');?></div>
        </a> </li>
      <li class="nav-item done"> <a href="#smartwizard-2-step-3" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-calendar-full"></span> <span class="sw-icon lnr lnr-calendar-full"></span> <?php echo $this->lang->line('left_leaves');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_view_leave_all');?></div>
        </a> </li>
      <li class="nav-item done"> <a href="#smartwizard-2-step-4" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-earth"></span> <span class="sw-icon lnr lnr-earth"></span> <?php echo $this->lang->line('xin_hr');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_view_core_hr_modules');?></div>
        </a> </li>
      <li class="nav-item done"> <a href="#smartwizard-2-step-5" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-layers"></span> <span class="sw-icon lnr lnr-layers"></span> <?php echo $this->lang->line('xin_hr_m_project_task');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_view_all_projects');?></div>
        </a> </li>
      <li class="nav-item done"> <a href="#smartwizard-2-step-6" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-keyboard"></span> <span class="sw-icon lnr lnr-keyboard"></span> <?php echo $this->lang->line('left_payslips');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_view_payslips_all');?></div>
        </a> </li>
    </ul>
    <hr class="border-light m-0">
    <div class="mb-3 sw-container tab-content">
      <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content mt-3" style="display: block;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                  <?php if($system[0]->employee_manage_own_profile=='yes'){?>
                  <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-basic_info"> <i class="lnr lnr-user text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_basic');?></a>
                  <?php } ?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-salary"> <i class="lnr lnr-highlight text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_salary_title');?></a>
                  <?php if($system[0]->employee_manage_own_picture=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-profile_picture"> <i class="lnr lnr-picture text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_profile_picture');?></a>
                  <?php } ?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-immigration"> <i class="lnr lnr-rocket text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_immigration');?></a>
                  <?php if($system[0]->employee_manage_own_contact=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-contacts"> <i class="lnr lnr-phone-handset text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_emergency_contacts');?></a>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_social=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social"> <i class="lnr lnr-earth text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_social');?></a>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_document=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-document"> <i class="lnr lnr-file-add text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_document');?></a>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_qualification=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-qualification"> <i class="lnr lnr-file-empty text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_qualification');?></a>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_work_experience=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-experience"> <i class="lnr lnr-hourglass text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_w_experience');?></a>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_bank_account=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-baccount"> <i class="lnr lnr-apartment text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_baccount');?></a>
                  <?php } ?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-cpassword"> <i class="lnr lnr-lock text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_cpassword');?></a> </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <?php if($system[0]->employee_manage_own_profile=='yes'){?>
                  <div class="tab-pane fade show active" id="account-basic_info">
                    <?php $shift_info = $this->Employees_model->read_shift_information($user[0]->office_shift_id); ?>
                    <?php
                        if(!is_null($shift_info)){
                            $shift_name = $shift_info[0]->shift_name;
                        } else {
                            $shift_name = '--';
                        }
                      ?>
                    <div class="card-body media align-items-center"> <img src="<?php echo $de_file;?>" alt="" class="d-block ui-w-80">
                      <div class="media-body ml-4"> <a target="_blank" href="<?php echo site_url('admin/employees/download_profile/').$session['user_id'];?>">
                        <label class="btn btn-outline-primary"> <?php echo $this->lang->line('xin_download_profile_title');?> </label>
                        </a>
                        <div class="text-light  mt-1"><?php echo $full_name;?></div>
                        <div class="text-light  mt-1"><?php echo $this->lang->line('xin_e_details_shift');?> - <?php echo $shift_name;?></div>
                      </div>
                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body">
                      <?php $attributes = array('name' => 'basic_info', 'id' => 'basic_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/profile/user_basic_info/', $attributes, $hidden);?>
                      <?php
                              $data_usr1 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'id'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr1);
                            ?>
                      <div class="box">
                        <div class="box-body">
                          <div class="card-block">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label form-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('dashboard_email');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="<?php echo $email;?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_employee_dob');?></label>
                                  <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="date_of_birth" type="text" value="<?php echo $date_of_birth;?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                                  <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                                    <option value="Male" <?php if($gender=='Male'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_gender_male');?></option>
                                    <option value="Female" <?php if($gender=='Female'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_gender_female');?></option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_mstatus');?></label>
                                  <select class="form-control" name="marital_status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_mstatus');?>">
                                    <option value="Single" <?php if($marital_status=='Single'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_status_single');?></option>
                                    <option value="Married" <?php if($marital_status=='Married'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_status_married');?></option>
                                    <option value="Widowed" <?php if($marital_status=='Widowed'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_status_widowed');?></option>
                                    <option value="Divorced or Separated" <?php if($marital_status=='Divorced or Separated'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_status_divorced_separated');?></option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_contact_number');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="<?php echo $contact_no;?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_employee_address');?></label>
                                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_address');?>" name="address" cols="30" rows="3" id="address"><?php echo $address;?></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_picture=='yes'){?>
                  <div class="tab-pane fade" id="account-profile_picture">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'profile_picture', 'id' => 'f_profile_picture', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_profile_picture' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/profile_picture/', $attributes, $hidden);?>
                      <?php
                              $data_usr2 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'id'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr2);
                            ?>
                      <?php
                            $data_usr3 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'session_id',
                                    'id'  => 'session_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr3);
                            ?>
                      <div class="box">
                        <div class="box-body">
                          <div class="card-block">
                            <div class="row">
                              <div class="col-md-12">
                                <div class='form-group'>
                                  <fieldset class="form-group">
                                    <label for="logo"><?php echo $this->lang->line('xin_browse');?></label>
                                    <input type="file" class="form-control-file" id="p_file" name="p_file">
                                    <small><?php echo $this->lang->line('xin_e_details_picture_type');?></small>
                                  </fieldset>
                                  <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                                  <img src="<?php echo site_url().'uploads/profile/'.$profile_picture;?>" width="50px" style="margin-left:20px;" id="u_file">
                                  <?php } else {?>
                                  <?php if($gender=='Male') { ?>
                                  <?php $de_file = site_url().'uploads/profile/default_male.jpg';?>
                                  <?php } else { ?>
                                  <?php $de_file = site_url().'uploads/profile/default_female.jpg';?>
                                  <?php } ?>
                                  <img src="<?php echo $de_file;?>" width="50px" style="margin-left:20px;" id="u_file">
                                  <?php } ?>
                                  <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                                  <br />
                                  <label>
                                    <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                    <?php echo $this->lang->line('xin_e_details_remove_pic');?></span> </label>
                                  <?php } else {?>
                                  <div id="remove_file" style="display:none;">
                                    <label>
                                      <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                      <?php echo $this->lang->line('xin_e_details_remove_pic');?></span> </label>
                                  </div>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <?php } ?>
                  <div class="tab-pane fade" id="account-immigration">
                    <div class="box pb-2">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_employee_immigration');?></span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'immigration_info', 'id' => 'immigration_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_document_info' => 'UPDATE');?>
                          <?php echo form_open_multipart('admin/employees/immigration_info/', $attributes, $hidden);?>
                          <?php
                              $data_usr5 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr5);
                            ?>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="relation"><?php echo $this->lang->line('xin_e_details_document');?></label>
                                <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                                  <option value=""></option>
                                  <?php foreach($all_document_types as $document_type) {?>
                                  <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="document_number" class="control-label"><?php echo $this->lang->line('xin_employee_document_number');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_document_number');?>" name="document_number" type="text">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="issue_date" class="control-label"><?php echo $this->lang->line('xin_issue_date');?></label>
                                <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_issue_date');?>" name="issue_date" type="text">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="expiry_date" class="control-label"><?php echo $this->lang->line('xin_e_details_doe');?></label>
                                <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_doe');?>" name="expiry_date" type="text">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <fieldset class="form-group">
                                  <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
                                  <input type="file" class="form-control-file" id="p_file2" name="document_file">
                                  <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
                                </fieldset>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="eligible_review_date" class="control-label"><?php echo $this->lang->line('xin_eligible_review_date');?></label>
                                <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_eligible_review_date');?>" name="eligible_review_date" type="text">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="send_mail"><?php echo $this->lang->line('xin_country');?></label>
                                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                                  <?php foreach($all_countries as $scountry) {?>
                                  <option value="<?php echo $scountry->country_id;?>"> <?php echo $scountry->country_name;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_assigned_immigration');?></strong> <?php echo $this->lang->line('xin_records');?></span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_imgdocument" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_document');?></th>
                                  <th><?php echo $this->lang->line('xin_issue_date');?></th>
                                  <th><?php echo $this->lang->line('xin_expiry_date');?></th>
                                  <th><?php echo $this->lang->line('xin_issued_by');?></th>
                                  <th><?php echo $this->lang->line('xin_eligible_review_date');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if($system[0]->employee_manage_own_contact=='yes'){?>
                  <div class="tab-pane fade" id="account-contacts">
                    <div class="box md-4">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_contact');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'contact_info', 'id' => 'contact_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_basic_info' => 'ADD');?>
                          <?php echo form_open('admin/employees/contact_info/', $attributes, $hidden);?>
                          <?php
                          $data_usr6 = array(
                                'type'  => 'hidden',
                                'name'  => 'user_id',
                                'value' => $session['user_id'],
                         );
                        echo form_input($data_usr6);
                        ?>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="relation"><?php echo $this->lang->line('xin_e_details_relation');?></label>
                                <select class="form-control" name="relation" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                                  <option value="Self"><?php echo $this->lang->line('xin_self');?></option>
                                  <option value="Parent"><?php echo $this->lang->line('xin_parent');?></option>
                                  <option value="Spouse"><?php echo $this->lang->line('xin_spouse');?></option>
                                  <option value="Child"><?php echo $this->lang->line('xin_child');?></option>
                                  <option value="Sibling"><?php echo $this->lang->line('xin_sibling');?></option>
                                  <option value="In Laws"><?php echo $this->lang->line('xin_in_laws');?></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <label for="work_email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_work');?>" name="work_email" type="text">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label>
                                  <input type="checkbox" class="minimal" value="1" id="is_primary" name="is_primary">
                                  <?php echo $this->lang->line('xin_e_details_pcontact');?></span> </label>
                                &nbsp;
                                <label>
                                  <input type="checkbox" class="minimal" value="1" id="is_dependent" name="is_dependent">
                                  <?php echo $this->lang->line('xin_e_details_dependent');?></span> </label>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_dependent');?>" name="personal_email" type="text">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="name" class="control-label"><?php echo $this->lang->line('xin_name');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_name');?>" name="contact_name" type="text">
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group" id="designation_ajax">
                                <label for="address_1" class="control-label"><?php echo $this->lang->line('xin_address');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="work_phone"><?php echo $this->lang->line('xin_phone');?></label>
                                <div class="row">
                                  <div class="col-md-8">
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_work');?>" name="work_phone" type="text">
                                  </div>
                                  <div class="col-md-4">
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_phone_ext');?>" name="work_phone_extension" type="text">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_mobile');?>" name="mobile_phone" type="text">
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-md-5">
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text">
                                  </div>
                                  <div class="col-md-4">
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text">
                                  </div>
                                  <div class="col-md-3">
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_home');?>" name="home_phone" type="text">
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <select name="country" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                                  <option value=""></option>
                                  <?php foreach($all_countries as $country) {?>
                                  <option value="<?php echo $country->country_id;?>"> <?php echo $country->country_name;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          <?php echo form_close(); ?> </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_contacts');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_contact" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_relation');?></th>
                                  <th><?php echo $this->lang->line('dashboard_email');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_mobile');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_social=='yes'){?>
                  <div class="tab-pane fade" id="account-social">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'social_networking', 'id' => 'f_social_networking', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/social_info/', $attributes, $hidden);?>
                      <?php
                              $data_usr4 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr4);
                            ?>
                      <div class="box">
                        <div class="box-body">
                          <div class="card-block">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="facebook_profile"><?php echo $this->lang->line('xin_e_details_fb_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_fb_profile');?>" name="facebook_link" type="text" value="<?php echo $facebook_link;?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="facebook_profile"><?php echo $this->lang->line('xin_e_details_twit_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_twit_profile');?>" name="twitter_link" type="text" value="<?php echo $twitter_link;?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="twitter_profile"><?php echo $this->lang->line('xin_e_details_blogr_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_blogr_profile');?>" name="blogger_link" type="text" value="<?php echo $blogger_link;?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="blogger_profile"><?php echo $this->lang->line('xin_e_details_linkd_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_linkd_profile');?>" name="linkdedin_link" type="text" value="<?php echo $linkdedin_link;?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="blogger_profile"><?php echo $this->lang->line('xin_e_details_gplus_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_gplus_profile');?>" name="google_plus_link" type="text" value="<?php echo $google_plus_link;?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_insta_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_insta_profile');?>" name="instagram_link" type="text" value="<?php echo $instagram_link;?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_pintrst_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_pintrst_profile');?>" name="pinterest_link" type="text" value="<?php echo $pinterest_link;?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_utube_profile');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_utube_profile');?>" name="youtube_link" type="text" value="<?php echo $youtube_link;?>">
                                </div>
                              </div>
                            </div>
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_document=='yes'){?>
                  <div class="tab-pane fade" id="account-document">
                    <div class="box md-4">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_document');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'document_info', 'id' => 'document_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_document_info' => 'ADD');?>
                          <?php echo form_open_multipart('admin/employees/document_info/', $attributes, $hidden);?>
                          <?php
                          $data_usr7 = array(
                                'type'  => 'hidden',
                                'name'  => 'user_id',
                                'value' => $session['user_id'],
                         );
                        echo form_input($data_usr7);
                        ?>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="relation"><?php echo $this->lang->line('xin_e_details_dtype');?></label>
                                <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                                  <option value=""></option>
                                  <?php foreach($all_document_types as $document_type) {?>
                                  <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="date_of_expiry" class="control-label"><?php echo $this->lang->line('xin_e_details_doe');?></label>
                                <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_e_details_doe');?>" name="date_of_expiry" type="text">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="title" class="control-label"><?php echo $this->lang->line('xin_e_details_dtitle');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_dtitle');?>" name="title" type="text">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="email" class="control-label"><?php echo $this->lang->line('xin_e_details_notifyemail');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_notifyemail');?>" name="email" type="email">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="description" class="control-label"><?php echo $this->lang->line('xin_description');?></label>
                                <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <fieldset class="form-group">
                                  <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
                                  <input type="file" class="form-control-file" id="document_file" name="document_file">
                                  <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
                                </fieldset>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="send_mail"><?php echo $this->lang->line('xin_e_details_send_notifyemail');?></label>
                                <select name="send_mail" id="send_mail" class="form-control" data-plugin="select_hrm">
                                  <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                                  <option value="2"><?php echo $this->lang->line('xin_no');?></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_documents');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                                  <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                  <!--<th><?php echo $this->lang->line('xin_e_details_notifyemail');?></th>-->
                                  <th><?php echo $this->lang->line('xin_e_details_doe');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_qualification=='yes'){?>
                  <div class="tab-pane fade" id="account-qualification">
                    <div class="box md-4">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_qualification');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'qualification_info', 'id' => 'qualification_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                          <?php echo form_open('admin/employees/qualification_info/', $attributes, $hidden);?>
                          <?php
                              $data_usr8 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr8);
                            ?>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="name"><?php echo $this->lang->line('xin_e_details_inst_name');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_inst_name');?>" name="name" type="text">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="education_level" class="control-label"><?php echo $this->lang->line('xin_e_details_edu_level');?></label>
                                <select class="form-control" name="education_level" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_edu_level');?>">
                                  <?php foreach($all_education_level as $education_level) {?>
                                  <option value="<?php echo $education_level->education_level_id?>"><?php echo $education_level->name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="from_year" class="control-label"><?php echo $this->lang->line('xin_e_details_timeperiod');?></label>
                                <div class="row">
                                  <div class="col-md-6">
                                    <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_from');?>" name="from_year" type="text">
                                  </div>
                                  <div class="col-md-6">
                                    <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_year" type="text">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="language" class="control-label"><?php echo $this->lang->line('xin_e_details_language');?></label>
                                <select class="form-control" name="language" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_language');?>">
                                  <?php foreach($all_qualification_language as $qualification_language) {?>
                                  <option value="<?php echo $qualification_language->language_id?>"><?php echo $qualification_language->name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="skill" class="control-label"><?php echo $this->lang->line('xin_e_details_skill');?></label>
                                <select class="form-control" name="skill" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_skill');?>">
                                  <option value=""></option>
                                  <?php foreach($all_qualification_skill as $qualification_skill) {?>
                                  <option value="<?php echo $qualification_skill->skill_id?>"><?php echo $qualification_skill->name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="to_year" class="control-label"><?php echo $this->lang->line('xin_description');?></label>
                                <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_qualification');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_qualification" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_inst_name');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_timeperiod');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_edu_level');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_work_experience=='yes'){?>
                  <div class="tab-pane fade" id="account-experience">
                    <div class="box md-4">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_w_experience');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'work_experience_info', 'id' => 'work_experience_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                          <?php echo form_open('admin/employees/work_experience_info/', $attributes, $hidden);?>
                          <?php
                              $data_usr9 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr9);
                            ?>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text" value="" id="company_name">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="post"><?php echo $this->lang->line('xin_e_details_post');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_post');?>" name="post" type="text" value="" id="post">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="from_year" class="control-label"><?php echo $this->lang->line('xin_e_details_timeperiod');?></label>
                                <div class="row">
                                  <div class="col-md-6">
                                    <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_from');?>" name="from_date" type="text">
                                  </div>
                                  <div class="col-md-6">
                                    <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_date" type="text">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                                <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="4" id="description"></textarea>
                                <span class="countdown"></span> </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_w_experience');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_work_experience" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_company_name');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_frm_date');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_to_date');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_post');?></th>
                                  <th><?php echo $this->lang->line('xin_description');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if($system[0]->employee_manage_own_bank_account=='yes'){?>
                  <div class="tab-pane fade" id="account-baccount">
                    <div class="box md-4">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_baccount');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'bank_account_info', 'id' => 'bank_account_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                          <?php echo form_open('admin/employees/bank_account_info/', $attributes, $hidden);?>
                          <?php
                              $data_usr10 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr10);
                            ?>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="account_title"><?php echo $this->lang->line('xin_e_details_acc_title');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_title');?>" name="account_title" type="text" value="" id="account_name">
                              </div>
                              <div class="form-group">
                                <label for="account_number"><?php echo $this->lang->line('xin_e_details_acc_number');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_number');?>" name="account_number" type="text" value="" id="account_number">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="bank_name"><?php echo $this->lang->line('xin_e_details_bank_name');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_name');?>" name="bank_name" type="text" value="" id="bank_name">
                              </div>
                              <div class="form-group">
                                <label for="bank_code"><?php echo $this->lang->line('xin_e_details_bank_code');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_code');?>" name="bank_code" type="text" value="" id="bank_code">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="bank_branch"><?php echo $this->lang->line('xin_e_details_bank_branch');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_branch');?>" name="bank_branch" type="text" value="" id="bank_branch">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_baccount');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_bank_account" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_acc_title');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_acc_number');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_bank_name');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_bank_code');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_bank_branch');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <div class="tab-pane fade" id="account-cpassword">
                    <div class="card-body pb-2">
                      <div class="box">
                        <div class="box-body">
                          <div class="card-block">
                            <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/employees/change_password/', $attributes, $hidden);?>
                            <?php
                              $data_usr11 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr11);
                            ?>
                            <?php if($this->input->get('change_password')):?>
                            <input type="hidden" id="change_pass" value="<?php echo $this->input->get('change_password');?>" />
                            <?php endif;?>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="old_password"><?php echo $this->lang->line('xin_old_password');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_old_password');?>" name="old_password" type="password">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="new_password"><?php echo $this->lang->line('xin_e_details_enpassword');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="password">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="new_password_confirm" class="control-label"><?php echo $this->lang->line('xin_e_details_ecnpassword');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="password">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                                </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-salary">
                    <div class="card-body pb-2">
                      <div class="box-body pb-2">
                        <div class="bg-white">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('xin_employee_type_wages');?></label>
                                <br />
                                <?php if($wages_type==1):?>
                                <?php echo $this->lang->line('xin_payroll_basic_salary');?>
                                <?php endif;?>
                                <?php if($wages_type==2):?>
                                <?php echo $this->lang->line('xin_employee_daily_wages');?>
                                <?php endif;?>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('xin_salary_title');?></label>
                                <br />
                                <?php echo $this->Xin_model->currency_sign($basic_salary);?> </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="smartwizard-2-step-3" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="overflow-hidden">
          <div class="col-md-12">
            <div class="tab-content">
              <div class="row">
                <?php $leave_categories_ids = explode(',',$leave_user[0]->leave_categories); ?>
                <?php foreach($all_leave_types as $type) {
                            if(in_array($type->leave_type_id,$leave_categories_ids)){?>
                <?php
                            $hlfcount =0;
                            //$count_l =0;
                            $leave_halfday_cal = employee_leave_halfday_cal($type->leave_type_id,$session['user_id']);
                            foreach($leave_halfday_cal as $lhalfday):
                                $hlfcount += 0.5;
                            endforeach;
                            
                            $count_l = count_leaves_info($type->leave_type_id,$session['user_id']);
                            $count_l = $count_l - $hlfcount;
                        ?>
                <?php
                            $edays_per_year = $type->days_per_year;
                            
                            if($count_l == 0){
                                $progress_class = '';
                                $count_data = 0;
                            } else {
                                if($edays_per_year > 0){
                                    $count_data = $count_l / $edays_per_year * 100;
                                } else {
                                    $count_data = 0;
                                }
                                // progress
                                if($count_data <= 20) {
                                    $progress_class = 'progress-success';
                                } else if($count_data > 20 && $count_data <= 50){
                                    $progress_class = 'progress-info';
                                } else if($count_data > 50 && $count_data <= 75){
                                    $progress_class = 'progress-warning';
                                } else {
                                    $progress_class = 'progress-danger';
                                }
                            }
                        ?>
                        <div class="col-md-3">
                          <div class="card mb-4">
                            <div class="card-body">
                              <div class="d-flex align-items-center">
                                <div class="fas fa-calendar-alt display-4 text-success"></div>
                                <div class="ml-3">
                                  <div class="text-muted small"><?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $edays_per_year;?>)</div>
                                  <div class="text-large">
                                    <div class="progress" style="height: 6px;">
                                      <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                        } }
                        ?>
              </div>
              <?php $leave = $this->Timesheet_model->get_employee_leaves($session['user_id']); ?>
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_leave');?></span> </div>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered xin_hrsale_table" id="xin_hr_table">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_view');?></th>
                          <th width="250"><?php echo $this->lang->line('xin_leave_type');?></th>
                          <th><?php echo $this->lang->line('left_department');?></th>
                          <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_leave_duration');?></th>
                          <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_applied_on');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($leave->result() as $r) { ?>
                        <?php
                            // get start date and end date
                            $user = $this->Xin_model->read_user_info($r->employee_id);
                            if(!is_null($user)){
                                $full_name = $user[0]->first_name. ' '.$user[0]->last_name;
                                // department
                                $department = $this->Department_model->read_department_information($user[0]->department_id);
                                if(!is_null($department)){
                                    $department_name = $department[0]->department_name;
                                } else {
                                    $department_name = '--';	
                                }
                            } else {
                                $full_name = '--';	
                                $department_name = '--';
                            }
                             
                             // get leave type
                             $leave_type = $this->Timesheet_model->read_leave_type_information($r->leave_type_id);
                             if(!is_null($leave_type)){
                                $type_name = $leave_type[0]->type_name;
                            } else {
                                $type_name = '--';	
                            }
                            
                            // get company
                            $company = $this->Xin_model->read_company_info($r->company_id);
                            if(!is_null($company)){
                                $comp_name = $company[0]->name;
                            } else {
                                $comp_name = '--';	
                            }
                             
                            $datetime1 = new DateTime($r->from_date);
                            $datetime2 = new DateTime($r->to_date);
                            $interval = $datetime1->diff($datetime2);
                            if(strtotime($r->from_date) == strtotime($r->to_date)){
                                $no_of_days =1;
                            } else {
                                $no_of_days = $interval->format('%a') + 1;
                            }
                            $applied_on = $this->Xin_model->set_date_format($r->applied_on);
                            if($r->is_half_day == 1){
                            $duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$this->lang->line('xin_hr_leave_half_day');
                            } else {
                                $duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrsale_total_days').': '.$no_of_days;
                            }							
                             
                            if($r->status==1): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
                            elseif($r->status==2): $status = '<span class="badge bg-green">'.$this->lang->line('xin_approved').'</span>';
                            elseif($r->status==4): $status = '<span class="badge bg-green">'.$this->lang->line('xin_role_first_level_approved').'</span>';
                            else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
                            
                            if(in_array('290',$role_resources_ids)) { //view
                                $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/leave_details/id/'.$r->leave_id.'/" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                            } else {
                                $view = '';
                            }
                            $combhr = $view;
                            $itype_name = $type_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_reason').': '.$r->reason.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('left_company').': '.$comp_name.'<i></i></i></small>';
                            ?>
                        <tr>
                          <td><?php echo $combhr;?></td>
                          <td><?php echo $itype_name;?></td>
                          <td><?php echo $department_name;?></td>
                          <td><i class="fa fa-calendar"></i> <?php echo $duration;?></td>
                          <td><i class="fa fa-calendar"></i> <?php echo $applied_on;?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="smartwizard-2-step-4" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-awards"> <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_awards');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-travels"> <i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_travels');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-training"> <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_training');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tickets"> <i class="lnr lnr-location text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_tickets');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-transfers"> <i class="lnr lnr-store text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_transfers');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-promotions"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_promotions');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-complaints"> <i class="lnr lnr-file-add text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_complaints');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-warnings"> <i class="lnr lnr-paw text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_warnings');?></a> </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-awards">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_awards');?> </span> </div>
                    <?php $award = $this->Awards_model->get_employee_awards($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table" id="xin_hr_table">
                          <thead>
                            <tr>
                              <th style="width:100px;"><?php echo $this->lang->line('xin_view');?></th>
                              <th width="300"><i class="fa fa-trophy"></i> <?php echo $this->lang->line('xin_award_name');?></th>
                              <th><i class="fa fa-gift"></i> <?php echo $this->lang->line('xin_gift');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_award_month_year');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($award->result() as $r) { ?>
                            <?php
                            // get user > added by
                            $user = $this->Xin_model->read_user_info($r->employee_id);
                            // user full name
                            if(!is_null($user)){
                                $full_name = $user[0]->first_name.' '.$user[0]->last_name;
                            } else {
                                $full_name = '--';	
                            }
                            // get award type
                            $award_type = $this->Awards_model->read_award_type_information($r->award_type_id);
                            if(!is_null($award_type)){
                                $award_type = $award_type[0]->award_type;
                            } else {
                                $award_type = '--';	
                            }
                            
                            $d = explode('-',$r->award_month_year);
                            $get_month = date('F', mktime(0, 0, 0, $d[1], 10));
                            $award_date = $get_month.', '.$d[0];
                            // get currency
                            if($r->cash_price == '') {
                                $currency = $this->Xin_model->currency_sign(0);
                            } else {
                                $currency = $this->Xin_model->currency_sign($r->cash_price);
                            }		
                            // get company
                            $company = $this->Xin_model->read_company_info($r->company_id);
                            if(!is_null($company)){
                                $comp_name = $company[0]->name;
                            } else {
                                $comp_name = '--';	
                            }
                            
                            $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->award_id . '" data-field_type="awards"><span class="fa fa-eye"></span></button></span>';
                            
                            $award_info = $award_type.'<br><small class="text-muted"><i>'.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_cash_price').': '.$currency.'<i></i></i></small>';
                            $combhr = $view;
                            ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $award_info;?></td>
                              <td><?php echo $r->gift_item;?></td>
                              <td><?php echo $award_date;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-travels">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_travel');?> </span> </div>
                    <?php $travel = $this->Travel_model->get_employee_travel($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr>
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th><?php echo $this->lang->line('xin_summary');?></th>
                              <th><?php echo $this->lang->line('xin_visit_place');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_start_date');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_end_date');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($travel->result() as $r) { ?>
                            <?php
                                // get start date
                                $start_date = $this->Xin_model->set_date_format($r->start_date);
                                // get end date
                                $end_date = $this->Xin_model->set_date_format($r->end_date);
                                // get company
                                $company = $this->Xin_model->read_company_info($r->company_id);
                                if(!is_null($company)){
                                    $comp_name = $company[0]->name;
                                } else {
                                    $comp_name = '--';	
                                }
                                // status
                                //if($r->status==0): $status = $this->lang->line('xin_pending');
                                //elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
                                if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
                                    elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected'); endif;
                                
                                $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->travel_id . '" data-field_type="travel"><span class="fa fa-eye"></span></button></span>';
                                
                                $combhr = $view;
                                $expected_budget = $this->Xin_model->currency_sign($r->expected_budget);
                                $actual_budget = $this->Xin_model->currency_sign($r->actual_budget);
                                $iemployee_name = $r->visit_purpose.'<br><small class="text-muted"><i>'.$this->lang->line('xin_expected_travel_budget').': '.$expected_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_actual_travel_budget').': '.$actual_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $iemployee_name;?></td>
                              <td><?php echo $r->visit_place;?></td>
                              <td><?php echo $start_date;?></td>
                              <td><?php echo $end_date;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-training">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_training');?> </span> </div>
                    <?php $training = $this->Training_model->get_employee_training($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr>
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th><?php echo $this->lang->line('left_training_type');?></th>
                              <th><?php echo $this->lang->line('xin_trainer');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_training_duration');?></th>
                              <th><i class="fa fa-dollar"></i> <?php echo $this->lang->line('xin_cost');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($training->result() as $r) { ?>
                            <?php
                                $aim = explode(',',$r->employee_id);
                                // get training type
                                $type = $this->Training_model->read_training_type_information($r->training_type_id);
                                if(!is_null($type)){
                                    $itype = $type[0]->type;
                                } else {
                                    $itype = '--';	
                                }
                                // get trainer
                                $trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
                                // trainer full name
                                if(!is_null($trainer)){
                                    $trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
                                } else {
                                    $trainer_name = '--';	
                                }
                                // get start date
                                $start_date = $this->Xin_model->set_date_format($r->start_date);
                                // get end date
                                $finish_date = $this->Xin_model->set_date_format($r->finish_date);
                                // training date
                                $training_date = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
                                // set currency
                                $training_cost = $this->Xin_model->currency_sign($r->training_cost);
                                /* get Employee info*/
                                if($r->employee_id == '') {
                                    $ol = '--';
                                } else {
                                    $ol = '<ol class="nl">';
                                    foreach(explode(',',$r->employee_id) as $uid) {
                                        $user = $this->Xin_model->read_user_info($uid);
                                        if(!is_null($user)){
                                            $ol .= '<li>'.$user[0]->first_name.' '.$user[0]->last_name.'</li>';
                                        } else {
                                            $ol .= '--';
                                        }
                                     }
                                     $ol .= '</ol>';
                                }
                                // status
                                //if($r->training_status==0): $status = $this->lang->line('xin_pending');
                                //elseif($r->training_status==1): $status = $this->lang->line('xin_started'); elseif($r->training_status==2): $status = $this->lang->line('xin_completed');
                                //else: $status = $this->lang->line('xin_terminated'); endif;
                                if($r->training_status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
                                elseif($r->training_status==1): $status = '<span class="badge bg-teal">'.$this->lang->line('xin_started').'</span>'; elseif($r->training_status==2): $status = '<span class="badge bg-green">'.$this->lang->line('xin_completed').'</span>';
                                else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_terminated').'</span>'; endif;
                                // get company
                                $company = $this->Xin_model->read_company_info($r->company_id);
                                if(!is_null($company)){
                                $comp_name = $company[0]->name;
                                } else {
                                  $comp_name = '--';	
                                }
    
                                $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/training/details/'.$r->training_id.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                                $combhr = $view;
                                $iitype = $itype.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $iitype;?></td>
                              <td><?php echo $trainer_name;?></td>
                              <td><?php echo $training_date;?></td>
                              <td><?php echo $training_cost;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-tickets">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_tickets');?> </span> </div>
                    <?php $ticket = $this->Tickets_model->get_employees_tickets($session['user_id']);?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr class="xin-bg-dark">
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th><?php echo $this->lang->line('xin_ticket_code');?></th>
                              <th><?php echo $this->lang->line('xin_subject');?></th>
                              <th><?php echo $this->lang->line('xin_p_priority');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_date');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($ticket->result() as $r) { ?>
                            <?php		
                                // priority
                                if($r->ticket_priority==1): $priority = $this->lang->line('xin_low'); elseif($r->ticket_priority==2): $priority = $this->lang->line('xin_medium'); elseif($r->ticket_priority==3): $priority = $this->lang->line('xin_high'); elseif($r->ticket_priority==4): $priority = $this->lang->line('xin_critical');  endif;
                                 
                                 // status
                                 //if($r->ticket_status==1): $status = $this->lang->line('xin_open'); elseif($r->ticket_status==2): $status = $this->lang->line('xin_closed'); endif;
                                 if($r->ticket_status==1): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_open').'</span>';
                                    else: $status = '<span class="badge bg-green">'.$this->lang->line('xin_closed').'</span>';endif;
                                 // ticket date and time
                                 $created_at = date('h:i A', strtotime($r->created_at));
                                 $_date = explode(' ',$r->created_at);
                                 $edate = $this->Xin_model->set_date_format($_date[0]);
                                 $_created_at = $edate. ' '. $created_at;
                                
                                $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/tickets/details/'.$r->ticket_id.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                                $combhr = $view;
                                $iticket_code = $r->ticket_code.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $iticket_code;?></td>
                              <td><?php echo $r->subject;?></td>
                              <td><?php echo $priority;?></td>
                              <td><?php echo $_created_at;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-transfers">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_transfers');?> </span> </div>
                    <?php $transfer = $this->Transfers_model->get_employee_transfers($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr>
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th><?php echo $this->lang->line('xin_summary');?></th>
                              <th><?php echo $this->lang->line('left_company');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_transfer_date');?></th>
                              <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($transfer->result() as $r) { ?>
                            <?php
                            // get date
                            $transfer_date = $this->Xin_model->set_date_format($r->transfer_date);
                            // get department by id
                            $department = $this->Department_model->read_department_information($r->transfer_department);
                            if(!is_null($department)){
                                $department_name = $department[0]->department_name;
                            } else {
                                $department_name = '--';	
                            }
                            // get location by id
                            $location = $this->Location_model->read_location_information($r->transfer_location);
                            if(!is_null($location)){
                                $location_name = $location[0]->location_name;
                            } else {
                                $location_name = '--';	
                            }
                            // get status
                            if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
                            elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
                            
                            // get company
                            $company = $this->Xin_model->read_company_info($r->company_id);
                            if(!is_null($company)){
                                $comp_name = $company[0]->name;
                            } else {
                                $comp_name = '--';	
                            }
                            
                            $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->transfer_id . '" data-field_type="transfers"><span class="fa fa-eye"></span></button></span>';
                        $combhr = $view;
                        $xinfo = $this->lang->line('xin_transfer_to_department').': '.$department_name.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_transfer_to_location').': '.$location_name.'<i></i></i></small>';
                            ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $xinfo;?></td>
                              <td><?php echo $comp_name;?></td>
                              <td><?php echo $transfer_date;?></td>
                              <td><?php echo $status;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-promotions">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_promotions');?> </span> </div>
                    <?php $promotion = $this->Promotion_model->get_employee_promotions($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr>
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th><?php echo $this->lang->line('xin_promotion_title');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_date');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($promotion->result() as $r) { ?>
                            <?php
                                // get company
                                $company = $this->Xin_model->read_company_info($r->company_id);
                                if(!is_null($company)){
                                    $comp_name = $company[0]->name;
                                } else {
                                    $comp_name = '--';	
                                }
                                // get promotion date
                                $promotion_date = $this->Xin_model->set_date_format($r->promotion_date);
                                    $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->promotion_id . '" data-field_type="promotion"><span class="fa fa-eye"></span></button></span>';
                                $combhr = $view;
                                $pro_desc = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('xin_description').': '.$r->description.'<i></i></i></small>';
                                ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $pro_desc;?></td>
                              <td><?php echo $promotion_date;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-complaints">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_complaints');?> </span> </div>
                    <?php $complaint = $this->Complaints_model->get_employee_complaints($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr>
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th width="200"><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_complaint_from');?></th>
                              <th><i class="fa fa-users"></i> <?php echo $this->lang->line('xin_complaint_against');?></th>
                              <th><?php echo $this->lang->line('xin_complaint_title');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_complaint_date');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($complaint->result() as $r) { ?>
                            <?php
                                // get user > added by
                                $user = $this->Xin_model->read_user_info($r->complaint_from);
                                // user full name
                                if(!is_null($user)){
                                    $complaint_from = $user[0]->first_name.' '.$user[0]->last_name;
                                } else {
                                    $complaint_from = '--';	
                                }
                                
                                if($r->complaint_against == '') {
                                    $ol = '--';
                                } else {
                                    $ol = '<ol class="nl">';
                                    foreach(explode(',',$r->complaint_against) as $desig_id) {
                                        $_comp_name = $this->Xin_model->read_user_info($desig_id);
                                        if(!is_null($_comp_name)){
                                            $ol .= '<li>'.$_comp_name[0]->first_name.' '.$_comp_name[0]->last_name.'</li>';
                                        } else {
                                            $ol .= '';
                                        }
                                        
                                     }
                                     $ol .= '</ol>';
                                }
                                // get complaint date
                                $complaint_date = $this->Xin_model->set_date_format($r->complaint_date);
                            
                                $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->complaint_id . '" data-field_type="complaints"><span class="fa fa-eye"></span></button></span>';
                                // get company
                                $company = $this->Xin_model->read_company_info($r->company_id);
                                if(!is_null($company)){
                                    $comp_name = $company[0]->name;
                                } else {
                                    $comp_name = '--';	
                                }
                                // get status
                                if($r->status==0): $status = '<span class="badge bg-red">'.$this->lang->line('xin_pending').'</span>';
                                elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>'; else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>';endif;
                                // info
                                $icomplaint_from = $complaint_from.'<br><small class="text-muted"><i>'.$this->lang->line('xin_description').': '.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                $combhr = $view;
                                ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $icomplaint_from;?></td>
                              <td><?php echo $ol;?></td>
                              <td><?php echo $r->title;?></td>
                              <td><?php echo $complaint_date;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-warnings">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_warnings');?> </span> </div>
                    <?php $warning = $this->Warning_model->get_employee_warning($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr>
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th><?php echo $this->lang->line('xin_subject');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_warning_date');?></th>
                              <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_warning_by');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($warning->result() as $r) { ?>
                            <?php
                                // get user > warning to
                                $user = $this->Xin_model->read_user_info($r->warning_to);
                                // user full name
                                if(!is_null($user)){
                                    $warning_to = $user[0]->first_name.' '.$user[0]->last_name;
                                } else {
                                    $warning_to = '--';	
                                }
                                // get user > warning by
                                $user_by = $this->Xin_model->read_user_info($r->warning_by);
                                // user full name
                                if(!is_null($user_by)){
                                    $warning_by = $user_by[0]->first_name.' '.$user_by[0]->last_name;
                                } else {
                                    $warning_by = '--';	
                                }
                                // get warning date
                                $warning_date = $this->Xin_model->set_date_format($r->warning_date);
                                        
                                // get status
                                if($r->status==0): $status = $this->lang->line('xin_pending');
                                elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
                                // get warning type
                                $warning_type = $this->Warning_model->read_warning_type_information($r->warning_type_id);
                                if(!is_null($warning_type)){
                                    $wtype = $warning_type[0]->type;
                                } else {
                                    $wtype = '--';	
                                }
                                // get company
                                $company = $this->Xin_model->read_company_info($r->company_id);
                                if(!is_null($company)){
                                    $comp_name = $company[0]->name;
                                } else {
                                    $comp_name = '--';	
                                }
                                
                                $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->warning_id . '" data-field_type="warning"><span class="fa fa-eye"></span></button></span>';
                                
                                if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
                                elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
                                
                                $combhr = $view;
                                
                                $iwarning_to = $warning_to.'<br><small class="text-muted"><i>'.$wtype.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $r->subject;?></td>
                              <td><?php echo $warning_date;?></td>
                              <td><?php echo $warning_by;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="smartwizard-2-step-5" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-projects"> <i class="lnr lnr-layers text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_projects');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tasks"> <i class="lnr lnr-dice text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_tasks');?></a> </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-projects">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_projects');?> </span> </div>
                    <?php $project = $this->Project_model->get_employee_projects($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table" id="xin_hr_table">
                          <thead>
                            <tr>
                              <th width="230"><?php echo $this->lang->line('xin_project_summary');?></th>
                              <th><?php echo $this->lang->line('xin_p_priority');?></th>
                              <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_project_users');?></th>
                              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_p_enddate');?></th>
                              <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($project->result() as $r) { ?>
                            <?php
                            $aim = explode(',',$r->assigned_to);
                            // get user > added by
                            $user = $this->Xin_model->read_user_info($r->added_by);
                            // user full name
                            if(!is_null($user)){
                                $full_name = $user[0]->first_name.' '.$user[0]->last_name;
                            } else {
                                $full_name = '--';	
                            }
                            // get date
                            $pdate = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($r->end_date);
                            
                            //project_progress
                            if($r->project_progress <= 20) {
                                $progress_class = 'progress-danger';
                            } else if($r->project_progress > 20 && $r->project_progress <= 50){
                                $progress_class = 'progress-warning';
                            } else if($r->project_progress > 50 && $r->project_progress <= 75){
                                $progress_class = 'progress-info';
                            } else {
                                $progress_class = 'progress-success';
                            }
                            
                            // progress
                            $pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->project_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->project_progress.'" max="100">'.$r->project_progress.'%</progress>';
                                    
                            //status
                            if($r->status == 0) {
                                $status = $this->lang->line('xin_not_started');
                            } else if($r->status ==1){
                                $status = $this->lang->line('xin_in_progress');
                            } else if($r->status ==2){
                                $status = $this->lang->line('xin_completed');
                            } else {
                                $status = $this->lang->line('xin_deffered');
                            }
                            
                            // priority
                            if($r->priority == 1) {
                                $priority = '<span class="label label-danger">'.$this->lang->line('xin_highest').'</span>';
                            } else if($r->priority ==2){
                                $priority = '<span class="label label-danger">'.$this->lang->line('xin_high').'</span>';
                            } else if($r->priority ==3){
                                $priority = '<span class="label label-primary">'.$this->lang->line('xin_normal').'</span>';
                            } else {
                                $priority = '<span class="label label-success">'.$this->lang->line('xin_low').'</span>';
                            }
                            
                            //assigned user
                            if($r->assigned_to == '') {
                                $ol = $this->lang->line('xin_not_assigned');
                            } else {
                                $ol = '';
                                foreach(explode(',',$r->assigned_to) as $desig_id) {
                                    $assigned_to = $this->Xin_model->read_user_info($desig_id);
                                    if(!is_null($assigned_to)){
                                        
                                      $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
                                     if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
                                        $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                        } else {
                                        if($assigned_to[0]->gender=='Male') { 
                                            $de_file = base_url().'uploads/profile/default_male.jpg';
                                         } else {
                                            $de_file = base_url().'uploads/profile/default_female.jpg';
                                         }
                                        $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                        }
                                    } ////
                                    else {
                                        $ol .= '';
                                    }
                                 }
                                 $ol .= '';
                            }
                            
                            $project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/project/detail/'.$r->project_id . '" target="_blank">'.$r->title.'</a></div><div class="text-muted">'.$r->summary.'</div>';
                            ?>
                            <tr>
                              <td><?php echo $project_summary;?></td>
                              <td><?php echo $priority;?></td>
                              <td><?php echo $ol;?></td>
                              <td><?php echo $pdate;?></td>
                              <td><?php echo $pbar;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-tasks">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_tasks');?> </span> </div>
                    <?php $task = $this->Timesheet_model->get_employee_tasks($session['user_id']); ?>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered xin_hrsale_table">
                          <thead>
                            <tr>
                              <th><?php echo $this->lang->line('xin_view');?></th>
                              <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                              <th><?php echo $this->lang->line('xin_end_date');?></th>
                              <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                              <th><?php echo $this->lang->line('xin_assigned_to');?></th>
                              <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($task->result() as $r) { ?>
                            <?php
                                $aim = explode(',',$r->assigned_to);
                      
                                if($r->assigned_to == '' || $r->assigned_to == 'None') {
                                    $ol = 'None';
                                } else {
                                    $ol = '<ol class="nl">';
                                    foreach(explode(',',$r->assigned_to) as $uid) {
                                        //$user = $this->Xin_model->read_user_info($uid);
                                        $assigned_to = $this->Xin_model->read_user_info($uid);
                                        if(!is_null($assigned_to)){
                                            
                                        $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
                                         if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
                                            $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                            } else {
                                            if($assigned_to[0]->gender=='Male') { 
                                                $de_file = base_url().'uploads/profile/default_male.jpg';
                                             } else {
                                                $de_file = base_url().'uploads/profile/default_female.jpg';
                                             }
                                            $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                            }
                                        }
                                     }
                                 $ol .= '</ol>';
                                }							
                                // task project
                                $prj_task = $this->Project_model->read_project_information($r->project_id);
                                if(!is_null($prj_task)){
                                    $prj_name = $prj_task[0]->title;
                                } else {
                                    $prj_name = '--';
                                }
                                
                                /// set task progress
                                if($r->task_progress=='' || $r->task_progress==0): $progress = 0; else: $progress = $r->task_progress; endif;				
                                // task progress
                                if($r->task_progress <= 20) {
                                $progress_class = 'progress-danger';
                                } else if($r->task_progress > 20 && $r->task_progress <= 50){
                                $progress_class = 'progress-warning';
                                } else if($r->task_progress > 50 && $r->task_progress <= 75){
                                $progress_class = 'progress-info';
                                } else {
                                $progress_class = 'progress-success';
                                }
                                
                                $progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->task_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->task_progress.'" max="100">'.$r->task_progress.'%</progress>';
                                // task end date
                                $tdate = $this->Xin_model->set_date_format($r->end_date);							
                                // task status
                                if($r->task_status == 0) {
                                    $status = $this->lang->line('xin_not_started');
                                } else if($r->task_status ==1){
                                    $status = $this->lang->line('xin_in_progress');
                                } else if($r->task_status ==2){
                                    $status = $this->lang->line('xin_completed');
                                } else {
                                    $status = $this->lang->line('xin_deffered');
                                }
                                // task end date
                                if(in_array('322',$role_resources_ids)) { //view
                                    $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/task_details/id/'.$r->task_id.'/" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                                } else {
                                    $view = '';
                                }
                                $combhr = $view;
                                $task_name = $r->task_name.'<br>'.$this->lang->line('xin_project').': <a href="'.site_url().'admin/project/detail/'.$r->project_id.'" target="_blank">'.$prj_name.'</a>';
                                ?>
                            <tr>
                              <td><?php echo $combhr;?></td>
                              <td><?php echo $task_name;?></td>
                              <td><?php echo $tdate;?></td>
                              <td><?php echo $status;?></td>
                              <td><?php echo $ol;?></td>
                              <td><?php echo $progress_bar;?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="smartwizard-2-step-6" class="card animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_payment_history');?> </span> </div>
        <?php $history = $this->Payroll_model->get_payroll_slip($session['user_id']); ?>
        <div class="card-body">
          <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered xin_hrsale_table" id="xin_hr_table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('xin_action');?></th>
                  <th><?php echo $this->lang->line('xin_payroll_net_payable');?></th>
                  <th><?php echo $this->lang->line('xin_salary_month');?></th>
                  <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_payroll_date_title');?></th>
                  <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($history->result() as $r) { ?>
                <?php
                    // get addd by > template
                    $user = $this->Xin_model->read_user_info($r->employee_id);
                    // user full name
                    if(!is_null($user)){
                    $full_name = $user[0]->first_name.' '.$user[0]->last_name;
                    $emp_link = $user[0]->employee_id;			  		  
                    $month_payment = date("F, Y", strtotime($r->salary_month));
                    
                    $p_amount = $this->Xin_model->currency_sign($r->net_salary);
                    
                    // get date > created at > and format
                    $created_at = $this->Xin_model->set_date_format($r->created_at);
                    // get designation
                    $designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
                    if(!is_null($designation)){
                        $designation_name = $designation[0]->designation_name;
                    } else {
                        $designation_name = '--';	
                    }
                    // department
                    $department = $this->Department_model->read_department_information($user[0]->department_id);
                    if(!is_null($department)){
                    $department_name = $department[0]->department_name;
                    } else {
                    $department_name = '--';	
                    }
                    $department_designation = $designation_name.' ('.$department_name.')';
                    // get company
                    $company = $this->Xin_model->read_company_info($user[0]->company_id);
                    if(!is_null($company)){
                        $comp_name = $company[0]->name;
                    } else {
                        $comp_name = '--';	
                    }
                    // bank account
                    $bank_account = $this->Employees_model->get_employee_bank_account_last($user[0]->user_id);
                    if(!is_null($bank_account)){
                        $account_number = $bank_account[0]->account_number;
                    } else {
                        $account_number = '--';	
                    }
                    $payslip = '<span data-toggle="tooltip" data-placement="top" data-state="primary" data-state="primary" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
                    
                $ifull_name = nl2br ($full_name."\r\n <small class='text-muted'><i>".$this->lang->line('xin_employees_id').': '.$emp_link."<i></i></i></small>\r\n <small class='text-muted'><i>".$department_designation.'<i></i></i></small>');
                    ?>
                <tr>
                  <td><?php echo $payslip;?></td>
                  <td><?php echo $p_amount;?></td>
                  <td><?php echo $month_payment;?></td>
                  <td><?php echo $created_at;?></td>
                  <td><?php echo $this->lang->line('xin_payroll_paid');?></td>
                </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
