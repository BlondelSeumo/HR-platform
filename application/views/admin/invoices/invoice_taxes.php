<?php
/* Catalog > Product Tax view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('121',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/');?>" data-link-data="<?php echo site_url('admin/invoices/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-file-invoice-dollar"></span> <?php echo $this->lang->line('xin_invoices_title');?>
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
    <li class="nav-item active"> <a href="<?php echo site_url('admin/invoices/taxes/');?>" data-link-data="<?php echo site_url('admin/invoices/taxes/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('xin_invoice_tax_type');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_invoice_tax_type');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php if(in_array('331',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_title_tax');?></span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_tax', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/invoices/add_tax', $attributes, $hidden);?>
        <div class="form-group">
          <label for="tax_name"><?php echo $this->lang->line('xin_title_tax_name');?></label>
          <input type="text" class="form-control" name="tax_name" placeholder="<?php echo $this->lang->line('xin_title_tax_name');?>">
        </div>
        <div class="form-group">
          <label for="tax_rate"><?php echo $this->lang->line('xin_title_tax_rate');?></label>
          <input type="text" class="form-control" name="tax_rate" placeholder="<?php echo $this->lang->line('xin_title_tax_rate');?>">
        </div>
        <div class="form-group">
          <label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>
          <select class="form-control" name="tax_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_invoice_tax_type');?>">
            <option value=""></option>
            <option value="fixed"><?php echo $this->lang->line('xin_title_tax_fixed');?></option>
            <option value="percentage"><?php echo $this->lang->line('xin_title_tax_percent');?></option>
          </select>
        </div>
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control" placeholder="Description<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
        </div>
        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_title_taxes');?></span> </div>
      <div class="card-body">
        <div class="card-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_title_tax_name');?></th>
                <th><?php echo $this->lang->line('xin_title_tax_rate');?></th>
                <th><?php echo $this->lang->line('xin_invoice_tax_type');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <!-- responsive --> 
    </div>
  </div>
</div>
