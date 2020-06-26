<?php
/* Accounting > Transfer Report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <?php $attributes = array('name' => 'report_accounting', 'id' => 'hrm-form', 'autocomplete' => 'off');?>
		<?php $hidden = array('re_user_id' => $session['user_id']);?>
        <?php echo form_open('admin/accounting/report_accounting', $attributes, $hidden);?>
        <?php
			$data = array(
			  'name'        => 'user_id',
			  'id'          => 'user_id',
			  'type'        => 'hidden',
			  'value' => $session['user_id'],
			  'class'       => 'form-control',
			);
			
			echo form_input($data);
			?>
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $session['user_id'];?>">  
          <div class="form-row">
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
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_acc_transfer_report');?></strong></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('xin_description');?></th>
            <th><?php echo $this->lang->line('xin_acc_account');?></th>
            <th><?php echo $this->lang->line('xin_acc_credit');?>/<?php echo $this->lang->line('xin_acc_debit');?></th>
            <th><?php echo $this->lang->line('xin_acc_debit');?></th>
            <th><?php echo $this->lang->line('xin_acc_credit');?></th>
          </tr>
        </thead>
        <tfoot id="get_footer">
        </tfoot>
      </table>
    </div>
  </div>
</div>
