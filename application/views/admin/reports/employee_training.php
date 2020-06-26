<?php
/* Date Wise Attendance Report > EMployees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'training_report', 'id' => 'training_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
		<?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/training_report', $attributes, $hidden);?>
        <?php
			$data = array(
			  'name'        => 'user_id',
			  'id'          => 'user_id',
			  'type'        => 'hidden',
			  'value'   	   => $session['user_id'],
			  'class'       => 'form-control',
			);
            echo form_input($data);
            ?>
          <div class="form-row">
          <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('xin_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('xin_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php /*?><?php if($company_id==$company->company_id):?> selected 
                    <?php endif;?><?php */?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
            <?php } else {?>
            <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="col-md mb-3">
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <?php if($ecompany_id == $company->company_id):?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                <?php endif;?>
                <?php } ?>
              </select>
            </div>
             <?php } ?>
            <div class="col-md mb-3">
            <div class="form-group" id="employee_ajax">
                <label class="form-label"><?php echo $this->lang->line('xin_choose_an_employee');?></label>
                <select name="employee_id" id="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                    <option value="">All</option>
                  </select>
            </div>
            </div>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_view');?></strong> <?php echo $this->lang->line('xin_hr_reports_training');?></span> </div>
      <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('xin_employee');?></th>
              <th><?php echo $this->lang->line('left_training_type');?></th>
              <th><?php echo $this->lang->line('xin_trainer');?></th>
              <th><?php echo $this->lang->line('xin_training_duration');?></th>
              <th><?php echo $this->lang->line('xin_cost');?></th>
              <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
</div>