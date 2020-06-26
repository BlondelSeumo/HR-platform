<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['performance_appraisal_id']) && $_GET['data']=='appraisal'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_performance_appraisal');?></h4>
</div>
<?php $attributes = array('name' => 'edit_appraisal', 'id' => 'edit_appraisal', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $performance_appraisal_id, 'ext_name' => $performance_appraisal_id);?>
<?php echo form_open('admin/performance_appraisal/update/'.$performance_appraisal_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="row">
            <div class="col-md-12">
              <?php if($user_info[0]->user_role_id==1){ ?>
              <div class="row">
                <div class="col-md-3 control-label">
                  <div class="form-group">
                    <label for="employee"><?php echo $this->lang->line('left_company');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <?php } else {?>
              <?php $ecompany_id = $user_info[0]->company_id;?>
              <div class="row">
                <div class="col-md-3 control-label">
                  <div class="form-group">
                    <label for="employee"><?php echo $this->lang->line('left_company');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
						  <?php if($ecompany_id == $company->company_id):?>
                          <option value="<?php echo $company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>><?php echo $company->name?></option>
                          <?php endif;?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="row">
                <div class="col-md-3 control-label">
                  <div class="form-group">
                    <label for="employee"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                    <input type="hidden" name="emp_id" value="<?php echo $employee_id;?>">
                    <input type="hidden" name="cur_date" value="<?php echo $appraisal_year_month;?>">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group" id="employee_ajx">
                   <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
                    <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" name="employee_id" id="employee_id">
                      <option value=""></option>
                      <?php foreach($result as $employee) {?>
                      <option value="<?php echo $employee->user_id;?>" <?php if($employee_id==$employee->user_id):?> selected="selected" <?php endif;?>><?php echo $employee->first_name.' '.$employee->last_name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 control-label">
                  <div class="form-group">
                    <label for="month_year"><?php echo $this->lang->line('xin_select_month');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <input class="form-control e_month_year" placeholder="<?php echo $this->lang->line('xin_select_month');?>" readonly id="month_year" name="month_year" type="text" value="<?php echo $appraisal_year_month;?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row m-b-1">
          <div class="col-md-6">
            <div class="box bg-white">
              <table class="table table-grey-head m-md-b-0">
                <thead>
                  <tr>
                    <th colspan="5"><?php echo $this->lang->line('xin_performance_technical_competencies');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2"><?php echo $this->lang->line('xin_indicator');?></th>
                    <th><?php echo $this->lang->line('xin_set_value');?></th>
                  </tr>
                  
                  <?php $itechnical_competencies = explode(',',$system[0]->technical_competencies);?>
				  <?php foreach($itechnical_competencies as $ikey=>$itech_comp):?>
                  <?php $performance_app = $this->Performance_appraisal_model->read_appraisal_technical_options($ikey,$performance_appraisal_id);
				  if(!is_null($performance_app)){
						$tperf_val  =  $performance_app[0]->appraisal_option_value;
					} else {
						$tperf_val  = 'A';
					}
					?>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $itech_comp;?></td>
                    <td><select name="technical_competencies_value[]" class="form-control">
                        <option value="0" <?php if($tperf_val==0):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_performance_none');?></option>
                        <option value="1" <?php if($tperf_val==1):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                        <option value="2" <?php if($tperf_val==2):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                        <option value="3" <?php if($tperf_val==3):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                        <option value="4" <?php if($tperf_val==4):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                      </select></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box bg-white">
              <table class="table table-grey-head m-md-b-0">
                <thead>
                  <tr>
                    <th colspan="5"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2"><?php echo $this->lang->line('xin_indicator');?></th>
                    <th><?php echo $this->lang->line('xin_set_value');?></th>
                  </tr>
                  <?php $iorganizational_competencies = explode(',',$system[0]->organizational_competencies);?>
				  <?php foreach($iorganizational_competencies as $okey=>$iorg_comp):?>
                  <?php $operformance_app = $this->Performance_appraisal_model->read_appraisal_organizational_options($okey,$performance_appraisal_id);
				  	if(!is_null($operformance_app)){
						$perf_val  =  $operformance_app[0]->appraisal_option_value;
					} else {
						$perf_val  = 'A';
					}
					
				  ?>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $iorg_comp;?></td>
                    <td><select name="organizational_competencies_value[]" class="form-control">
                        <option value="5" <?php if($perf_val==5):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_performance_none');?></option>
                        <option value="6" <?php if($perf_val==6):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                        <option value="7" <?php if($perf_val==7):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                        <option value="8" <?php if($perf_val==8):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      </select></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="m-b-1">
        <div class="col-md-12">
          <div class="bg-white">
            <div class="form-group">
              <label for="remarks"><?php echo $this->lang->line('xin_remarks');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" cols="30" rows="5" id="remarks2"><?php echo $remarks;?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
						
		// Month & Year
		$('.e_month_year').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1970:' + new Date().getFullYear(),
		beforeShow: function(input) {
			$(input).datepicker("widget").addClass('hide-calendar');
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(year, month, 1));
			$(this).datepicker('widget').removeClass('hide-calendar');
			$(this).datepicker('widget').hide();
		}
			
		});	 
		 Ladda.bind('button[type=submit]');
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
		});
		$('#remarks2').trumbowyg();
		
		/* Edit data */
		$("#edit_appraisal").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=appraisal&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/performance_appraisal/appraisal_list") ?>",
							type : 'GET'
						},
						dom: 'lBfrtip',
						"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['performance_appraisal_id']) && $_GET['data']=='view_appraisal' && $_GET['type']=='view_appraisal'){
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_performance_appraisal');?></h4>
</div>
<div class="modal-body">
  <div class="row m-b-1">
    <div class="col-md-12">
      <div class="bg-white">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="employee"><?php echo $this->lang->line('left_company');?>: </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
				<?php foreach($get_all_companies as $company) {?>
                <?php if($company_id==$company->company_id):?>
                <?php echo $company->name;?>
                <?php endif;?>
                <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="employee"><?php echo $this->lang->line('dashboard_single_employee');?>: </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <?php foreach($all_employees as $employee) {?>
                  <?php if($employee_id==$employee->user_id):?>
                  <?php echo $employee->first_name.' '.$employee->last_name;?>
                  <?php endif; } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="month_year"><?php echo $this->lang->line('xin_performance_app_date');?>: </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group"> <?php echo date("F, Y", strtotime($appraisal_year_month));?> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-b-1">
        <div class="col-md-6">
          <div class="box bg-white">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="table table-grey-head m-md-b-0">
                <thead>
                  <tr>
                    <th colspan="5"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2"><?php echo $this->lang->line('xin_indicator');?></th>
                    <th><?php echo $this->lang->line('xin_set_value');?></th>
                  </tr>
                  <?php $itechnical_competencies = explode(',',$system[0]->technical_competencies);?>
				  <?php foreach($itechnical_competencies as $ikey=>$itech_comp):?>
                  <?php $performance_app = $this->Performance_appraisal_model->read_appraisal_technical_options($ikey,$performance_appraisal_id);
				  if(!is_null($performance_app)){
						$tperf_val  =  $performance_app[0]->appraisal_option_value;
					} else {
						$tperf_val  = 'A';
					}
					?>
                    <tr>
                    <td scope="row" colspan="2"><?php echo $itech_comp;?></td>
                    <td><?php if($tperf_val==0):?>
                      <?php echo $this->lang->line('xin_performance_none');?>
                      <?php elseif($tperf_val==1):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($tperf_val==2):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($tperf_val==3):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($tperf_val==3):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box bg-white">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="table table-grey-head m-md-b-0">
                <thead>
                  <tr>
                    <th colspan="5"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2"><?php echo $this->lang->line('xin_indicator');?></th>
                    <th><?php echo $this->lang->line('xin_set_value');?></th>
                  </tr>
                  <?php $iorganizational_competencies = explode(',',$system[0]->organizational_competencies);?>
				  <?php foreach($iorganizational_competencies as $okey=>$iorg_comp):?>
                  <?php $operformance_app = $this->Performance_appraisal_model->read_appraisal_organizational_options($okey,$performance_appraisal_id);
				  	if(!is_null($operformance_app)){
						$perf_val  =  $operformance_app[0]->appraisal_option_value;
					} else {
						$perf_val  = 'A';
					}
					
				  ?>
                   <tr>
                    <td scope="row" colspan="2"><?php echo $iorg_comp;?></td>
                    <td><?php if($perf_val==5):?>
                      <?php echo $this->lang->line('xin_performance_none');?>
                      <?php elseif($perf_val==6):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($perf_val==7):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($perf_val==8):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="form-group">
            <label for="remarks"><strong><?php echo $this->lang->line('xin_remarks');?></strong></label>
            <?php echo htmlspecialchars_decode($remarks);?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php }
?>
