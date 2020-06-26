<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('121',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/invoices/');?>" data-link-data="<?php echo site_url('admin/invoices/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-invoice-dollar"></span> <?php echo $this->lang->line('xin_invoices_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_invoices_title');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('426',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/invoice_calendar/');?>" data-link-data="<?php echo site_url('admin/invoices/invoice_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_invoice_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('330',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/payments_history/');?>" data-link-data="<?php echo site_url('admin/invoices/payments_history/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-invoice"></span> <?php echo $this->lang->line('xin_acc_invoice_payments');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_invoice_payments');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('122',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/taxes/');?>" data-link-data="<?php echo site_url('admin/invoices/taxes/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('xin_invoice_tax_type');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_invoice_tax_type');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-cart display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_invoice_paid_client');?></div>
            <div class="text-large"><?php echo all_invoice_paid_count();?></div>
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
            <div class="text-muted small"><?php echo $this->lang->line('xin_paid_amount');?></div>
            <div class="text-large"><?php echo $this->Xin_model->currency_sign(all_invoice_paid_amount());?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_invoice_unpaid_client');?></div>
            <div class="text-large"><?php echo all_invoice_unpaid_count();?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-users display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_invoice_due_amount');?></div>
            <div class="text-large"><?php echo $this->Xin_model->currency_sign(all_invoice_unpaid_amount());?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
</div>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_invoices_title');?></span>
    <?php if(in_array('120',$role_resources_ids)) {?>
    <div class="card-header-elements ml-md-auto"> <a class="text-dark"href="<?php echo site_url('admin/invoices/create/')?>">
      <button type="button" class="btn btn-xs btn-primary" onclick="window.location='<?php echo site_url('admin/invoices/create/')?>'"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_invoice_create');?></button>
      </a> </div>
    <?php } ?>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_invoice_no');?></th>
            <th><?php echo $this->lang->line('xin_project');?></th>
            <th><?php echo $this->lang->line('xin_acc_total');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_due_date');?></th>
            <th><?php echo $this->lang->line('kpi_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.info-box-number {
	font-size:15px !important;
	font-weight:300 !important;
}
</style>
