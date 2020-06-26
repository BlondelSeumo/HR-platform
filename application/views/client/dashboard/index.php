<?php $session = $this->session->userdata('client_username'); ?>
<?php $clientinfo = $this->Clients_model->read_client_info($session['client_id']); ?>

<h4 class="font-weight-bold pys-3 mb-4"> <?php echo $this->lang->line('xin_title_wcb');?>, <?php echo $clientinfo[0]->name;?>!
  <div class="text-muted text-tiny mt-1"><small class="font-weight-normal"><?php echo $this->lang->line('xin_title_today_is');?> <?php echo date('l, j F Y');?></small></div>
</h4>
<div class="row">
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-cart display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_invoice_paid_client');?></div>
            <div class="text-large"><?php echo clients_invoice_paid_count($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-earth display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_invoice_unpaid_client');?></div>
            <div class="text-large"><?php echo clients_invoice_unpaid_count($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/projects/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_completed').' '.$this->lang->line('xin_project');?></div>
            <div class="text-large"><?php echo clients_project_completed($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/payroll/generate_payslip');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-users display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_in_progress').' '.$this->lang->line('xin_project');?></div>
            <div class="text-large"><?php echo clients_project_inprogress($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
</div>
<div class="row">
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-cart display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_paid_amount');?></div>
            <div class="text-large"><?php echo $this->Xin_model->currency_sign(clients_invoice_paid_amount($session['client_id']));?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-earth display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_invoice_due_amount');?></div>
            <div class="text-large"><?php echo $this->Xin_model->currency_sign(clients_invoice_unpaid_amount($session['client_id']));?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/projects/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_not_started').' '.$this->lang->line('xin_project');?></div>
            <div class="text-large"><?php echo clients_project_notstarted($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/payroll/generate_payslip');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-users display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_deffered').' '.$this->lang->line('xin_project');?></div>
            <div class="text-large"><?php echo clients_project_deffered($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
</div>
<div class="row"> 
  <!-- Left col -->
  <div class="col-md-6"> 
    <!-- TABLE: LATEST ORDERS -->
    <div class="card box-info">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('dashboard_my_projects');?></strong></span> </div>
      <!-- /.box-header -->
      <div class="card-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_project_summary');?></th>
                <th><?php echo $this->lang->line('xin_p_priority');?></th>
                <th><?php echo $this->lang->line('xin_p_enddate');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($this->Xin_model->last_five_client_projects($session['client_id']) as $_project) {?>
              <?php
                    if($_project->priority == 1) {
                    	$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_highest').'</span>';
                    } else if($_project->priority ==2){
                    	$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_high').'</span>';
                    } else if($_project->priority ==3){
                    	$priority = '<span class="badge badge-primary">'.$this->lang->line('xin_normal').'</span>';
                    } else {
                    	$priority = '<span class="badge badge-success">'.$this->lang->line('xin_low').'</span>';
                    }
                    	$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($_project->end_date);
					//project_progress
					if($_project->project_progress <= 20) {
						$progress_class = 'progress-danger';
					} else if($_project->project_progress > 20 && $_project->project_progress <= 50){
						$progress_class = 'progress-warning';
					} else if($_project->project_progress > 50 && $_project->project_progress <= 75){
						$progress_class = 'progress-info';
					} else {
						$progress_class = 'progress-success';
					}
					// progress
				$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$_project->project_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$_project->project_progress.'" max="100">'.$_project->project_progress.'%</progress>';
                    ?>
              <tr>
                <td><a href="<?php echo site_url().'client/projects/detail/'.$_project->project_id;?>"><?php echo $_project->title;?></a></td>
                <td><?php echo $priority;?></td>
                <td><?php echo $pdate;?></td>
                <td><?php echo $pbar;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive --> 
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix"> <a href="<?php echo site_url('client/projects/');?>" class="btn btn-sm btn-info btn-flat pull-left"><?php echo $this->lang->line('dashboard_my_projects');?></a> </div>
      <!-- /.box-footer --> 
    </div>
    <!-- /.box --> 
  </div>
  <div class="col-md-6"> 
    <!-- TABLE: LATEST ORDERS -->
    <div class="card box-info">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_invoices_title');?></span> </div>
      <!-- /.box-header -->
      <div class="card-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th>Invoice#
                  <?php //echo $this->lang->line('xin_client_name');?></th>
                <th><?php echo $this->lang->line('xin_project');?></th>
                <th>Total
                  <?php //echo $this->lang->line('xin_email');?></th>
                <th>Invoice Date
                  <?php //echo $this->lang->line('xin_website');?></th>
                <th>Due Date
                  <?php //echo $this->lang->line('xin_city');?></th>
                <th>Status
                  <?php //echo $this->lang->line('xin_country');?></th>
              </tr>
            </thead>
            <tbody>
              <?php //$client = last_five_client_invoices_info($session['client_id']);?>
              <?php foreach($this->Invoices_model->last_five_client_invoices($session['client_id']) as $r) {?>
              <?php
                // get country
                $grand_total = $this->Xin_model->currency_sign($r->grand_total);
                // get project
                $project = $this->Project_model->read_project_information($r->project_id); 
                if(!is_null($project)){
                $project_name = $project[0]->title;
                } else {
                $project_name = '--';
                }
                // if($project[0]->client_id==$session['client_id']) {
                
                $invoice_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_date);
                $invoice_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_due_date);
                //invoice_number
                $invoice_number = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$r->invoice_number.'</a>';
                if($r->status == 0){
                $istatus = $this->lang->line('xin_payroll_unpaid');
                } else {
                $istatus = $this->lang->line('xin_payment_paid');
                }
                ?>
              <tr>
                <td><?php echo $invoice_number;?></td>
                <td><?php echo $project_name;?></td>
                <td><?php echo $grand_total;?></td>
                <td><?php echo $invoice_date;?></td>
                <td><?php echo $invoice_due_date;?></td>
                <td><?php echo $istatus;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive --> 
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix"> <a href="<?php echo site_url('client/invoices/');?>" class="btn btn-sm btn-info btn-flat pull-left"><?php echo $this->lang->line('xin_invoices_all');?></a> </div>
      <!-- /.box-footer --> 
    </div>
    <!-- /.box --> 
  </div>
  <!-- /.col --> 
</div>
<style type="text/css">
.box-body {
    padding: 0 !important;
}
.info-box-number {
	font-size:16px !important;
	font-weight:300 !important;
}
</style>
