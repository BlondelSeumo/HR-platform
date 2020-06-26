<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php
/*if(isset($_POST['set_date'])){
	$leave_date = $_POST['set_date'];
} else {
	$leave_date = date('Y-m-d');
}*/
$r = $this->Xin_model->read_user_info(5);
/* Set the date */
$date = strtotime(date("Y-m-d"));
$day = date('d', $date);
$month = date('m', $date);
$year = date('Y', $date);
// total days in month
$daysInMonth =  date('t');
$imonth = date('F', $date);
?>
<script type="text/javascript">
var newEvent;
var editEvent;

$(document).ready(function() {
    
   var calendar = $('#calendar_hr').fullCalendar({
       
       eventRender: function(event, element, view) {
         var displayEventDate;    
         if(event.title == 'Present'){
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
		  }   else if(event.title == 'Holiday'){
          element.popover({
			  
            title:    '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
            content:  '<div class="popoverInfoCalendar">' +
						'<p><strong>Event Name:</strong> ' + event.event_name + '</p>' +
						'<p><strong>Start Date:</strong> ' + event.estart + '</p>' +
						'<p><strong>End Date:</strong> ' + event.eend + '</p>' +
                        '<div class="popoverDescCalendar"><strong>Description:</strong> '+ event.description +'</div>' +
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
       /*customButtons: {
          printButton: {
            icon: 'print',
            click: function() {
              window.print();
            }
          }
        },*/
       header: {
           left: 'today, prevYear, nextYear, printButton',
           center: 'prev, title, next',
           right: 'month,agendaWeek,agendaDay,listWeek'
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
       defaultDate: moment('<?php echo date('Y-m-d');?>'),
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
			// get holiday>weekend
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
				$clockout = '';
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
				$clockout = '';
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = '1';
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = 'Holiday';
				$bgcolor = '#f39c12';
				$clockin = '';
				$total_work = '';
				$clockout = '';
				$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
				$event_name = '';
				if($h_date_chck->num_rows() > 0){
					$h_date = $this->Timesheet_model->holiday_date($attendance_date);
					foreach($h_date as $hevent){
						$event_name = $hevent->event_name;
						$description = $hevent->description;
					}
				}
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = 'Leave';
				$clockin = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
			} else if($check->num_rows() > 0){
				$attendance = $this->Timesheet_model->attendance_first_in($user_id,$attendance_date);
				$status = $attendance[0]->attendance_status;
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
				$status = 'Absent';
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
			if($status==1){
				$attendance_date = '';
			}
			if($status == 'Present'){
			?>
		   {
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   clock_in: '<?php echo $clockin;?>',
			   clock_out: '<?php echo $clockout;?>',
			   total_work: '<?php echo $total_work;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#ffffff",
		   },
			<?php } 
			else if($status == 'Holiday'){
			?>
		   {
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   event_name: '<?php echo $event_name;?>',
			   estart: '<?php echo $attendance_date;?>',
			   eend: '<?php echo $attendance_date;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   description: '<?php echo $description;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#ffffff",
		   },
			<?php } else { ?>
			{
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   clock_in: '',
			   clock_out: '',
			   total_work: '',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#ffffff",
		   },
		<?php }	?>   
	   <?php endfor;?>
	   ]

   }); 
});
$(document).ready(function(){
	
	/* initialize the calendar
	-----------------------------------------------------------------*/
	$('#calendar_hr1').fullCalendar({
		header: {
			left: 'prev,next today,printButton',
			center: 'prev, title, next',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		views: {
            month: {
              columnFormat:'dddd'
            },
            agendaWeek:{
              columnFormat:'ddd D/M',
              eventLimit: false
            },
            agendaDay:{
              columnFormat:'dddd',
              eventLimit: false
            },
            listWeek:{
              columnFormat:''
            }
        },
		eventRender: function(event, element) {
		element.attr('title',event.titlepopup).tooltip();
		element.find('.fc-title').append(event.clockin);
		element.find('.fc-title').append(event.total_work);
		
		},
		defaultDate: '<?php echo date('Y-m-d');?>',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
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
				// get holiday>weekend
				if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
					$status = '1';	
					$bgcolor = '';
					$total_work = '';
				} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
					$status = '1';	
					$bgcolor = '';
					$total_work = '';
				} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
					$status = '1';	
					$bgcolor = '';
					$total_work = '';
				} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
					$status = '1';	
					$bgcolor = '';
					$total_work = '';
				} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
					$status = '1';	
					$bgcolor = '';
					$total_work = '';
				} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
					$status = '1';	
					$bgcolor = '';
					$total_work = '';
				} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
					$status = '1';
					$bgcolor = '';
					$total_work = '';
				} else if(in_array($attendance_date,$holiday_arr)) { // holiday
					$status = 'Holiday';
					$bgcolor = '#f39c12';
					$clockin = '';
					$total_work = '';
				} else if(in_array($attendance_date,$leave_arr)) { // on leave
					$status = 'Leave';
					$clockin = '';
					$total_work = '';
				} else if($check->num_rows() > 0){
					$attendance = $this->Timesheet_model->attendance_first_in($user_id,$attendance_date);
					$status = $attendance[0]->attendance_status;
					$bgcolor = '#00a65a';
					$attendance_date = $attendance_date;
					$iclock_in = new DateTime($attendance[0]->clock_in);
					$fclockin = $iclock_in->format('h:i a');
					$iclock_out = new DateTime($attendance[0]->clock_out);
					$fclockout = $iclock_out->format('h:i a');
					$clockin = '<br><br><i class="fa fa-clock-o"></i> '.$fclockin.' - <i class="fa fa-clock-o"></i> '.$fclockout;
					// total hours work/ed
					$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($user_id,$attendance_date);
					$hrs_old_int1 = 0;
					$Total = '';
					$Trest = '';
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
						$total_work = '<br/>Total: '.$Total;
					}
				} else {		
					$status = 'Absent';
					$bgcolor = '#dd4b39';
					$attendance_date = $attendance_date;
					$clockin = '';
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
				if($status==1){
					$attendance_date = '';
				}
			?>
			{
				title: '<?php echo $status;?>',
				clockin: '<?php echo $clockin;?>',
				total_work: '<?php echo $total_work;?>',
				start: '<?php echo $attendance_date;?>',
				end: '<?php echo $attendance_date;?>',
				color: '<?php echo $bgcolor;?>',
			},		
			<?php endfor; ?>	
		]
	});
	
	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events .fc-event').each(function() {

		// Different colors for events
        $(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});

		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			color: $(this).data('color'),
			stick: true // maintain when user navigates (see docs on the renderEvent method)
		});

	});


});
</script>