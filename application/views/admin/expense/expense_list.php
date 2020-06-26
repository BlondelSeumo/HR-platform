<?php
/* Expense view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('310',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_expense');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_expense', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/expense/add_expense', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="expense_type"><?php echo $this->lang->line('xin_expense_type');?></label>
                <select name="expense_type" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_expense_type');?>...">
                  <option value=""></option>
                  <?php foreach($all_expense_types as $expense_type) {?>
                  <option value="<?php echo $expense_type->expense_type_id;?>"><?php echo $expense_type->name;?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="purchase_date"><?php echo $this->lang->line('xin_purchase_date');?></label>
                    <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_purchase_date');?>" readonly name="purchase_date" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount"><?php echo $this->lang->line('xin_amount');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="number" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group" id="employee_ajax">
                    <label for="gift"><?php echo $this->lang->line('xin_purchased_by');?></label>
                    <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="add_billycopy_fields"></div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
                <textarea class="form-control textarea" name="remarks" cols="25" rows="5" id="description"></textarea>
              </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_bill_copy');?></label>
                      <input type="file" class="form-control-file" id="bill_copy" name="bill_copy">
                      <small><?php echo $this->lang->line('xin_expense_allow_files');?></small>
                    </fieldset>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions box-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_expenses');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="110"><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_expense');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><i class="fa fa-dollar"></i> <?php echo $this->lang->line('xin_amount');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_purchase_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
