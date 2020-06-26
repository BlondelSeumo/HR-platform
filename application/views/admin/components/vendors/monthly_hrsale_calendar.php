<?php
/* Define return | here result is used to return user data and error for error message */	
$someArray = array();
$someArrayEmp = array();
if($this->input->post('employee_id')==0){
	$xin_employees = $this->Xin_model->all_employees();
} else {
	$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
}

$month_year = $this->input->post('month_year');
if(isset($month_year)){
	$default_date = $month_year;
} else {
	$default_date = date("Y-m-d");
}

if(isset($month_year)){
	$date = strtotime($this->input->post('month_year').'-01');
	$imonth_year = explode('-',$this->input->post('month_year'));
	$day = date('d', $date);
	$month = date($imonth_year[1], $date);
	$year = date($imonth_year[0], $date);
	$month_year = $this->input->post('month_year');
} else {
	$date = strtotime(date("Y-m-d"));
	//$date = strtotime('2020-05-01');
	$day = date('d', $date);
	$month = date('m', $date);
	$year = date('Y', $date);
	$month_year = date('Y-m');
}
// total days in month
$daysInMonth =  date('t');

$imonth = date('F', $date);
?>
<script type="text/javascript">
$(function() {

  $('#calendar').fullCalendar({
    defaultView: 'timelineMonth',
    header: {
      right: 'timelineMonth'
    },
	defaultDate: moment('<?php echo $default_date;?>'),
    resourceColumns: [
        {
          labelText: 'Employee',
          field: 'title'
        },
        {
          labelText: 'Present',
          field: 'employee_present'
        }
      ],
    resources: <?php
	if($this->input->post('employee_id')==0){
			$xin_employees = $this->Xin_model->all_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
		
		foreach($xin_employees as $hr_user) { 
				
			$full_name = $hr_user->first_name.' '.$hr_user->last_name;	
			$designation = $this->Designation_model->read_designation_information($hr_user->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			// department
			$department = $this->Department_model->read_department_information($hr_user->department_id);
			if(!is_null($department)){
			$department_name = $department[0]->department_name;
			} else {
			$department_name = '--';
			}
			$user_info = $full_name;
			$pcount = 0;
			for($i = 1; $i <= $daysInMonth; $i++):
			$i = str_pad($i, 2, 0, STR_PAD_LEFT);
			// get date <
			$eattendance_date = $year.'-'.$month.'-'.$i;
			$check = $this->Timesheet_model->attendance_first_in_check($hr_user->user_id,$eattendance_date);
			if($check->num_rows() > 0) {
				$pcount += $check->num_rows();
			} else {
				$pcount += 0;
			}
			endfor;
			if($pcount == 0){
				$pcount = '0';
			}
			$someArrayEmp[] = array(
			  'id' => $hr_user->user_id,
			  'title'   => $user_info,
			  'employee_present' => $pcount
			  );
		}
		echo json_encode($someArrayEmp);
		?>,
		events: <?php
$j=0;foreach($xin_employees as $r) { 
	for($i = 1; $i <= $daysInMonth; $i++):
		$i = str_pad($i, 2, 0, STR_PAD_LEFT);
		// get date <
		$attendance_date = $year.'-'.$month.'-'.$i;
		$tdate = $year.'-'.$month.'-'.$i;
		$get_day = strtotime($attendance_date);
		$day = date('l', $get_day);
		$user_id = $r->user_id;
		// office shift
		$office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
		if(!is_null($office_shift)){
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
			$status = 'P';					
		} else {
			$status = 'A';
			//$pcount += 0;
		}
		//$pcount += $check->num_rows();
		// set to present date
		$iattendance_date = strtotime($attendance_date);
		$icurrent_date = strtotime(date('Y-m-d'));
		$status = $status;
		if($iattendance_date <= $icurrent_date){
			$status = $status;
		} else {
			$status = '0';
		}
		$idate_of_joining = strtotime($r->date_of_joining);
		if($idate_of_joining < $iattendance_date){
			$status = $status;
		} else {
			$status = '0';
		}
		} else {
			$status = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('xin_office_shift_not_assigned').'</a>';
			$attendance_date = '';
			$attendance_date = '';
		}
		$someArray[] = array(
			'title' => $status,
			'resourceIds' => $r->user_id,
			'start'   => $attendance_date,
			'end'   => $attendance_date,
		);
	  endfor;	
}
echo json_encode($someArray);
?>,
  });

});	
</script>
<style>
  #calendar {
    width: 100%;
	height: 100%;
  }

</style>