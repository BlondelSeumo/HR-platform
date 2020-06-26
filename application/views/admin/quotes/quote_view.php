<?php
/* Quote view
*/
?>
<?php $session = $this->session->userdata('username');?>
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
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php if($this->session->flashdata('response')):?>
<div class="callout callout-success">
<p><?php echo $this->session->flashdata('response');?></p>
</div>
<?php endif;?>

<div class="card">
<?php $quote_convert_record = $this->Quotes_model->read_quote_converted_info($quote_id);?>
    <?php if ($quote_convert_record < 1) { ?>
<div class="card-header with-elements"> <span class="card-header-title mr-2">&nbsp;</span>
      <div class="card-header-elements ml-md-auto">
      <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary waves-effect waves-light"  data-toggle="modal" data-target=".view-modal-data"  data-quote_id="<?php echo $quote_id; ?>"><span class="fa fa-exchange"></span> <?php echo $this->lang->line('xin_quote_convert_project');?></a>
      <a href="<?php echo site_url('admin/quotes/edit/'.$quote_id);?>" class="btn btn-outline-primary btn-sm waves-effect waves-light"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('xin_edit');?></a>
      </div>
    </div>
   <?php } ?> 
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
        <span style="text-transform:uppercase;"><?php echo $this->lang->line('xin_title_quote_hash');?></span> <?php echo $quote_number;?></h6>
        <div class="mb-1"><?php echo $this->lang->line('xin_e_details_date');?>: <strong class="font-weight-semibold"><?php echo $this->Xin_model->set_date_format($quote_date);?></strong></div>
        <div><?php echo $this->lang->line('xin_payment_due');?>: <strong class="font-weight-semibold"><?php echo $this->Xin_model->set_date_format($quote_due_date);?></strong></div>
        <div>
        <?php $_status = '';
		if($status == 0){
			$_status = '<span class="badge badge-warning">'.$this->lang->line('xin_quoted_title').'</span>';
		} else {
			$_status = '<span class="badge badge-success">'.$this->lang->line('xin_quote_invoiced').'</span>';
		}
		echo $_status;
		?>
        </div>

      </div>
    </div>

    <hr class="mb-4">

    <div class="row">
      <div class="col-sm-6 mb-4">

        <div class="font-weight-bold mb-2"><?php echo $this->lang->line('xin_estimate_to');?>:</div>
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
			$company_info = $this->Company_model->read_company_information($ecompany_id);
			$prod = array(); $i=1; foreach($this->Quotes_model->get_quote_items($quote_id) as $_item):?>
            <?php if(!is_null($company_info)){ ?>
            <tr>
              <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
              <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->company_currency_sign($_item->item_tax_rate,$ecompany_id);?></strong></td>
              <td class="py-3"><strong><?php echo $_item->item_qty;?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->company_currency_sign($_item->item_unit_price,$ecompany_id);?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->company_currency_sign($_item->item_sub_total,$ecompany_id);?></strong></td>
            </tr>
            <?php } else {?>
            <tr>
              <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
              <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></strong></td>
              <td class="py-3"><strong><?php echo $_item->item_qty;?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_unit_price);?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_sub_total);?></strong></td>
            </tr>
            <?php } ?>
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
    <?php if($quote_note != ''):?>
    <div class="text-muted">
      <strong><?php echo $this->lang->line('xin_note');?>:</strong> <?php echo $quote_note;?>
    </div>
   <?php endif;?> 
  </div>
  <div class="card-footer text-right">
    <a href="javascript:void(0);" class="btn btn-default print-invoice"><i class="ion ion-md-print"></i>&nbsp; <?php echo $this->lang->line('xin_print');?></a>
  </div>
</div>
