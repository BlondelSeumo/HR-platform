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
			right: 'month,agendaWeek'
		},
		views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		  },
		  eventClick: function(event, jsEvent, view) {
		  $this = $(this);
		  var that = $(jsEvent.target);
		  var el = that.is('.fc-event') ? that : that.closest('.fc-event');
		//  var event_date = '<div><i class="fa fa-fw fa-calendar-o text-muted"></i> '+moment(event.start).format("dddd D M Y")+'</div>';
		  var participant = ''
		  $.each(event.participant, function (index, value) {
			participant += '<a href="profile.html" class="avatar w-24 mr-1"><img src="<?php echo base_url();?>'+value+'"></a>';
		  });
		  var title = 'New Project';
		  var description = '<div class="popover-body"><div><i class="fa fa-fw fa-calendar-o text-muted"></i> Monday 2</div><div><i class="fa fa-fw fa-clock-o text-muted"></i> 5:12am</div><div class="d-flex my-2">'+participant+'</div><div class="text-muted mb-2">Tricies neque, quis malesuada augue. Donec eleifend  nisl eu consectetur. </div></div>';
        $this.popover({html:true,title:title,content: description ,placement:'right'}).popover('show');
        //return false;            
    },
		eventRender: function(event, element) {
		//element.attr('title',event.title).tooltip();
		element.attr('href', 'javascript:void(0);');
        /*element.click(function() {
			if(event.unq==1){
				$.ajax({
					url : site_url+"timesheet/read_holiday_record/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=modal&data=view_holiday&holiday_id='+event.holiday_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show')
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==2){
				$.ajax({
					url : site_url+"timesheet/read_leave_record/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=modal&data=view_leave&leave_id='+event.leave_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show')
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==4){
				$.ajax({
					url : site_url+"travel/read/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=view_modal&data=view_travel&travel_id='+event.travel_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show')
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==5){
				$.ajax({
					url : site_url+"training/read/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=view_modal&data=view_training&training_id='+event.training_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show')
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==6){
				$.ajax({
					url : site_url+"project/read/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=view_modal&data=view_project&project_id='+event.project_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show')
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==7){
				$.ajax({
					url : site_url+"timesheet/read_task_record/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=view_modal&data=view_task&task_id='+event.task_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show')
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==8){
				$.ajax({
					url : site_url+"events/read_event_record/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=modal&data=view_event&event_id='+event.event_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show')
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==9){
				$.ajax({
					url : site_url+"meetings/read_meeting_record/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=modal&data=view_meeting&meeting_id='+event.meeting_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show');
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			} else if(event.unq==10){
				$.ajax({
					url : site_url+'goal_tracking/read_goal/',
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=modal&data=view_tracking&tracking_id='+event.tracking_id,
					success: function (response) {
						if(response) {
							$('.payroll_template_modal').modal('show');
							$("#ajax_modal_payroll").html(response);
						}
					}
				});
			}
        });
		*/
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
		navLinks: true, // can click day/week names to navigate views
		events: [
			<?php foreach($all_holidays->result() as $holiday):?>
			{
				holiday_id: '<?php echo $holiday->holiday_id?>',
				title: '<?php echo $holiday->event_name?>',
				start: '<?php echo $holiday->start_date?>',
				end: '<?php echo $holiday->end_date?>',
				color: '#2D95BF',
				unq: '1',
			},
			<?php endforeach;?>
			<?php foreach($all_leaves_request_calendar->result() as $leave):?>
			<?php $lvType = $this->Timesheet_model->read_leave_type_information($leave->leave_type_id);?>
			<?php $lvUser = $this->Xin_model->read_user_info($leave->employee_id); ?>
			<?php if(!is_null($lvUser)):?><?php $fName = $lvUser[0]->first_name. ' '.$lvUser[0]->last_name;?>
			<?php else:?><?php echo $fName='';?><?php endif;?>
			<?php if(!is_null($lvType)):?><?php $leaveType = $lvType[0]->type_name;?>
			<?php else:?><?php echo $leaveType='';?><?php endif;?>
			{
				leave_id: '<?php echo $leave->leave_id?>',
				title: '<?php echo $leaveType.' '.$this->lang->line('xin_hr_calendar_lv_request_by').' '.$fName;?>',
				start: '<?php echo $leave->from_date?>',
				end: '<?php echo $leave->to_date?>',
				color: '#48CFAE',
				unq: '2',
			},
			<?php endforeach;?>
			<?php foreach($all_upcoming_birthday as $upc_birthday):?>
			{
				title: '<?php echo $upc_birthday->first_name.' '.$upc_birthday->last_name?> - <?php echo $this->lang->line('xin_hr_calendar_upc_birthday');?>',
				start: '<?php echo $upc_birthday->date_of_birth?>',
				color: '#FB6E52',
				unq: '3',
			},
			<?php endforeach;?>
			<?php if($system[0]->module_travel=='true'){?>
			<?php foreach($all_travel_request->result() as $travel_request):?>
			<?php $employee = $this->Xin_model->read_user_info($travel_request->employee_id); ?>
			<?php if(!is_null($employee)):?><?php $eName = $employee[0]->first_name. ' '.$employee[0]->last_name;?>
			<?php else:?><?php echo $eName='';?><?php endif;?>
			{
				travel_id: '<?php echo $travel_request->travel_id?>',
				title: '<?php echo $travel_request->visit_purpose.' '.$this->lang->line('xin_hr_calendar_lv_request_by').' '.$eName;?>',
				start: '<?php echo $travel_request->start_date?>',
				end: '<?php echo $travel_request->end_date?>',
				color: '#50C1E9',
				unq: '4',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if($system[0]->module_training=='true'){?>
			<?php foreach($all_training->result() as $training):?>
			<?php $type = $this->Training_model->read_training_type_information($training->training_type_id); ?>
			<?php if(!is_null($type)):?><?php $itype = $type[0]->type;?>
			<?php else:?><?php echo $itype='';?><?php endif;?>
			{
				training_id: '<?php echo $training->training_id?>',
				title: '<?php echo $itype;?>',
				start: '<?php echo $training->start_date?>',
				end: '<?php echo $training->finish_date?>',
				color: '#ED5564',
				unq: '5',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php foreach($all_projects->result() as $projects):?>
			{
				project_id: '<?php echo $projects->project_id;?>',
				title: '<?php echo $projects->title;?>',
				start: '<?php echo $projects->start_date?>',
				end: '<?php echo $projects->end_date?>',
				color: '#F8B195',
				unq: '6',
			},
			<?php endforeach;?>
			<?php foreach($all_tasks->result() as $tasks):?>
			{
				task_id: '<?php echo $tasks->task_id;?>',
				title: '<?php echo $tasks->task_name;?>',
				start: '<?php echo $tasks->start_date?>',
				end: '<?php echo $tasks->end_date?>',
				color: '#6C5B7B',
				unq: '7',
			},
			<?php endforeach;?>
			<?php foreach($all_events->result() as $events):?>
			{
				event_id: '<?php echo $events->event_id?>',
				title: '<?php echo $events->event_title?>',
				start: '<?php echo $events->event_date?>T<?php echo $events->event_time?>',
				color: '#355C7D',
				unq: '8',
			},
			<?php endforeach;?>
			<?php foreach($all_meetings->result() as $meetings):?>
			{
				meeting_id: '<?php echo $meetings->meeting_id?>',
				title: '<?php echo $meetings->meeting_title?>',
				start: '<?php echo $meetings->meeting_date?>T<?php echo $meetings->meeting_time?>',
				color: '#547A8B',
				unq: '9',
				className: "regular"
			},
			<?php endforeach;?>
			<?php foreach($all_goals->result() as $goals):?>
			{
				tracking_id: '<?php echo $goals->tracking_id?>',
				title: '<?php echo $goals->subject?>',
				start: '<?php echo $goals->start_date?>',
				end: '<?php echo $goals->end_date?>',
				color: '#3EACAB',
				unq: '10',
				participant : ['uploads/profile/default_female.jpg','uploads/profile/default_male.jpg']
			},
			<?php endforeach;?>
		]
	});
	$('.fc-icon-x').click(function() {
		$('#module-opt').hide();
	});
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var ex_date = $('#exact_date').val();
		var recrd =  button.data('record');
		var modal = $(this);
		$.ajax({
		url : site_url+"calendar/add_cal_record/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=event&event_date='+ex_date+"&record="+recrd,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
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

<div id="module-opt" class="fc-popover fc-more-popover" style="display:none; z-index: 100;">
  <div class="fc-header fc-widget-header"> <span class="fc-close fc-icon fc-icon-x"></span><span class="fc-title"><?php echo $this->lang->line('xin_hr_add_options');?></span>
    <div class="fc-clear"></div>
  </div>
  <div class="fc-body fc-widget-content" style=" overflow: auto; height: 250px;">
    <div class="fc-event-container"> <a data-toggle="modal" data-target=".view-modal-data" data-record="0" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('left_holidays');?></span></div>
      </a> <a data-toggle="modal" data-target=".view-modal-data" data-record="1" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('left_leave');?></span></div>
      </a>
      <?php if($system[0]->module_travel=='true'){?>
      <a data-toggle="modal" data-target=".view-modal-data" data-record="2" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('xin_travel');?></span></div>
      </a>
      <?php } ?>
      <?php if($system[0]->module_training=='true'){?>
      <a data-toggle="modal" data-target=".view-modal-data" data-record="3" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('xin_hr_calendar_tranings');?></span></div>
      </a>
      <?php } ?>
      <a data-toggle="modal" data-target=".view-modal-data" data-record="4" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('left_projects');?></span></div>
      </a> <a data-toggle="modal" data-target=".view-modal-data" data-record="5" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('left_tasks');?></span></div>
      </a> <a data-toggle="modal" data-target=".view-modal-data" data-record="6" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('xin_hr_events');?></span></div>
      </a> <a data-toggle="modal" data-target=".view-modal-data" data-record="7" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('xin_hr_meetings');?></span></div>
      </a> <a data-toggle="modal" data-target=".view-modal-data" data-record="8" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
      <div class="fc-content"> <span class="fc-title"><?php echo $this->lang->line('xin_hr_set_goal');?></span></div>
      </a> </div>
  </div>
</div>
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
</style>
