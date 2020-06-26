<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php
if(isset($_POST['calendar_goal_date'])){
	$goal_date = $_POST['calendar_goal_date'];
} else {
	$goal_date = date('Y-m');
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
		element.attr('title',event.title).tooltip();
		element.attr('href', 'javascript:void(0);');
        element.click(function() {
			$.ajax({
				url : site_url+"goal_tracking/read_goal/",
				type: "GET",
				data: 'jd=1&is_ajax=1&mode=modal&data=view_tracking&tracking_id='+event.tracking_id,
				success: function (response) {
					if(response) {
						$('.view-modal-data').modal('show')
						$("#ajax_modal_view").html(response);
					}
				}
			});
        });
		
		},
		defaultDate: '<?php echo $goal_date;?>',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		events: [
			<?php foreach($all_goals_completed->result() as $goals_completed):?>
			{
				tracking_id: '<?php echo $goals_completed->tracking_id?>',
				title: '<?php echo $goals_completed->subject?>',
				start: '<?php echo $goals_completed->start_date?>',
				end: '<?php echo $goals_completed->end_date?>',
				color: '#ED5564'
			},
			<?php endforeach;?>
			<?php foreach($all_goals_inprogress->result() as $goals_inprogress):?>
			{
				tracking_id: '<?php echo $goals_inprogress->tracking_id?>',
				title: '<?php echo $goals_inprogress->subject?>',
				start: '<?php echo $goals_inprogress->start_date?>',
				end: '<?php echo $goals_inprogress->end_date?>',
				color: '#F6BB42'
			},
			<?php endforeach;?>
			<?php foreach($all_goals_not_started->result() as $goals_not_started):?>
			{
				tracking_id: '<?php echo $goals_not_started->tracking_id?>',
				title: '<?php echo $goals_not_started->subject?>',
				start: '<?php echo $goals_not_started->start_date?>',
				end: '<?php echo $goals_not_started->end_date?>',
				color: '#ED5564'
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
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>