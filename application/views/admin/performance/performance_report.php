<?php
/* Performance Report view
*/
?>
<?php $session = $this->session->userdata('username');?>

<section id="decimal">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h4 class="box-title"><?php echo $this->lang->line('kpi_report');?></h4>
        </div>
        <div class="box-body collapse in">
          <div class="box-block card-dashboard">
            <p>
            Download Performance KPI for all employee
            </p>
            <?php $attributes = array('name' => 'download_kpi', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php echo form_open('admin/performance_report/download_kpi', $attributes);?>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="kpi_quarter_name"><?php echo $this->lang->line('kpi_select_quarter');?></label>
                  <select name="kpi_quarter_name" id="kpi_quarter_name" class="form-control">
                    <option value="All">All</option>
                    <option value="1"><?php echo $this->lang->line('kpi_first_quarter');?></option>
                    <option value="2"><?php echo $this->lang->line('kpi_second_quarter');?></option>
                    <option value="3"><?php echo $this->lang->line('kpi_third_quarter');?></option>
                    <option value="4"><?php echo $this->lang->line('kpi_fourth_quarter');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="kpi_year"><?php echo $this->lang->line('kpi_select_year');?></label>
                  <select name="kpi_year" id="kpi_year" class="form-control" data-plugin="select_hrm">
                    <?php for($i=2019;$i<=2030;$i++) : ?>
                    <option value="<?php echo $i;?>" <?php echo (date('Y') == $i)?'selected':''; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <label for="downloadBtn">Download</label>
                <div class="form-group">
                  <input type="submit" id="downloadBtn" class="btn btn-primary" value="Download all KPI &raquo;">
                </div>
              </div>
            </div>
            <?php form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
