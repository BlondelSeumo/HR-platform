<?php
/* Attendance Calendar view > hrsale
*/
?>
<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$user_info = $this->Xin_model->read_user_info($session['user_id']);
// get month&year > employee > company
$month_year = $this->input->post('month_year');
$employee_id = $this->input->post('employee_id');
$company_id = $this->input->post('company_id');
if($user_info[0]->user_role_id==1){
	$month_year = $this->input->post('month_year');
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	//if(isset($company_id)){
	if(isset($company_id)){
		$date = strtotime(date("Y-m-d"));
		
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($employee_id == ''){
			$r = $this->Xin_model->read_user_info($session['user_id']);
		} else {
			$r = $this->Xin_model->read_user_info($employee_id);
		}
		$fdate = $month_year;
	} else {
		$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$fdate = strtotime(date("Y-m-d"));
	}
	//$fdate = strtotime(date("Y-m"));
} else {
	if(isset($month_year)){
		$date = strtotime(date("Y-m-d"));
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		$r = $this->Xin_model->read_user_info($session['user_id']);
		$fdate = $month_year;
	} else {
		$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$fdate = date("Y-m-d");
		$month_year = date("Y-m");
		$r = $this->Xin_model->read_user_info($session['user_id']);
	}
}
// total days in month
$daysInMonth =  date('t');
?>
<script type="text/javascript">
var newEvent;
var editEvent;

$(document).ready(function() {
    
   var calendar = $('#calendar_hr').fullCalendar({
       
       eventRender: function(event, element, view) {
         var displayEventDate;    
         if(event.etitle == 'Present'){
          element.popover({
			  
            title:    '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
            content:  '<div class="popoverInfoCalendar">' +
                      '<p><strong>Clock In:</strong> ' + event.clock_in + '</p>' +
                      '<p><strong>Clock Out:</strong> ' + event.clock_out + '</p>' +
                      '<p><strong>Total Work:</strong> ' + event.total_work + '</p>' +
                      '</div>',
            delay: { 
               show: "400", 
               hide: "50"
            },
            trigger: 'hover',
            placement: 'top',
            html: true,
            container: 'body'
          }); 
		  } 
       },
       header: {
           //left: 'today, prevYear, nextYear, printButton',
           //center: 'prev, title, next',
           right: 'month'
       },
	   themeSystem: 'bootstrap4',
       eventAfterAllRender: function(view) {
           if(view.name == "month"){
              $(".fc-content").css('height','auto');
            } else {
				$(".fc-content").css('height','auto');
			}
       },
       eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
            $('.popover.fade.top').remove();
       },
       locale: 'en-GB',
       allDaySlot: false,
       firstDay: 1,
       weekNumbers: false,
       selectable: false,
       weekNumberCalculation: "ISO",
       eventLimit: true,
       eventLimitClick: 'week', //popover
       navLinks: true,
       defaultDate: moment('<?php echo $fdate;?>'),
       timeFormat: 'HH:mm',
       editable: false,
       weekends: true,
       nowIndicator: true,
       dayPopoverFormat: 'dddd DD/MM', 
       longPressDelay : 0,
       eventLongPressDelay : 0,
       selectLongPressDelay : 0,
       
       events: [
	   <?php
			for($i = 1; $i <= $daysInMonth; $i++):
			$i = str_pad($i, 2, 0, STR_PAD_LEFT);
			// get date <
			$attendance_date = $year.'-'.$month.'-'.$i;
			$get_day = strtotime($attendance_date);
			$day = date('l', $get_day);
			$user_id = $r[0]->user_id;
			$office_shift_id = $r[0]->office_shift_id;
			$attendance_status = '';
			$office_shift = $this->Timesheet_model->read_office_shift_information($office_shift_id);
			$check = $this->Timesheet_model->attendance_first_in_check($user_id,$attendance_date);
			// get holiday>events
			
			
			// get holiday>weekend
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = 'off day';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
				$estatus = '';
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = 'off day';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
				$estatus = '';
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = 'off day';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
				$estatus = '';
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = 'off day';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
				$clockout = '';
				$estatus = '';
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = 'off day';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$estatus = '';
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = 'off day';	
				$bgcolor = '';
				$estatus = '';
				$total_work = '';
				$event_name = '';
				$clockout = '';
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = 'off day';
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
				$estatus = '';
			} else if($check->num_rows() > 0){
				$attendance = $this->Timesheet_model->attendance_first_in($user_id,$attendance_date);
				$status = $this->lang->line('xin_emp_working');
				$estatus = 'Present';
				$bgcolor = '#00a65a';
				$attendance_date = $attendance_date;
				$iclock_in = new DateTime($attendance[0]->clock_in);
				$fclockin = $iclock_in->format('h:i a');
				$iclock_out = new DateTime($attendance[0]->clock_out);
				$fclockout = $iclock_out->format('h:i a');
				$clockin = '<i class="fa fa-clock-o"></i>'.$fclockin;
				$clockout = '<i class="fa fa-clock-o"></i>'.$fclockout;
				// total hours work/ed
				$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($user_id,$attendance_date);
				$hrs_old_int1 = 0;
				$Total = '';
				$Trest = '';
				$event_name = '';
				$hrs_old_seconds = 0;
				$hrs_old_seconds_rs = 0;
				$total_time_rs = '';
				$hrs_old_int_res1 = 0;
				foreach ($total_hrs->result() as $hour_work){		
					// total work			
					$timee = $hour_work->total_work.':00';
					$str_time =$timee;
		
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
					
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					
					$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					
					$hrs_old_int1 += $hrs_old_seconds;
					
					$Total = gmdate("H:i", $hrs_old_int1);	
				}
				if($Total=='') {
					$total_work = '';
				} else {
					$total_work = $Total;
				}
			} else {	
				$event_name = '';	
				$status = $this->lang->line('xin_absent');
				$estatus = 'Absent';
				$bgcolor = '#dd4b39';
				$attendance_date = $attendance_date;
				$clockin = '';
				$clockout = '';
				$total_work = '';
			}
			// set to present date
			$iattendance_date = strtotime($attendance_date);
			$icurrent_date = strtotime(date('Y-m-d'));
			if($iattendance_date <= $icurrent_date){
				$status = $status;
				$bgcolor = $bgcolor;
				$attendance_date = $attendance_date;
			} else {
				$status = '';
				$bgcolor = '';
				$attendance_date = '';
			}
			$idate_of_joining = strtotime($r[0]->date_of_joining);
			if($idate_of_joining < $iattendance_date){
				$status = $status;
			} else {
				$status = '';
			}
			if($status==1){
				$attendance_date = '';
			}
			if($estatus == 'Present'){
			?>
		   {
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   etitle: '<?php echo $estatus;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   clock_in: '<?php echo $clockin;?>',
			   clock_out: '<?php echo $clockout;?>',
			   total_work: '<?php echo $total_work;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#000000",
		   },
			<?php } else { ?>
			{
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   etitle: '<?php echo $estatus;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#000000",
		   },
		<?php }	?>   
	   <?php endfor;?>
	   ]

   }); 
});
</script>