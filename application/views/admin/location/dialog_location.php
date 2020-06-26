<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['location_id']) && $_GET['data']=='location'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_location');?></h4>
</div>
<?php $attributes = array('name' => 'edit_location', 'id' => 'edit_location', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $company_id, 'ext_name' => $location_name);?>
<?php echo form_open('admin/location/update/'.$location_id, $attributes, $hidden);?>
<div class="modal-body">
    <div class="row">
      <div class="col-sm-6">
        <?php if($user_info[0]->user_role_id==1){ ?>
        <div class="form-group">
          <label for="company_name"><?php echo $this->lang->line('xin_edit_company');?></label>
          <select class="form-control" name="company" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_edit_company');?>">
            <option value=""><?php echo $this->lang->line('xin_edit_company');?></option>
            <?php foreach($all_companies as $company) {?>
            <option value="<?php echo $company->company_id;?>" <?php if($company_id==$company->company_id):?> selected <?php endif;?>> <?php echo $company->name;?></option>
            <?php } ?>
          </select>
        </div>
        <?php } else {?>
        <?php $ecompany_id = $user_info[0]->company_id;?>
        <div class="form-group">
          <label for="company_name"><?php echo $this->lang->line('xin_edit_company');?></label>
          <select class="form-control" name="company" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_edit_company');?>">
            <option value=""><?php echo $this->lang->line('xin_edit_company');?></option>
            <?php foreach($all_companies as $company) {?>
				<?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id;?>" <?php if($company_id==$company->company_id):?> selected <?php endif;?>> <?php echo $company->name;?></option>
                <?php endif;?>
            <?php } ?>
          </select>
        </div>
        <?php } ?>
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_location_name');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_location_name');?>" name="name" type="text" value="<?php echo $location_name;?>">
        </div>
        <div class="form-group">
          <label for="email"><?php echo $this->lang->line('xin_email');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="phone"><?php echo $this->lang->line('xin_phone');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phone');?>" name="phone" type="text" value="<?php echo $phone;?>">
            </div>
            <div class="col-md-6">
              <label for="xin_faxn"><?php echo $this->lang->line('xin_faxn');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_faxn');?>" name="fax" type="text" value="<?php echo $fax;?>">
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group" id="employee_ajx">
          <div class="row">
            <div class="col-md-12">
              <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
              <label for="email"><?php echo $this->lang->line('xin_view_locationh');?></label>
              <select class="form-control" name="location_head" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_view_locationh');?>">
                <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                <?php foreach($result as $employee) {?>
                <option value="<?php echo $employee->user_id;?>" <?php if($location_head==$employee->user_id):?> selected <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="address"><?php echo $this->lang->line('xin_address');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
          <br>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
          <br>
          <div class="row">
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
            </div>
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
            </div>
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
            </div>
          </div>
          <br>
          <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
            <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
            <?php foreach($all_countries as $country) {?>
            <option value="<?php echo $country->country_id;?>" <?php if($countryid==$country->country_id):?> selected <?php endif;?>> <?php echo $country->country_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script> 
<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
		});	 
		 Ladda.bind('button[type=submit]');	 

		/* Edit data */
		$("#edit_location").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=location&form="+action,
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
								url : "<?php echo site_url("admin/location/location_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['location_id']) && $_GET['data']=='view_location'){
?>
<form class="m-b-1">
  <div class="modal-body">
  <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('xin_view_location');?></strong></p>
    <div class="table-responsive" data-pattern="priority-columns">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('module_company_title');?></th>
            <td style="display: table-cell;"><?php foreach($all_companies as $company) {?>
              <?php if($company_id==$company->company_id):?>
              <?php echo $company->name;?>
              <?php endif;?>
              <?php } ?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_location_name');?></th>
            <td style="display: table-cell;"><?php echo $location_name;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_view_locationh');?></th>
            <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
              <?php if($location_head==$employee->user_id):?>
              <?php echo $employee->first_name.' '.$employee->last_name;?>
              <?php endif;?>
              <?php } ?>
              </span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_email');?></th>
            <td style="display: table-cell;"><?php echo $email;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_phone');?></th>
            <td style="display: table-cell;"><?php echo $phone;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_faxn');?></th>
            <td style="display: table-cell;"><?php echo $fax;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_address');?></th>
            <td style="display: table-cell;"><?php echo $address_1;?></span></td>
          </tr>
          <?php if($address_2!='') { ?>
          <tr>
            <th>&nbsp;</th>
            <td style="display: table-cell;"><?php echo $address_2;?></span></td>
          </tr>
          <?php } ?>
          <tr>
            <th><?php echo $this->lang->line('xin_city');?></th>
            <td style="display: table-cell;"><?php echo $city;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_state');?></th>
            <td style="display: table-cell;"><?php echo $state;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_zipcode');?></th>
            <td style="display: table-cell;"><?php echo $zipcode;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_country');?></th>
            <td style="display: table-cell;"><?php foreach($all_countries as $country) {?>
              <?php if($countryid==$country->country_id):?>
              <?php echo $country->country_name;?>
              <?php endif;?>
              <?php } ?>
              </span></td>
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
