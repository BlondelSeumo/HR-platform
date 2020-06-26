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
		element.attr('title',event.description).tooltip();
		element.attr('href', event.urllink);
		},
		defaultDate: '<?php echo $set_date;?>',
		eventLimit: true, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		events: [
			<?php foreach($leads_follow_up_all as $follow_up):?>
			<?php
			$lead_info = $this->Clients_model->read_lead_info($follow_up->lead_id);
			if(!is_null($lead_info)) {
				$lead_name = $lead_info[0]->name;
				$urllink = site_url().'admin/leads/followup/'.$follow_up->lead_id;
			} else {
				$lead_name = '--';
				$urllink = '';
			}
			?>
			{
				title: '<?php echo $lead_name;?>',
				description: '<?php echo $follow_up->description?>',
				start: '<?php echo $follow_up->next_followup?>',
				end: '<?php echo $follow_up->next_followup?>',
				urllink: '<?php echo $urllink;?>',
				color: '#02BC77 !important'
			},
			<?php endforeach;?>
			<?php foreach($estimates_all as $estimates):?>
			{
				title: '<?php echo $estimates->quote_number;?>',
				description: '<?php echo $estimates->quote_number;?>',
				start: '<?php echo $estimates->quote_date?>',
				end: '<?php echo $estimates->quote_date?>',
				urllink: '<?php echo site_url().'admin/quotes/view/'.$estimates->quote_id;?>',
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