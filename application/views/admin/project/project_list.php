<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $project_no = $this->Xin_model->generate_random_string();?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('312',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_dashboard/');?>" data-link-data="<?php echo site_url('admin/project/projects_dashboard/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_overview');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('44',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/project/');?>" data-link-data="<?php echo site_url('admin/project/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('left_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('left_projects');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('119',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/clients/');?>" data-link-data="<?php echo site_url('admin/clients/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('xin_project_clients');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_clients');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('94',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/timelogs/');?>" data-link-data="<?php echo site_url('admin/project/timelogs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('xin_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_project_timelogs');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('424',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_calendar/');?>" data-link-data="<?php echo site_url('admin/project/projects_calendar/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('xin_acc_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_acc_calendar');?></div>
      </a> </li>
      <?php } ?>
      <?php if(in_array('425',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/projects_scrum_board/');?>" data-link-data="<?php echo site_url('admin/project/projects_scrum_board/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('xin_projects_scrm_board');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_projects_scrm_board');?></div>
      </a> </li>
      <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('315',$role_resources_ids)) {?>
<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_project');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_project_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_project_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_project', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/project/add_project', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title"><?php echo $this->lang->line('xin_title');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_title');?>" name="title" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="project_no"><?php echo $this->lang->line('xin_project_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_no');?>" name="project_no" type="text" value="<?php echo $project_no;?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="purchase_no"><?php echo $this->lang->line('xin_po_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_po_no');?>" name="purchase_no" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phase_no"><?php echo $this->lang->line('xin_phase_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phase_no');?>" name="phase_no" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="client_id"><?php echo $this->lang->line('xin_project_client');?></label>
                      <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_client');?>">
                        <option value=""></option>
                        <?php foreach($all_clients as $client) {?>
                        <option value="<?php echo $client->client_id;?>"> <?php echo $client->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php if($user_info[0]->user_role_id==1){ ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_id"><?php echo $this->lang->line('module_company_title');?></label>
                      <select multiple="multiple" name="company_id[]" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                        <option value=""></option>
                        <?php foreach($all_companies as $company) {?>
                        <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else {?>
                  <?php $ecompany_id = $user_info[0]->company_id;?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_id"><?php echo $this->lang->line('module_company_title');?></label>
                      <select multiple="multiple" name="company_id[]" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                        <option value=""></option>
                        <?php foreach($all_companies as $company) {?>
                        <?php if($ecompany_id == $company->company_id):?>
                        <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                        <?php endif;?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } ?>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="budget_hours"><?php echo $this->lang->line('xin_project_budget_hrs');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_project_budget_hrs');?>" name="budget_hours" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="employee"><?php echo $this->lang->line('xin_p_priority');?></label>
                      <select name="priority" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_p_priority');?>">
                        <option value="1"><?php echo $this->lang->line('xin_highest');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_high');?></option>
                        <option value="3"><?php echo $this->lang->line('xin_normal');?></option>
                        <option value="4"><?php echo $this->lang->line('xin_low');?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_project_manager');?></label>
                  <select multiple name="assigned_to[]" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_manager');?>">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="summary"><?php echo $this->lang->line('xin_summary');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if($system[0]->show_projects=='0'){ ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_projects');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_project');?>#</th>
            <th><?php echo $this->lang->line('xin_phase_no');?></th>
            <th width="180"><?php echo $this->lang->line('xin_project_summary');?></th>
            <?php //if(!in_array('386',$role_resources_ids)) {?>
            <th><?php echo $this->lang->line('xin_p_priority');?></th>
            <?php //} ?>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_project_users');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php } else {?>
<?php if($user_info[0]->user_role_id==1){
    $project = $this->Project_model->get_projects();
} else {
    if(in_array('318',$role_resources_ids)) {
        $project = $this->Project_model->get_company_projects($user_info[0]->company_id);
    } else {
        $project = $this->Project_model->get_employee_projects($session['user_id']);
    }
}
$data = array();
?>
<div class="row">
	<?php
    foreach($project->result() as $r) {
		$aim = explode(',',$r->assigned_to);
				 // get user > added by
		$user = $this->Xin_model->read_user_info($r->added_by);
		// user full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		// get date
		$psdate = $this->Xin_model->set_date_format($r->start_date);
		$pedate = $this->Xin_model->set_date_format($r->end_date);
		
		//project_progress
		if($r->project_progress <= 20) {
			$progress_class = 'bg-danger';
		} else if($r->project_progress > 20 && $r->project_progress <= 50){
			$progress_class = 'bg-warning';
		} else if($r->project_progress > 50 && $r->project_progress <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		// priority
		if($r->priority == 1) {
			$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_highest').'</span>';
		} else if($r->priority ==2){
			$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_high').'</span>';
		} else if($r->priority ==3){
			$priority = '<span class="badge badge-primary">'.$this->lang->line('xin_normal').'</span>';
		} else {
			$priority = '<span class="badge badge-success">'.$this->lang->line('xin_low').'</span>';
		}
		
		//assigned user
		if($r->assigned_to == '') {
			$ol = $this->lang->line('xin_not_assigned');
		} else {
			$ol = '';
			foreach(explode(',',$r->assigned_to) as $desig_id) {
				$assigned_to = $this->Xin_model->read_user_info($desig_id);
				if(!is_null($assigned_to)){
					
				  $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="mb-1"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="mb-1"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					}
				} ////
				else {
					$ol .= '';
				}
			 }
			 $ol .= '';
		}
		
		
		if(in_array('316',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-project_id="'. $r->project_id . '"><span class="fa fa-pencil"></span></button></span>';
			
			$add_users = ' <span type="button" data-toggle="modal" data-target=".edit-modal-data"  data-project_id="'. $r->project_id . '"><span class="fa fa-plus"></span></span>';
		} else {
			$edit = '';
			$add_users = '';
		}
		
		$client = $this->Clients_model->read_client_info($r->client_id);
		if(!is_null($client)) {
			$client_name = $client[0]->name;
		} else {
			$client_name = '--';
		}		
		?>
  <div class="col-sm-6 col-xl-4">

    <div class="card mb-4">
      <div class="card-body d-flex justify-content-between align-items-start pb-3">
        <div>
          <a href="javascript:void(0)" class="text-body text-big font-weight-semibold"><?php echo $r->title;?></a>
          <?php if($r->status == 0) {
				$status = '<span class="badge badge-warning align-text-bottom ml-1">'.$this->lang->line('xin_not_started').'</span>';
			} else if($r->status ==1){
				$status = '<span class="badge badge-primary align-text-bottom ml-1">'.$this->lang->line('xin_in_progress').'</span>';
			} else if($r->status ==2){
				$status = '<span class="badge badge-success align-text-bottom ml-1">'.$this->lang->line('xin_completed').'</span>';
			} else if($r->status ==3){
				$status = '<span class="badge badge-danger align-text-bottom ml-1">'.$this->lang->line('xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="badge badge-danger align-text-bottom ml-1">'.$this->lang->line('xin_project_hold').'</span>';
			}
		 ?>	
        <?php echo $status;?>
          <div class="text-muted small mt-1"><?php echo $this->lang->line('xin_project');?>#: <?php echo $r->project_no;?></div>
        </div>
        <div class="btn-group project-actions">
          <button type="button" class="btn btn-sm btn-default icon-btn borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown">
            <i class="ion ion-ios-more"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo site_url().'admin/project/detail/'.$r->project_id;?>">View</a>
            <?php if(in_array('316',$role_resources_ids)) { // Edit ?>
            <a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-target=".edit-modal-data" data-project_id="<?php echo $r->project_id;?>"><?php echo $this->lang->line('xin_edit');?></a>
            <?php } ?>
            <?php if(in_array('317',$role_resources_ids)) { // delete ?>
            <a class="dropdown-item delete" href="javascript:void(0)" data-toggle="modal" data-target=".delete-modal" data-record-id="<?php echo $r->project_id;?>"><?php echo $this->lang->line('xin_delete');?></a>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="progress rounded-0" style="height: 3px;">
        <div class="progress-bar <?php echo $progress_class;?>" style="width: <?php echo $r->project_progress;?>%;"></div>
      </div>
      <div class="card-body small pt-2 pb-0">
        <strong><?php echo $r->project_progress;?>%</strong> <?php echo $this->lang->line('xin_completed');?>
      </div>
      <div class="card-body pb-3">
        <?php echo $r->summary;?>
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('xin_start_date');?></div>
            <div class="font-weight-bold"><?php echo $this->Xin_model->set_date_format($r->start_date);?></div>
          </div>
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('xin_end_date');?></div>
            <div class="font-weight-bold"><?php echo $this->Xin_model->set_date_format($r->end_date);?></div>
          </div>
        </div>
      </div>
      <hr class="m-0">
      <div class="card-body">
        <div class="text-muted small"><?php echo $this->lang->line('xin_project_client');?></div>
        <div class="mb-3"><a href="javascript:void(0)" class="text-body font-weight-semibold"><?php echo $client_name;?></a></div>
        
      
        
      </div>
      <hr class="m-0">
      <div class="card-body py-3">
        <div class="text-muted small mb-2"><?php echo $this->lang->line('xin_team');?></div>
        <div class="d-flex flex-wrap">
          <?php echo $ol; ?>
        </div>
      </div>
    </div>
  </div>
  <?php }?>
</div>
<?php } ?>