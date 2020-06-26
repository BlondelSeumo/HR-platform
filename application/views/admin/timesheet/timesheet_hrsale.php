<?php
/* Timesheet view > hrsale
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
$month_year = $this->input->post('month_year');
if($user_info[0]->user_role_id==1){
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$xin_employees = $this->Timesheet_model->get_xin_employees();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('employee_id')==0){
			$xin_employees = $this->Timesheet_model->get_xin_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
	}
} else if(in_array('10',$role_resources_ids)) {
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$xin_employees = $this->Timesheet_model->get_xin_employees();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('employee_id')==0){
			$xin_employees = $this->Timesheet_model->get_xin_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
	}
} else {
	$date = strtotime(date("Y-m-d"));
	/* Set the date */
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$month_year = date('Y-m');
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		$month_year = $month_year;
	}
	$xin_employees = $this->Xin_model->read_user_info($session['user_id']);
}
// total days in month
$daysInMonth =  date('t');
$imonth = date('F', $date);
?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active">
      <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-md-speedometer"></span>
        <?php echo $this->lang->line('dashboard_title');?>
        <div class="text-muted small">Set up shortcuts</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/attendance/');?>" data-link-data="<?php echo site_url('admin/timesheet/attendance/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-md-clock"></span>
        <?php echo $this->lang->line('left_attendance');?>
        <div class="text-muted small">Add effects</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/update_attendance');?>" data-link-data="<?php echo site_url('admin/timesheet/update_attendance');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fas fa-pencil-alt"></span>
        <?php echo $this->lang->line('left_update_attendance');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fas fa-calendar-alt"></span>
        <?php echo $this->lang->line('xin_month_timesheet_title');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-md-calendar"></span>
        <?php echo $this->lang->line('xin_acc_calendar');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/overtime_request/');?>" data-link-data="<?php echo site_url('admin/overtime_request/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-md-timer"></span>
        <?php echo $this->lang->line('xin_overtime_request');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
  </ul>
</div>  
  <hr class="border-light m-0">
  <div class="row mt-3">
        <div class="col-md-6">
        <div class="card mb-4">
          <h6 class="card-header with-elements border-0 pr-0 pb-0">
            <div class="card-header-title">Attendance Status</div>
          </h6>
          <div class="row">
          <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    
                    <tr>
                      <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                      <td><?php echo $this->lang->line('xin_absent');?></td>
                    </tr>
                    <tr>
                      <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                      <td><?php echo $this->lang->line('xin_emp_working');?></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
            </div>    
          <div class="col-md-5">
            <div style="height:120px;">
              <canvas id="attendance_status"  style="display: block; height: 150px; width:300px;"></canvas>
            </div>
          </div>
          </div>
        </div>
    
      </div>
      
      <div class="col-md-6">
    
        <div class="card mb-4">
          <h6 class="card-header with-elements border-0 pr-0 pb-0">
            <div class="card-header-title">Overtime Request Status</div>
          </h6>
          <div class="row">
          <div class="col-md-6">
                <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
                  <div class="table-responsive">
                    <table class="table mb-0 table-dashboard">
                      <tbody>
                        <tr>
                          <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                          <td><?php echo $this->lang->line('xin_approved');?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #FFD950;"></div></td>
                          <td><?php echo $this->lang->line('xin_pending');?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                          <td><?php echo $this->lang->line('xin_rejected');?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
            <div style="height:120px;">
              <canvas id="hrsale_overtime_request" style="display: block; height: 150px; width:300px;"></canvas>
            </div>
          </div>
          </div>
        </div>

  </div>
</div>
  <div class="mb-3 sw-container tab-content">
    
    <div id="smartwizard-2-step-3" class="animated fadeIn tab-pane step-content mt-3">
    	<div class="ui-bordered px-4 pt-4 mb-4">
        <?php $attributes = array('name' => 'update_attendance_report', 'id' => 'update_attendance_report', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/timesheet/update_attendance', $attributes, $hidden);?>
            <?php
				$data = array(
				  'name'        => 'emp_id',
				  'id'          => 'emp_id',
				  'value'       => $session['user_id'],
				  'type'   		=> 'hidden',
				  'class'       => 'form-control',
				);
			
				echo form_input($data);
				?>
              <div class="form-row">
                <div class="col-md mb-4">
                  <label class="form-label"><?php echo $this->lang->line('xin_e_details_date');?></label>
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly id="mn_attendance_date" name="mn_attendance_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
                <div class="col-md mb-4">
                <?php if($user_info[0]->user_role_id==1){ ?>
                  <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control custom-select" name="company_id" id="up_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                  <?php } else if(in_array('310',$role_resources_ids)) {?>
                <?php $ecompany_id = $user_info[0]->company_id;?>
                <select class="form-control custom-select" name="company_id" id="up_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <?php if($ecompany_id == $company->company_id):?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                <?php } ?>
                </div>
                <?php if($user_info[0]->user_role_id==1 || in_array('310',$role_resources_ids)){ ?>
                <div class="col-md mb-4" id="up_employee_ajax">
                  <label class="form-label"><?php echo $this->lang->line('xin_employee');?></label>
                  <select disabled="disabled" name="employee_id" id="up_employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                  </select>
                </div>
                <?php } else {?>
                <input type="hidden" name="employee_id" id="up_employee_id" value="<?php echo $session['user_id'];?>" />
                <?php }?>
                <div class="col-md col-xl-2 mb-4">
                  <label class="form-label d-none d-md-block">&nbsp;</label>
                  <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
        <div class="card mb-4">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('left_update_attendance');?></strong></span>
              <?php if(in_array('277',$role_resources_ids)) {?>
              <div class="card-header-elements ml-md-auto" id="add_attendance_btn" style="display:none;">
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
               </div>
              <?php } ?>  
            </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_update_attendance_table">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_in_time');?></th>
                    <th><?php echo $this->lang->line('xin_out_time');?></th>
                    <th><?php echo $this->lang->line('dashboard_total_work');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
    </div>
    <div id="smartwizard-2-step-4" class="animated fadeIn tab-pane step-content mt-3" <?php echo $mnfact;?>>
      <div class="ui-bordered px-4 pt-4 mb-4">
			<?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('_user' => $session['user_id']);?>
            <?php echo form_open('admin/timesheet/', $attributes, $hidden);?>
              <div class="form-row">
                <div class="col-md mb-4">
                  <label class="form-label"><?php echo $this->lang->line('xin_e_details_date');?></label>
                  <input class="form-control d_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
                </div>
                <?php if($user_info[0]->user_role_id==1){?>
                <div class="col-md mb-4">
                  <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company_mn" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" 
					<?php if(isset($employee_id)): if($company->company_id==$company_id): ?> selected="selected" <?php endif; endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
                </div>
                <div class="col-md mb-3" id="mn_employee_ajax">
                  <label class="form-label"><?php echo $this->lang->line('xin_employee');?></label>
                  <select name="employee_id" id="m_employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
					<?php if(isset($employee_id)): ?>
                    <?php $result = $this->Department_model->ajax_company_employee_info($company_id); ?>
                    <option value="0">All</option>
                    <?php foreach($result as $employee) {?>
                    <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id): ?> selected="selected" <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                    <?php } ?>
                    <?php endif;?>
                  </select>
                </div>
                <?php } ?>
                <div class="col-md col-xl-2 mb-4">
                  <label class="form-label d-none d-md-block">&nbsp;</label>
                  <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
                </div>
                
              </div>
              <?php echo form_close(); ?>
            </div>
            <div class="card <?php echo $get_animate;?>">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_employees_monthly_timesheet');?></strong> <?php echo $this->lang->line('xin_for_the_month_of');?> <?php if(isset($month_year)): echo date('F Y', strtotime($month_year)); else: echo date('F Y'); endif;?></span>
              <div class="card-header-elements ml-md-auto">
                A: Absent, P: Present, H: Holiday, L: Leave </div>
            </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_monthly_timsheet_table">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_employee');?></th>
                    <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
                    <?php $i = str_pad($i, 2, 0, STR_PAD_LEFT); ?>
                    <?php
                    $tdate = $year.'-'.$month.'-'.$i;
                    //Convert the date string into a unix timestamp.
                    $unixTimestamp = strtotime($tdate);
                    //Get the day of the week
                    $dayOfWeek = date("D", $unixTimestamp);
                    ?>
                    <th><strong><?php echo '<div>'.$i.' </div><span style="text-decoration:underline;">'.$dayOfWeek.'</span>';?></strong></th>
                    <?php endfor; ?>
                    <th width="100px"><?php echo $this->lang->line('xin_timesheet_workdays');?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $j=0;foreach($xin_employees as $r):?>
                  <?php
                    // user full name 
                    $full_name = $r->first_name.' '.$r->last_name;
                    // get designation
                    $designation = $this->Designation_model->read_designation_information($r->designation_id);
                    if(!is_null($designation)){
                        $designation_name = $designation[0]->designation_name;
                    } else {
                        $designation_name = '--';	
                    }
                    // department
                    $department = $this->Department_model->read_department_information($r->department_id);
                    if(!is_null($department)){
                    $department_name = $department[0]->department_name;
                    } else {
                    $department_name = '--';	
                    }
                    $department_designation = $designation_name.' ('.$department_name.')';$pcount=0;
                    ?>
                  <?php $employee_name = $full_name.'<br><small class="text-muted"><i>'.$department_designation.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_employees_id').': '.$r->employee_id.'<i></i></i></small>';?>
                  <tr>
                    <td style="width:200px;"><?php echo $employee_name;?></td>
                    <?php
                    for($i = 1; $i <= $daysInMonth; $i++):
                    $i = str_pad($i, 2, 0, STR_PAD_LEFT);
                    // get date <
                    $attendance_date = $year.'-'.$month.'-'.$i;
                    $get_day = strtotime($attendance_date);
                    $day = date('l', $get_day);
                    $user_id = $r->user_id;
                    // office shift
                    $office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
                    // get holiday
                    $h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
                    $holiday_arr = array();
                    if($h_date_chck->num_rows() == 1){
                        $h_date = $this->Timesheet_model->holiday_date($attendance_date);
                        $begin = new DateTime( $h_date[0]->start_date );
                        $end = new DateTime( $h_date[0]->end_date);
                        $end = $end->modify( '+1 day' ); 
                        
                        $interval = new DateInterval('P1D');
                        $daterange = new DatePeriod($begin, $interval ,$end);
                        
                        foreach($daterange as $date){
                            $holiday_arr[] =  $date->format("Y-m-d");
                        }
                    } else {
                        $holiday_arr[] = '99-99-99';
                    }
                    //echo '<pre>'; print_r($holiday_arr);
                    // get leave/employee
                    $leave_date_chck = $this->Timesheet_model->leave_date_check($r->user_id,$attendance_date);
                    $leave_arr = array();
                    if($leave_date_chck->num_rows() == 1){
                        $leave_date = $this->Timesheet_model->leave_date($r->user_id,$attendance_date);
                        $begin1 = new DateTime( $leave_date[0]->from_date );
                        $end1 = new DateTime( $leave_date[0]->to_date);
                        $end1 = $end1->modify( '+1 day' ); 
                        
                        $interval1 = new DateInterval('P1D');
                        $daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
                        
                        foreach($daterange1 as $date1){
                            $leave_arr[] =  $date1->format("Y-m-d");
                        }	
                    } else {
                        $leave_arr[] = '99-99-99';
                    }
                    $attendance_status = '';
                    $check = $this->Timesheet_model->attendance_first_in_check($r->user_id,$attendance_date);
                    if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
                        $status = 'H';	
                    } else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
                        $status = 'H';
                    } else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
                        $status = 'H';
                    } else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
                        $status = 'H';
                    } else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
                        $status = 'H';
                    } else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
                        $status = 'H';
                    } else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
                        $status = 'H';
                    } else if(in_array($attendance_date,$holiday_arr)) { // holiday
                        $status = 'H';
                    } else if(in_array($attendance_date,$leave_arr)) { // on leave
                        $status = 'L';
                    } else if($check->num_rows() > 0){
                    $attendance = $this->Timesheet_model->attendance_first_in($r->user_id,$attendance_date);
                    $status = 'P';//$attendance[0]->attendance_status;
                        
                    } else {
                        
                         
                        $status = 'A';
                        //$pcount += 0;
                    }
                    $pcount += $check->num_rows();
                    // set to present date
                    $iattendance_date = strtotime($attendance_date);
                    $icurrent_date = strtotime(date('Y-m-d'));
                    if($iattendance_date <= $icurrent_date){
                        $status = $status;
                    } else {
                        $status = '';
                    }
                    $idate_of_joining = strtotime($r->date_of_joining);
                    if($idate_of_joining < $iattendance_date){
                        $status = $status;
                    } else {
                        $status = '';
                    }
                    
                    ?>
                    <td><?php echo $status; ?></td>
                    <?php endfor; ?>
                    <td><?php echo $pcount;?></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
    <div id="smartwizard-2-step-5" class="animated fadeIn tab-pane step-content mt-3">
      <?php
		$session = $this->session->userdata('username');
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
		if(!is_null($role_user)){
			$role_resources_ids = explode(',',$role_user[0]->role_resources);
		} else {
			$role_resources_ids = explode(',',0);	
		}
		$iuser = $this->Xin_model->read_user_info($session['user_id']);
		$system = $this->Xin_model->read_setting_info(1);
		$get_animate = $this->Xin_model->get_content_animate();
		$month_year = $this->input->post('month_year');
		if($user_info[0]->user_role_id==1){
			
			$employee_id = $this->input->post('employee_id');
			$company_id = $this->input->post('company_id');
			/* Set the date */
			//if(isset($company_id)){
			$date = strtotime(date("Y-m-d"));
			/* Set the date */
			if(!isset($month_year)){
				$day = date('d', $date);
				$month = date('m', $date);
				$year = date('Y', $date);
			} else {
				$imonth_year = explode('-',$month_year);
				$day = date('d', $date);
				$month = date($imonth_year[1], $date);
				$year = date($imonth_year[0], $date);
			}
			
			if($employee_id == ''){
				$r = $this->Xin_model->read_user_info($session['user_id']);
			} else {
				$r = $this->Xin_model->read_user_info($employee_id);
			}
		} else {
			$date = strtotime(date("Y-m-d"));
			/* Set the date */
			if(!isset($month_year)){
				$day = date('d', $date);
				$month = date('m', $date);
				$year = date('Y', $date);
				$month_year = date('Y-m');
			} else {
				$imonth_year = explode('-',$month_year);
				$day = date('d', $date);
				$month = date($imonth_year[1], $date);
				$year = date($imonth_year[0], $date);
				$month_year = $month_year;
			}
			$r = $this->Xin_model->read_user_info($session['user_id']);
		}
		?>
		<?php
		// get designation
		$designation = $this->Designation_model->read_designation_information($r[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		// department
		$department = $this->Department_model->read_department_information($r[0]->department_id);
		if(!is_null($department)){
		$department_name = $department[0]->department_name;
		} else {
		$department_name = '--';	
		}
		// get company
		$company = $this->Xin_model->read_company_info($r[0]->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		// total days in month
		$daysInMonth =  date('t');
		$imonth = date('F', $date);
		$pcount = 0;
		$acount = 0;
		$lcount = 0;
		for($i = 1; $i <= $daysInMonth; $i++):
			$i = str_pad($i, 2, 0, STR_PAD_LEFT);
			// get date <
			$attendance_date = $year.'-'.$month.'-'.$i;
			$get_day = strtotime($attendance_date);
			$day = date('l', $get_day);
			$user_id = $r[0]->user_id;
			$office_shift_id = $r[0]->office_shift_id;
			$attendance_status = '';
			// get holiday
			$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
			$holiday_arr = array();
			if($h_date_chck->num_rows() == 1){
				$h_date = $this->Timesheet_model->holiday_date($attendance_date);
				$begin = new DateTime( $h_date[0]->start_date );
				$end = new DateTime( $h_date[0]->end_date);
				$end = $end->modify( '+1 day' ); 
				
				$interval = new DateInterval('P1D');
				$daterange = new DatePeriod($begin, $interval ,$end);
				
				foreach($daterange as $date){
					$holiday_arr[] =  $date->format("Y-m-d");
				}
			} else {
				$holiday_arr[] = '99-99-99';
			}
			// get leave/employee
			$leave_date_chck = $this->Timesheet_model->leave_date_check($user_id,$attendance_date);
			$leave_arr = array();
			if($leave_date_chck->num_rows() == 1){
				$leave_date = $this->Timesheet_model->leave_date($user_id,$attendance_date);
				$begin1 = new DateTime( $leave_date[0]->from_date );
				$end1 = new DateTime( $leave_date[0]->to_date);
				$end1 = $end1->modify( '+1 day' ); 
				
				$interval1 = new DateInterval('P1D');
				$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
				
				foreach($daterange1 as $date1){
					$leave_arr[] =  $date1->format("Y-m-d");
				}	
			} else {
				$leave_arr[] = '99-99-99';
			}
			$office_shift = $this->Timesheet_model->read_office_shift_information($office_shift_id);
			$check = $this->Timesheet_model->attendance_first_in_check($user_id,$attendance_date);
			// get holiday>events
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = 'H';	
				$pcount += 0;
				//$acount += 0;
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = 'H';
				$pcount += 0;
				//$acount += 0;
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = 'H';
				$pcount += 0;
				//$acount += 0;
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = 'H';
				$pcount += 0;
				//$acount += 0;
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = 'H';
				$pcount += 0;
				//$acount += 0;
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = 'H';
				$pcount += 0;
				//$acount -= 1;
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = 'H';
				$pcount += 0;
				//$acount -= 1;
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = 'H';
				$pcount += 0;
				//$acount += 0;
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = 'L';
				$pcount += 0;
				$lcount += 1;
			//	$acount += 0;
			} else if($check->num_rows() > 0){
				$pcount += 1;
				//$acount -= 1;
			}	else {
				$status = 'A';
				//$acount += 1;
				$pcount += 0;
				// set to present date
				$iattendance_date = strtotime($attendance_date);
				$icurrent_date = strtotime(date('Y-m-d'));
				if($iattendance_date <= $icurrent_date){
					$acount += 1;
				} else {
					$acount += 0;
				}
			}
		endfor;
		//}
		?>
        <div class="ui-bordered px-4 pt-4 mb-4">
        <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/timecalendar/', $attributes, $hidden);?>
          <div class="form-row">
            <div class="col-md mb-4">
              <label class="form-label"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control d_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
            </div>
            <?php if($user_info[0]->user_role_id==1){?>
            
            <div class="col-md mb-4">
              <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control custom-select" name="company_id" id="cal_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" 
					<?php if(isset($employee_id)): if($company->company_id==$r[0]->company_id): ?> selected="selected" <?php endif; endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md mb-4" id="employee_cal_ajx">
              <label class="form-label"><?php echo $this->lang->line('xin_employee');?></label>
              <select name="employee_id" id="cal_employee_id" class="form-control employee-data  custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                <?php if(isset($employee_id)): ?>
                <?php $result = $this->Department_model->ajax_company_employee_info($company_id); ?>
                <option value=""></option>
                <?php foreach($result as $employee) {?>
                <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id): ?> selected="selected" <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
                <?php endif;?>
              </select>
            </div>
            <?php } ?>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
		<?php if(isset($company_id) || $user_info[0]->user_role_id!=1){?>
		<div class="row <?php echo $get_animate;?>">
		  <div class="col-md-4">
			<div class="card">
			  <div class="box-header with-border">
				<h3 class="box-title"> <?php echo $r[0]->first_name.' '.$r[0]->last_name;?> - <?php echo date('F Y',strtotime($month_year));?></h3>
			  </div>
			  <div class="card-body">
				<div class="table-responsive" data-pattern="priority-columns">
				  <table class="table table-striped m-md-b-0">
					<tbody>
					  <tr>
						<th scope="row"><?php echo $this->lang->line('left_company');?></th>
						<td class="text-right"><?php echo $comp_name;?></td>
					  </tr>
					  <tr>
						<th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_department');?></th>
						<td class="text-right"><?php echo $department_name;?></td>
					  </tr>
					  <tr>
						<th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_designation');?></th>
						<td class="text-right"><?php echo $designation_name;?></td>
					  </tr>
					  <tr>
						<th scope="row"><?php echo $this->lang->line('dashboard_employee_id');?></th>
						<td class="text-right"><?php echo $r[0]->employee_id;?></td>
					  </tr>
					  <tr>
						<th scope="row"><?php echo $this->lang->line('xin_attendance_total_present');?></th>
						<td class="text-right"><?php echo $pcount;?></td>
					  </tr>
					  <tr>
						<th scope="row"><?php echo $this->lang->line('xin_attendance_total_absent');?></th>
						<td class="text-right"><?php echo $acount;?></td>
					  </tr>
					  <tr>
						<th scope="row"><?php echo $this->lang->line('xin_attendance_total_leave');?></th>
						<td class="text-right"><?php echo $lcount;?></td>
					  </tr>
					</tbody>
				  </table>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-md-8">
			<div class="box">
			  <div class="box-body">
				<div id='calendar_hr'></div>
			  </div>
			</div>
		  </div>
		</div>
        <?php } ?>
    </div>
    <div id="smartwizard-2-step-6" class="animated fadeIn tab-pane step-content mt-3">
      <div class="card m-b-1 <?php echo $get_animate;?>">
          <div class="col-md-12">
            <div class="box mb-4">
              
              <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_overtime_request');?></strong></span>
              <div class="card-header-elements ml-md-auto">
                <button type="button" class="btn btn-xs btn-primary" id="add_attendance_btn" data-toggle="modal" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
              </div>
            </div>
              <div class="card-body">
                <div class="box-datatable table-responsive">
                  <table class="datatables-demo table table-striped table-bordered" id="xin_table">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('xin_action');?></th>
                        <th><?php echo $this->lang->line('xin_employee');?></th>
                        <th><?php echo $this->lang->line('xin_project_no');?></th>
                        <th><?php echo $this->lang->line('xin_phase_no');?></th>
                        <th><?php echo $this->lang->line('xin_e_details_date');?></th>
                        <th><?php echo $this->lang->line('xin_in_time');?></th>
                        <th><?php echo $this->lang->line('xin_out_time');?></th>
                        <th><?php echo $this->lang->line('xin_overtime_thours');?></th>
                        <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
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

