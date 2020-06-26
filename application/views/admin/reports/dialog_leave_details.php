<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['type']=='leave_status'){
	if($_GET['leave_opt'] == 'Approved'){
		$leave = $this->Reports_model->get_pending_leave_list($_GET['employee_id'],2);
	} else if($_GET['leave_opt'] == 'Pending'){
		$leave = $this->Reports_model->get_pending_leave_list($_GET['employee_id'],1);
	} else if($_GET['leave_opt'] == 'Upcoming'){
		$leave = $this->Reports_model->get_pending_leave_list($_GET['employee_id'],4);
	} else if($_GET['leave_opt'] == 'Rejected'){
		$leave = $this->Reports_model->get_pending_leave_list($_GET['employee_id'],3);
	}
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $_GET['leave_opt'].' '.$this->lang->line('xin_leave_detail');?></h4>
</div>
<form class="m-b-1">
<div class="modal-body" >
  <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_leave_type');?></th>
              <th><?php echo $this->lang->line('xin_e_details_frm_date');?></th>
              <th><?php echo $this->lang->line('dashboard_xin_end_date');?></th>
              <th><?php echo $this->lang->line('xin_leave_reason');?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($leave->result() as $r) { ?>
          <?php
		  // get leave type
			$leave_type = $this->Timesheet_model->read_leave_type_information($r->leave_type_id);
			if(!is_null($leave_type)){
				$type_name = $leave_type[0]->type_name;
			} else {
				$type_name = '--';	
			}
			$from_date = $this->Xin_model->set_date_format($r->from_date);
			$end_date = $this->Xin_model->set_date_format($r->to_date);
			?>
              <tr role="row" class="odd">
                <td class="sorting_1"><?php echo $type_name;?></td>
                <td><?php echo $from_date;?></td>
                <td><?php echo $end_date;?></td>
                <td><?php echo $r->reason;?></td>
              </tr>
           <?php } ?>   
          </tbody>
        </table>
      </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php echo form_close(); ?>
<?php } ?>
