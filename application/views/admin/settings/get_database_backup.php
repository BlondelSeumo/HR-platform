<?php $db_backup = $this->Xin_model->all_db_backup();?>
<div class="form-group" id="ajx_restore">
  <label class="form-label control-label"><?php echo $this->lang->line('xin_database_choose_backup');?></label>
  <select class="form-control" name="restore_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_database_choose_backup');?>">
    <option value=""><?php echo $this->lang->line('xin_database_choose_backup');?></option>
	<?php  foreach($db_backup->result() as $dbr) { ?>
    <option value="<?php echo $dbr->backup_id;?>"><?php echo $dbr->backup_file;?></option>
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