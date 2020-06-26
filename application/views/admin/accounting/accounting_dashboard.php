<?php
/*
* Accounting View
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('286',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/accounting/accounting_dashboard/');?>" data-link-data="<?php echo site_url('admin/accounting/accounting_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('xin_hr_finance');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_accounting_dashboard_title');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('72',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/bank_cash/');?>" data-link-data="<?php echo site_url('admin/accounting/bank_cash/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-ios-cash"></span> <?php echo $this->lang->line('xin_acc_account_list');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_accounts');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('75',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/deposit/');?>" data-link-data="<?php echo site_url('admin/accounting/deposit/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-usd"></span> <?php echo $this->lang->line('xin_acc_deposit');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_deposit');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('76',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/expense/');?>" data-link-data="<?php echo site_url('admin/accounting/expense/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-money-check-alt"></span> <?php echo $this->lang->line('xin_acc_expense');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_expense');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('77',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/transfer/');?>" data-link-data="<?php echo site_url('admin/accounting/transfer/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-swap"></span> <?php echo $this->lang->line('xin_acc_transfer');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_transfer_funds');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('78',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/accounting/transactions/');?>" data-link-data="<?php echo site_url('admin/accounting/transactions/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-cube"></span> <?php echo $this->lang->line('xin_acc_transactions');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view_all');?> <?php echo $this->lang->line('xin_acc_transactions');?></div>
      </a> </li>
    <?php } ?>  
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('75',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('80',$role_resources_ids) || in_array('81',$role_resources_ids)) { ?>
<div class="row">
  <div class="d-flex col-xl-12 align-items-stretch"> 
    
    <!-- Stats + Links -->
    <div class="card d-flex w-100 mb-4">
      <div class="row no-gutters row-bordered h-100">
        <?php if(in_array('75',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-logo-usd display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->currency_sign(dashboard_total_sales());?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_total_deposit');?></small> </span> </a> </div>
        <?php } ?>
		<?php if(in_array('76',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-cash display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $this->Xin_model->currency_sign(dashboard_total_expense());?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_total_expenses');?></small> </span> </a> </div>
        <?php } ?>
		<?php if(in_array('80',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-person-add display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo dashboard_total_payees();?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_total_payees');?></small> </span> </a> </div>
        <?php } ?>
		<?php if(in_array('81',$role_resources_ids)) { ?>
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-ios-person display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo dashboard_total_payers();?></span><br>
          <small class="text-muted"><?php echo $this->lang->line('xin_total_payers');?></small> </span> </a> </div>
        <?php } ?>  
      </div>
    </div>
    <!-- / Stats + Links --> 
  </div>
</div>
<?php } ?>
<?php if(in_array('121',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('75',$role_resources_ids)) { ?>
<div class="row">
<?php if(in_array('121',$role_resources_ids)) { ?>
  <div class="col-md-8">
    <div class="card mb-4">
      <h6 class="card-header with-elements mb-2">
        <div class="card-header-title"><?php echo $this->lang->line('xin_invoices_summary');?></div>
        <div class="card-header-elements ml-auto"> <a href="<?php echo site_url('admin/invoices/');?>">
          <button type="button" class="btn btn-default btn-xs md-btn-flat"><?php echo $this->lang->line('dashboard_show_more');?></button>
          </a> </div>
      </h6>
      <div class="row">
        <div class="col-xs-6 col-md-6 text-center">
          <input type="text" class="knob" value="<?php echo dashboard_unpaid_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#f96868" data-readonly="true">
          <div class="knob-label"><?php echo $this->lang->line('xin_payroll_unpaid');?></div>
        </div>
        <!-- ./col -->
        <div class="col-xs-6 col-md-6 text-center">
          <input type="text" class="knob" value="<?php echo dashboard_paid_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#46be8a" data-readonly="true">
          <div class="knob-label"><?php echo $this->lang->line('xin_payment_paid');?></div>
        </div>
        <!-- ./col --> 
      </div>
      <div class="table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_invoice_no');?></th>
              <th width="130px;"><?php echo $this->lang->line('xin_project');?></th>
              <th width="100px;"><?php echo $this->lang->line('xin_amount');?></th>
              <th><?php echo $this->lang->line('xin_invoice_date');?></th>
              <th><?php echo $this->lang->line('xin_invoice_due_date');?></th>
              <th width="80px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach(dashboard_last_two_invoices() as $linvoices){?>
            <?php
				// get project
                  $project = $this->Project_model->read_project_information($linvoices->project_id); 
                  if(!is_null($project)){
                    $project_name = $project[0]->title;
                  } else {
                      $project_name = '--';	
                  }
				// get grand_total
			 	$grand_total = $this->Xin_model->currency_sign($linvoices->grand_total);
				$invoice_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($linvoices->invoice_date);
			  	$invoice_due_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($linvoices->invoice_due_date);
				if($linvoices->status == 0){
					$status = '<span class="badge badge-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
				} else if($linvoices->status == 1) {
					$status = '<span class="badge badge-success">'.$this->lang->line('xin_payment_paid').'</span>';
				} else {
					$status = '<span class="badge badge-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
				}
			?>
            <tr>
              <td><a href="<?php echo site_url('admin/invoices/view/');?><?php echo $linvoices->invoice_id;?>" target="_blank"> <?php echo $linvoices->invoice_number;?> </a></td>
              <td><?php echo $project_name;?></td>
              <td class="amount"><?php echo $grand_total;?></td>
              <td><?php echo $invoice_date;?></td>
              <td><?php echo $invoice_due_date;?></td>
              <td><?php echo $status;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- / stats --> 
    
  </div>
  <?php } ?>
  <?php if(in_array('76',$role_resources_ids) && in_array('75',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <h6 class="card-header with-elements">
        <div class="card-header-title"><?php echo $this->lang->line('xin_deposit_vs_expense');?></div>
      </h6>
      <div class="card-body pb-0">
        <div class="row">
          <div class="col-md-12">
            <div class="my-1" style="height: 140px;">
              <canvas id="hrsale_expense_deposit" width="460" height="146" style="display: block; height: 117px; width: 368px;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-center py-3">
        <div class="row">
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('xin_total_deposit');?></div>
            <strong class="text-big"><?php echo $this->Xin_model->currency_sign(dashboard_total_sales());?></strong> </div>
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('xin_total_expenses');?></div>
            <strong class="text-big"><?php echo $this->Xin_model->currency_sign(dashboard_total_expense());?></strong> </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>
