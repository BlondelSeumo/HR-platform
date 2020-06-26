<?php
// Edit Invoice Page

$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_title_edit_invoice');?> #<?php echo $invoice_number;?></strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_invoice', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/invoices/update_invoice/'.$invoice_id, $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_invoice_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_invoice_number');?>" name="invoice_number" type="text" readonly="readonly" value="<?php echo $invoice_number;?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="project"><?php echo $this->lang->line('xin_project');?></label>
                      <select class="form-control" name="project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
                        <?php foreach($all_projects->result() as $project) {?>
                        <option value="<?php echo $project->project_id?>" <?php if($project->project_id==$project_id):?> selected="selected"<?php endif;?>><?php echo $project->title?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_invoice_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_invoice_date');?>" readonly="readonly" name="invoice_date" type="text" value="<?php echo $invoice_date;?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_invoice_due_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_invoice_due_date');?>" readonly="readonly" name="invoice_due_date" type="text" value="<?php echo $invoice_due_date;?>">
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="hrsale-item-values">
                        <div data-repeater-list="items">
                          <div data-repeater-item="">
                            <?php $prod = array(); foreach($this->Invoices_model->get_invoice_items($invoice_id) as $_item):?>
                            <div class="row item-row">
                              <div class="form-group mb-1 col-sm-12 col-md-3">
                                <input type="hidden" name="item[<?php echo $_item->invoice_item_id;?>]" value="<?php echo $_item->invoice_item_id;?>" />
                                <label for="item_name"><?php echo $this->lang->line('xin_title_item');?></label>
                                <br>
                                <input type="text" class="form-control item_name" name="eitem_name[<?php echo $_item->invoice_item_id;?>]" id="item_name" placeholder="Item Name" value="<?php echo $_item->item_name;?>">
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>
                                <br>
                                <select class="form-control tax_type" name="etax_type[<?php echo $_item->invoice_item_id;?>]" id="tax_type">
                                  <!--<option value="0" tax-type="0" tax-rate="0"><?php echo $this->lang->line('xin_performance_none');?></option>-->
								  <?php foreach($all_taxes as $_tax){?>
                                  <?php
										if($_tax->type=='percentage') {
											$_tax_type = $_tax->rate.'%';
										} else {
											$_tax_type = $this->Xin_model->currency_sign($_tax->rate);
										}
									?>
                                  <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>" <?php if($_item->item_tax_type==$_tax->tax_id):?> selected="selected"<?php endif;?>> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="xin_title_tax_rate"><?php echo $this->lang->line('xin_title_tax_rate');?></label>
                                <br>
                                <input type="text" readonly="readonly" class="form-control tax-rate-item" name="etax_rate_item[<?php echo $_item->invoice_item_id;?>]" value="<?php echo $_item->item_tax_rate;?>" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_title_qty_hrs');?></label>
                                <br>
                                <input type="text" class="form-control qty_hrs" name="eqty_hrs[<?php echo $_item->invoice_item_id;?>]" id="qty_hrs" value="<?php echo $_item->item_qty;?>">
                              </div>
                              <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                <label for="unit_price"><?php echo $this->lang->line('xin_title_unit_price');?></label>
                                <br>
                                <input class="form-control unit_price" type="text" name="eunit_price[<?php echo $_item->invoice_item_id;?>]" value="<?php echo $_item->item_unit_price;?>" id="unit_price" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="profession"><?php echo $this->lang->line('xin_title_sub_total');?></label>
                                <input type="text" class="form-control sub-total-item" readonly="readonly" name="esub_total_item[<?php echo $_item->invoice_item_id;?>]" value="<?php echo $_item->item_sub_total;?>" />
                                <!-- <br>-->
                                <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
                              </div>
                              <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
                                <label for="profession">&nbsp;</label>
                                <br>
                                <button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light eremove-item" data-repeater-delete="" data-record-id="<?php echo $_item->invoice_item_id;?>" data-invoice-id="<?php echo $invoice_id;?>"> <span class="fa fa-trash"></span></button>
                              </div>
                            </div>
                            <?php endforeach;?>
                          </div>
                        </div>
                      </div>
                      <div id="item-list"></div>
                      <div class="form-group overflow-hidden1">
                        <div class="col-xs-12">
                          <button type="button" data-repeater-create="" class="btn btn-primary" id="add-invoice-item"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('xin_title_add_item');?></button>
                        </div>
                      </div>
                      <?php
						$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
						$sc_show = $ar_sc[1];
						?>
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="<?php echo $sub_total_amount;?>" />
                      <input type="hidden" class="items-tax-total" name="items_tax_total" value="<?php echo $total_tax;?>" />
                      <div class="row">
                        <div class="col-md-7 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-5 col-sm-12">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td><?php echo $this->lang->line('xin_title_sub_total2');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="sub_total"><?php echo $sub_total_amount;?></span></td>
                                </tr>
                                <tr>
                                  <td><?php echo $this->lang->line('xin_title_tax_c');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="tax_total"><?php echo $total_tax;?></span></td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left"><table class="table table-bordered">
                                      <tbody>
                                        <tr>
                                          <td width="30%" style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_discount_type');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:center"><strong><?php echo $this->lang->line('xin_discount');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_discount_amount');?></strong></td>
                                        </tr>
                                        <tr>
                                          <td><div class="form-group">
                                              <select name="discount_type" class="form-control discount_type">
                                                <option value="1" <?php if($discount_type==1):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_flat');?></option>
                                                <option value="2" <?php if($discount_type==2):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_percent');?></option>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" name="discount_figure" class="form-control discount_figure" value="<?php echo $discount_figure;?>" data-valid-num="required">
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="discount_amount" value="<?php echo $total_discount;?>" class="discount_amount form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" name="fgrand_total" value="<?php echo $grand_total;?>" />
                              <tr>
                                <td><?php echo $this->lang->line('xin_grand_total');?></td>
                                <td class="text-xs-right"><?php echo $sc_show;?> <span class="grand_total"><?php echo $grand_total;?></span></td>
                              </tr>
                                </tbody>
                              
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="invoice_note"><?php echo $this->lang->line('xin_invoice_note');?></label>
                          <textarea name="invoice_note" class="form-control"><?php echo $invoice_note;?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12">&nbsp;
                    </div>
                    <div class="col-md-5 col-sm-12 text-xs-center">
                      <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_submit_invoice');?></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
