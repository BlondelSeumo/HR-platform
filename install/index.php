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
</head>
<body style="background:linear-gradient(90deg, #000000 0%, #d3e9ff 100%);">
<div class="container" style="margin-top:50px ">
  <div class="row">
    <div class="col-md-6 col-md-offset-5" style="margin-bottom:15px;"> <img src="../skin/img/hrsale-white.png" /> </div>
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading"> <strong class="">HRSALE - The Ultimate HRM</strong> </div>
        <div class="panel-body">
          
          <div class="panel panel-default" data-collapsed="0"
          style="border-color: #dedede;">
            <!-- panel body -->
            <div class="panel-body" style="font-size: 14px;">
            <p style="font-size: 14px;">
              You will need to know the following items before
              proceeding.
            </p>
            <hr/>
            <ol>
              <li>Database Name</li>
              <li>Database Username</li>
              <li>Database Password</li>
              <li>Database Hostname</li>
            </ol>
            <p style="font-size: 14px;">
              We are going to use the above information to write database.php file which will connect the application to your
              database.<br />
              During the installation process, we will check if the files that are needed to be written
              (<strong>application/config/database.php</strong> & <strong>application/config/routes.php</strong>) have
              <strong>write permission</strong>.
            </p>
            <p style="font-size: 14px;">
              Gather the information mentioned above before hitting the start installation button. If you are ready....
            </p>
            <br>
            <p class="text-right">
              <a href="step1.php" class="btn btn-primary">
                Start Installation Process
              </a>
            </p>
    			</div>
    		</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <footer class="main" style="text-align: center;">Need help?  
                <a href="https://hrsale.com/contact.php" target="_blank" style="text-decoration:underline;">Contact support</a>
                </footer>
            </div>
		</div>
        <div class="panel-footer"><?php echo date('Y');?> &copy HRSALE - The Ultimate HRM</div>
      </div>
    </div>
  </div>
</div> 
</body>
</html>
