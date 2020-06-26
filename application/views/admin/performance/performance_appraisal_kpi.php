<?php
/* Performance Appraisal KPI
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $curMonth = date("m", time()); $curQuarter = ceil($curMonth/3);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php if ($is_department_head && $user[0]->user_role_id == 1) { ?>
<section id="decimal">
  <div class="row">
    <div class="col-md-4">
      <label for="aj_all_employees" class="control-label"><?php echo $this->lang->line('kpi_select_employee_to_view');?> </label>
      <select name="all_employess" id="aj_all_employees" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('kpi_select_employee_to_view');?>">
        <?php foreach ($employees as $e) : ?>
        <option value=""></option>
        <option value="<?php echo $e->user_id; ?>" <?php echo ($e->user_id == $session['user_id'])?'selected':'';?>><?php echo $e->first_name; ?> <?php echo $e->last_name; ?> <?php echo ($e->user_id == $session['user_id'])?'(Me)':''; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <br>
</section>
<?php } ?>
<?php if ($user[0]->user_role_id == 1 && !$is_department_head) { ?>
<section id="decimal">
  <div class="row">
    <div class="col-md-4">
      <label for="aj_all_employees" class="control-label"><?php echo $this->lang->line('kpi_select_employee_to_view');?> </label>
      <select name="all_employess" id="aj_all_employees" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('kpi_select_employee_to_view');?>">
        <?php foreach ($employees as $e) : ?>
        <option value=""></option>
        <option value="<?php echo $e->user_id; ?>" <?php echo ($e->user_id == $session['user_id'])?'selected':'';?>><?php echo $e->first_name; ?> <?php echo $e->last_name; ?> <?php echo ($e->user_id == $session['user_id'])?'(Me)':''; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <br>
</section>
<?php } ?>
<?php if ($is_department_head && $user[0]->user_role_id == 2) { ?>
<section id="decimal">
  <div class="row">
    <div class="col-md-4">
      <label for="aj_all_employees" class="control-label"><?php echo $this->lang->line('kpi_select_employee_to_view');?> </label>
      <select name="all_employess" id="aj_all_employees" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('kpi_select_employee_to_view');?>">
        <?php foreach ($employees as $e) : ?>
        <option value=""></option>
        <option value="<?php echo $e->user_id; ?>" <?php echo ($e->user_id == $session['user_id'])?'selected':'';?>><?php echo $e->first_name; ?> <?php echo $e->last_name; ?> <?php echo ($e->user_id == $session['user_id'])?'(Me)':''; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <br>
</section>
<?php } ?>
<?php if ($user[0]->user_role_id != 1) { ?>
<input type="hidden" id="aj_all_employees" value="<?php echo $session['user_id'];?>">
<?php } ?>
<section id="decimal">
  <div class="box" style="border: .5px solid #ccc;">
    <div class="box-body collapse in">
      <div class="box-block card-dashboard">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="kpi_quarter_name"><?php echo $this->lang->line('kpi_select_quarter');?></label>
              <select name="kpi_quarter_name" id="kpi_quarter_name" class="form-control">
                <option value="All">All</option>
                <option value="1"><?php echo $this->lang->line('kpi_first_quarter');?></option>
                <option value="2"><?php echo $this->lang->line('kpi_second_quarter');?></option>
                <option value="3"><?php echo $this->lang->line('kpi_third_quarter');?></option>
                <option value="4"><?php echo $this->lang->line('kpi_fourth_quarter');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="kpi_year"><?php echo $this->lang->line('kpi_select_year');?></label>
              <select name="kpi_year" id="kpi_year" class="form-control" data-plugin="select_hrm">
                <?php for($i=2019;$i<=2030;$i++) : ?>
                <option value="<?php echo $i;?>" <?php echo (date('Y') == $i)?'selected':''; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="card-block nav-tabs-custom">
        <ul class="nav nav-tabs nav-top-border no-hover-bg">
          <li class="nav-item"> <a style="background-color: #bdd7ee" class="nav-link" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-bar-chart"></i> <?php echo $this->lang->line('xin_all');?> <?php echo $this->lang->line('kpi_main');?></a> </li>
          <li class="nav-item active"> <a style="background-color: #e2efda" class="nav-link active" id="baseIcon-tab12" data-toggle="tab" aria-controls="tabIcon12" href="#tabIcon12" aria-expanded="false"><i class="fa fa-line-chart"></i> <?php echo $this->lang->line('xin_all');?> <?php echo $this->lang->line('kpi_variable');?></a> </li>
          <li class="nav-item"> <a style="background-color: #fff2cc" class="nav-link" id="baseIcon-tab13" data-toggle="tab" aria-controls="tabIcon13" href="#tabIcon13" aria-expanded="false"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('xin_all');?> <?php echo $this->lang->line('kpi_incidental');?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="baseIcon-tab14" data-toggle="tab" aria-controls="tabIcon14" href="#tabIcon14" aria-expanded="false"><i class="fa fa-area-chart"></i> <?php echo $this->lang->line('kpi_statistics');?></a> </li>
          <li class="pull-right"><a href="<?php echo site_url('admin/performance_report');?>" class="text-muted"><i class="fa fa-bar-chart-o"></i> <?php echo $this->lang->line('kpi_report');?></a></li>
        </ul>
        <!-- Main goals tab -->
        <div class="tab-content pt-1 hrsale-kpi">
          <div class="tab-pane" id="tabIcon11" aria-labelledby="baseIcon-tab11" aria-expanded="false">
            <div class="box <?php echo $get_animate;?>" style="border: .5px solid #ccc;"> <!-- Add main goals form --->
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->lang->line('xin_performance_kpi_maingoals');?></h3>
                <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_maingoals_kpi" aria-expanded="false">
                  <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
                  </a> </div>
              </div>
              <div id="add_maingoals_kpi" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="box-block card-dashboard">
                    <div class="table-responsive" data-pattern="priority-columns">
                      <?php $attributes = array('name' => 'add_maingoals_kpi', 'id' => 'xin-form-maingoals', 'autocomplete' => 'off');?>
                      <?php $hidden = array('_user' => $session['user_id']);?>
                      <?php echo form_open('admin/performance_maingoals/add_maingoals_kpi', $attributes, $hidden);?>
                      <div class="form-group">
                        <label for="maingoals"><?php echo $this->lang->line('xin_enter_kpi_maingoals');?></label>
                        <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_enter_kpi_maingoals');?>" name="kpi_main_goals" cols="30" rows="2" id="maingoals"></textarea>
                      </div>
                      <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end add main goals form -->
            <div class="form-group <?php echo $get_animate;?>">
              <label for="main_goals_year"><?php echo $this->lang->line('kpi_select_year');?></label>
              <select name="main_goals_year" id="main_goals_year" class="form-control" data-plugin="select_hrm">
                <?php for($i=2019;$i<=2030;$i++) : ?>
                <option value="<?php echo $i;?>" <?php echo (date('Y') == $i)?'selected':''; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="box <?php echo $get_animate;?>" style="border: .5px solid #ccc;">
              <div class="box-header with-border">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_all');?> <?php echo $this->lang->line('kpi_main');?> </h3>
              </div>
              <div class="box-body collapse in">
                <div class="box-block card-dashboard">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_maingoals" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('kpi_main');?></th>
                          <th><?php echo $this->lang->line('kpi_q1');?></th>
                          <th><?php echo $this->lang->line('kpi_q2');?></th>
                          <th><?php echo $this->lang->line('kpi_q3');?></th>
                          <th><?php echo $this->lang->line('kpi_q4');?></th>
                          <th><?php echo $this->lang->line('kpi_status');?></th>
                          <th><?php echo $this->lang->line('kpi_feedback');?></th>
                          <th><?php echo $this->lang->line('kpi_created_date');?></th>
                          <th><?php echo $this->lang->line('kpi_updated_at');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Variable tab -->
          <div class="tab-pane active" id="tabIcon12" aria-labelledby="baseIcon-tab12" aria-expanded="false">
            <div class="box <?php echo $get_animate;?>" style="border: .5px solid #ccc;">
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->lang->line('xin_performance_kpi_variablekpi');?></h3>
                <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_variable_kpdi" aria-expanded="false">
                  <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
                  </a> </div>
              </div>
              <div id="add_variable_kpdi" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="box-block card-dashboard">
                    <div class="table-responsive" data-pattern="priority-columns">
                      <?php $attributes = array('name' => 'add_variable_kpi', 'id' => 'xin-form-variable', 'autocomplete' => 'off');?>
                      <?php $hidden = array('_user' => $session['user_id']);?>
                      <?php echo form_open('admin/performance_variable/add_variable_kpi', $attributes, $hidden);?>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="variable_quarter_name"><?php echo $this->lang->line('kpi_add_to');?></label>
                          <select name="variable_quarter_name" id="variable_quarter_name" class="form-control">
                            <option value="1" <?=($curQuarter==1)?'selected':''; ?>><?php echo $this->lang->line('kpi_first_quarter');?></option>
                            <option value="2" <?=($curQuarter==2)?'selected':''; ?>><?php echo $this->lang->line('kpi_second_quarter');?></option>
                            <option value="3" <?=($curQuarter==3)?'selected':''; ?>><?php echo $this->lang->line('kpi_third_quarter');?></option>
                            <option value="4" <?=($curQuarter==4)?'selected':''; ?>><?php echo $this->lang->line('kpi_fourth_quarter');?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="variable_year"><?php echo $this->lang->line('kpi_select_year');?></label>
                          <select name="variable_year" id="variable_year" class="form-control" data-plugin="select_hrm">
                            <?php for($i=2019;$i<=2030;$i++) : ?>
                            <option value="<?php echo $i;?>" <?php echo (date('Y') == $i)?'selected':''; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="variable_targeted_date"><?php echo $this->lang->line('kpi_targeted_date');?></label>
                          <input class="form-control date" id="variable_targeted_date" placeholder="<?php echo $this->lang->line('kpi_targeted_date');?>" name="variable_targeted_date" type="text">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="kpi_variable"><?php echo $this->lang->line('xin_enter_kpi_variable');?></label>
                          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_enter_kpi_variable');?>" name="kpi_variable" cols="30" rows="2" id="kpi_variable"></textarea>
                        </div>
                        <div class="form-group pull-right">
                          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box <?php echo $get_animate;?>" style="border: .5px solid #ccc;">
              <div class="box-header with-border">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_all');?> <?php echo $this->lang->line('kpi_variable');?> </h3>
              </div>
              <div class="box-body collapse in">
                <div class="box-block card-dashboard">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_variable" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('kpi_variable');?></th>
                          <th><?php echo $this->lang->line('kpi_targeted_date');?></th>
                          <th><?php echo $this->lang->line('kpi_result');?></th>
                          <th><?php echo $this->lang->line('kpi_status');?></th>
                          <th><?php echo $this->lang->line('kpi_feedback');?></th>
                          <th><?php echo $this->lang->line('kpi_created_date');?></th>
                          <th><?php echo $this->lang->line('kpi_updated_at');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Incidental tab -->
          <div class="tab-pane" id="tabIcon13" aria-labelledby="baseIcon-tab13" aria-expanded="false">
            <div class="box <?php echo $get_animate;?>" style="border: .5px solid #ccc;">
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->lang->line('xin_performance_kpi_incidental');?></h3>
                <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_incidental_kpi" aria-expanded="false">
                  <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
                  </a> </div>
              </div>
              <div id="add_incidental_kpi" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="box-block card-dashboard">
                    <div class="table-responsive" data-pattern="priority-columns">
                      <?php $attributes = array('name' => 'add_incidental_kpi', 'id' => 'xin-form-incidental', 'autocomplete' => 'off');?>
                      <?php $hidden = array('_user' => $session['user_id']);?>
                      <?php echo form_open('admin/performance_incidental/add_incidental_kpi', $attributes, $hidden);?>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="incidental_quarter_name"><?php echo $this->lang->line('kpi_add_to');?></label>
                          <select name="incidental_quarter_name" id="incidental_quarter_name" class="form-control">
                            <option value="1" <?=($curQuarter==1)?'selected':''; ?>><?php echo $this->lang->line('kpi_first_quarter');?></option>
                            <option value="2" <?=($curQuarter==2)?'selected':''; ?>><?php echo $this->lang->line('kpi_second_quarter');?></option>
                            <option value="3" <?=($curQuarter==3)?'selected':''; ?>><?php echo $this->lang->line('kpi_third_quarter');?></option>
                            <option value="4" <?=($curQuarter==4)?'selected':''; ?>><?php echo $this->lang->line('kpi_fourth_quarter');?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="incidental_year"><?php echo $this->lang->line('kpi_select_year');?></label>
                          <select name="incidental_year" id="incidental_year" class="form-control" data-plugin="select_hrm">
                            <?php for($i=2019;$i<=2030;$i++) : ?>
                            <option value="<?php echo $i;?>" <?php echo (date('Y') == $i)?'selected':''; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="incidental_targeted_date"><?php echo $this->lang->line('kpi_targeted_date');?></label>
                          <input class="form-control date" id="incidental_targeted_date" placeholder="<?php echo $this->lang->line('kpi_targeted_date');?>" name="incidental_targeted_date" type="text">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="kpi_incidental"><?php echo $this->lang->line('xin_enter_kpi_incidental');?></label>
                          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_enter_kpi_incidental');?>" name="kpi_incidental" cols="30" rows="2" id="kpi_incidental" required></textarea>
                        </div>
                        <div class="form-group pull-right">
                          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box <?php echo $get_animate;?>" style="border: .5px solid #ccc;">
              <div class="box-header with-border">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_all');?> <?php echo $this->lang->line('kpi_incidental');?> </h3>
              </div>
              <div class="box-body collapse in">
                <div class="box-block card-dashboard">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_incidental" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('kpi_incidental');?></th>
                          <th><?php echo $this->lang->line('kpi_targeted_date');?></th>
                          <th><?php echo $this->lang->line('kpi_result');?></th>
                          <th><?php echo $this->lang->line('kpi_status');?></th>
                          <th><?php echo $this->lang->line('kpi_feedback');?></th>
                          <th><?php echo $this->lang->line('kpi_created_date');?></th>
                          <th><?php echo $this->lang->line('kpi_updated_at');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Statistics tab -->
          <div class="tab-pane" id="tabIcon14" aria-labelledby="baseIcon-tab14" aria-expanded="false">
            <div class="box <?php echo $get_animate;?>" style="border: .5px solid #ccc;">
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->lang->line('kpi_statistics_variable');?></h3>
              </div>
              <div class="box-body collapse in">
                <div class="box-block card-dashboard">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_statistics_variable" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('kpi_statistics_title');?></th>
                          <th><?php echo $this->lang->line('kpi_statistics_value');?></th>
                        </tr>
                      </thead>
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
</section>
