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
			<?php foreach($completed_invoices as $cinvoice):?>
			{
				title: '<?php echo $cinvoice->invoice_number;?>',
				description: '<?php echo $cinvoice->invoice_number;?>',
				start: '<?php echo $cinvoice->invoice_date?>',
				end: '<?php echo $cinvoice->invoice_date?>',
				urllink: '<?php echo site_url().'admin/invoices/view/'.$cinvoice->invoice_id;?>',
				color: '#02BC77 !important'
			},
			<?php endforeach;?>
			<?php foreach($pending_invoices as $pinvoice):?>
			{
				title: '<?php echo $pinvoice->invoice_number;?>',
				description: '<?php echo $pinvoice->invoice_number;?>',
				start: '<?php echo $pinvoice->invoice_date?>',
				end: '<?php echo $pinvoice->invoice_date?>',
				urllink: '<?php echo site_url().'admin/invoices/view/'.$pinvoice->invoice_id;?>',
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