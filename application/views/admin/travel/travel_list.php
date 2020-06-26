<?php
/* Travel view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_employee_info($session['user_id']);?>
<?php if(in_array('216',$role_resources_ids)) {?>

<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_travel');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_travel', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php if($user_info[0]->user_role_id==1){ ?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php } else { ?>
        <?php $hidden = array('user_id' => $session['user_id'],'company_id' => $user_info[0]->company_id,'employee_id' => $session['user_id']);?>
        <?php } ?>
        <?php echo form_open('admin/travel/add_travel', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group" id="employee_ajax">
                  <label for="employee_id"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                  <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
                <?php } ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="visit_purpose"><?php echo $this->lang->line('xin_visit_purpose');?></label>
                      <input class="form-control" placeholder="Purpose of Visit<?php echo $this->lang->line('xin_visit_purpose');?>" name="visit_purpose" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="visit_place"><?php echo $this->lang->line('xin_visit_place');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_visit_place');?>" name="visit_place" type="text">
                    </div>
                  </div>
                </div>
                <?php if($user_info[0]->user_role_id!=1){ ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="travel_mode"><?php echo $this->lang->line('xin_travel_mode');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_travel_mode');?>" name="travel_mode">
                        <option value="1"><?php echo $this->lang->line('xin_by_bus');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_by_train');?></option>
                        <option value="3"><?php echo $this->lang->line('xin_by_plane');?></option>
                        <option value="4"><?php echo $this->lang->line('xin_by_taxi');?></option>
                        <option value="5"><?php echo $this->lang->line('xin_by_rental_car');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="arrangement_type"><?php echo $this->lang->line('xin_arragement_type');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_arragement_type');?>" name="arrangement_type">
                        <?php foreach($travel_arrangement_types as $travel_arr_type) {?>
                        <option value="<?php echo $travel_arr_type->arrangement_type_id;?>"> <?php echo $travel_arr_type->type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="expected_budget"><?php echo $this->lang->line('xin_expected_travel_budget');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_expected_travel_budget');?>" name="expected_budget" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="actual_budget"><?php echo $this->lang->line('xin_actual_travel_budget');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_actual_travel_budget');?>" name="actual_budget" type="text">
                    </div>
                  </div>
                </div>
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="travel_mode"><?php echo $this->lang->line('xin_travel_mode');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_travel_mode');?>" name="travel_mode">
                        <option value="1"><?php echo $this->lang->line('xin_by_bus');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_by_train');?></option>
                        <option value="3"><?php echo $this->lang->line('xin_by_plane');?></option>
                        <option value="4"><?php echo $this->lang->line('xin_by_taxi');?></option>
                        <option value="5"><?php echo $this->lang->line('xin_by_rental_car');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="arrangement_type"><?php echo $this->lang->line('xin_arragement_type');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_arragement_type');?>" name="arrangement_type">
                        <?php foreach($travel_arrangement_types as $travel_arr_type) {?>
                        <option value="<?php echo $travel_arr_type->arrangement_type_id;?>"> <?php echo $travel_arr_type->type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <?php } ?>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_travels');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_single_employee');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><?php echo $this->lang->line('xin_visit_place');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_start_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_end_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
