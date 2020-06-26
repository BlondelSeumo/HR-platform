<?php
/*
* Languages - View Page
*/
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_language');?></span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_language', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/languages/add_language', $attributes, $hidden);?>
        <div class="form-group">
          <label for="account_name"><?php echo $this->lang->line('xin_name');?></label>
          <input type="text" class="form-control" name="language_name" placeholder="<?php echo $this->lang->line('xin_name');?>">
        </div>
        <div class="form-group">
          <label for="account_balance"><?php echo $this->lang->line('xin_code');?></label>
          <input type="text" class="form-control" name="language_code" placeholder="<?php echo $this->lang->line('xin_code');?>">
        </div>
        <div class="form-group">
          <fieldset class="form-group">
            <label for="logo"><?php echo $this->lang->line('xin_flag');?></label>
            <input type="file" class="form-control-file" id="language_flag" name="language_flag">
            <small><?php echo $this->lang->line('xin_error_flag_allow_files');?></small>
          </fieldset>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8 <?php echo $get_animate;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_languages');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_name');?></th>
                <th><?php echo $this->lang->line('xin_code');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
