<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row">
    <div class="col-md-12">
        <div class="box <?php echo $get_animate;?>">
            <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_last_5_project_data');?> </h3>
      </div>
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#projects" data-toggle="tab">Projects</a></li>
              <li><a href="#tasks" data-toggle="tab">Tasks</a></li>
              <li><a href="#invoices" data-toggle="tab">Invoices</a></li>
              <li><a href="#estimates" data-toggle="tab">Estimates</a></li>
              <li><a href="#invoice_payments" data-toggle="tab">Invoice Payments</a></li>
              <li><a href="#clients" data-toggle="tab">Clients</a></li>
              <li><a href="#leads" data-toggle="tab">Leads</a></li>
              <li><a href="#quoted_projects" data-toggle="tab">Quoted Projects</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="projects">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_project');?>#</th>
                            <th><?php echo $this->lang->line('xin_phase_no');?></th>
                            <th width="180"><?php echo $this->lang->line('xin_project_summary');?></th>
                            <th><?php echo $this->lang->line('xin_p_priority');?></th>
                            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_project_users');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_date');?></th>
                            <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                          </tr>
                          <?php foreach(total_last_projects() as $ls_projects):?>
                          <?php
						 	 $aim = explode(',',$ls_projects->assigned_to);
							 // get user > added by
							$user = $this->Xin_model->read_user_info($ls_projects->added_by);
							// user full name
							if(!is_null($user)){
								$full_name = $user[0]->first_name.' '.$user[0]->last_name;
							} else {
								$full_name = '--';	
							}
							// get date
							$psdate = $this->Xin_model->set_date_format($ls_projects->start_date);
							$pedate = $this->Xin_model->set_date_format($ls_projects->end_date);
							
							//project_progress
							if($ls_projects->project_progress <= 20) {
								$progress_class = 'progress-bar-danger';
							} else if($ls_projects->project_progress > 20 && $ls_projects->project_progress <= 50){
								$progress_class = 'progress-bar-warning';
							} else if($ls_projects->project_progress > 50 && $ls_projects->project_progress <= 75){
								$progress_class = 'progress-bar-info';
							} else {
								$progress_class = 'progress-bar-success';
							}
							
							// progress
							$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$ls_projects->project_progress.'%</span>
					<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ls_projects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ls_projects->project_progress.'%"></div></div></p>';
					
									
							//status
							if($ls_projects->status == 0) {
								$status = '<span class="label label-warning">'.$this->lang->line('xin_not_started').'</span>';
							} else if($ls_projects->status ==1){
								$status = '<span class="label label-primary">'.$this->lang->line('xin_in_progress').'</span>';
							} else if($ls_projects->status ==2){
								$status = '<span class="label label-success">'.$this->lang->line('xin_completed').'</span>';
							} else if($ls_projects->status ==3){
								$status = '<span class="label label-danger">'.$this->lang->line('xin_project_cancelled').'</span>';
							} else {
								$status = '<span class="label label-danger">'.$this->lang->line('xin_project_hold').'</span>';
							}
							
							// priority
							if($ls_projects->priority == 1) {
								$priority = '<span class="label label-danger">'.$this->lang->line('xin_highest').'</span>';
							} else if($ls_projects->priority ==2){
								$priority = '<span class="label label-danger">'.$this->lang->line('xin_high').'</span>';
							} else if($ls_projects->priority ==3){
								$priority = '<span class="label label-primary">'.$this->lang->line('xin_normal').'</span>';
							} else {
								$priority = '<span class="label label-success">'.$this->lang->line('xin_low').'</span>';
							}
							
							//assigned user
							if($ls_projects->assigned_to == '') {
								$ol = $this->lang->line('xin_not_assigned');
							} else {
								$ol = '';
								foreach(explode(',',$ls_projects->assigned_to) as $desig_id) {
									$assigned_to = $this->Xin_model->read_user_info($desig_id);
									if(!is_null($assigned_to)){
										
									  $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
									 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
										} else {
										if($assigned_to[0]->gender=='Male') { 
											$de_file = base_url().'uploads/profile/default_male.jpg';
										 } else {
											$de_file = base_url().'uploads/profile/default_female.jpg';
										 }
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
										}
									} ////
									else {
										$ol .= '';
									}
								 }
								 $ol .= '';
							}
							$client = $this->Clients_model->read_client_info($ls_projects->client_id);
							if(!is_null($client)) {
								$client_name = $client[0]->name;
							} else {
								$client_name = '--';
							}
									
							$new_time = $this->Xin_model->actual_hours_timelog($ls_projects->project_id);
							$project_summary = '<a href="'.site_url().'admin/project/detail/'.$ls_projects->project_id . '">'.$ls_projects->title.'</a><br><small>'.$this->lang->line('xin_project_client').': '.$client_name.'</small><br><small>'.$this->lang->line('xin_project_budget_hrs').': '.$ls_projects->budget_hours.'</small><br><small>'.$this->lang->line('xin_project_actual_hrs').': '.$new_time.'</small>';
							
							$project_date = $this->lang->line('xin_start_date').': '.$psdate.'<br>'.$this->lang->line('xin_end_date').': '.$pedate;
							// progress
							$project_progress = $pbar.$status;
							$project_no = '<a href="'.site_url().'admin/project/detail/'.$ls_projects->project_id . '">'.$ls_projects->project_no.'</a>';
							?>
                          <tr>
                            <td><?php echo $project_no;?></td>
                            <td><?php echo $ls_projects->phase_no;?></td>
                            <th width="180"><?php echo $project_summary;?></td>
                            <td><?php echo $priority;?></td>
                            <td><?php echo $ol;?></td>
                            <td><?php echo $project_date;?></td>
                            <td><?php echo $project_progress;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="tasks">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                            <th><?php echo $this->lang->line('xin_assigned_to');?></th>
                            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
                            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                            <th><?php echo $this->lang->line('xin_created_by');?></th>
                            <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                          </tr>
                          <?php foreach(total_last_tasks() as $ls_tasks):?>
                          <?php
						 	 $aim = explode(',',$ls_tasks->assigned_to);
				  
								if($ls_tasks->assigned_to == '' || $ls_tasks->assigned_to == 'None') {
									$ol = 'None';
								} else {
									$ol = '';
									foreach(explode(',',$ls_tasks->assigned_to) as $uid) {
										//$user = $this->Xin_model->read_user_info($uid);
										$assigned_to = $this->Xin_model->read_user_info($uid);
										if(!is_null($assigned_to)){
											
										$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
										 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
											$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
											} else {
											if($assigned_to[0]->gender=='Male') { 
												$de_file = base_url().'uploads/profile/default_male.jpg';
											 } else {
												$de_file = base_url().'uploads/profile/default_female.jpg';
											 }
											$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
											}
										}
									 }
								 $ol .= '';
								}
								//$ol = 'A';
								/* get User info*/
								$u_created = $this->Xin_model->read_user_info($ls_tasks->created_by);
								if(!is_null($u_created)){
									$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
								} else {
									$f_name = '--';	
								}
								
								// task project
								$prj_task = $this->Project_model->read_project_information($ls_tasks->project_id);
								if(!is_null($prj_task)){
									$prj_name = $prj_task[0]->title;
								} else {
									$prj_name = '--';
								}
								// task category
								$task_cat = $this->Project_model->read_task_category_information($ls_tasks->task_name);
								if(!is_null($task_cat)){
									$task_catname = $task_cat[0]->category_name;
								} else {
									$task_catname = '--';
								}
								
								/// set task progress
								if($ls_tasks->task_progress=='' || $ls_tasks->task_progress==0): $progress = 0; else: $progress = $ls_tasks->task_progress; endif;				
								// task progress
								if($ls_tasks->task_progress <= 20) {
								$progress_class = 'progress-bar-danger';
								} else if($ls_tasks->task_progress > 20 && $ls_tasks->task_progress <= 50){
								$progress_class = 'progress-bar-warning';
								} else if($ls_tasks->task_progress > 50 && $ls_tasks->task_progress <= 75){
								$progress_class = 'progress-bar-info';
								} else {
								$progress_class = 'progress-bar-success';
								}
								
								$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$ls_tasks->task_progress.'%</span>
					<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ls_tasks->task_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ls_tasks->task_progress.'%"></div></div></p>';
								// task status			
								if($ls_tasks->task_status == 0) {
									$status = '<span class="label label-warning">'.$this->lang->line('xin_not_started').'</span>';
								} else if($ls_tasks->task_status ==1){
									$status = '<span class="label label-primary">'.$this->lang->line('xin_in_progress').'</span>';
								} else if($ls_tasks->task_status ==2){
									$status = '<span class="label label-success">'.$this->lang->line('xin_completed').'</span>';
								} else if($ls_tasks->task_status ==3){
									$status = '<span class="label label-danger">'.$this->lang->line('xin_project_cancelled').'</span>';
								} else {
									$status = '<span class="label label-danger">'.$this->lang->line('xin_project_hold').'</span>';
								}
								// task start/end date
								$psdate = $this->Xin_model->set_date_format($ls_tasks->start_date);
								$pedate = $this->Xin_model->set_date_format($ls_tasks->end_date);
								$ttask_date = $this->lang->line('xin_start_date').': '.$psdate.'<br>'.$this->lang->line('xin_end_date').': '.$pedate;	
							?>
                          <tr>
                            <td><?php echo $task_catname.'<br>'.$this->lang->line('xin_project').': <a href="'.site_url().'admin/project/detail/'.$ls_tasks->project_id.'">'.$prj_name.'</a><br>'.$this->lang->line('xin_hours').': '.$ls_tasks->task_hour;?></td>
                            <td><?php echo $ol;?></td>
                            <td><?php echo $ttask_date;?></td>
                            <td><?php echo $status;?></td>
                            <td><?php echo $f_name;?></td>
                            <td><?php echo $progress_bar;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="invoices">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_invoice_no');?></th>
                            <th><?php echo $this->lang->line('xin_project');?></th>
                            <th><?php echo $this->lang->line('xin_acc_total');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_date');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_due_date');?></th>
                            <th><?php echo $this->lang->line('kpi_status');?></th>
                          </tr>
                          <?php $role_resources_ids = $this->Xin_model->user_role_resource(); foreach(total_last_invoices() as $ls_invoices):?>
                          <?php
						 	 // get country
							 $grand_total = $this->Xin_model->currency_sign($ls_invoices->grand_total);
							  // get project
							  $project = $this->Project_model->read_project_information($ls_invoices->project_id); 
							  if(!is_null($project)){
								$project_name = $project[0]->title;
							  } else {
								  $project_name = '--';	
							  }
							  $invoice_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($ls_invoices->invoice_date);
							  $invoice_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($ls_invoices->invoice_due_date);
							  //invoice_number
							  $invoice_number = '';
								if(in_array('330',$role_resources_ids)) { //view
									$invoice_number = '<a href="'.site_url().'admin/invoices/view/'.$ls_invoices->invoice_id.'/">'.$ls_invoices->invoice_number.'</a>';
								} else {
									$invoice_number = $ls_invoices->invoice_number;
								}
								if($ls_invoices->status == 0){
									$status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
								} else if($ls_invoices->status == 1) {
									$status = '<span class="label label-success">'.$this->lang->line('xin_payment_paid').'</span>';
								} else {
									$status = '<span class="label label-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
								}
							?>
                          <tr>
                            <td><?php echo $invoice_number;?></td>
                            <td><?php echo $project_name;?></td>
                            <td><?php echo $grand_total;?></td>
                            <td><?php echo $invoice_date;?></td>
                            <td><?php echo $invoice_due_date;?></td>
                            <td><?php echo $status;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="estimates">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_title_quote_hash');?></th>
                            <th><?php echo $this->lang->line('xin_project_title');?></th>
                            <th><?php echo $this->lang->line('xin_acc_total');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_quote_date');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_due_date');?></th>
                            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                          </tr>
                          <?php $role_resources_ids = $this->Xin_model->user_role_resource(); foreach(total_last_estimates() as $ls_estimates):?>
                          <?php
						 	 /// get country
							   $company_info = $this->Company_model->read_company_information($ls_estimates->company_id);
								if(!is_null($company_info)){
									$grand_total = $this->Xin_model->company_currency_sign($ls_estimates->grand_total,$ls_estimates->company_id);	
								} else {
									$grand_total = $this->Xin_model->currency_sign($ls_estimates->grand_total);
								}
										
										
							   // get project
							  $project = $this->Project_model->read_project_information($ls_estimates->project_id); 
							  if(!is_null($project)){
								$project_name = $project[0]->title;
							  } else {
								  $project_name = '--';	
							  }
							$quote_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($ls_estimates->quote_date);
							$quote_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($ls_estimates->quote_due_date);
							$quote_number = '';
							if(in_array('330',$role_resources_ids)) { //view
								$quote_number = '<a href="'.site_url().'admin/quotes/view/'.$ls_estimates->quote_id.'/">'.$ls_estimates->quote_number.'</a>';
							} else {
								$quote_number = $ls_estimates->quote_number;
							}
							if($ls_estimates->status == 0){
								$status = '<span class="label label-warning">'.$this->lang->line('xin_quoted_title').'</span>';
							} else {
								$status = '<span class="label label-success">'.$this->lang->line('xin_quote_invoiced').'</span>';
							}
							$quote_convert_record = $this->Quotes_model->read_quote_converted_info($ls_estimates->quote_id);
							?>
                          <tr>
                            <td><?php echo $quote_number;?></td>
                            <td><?php echo $project_name;?></td>
                            <td><?php echo $grand_total;?></td>
                            <td><?php echo $quote_date;?></td>
                            <td><?php echo $quote_due_date;?></td>
                            <td><?php echo $status;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="invoice_payments">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_invoice_no');?></th>
                          <th><?php echo $this->lang->line('xin_client_name');?></th>
                          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
                          <th><?php echo $this->lang->line('xin_amount');?></th>
                          <th><?php echo $this->lang->line('xin_payment_method');?></th>
                          <th><?php echo $this->lang->line('xin_description');?></th>
                          </tr>
                          <?php $role_resources_ids = $this->Xin_model->user_role_resource(); foreach(total_last_5_invoice_payments() as $ls_invoice_payments):?>
                          <?php
						 	 // transaction date
							$transaction_date = $this->Xin_model->set_date_format($ls_invoice_payments->transaction_date);
							// get currency
							$total_amount = $this->Xin_model->currency_sign($ls_invoice_payments->amount);
							// credit
							$cr_dr = $ls_invoice_payments->dr_cr=="dr" ? "Debit" : "Credit";
							
							$invoice_info = $this->Invoices_model->read_invoice_info($ls_invoice_payments->invoice_id);
							if(!is_null($invoice_info)){
								$inv_no = $invoice_info[0]->invoice_number;
							} else {
								$inv_no = '--';	
							}
							// payment method 
							$payment_method = $this->Xin_model->read_payment_method($ls_invoice_payments->payment_method_id);
							if(!is_null($payment_method)){
								$method_name = $payment_method[0]->method_name;
							} else {
								$method_name = '--';	
							}	
							// payment method 
							$clientinfo = $this->Clients_model->read_client_info($ls_invoice_payments->client_id);
							if(!is_null($clientinfo)){
								$name_name = $clientinfo[0]->name;
							} else {
								$name_name = '--';	
							}
							
							$invoice_number = '<a href="'.site_url().'admin/invoices/view/'.$ls_invoice_payments->invoice_id.'/">'.$inv_no.'</a>';
							?>
                          <tr>
                            <td><?php echo $invoice_number;?></td>
                            <td><?php echo $name_name;?></td>
                            <td><?php echo $transaction_date;?></td>
                            <td><?php echo $total_amount;?></td>
                            <td><?php echo $method_name;?></td>
                            <td><?php echo $ls_invoice_payments->description;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="clients">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                          <th><?php echo $this->lang->line('xin_client_name');?></th>
                        <th><?php echo $this->lang->line('module_company_title');?></th>
                        <th><?php echo $this->lang->line('xin_email');?></th>
                        <th><?php echo $this->lang->line('xin_website');?></th>
                        <th><?php echo $this->lang->line('xin_country');?></th>
                          </tr>
                          <?php $role_resources_ids = $this->Xin_model->user_role_resource(); foreach(total_last_clients() as $ls_clients):?>
                          <?php
						 	 // get country
							  $country = $this->Xin_model->read_country_info($ls_clients->country);
							  if(!is_null($country)){
								$c_name = $country[0]->country_name;
							  } else {
								  $c_name = '--';	
							  }
							?>
                          <tr>
                            <td><?php echo $ls_clients->name;?></td>
                            <td><?php echo $ls_clients->company_name;?></td>
                            <td><?php echo $ls_clients->email;?></td>
                            <td><?php echo $ls_clients->website_url;?></td>
                            <td><?php echo $c_name;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="leads">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_client_name');?></th>
                            <th><?php echo $this->lang->line('module_company_title');?></th>
                            <th><?php echo $this->lang->line('xin_email');?></th>
                            <th><?php echo $this->lang->line('xin_website');?></th>
                            <th><?php echo $this->lang->line('xin_country');?></th>
                          </tr>
                          <?php $role_resources_ids = $this->Xin_model->user_role_resource(); foreach(total_last_leads() as $ls_leads):?>
                          <?php
						 	// get country
							  $country = $this->Xin_model->read_country_info($ls_leads->country);
							  if(!is_null($country)){
								$c_name = $country[0]->country_name;
							  } else {
								  $c_name = '--';	
							  }	
							  $lead_flup = $this->Clients_model->get_total_lead_followup($ls_leads->client_id);
							// change to client
								if($ls_leads->is_changed == '0'){
									$opt = '<span class="badge bg-purple">'.$this->lang->line('xin_lead').'</span>';
								} else {
									$opt = '<span class="badge bg-green">'.$this->lang->line('xin_contact_person').'</span>';
								}
								if($lead_flup > 0){
								if($ls_leads->is_changed == '0'){
									$ldflp_opt = '<span class="badge bg-red">'.$this->lang->line('xin_lead_followup').'</span>';
								} else {
									$ldflp_opt = '';
								}
							} else {
								$ldflp_opt = '';
							}
							
							if($ls_leads->is_changed == 0){
							$dview = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_lead_add_followup').'"><a href="'.site_url().'admin/leads/followup/'.$ls_leads->client_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
							} else {
								$dview = '';
							}
							?>
                          <tr>
                            <td><?php echo $ls_leads->name.'<br>'.$opt.'<br>'.$ldflp_opt;?></td>
                            <td><?php echo $ls_leads->company_name;?></td>
                            <td><?php echo $ls_leads->email;?></td>
                            <td><?php echo $ls_leads->website_url;?></td>
                            <td><?php echo $c_name;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="quoted_projects">
                <div class="box-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_projects_dashboard_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_project');?>#</th>
                            <th width="180"><?php echo $this->lang->line('xin_project_summary');?></th>
                            <th><?php echo $this->lang->line('xin_p_priority');?></th>
                            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_project_users');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_quote_date');?></th>
                            <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                          </tr>
                          <?php $role_resources_ids = $this->Xin_model->user_role_resource(); foreach(total_last_5_qprojects() as $ls_qprojects):?>
                          <?php
						 	$aim = explode(',',$ls_qprojects->assigned_to);
									 // get user > added by
							$user = $this->Xin_model->read_user_info($ls_qprojects->added_by);
							// user full name
							if(!is_null($user)){
								$full_name = $user[0]->first_name.' '.$user[0]->last_name;
							} else {
								$full_name = '--';	
							}
							// get date
							$estimate_date = $this->Xin_model->set_date_format($ls_qprojects->estimate_date);			
							//project_progress
							if($ls_qprojects->project_progress <= 20) {
								$progress_class = 'progress-bar-danger';
							} else if($ls_qprojects->project_progress > 20 && $ls_qprojects->project_progress <= 50){
								$progress_class = 'progress-bar-warning';
							} else if($ls_qprojects->project_progress > 50 && $ls_qprojects->project_progress <= 75){
								$progress_class = 'progress-bar-info';
							} else {
								$progress_class = 'progress-bar-success';
							}
							
							// progress
							$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$ls_qprojects->project_progress.'%</span>
					<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ls_qprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ls_qprojects->project_progress.'%"></div></div></p>';
					
									
							//status
							if($ls_qprojects->status == 0) {
								$status = '<span class="label label-warning">'.$this->lang->line('xin_not_started').'</span>';
							} else if($ls_qprojects->status ==1){
								$status = '<span class="label label-primary">'.$this->lang->line('xin_in_progress').'</span>';
							} else if($ls_qprojects->status ==2){
								$status = '<span class="label label-success">'.$this->lang->line('xin_completed').'</span>';
							} else if($ls_qprojects->status ==3){
								$status = '<span class="label label-danger">'.$this->lang->line('xin_project_cancelled').'</span>';
							} else {
								$status = '<span class="label label-danger">'.$this->lang->line('xin_project_hold').'</span>';
							}
							
							// priority
							if($ls_qprojects->priority == 1) {
								$priority = '<span class="label label-danger">'.$this->lang->line('xin_highest').'</span>';
							} else if($ls_qprojects->priority ==2){
								$priority = '<span class="label label-danger">'.$this->lang->line('xin_high').'</span>';
							} else if($ls_qprojects->priority ==3){
								$priority = '<span class="label label-primary">'.$this->lang->line('xin_normal').'</span>';
							} else {
								$priority = '<span class="label label-success">'.$this->lang->line('xin_low').'</span>';
							}
							
							//assigned user
							if($ls_qprojects->assigned_to == '') {
								$ol = $this->lang->line('xin_not_assigned');
							} else {
								$ol = '';
								foreach(explode(',',$ls_qprojects->assigned_to) as $desig_id) {
									$assigned_to = $this->Xin_model->read_user_info($desig_id);
									if(!is_null($assigned_to)){
										
									  $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
									 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
										} else {
										if($assigned_to[0]->gender=='Male') { 
											$de_file = base_url().'uploads/profile/default_male.jpg';
										 } else {
											$de_file = base_url().'uploads/profile/default_female.jpg';
										 }
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
										}
									} ////
									else {
										$ol .= '';
									}
								 }
								 $ol .= '';
							}
							
							$client = $this->Clients_model->read_client_info($ls_qprojects->client_id);
							if(!is_null($client)) {
								$client_name = $client[0]->name;
							} else {
								$client_name = '--';
							}
									
							//$new_time = $this->Xin_model->actual_hours_timelog($ls_qprojects->project_id);
							$project_summary = '<a href="'.site_url().'admin/quoted_projects/detail/'.$ls_qprojects->project_id . '">'.$ls_qprojects->title.'</a><br><small>'.$this->lang->line('xin_project_client').': '.$client_name.'</small><br><small>'.$this->lang->line('xin_estimate_hrs').': '.$ls_qprojects->estimate_hrs.'</small>';
							
							// progress
							$project_progress = $pbar.$status;
							$project_no = '<a href="'.site_url().'admin/quoted_projects/detail/'.$ls_qprojects->project_id . '">'.$ls_qprojects->project_no.'</a>';
							?>
                          <tr>
                            <td><?php echo $project_no;?></td>
                            <td><?php echo $project_summary;?></td>
                            <td><?php echo $priority;?></td>
                            <td><?php echo $ol;?></td>
                            <td><?php echo $estimate_date;?></td>
                            <td><?php echo $project_progress;?></td>
                          </tr>
                          <?php endforeach;?>
                        </thead>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
   </div>