<?php
/* Job pages view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_post/');?>" data-link-data="<?php echo site_url('admin/job_post/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-newspaper"></span> <?php echo $this->lang->line('left_job_posts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('header_apply_jobs_frontend');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('51',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_candidates/');?>" data-link-data="<?php echo site_url('admin/job_candidates/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('left_job_candidates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_job_candidates');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('52',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_post/employer/');?>" data-link-data="<?php echo site_url('admin/job_post/employer/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-ninja"></span> <?php echo $this->lang->line('xin_jobs_employer');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_add');?> <?php echo $this->lang->line('xin_jobs_employer');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('296',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/job_post/pages/');?>" data-link-data="<?php echo site_url('admin/job_post/pages/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon ion ion-ios-paper"></span> <?php echo $this->lang->line('xin_jobs_cms_pages');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_update');?> <?php echo $this->lang->line('xin_jobs_cms_pages');?></div>
      </a> </li>
     <?php } ?> 
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_jobs_cms_pages');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
            <th><?php echo $this->lang->line('xin_jobs_page_url');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
