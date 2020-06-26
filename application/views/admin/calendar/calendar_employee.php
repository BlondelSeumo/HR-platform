<?php 
$session = $this->session->userdata('username');
$user_info = $this->Exin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php if(in_array('98',$role_resources_ids) || in_array('99',$role_resources_ids) || in_array('8',$role_resources_ids)) { ?>
<div class="row">
  <div class="col-md-12">
    <div class="box mb-4">
      <input type="hidden" id="exact_date" value="" />
      <div class="row">
        <div class="col-md-3">
          <div class="box-body">
            <div class="box-header with-border">
              <h3 class="box-title"> <?php echo $this->lang->line('xin_hr_calendar_options');?> </h3>
            </div>
            <div class="list-group"> 
			<?php if(in_array('8',$role_resources_ids)) { ?>
            <span class="list-group-item calendar-options text-green"> <i class="fa fa-space-shuttle"></i> <?php echo $this->lang->line('left_holidays');?></span>
            <?php } ?>
            <?php if($system[0]->module_events=='true'){?>
              <?php if(in_array('98',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-navy"> <i class="fa fa-calendar-plus-o"></i> <?php echo $this->lang->line('xin_hr_events');?></span>
              <?php } ?>
              <?php if(in_array('99',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-teal"> <i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('xin_hr_meetings');?></span>
              <?php } ?>
            <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="box">
              <div class="box-body">
                <div id='calendar_hr'></div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.calendar-options { padding: .3rem 0.4rem !important;}
</style>
<?php } ?>
