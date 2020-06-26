<?php $session = $this->session->userdata('c_user_id');?>
<?php $employer = $this->Recruitment_model->read_employer_info($session['c_user_id']);?>
<div class="container">
  <div class="sixteen columns">
    <h2 class="my-acc-h2">Hello <strong><?php echo $employer[0]->first_name.' '.$employer[0]->last_name;?></strong></h2>
    <p class="woocommerce-dashboard-welcome"> From your account dashboard you can view your jobs applications</a>, manage your <a href="<?php echo site_url('employer/manage_jobs');?>">jobs</a> and <a href="<?php echo site_url('employer/account');?>">edit your password and account details</a>.</p>
    <p> To check your Job Listings and Applications visit <a href="<?php echo site_url('employer/manage_jobs');?>">Jobs Listings</a>.<br>
    </p>
    <br>
    <a href="<?php echo site_url('employer/post_job');?>" class="button">Add a Job</a> </div>
</div>
<div class="margin-top-50"></div>