<?php
//$result = $this->Xin_model->get_company_employees_multi($company_id);
$company_ids = explode(',',$company_id)?>
<div class="form-group">
  <label for="xin_project_manager"><?php echo $this->lang->line('xin_project_manager');?></label>
   <select multiple="multiple" name="assigned_to[]" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_manager');?>">
    <option value=""><?php echo $this->lang->line('xin_project_manager');?></option>
    <?php foreach($company_ids as $cid) {?>
    <?php $result = $this->Xin_model->get_company_employees_multi($cid); ?>
    <?php foreach($result as $re) {?>
    <option value="<?php echo $re->user_id;?>"> <?php echo $re->first_name.' '.$re->last_name;?></option>
    <?php } ?>
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