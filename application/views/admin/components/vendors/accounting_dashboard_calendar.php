<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<style type="text/css">
.popover-title {
    font-size: .9rem !important;
    border-color: rgba(0,0,0,.05) !important;
    background-color: #fff !important;
	font-weight:bold !important;
}
.popover-title {
    padding: .5rem .75rem !important;
    margin-bottom: 0 !important;
    color: inherit !important;
    border-bottom: 1px solid #ebebeb !important;
    border-top-left-radius: calc(.3rem - 1px) !important;
    border-top-right-radius: calc(.3rem - 1px) !important;
}
.popover {
    border-color: rgba(0,0,0,.1) !important;
}
.popover {
    color: rgba(70,90,110,.85) !important;
}
.popover .arrow {
    position: absolute !important;
    display: block !important;
}
.popover-content {
    font-size: .8rem !important;
    color: rgba(70,90,110,.85) !important;
}

.popover-content {
    padding: .5rem .75rem !important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	/* initialize the calendar
	-----------------------------------------------------------------*/
	$('#calendar_hr').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay',
		},
		views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		  },
		 themeSystem: 'bootstrap4',
		bootstrapFontAwesome: {
		  close: ' ion ion-md-close',
		  prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
		  next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
		  prevYear: ' ion ion-ios-arrow-dropleft-circle scaleX--1-rtl',
		  nextYear: ' ion ion-ios-arrow-dropright-circle scaleX--1-rtl'
		}, 
		eventRender: function(event, element) {
		element.attr('title',event.title).tooltip();
		//element.attr('href', 'javascript:void(0);');
		//element.attr('target', '_blank');
        element.click(function() {
        });
		
		},
		
		
		dayClick: function(date, jsEvent, view) {
        date_last_clicked = $(this);
			var event_date = date.format();
			$('#exact_date').val(event_date);
			var eventInfo = $("#module-opt");
            var mousex = jsEvent.pageX + 20; //Get X coodrinates
            var mousey = jsEvent.pageY + 20; //Get Y coordinates
            var tipWidth = eventInfo.width(); //Find width of tooltip
            var tipHeight = eventInfo.height(); //Find height of tooltip

            //Distance of element from the right edge of viewport
            var tipVisX = $(window).width() - (mousex + tipWidth);
            //Distance of element from the bottom of viewport
            var tipVisY = $(window).height() - (mousey + tipHeight);

            if (tipVisX < 20) { //If tooltip exceeds the X coordinate of viewport
                mousex = jsEvent.pageX - tipWidth - 20;
            } if (tipVisY < 20) { //If tooltip exceeds the Y coordinate of viewport
                mousey = jsEvent.pageY - tipHeight - 0;
            }
            //Absolute position the tooltip according to mouse position
            eventInfo.css({ top: mousey, left: mousex });
            eventInfo.show(); //Show tool tip
		},
		theme:true,
		defaultDate: '<?php echo date('Y-m-d');?>',
		eventLimit: false, // allow "more" link when too many events
	//	navLinks: true, // can click day/week names to navigate views
		events: [
			<?php if(in_array('8',$role_resources_ids)) { ?>
			<?php foreach(income_transaction_record() as $income):?>
			{
				transaction_id: '<?php $income->transaction_id?>',
				title: '<?php echo $income->description.'\n'.$this->Xin_model->currency_sign($income->amount)?>',
				start: '<?php echo $income->transaction_date?>',
				end: '<?php echo $income->transaction_date?>',
				color: '#00a65a',
				unq: '1',
			},
			<?php endforeach;?>
			<?php }?>
			<?php foreach(awards_transaction_record() as $eawards):?>
			<?php
			// get award type
			$award_type = $this->Awards_model->read_award_type_information($eawards->award_type_id);
			if(!is_null($award_type)){
				$award_type = $award_type[0]->award_type;
			} else {
				$award_type = '--';	
			}
			?>
			{
				transaction_id: '<?php echo $eawards->award_id?>',
				title: '<?php echo $award_type.'\n'.$this->Xin_model->currency_sign($eawards->cash_price)?>',
				start: '<?php echo $eawards->created_at?>',
				end: '<?php echo $eawards->created_at?>',
				color: '#d81b60',
				unq: '2',
			},
			<?php endforeach;?>
			<?php foreach(travel_transaction_record() as $etravel):?>
			{
				transaction_id: '<?php echo $etravel->travel_id?>',
				title: '<?php echo $etravel->visit_purpose.'\n'.$this->Xin_model->currency_sign($etravel->actual_budget)?>',
				start: '<?php echo $etravel->start_date?>',
				end: '<?php echo $etravel->end_date?>',
				color: '#3c8dbc',
				unq: '3',
			},
			<?php endforeach;?>
			<?php foreach(payroll_transaction_record() as $epayroll):?>
			<?php
			if($epayroll->wages_type == 0){
				$wages_type = $this->lang->line('xin_payroll_basic_salary');
			} else {
				$wages_type = $this->lang->line('xin_employee_daily_wages');
			}
			$pd = date("Y-m-d", strtotime($epayroll->created_at));
			?>
			{
				transaction_id: '<?php echo $epayroll->payslip_id?>',
				title: '<?php echo $wages_type.'\n'.$this->Xin_model->currency_sign($epayroll->net_salary)?>',
				start: '<?php echo $pd?>',
				end: '<?php echo $pd?>',
				color: '#00c0ef',
				unq: '4',
			},
			<?php endforeach;?>
			<?php foreach(training_transaction_record() as $etraining):?>
			<?php
			// get training type
			$type = $this->Training_model->read_training_type_information($etraining->training_type_id);
			if(!is_null($type)){
				$itype = $type[0]->type;
			} else {
				$itype = '--';	
			}
			?>
			{
				transaction_id: '<?php echo $etraining->training_id?>',
				title: '<?php echo $itype.'\n'.$this->Xin_model->currency_sign($etraining->training_cost)?>',
				start: '<?php echo $etraining->start_date?>',
				end: '<?php echo $etraining->finish_date?>',
				color: '#f39c12',
				unq: '5',
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
				urllink: '<?php echo site_url().'admin/invoices/view/'.$invoice_payments->invoice_id;?>',
				color: '#605ca8'
			},
			<?php endforeach;?>
		]
	});
	$('.fc-icon-x').click(function() {
		$('#module-opt').hide();
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
.trumbowyg-box.trumbowyg-editor-visible {
  min-height: 90px !important;
}
.fc-day-grid-event {
    padding: 0px 5px !important;
}
.fc-events-container .fc-event {
    padding: 2px !important;
}
.trumbowyg-editor {
  min-height: 90px !important;
}
.fc-day:hover, .fc-day-number:hover, .fc-content:hover{cursor: pointer;}

.fc-close {
    font-size: .9em !important;
    margin-top: 2px !important;
}
.fc-close {
    float: right !important;
}

.fc-close {
    color: #666 !important;
}
.fc-event.fc-draggable, .fc-event[href], .fc-popover .fc-header .fc-close {
    cursor: pointer;
}
.fc-widget-header {
    background: #E4EBF1 !important;
}
.fc-widget-content {
	background: #FFFFFF;
}

.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
.fc-event { line-height: 2.0 !important; }
</style>
