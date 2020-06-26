<?php $result = $this->Project_model->ajax_company_projects($company_id);?>
<div class="form-group" id="project_ajax">
  <label for="project_ajax" class="control-label"><?php echo $this->lang->line('xin_project');?></label>
  <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
    <option value=""></option>
    <?php foreach($result as $project) {?>
    <option value="<?php echo $project->project_id?>"> <?php echo $project->title;?></option>
    <?php } ?>
  </select>
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>