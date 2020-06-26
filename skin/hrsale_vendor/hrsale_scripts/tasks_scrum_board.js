$(function() {

  // Task Kanban Board
	dragula([
		document.getElementById('first-notstarted'),
		document.getElementById('first-inprogress'),
		document.getElementById('first-completed'),
		document.getElementById('first-cancelled'),
		document.getElementById('first-hold'),
	])
	.on('drag', function(event) {
		var infieldid =  event.dataset.id;
		var infieldst = event.dataset.status;
		
	}).on('dragend', function(el,target) {
		var xfieldid =  el.dataset.id;
		var xfieldst = $('.'+el.id+'_'+xfieldid).parent( ".kanban-box" ).data('status');
			$.get(site_url+"project/update_task_scrum_board_status/"+xfieldid+"/"+xfieldst, function(data, status){
				toastr.success(data.result);
		});
	});
  // RTL
  if ($('html').attr('dir') === 'rtl') {
    $('.kanban-board-actions .dropdown-menu').removeClass('dropdown-menu-right');
  }

});
$(document).ready(function() {
	// add
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var task_status = button.data('task_status');
		var modal = $(this);
	$.ajax({
		url : site_url+"project/get_scrumboard_task/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=scrum_board&task_status='+task_status,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
});