<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['performance_indicator_id']) && $_GET['data']=='indicator'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_performance_indicator');?></h4>
</div>
<?php $attributes = array('name' => 'edit_indicator', 'id' => 'edit_indicator', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $performance_indicator_id, 'ext_name' => $designation_id);?>
<?php echo form_open('admin/performance_indicator/update/'.$performance_indicator_id, $attributes, $hidden);?>
<div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="left_company"><?php echo $this->lang->line('left_company');?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected="selected" <?php endif;?>><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="designation"><?php echo $this->lang->line('dashboard_designation');?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group" id="designation_ajx">
                 <?php $result = $this->Designation_model->ajax_company_designation_info($company_id);?>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_designation');?>" name="designation_id">
                    <option value=""></option>
                    <?php foreach($result as $designation) {?>
                    <option value="<?php echo $designation->designation_id?>" <?php if($designation->designation_id==$designation_id):?> selected="selected" <?php endif;?>><?php echo $designation->designation_name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="form-section"><?php echo $this->lang->line('xin_performance_technical_competencies');?></h4>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_customer_experience');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="customer_experience" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($customer_experience=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($customer_experience=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($customer_experience=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4" <?php if($customer_experience=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_marketing');?> </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="marketing" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($marketing=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($marketing=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($marketing=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4" <?php if($marketing=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_management');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="management" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($management=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($management=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($management=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4" <?php if($management=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_administration');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="administration" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($administration=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($administration=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($administration=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4" <?php if($administration=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_present_skill');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="presentation_skill" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($presentation_skill=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($presentation_skill=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($presentation_skill=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4" <?php if($presentation_skill=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_quality_work');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="quality_of_work" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($quality_of_work=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($quality_of_work=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($quality_of_work=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4" <?php if($quality_of_work=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_efficiency');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="efficiency" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($efficiency=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($efficiency=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($efficiency=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4" <?php if($efficiency=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="form-section"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></h4>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_integrity');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="integrity" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($integrity=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($integrity=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($integrity=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_professionalism');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="professionalism" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($professionalism=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($professionalism=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($professionalism=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_team_work');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="team_work" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($team_work=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($team_work=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($team_work=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_critical_think');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="critical_thinking" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($critical_thinking=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($critical_thinking=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($critical_thinking=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_conflict_manage');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="conflict_management" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($conflict_management=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($conflict_management=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($conflict_management=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_attendance');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="attendance" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($attendance=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($attendance=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($attendance=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_meet_deadline');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="ability_to_meet_deadline" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1" <?php if($ability_to_meet_deadline=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2" <?php if($ability_to_meet_deadline=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3" <?php if($ability_to_meet_deadline=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
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
				
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_designations/"+jQuery(this).val(), function(data, status){
			jQuery('#designation_ajx').html(data);
		});
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	
	/* Edit data */
	$("#edit_indicator").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=indicator&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : "<?php echo site_url("admin/performance_indicator/performance_indicator_list") ?>",
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
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['performance_indicator_id']) && $_GET['data']=='view_indicator' && $_GET['type']=='view_indicator'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_performance_indicator');?></h4>
</div>
<form method="post" name="view_performance_indicator" id="view_performance_indicator" class="form-hrm">
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="left_company"><?php echo $this->lang->line('left_company');?>: </label>
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
                  <label for="designation"><?php echo $this->lang->line('dashboard_designation');?>: </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <?php foreach($all_designations as $designation) {?>
                  <?php if($designation->designation_id==$designation_id):?>
                  <?php echo $designation->designation_name?>
                  <?php endif;?>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="form-section"><?php echo $this->lang->line('xin_performance_technical_competencies');?></h4>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_customer_experience');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($customer_experience=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($customer_experience=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($customer_experience=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php elseif($customer_experience=='4'):?>
                    <?php echo $this->lang->line('xin_performance_expert');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_marketing');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($marketing=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($marketing=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($marketing=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php elseif($marketing=='4'):?>
                    <?php echo $this->lang->line('xin_performance_expert');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_management');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($management=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($management=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($management=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php elseif($management=='4'):?>
                    <?php echo $this->lang->line('xin_performance_expert');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_administration');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($administration=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($administration=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($administration=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php elseif($administration=='4'):?>
                    <?php echo $this->lang->line('xin_performance_expert');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_present_skill');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($presentation_skill=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($presentation_skill=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($presentation_skill=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php elseif($presentation_skill=='4'):?>
                    <?php echo $this->lang->line('xin_performance_expert');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_quality_work');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($quality_of_work=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($quality_of_work=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($quality_of_work=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php elseif($quality_of_work=='4'):?>
                    <?php echo $this->lang->line('xin_performance_expert');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_efficiency');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($efficiency=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($efficiency=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($efficiency=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php elseif($efficiency=='4'):?>
                    <?php echo $this->lang->line('xin_performance_expert');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="form-section"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></h4>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_integrity');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($integrity=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($integrity=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($integrity=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_professionalism');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($professionalism=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($professionalism=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($professionalism=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_team_work');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($team_work=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($team_work=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($team_work=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_critical_think');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($critical_thinking=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($critical_thinking=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($critical_thinking=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_conflict_manage');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($conflict_management=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($conflict_management=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($conflict_management=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_attendance');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($attendance=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($attendance=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($attendance=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_meet_deadline');?>: </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <?php if($ability_to_meet_deadline=='1'):?>
                    <?php echo $this->lang->line('xin_performance_beginner');?>
                    <?php elseif($ability_to_meet_deadline=='2'):?>
                    <?php echo $this->lang->line('xin_performance_intermediate');?>
                    <?php elseif($ability_to_meet_deadline=='3'):?>
                    <?php echo $this->lang->line('xin_performance_advanced');?>
                    <?php else:?>
                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                    <?php endif;?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
