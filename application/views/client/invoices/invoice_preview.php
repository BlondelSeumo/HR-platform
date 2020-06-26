<?php
/* Invoice view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
<?php $system_setting = $this->Xin_model->read_setting_info(1);?>
<?php
$client_name = $name;
$client_contact_number = $contact_number;
$client_company_name = $client_company_name;
$client_website_url = $website_url;
$client_address_1 = $address_1;
$client_address_2 = $address_2;
//$client_country = $countryid;
$client_city = $city;
$client_zipcode = $zipcode;
$country = $this->Xin_model->read_country_info($countryid);
if(!is_null($country)){
$client_country = $country[0]->country_name;
} else {
$client_country = '--';	
}
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $inv_record = get_invoice_transaction_record($invoice_id);?>
<div class="card">    
<div class="card-header with-elements"> <span class="card-header-title mr-2">&nbsp;</span>
<?php if ($inv_record->num_rows() > 0) { ?>
      <div class="card-header-elements ml-md-auto">
      <button type="button" id="print-invoice" class="btn btn-vk btn-sm print-invoice"><i class="fa fa-print" aria-hidden="true"></i> <?php echo $this->lang->line('xin_print');?></button>
      </div>
      <?php } ?>
    </div>
   
  <div class="card-body p-5" id="print_invoice_hr">
    <div class="row">
      <div class="col-sm-6 pb-4">

        <div class="media align-items-center mb-2">
          <div class="media-body text-big font-weight-bold ml-1">
            <?php echo $company_name;?>
          </div>
        </div>

        <div class="mb-0"><?php echo $company_address;?></div>
        <div class="mb-0"><?php echo $company_zipcode;?>, <?php echo $company_city;?>, <?php echo $company_country;?></div>
        <div><?php echo $this->lang->line('xin_phone');?>: <?php echo $company_phone;?></div>
        <div><strong>Attn:</strong> <?php echo $name;?></div>
        <div><strong><?php echo $this->lang->line('xin_project');?>:</strong> <?php echo $project_name;?></div>
      </div>

      <div class="col-sm-6 text-right pb-4">

        <h6 class="text-big text-large font-weight-bold mb-3">
        <span style="text-transform:uppercase;"><?php echo $this->lang->line('xin_invoice_no');?></span> <?php echo $invoice_number;?></h6>
        <div class="mb-1"><?php echo $this->lang->line('xin_e_details_date');?>: <strong class="font-weight-semibold"><?php echo $this->Xin_model->set_date_format($invoice_date);?></strong></div>
        <div><?php echo $this->lang->line('xin_payment_due');?>: <strong class="font-weight-semibold"><?php echo $this->Xin_model->set_date_format($invoice_due_date);?></strong></div>
        <div>
        <?php
		if($status == 0){
			$_status = '<span class="badge badge-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
		} else if($status == 1) {
			$_status = '<span class="badge badge-success">'.$this->lang->line('xin_payment_paid').'</span>';
		} else {
			$_status = '<span class="badge badge-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
		}
		echo $_status;
		?>
        </div>
        <?php if ($inv_record->num_rows() < 1) { ?>
        <div>
          <h6><span>Invoice Total:</span> <?php echo $this->Xin_model->currency_sign($grand_total);?></h6>
          <?php $attributes = array('name' => 'add_item', 'id' => 'xin-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('invoice_id' => $invoice_id, 'token' => $invoice_id);?>
          <?php echo form_open('client/gateway/pay', $attributes, $hidden);?>
          <select name="gateway" id="gateway" class="form-control select-gateway" style="width: 120px; display:inline-block;">
            <option value="paypal">Paypal</option>
            <option value="stripe">Stripe</option>
          </select>
          <button type="submit" style="margin-top:-2px" class="btn btn-info"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_pay_now');?></button>
          <?php echo form_close(); ?><br />
        </div>
        <?php } ?>

      </div>
    </div>

    <hr class="mb-4">

    <div class="row">
      <div class="col-sm-6 mb-4">

        <div class="font-weight-bold mb-2"><?php echo $this->lang->line('xin_invoice_to');?>:</div>
        <div><?php echo $client_name;?></div>
        <div><?php echo $client_company_name;?></div>
        <div><?php echo $client_address_1.' '.$client_address_2.' '.$client_city;?></div>
        <div><?php echo $client_contact_number;?></div>
        <div><?php echo $email;?></div>

      </div>
      <div class="col-sm-6 mb-4">

        <div class="font-weight-bold mb-2"><?php echo $this->lang->line('xin_payment_details');?>:</div>
        <table>
          <tbody>
            <tr>
              <td class="pr-3"><?php echo $this->lang->line('xin_total_due');?>:</td>
              <td><strong><?php echo $this->Xin_model->currency_sign($grand_total);?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="table-responsive mb-4">
      <table class="table m-0">
        <thead>
          <tr>
              <th class="py-3"> # </th>
              <th class="py-3" width="300px"> <?php echo $this->lang->line('xin_title_item');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_tax_rate');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_qty_hrs');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_unit_price');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_sub_total');?> </th>
            </tr>
        </thead>
        <tbody>
          <?php
			$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[1];
			?>
            <?php $prod = array(); $i=1; foreach($this->Invoices_model->get_invoice_items($invoice_id) as $_item):?>
            <tr>
              <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
              <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></strong></td>
              <td class="py-3"><strong><?php echo $_item->item_qty;?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_unit_price);?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_sub_total);?></strong></td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="5" class="text-right py-3">
                  Subtotal:<br>
                  Tax:<br>
                  Discount:<br>
                  <span class="d-block text-big mt-2">Total:</span>
                </td>
                <td class="py-3">
                  <strong><?php echo $this->Xin_model->currency_sign($sub_total_amount);?></strong><br>
                  <strong><?php echo $this->Xin_model->currency_sign($total_tax);?></strong><br>
                  <strong><?php echo $this->Xin_model->currency_sign($total_discount);?></strong><br>
                  <strong class="d-block text-big mt-2"><?php echo $this->Xin_model->currency_sign($grand_total);?></strong>
                </td>
              </tr>
        </tbody>
      </table>
    </div>
    <?php if($invoice_note != ''):?>
    <div class="text-muted">
      <strong><?php echo $this->lang->line('xin_note');?>:</strong> <?php echo $invoice_note;?>
    </div>
   <?php endif;?> 
  </div>
</div>