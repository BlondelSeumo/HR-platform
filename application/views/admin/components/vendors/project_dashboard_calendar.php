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
	$('#calendar_projects').fullCalendar({
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
			
			<?php foreach($get_projects->result() as $project):?>
			{
				title: '<?php echo $project->title;?>',
				description: '<?php echo $project->title;?>',
				start: '<?php echo $project->start_date?>',
				end: '<?php echo $project->end_date?>',
				urllink: '<?php echo site_url().'admin/project/detail/'.$project->project_id;?>',
				color: '#00a65a'
			},
			<?php endforeach;?>
			<?php foreach($all_tasks->result() as $ctasks):?>
			<?php
				$task_cat = $this->Project_model->read_task_category_information($ctasks->task_name);
				if(!is_null($task_cat)){
					$tname = $task_cat[0]->category_name;
				} else {
					$tname = '';
				}
			?>
			{
				title: '<?php echo $tname;?>',
				description: '<?php echo $tname;?>',
				start: '<?php echo $ctasks->start_date?>',
				end: '<?php echo $ctasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$ctasks->task_id;?>',
				color: '#d81b60'
			},
			<?php endforeach;?>
			<?php foreach($get_invoices->result() as $cinvoice):?>
			{
				title: '<?php echo $cinvoice->invoice_number;?>',
				description: '<?php echo $cinvoice->invoice_number;?>',
				start: '<?php echo $cinvoice->invoice_date?>',
				end: '<?php echo $cinvoice->invoice_date?>',
				urllink: '<?php echo site_url().'admin/invoices/view/'.$cinvoice->invoice_id;?>',
				color: '#001f3f'
			},
			<?php endforeach;?>
			<?php foreach($get_quotes->result() as $pquote):?>
			{
				title: '<?php echo $pquote->quote_number;?>',
				description: '<?php echo $pquote->quote_number;?>',
				start: '<?php echo $pquote->quote_date?>',
				end: '<?php echo $pquote->quote_date?>',
				urllink: '<?php echo site_url().'admin/quotes/view/'.$pquote->quote_id;?>',
				color: '#39cccc'
			},
			<?php endforeach;?>
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
				color: '#00c0ef'
			},
			<?php endforeach;?>
			<?php foreach(invoice_payments_transaction_record() as $invoice_payments):?>
			<?php $total_amount = $this->Xin_model->currency_sign($invoice_payments->amount);?>
			<?php
			$invoice_info = $this->Invoices_model->read_invoice_info($invoice_payments->invoice_id);
			if(!is_null($invoice_info)){
				$inv_no = $invoice_info[0]->invoice_number;
			} else {
				$inv_no = '--';	
			}
			?>
			{
				title: '<?php echo $inv_no;?>',
				description: '<?php echo $inv_no.' ('.$total_amount.')';?>',
				start: '<?php echo $invoice_payments->transaction_date?>',
				end: '<?php echo $invoice_payments->transaction_date?>',
				color: '#f39c12'
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