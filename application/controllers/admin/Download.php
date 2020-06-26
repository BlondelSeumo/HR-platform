<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
	}
	
	public function output_file($file, $name, $mime_type='') {
		 if(!is_readable($file)) die('File not found or inaccessible!');
		 $size = filesize($file);
		 $name = rawurldecode($name);
		 $known_mime_types=array(
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"jpg" => "image/jpg",
			"php" => "text/plain",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html"=> "text/html",
			"png" => "image/png",
			"jpeg"=> "image/jpg"
		 );
		 
		 if($mime_type==''){
			 $file_extension = strtolower(substr(strrchr($file,"."),1));
			 if(array_key_exists($file_extension, $known_mime_types)){
				$mime_type=$known_mime_types[$file_extension];
			 } else {
				$mime_type="application/force-download";
			 };
		 };
		 
		 //turn off output buffering to decrease cpu usage
		 @ob_end_clean(); 
		 
		 // required for IE, otherwise Content-Disposition may be ignored
		 if(ini_get('zlib.output_compression'))
		 ini_set('zlib.output_compression', 'Off');
		 header('Content-Type: ' . $mime_type);
		 header('Content-Disposition: attachment; filename="'.$name.'"');
		 header("Content-Transfer-Encoding: binary");
		 header('Accept-Ranges: bytes');
		 
		 // multipart-download and download resuming support
		 if(isset($_SERVER['HTTP_RANGE']))
		 {
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			if(!$range_end) {
				$range_end=$size-1;
			} else {
				$range_end=intval($range_end);
			}
		
			$new_length = $range_end-$range+1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range-$range_end/$size");
		 } else {
			$new_length=$size;
			header("Content-Length: ".$size);
		 }
		 
		 /* Will output the file itself */
		 $chunksize = 1*(1024*1024); //you may want to change this
		 $bytes_send = 0;
		 if ($file = fopen($file, 'r'))
		 {
			if(isset($_SERVER['HTTP_RANGE']))
			fseek($file, $range);
		 
			while(!feof($file) && 
				(!connection_aborted()) && 
				($bytes_send<$new_length)
				  )
			{
				$buffer = fread($file, $chunksize);
				echo($buffer); 
				flush();
				$bytes_send += strlen($buffer);
			}
		 fclose($file);
		 } else
		 //If no permissiion
		 die('Error - can not open file.');
		 //die
		die();
		}
		
	public function index() {	
		// type
		$type = $this->input->get('type');
		
		if($type!= '') {
			//Set the time out
			set_time_limit(0);
			
			// file name
			$filename = $this->input->get('filename');
			//path to the file
			$file_path='uploads/'.$type.'/'.$filename;
			
			//Call the download function with file path,file name and file type
			$this->output_file($file_path, ''.$filename.'', 'text/plain');
		}
	}
}
