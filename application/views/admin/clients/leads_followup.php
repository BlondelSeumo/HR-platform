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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_lead_details');?></strong></span> </div>
      <div class="card-header"> </div>
      <div class="box-body">
        <div class="box-block box-dashboard">
          <div class="table-responsive" data-pattern="priority-columns">
            <table class="datatables-demo table table-striped table-bordered">
              <tbody>
                <tr>
                  <th><?php echo $this->lang->line('xin_company_name');?></th>
                  <td style="display: table-cell;"><?php echo $company_name;?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('xin_clcontact_person');?></th>
                  <td style="display: table-cell;"><?php echo $name;?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('xin_contact_number');?></th>
                  <td style="display: table-cell;"><?php echo $contact_number;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('xin_email');?></th>
                  <td style="display: table-cell;"><?php echo $email;?></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 <?php echo $get_animate;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_lead_followup');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="table table-striped table-bordered dataTable" id="xin_table" style="width:100%;">
            <thead>
              <tr>
                <th width="100"><?php echo $this->lang->line('xin_action');?></th>
                <th width="140"><?php echo $this->lang->line('xin_lead_next_followup');?></th>
                <th><?php echo $this->lang->line('xin_description');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_lead_new_followup');?></strong></span> </div>
      <div class="card-body pb-2">
       <input type="hidden" name="xlead_id" id="xlead_id" value="<?php echo $client_id;?>" />
        <?php $attributes = array('name' => 'followup_info', 'id' => 'followup_info', 'autocomplete' => 'off');?>
        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
        <?php echo form_open('admin/leads/add_followup', $attributes, $hidden);?>
        <?php
			  $data_usr4 = array(
				'type'  => 'hidden',
				'name'  => 'client_id',
				'value' => $client_id,
			 );
			echo form_input($data_usr4);
		  ?>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="next_followup"><?php echo $this->lang->line('xin_lead_next_followup');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_lead_next_followup');?>" name="next_followup" type="text">
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="description"><?php echo $this->lang->line('xin_description');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" type="text" value="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
