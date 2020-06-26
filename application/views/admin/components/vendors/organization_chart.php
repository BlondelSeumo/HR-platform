<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/orgchart/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/orgchart/css/jquery.orgchart.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/orgchart/css/style.css">
<style type="text/css">
.orgchart {
	background: #fff;
}
#chart-container {
 <?php if($theme[0]->org_chart_layout=='t2b' || $theme[0]->org_chart_layout=='b2t'):?>  text-align: center !important;
 <?php elseif($theme[0]->org_chart_layout=='l2r'):?>  text-align: left !important;
 <?php elseif($theme[0]->org_chart_layout=='r2l'):?>  text-align: right !important;
 <?php endif;
?>
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/orgchart/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_vendor/assets/vendor/orgchart/js/jquery.orgchart.js"></script>
<?php $main_companies = get_main_companies_chart();?>
<script type="text/javascript">
    $(function() {
	var datascource = {
      'name': '<?php echo $company[0]->company_name;?>',
      'title': '<?php echo $this->lang->line('xin_company_administrator');?>',
      'children': [
	  <?php foreach($main_companies as $cr){ ?>
	   <?php
	   	// company type
		  $ctype = $this->Company_model->read_company_type($cr->type_id);
		  if(!is_null($ctype)){
			$type_name = $ctype[0]->name;
		  } else {
			 $type_name = '--';	
		  }
	   ?>
		{ 'name': '<?php echo $cr->name;?>', 'title': '<?php echo $type_name;?>',
			<?php $location_chart = get_main_companies_location_chart($cr->company_id);?>
			
		'children': [
			<?php foreach($location_chart as $lchart){ ?>
			<?php $location_user = $this->Xin_model->read_user_info($lchart->location_head);
			if(!is_null($location_user)){
				$location_head = $location_user[0]->first_name.' '.$location_user[0]->last_name;
			} else {
				$location_head = '';
			}
			?>
			{ 'name': '<?php echo $location_head;?>', 'title': '<?php echo $lchart->location_name;?>',
				<?php $ldepartment = get_location_departments_head_employees($lchart->location_id);?>
				'children': [
				  <?php foreach($ldepartment as $r){ ?>
					<?php $user = $this->Xin_model->read_user_info($r->employee_id);
					if(!is_null($user)){
						$department_head = $user[0]->first_name.' '.$user[0]->last_name;
					} else {
						$department_head = '';
					}
					?>
					{ 'name': '<?php echo $department_head;?>', 'title': '<?php echo $r->department_name;?>',
					<?php $subdesign = get_departments_designations($r->department_id,$r->employee_id);?>
					'children': [
						<?php foreach($subdesign as $sdesign){ ?>
						
						{ 'name': '<?php echo $sdesign->first_name.' '.$sdesign->last_name;?>', 'title': '<?php echo $sdesign->designation_name;?>',
						},
						
						<?php }?>
					]
					},
					<?php }?>
				  ]
			},
			<?php }?>
			]
		},
		<?php }?>
	  ]
	  
    };

    $('#chart-container').orgchart({
      'data' : datascource,
      'visibleLevel': 5,
      'nodeContent': 'title',
      'exportButton': <?php echo $theme[0]->export_orgchart;?>,
      'exportFilename': '<?php echo $theme[0]->export_file_title;?>',
	  'pan': <?php echo $theme[0]->org_chart_pan;?>,
      'zoom': <?php echo $theme[0]->org_chart_zoom;?>,
      'direction': '<?php echo $theme[0]->org_chart_layout;?>'
    });

  });
  </script>
