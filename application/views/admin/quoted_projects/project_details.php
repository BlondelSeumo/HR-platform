<?php
/* Project Details view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $u_created = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
$id = $this->uri->segment(4);
$result = $this->Quoted_project_model->read_project_information($id);
/*if(is_null($result)){
	redirect('admin/project');
}*/	
?>
<?php $assigned_ids = explode(',',$result[0]->assigned_to);?>
<?php
//status
if($result[0]->status == 0) {
	$nstatus = '<span class="label label-warning">'.$this->lang->line('xin_not_started').'</span>';
} else if($result[0]->status ==1){
	$nstatus = '<span class="label label-primary">'.$this->lang->line('xin_in_progress').'</span>';
} else if($result[0]->status ==2){
	$nstatus = '<span class="label label-success">'.$this->lang->line('xin_completed').'</span>';
} else if($result[0]->status ==3){
	$nstatus = '<span class="label label-danger">'.$this->lang->line('xin_project_cancelled').'</span>';
} else {
	$nstatus = '<span class="label label-danger">'.$this->lang->line('xin_project_hold').'</span>';
}
			
//priority
if($result[0]->priority == 1) {
	$epriority = '<span class="label label-danger">'.$this->lang->line('xin_highest').'</span>';
} else if($result[0]->priority ==2){
	$epriority = '<span class="label label-warning">'.$this->lang->line('xin_high').'</span>';
} else if($result[0]->priority ==3){
	$epriority = '<span class="label label-primary">'.$this->lang->line('xin_normal').'</span>';
} else {
	$epriority = '<span class="label label-success">'.$this->lang->line('xin_low').'</span>';
}
if($result[0]->project_progress <= 20) {
	$progress_class = 'progress-danger';
	$txt_class = 'text-danger';
} else if($result[0]->project_progress > 20 && $result[0]->project_progress <= 50){
	$progress_class = 'progress-warning';
	$txt_class = 'text-warning';
} else if($result[0]->project_progress > 50 && $result[0]->project_progress <= 75){
	$progress_class = 'progress-info';
	$txt_class = 'text-info';
} else {
	$progress_class = 'progress-success';
	$txt_class = 'text-success';
}
$project_id = $result[0]->project_id;
$projectTasks = $this->Quoted_project_model->completed_project_tasks($project_id);
$projectBugs = $this->Quoted_project_model->completed_project_bugs($project_id); 
?>
<?php // get company name by project id ?>
<?php $co_info  = $this->Quoted_project_model->read_project_information($project_id); ?>
<?php $eresult = $this->Department_model->ajax_company_employee_info($co_info[0]->company_id);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php if($this->session->flashdata('response')):?>
<div class="callout callout-success">
<p><?php echo $this->session->flashdata('response');?></p>
</div>
<?php endif;?>

<div class="row animated fadeInRight">
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-secondary mr-3">
                    <i class="fa fa-user"></i>
                </span>
                <div>
                    <h5 class="mb-1"><b><?php echo $this->lang->line('xin_project_client');?></b></h5>
                    <span> <?php echo $client_name?> </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-danger-4 mr-3">
                    <i class="fa fa-calendar"></i>
                </span>
                <div>
                    <h5 class="mb-1"><p><?php echo $this->lang->line('xin_quote_date');?></p></h5>
                    <span class="text-muted"><?php echo $this->Xin_model->set_date_format($estimate_date);?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-warning-4 mr-3">
                    <i class="fa fa-tasks"></i>
                </span>
                <div>
                    <h5 class="mb-1"><b><?php echo $project_no;?></b></h5>
                    <span><?php echo $this->lang->line('xin_quoted_project_no');?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card m-b-20">
      <div class="card-body">
        <div class="row m-t-20">
          <div class="col-md-2">
            <h5 class=""><?php echo $this->lang->line('dashboard_xin_status');?></h5>
            <p class="text-muted"><?php echo $nstatus;?></p>
          </div>
          <div class="col-md-2">
            <h5 class=""><?php echo $this->lang->line('xin_p_priority');?></h5>
            <p class="text-muted"><?php echo $epriority;?></p>
          </div>
          <div class="col-md-2">
            <h5 class=""><?php echo $this->lang->line('xin_estimate_hrs');?></h5>
            <p class="text-muted"><?php echo $estimate_hrs;?></p>
          </div>           
          <div class="col-md-4">
            <h5 class=""><?php echo $this->lang->line('xin_prjct_detail_overall_progress');?></h5>
            <p class="text-muted"><?php echo $progress;?>%<br />
            <div class="progress" style="height: 7px;">
              <div class="progress-bar" style="width: <?php echo $progress;?>%;"></div>
            </div>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<section id="basic-listgroup">
  <div class="row match-heights <?php echo $get_animate;?>">
    <div class="col-lg-2 col-md-2">
      <div class="card">
        <div class="card-blocks">
          <div class="list-group"> <a class="list-group-item list-group-item-action nav-tabs-link active" href="#overview" data-config="1" data-config-block="overview" data-toggle="tab" aria-expanded="true" id="pj_data_1"> <i class="fa fa-home"></i> <?php echo $this->lang->line('xin_overview');?></a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#assigned" data-config="2" data-config-block="assigned" data-toggle="tab" aria-expanded="true" id="pj_data_2"><i class="fa fa-users"></i> <?php echo $this->lang->line('xin_assigned_to');?></a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#progress" data-config="3" data-config-block="progress" data-toggle="tab" aria-expanded="true" id="pj_data_3"><i class="fa fa-leaf"></i> <?php echo $this->lang->line('dashboard_xin_progress');?></a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#timelogs" data-config="9" data-config-block="timelogs" data-toggle="tab" aria-expanded="true" id="pj_data_9"><i class="fa fa-clock-o"></i> <?php echo $this->lang->line('xin_project_timelogs');?></a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#files" data-config="7" data-config-block="files" data-toggle="tab" aria-expanded="true" id="pj_data_7"><i class="fa fa-book"></i> <?php echo $this->lang->line('xin_files');?></a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#discussion" data-config="4" data-config-block="discussion" data-toggle="tab" aria-expanded="true" id="pj_data_4"><i class="fa fa-weixin"></i> <?php echo $this->lang->line('xin_discussion');?></a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#note" data-config="8" data-config-block="note" data-toggle="tab" aria-expanded="true" id="pj_data_8"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('xin_note');?> </a> </div>
        </div>
      </div>
    </div>
    <div class="col-xl-10 col-lg-10  <?php echo $get_animate;?>">
      <div class="col current-tab <?php echo $get_animate;?>" id="overview"> 
        
        <!-- Description -->
        <div class="box mb-4">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_project_detail');?> </h3>
          </div>
          <div class="box-body"> <?php echo html_entity_decode($description);?> </div>
        </div>
        <!-- / Description --> 
      </div>
      <div class="col current-tab <?php echo $get_animate;?>" id="assigned"  aria-expanded="false" style="display:none;">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_assigned');?> <?php echo $this->lang->line('xin_users');?> </h3>
          </div>
          <div class="box-body">
            <div class="box-block">
              <div class="row">
                <div class="col-md-12">
                  <?php $attributes = array('name' => 'assign_project', 'id' => 'assign_project', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
                  <?php $hidden = array('_method' => 'EDIT');?>
                  <?php echo form_open('admin/quoted_projects/assign_project/', $attributes, $hidden);?>
                  <?php
						$data = array(
						  'name'        => 'project_id',
						  'id'          => 'project_id',
						  'type'        => 'hidden',
						  'value'  	   => $project_id,
						  'class'       => 'form-control',
						);
						echo form_input($data);
					?>
                  <?php $company_ids = explode(',',$company_id); ?>
                  <div class="form-group">
                    <label for="employees" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
                    <select class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee');?>" multiple="multiple">
                      <?php /*?><?php foreach($eresult as $e_employee) {?>
                      <option value="<?php echo $e_employee->user_id?>" <?php if(in_array($e_employee->user_id,$assigned_ids)){ ?> selected="selected"<?php } ?>> <?php echo $e_employee->first_name.' '.$e_employee->last_name;?></option>
                      <?php } ?><?php */?>
                      <?php foreach($company_ids as $cid) {?>
						<?php $ci_result = $this->Xin_model->get_company_employees_multi($cid); ?>
                        <?php foreach($ci_result as $re) {?>
                        <option value="<?php echo $re->user_id;?>" <?php if(isset($_GET)) { if(in_array($re->user_id,$assigned_ids)):?> selected <?php endif; }?>> <?php echo $re->first_name.' '.$re->last_name;?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col current-tab <?php echo $get_animate;?>" id="progress"  aria-expanded="false" style="display:none;">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('dashboard_xin_progress');?></h3>
          </div>
          <div class="box-body">
            <div class="box-block">
              <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
              <?php $hidden = array('_method' => 'EDIT');?>
              <?php echo form_open('admin/quoted_projects/update_status/', $attributes, $hidden);?>
              <?php
			$data1 = array(
			  'name'        => 'project_id',
			  'type'        => 'hidden',
			  'value'  	   => $project_id,
			  'class'       => 'form-control',
			);
			echo form_input($data1);
			?>
              <?php
			$data2 = array(
			  'name'        => 'progres_val',
			  'id'          => 'progres_val',
			  'type'        => 'hidden',
			  'value'  	   => $result[0]->project_progress,
			  'class'       => 'form-control',
			);
			echo form_input($data2);
			?>
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="progress"><?php echo $this->lang->line('dashboard_xin_progress');?></label>
                        <input type="text" id="range_grid">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="Status">
                          <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_not_started');?></option>
                          <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_in_progress');?></option>
                          <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_completed');?></option>
                          <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_project_cancelled');?></option>
                          <option value="4" <?php if($status=='4'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_project_hold');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="status"><?php echo $this->lang->line('xin_p_priority');?></label>
                        <select class="form-control" name="priority" data-plugin="select_hrm" data-placeholder="Priority">
                          <option value="1" <?php if($priority=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_highest');?></option>
                          <option value="2" <?php if($priority=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_high');?></option>
                          <option value="3" <?php if($priority=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_normal');?></option>
                          <option value="4" <?php if($priority=='4'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_low');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-actions  box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
      </div>
      <div class="col current-tab <?php echo $get_animate;?>" id="discussion"  aria-expanded="false" style="display:none;">
        <div class="box md-4">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_discussion');?> </h3>
          </div>
          <div class="box-body">
            <?php $attributes = array('name' => 'set_discussion', 'id' => 'set_discussion', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
            <?php $hidden = array('_method' => 'EDIT');?>
            <?php echo form_open_multipart('admin/quoted_projects/set_discussion/', $attributes, $hidden);?>
            <?php
			$data3 = array(
			  'name'        => 'user_id',
			  'type'        => 'hidden',
			  'value'  	   => $session['user_id'],
			  'class'       => 'form-control',
			);
			echo form_input($data3);
		?>
            <?php
			$data4 = array(
			  'name'        => 'discussion_project_id',
			  'id'          => 'discussion_project_id',
			  'type'        => 'hidden',
			  'value'  	   => $project_id,
			  'class'       => 'form-control',
			);
			echo form_input($data4);
		?>
            <div class="box-block">
              <div class="form-group">
                <textarea name="xin_message" id="xin_message" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('xin_message');?>"></textarea>
              </div>
              <div class="form-group">
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_attachment');?></label>
                  <input type="file" class="form-control-file" id="attachment_discussion" name="attachment_discussion">
                </fieldset>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
        <div class="box mt-4">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_discussion');?> </h3>
          </div>
          <div class="box-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_discussion_table" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_all_discussions');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col current-tab <?php echo $get_animate;?>" id="timelogs"  aria-expanded="false" style="display:none;">
        <div class="box md-4">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_project_timelogs');?></h3>
            <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_timelogs_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
          </div>
          <div id="add_timelogs_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
          <div class="box-body">
            <?php $attributes = array('name' => 'add_timelog', 'id' => 'add_timelog', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
            <?php $hidden = array('_method' => 'ADD');?>
            <?php echo form_open('admin/quoted_projects/add_project_timelog/', $attributes, $hidden);?>
            <?php
			$data7 = array(
			  'name'        => 'user_id',
			  'type'        => 'hidden',
			  'value'  	   => $session['user_id'],
			  'class'       => 'form-control',
			);
			echo form_input($data7);
		?>
            <?php
			$data8 = array(
			  'name'        => 'type',
			  'type'        => 'hidden',
			  'value'  	   => 1,
			  'class'       => 'form-control',
			);
			echo form_input($data8);
		?>
            <div class="box-block">
              <div class="row">
              <?php $colmd = '2';?>
              <?php if($u_created[0]->user_role_id == '1'){?>
              <?php $colmd = '2'; $user_date = 'timelog_date';?>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="employees" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
                    <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee');?>">
                      <?php foreach($eresult as $e_employee) {?>
                      <?php if(in_array($e_employee->user_id,$assigned_ids)){ ?>
                      <option value="<?php echo $e_employee->user_id?>"> <?php echo $e_employee->first_name.' '.$e_employee->last_name;?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                    
                  </div>
                </div>  
                <?php } else {?>
                <?php $colmd = '3'; $user_date = 'user_timelog_date';?>
                <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $session['user_id'];?>" />
                <?php } ?>
                <input type="hidden" name="project_id" id="tproject_id" value="<?php echo $project_id;?>" />
                <input type="hidden" name="company_id" id="company_id" value="<?php echo $co_info[0]->company_id;?>" />
                <div class="col-md-<?php echo $colmd;?>">
                  <div class="form-group">
                    <label for="start_time"><?php echo $this->lang->line('xin_project_timelogs_starttime');?></label>
                    <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_project_timelogs_starttime');?>" readonly name="start_time" id="start_time" type="text" value="">
                  </div>
                </div>
                <div class="col-md-<?php echo $colmd;?>">
                  <div class="form-group">
                    <label for="end_time"><?php echo $this->lang->line('xin_project_timelogs_endtime');?></label>
                    <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_project_timelogs_endtime');?>" readonly name="end_time" id="end_time" type="text" value="">
                  </div>
                </div>
                <div class="col-md-<?php echo $colmd;?>">
                  <div class="form-group">
                    <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                    <input class="form-control <?php echo $user_date;?>" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" id="start_date" value="">
                  </div>
                </div>
                <div class="col-md-<?php echo $colmd;?>">
                  <div class="form-group">
                    <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                    <input class="form-control <?php echo $user_date;?>" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" id="end_date" value="">
                  </div>
                </div>                
              </div>
              <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" name="total_hours" id="total_hours" value="0" />
                    <label for="timelogs_memo"><?php echo $this->lang->line('xin_project_timelogs_memo');?> 
                     <span id="total_time">&nbsp;</span></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_timelogs_memo');?>" name="timelogs_memo" type="text" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div></div>
        </div>
        <div class="box mt-4 <?php echo $get_animate;?>">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_project_timelogs');?> </h3>
          </div>
          <div class="box-body">
            <div class="box-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_timelogs_table" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_employee');?></th>
                    <th><?php echo $this->lang->line('xin_start_date');?></th>
                    <th><?php echo $this->lang->line('xin_end_date');?></th>
                    <th><?php echo $this->lang->line('xin_overtime_thours');?></th>
                    <th><?php echo $this->lang->line('xin_project_timelogs_memo');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col current-tab <?php echo $get_animate;?>" id="files"  aria-expanded="false" style="display:none;">
        <div class="box mb-4">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_files');?></h3>
          </div>
          <div class="box-body">
            <?php $attributes = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
            <?php $hidden = array('_method' => 'ADD');?>
            <?php echo form_open_multipart('admin/quoted_projects/add_attachment/', $attributes, $hidden);?>
            <?php
			$data9 = array(
			  'name'        => 'user_id',
			  'id'          => 'user_id',
			  'type'        => 'hidden',
			  'value'  	   => $session['user_id'],
			  'class'       => 'form-control',
			);
			echo form_input($data9);
		?>
            <?php
			$data10 = array(
			  'name'        => 'project_id',
			  'id'          => 'f_project_id',
			  'type'        => 'hidden',
			  'value'  	   => $project_id,
			  'class'       => 'form-control',
			);
			echo form_input($data10);
		?>
            <?php
			$data11 = array(
			  'name'        => 'type',
			  'type'        => 'hidden',
			  'value'  	   => 1,
			  'class'       => 'form-control',
			);
			echo form_input($data11);
		?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="task_name"><?php echo $this->lang->line('dashboard_xin_title');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="file_name" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class='form-group'>
                      <fieldset class="form-group">
                        <label for="logo"><?php echo $this->lang->line('xin_attachment_file');?></label>
                        <input type="file" class="form-control-file" id="attachment_file" name="attachment_file">
                        <small><?php echo $this->lang->line('xin_project_files_upload');?></small>
                      </fieldset>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                      <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="file_description" rows="4" id="file_description"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
        <div class="box <?php echo $get_animate;?>">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_attachment_list');?></h3>
          </div>
          <div class="box-body">
            <div class="box-datatable table-responsive">
              <table class="table table-hover table-striped table-bordered table-ajax-load" id="xin_attachment_table" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_option');?></th>
                    <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                    <th><?php echo $this->lang->line('xin_description');?></th>
                    <th><?php echo $this->lang->line('xin_date_and_time');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col current-tab <?php echo $get_animate;?>" id="note"  aria-expanded="false" style="display:none;">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_note');?></h3>
          </div>
          <div class="box-body">
            <div class="box-block">
              <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
              <?php $hidden = array('_method' => 'UPDATE', '_uid' => $session['user_id']);?>
              <?php echo form_open_multipart('admin/quoted_projects/add_note/', $attributes, $hidden);?>
              <?php
				$data12 = array(
				  'name'        => 'note_project_id',
				  'id'          => 'note_project_id',
				  'type'        => 'hidden',
				  'value'  	   => $project_id,
				  'class'       => 'form-control',
				);
				echo form_input($data12);
			?>
              <div class="box-block">
                <div class="form-group">
                  <textarea name="project_note" id="project_note" class="form-control" rows="5" placeholder="<?php echo $this->lang->line('xin_project_note');?>"><?php echo $project_note;?></textarea>
                </div>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<style type="text/css">
.trumbowyg-box, .trumbowyg-editor { min-height: 105px; }
</style>
