<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<h4 class="font-weight-bold pys-3 mb-4"> <?php echo $this->lang->line('xin_title_wcb');?>, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!
  <div class="text-muted text-tiny mt-1"><small class="font-weight-normal"><?php echo $this->lang->line('xin_title_today_is');?> <?php echo date('l, j F Y');?></small></div>
</h4>
<?php if(in_array('13',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('46',$role_resources_ids) || in_array('36',$role_resources_ids)) { ?>
<div class="row">
 <?php if(in_array('13',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/employees');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-contacts display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_people');?></div>
            <div class="text-large"><?php echo $this->Employees_model->get_total_employees();?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
  <?php if(in_array('76',$role_resources_ids)) { ?>  
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/accounting/expense/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-cash display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_total_expenses');?></div>
            <div class="text-large"><?php echo $this->Xin_model->currency_sign(dashboard_total_expense());?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
  <?php if(in_array('46',$role_resources_ids)) { ?>  
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/timesheet/leave');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-calendar display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_attendance_total_leave');?></div>
            <div class="text-large"><?php echo employee_request_leaves();?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
  <?php if(in_array('36',$role_resources_ids)) { ?>  
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/payroll/generate_payslip');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-calculator display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('dashboard_total_salaries');?></div>
            <div class="text-large"><?php echo $this->Xin_model->currency_sign(total_salaries_paid());?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
</div>
<?php } ?>
<?php if(in_array('36',$role_resources_ids)) { ?>
<div class="card mb-4">
  <h6 class="card-header with-elements">
    <div class="card-header-title"><?php echo $this->lang->line('left_payroll');?></div>
    <div class="card-header-elements ml-auto"> <a href="<?php echo site_url('admin/payroll/generate_payslip');?>">
      <button type="button" class="btn btn-default btn-xs md-btn-flat"><?php echo $this->lang->line('dashboard_show_more');?></button>
      </a> </div>
  </h6>
  <div class="row no-gutters row-bordered">
    <div class="col-md-8 col-lg-12 col-xl-8">
      <div class="card-body">
        <div style="height: 210px;">
          <canvas id="hrsale_payroll" style="display: block; height: 210px; width: 754px;" width="942" height="262"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-lg-12 col-xl-4">
      <div class="card-body"> 
        
        <!-- Numbers -->
        <div class="row">
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_attendance_this_month');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_payroll_this_month());?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_6_month');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_payroll_last_6_month());?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_1_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_payroll_last_1year());?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_2_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_payroll_last_2years());?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_3_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrsale_payroll_last_3years());?></span> </div>
        </div>
        <!-- / Numbers --> 
        
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if(in_array('3',$role_resources_ids) || in_array('4',$role_resources_ids)) { ?>
<div class="row">
<?php if(in_array('3',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('xin_employee_department_txt');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div id="overflow-scrolls" class="overflow-scrolls py-4 px-3 " style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color = array('#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                  <?php $j=0;foreach($this->Department_model->all_departments() as $department) { ?>
                  <?php
						$condition = "department_id =" . "'" . $department->department_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($condition);
						$query = $this->db->get();
						// check if department available
						if ($query->num_rows() > 0) {
					?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($department->department_name);?> (<?php echo $query->num_rows();?>)</td>
                  </tr>
                  <?php $j++; } ?>
                  <?php  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:150px;">
            <canvas id="employee_department" height="250" width="270" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
  <?php if(in_array('4',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('xin_employee_designation_txt');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div id="overflow-scrolls2" class="py-4 px-3 " style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color2 = array('#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                  <?php $k=0;foreach($this->Designation_model->all_designations() as $designation) { ?>
                  <?php
						$condition1 = "designation_id =" . "'" . $designation->designation_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($condition1);
						$query1 = $this->db->get();
						// check if department available
						if ($query1->num_rows() > 0) {
					?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color2[$k];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($designation->designation_name);?> (<?php echo $query1->num_rows();?>)</td>
                  </tr>
                  <?php $k++; } ?>
                  <?php  } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:150px;">
            <canvas id="employee_designation" height="250" width="270" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
</div>
<?php  } ?>
<?php if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('330',$role_resources_ids)) { ?>
<div class="row">
  <div class="d-flex col-xl-12 align-items-stretch"> 
    <!-- Stats + Links -->
    <div class="card d-flex w-100 mb-4">
      <div class="row no-gutters row-bordered h-100">
        
        <?php if(in_array('44',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-logo-buffer display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_completed_projects();?></span> <?php echo $this->lang->line('left_projects');?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('dashboard_completed');?></small> </span> </a> </div>
          <?php  } ?>
          <?php if(in_array('45',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="fab fa-fantasy-flight-games display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"><span class="font-weight-bolder"><?php echo total_completed_tasks();?></span> <?php echo $this->lang->line('left_tasks');?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('dashboard_completed');?></small> </span> </a> </div>
          <?php  } ?>
          <?php if(in_array('75',$role_resources_ids)) { ?>
          <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-logo-usd display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->currency_sign(dashboard_total_sales());?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_total_deposit');?></small> </span> </a> </div>
          <?php  } ?>
          <?php if(in_array('330',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-paper display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->currency_sign(total_invoices_paid());?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_acc_invoice_payments');?></small> </span> </a> </div>
        <?php  } ?>
      </div>
    </div>
    <!-- / Stats + Links --> 
  </div>
</div>
<?php  } ?>
<?php if(in_array('44',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('13',$role_resources_ids)) { ?>
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
  <!-- Charts -->
  <?php if(in_array('44',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body pb-0">
        <div class="small">
          <div class="btn-group">
            <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $this->lang->line('xin_projects_status');?></button>
            <div class="dropdown-menu">
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
              <a class="dropdown-item" href="javascript:void(0)"><span class="" style="background-color:<?php echo $dc_color[$dj];?>; padding-left:6px; padding-right:6px;">&nbsp;</span> <span><?php echo htmlspecialchars_decode($csname);?> (<?php echo $row;?>)</span></a>
              <?php $dj++; } ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="my-1" style="height: 116px;">
              <canvas id="hrsale_chart_projects" width="460" height="146" style="display: block; height: 117px; width: 368px;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer"> <?php echo $this->lang->line('xin_projects_status');?> </div>
    </div>
  </div>
  <?php  } ?>
  <?php if(in_array('76',$role_resources_ids) && in_array('75',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body pb-0">
        <div class="small">
          <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $this->lang->line('xin_deposit_vs_expense');?></button>
          <div class="dropdown-menu">
            <?php $dc_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');?>
            <a class="dropdown-item" href="javascript:void(0)"><span class="" style="background-color:#647c8a; padding-left:6px; padding-right:6px;">&nbsp;</span> <span><?php echo $this->lang->line('xin_total_deposit');?></span></a> <a class="dropdown-item" href="javascript:void(0)"><span class="" style="background-color:#2196f3; padding-left:6px; padding-right:6px;">&nbsp;</span> <span><?php echo $this->lang->line('xin_total_expenses');?></span></a> </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="my-1" style="height: 116px;">
              <canvas id="hrsale_expense_deposit" width="460" height="146" style="display: block; height: 117px; width: 368px;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer"> <?php echo $this->lang->line('xin_deposit_vs_expense');?> </div>
    </div>
  </div>
  <?php  } ?>
  <?php if(in_array('13',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-4">
    <div class="card pt-2 mb-4">
      <div class="d-flex align-items-center position-relative mt-4" style="height:51px;">
        <div class="w-100 position-absolute" style="height:110px;top:0;"> </div>
        <div class="w-100 text-center text-large"><?php echo $this->Employees_model->get_total_employees();?></div>
      </div>
      <div class="text-center pb-2 my-3"> <?php echo $this->lang->line('xin_people');?> </div>
      <div class="card-footer text-center py-3">
        <div class="row">
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('xin_absent');?></div>
            <strong class="text-big"><?php echo $this->Xin_model->set_percentage($emp_abs);?>%</strong> </div>
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('xin_emp_working');?></div>
            <strong class="text-big"><?php echo $this->Xin_model->set_percentage($emp_work);?>%</strong> </div>
        </div>
      </div>
    </div>
  </div>
  <?php  } ?>
</div>
<?php  } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<?php endif; ?>