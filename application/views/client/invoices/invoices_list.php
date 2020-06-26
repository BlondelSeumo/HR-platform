<?php
/* Invoices List
*/
?>
<?php //$session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_invoices_title');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_invoice_no');?></th>
            <th><?php echo $this->lang->line('xin_project');?></th>
            <th><?php echo $this->lang->line('xin_acc_total');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_due_date');?></th>
            <th><?php echo $this->lang->line('kpi_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
