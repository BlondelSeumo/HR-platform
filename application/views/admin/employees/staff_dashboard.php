<?php
/* Employees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php
// reports to 
$reports_to = get_reports_team_data($session['user_id']); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('422',$role_resources_ids) && $user_info[0]->user_role_id==1) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employees/staff_dashboard/');?>" data-link-data="<?php echo site_url('admin/employees/staff_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon ion ion-md-speedometer"></span> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('hr_staff_dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_staff_dashboard_title');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('13',$role_resources_ids) || $reports_to>0) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employees/');?>" data-link-data="<?php echo site_url('admin/employees/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('dashboard_employees');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('dashboard_employees');?></div>
      </a> </li>
    <?php } ?>
    <?php if($user_info[0]->user_role_id==1) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/roles/');?>" class="mb-3 nav-link hrsale-link" data-link-data="<?php echo site_url('admin/roles/');?>"> <span class="sw-icon ion ion-md-unlock"></span> <?php echo $this->lang->line('xin_role_urole');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_set_roles');?></div>
      </a> </li>
     <?php } ?>
    <?php if(in_array('7',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/office_shift/');?>" data-link-data="<?php echo site_url('admin/timesheet/office_shift/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_office_shifts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('left_office_shifts');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('13',$role_resources_ids) || in_array('36',$role_resources_ids) || in_array('14',$role_resources_ids) || in_array('46',$role_resources_ids)) { ?>
<div class="row">
  <?php if(in_array('13',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-contacts display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('dashboard_employees');?></div>
            <div class="text-large"><?php echo $this->Employees_model->get_total_employees();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
  <?php if(in_array('36',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-calculator display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('dashboard_total_salaries');?></div>
            <div class="text-large"><?php echo $this->Xin_model->currency_sign(total_salaries_paid());?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
  <?php if(in_array('14',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-trophy display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('left_awards');?></div>
            <div class="text-large"><?php echo $this->Exin_model->total_employee_awards_dash();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
  <?php if(in_array('46',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-calendar display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_leave_request');?></div>
            <div class="text-large"><?php echo employee_request_leaves();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
</div>
<?php  } ?>
<?php if(in_array('7',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
<div class="row">
<?php if(in_array('7',$role_resources_ids)) { ?>
  <div class="col-xl-6 col-md-6 align-items-strdetch"> 
    <!-- Daily progress chart -->
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('left_office_shifts');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7','#66456e','#b26fc2','#a98852','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e');?>
                  <?php $j=0;foreach(hrsale_office_shift() as $hr_office_shift) { ?>
                  <?php
                    $condition = "office_shift_id =" . "'" . $hr_office_shift->office_shift_id . "'";
                    $this->db->select('*');
                    $this->db->from('xin_employees');
                    $this->db->where($condition);
                    $query = $this->db->get();
                    $r_row = $query->num_rows();
                    ?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($hr_office_shift->shift_name);?> (<?php echo $r_row;?>)</td>
                  </tr>
                  <?php $j++; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div style="height:120px;">
            <canvas id="hrsale_office_shifts"  style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
  <?php if($user_info[0]->user_role_id==1) { ?>
  <div class="col-xl-6 col-md-6 align-items-strdetch"> 
    
    <!-- Daily progress chart -->
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('xin_roles');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color = array('#66456e','#b26fc2','#a98852','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e');?>
                  <?php $j=0;foreach(hrsale_roles() as $hr_roles) { ?>
                  <?php
                    $condition = "user_role_id =" . "'" . $hr_roles->role_id . "'";
                    $this->db->select('*');
                    $this->db->from('xin_employees');
                    $this->db->where($condition);
                    $query = $this->db->get();
                    $r_row = $query->num_rows();
                    ?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($hr_roles->role_name);?> (<?php echo $r_row;?>)</td>
                  </tr>
                  <?php $j++; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div style="height:120px;">
            <canvas id="hrsale_roles"  style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
</div>
<?php  } ?>
 <?php if(in_array('13',$role_resources_ids) || in_array('13',$role_resources_ids) || in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids)) { ?>
<?php
	$current_month = date('Y-m-d');
	$working = $this->Xin_model->current_month_day_attendance($current_month);
	$query = $this->Xin_model->all_employees_status();
	$total = $query->num_rows();
	// absent
	$abs = $total - $working;
	?>
<?php
	$emp_abs = $abs / $total * 100;
	$emp_work = $working / $total * 100;
	?>
<?php
	$emp_abs = $abs / $total * 100;
	$emp_work = $working / $total * 100;
	?>
<div class="row">
  <div class="d-flex col-xl-12 align-items-stretch"> 
    <!-- Stats + Links -->
    <div class="card d-flex w-100 mb-4">
      <div class="row no-gutters row-bordered h-100">
        <?php if(in_array('13',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-md-close display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->set_percentage($emp_abs);?>%</span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_hrsale_absent_today');?></small> </span> </a> </div>
          <?php  } ?>
          <?php if(in_array('13',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-md-checkbox-outline display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->set_percentage($emp_work);?>%</span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_hrsale_present_today');?></small> </span> </a> </div>
          <?php  } ?>
          <?php if(in_array('44',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
          <?php $completed_proj = $this->Project_model->complete_projects();?>
          <?php $proj = $this->Xin_model->get_all_projects();
            if($proj < 1) {
                $proj_percnt = 0;
            } else {
                $proj_percnt = $completed_proj / $proj * 100;
            }
            ?>
          <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-logo-buffer display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->set_percentage($proj_percnt);?>%</span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_hrsale_project_status');?></small> </span> </a> </div>
          <?php  } ?>
          <?php if(in_array('45',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
          <?php $completed_tasks = completed_tasks();?>
          <?php $task_all = $this->Xin_model->get_all_tasks();
            if($task_all < 1) {
                $task_percnt = 0;
            } else {
                $task_percnt = $completed_tasks / $task_all * 100;
            }
            ?>
          <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="lnr lnr-database display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->set_percentage($task_percnt);?>%</span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_hrsale_task_status');?></small> </span> </a> </div>
          <?php  } ?>
      </div>
    </div>
    <!-- / Stats + Links --> 
  </div>
</div>
<?php  } ?>
<?php if(in_array('13',$role_resources_ids)) { ?>
<div class="row">
<?php if(in_array('13',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('xin_employee_location_txt');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color3 = array('#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                  <?php $lj=0;foreach($this->Xin_model->all_locations() as $location) { ?>
                  <?php
						$lcondition = "location_id =" . "'" . $location->location_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($lcondition);
						$lquery = $this->db->get();
						// check if department available
						if ($lquery->num_rows() > 0) {
					?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color3[$lj];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($location->location_name);?> (<?php echo $lquery->num_rows();?>)</td>
                  </tr>
                  <?php $lj++; } ?>
                  <?php  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="employee_location"  style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
  <?php if(in_array('13',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('xin_employee_company_txt');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color4 = array('#975df3','#001f3f','#39cccc','#3c8dbc','#006400','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                  <?php $ck=0;foreach($this->Xin_model->all_companies_dash() as $ecompany) { ?>
                  <?php
						$conditione = "company_id =" . "'" . $ecompany->company_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($conditione);
						$cquery1 = $this->db->get();
						// check if department available
						if ($cquery1->num_rows() > 0) {
					?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color4[$ck];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($ecompany->name);?> (<?php echo $cquery1->num_rows();?>)</td>
                  </tr>
                  <?php $ck++; } ?>
                  <?php  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="employee_company" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
</div>
<?php  } ?>
