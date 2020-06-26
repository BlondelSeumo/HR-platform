<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('415',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/quotes/');?>" data-link-data="<?php echo site_url('admin/quotes/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fa fa-tasks"></span> <?php echo $this->lang->line('xin_estimates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_create_quote');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('427',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_quote_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_quote_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('429',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/leads/');?>" data-link-data="<?php echo site_url('admin/leads/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_leads');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_leads');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('430',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/timelogs/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('428',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('xin_quoted_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_quoted_projects');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_title_quotes');?></span>
  	  <?php if(in_array('120',$role_resources_ids)) {?>
      <div class="card-header-elements ml-md-auto">
        <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $this->lang->line('xin_create_quote');?></button>
        <ul class="dropdown-menu">
       <?php foreach($all_companies as $company) {?>
        <li><a href="<?php echo site_url('admin/quotes/create/');?>?c=<?php echo $company->company_id;?>"><?php echo $company->name?></a></li>
        <?php }?>
      </ul>
      </div>
      <?php }?>  
    </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_title_quote_hash');?></th>
            <th><?php echo $this->lang->line('xin_project_title');?></th>
            <th><?php echo $this->lang->line('xin_acc_total');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_quote_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_due_date');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
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