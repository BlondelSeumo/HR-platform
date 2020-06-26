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
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#list_group span.hrsale-drag-option'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar_hr').fullCalendar({
      header: {
           left: 'today',
           center: 'prev, title, next',
           right: 'month,agendaWeek,agendaDay,listWeek'
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
		element.attr('href', 'javascript:void(0);');
        element.click(function() {
			if(event.unq==1){
				$.ajax({
					url : site_url+"timesheet/read_holiday_record/",
					type: "GET",
					data: 'jd=1&is_ajax=1&mode=modal&data=view_holiday&holiday_id='+event.holiday_id,
					success: function (response) {
						if(response) {
							$('#modals-slide').modal('show')
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show')
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show')
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show')
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show')
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show')
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show')
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show');
							$("#ajax_modal_view").html(response);
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
							$('#modals-slide').modal('show');
							$("#ajax_modal_view").html(response);
						}
					}
				});
			}
        });
		
		},
      theme:true,
		defaultDate: '<?php echo date('Y-m-d');?>',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
      events: [
			<?php if(in_array('8',$role_resources_ids)) { ?>
			<?php foreach($all_holidays->result() as $holiday):?>
			{
				holiday_id: '<?php echo $holiday->holiday_id?>',
				title: "<?php echo $holiday->event_name?>",
				start: '<?php echo $holiday->start_date?>',
				end: '<?php echo $holiday->end_date?>',
				color: 'rgba(24,28,33,0.9) !important',
				unq: '1',
			},
			<?php endforeach;?>
			<?php }?>
			<?php if(in_array('46',$role_resources_ids)) { ?>
			<?php foreach($all_leaves_request_calendar->result() as $leave):?>
			<?php $lvType = $this->Timesheet_model->read_leave_type_information($leave->leave_type_id);?>
			<?php $lvUser = $this->Xin_model->read_user_info($leave->employee_id); ?>
			<?php if(!is_null($lvUser)):?><?php $fName = $lvUser[0]->first_name. ' '.$lvUser[0]->last_name;?>
			<?php else:?><?php echo $fName='';?><?php endif;?>
			<?php if(!is_null($lvType)):?><?php $leaveType = $lvType[0]->type_name;?>
			<?php else:?><?php echo $leaveType='';?><?php endif;?>
			<?php $leave_to_date = date('Y-m-d H:i:s', strtotime($leave->to_date . ' +1 day'));?>
			{
				leave_id: '<?php echo $leave->leave_id?>',
				title: "<?php echo $leaveType.' '.$this->lang->line('xin_hr_calendar_lv_request_by').' '.$fName;?>",
				start: '<?php echo $leave->from_date?>',
				end: '<?php echo $leave_to_date?>',
				color: '#26B4FF !important',
				unq: '2',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php foreach($all_upcoming_birthday as $upc_birthday):?>
			{
				title: "<?php echo $upc_birthday->first_name.' '.$upc_birthday->last_name?> - <?php echo $this->lang->line('xin_hr_calendar_upc_birthday');?>",
				start: '<?php echo $upc_birthday->next_birthday?>',
				color: '#a3a4a6 !important',
				unq: '3',
			},
			<?php endforeach;?>
			<?php if($system[0]->module_travel=='true'){?>
			<?php if(in_array('17',$role_resources_ids)) { ?>
			<?php foreach($all_travel_request->result() as $travel_request):?>
			<?php $employee = $this->Xin_model->read_user_info($travel_request->employee_id); ?>
			<?php if(!is_null($employee)):?><?php $eName = $employee[0]->first_name. ' '.$employee[0]->last_name;?>
			<?php else:?><?php echo $eName='';?><?php endif;?>
			{
				travel_id: '<?php echo $travel_request->travel_id?>',
				title: "<?php echo $travel_request->visit_purpose.' '.$this->lang->line('xin_hr_calendar_lv_request_by').' '.$eName;?>",
				start: '<?php echo $travel_request->start_date?>',
				end: '<?php echo $travel_request->end_date?>',
				color: '#02BC77 !important',
				unq: '4',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php } ?>
			<?php if($system[0]->module_training=='true'){?>
			<?php if(in_array('54',$role_resources_ids)) { ?>
			<?php foreach($all_training->result() as $training):?>
			<?php $type = $this->Training_model->read_training_type_information($training->training_type_id); ?>
			<?php if(!is_null($type)):?><?php $itype = $type[0]->type;?>
			<?php else:?><?php echo $itype='';?><?php endif;?>
			{
				training_id: '<?php echo $training->training_id?>',
				title: "<?php echo $itype;?>",
				start: '<?php echo $training->start_date?>',
				end: '<?php echo $training->finish_date?>',
				color: '#28c3d7 !important',
				unq: '5',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php } ?>
			<?php if($system[0]->module_projects_tasks=='true'){?>
			<?php if(in_array('44',$role_resources_ids)) { ?>
			<?php foreach($all_projects->result() as $projects):?>
			{
				project_id: '<?php echo $projects->project_id;?>',
				title: "<?php echo $projects->title;?>",
				start: '<?php echo $projects->start_date?>',
				end: '<?php echo $projects->end_date?>',
				color: '#FFD950 !important',
				unq: '6',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('45',$role_resources_ids)) { ?>
			<?php foreach($all_tasks->result() as $tasks):?>
			{
				task_id: '<?php echo $tasks->task_id;?>',
				title: "<?php echo $tasks->task_name;?>",
				start: '<?php echo $tasks->start_date?>',
				end: '<?php echo $tasks->end_date?>',
				color: '#d9534f !important',
				unq: '7',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php } ?>
			<?php if($system[0]->module_events=='true'){?>
			<?php if(in_array('98',$role_resources_ids)) { ?>
			<?php foreach($all_events->result() as $events):?>
			{
				event_id: '<?php echo $events->event_id?>',
				title: "<?php echo $events->event_title?>",
				start: '<?php echo $events->event_date?>T<?php echo $events->event_time?>',
				color: '#d81b60 !important',
				unq: '8',
			},
			<?php endforeach;?>
			<?php } ?>
			<?php if(in_array('99',$role_resources_ids)) { ?>
			<?php foreach($all_meetings->result() as $meetings):?>
			{
				meeting_id: '<?php echo $meetings->meeting_id?>',
				title: "<?php echo $meetings->meeting_title?>",
				start: '<?php echo $meetings->meeting_date?>T<?php echo $meetings->meeting_time?>',
				color: '#605ca8 !important',
				unq: '9',
				className: "regular"
			},
			<?php endforeach;?>
			<?php } ?>
			<?php } ?>
			<?php if($system[0]->module_goal_tracking=='true'){?>
			<?php if(in_array('107',$role_resources_ids)) { ?>
			<?php foreach($all_goals->result() as $goals):?>
			{
				tracking_id: '<?php echo $goals->tracking_id?>',
				title: "<?php echo $goals->subject?>",
				start: '<?php echo $goals->start_date?>',
				end: '<?php echo $goals->end_date?>',
				color: '#39cccc !important',
				unq: '10',
				participant : ['uploads/profile/default_female.jpg','uploads/profile/default_male.jpg']
			},
			<?php endforeach;?>
			<?php } ?>
			<?php } ?>
		],
      editable  : false,
      droppable : true, // this allows things to be dropped onto the calendar !!!
	  selectable: false,
      drop      : function (date, allDay) { // this function is called when something is dropped
			var event_date = date.format();
			$('#exact_date').val(event_date);
			var this_record = $(this).data('record');
			$('#modals-slide').modal('show');
			var ex_date = $('#exact_date').val();
			$.ajax({
			url : site_url+"calendar/add_cal_record/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=event&event_date='+ex_date+"&record="+this_record,
			success: function (response) {
				if(response) {
					$("#ajax_modal_view").html(response);
				}
			}
		})
      },
    })
  })
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
.hrsale-drag-option {
	cursor: move !important;
}
</style>
