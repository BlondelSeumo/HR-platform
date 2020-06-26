<?php
/* Accounting > Expense Report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'report_accounting', 'id' => 'hrm-form', 'autocomplete' => 'off');?>
		<?php $hidden = array('re_user_id' => $session['user_id']);?>
        <?php echo form_open('admin/accounting/report_accounting', $attributes, $hidden);?>
        <?php
            $data = array(
              'name'        => 'user_id',
              'id'          => 'user_id',
              'type'        => 'hidden',
              'value'	   => $session['user_id'],
              'class'       => 'form-control',
            );
        
        echo form_input($data);
        ?> 
          <div class="form-row">
          <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
                <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
            <?php } else {?>
            <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" required name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value="0"><?php echo $this->lang->line('module_company_title');?></option>
                <?php foreach($all_companies as $company) {?>
                <?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php endif;?>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
            <div class="col-md mb-3">
            <div class="form-group" id="expense_type_ajax">
              <label class="form-label"><?php echo $this->lang->line('xin_acc_select_expense_type');?></label>
              <select name="type_id" id="type_id" class="form-control" required data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_select_expense_type');?>">
                <option value="0"><?php echo $this->lang->line('xin_acc_all_types');?></option>
                <?php foreach($all_expense_types as $expense_type) {?>
                <option value="<?php echo $expense_type->expense_type_id;?>"> <?php echo $expense_type->name;?></option>
                <?php } ?>
              </select>
               </div>   
            </div>
            <div class="col-md-3">
                <div class="form-group">
                  <label for="designation"><?php echo $this->lang->line('xin_e_details_frm_date');?></label>
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_frm_date');?>" readonly id="from_date" name="from_date" type="text" value="<?php echo date('Y-m-d')?>">
                </div>
              </div>  
              <div class="col-md-3">
                <div class="form-group">
                  <label for="designation"><?php echo $this->lang->line('xin_e_details_to_date');?></label>
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_to_date');?>" readonly id="to_date" name="to_date" type="text" value="<?php echo date('Y-m-d')?>">
                </div>
              </div>       
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card <?php echo $get_animate;?>">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_acc_expense_reports');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_e_details_date');?></th>
                <th><?php echo $this->lang->line('xin_acc_account');?></th>
                <th><?php echo $this->lang->line('xin_acc_category');?></th>
                <th><?php echo $this->lang->line('xin_acc_payee');?></th>
                <th><?php echo $this->lang->line('xin_amount');?></th>
              </tr>
            </thead>
            <tfoot id="get_footer">
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>    
