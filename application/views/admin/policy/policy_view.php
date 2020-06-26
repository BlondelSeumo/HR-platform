<?php
/* Policy view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php
$role_resources_ids = $this->Xin_model->user_role_resource();
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->user_role_id==1){
	$policy = $this->Policy_model->get_policies();
} else {
	$policy = $this->Policy_model->get_company_policies($user_info[0]->company_id);
}
$data = array();
?>

<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="text-center font-weight-bold py-1 mb-2">
      <?php echo $this->lang->line('xin_policies');?>
      <?php if(in_array('258',$role_resources_ids)) {?>
      <a class="text-dark" href="<?php echo site_url('admin/policy/');?>"><button type="button" class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp; <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_policy');?></button></a><?php } ?>
    </h3>
    <hr class="container-m-nx border-light my-0">
</div>

<div id="smartwizard-4" class="smartwizard-vertical-left smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <?php $i=1;foreach($policy->result() as $r) { ?>
        <?php
        // get company
        if($r->company_id=='0'){
            $company = $this->lang->line('xin_all_companies');
        } else {
            $p_company = $this->Xin_model->read_company_info($r->company_id);
            if(!is_null($p_company)){
                $company = $p_company[0]->name;
            } else {
                $company = '--';	
            }
        }
        ?>
        <li class="nav-item <?php if($i==1):?>active<?php else:?>done<?php endif;?>">
        <a href="#policy_<?php echo $r->policy_id;?>" class="text-nowrap mb-3 nav-link">
          <span class="sw-done-icon ion ion-md-checkmark"></span>
          <span class="sw-icon ion ion-ios-keypad"></span>
          <div class=""><?php echo $r->title;?></div>
           <div class="small"><?php echo $company;?></div>
        </a>
      </li>
      <?php $i++;}?>
    </ul>

    <div class="mb-3 sw-container tab-content">
     <?php $j=1;foreach($policy->result() as $r) { ?>
      <div id="policy_<?php echo $r->policy_id;?>" class="card animated fadeIn mb-3 tab-pane step-content" <?php if($j==1):?>style="display: block;"<?php else:?>style="display: none;"<?php endif;?>>
        <div class="card-body">
        <h4 class="media align-items-center my-3">
          <div class="ion ion-ios-keypad ui-w-40 text-large"></div>
          <div class="media-body ml-1">
            <?php echo $r->title;?>
            <div class="text-muted text-tiny font-weight-light"><?php echo $company;?></div>
          </div>
        </h4>
          <?php echo html_entity_decode($r->description);?>
        </div>
      </div>
      <?php $j++;}?>                
    </div>
  </div>
