<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['expense_id']) && $_GET['data']=='expense'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_expense');?></h4>
</div>
<?php $attributes = array('name' => 'edit_expense', 'id' => 'edit_expense', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $expense_id, 'ext_name' => $expense_id);?>
<?php echo form_open('admin/expense/update/'.$expense_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="employee"><?php echo $this->lang->line('xin_expense_type');?></label>
          <select name="expense_type" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_expense_type');?>...">
            <option value=""></option>
            <?php foreach($all_expense_types as $expense_type) {?>
            <option value="<?php echo $expense_type->expense_type_id;?>" <?php if($expense_type->expense_type_id==$expense_type_id):?> selected <?php endif; ?>><?php echo $expense_type->name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="purchase_date"><?php echo $this->lang->line('xin_purchase_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_purchase_date');?>" readonly="true" name="purchase_date" type="text" value="<?php echo $purchase_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="amount"><?php echo $this->lang->line('xin_amount');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="number" value="<?php echo $amount;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected <?php endif; ?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" id="employee_ajx">
              <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
              <label for="gift"><?php echo $this->lang->line('xin_purchased_by');?></label>
              <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>...">
                <option value=""></option>
                <?php foreach($result as $employee) {?>
                <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id):?> selected <?php endif; ?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
          <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
          <textarea class="form-control textarea" name="remarks" cols="25" rows="5" id="description2"><?php echo $remarks;?></textarea>
        </div>
      </div>
      </div>
      <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
          <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>...">
            <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_pending');?></option>
            <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_approved');?></option>
            <option value="2" <?php if($status=='2'):?> selected <?php endif; ?> ><?php echo $this->lang->line('xin_cancel');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class='form-group'>
          <fieldset class="form-group">
            <label for="logo"><?php echo $this->lang->line('xin_bill_copy');?></label>
            <input type="file" class="form-control-file" id="bill_copy" name="bill_copy">
            <small><?php echo $this->lang->line('xin_expense_allow_files');?></small>
          </fieldset>
          <?php if($billcopy_file!='' && $billcopy_file!='no file') {?>
          <br />
          <a href="<?php echo site_url("hr/download?type=expense&filename=".$billcopy_file."") ?>"><?php echo $this->lang->line('xin_download_file');?></a>
          <?php } ?>
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
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		//$('#description2').trumbowyg();
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
		});
		$('.edate').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 10),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
		});

		/* Edit data */
		$("#edit_expense").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'expense');
			fd.append("form", action);
			e.preventDefault();
			$('.save').prop('disabled', true);
			$.ajax({
				url: e.target.action,
				type: "POST",
				data:  fd,
				contentType: false,
				cache: false,
				processData:false,
				success: function(JSON)
				{
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/expense/expense_list") ?>",
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
					}
				},
				error: function() 
				{
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} 	        
		   });
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['expense_id']) && $_GET['data']=='view_expense'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_expense');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('module_company_title');?></th>
            <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
              <?php if($company_id==$company->company_id):?>
              <?php echo $company->name;?>
              <?php endif;?>
              <?php } ?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_expense_type');?></th>
            <td style="display: table-cell;"><?php foreach($all_expense_types as $expense_type) {?>
              <?php if($expense_type_id==$expense_type->expense_type_id):?>
              <?php echo $expense_type->name;?>
              <?php endif;?>
              <?php } ?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_purchase_date');?></th>
            <td style="display: table-cell;"><?php echo $purchase_date;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_amount');?></th>
            <td style="display: table-cell;"><?php echo $this->Xin_model->currency_sign($amount);?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_purchased_by');?></th>
            <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
              <?php if($employee_id==$employee->user_id):?>
              <?php echo $employee->first_name.' '.$employee->last_name;?>
              <?php endif;?>
              <?php } ?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
            <td style="display: table-cell;"><?php if($status=='0'): $e_status = $this->lang->line('xin_pending'); ?>
              <?php endif; ?>
              <?php if($status=='1'): $e_status = $this->lang->line('xin_approved');?>
              <?php endif; ?>
              <?php if($status=='2'): $e_status = $this->lang->line('xin_cancel');?>
              <?php endif; ?>
              <?php echo $e_status;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_bill_copy');?></th>
            <td style="display: table-cell;">
			  <?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
			  <?php if(in_array('314',$role_resources_ids)) { //download?>
				  <?php if($billcopy_file!='' && $billcopy_file!='no file') {?>
                  	<a href="<?php echo site_url("admin/download?type=expense&filename=".$billcopy_file."") ?>"><?php echo $this->lang->line('xin_download_file');?></a>
                  <?php } ?>
              <?php } ?>
              </td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_remarks');?></th>
            <td style="display: table-cell;"><?php echo html_entity_decode($remarks);?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
