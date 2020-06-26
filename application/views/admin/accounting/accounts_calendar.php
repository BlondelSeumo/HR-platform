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

<div class="row">
  <div class="col-md-3">
    <div class="box">
      <div class="box-body">
        <div class="box-header with-border">
          <h4 class="box-title"> <?php echo $this->lang->line('xin_hr_calendar_options');?> </h4>
        </div>
        <input type="hidden" id="exact_date" value="" />
        <div class="list-group">
          <span class="list-group-item calendar-options text-green hrsale-drag-option" data-record="0"> <i class="ion ion-stats-bars"></i> <?php echo $this->lang->line('xin_income');?></span>
              <span class="list-group-item calendar-options text-aqua hrsale-drag-option" data-record="0"> <i class="fa fa-dollar"></i> <?php echo $this->lang->line('left_payroll');?></span>
              <span class="list-group-item calendar-options text-maroon hrsale-drag-option" data-record="0"> <i class="fa fa-trophy"></i> <?php echo $this->lang->line('xin_awards_cash');?></span>
              <span class="list-group-item calendar-options text-light-blue hrsale-drag-option" data-record="0"> <i class="fa fa-plane"></i> <?php echo $this->lang->line('xin_hrsale_travel_expenses');?></span>
              <span class="list-group-item calendar-options text-yellow hrsale-drag-option" data-record="0"> <i class="fa fa-graduation-cap"></i> <?php echo $this->lang->line('xin_training_cost');?></span>
              <span class="list-group-item calendar-options text-purple hrsale-drag-option" data-record="0"> <i class="fa fa-calendar-plus-o"></i> <?php echo $this->lang->line('xin_acc_invoice_payments');?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="box">
      <div class="box-body">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_hr_calendar_options');?> </h3>
        </div>
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>
