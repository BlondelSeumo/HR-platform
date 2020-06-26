<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php
if(isset($_POST['set_date'])){
	$set_date = $_POST['set_date'];
} else {
	$set_date = date('Y-m-d');
}
?>
<?php
if($user_info[0]->user_role_id == '1'){
	$completed_task = $this->Project_model->calendar_complete_tasks();
	$cancelled_task = $this->Project_model->calendar_cancelled_tasks();
	$inprogress_task = $this->Project_model->calendar_inprogress_tasks();
	$not_started_task = $this->Project_model->calendar_not_started_tasks();
	$hold_task = $this->Project_model->calendar_hold_tasks();
} else {
	$completed_task = $this->Project_model->calendar_user_complete_tasks($session['user_id']);
	$cancelled_task = $this->Project_model->calendar_user_cancelled_tasks($session['user_id']);
	$inprogress_task = $this->Project_model->calendar_user_inprogress_tasks($session['user_id']);
	$not_started_task = $this->Project_model->calendar_user_not_started_tasks($session['user_id']);
	$hold_task = $this->Project_model->calendar_user_hold_tasks($session['user_id']);
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
			right: 'month,agendaWeek'
		},
		views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		  },
		eventRender: function(event, element) {
		element.attr('title',event.title).tooltip();
		element.attr('href', event.urllink);
		},
		defaultDate: '<?php echo $set_date;?>',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		events: [
			<?php foreach($completed_task as $ctasks):?>
			
			{
				title: '<?php echo $ctasks->task_name;?>',
				start: '<?php echo $ctasks->start_date?>',
				end: '<?php echo $ctasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$ctasks->task_id;?>',
				color: '#02BC77 !important'
			},
			<?php endforeach;?>
			<?php foreach($inprogress_task as $intasks):?>
			{
				title: '<?php echo $intasks->task_name;?>',
				start: '<?php echo $intasks->start_date?>',
				end: '<?php echo $intasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$intasks->task_id;?>',
				color: '#7b83ff !important'
			},
			<?php endforeach;?>
			<?php foreach($not_started_task as $nttasks):?>
			{
				title: '<?php echo $nttasks->task_name;?>',
				start: '<?php echo $nttasks->start_date?>',
				end: '<?php echo $nttasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$nttasks->task_id;?>',
				color: '#28c3d7 !important'
			},
			<?php endforeach;?>
			<?php foreach($cancelled_task as $cntasks):?>
			{
				title: '<?php echo $cntasks->task_name;?>',
				start: '<?php echo $cntasks->start_date?>',
				end: '<?php echo $cntasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$cntasks->task_id;?>',
				color: '#d9534f !important'
			},
			<?php endforeach;?>
			<?php foreach($hold_task as $hltasks):?>
			{
				title: '<?php echo $hltasks->task_name;?>',
				start: '<?php echo $hltasks->start_date?>',
				end: '<?php echo $hltasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$hltasks->task_id;?>',
				color: '#FFD950 !important'
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