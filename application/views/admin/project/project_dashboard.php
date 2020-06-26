<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $project_no = $this->Xin_model->generate_random_string();?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('312',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/project/projects_dashboard/');?>" data-link-data="<?php echo site_url('admin/project/projects_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_overview');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('44',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/');?>" data-link-data="<?php echo site_url('admin/project/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('left_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('left_projects');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('119',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/clients/');?>" data-link-data="<?php echo site_url('admin/clients/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_project_clients');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_clients');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('94',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/timelogs/');?>" data-link-data="<?php echo site_url('admin/project/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('424',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_calendar/');?>" data-link-data="<?php echo site_url('admin/project/projects_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_acc_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('425',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_scrum_board/');?>" data-link-data="<?php echo site_url('admin/project/projects_scrum_board/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('xin_projects_scrm_board');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_projects_scrm_board');?></div>
      </a> </li>
      <?php } ?>
  </ul>
 </div> 
<hr class="border-light m-0 mb-3">
<?php if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids) || in_array('119',$role_resources_ids) || in_array('330',$role_resources_ids)) { ?>
<div class="row">
<div class="d-flex col-xl-12 align-items-stretch"> 
  <!-- Stats + Links -->
  <div class="card d-flex w-100 mb-4">
    <div class="row no-gutters row-bordered h-100">
      <?php if(in_array('44',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-logo-buffer display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_projects();?></span> <?php echo $this->lang->line('left_projects');?></span><br>
        <small class="text-muted"><?php echo total_completed_projects();?> <?php echo $this->lang->line('dashboard_completed');?> </small> </span> </a> </div>
      <?php } ?>
      <?php if(in_array('45',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="lnr lnr-database display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_tasks();?></span> <?php echo $this->lang->line('left_tasks');?></span><br>
        <small class="text-muted"><?php echo total_completed_tasks();?> <?php echo $this->lang->line('dashboard_completed');?> </small> </span> </a> </div>
      <?php } ?>
      <?php if(in_array('119',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-person-add display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_clients();?></span></span><br>
        <small class="text-muted"><?php echo $this->lang->line('xin_project_clients');?></small> </span> </a> </div>
      <?php } ?>
      <?php if(in_array('330',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-cash display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo $this->Xin_model->currency_sign(total_invoices_paid());?></span></span><br>
        <small class="text-muted"><?php echo $this->lang->line('xin_acc_invoice_payments');?></small> </span> </a> </div>
        <?php } ?>
    </div>
  </div>
  <!-- / Stats + Links --> 
</div>
</div>
<?php } ?>
<?php if(in_array('121',$role_resources_ids) || in_array('415',$role_resources_ids) || in_array('428',$role_resources_ids) || in_array('410',$role_resources_ids)) { ?>
<div class="row">
<div class="d-flex col-xl-12 align-items-stretch"> 
  
  <!-- Stats + Links -->
  <div class="card d-flex w-100 mb-4">
	<div class="row no-gutters row-bordered h-100">
	  <?php if(in_array('121',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-paper display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_invoices();?></span> <?php echo $this->lang->line('xin_invoices_title');?></span><br>
		<small class="text-muted"><?php echo total_paid_invoices();?> <?php echo $this->lang->line('xin_payment_paid');?></small> </span> </a> </div>
	  <?php } ?>
	  <?php if(in_array('415',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-md-reorder display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_estimate();?></span> <?php echo $this->lang->line('xin_title_quotes');?></span><br>
		<small class="text-muted"><?php echo total_estimate_converted();?> <?php echo $this->lang->line('xin_quote_converted_project');?></small> </span> </a> </div>
	  <?php } ?>
	  <?php if(in_array('428',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-list-box display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_quoted_projects();?></span></span><br>
		<small class="text-muted"><?php echo $this->lang->line('xin_quoted_projects');?></small> </span> </a> </div>
	  <?php } ?>
	  <?php if(in_array('410',$role_resources_ids)) { ?>
      <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-people display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_leads();?></span></span><br>
		<small class="text-muted"><?php echo $this->lang->line('xin_leads');?></small> </span> </a> </div>
      <?php } ?>
	</div>
  </div>
  <!-- / Stats + Links --> 
</div>
</div>
<?php } ?>
<?php if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids) || in_array('119',$role_resources_ids) || in_array('410',$role_resources_ids)) { ?>
<div class="row">
<?php if(in_array('44',$role_resources_ids)) { ?>
<div class="col-md-4">
  <div class="card mb-4">
	<h6 class="card-header with-elements border-0 pr-0 pb-0">
	  <div class="card-header-title"><?php echo $this->lang->line('xin_projects_status');?></div>
	</h6>
	<div class="row">
	  <div class="col-md-6">
		<div id="overflow-scrolls" class="py-2 px-3" style="overflow:auto; height:200px;">
		  <div class="table-responsive">
			<table class="table mb-0 table-dashboard">
			  <tbody>
				<?php $dc_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');?>
				<?php $dj=0;$projects = get_projects_status(); foreach($projects->result() as $eproject) { ?>
				<?php
				$row = total_projects_status($eproject->status);
				if($eproject->status==0){
					$csname = htmlspecialchars_decode($this->lang->line('xin_not_started'));
				} else if($eproject->status==1){
					$csname = htmlspecialchars_decode($this->lang->line('xin_in_progress'));
				} else if($eproject->status==2){
					$csname = htmlspecialchars_decode($this->lang->line('xin_completed'));
				} else if($eproject->status==3){
					$csname = htmlspecialchars_decode($this->lang->line('xin_project_cancelled'));
				} else if($eproject->status==4){
					$csname = htmlspecialchars_decode($this->lang->line('xin_project_hold'));
				}
			?>
				<tr>
				  <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $dc_color[$dj];?>;"></div></td>
				  <td><?php echo htmlspecialchars_decode($csname);?> (<?php echo $row;?>)</td>
				</tr>
				<?php $dj++; } ?>
				<?php  ?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	  <div class="col-md-5">
		<div style="height:120px;">
		  <canvas id="hrsale_chart_projects"  style="display: block; height: 150px; width:300px;"></canvas>
		</div>
	  </div>
	</div>
  </div>
</div>
<?php } ?>
<?php if(in_array('119',$role_resources_ids) && in_array('410',$role_resources_ids)) { ?>
<div class="col-sm-4 col-xl-4">
  <div class="card mb-4">
	<h6 class="card-header with-elements border-0 pr-0 pb-0">
	  <div class="card-header-title"><?php echo $this->lang->line('xin_clients_leads_status');?></div>
	</h6>
	<div class="row">
	  <div class="col-md-6">
		<div id="overflow-scrolls2" class="py-2 px-3" style="overflow:auto; height:200px;">
		  <div class="table-responsive">
			<table class="table mb-0 table-dashboard">
			  <tbody>
				<tr>
				  <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #647c8a;"></div></td>
				  <td><?php echo $this->lang->line('xin_project_clients');?> (<?php echo total_clients();?>)</td>
				</tr>
				<tr>
				  <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #2196f3;"></div></td>
				  <td><?php echo $this->lang->line('xin_leads');?> (<?php echo total_leads();?>)</td>
				</tr>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	  <div class="col-md-5">
		<div style="height:120px;">
		  <canvas id="hrsale_clients_leads" style="display: block; height: 150px; width:300px;"></canvas>
		</div>
	  </div>
	</div>
  </div>
</div>
<?php } ?>
<?php if(in_array('45',$role_resources_ids)) { ?>
<div class="col-md-4">
  <div class="card mb-4">
	<h6 class="card-header with-elements border-0 pr-0 pb-0">
	  <div class="card-header-title"><?php echo $this->lang->line('xin_tasks_status');?></div>
	</h6>
	<div class="row">
	  <div class="col-md-6">
		<div class="overflow-scrolls py-2 px-3" style="overflow:auto; height:200px;">
		  <div class="table-responsive">
			<table class="table mb-0 table-dashboard">
			  <tbody>
				<?php $dc_color = array('#3c8dbc','#006400','#dd4b39','#a98852','#f39c12','#605ca8');?>
				<?php $sj=0;$tasks = get_tasks_status(); foreach($tasks->result() as $etask) { ?>
				<?php
				$trow = total_projects_status($etask->task_status);
				if($etask->task_status==0){
					$sname = htmlspecialchars_decode($this->lang->line('xin_not_started'));
				} else if($etask->task_status==1){
					$sname = htmlspecialchars_decode($this->lang->line('xin_in_progress'));
				} else if($etask->task_status==2){
					$sname = htmlspecialchars_decode($this->lang->line('xin_completed'));
				} else if($etask->task_status==3){
					$sname = htmlspecialchars_decode($this->lang->line('xin_project_cancelled'));
				} else if($etask->task_status==4){
					$sname = htmlspecialchars_decode($this->lang->line('xin_project_hold'));
				}	
			?>
				<tr>
				  <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $dc_color[$sj];?>;"></div></td>
				  <td><?php echo htmlspecialchars_decode($sname);?> (<?php echo $trow;?>)</td>
				</tr>
				<?php $sj++; } ?>
				<?php  ?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	  <div class="col-md-5">
		<div style="height:120px;">
		  <canvas id="hrsale_tasks" style="display: block; height: 150px; width:300px;"></canvas>
		</div>
	  </div>
	</div>
  </div>
</div>
<?php } ?>
</div>
<?php } ?>