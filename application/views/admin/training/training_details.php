<?php
/*
* Training Detail view
*/
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-4 <?php echo $get_animate;?>">
          <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_training_details');?></strong></span> </div>
            <div class="box-body">
              <div class="box-block box-dashboard">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered">
                    <tbody>
                      <tr>
                        <th scope="row" style="border-top: 0px;"><?php echo $this->lang->line('left_training_type');?></th>
                        <td class="text-right"><?php echo $type;?></td>
                      </tr>
                      <?php $user = $this->Xin_model->read_user_info($session['user_id']);
				  		if($user[0]->user_role_id==1){?>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_trainer');?></th>
                        <td class="text-right"><?php echo $trainer_name;?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_training_cost');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->currency_sign($training_cost);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_start_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($start_date);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_end_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($finish_date);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_e_details_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($created_at);?></td>
                      </tr>
                      <?php if($training_status=='2'){?>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('dashboard_xin_status');?></th>
                        <td class="text-right"><?php echo '<span class="badge bg-green">'.$this->lang->line('xin_completed').'</span>';?></td>
                      </tr>
                      <?php }?>
                
                      <?php $count_module_attributes = $this->Custom_fields_model->count_training_module_attributes();?>
						<?php $module_attributes = $this->Custom_fields_model->training_hrsale_module_attributes();?>
                        <?php foreach($module_attributes as $mattribute):?>
                          <?php $attribute_info = $this->Custom_fields_model->get_employee_custom_data($training_id,$mattribute->custom_field_id);?>
                          <?php
                                if(!is_null($attribute_info)){
                                    $attr_val = $attribute_info->attribute_value;
                                } else {
                                    $attr_val = '';
                                }
                            ?>
                            <?php if($mattribute->attribute_type == 'date'){?>
                            <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php echo $attr_val;?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'select'){?>
                          <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php foreach($iselc_val as $selc_val) {?> <?php if($attr_val==$selc_val->attributes_select_value_id):?> <?php echo $selc_val->select_label?> <?php endif;?><?php } ?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'multiselect'){?>
                          <?php $multiselect_values = explode(',',$attr_val);?>
                          <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php foreach($imulti_selc_val as $multi_selc_val) {?> <?php if(in_array($multi_selc_val->attributes_select_value_id,$multiselect_values)):?><br /> <?php echo $multi_selc_val->select_label?> <?php endif;?><?php } ?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'textarea'){?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php echo $attr_val;?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'fileupload'){?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php if($attr_val!='' && $attr_val!='no file') {?>
                              <img src="<?php echo base_url().'uploads/custom_files/'.$attr_val;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('xin_download');?></a>
                              <?php } ?></td>
                          </tr>
                          <?php } else { ?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php echo $attr_val;?></td>
                          </tr>
                          <?php } ?>
                          
                          <?php endforeach;?>
                    </tbody>
                  </table>
                  <?php if($description!='' && $description!='<p><br></p>'):?>
                  <div class="bs-callout-success callout-border-left callout-square callout-transparent mt-1 p-1 ml-2 mr-2"> <?php echo $description;?> </div>
                  <?php endif;?>
                </div>
              </div>
            </div>
          </div>
  </div>
  <div class="col-md-8 <?php echo $get_animate;?>">
          <div class="card">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_details');?></strong></span> </div>
            <div class="card-body">
              <div class="box-block card-dashboard">
                <div class="row">
                <div class="col-md-6">
                  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_training_employees_s');?></strong></span> </div>
                  <div class="media-list" id="all_employees_list">
                  <ul class="list-group list-group-flush">
                    <?php if($employee_id!='') {?>
                    <?php $employee_ids = explode(',',$employee_id); foreach($employee_ids as $assign_id) {?>
                    <?php $e_name = $this->Xin_model->read_user_info($assign_id);?>
                    <?php if(!is_null($e_name)){ ?>
                    <?php $_designation = $this->Designation_model->read_designation_information($e_name[0]->designation_id);?>
                    <?php
						  if(!is_null($_designation)){
							$designation_name = $_designation[0]->designation_name;
						  } else {
							$designation_name = '--';	
						  }
						  ?>
                    <?php
							if($e_name[0]->profile_picture!='' && $e_name[0]->profile_picture!='no file') {
								$u_file = base_url().'uploads/profile/'.$e_name[0]->profile_picture;
							} else {
								if($e_name[0]->gender=='Male') { 
									$u_file = base_url().'uploads/profile/default_male.jpg';
								} else {
									$u_file = base_url().'uploads/profile/default_female.jpg';
								}
							} ?>
                    	<li class="list-group-item" style="border:0px;">
                          <div class="media align-items-center"> <img src="<?php echo $u_file;?>" class="user-image-hr-prj ui-w-30 rounded-circle" alt="">
                            <div class="media-body px-2">
                              <?php if($user[0]->user_role_id==1):?>
                              <a href="<?php echo site_url()?>admin/employees/detail/<?php echo $e_name[0]->user_id;?>" class="text-dark">
                              <?php endif;?>
                              <?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?>
                              <?php if($user[0]->user_role_id==1):?>
                              </a>
                              <?php endif;?>
                              <br>
                              <p class="font-small-2 mb-0 text-muted"><?php echo $designation_name;?></p>
                            </div>
                          </div>
                        </li>
                        <!--<div class="media">
                      <?php if($user[0]->user_role_id==1):?>
                      <a class="media-left" href="<?php echo site_url()?>admin/employees/detail/<?php echo $e_name[0]->user_id;?>">
                      <?php endif;?>
                      <img class="media-object rounded-circle" src="<?php echo $u_file;?>" alt="Generic placeholder image" style="width: 64px;height: 64px;">
                      <?php if($user[0]->user_role_id==1):?>
                      </a>
                      <?php endif;?>
                      <div class="media-body">
                        <h6 class="media-heading"><?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?></h6>
                        <?php echo $designation_name;?> </div>
                    </div>-->
                    <?php } }?>
                    <?php } else { ?>
                    <li class="list-group-item" style="border:0px;">&nbsp;</li>
                    <?php } ?>
                   </ul> 
                  </div>
                </div>
                <?php if($user[0]->user_role_id==1){?>
                
                <?php if($training_status=='2'){?>
                <?php } else {?>
                <div class="col-md-6">
                  <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
				  <?php $hidden = array('user_id' => $session['user_id']);?>
                  <?php echo form_open('admin/training/update_status', $attributes, $hidden);?>
                  <?php
					$data = array(
					  'name'        => 'token_status',
					  'id'          => 'token_status',
					  'type'        => 'hidden',
					  'value'   	   => $training_id,
					  'class'       => 'form-control',
					);
					echo form_input($data);
					?>
                    <div class="card-header with-elements mb-2"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_update_status');?></strong></span> </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="status"><?php echo $this->lang->line('left_performance');?></label>
                              <select class="form-control" name="performance" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_performance');?>">
                                <option value="0" <?php if($performance=='0'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_not_included');?></option>
                                <option value="1" <?php if($performance=='1'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_satisfactory');?></option>
                                <option value="2" <?php if($performance=='2'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_average');?></option>
                                <option value="3" <?php if($performance=='3'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_poor');?></option>
                                <option value="4" <?php if($performance=='4'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_excellent');?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                              <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                                <option value="0" <?php if($training_status=='0'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_pending');?></option>
                                <option value="1" <?php if($training_status=='1'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_started');?></option>
                                <option value="2" <?php if($training_status=='2'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_completed');?></option>
                                <option value="3" <?php if($training_status=='3'):?> selected <?php endif;?>><?php echo $this->lang->line('xin_terminated');?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="status"><?php echo $this->lang->line('xin_remarks');?></label>
                              <textarea class="form-control" name="remarks" rows="4" cols="15" placeholder="<?php echo $this->lang->line('xin_remarks');?>"><?php echo $remarks;?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="form-actions box-footer">
                          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                  <?php echo form_close(); ?>
                  </div>
                  <?php } ?>
                
                <?php } else {?>
                <div class="col-md-6">
                  
                    <input type="hidden" name="_token_status" value="<?php echo $training_id;?>">
                    <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('xin_trainer');?> </h3>
                  </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $trainer_name;?></label>
                        </div>
                      </div>
                    </div>
                  <?php echo form_close(); ?>
                </div>
                <?php } ?>
                <div>&nbsp;</div>
              </div></div>
              <!-- tab --> 
            </div>
          </div>
  </div>
</div>
