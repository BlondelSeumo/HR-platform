<?php
/*
* Languages - View Page
*/
$session = $this->session->userdata('username');
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('25',$role_resources_ids)) {?>
    <li class="nav-item active">
      <a href="<?php echo site_url('admin/assets/');?>" data-link-data="<?php echo site_url('admin/assets/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon ion ion-md-today"></span>
        <?php echo $this->lang->line('xin_assets');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_assets');?></div>
      </a>
    </li>
    <?php } ?>
    <?php if(in_array('26',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/assets/category/');?>" data-link-data="<?php echo site_url('admin/assets/category/');?>" class="mb-3 nav-link hrsale-link">
        <span class="sw-icon fab fa-typo3"></span>
        <?php echo $this->lang->line('xin_acc_category');?>
        <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('xin_acc_category');?></div>
      </a>
    </li>
   <?php } ?>
  </ul>
 </div> 
  <hr class="border-light m-0 mb-3">
  
<div class="row m-b-1 animated fadeInRight">
<?php if(in_array('266',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_acc_category');?></span>
            </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_asset_category', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/assets/add_category', $attributes, $hidden);?>
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_name');?></label>
          <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_name');?>">
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_categories');?></span>
            </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_name');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
