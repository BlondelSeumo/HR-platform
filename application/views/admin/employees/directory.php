<?php
/* Employee Directory view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $countries = $this->Xin_model->get_countries();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($user_info[0]->user_role_id==1){ ?>
      <div class="ui-bordered px-4 pt-4 mb-4 mt-3">
      <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/employees/hr', $attributes, $hidden);?>
        <?php
			$data = array(
			  'type'        => 'hidden',
			  'name'        => 'hrsale_directory',
			  'id'          => 'date_format',
			  'value'       => 1,
			  'class'       => 'form-control',
			);
			echo form_input($data);
			?>
          <div class="form-row">
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="filter_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                  <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  <?php foreach($get_all_companies as $company) {?>
                  <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="col-md mb-3" id="location_ajaxflt">
              <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
              <select name="location_id" id="filter_location" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
              </select>
            </div>
            <div class="col-md mb-3" id="department_ajaxflt">
              <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
              <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
                  <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                </select>
            </div>
            <div class="col-md mb-3" id="designation_ajaxflt">
              <label class="form-label"><?php echo $this->lang->line('xin_designation');?></label>
              <select class="form-control" name="designation_id" data-plugin="select_hrm"  id="filter_designation" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                  <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                </select>
            </div>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-secondary btn-block', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_get'))); ?>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
<?php } ?>
<div class="d-flex flex-wrap justify-content-between ui-bordered px-3 pt-3 mb-4">
  <div> 
    
    <!-- View toggle -->
    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
      <label class="btn btn-default icon-btn md-btn-flat active">
        <input type="radio" name="contacts-view" value="contacts-col-view" checked>
        <span class="ion ion-md-apps"></span> </label>
      <label class="btn btn-default icon-btn md-btn-flat">
        <input type="radio" name="contacts-view" value="contacts-row-view">
        <span class="ion ion-md-menu"></span> </label>
    </div>
    <!-- / View toggle -->
    <?php if(in_array('201',$role_resources_ids)) {?>
    <button type="button" class="btn btn-outline-primary mb-3 ml-3" onclick="window.location='<?php echo site_url('admin/employees/');?>'"> <span class="ion ion-md-add"></span>&nbsp; <?php echo $this->lang->line('xin_add_new');?></button>
    <?php } ?>
  </div>
</div>
<div class="row contacts-col-view">
  <?php foreach($results as $employee) { ?>
  <?php
	if($employee->profile_picture!='' && $employee->profile_picture!='no file') {
		$u_file = base_url().'uploads/profile/'.$employee->profile_picture;
	} else {
		if($employee->gender=='Male') { 
			$u_file = base_url().'uploads/profile/default_male.jpg';
		} else {
			$u_file = base_url().'uploads/profile/default_female.jpg';
		}
	}
	?>
  <?php $designation = $this->Designation_model->read_designation_information($employee->designation_id);?>
  <?php
		if(!is_null($designation)){
		$designation_name = strtolower($designation[0]->designation_name);
	  } else {
		$designation_name = '--';	
	  }
	?>
  <div class="contacts-col col-12">
    <div class="card mb-4">
      <div class="card-body">
      <?php if(in_array('202',$role_resources_ids)) {?>
        <div class="contacts-dropdown btn-group">
          <button type="button" class="btn btn-sm btn-default icon-btn borderless btn-round md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown"> <i class="ion ion-ios-more"></i> </button>
          <div class="contacts-dropdown-menu dropdown-menu dropdown-menu-right"> <a class="dropdown-item" href="<?php echo site_url('admin/employees/detail')?>/<?php echo $employee->user_id;?>">Edit</a> </div>
        </div>
        <?php } ?>
        <div class="contact-content"> <img src="<?php echo $u_file;?>" class="contact-content-img rounded-circle" alt="">
          <div class="contact-content-about">
            <h5 class="contact-content-name mb-1"> 
            <?php if(in_array('202',$role_resources_ids)) {?>
            	<a href="<?php echo site_url('admin/employees/detail')?>/<?php echo $employee->user_id;?>" class="text-dark"><?php echo $employee->first_name;?> <?php echo $employee->last_name;?></a>
			<?php } else {?>
            	<a href="javascript:void();" class="text-dark"><?php echo $employee->first_name;?> <?php echo $employee->last_name;?></a>
            <?php } ?></h5>
            <div class="contact-content-user text-muted small mb-2"><?php echo $employee->email;?></div>
            <div class="small"> <strong><?php echo ucwords($designation_name);?></strong> <br>
              <?php echo $employee->contact_no;?> </div>
            <hr class="border-light">
            <div> <a target="_blank" href="<?php echo $employee->twitter_link;?>" class="text-twitter"> <span class="ion ion-logo-twitter"></span> </a> &nbsp;&nbsp; <a target="_blank" href="<?php echo $employee->facebook_link;?>" class="text-facebook"> <span class="ion ion-logo-facebook"></span> </a> &nbsp;&nbsp; <a target="_blank" href="<?php echo $employee->linkdedin_link;?>" class="text-linkdedin"> <span class="ion ion-logo-linkedin"></span> </a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php //} ?>
</div>
<?php if (isset($links)) { ?>
  <?php echo $links ?>
<?php } ?>

