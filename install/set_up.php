<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){
	/*Detect AJAX and POST request*/
 
}
session_start();

error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.
// Load the classes and create the new objects
require_once('includes/core_class.php');

$core = new Core();
// Only load the classes in case the user submitted the form
if(!empty($_POST) && $_POST['is_ajax']=='1' && $_POST['type']=='set_up'){
    /* Define return | here result is used to return user data and error for error message */
    $Return = array('result'=>'', 'error'=>'');
	$conn = new mysqli($_SESSION['hostname'],$_SESSION['username'],$_SESSION['password'],$_SESSION['database']);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$application_name = $_POST['application_name'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$system_timezone = $_POST['system_timezone'];
	
	/* Server side PHP input validation */
    if($application_name==='') {
        $Return['error'] = 'The application name field is required.';
    } else if($first_name==='') {
        $Return['error'] = 'The first name field is required.';
    } else if($last_name==='') {
        $Return['error'] = 'The last name field is required.';
    } else if($username==='') {
        $Return['error'] = 'The username field is required.';
    } else if($email==='') {
        $Return['error'] = 'The email field is required.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$Return['error'] = 'Invalid email address.';
	} else if($password==='') {
        $Return['error'] = 'The password field is required.';
    } else if(strlen($password) < 6) {
		 $Return['error'] = 'The password must be at least 6 characters.';
	}
		
   	/*Display Error. */		
    if($Return['error']!=''){
        $core->output($Return);
    }
	
	$sql = "UPDATE xin_system_setting SET application_name='$application_name',system_timezone='$system_timezone' WHERE setting_id=1";

	if ($conn->query($sql) === TRUE) {
		$options = array('cost' => 12);
		$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
		$user_sql = "UPDATE xin_employees SET first_name='$first_name',last_name='$last_name',email='$email',username='$username',password='$password_hash' WHERE user_id=1";
		$conn->query($user_sql);
		$_SESSION['admin_username'] = $username;
	  	$Return['result'] = "You have successfully installed the HRSALE - Ultimate HRM.";
	} else {
	  $Return['error'] = "Error updating record: " . $conn->error;
	}		
	/*Return*/
	$core->output($Return);
}

?>