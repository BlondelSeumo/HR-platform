<?php
/*
* Payers - Accounting View
*/
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php  if(in_array('80',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/accounting/payees/');?>" data-link-data="<?php echo site_url('admin/accounting/payees/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_acc_payees');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_acc_payees');?></div>
      </a> </li>
      <?php } ?>
    <?php  if(in_array('81',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/accounting/payers/');?>" data-link-data="<?php echo site_url('admin/accounting/payers/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-plus"></span> <?php echo $this->lang->line('xin_acc_payers');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_acc_payers');?></div>
      </a> </li>
     <?php } ?> 
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
<?php if(in_array('367',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_payer');?></span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_payer', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/accounting/add_payer', $attributes, $hidden);?>
        <div class="form-group">
          <label for="account_name"><?php echo $this->lang->line('xin_acc_payer');?></label>
          <input type="text" class="form-control" name="payer_name" placeholder="<?php echo $this->lang->line('xin_acc_payer_name');?>">
        </div>
        <div class="form-group">
          <label for="account_balance"><?php echo $this->lang->line('xin_contact_number');?></label>
          <input type="text" class="form-control" name="contact_number" placeholder="<?php echo $this->lang->line('xin_contact_number');?>">
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_acc_payers');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_acc_payer');?></th>
                <th><?php echo $this->lang->line('xin_contact_number');?></th>
                <th><?php echo $this->lang->line('xin_acc_created_at');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
