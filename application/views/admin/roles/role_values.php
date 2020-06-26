<script type="text/javascript">
//$(document).ready(function(){
	jQuery("#treeview_r1").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
	/*template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
	},
	template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
	},*/
	template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text #</span></label>"
	},
	//<label class='custom-control custom-checkbox'><input type='checkbox' class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>
	
	//template: "<label class="custom-control custom-checkbox"><input type="checkbox" #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class="custom-control-label">#= item.add_info #</span></label>"
	check: onCheck,
	dataSource: [
	
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('let_staff');?>",  add_info: "", value: "103",  items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('dashboard_employees');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "13",  items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "13",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "201",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "202",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "203",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_view_company_emp_title');?>",  add_info: "<?php echo $this->lang->line('xin_view_company_emp_title');?>", value: "372",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_view_location_emp_title');?>",  add_info: "<?php echo $this->lang->line('xin_view_location_emp_title');?>", value: "373",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_hrsale_custom_fields');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "393",  items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "393",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "394",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "395",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "396",}
	]},	
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('hr_staff_dashboard_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "422"},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_set_employees_salary');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "351"},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_download_profile_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "421"},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_employees_directory');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "88"},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_employees_exit');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "23",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "23",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "204",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "205",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "206",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_employees_exit').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "231",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_e_details_exp_documents');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "400"},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_employees_last_login');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "22"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('header_my_profile');?>",  add_info: "<?php echo $this->lang->line('header_my_profile');?>", value: "445"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_lock_user');?>",  add_info: "<?php echo $this->lang->line('xin_lock_user');?>", value: "465"},
	]},
	//
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_hr');?>",  add_info: "", value: "12",  items: [
	
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_awards');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "14",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "14",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "207",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "208",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "209",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_awards').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "232",},
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_transfers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "15",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "15",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "210",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "211",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "212",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_transfers').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "233",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_resignations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "16",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "16",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "213",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "214",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "215",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_resignations').'</small>';?>",  add_info: "<?php echo $this->lang->line('left_resignations');?>", value: "234",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_manager_level_title').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_manager_level_title');?>", value: "406"},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_hrd_level_title').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_hrd_level_title');?>", value: "407"},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_gm_om_level_title').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_gm_om_level_title');?>", value: "408"}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_travels');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "17",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "17",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "216",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "217",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "218",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_travels').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "235",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_promotions');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "18",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "18",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "219",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "220",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "221",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_promotions').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "236",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_complaints');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "19",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "19",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "222",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "223",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "224",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_complaints').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "237",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_warnings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "20",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "20",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "225",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "226",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "227",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_warnings').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "238",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_terminations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "21",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "21",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "228",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "229",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "230",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_terminations').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "239",}
	]}
	]},
	
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_organization');?>", add_info: "", value:"2", items: [
	// sub 1
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_department');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "3",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "3",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "240",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "241",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "242",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_designation');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "4",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "4",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "243",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "244",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "245",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_designation').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "249",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_company');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "5",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "5",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "246",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "247",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "248",},
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_location');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "6",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "6",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "250",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "251",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "252",},	
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_announcements');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "11",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "11",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "254",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "255",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "256",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_announcements').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "257",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('left_policies');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "9",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "9",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "258",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "259",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "260",}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_org_chart_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "96",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_official_documents');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "442",},
	]}, // sub 1 end
	
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "", value: "24",  items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "25",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "25",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "262",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "263",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "264",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_assets').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "265"}
	]},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_acc_category');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "26",items: [
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "26",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "266",},
	{ id: "", class: "role-checkbox custom-control-input custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "267",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "268",}
	]},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_events_meetings');?>",  add_info: "", value: "97",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_events');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "98",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "98",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "269",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "270",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "271",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_hr_events').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "272",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_meetings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "99",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "99",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "273",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "274",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "275",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_hr_meetings').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "276",}
	]},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_timesheet');?>",  add_info: "", value: "27",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "28", items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "28",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_timesheet').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "397",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('hr_timesheet_dashboard_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "423"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_month_timesheet_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "10", items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "10",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_month_timesheet_title').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "253",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_attendance_timecalendar');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "261",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_date_wise_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "29",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "29",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_date_wise_attendance').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "381",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_update_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "30",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "30",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "277",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "278",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "279",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_upd_company_attendance').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "310",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_overtime_request');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "401", items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "401"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "402"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "403"},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_leave_status');?>",  add_info: "<?php echo $this->lang->line('xin_attendance_import');?>", value: "31",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_office_shifts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "7",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "7",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "280",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "281",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "282",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_change_default');?>",  add_info: "<?php echo $this->lang->line('xin_role_change_default');?>", value: "2822",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_office_shifts').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "311",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_holidays');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "8",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "8",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "283",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "284",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "285",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_leaves');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "46",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "46",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "287",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "288",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "289",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_leaves').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "290",}
	]},
	
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_recruitment');?>",  add_info: "", value: "48",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_job_posts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "49",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "49",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "291",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "292",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "293",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_jobs_listing');?> <small><?php echo $this->lang->line('left_frontend');?></small>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "50"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_job_candidates');?>",  add_info: "<?php echo $this->lang->line('xin_update_status_delete');?>", value: "51",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "51",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_dwn_resume');?>",  add_info: "<?php echo $this->lang->line('xin_role_dwn_resume');?>", value: "294",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "295",}
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_jobs_employer');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "52"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_jobs_cms_pages');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "296"},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_payroll');?>",  add_info: "", value: "32",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_generate_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "36",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "36",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "313",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_generate_company_payslips').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "314",}
	]},
	/**/
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_payroll_verifier_title');?>",  add_info: "<?php echo $this->lang->line('xin_payroll_verifier_title');?>", value: "404"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_payroll_approver_title');?>",  add_info: "<?php echo $this->lang->line('xin_payroll_approver_title');?>", value: "405"},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_performance');?>",  add_info: "", value: "40",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_performance_indicator');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "41",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "41",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "298",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "299",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "300",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_performance_indicator').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "301",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_performance_appraisal');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "42",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "42",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "302",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "303",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "304",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_performance_appraisal').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "305",}
	]},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_tickets');?>",  add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", value: "43",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "43",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "306",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "307",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "308",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_tickets').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "309",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "", value: "104",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "44",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "44",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "315",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "316",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "317",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_projects').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "318",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('hr_project_dashboard_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "312",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "45",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "45",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "319",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "320",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "321",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_tasks').'</small>';?>", value: "322",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_tasks_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "90",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_tasks_sboard');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "91",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_project_timelogs');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "94",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_projects_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "424",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_projects_sboard');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "425",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_invoice_tax_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "122",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "122",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "331",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "332",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "333",}
	]},
	]},
		
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  add_info: "", value: "106",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "107",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "107",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "334",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "335",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "336",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "108",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "108",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "338",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "339",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "340",}
	]},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_files_manager');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "47",},

	]
	});
	
	jQuery("#treeview_r2").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
	/*template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"*/
	template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text #</span></label>"
	},
	//template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
	//},
	check: onCheck,
	dataSource: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_training');?>",  add_info: "", value: "53",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_training_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "54",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "54",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "341",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "342",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "343",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_training').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "344",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_training_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "55",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "55",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "345",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "346",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "347",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_trainers_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "56",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "56",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "348",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "349",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "350",}
	]},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "", value: "57",  items: [
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_settings');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "60",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "61",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_db_backup');?>",  add_info: "<?php echo $this->lang->line('xin_create_delete_download');?>", value: "62",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_email_templates');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "63",},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_setup_modules');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "93",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_payment_gateway');?>",  add_info: "<?php echo $this->lang->line('xin_system');?>", value: "118",},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "297",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_general');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "431",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_employee_role');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "432",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_payroll');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "433",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_recruitment');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "434",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_performance');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "435",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_system_logos');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "436",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_email_notifications');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "437",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_page_layouts');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "438",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_notification_position');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "439",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_files_manager');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "440",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_org_chart_title');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "441",},
	
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "447",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_e_details_contract_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "448",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_e_details_qualification');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "449",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_e_details_dtype');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "450",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_award_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "451",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_ethnicity_type_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "452",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_leave_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "453",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_warning_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "454",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_expense_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "455",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_income_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "456",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_job_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "457",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_rec_job_categories');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "458",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_currency_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "459",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_company_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "460",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_security_level');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "461",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_termination_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "462",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_employee_exit_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "463",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_travel_arrangement_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "464",},
	]},
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_accounts');?>", add_info: "",value: "71",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('hr_accounting_dashboard_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "286",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "72",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "72",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "352",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "353",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "354",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_balances');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "73",},
	]},
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_transactions');?>", add_info: "",value: "74",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_deposit');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "75",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "75",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "355",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "356",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "357",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_expense');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "76",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "76",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "358",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "359",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "360",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_transfer');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "77",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "77",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "361",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "362",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "363",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_view_transactions');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "78",},
	{ id: "", class: "role-checkbox custom-control-input-modal", text: "<?php echo $this->lang->line('xin_payslip_history');?>",  add_info: "<?php echo $this->lang->line('xin_view_payslip');?>", value: "37", check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox custom-control-input-modal", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "37", check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox custom-control-input-modal", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_payment_history').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "391", check: "<?php if(isset($_GET['role_id'])) { if(in_array('391',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_payees_payers');?>", add_info: "",value: "79",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_payees');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "80",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "80",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "364",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "365",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "366",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_payers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "81",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "81",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "367",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "368",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "369",}
	]},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_accounts').' '.$this->lang->line('xin_acc_reports');?>", add_info: "",value: "82",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_statement');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "83"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_expense_reports');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "84",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_income_reports');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "85",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_transfer_report');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "86",},
	]},
	/*{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('hd_changelog');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "87",},*/
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_quote_manager');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "87",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_project_clients');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "119",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "119",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "323",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "324",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "325",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "326",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_leads');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "410",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "411",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "412",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "413",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "414",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "420",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_estimates');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "415",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "416",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_create');?>",  add_info: "<?php echo $this->lang->line('xin_role_create');?>", value: "417",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "418",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "419",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_invoices_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "121",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "121",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_create');?>",  add_info: "<?php echo $this->lang->line('xin_role_create');?>", value: "120",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "328",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "329",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_invoice_payments');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "330",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_invoice_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "426",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_quote_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "427",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_quoted_projects');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "428",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_estimate_leads');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "429",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_estimate_timelogs');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "430",},
	
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_lang_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "89",items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "89",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "370",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "371",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_calendar_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "95",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_import_employees');?>",  add_info: "<?php echo $this->lang->line('xin_import_employees');?>", value: "92"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_import_attendance');?>",  add_info: "<?php echo $this->lang->line('left_import_attendance');?>", value: "443"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_import_leads');?>",  add_info: "<?php echo $this->lang->line('xin_import_leads');?>", value: "444"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_chat_box');?>",  add_info: "<?php echo $this->lang->line('xin_hr_chat_box');?>", value: "446"},
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_hr_report_title');?>", add_info: "",value: "110",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "111"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_attendance_employee');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "112"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_training');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "113"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_projects');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "114"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "115"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_report_user_roles');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "116"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_report_employees');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "117"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_report_leave_report');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "409"},
	]},
	//
	]
	});
//});
// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
		treeView = jQuery("#treeview2").data("kendoTreeView"),
		message;
		jQuery("#result").html(message);
}
</script>