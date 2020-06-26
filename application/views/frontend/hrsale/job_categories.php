<div id="categories"> 
  <!-- Categories Group -->
  <div class="categories-group">
    <div class="container">
      <div class="four columns">
        <h4>Job Categories</h4>
      </div>
      <?php foreach (array_chunk($all_job_categories, 20) as $row) { ?>
      <div class="four columns">
        <ul>
          <?php $count= 1; foreach($row as $job_category) {?>
          <li><a href="<?php echo site_url().'jobs/search/category/'.$job_category->category_url;?>"><?php echo $job_category->category_name;?> (<?php echo $this->Recruitment_model->job_category_record_count($job_category->category_url);?>)</a></li>
          <?php $count++;}?>
        </ul>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="margin-top-50"></div>
<?php $this->load->view('frontend/hrsale/footer-block');?>