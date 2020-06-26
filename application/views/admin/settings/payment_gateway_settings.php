<?php
/* Payment Gateway Settings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row match-heights">
  <div class="col-lg-8 col-md-8 current-tab <?php echo $get_animate;?>" id="general"  aria-expanded="false">
    <?php $attributes = array('name' => 'payment_gateway', 'id' => 'payment_gateway', 'autocomplete' => 'off');?>
    <?php $hidden = array('u_company_info' => 'UPDATE');?>
    <?php echo form_open('admin/settings/update_payment_gateway/996633', $attributes, $hidden);?>
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_payment_gateway_info');?></h3>
      </div>
      <div class="box-body">
        <div class="card-block">
          <legend><?php echo $this->lang->line('xin_acc_paypal_info');?></legend>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="paypal_email"><?php echo $this->lang->line('xin_acc_paypal_email');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_paypal_email');?>" name="paypal_email" type="text" value="<?php echo $paypal_email;?>">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="paypal_sandbox_active"><?php echo $this->lang->line('xin_acc_paypal_sandbox_active');?></label>
                    <select class="form-control" name="paypal_sandbox" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('paypal_sandbox_active');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="yes" <?php if($paypal_sandbox =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_yes');?></option>
                      <option value="no" <?php if($paypal_sandbox =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_no');?></option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="paypal_active"><?php echo $this->lang->line('xin_employees_active');?></label>
                    <select class="form-control" name="paypal_active" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_employees_active');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="yes" <?php if($paypal_active =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_yes');?></option>
                      <option value="no" <?php if($paypal_active =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_no');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="paypal_ipn_url"><?php echo $this->lang->line('xin_acc_paypal_ipn_url');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_paypal_ipn_url');?>" name="paypal_ipn_url" type="text" value="<?php echo site_url('admin/gateway/paypal_process/paypal_ipn');?>" readonly="readonly">
              </div>
            </div>
          </div>
          <legend><?php echo $this->lang->line('xin_acc_stripe_info');?></legend>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="stripe_secret_key"><?php echo $this->lang->line('xin_acc_stripe_secret_key');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_stripe_secret_key');?>" name="stripe_secret_key" type="text" value="<?php echo $stripe_secret_key;?>">
              </div>
              <div class="form-group">
                <label for="paypal_ipn_url"><?php echo $this->lang->line('xin_acc_stripe_publlished_key');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_stripe_publlished_key');?>" name="stripe_publishable_key" type="text" value="<?php echo $stripe_publishable_key;?>">
              </div>
              <div class="form-group">
                <label for="stripe_active"><?php echo $this->lang->line('xin_employees_active');?></label>
                <select class="form-control" name="stripe_active" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_employees_active');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <option value="yes" <?php if($stripe_active =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_yes');?></option>
                  <option value="no" <?php if($stripe_active =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_no');?></option>
                </select>
              </div>
            </div>
          </div>
          <legend><?php echo $this->lang->line('xin_acc_online_payment_receive_account');?></legend>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="stripe_active"><?php echo $this->lang->line('xin_acc_account');?></label>
                <select name="bank_cash_id" id="select2-demo-6" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
                  <option value=""></option>
                  <?php foreach($all_bank_cash as $bank_cash) {?>
                  <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($online_payment_account == $bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->account_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
