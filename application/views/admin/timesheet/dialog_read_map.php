<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['ipaddress']) && $_GET['data']=='view_map'){
	$ipAdress = $_GET['ipaddress'];
	$att_location = $this->Xin_model->get_employee_attendance_location($_GET['uid'],$_GET['start_date']);	
	if($_GET['att_type'] == 'clock_in'){
		$clock_latitude = $att_location[0]->clock_in_latitude;
		$clock_longitude = $att_location[0]->clock_in_longitude;
		
	} else {
		$clock_latitude = $att_location[0]->clock_out_latitude;
		$clock_longitude = $att_location[0]->clock_out_longitude;
	}
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_map_address');?></h4>
</div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <?php	
			//$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ipAdress));
			//if($query && $query['status'] == 'success') {			
			// query2
			$query2 = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$clock_latitude.",".$clock_longitude."&sensor=true&key=".$system[0]->google_maps_api_key."");
			$json = json_decode($query2, true);
		  ?>
          <div id="map" style="width:100%;height:400px;"></div>
          <script type="text/javascript">
            var locations = [
              ['<?php echo $json['results'][0]['formatted_address'];?>', <?php echo $clock_latitude;?>,<?php echo $clock_longitude;?>, 0]
            ];
        
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 16,
              center: new google.maps.LatLng(<?php echo $clock_latitude;?>,<?php echo $clock_longitude;?>),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            });
        
            var infowindow = new google.maps.InfoWindow();
        
            var marker, i;
        
            for (i = 0; i < locations.length; i++) {  
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
              });
        
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
          </script>
          <?php
		  /*} else {
			  echo $this->lang->line('xin_map_unable_get_location');
			}*/
		  ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php } ?>
