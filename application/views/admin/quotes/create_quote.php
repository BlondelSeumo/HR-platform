<?php
// Create Invoice Page
$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_create_quote');?></strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_quote', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/quotes/create_new_quote', $attributes, $hidden);?>
            <?php $inv_info = last_client_invoice_info(); $linv = $inv_info + 1;?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="quote_number"><?php echo $this->lang->line('xin_title_quote_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_title_quote_number');?>" name="quote_number" type="text" value="Q-<?php echo '000'.$linv;?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($all_companies as $company) {?>
                      <?php if($this->input->get("c") == $company->company_id):?>
                          <option value="<?php echo $company->company_id?>" <?php if($this->input->get("c") == $company->company_id):?> selected="selected"<?php endif;?>><?php echo $company->name?></option>
                          <?php endif;?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php $c_clients = $this->Xin_model->get_company_clients($this->input->get("c"))?>
                <div class="col-md-3">
                    <div class="form-group">
                      <label for="client_id"><?php echo $this->lang->line('xin_project_client');?></label>
                      <select name="client_id" id="aj_client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_client');?>">
                        <option value=""></option>
                        <?php foreach($c_clients as $client) {?>
                        <?php $clientInfo = $this->Clients_model->read_client_info($client->client_id);?>
                        <?php if(!is_null($clientInfo)):?>
                        <option value="<?php echo $clientInfo[0]->client_id;?>"> <?php echo $clientInfo[0]->name;?></option>
                        <?php endif;?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group" id="project_ajax">
                      <label for="project"><?php echo $this->lang->line('xin_project');?></label>
                      <select disabled="disabled" class="form-control" name="project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="quote_date"><?php echo $this->lang->line('xin_quote_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_quote_date');?>" readonly="readonly" name="quote_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="quote_due_date"><?php echo $this->lang->line('xin_invoice_due_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_invoice_due_date');?>" readonly="readonly" name="quote_due_date" type="text" value="">
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
                            <div class="row item-row">
                              <div class="form-group mb-1 col-sm-12 col-md-3">
                                <label for="item_name"><?php echo $this->lang->line('xin_title_item');?></label>
                                <br>
                                <input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Item Name">
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>
                                <br>
                                <select class="form-control tax_type" name="tax_type[]" id="tax_type">
                                  <?php foreach($all_taxes as $_tax){?>
                                  <?php
										if($_tax->type=='percentage') {
											$_tax_type = $_tax->rate.'%';
										} else {
											$_tax_type = $this->Xin_model->company_currency_sign($_tax->rate,$this->input->get("c"));
										}
									?>
                                  <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>"> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="xin_title_tax_rate"><?php echo $this->lang->line('xin_title_tax_rate');?></label>
                                <br>
                                <input type="text" readonly="readonly" class="form-control tax-rate-item" name="tax_rate_item[]" value="0" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_title_qty_hrs');?></label>
                                <br>
                                <input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">
                              </div>
                              <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                <label for="unit_price"><?php echo $this->lang->line('xin_title_unit_price');?></label>
                                <br>
                                <input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="profession"><?php echo $this->lang->line('xin_title_sub_total');?></label>
                                <input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />
                                <!-- <br>-->
                                <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
                              </div>
                              <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
                                <label for="profession">&nbsp;</label>
                                <br>
                                <button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button>
                              </div>
                            </div>
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
					   $company_info = $this->Company_model->read_company_information($this->input->get("c"));
						if(!is_null($company_info)){
							$default_currency = $company_info[0]->default_currency;
							$ar_sc = explode('- ',$default_currency);
							$sc_show = $ar_sc[1];	
						} else {
							$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
							$sc_show = $ar_sc[1];	
						}
						
						?>
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="0" />
                      <input type="hidden" class="items-tax-total" name="items_tax_total" value="0" />
                      <div class="row">
                        <div class="col-md-7 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-5 col-sm-12">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td><?php echo $this->lang->line('xin_title_sub_total2');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="sub_total">0</span></td>
                                </tr>
                                <tr>
                                  <td><?php echo $this->lang->line('xin_title_tax_c');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="tax_total">0</span></td>
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
                                                <option value="1"> <?php echo $this->lang->line('xin_flat');?></option>
                                                <option value="2"> <?php echo $this->lang->line('xin_percent');?></option>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" name="discount_figure" class="form-control discount_figure" value="0" data-valid-num="required">
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="discount_amount" value="0" class="discount_amount form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" name="fgrand_total" value="0" />
                              <tr>
                                <td><?php echo $this->lang->line('xin_grand_total');?></td>
                                <td class="text-xs-right"><?php echo $sc_show;?> <span class="grand_total">0</span></td>
                              </tr>
                                </tbody>
                              
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="quote_note"><?php echo $this->lang->line('xin_quote_note');?></label>
                          <textarea name="quote_note" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12">
                      <h6>Terms &amp; Condition</h6> 
                      <p><?php echo $system_setting[0]->estimate_terms_condition;?></p>
                    </div>
                    <div class="col-md-5 col-sm-12 text-xs-center">
                      <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_submit_estimates');?></button>
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
