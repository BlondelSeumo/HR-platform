<?php
/* Performance Indicator view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('42',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/performance_appraisal/');?>" data-link-data="<?php echo site_url('admin/performance_appraisal/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon oi oi-aperture"></span>
        <?php echo $this->lang->line('left_performance_xappraisal');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('left_performance_xappraisal');?></div>
      </a>
    </li>
    <?php } ?>
    <?php if(in_array('41',$role_resources_ids)) {?>
    <li class="nav-item active">
      <a href="<?php echo site_url('admin/performance_indicator/');?>" data-link-data="<?php echo site_url('admin/performance_indicator/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-ios-contract"></span>
        <?php echo $this->lang->line('xin_indicator');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_indicator');?></div>
      </a>
    </li>
    <?php } ?>
    <?php if($system[0]->performance_option == 'both') {?>
    <?php if(in_array('107',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/goal_tracking/');?>" data-link-data="<?php echo site_url('admin/goal_tracking/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-cube"></span> <?php echo $this->lang->line('xin_hr_goal_tracking');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_hr_goal_tracking');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('108',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/goal_tracking/type/');?>" data-link-data="<?php echo site_url('admin/goal_tracking/type/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?></div>
      </a> </li>
    <?php } ?> 
    <?php } ?>
  </ul>
  <hr class="border-light m-0 mb-3">
</div>
<?php if(in_array('298',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_role_set');?></strong> <?php echo $this->lang->line('xin_indicator');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_performance_indicator', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/performance_indicator/add_indicator', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="left_company"><?php echo $this->lang->line('left_company');?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } else {?>
            <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="left_company"><?php echo $this->lang->line('left_company');?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
						<?php if($ecompany_id == $company->company_id):?>
                        <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                        <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="designation"><?php echo $this->lang->line('dashboard_designation');?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group" id="designation_ajax">
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_designation');?>" name="designation_id">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <h4 class="form-section"><?php echo $this->lang->line('xin_performance_technical_competencies');?></h4>
                <?php $itechnical_competencies = explode(',',$system[0]->technical_competencies);?>
            	<?php foreach($itechnical_competencies as $itech_comp):?>
                <div class="row">
                  <div class="col-md-6 control-label">
                    <div class="form-group">
                      <p><?php echo $itech_comp;?></p>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <select name="technical_competencies_value[]" class="form-control">
                        <option value="0"><?php echo $this->lang->line('xin_performance_none');?></option>
                        <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                        <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                        <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                        <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <?php endforeach;?>
              </div>
              <div class="col-md-6">
                <h4 class="form-section"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></h4>
				<?php $iorganizational_competencies = explode(',',$system[0]->organizational_competencies);?>
                <?php foreach($iorganizational_competencies as $iorg_comp):?>
                <div class="row">
                  <div class="col-md-6 control-label">
                    <div class="form-group">
                      <p><?php echo $iorg_comp;?></p>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <select name="organizational_competencies_value[]" class="form-control">
                        <option value="5"><?php echo $this->lang->line('xin_performance_none');?></option>
                        <option value="6"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                        <option value="7"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                        <option value="8"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <?php endforeach;?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_performance_indicators');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('dashboard_designation');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><?php echo $this->lang->line('left_department');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_added_by');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_created_at');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
