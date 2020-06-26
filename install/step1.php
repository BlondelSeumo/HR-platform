<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRSALE - The Ultimate HRM</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<style type="text/css">
body {
	font-size: 12px;
}
.form-control {
	height: 32px;
}
.error {
	background: #ffd1d1;
	border: 1px solid #ff5858;
	padding: 4px;
}
</style>
<link rel="stylesheet" href="../skin/hrsale_vendor/assets/vendor/toastr/toastr.min.css">
<link rel="stylesheet" href="../skin/hrsale_vendor/assets/vendor/libs/ladda/ladda.css">
</head>
<body style="background:linear-gradient(90deg, #000000 0%, #d3e9ff 100%);">
<div class="container" style="margin-top:30px ">
  <div class="row">
    <div class="col-md-7 col-md-offset-5" style="margin-bottom:15px;"> <img src="../skin/img/hrsale-white.png" /> </div>
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading"> <strong class="">HRSALE - The Ultimate HRM</strong> </div>
        <div class="panel-body">
          <h4 class="text-center">Setup Database Setings</h4>
          <hr/>
          <form class="form-horizontal" id="install_form" method="post" action="install_application.php" autocomplete="off">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label">Hostname</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" id="hostname" value="localhost" name="hostname">
                <span style="font-size:12px;">If 'localhost' does not work, you can get the hostname from web host</span>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label">Database Username</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" name="username" value="root">
                <span style="font-size:12px;">Your database username</span>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label">Database Password</label>
              <div class="col-sm-8">
                <input class="form-control" type="password" id="password" name="password">
                <span style="font-size:12px;">Your database password</span>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label">Database Name</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" id="database" name="database">
                <span style="font-size:12px;"> Your database name</span>
              </div>
            </div>
            <hr>
            <div class="form-group last">
              <div class="col-sm-offset-3 col-sm-8">
                <button type="submit" class="btn btn-success" id="submit">Install</button>
                <button type="reset" class="btn btn-default reset">Reset</button>
              </div>
            </div>
          </form>
          <p class="error text-center">Please make sure the application/config/database.php file is writable.<br />
            <strong>Example:</strong> <code>chmod 777 application/config/database.php</code></p>
        </div>
        <div class="panel-footer"><?php echo date('Y');?> &copy HRSALE - The Ultimate HRM</div>
      </div>
    </div>
  </div>
</div>
<script src="../skin/hrsale_vendor/assets/vendor/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../skin/hrsale_vendor/assets/vendor/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../skin/hrsale_vendor/assets/vendor/libs/spin/spin.js"></script>
<script src="../skin/hrsale_vendor/assets/vendor/libs/ladda/ladda.js"></script>
<script src="../skin/hrsale_vendor/assets/vendor/toastr/toastr.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = true;
	toastr.options.progressBar = true;
	toastr.options.timeOut = 2000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "toast-top-center";
	Ladda.bind('button[type=submit]');
	$('.reset').prop('disabled', true);
	$("#install_form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=install&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.reset').prop('disabled', false);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					$('.reset').prop('disabled', false);
					window.location = 'finalizing_setup.php';
				}
			}
		});
	});
});
</script>
</body>
</html>
