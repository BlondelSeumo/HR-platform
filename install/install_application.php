<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){
	/*Detect AJAX and POST request*/
}
error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

// Load the classes and create the new objects
require_once('includes/core_class.php');
$core = new Core();

// Only load the classes in case the user submitted the form
if(!empty($_POST) && $_POST['is_ajax']=='1' && $_POST['type']=='install'){
    /* Define return | here result is used to return user data and error for error message */
    $Return = array('result'=>'', 'error'=>'');
	
	$hostname = $_POST['hostname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$database = $_POST['database'];
	
	/* Server side PHP input validation */
    if($hostname==='') {
        $Return['error'] = 'The hostname field is required.';
    } else if($username==='') {
        $Return['error'] = 'The username field is required.';
    } /*else if($password==='') {
        $Return['error'] = 'The password field is required.';
    }*/ else if($database==='') {
        $Return['error'] = 'The database field is required.';
    }
		
   	/*Display Error. */		
    if($Return['error']!=''){
        $core->output($Return);
    }
	// First create tables for database, then write the config file
	// Connect to the database
	$mysqli = new mysqli($hostname,$username,$password,$database);

	// Check for errors
	if(mysqli_connect_errno()) {
		$Return['error'] = 'The database you are trying to use for the application does not exist. Please create the database first';
	}
	/*Display Error. */		
	if($Return['error']!=''){
		$core->output($Return);
	}
	// Open the default SQL file
	$query = file_get_contents('assets/install.sql');                
	// Execute a multi query
	$mysqli->multi_query($query);

	// Close the connection
	$mysqli->close();
	$core->write_config($hostname,$username,$password,$database);
	//start session
	session_start();
	$_SESSION['hostname'] = $hostname;
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	$_SESSION['database']   = $database;	

	if($database){
		$Return['result'] = "Password changed successfully.";
	} else {
		$Return['error'] = "You don't have valid purchase code of HRSALE";
	}
	/*Return*/
	$core->output($Return);
}

?>