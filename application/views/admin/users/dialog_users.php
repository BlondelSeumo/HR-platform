<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['user_id']) && $_GET['data']=='user'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('xin_edit_user');?></h4>
</div>
<form class="m-b-1" action="<?php echo site_url("admin/users/update").'/'.$user_id; ?>" method="post" name="edit_user" id="edit_user">
  <input type="hidden" name="_method" value="EDIT">
  <input type="hidden" name="_token" value="<?php echo $_GET['user_id'];?>">
  <input type="hidden" name="ext_name" value="<?php echo $first_name;?>">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <label for="email"><?php echo $this->lang->line('xin_email');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="username"><?php echo $this->lang->line('dashboard_username');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $username;?>">
            </div>
            <div class="col-md-6">
              <label for="password"><?php echo $this->lang->line('xin_employee_password');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text" value="<?php echo $password;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" value="<?php echo $contact_number;?>" type="number">
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
              <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                <option value="Male" <?php if('Male'==$gender):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_gender_male');?></option>
                <option value="Female"<?php if('Female'==$gender):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_gender_female');?></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <fieldset class="form-group">
              <label for="photo"><?php echo $this->lang->line('xin_user_photo');?></label>
              <input type="file" class="form-control-file" id="photo" name="photo">
              <small><?php echo $this->lang->line('xin_company_file_type');?></small>
            </fieldset>
          </div>
          <div class="col-md-6">
            <?php if($profile_photo!='' || $profile_photo!='no-file'){?>
            <span class="box-96 mr-0-5"> <img class="b-a-radius-circle" src="<?php echo site_url();?>uploads/users/<?php echo $profile_photo;?>" alt=""> </span>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
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
            <option value="<?php echo $country->country_id;?>" <?php if($country->country_id==$icountry):?> selected="selected"<?php endif;?>> <?php echo $country->country_name;?></option>
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
<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 

		/* Edit data */
		$("#edit_user").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'user');
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
						$('.save').prop('disabled', false);
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/users/users_list") ?>",
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
				},
				error: function() 
				{
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} 	        
		   });
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_user' && isset($_GET['user_id']) ){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-eye4"></i> <?php echo $this->lang->line('xin_view_user');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('xin_employee_first_name');?></th>
            <td style="display: table-cell;"><?php echo $first_name;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_employee_last_name');?></th>
            <td style="display: table-cell;"><?php echo $last_name;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_email');?></th>
            <td style="display: table-cell;"><?php echo $email;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('dashboard_username');?></th>
            <td style="display: table-cell;"><?php echo $username;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_employee_password');?></th>
            <td style="display: table-cell;"><?php echo $password;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_contact_number');?></th>
            <td style="display: table-cell;"><?php echo $contact_number;?></span></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_employee_gender');?></th>
            <td style="display: table-cell;"><?php echo $gender;?></span></td>
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
              <?php if($icountry==$country->country_id):?>
              <?php echo $country->country_name;?>
              <?php endif;?>
              <?php } ?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_user_photo');?></th>
            <td style="display: table-cell;"><?php if($profile_photo!='' || $profile_photo!='no-file'){?>
              <div class="avatar box-48 mr-0-5"> <img src="<?php echo site_url();?>uploads/users/<?php echo $profile_photo;?>" alt=""></a> </div>
              <?php } ?></td>
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
