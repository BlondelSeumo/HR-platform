<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php
if(isset($_POST['set_date'])){
	$leave_date = $_POST['set_date'];
} else {
	$leave_date = date('Y-m-d');
}
?>
<script type="text/javascript">
$(document).ready(function(){
	
	/* initialize the calendar
	-----------------------------------------------------------------*/
	$('#calendar_hr').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		  },
		eventRender: function(event, element) {
		element.attr('title',event.titlepopup).tooltip();
		element.attr('href', event.urllink);
		
		},
		defaultDate: '<?php echo $leave_date;?>',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		events: [
			<?php foreach($this->Xin_model->get_leave_applications() as $leave_app):?>
			<?php
				$leave_type = $this->Timesheet_model->read_leave_type_information($leave_app->leave_type_id);
				 if(!is_null($leave_type)){
					$type_name = $leave_type[0]->type_name;
				} else {
					$type_name = '--';	
				}
				$user = $this->Xin_model->read_user_info($leave_app->employee_id);
				if(!is_null($user)){
					$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				} else { $full_name = '--'; }
			?>
			{
				title: '<?php echo $type_name;?>',
				titlepopup: '<?php echo $this->lang->line('xin_hr_calendar_lv_request_by').': '.$full_name;?>',
				start: '<?php echo $leave_app->from_date;?>',
				end: '<?php echo $leave_app->to_date;?>',
				urllink: '<?php echo site_url().'admin/timesheet/leave_details/id/'.$leave_app->leave_id;?>',
				color: '#F6BB42'
			},
			<?php endforeach;?>
			
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