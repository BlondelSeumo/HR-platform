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
	$completed_projects = $this->Project_model->calendar_complete_projects();
	$cancelled_projects = $this->Project_model->calendar_cancelled_projects();
	$inprogress_projects = $this->Project_model->calendar_inprogress_projects();
	$not_started_projects = $this->Project_model->calendar_not_started_projects();
	$hold_projects = $this->Project_model->calendar_hold_projects();
} else {
	$completed_projects = $this->Project_model->calendar_user_complete_projects($session['user_id']);
	$cancelled_projects = $this->Project_model->calendar_user_cancelled_projects($session['user_id']);
	$inprogress_projects = $this->Project_model->calendar_user_inprogress_projects($session['user_id']);
	$not_started_projects = $this->Project_model->calendar_user_not_started_projects($session['user_id']);
	$hold_projects = $this->Project_model->calendar_user_hold_projects($session['user_id']);
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
			<?php foreach($completed_projects as $cprojects):?>
			{
				title: '<?php echo $cprojects->title;?>',
				start: '<?php echo $cprojects->start_date?>',
				end: '<?php echo $cprojects->end_date?>',
				urllink: '<?php echo site_url().'admin/project/detail/'.$cprojects->project_id;?>',
				color: '#02BC77 !important'
			},
			<?php endforeach;?>
			<?php foreach($inprogress_projects as $inprojects):?>
			{
				title: '<?php echo $inprojects->title;?>',
				start: '<?php echo $inprojects->start_date?>',
				end: '<?php echo $inprojects->end_date?>',
				urllink: '<?php echo site_url().'admin/project/detail/'.$inprojects->project_id;?>',
				color: '#7b83ff !important'
			},
			<?php endforeach;?>
			<?php foreach($not_started_projects as $ntprojects):?>
			{
				title: '<?php echo $ntprojects->title;?>',
				start: '<?php echo $ntprojects->start_date?>',
				end: '<?php echo $ntprojects->end_date?>',
				urllink: '<?php echo site_url().'admin/project/detail/'.$ntprojects->project_id;?>',
				color: '#28c3d7 !important'
			},
			<?php endforeach;?>
			<?php foreach($cancelled_projects as $cnprojects):?>
			{
				title: '<?php echo $cnprojects->title;?>',
				start: '<?php echo $cnprojects->start_date?>',
				end: '<?php echo $cnprojects->end_date?>',
				urllink: '<?php echo site_url().'admin/project/detail/'.$cnprojects->project_id;?>',
				color: '#d9534f !important'
			},
			<?php endforeach;?>
			<?php foreach($hold_projects as $hlprojects):?>
			{
				title: '<?php echo $hlprojects->title;?>',
				start: '<?php echo $hlprojects->start_date?>',
				end: '<?php echo $hlprojects->end_date?>',
				urllink: '<?php echo site_url().'admin/project/detail/'.$hlprojects->project_id;?>',
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