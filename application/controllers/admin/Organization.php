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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          //load the login model
          $this->load->model('Company_model');
		  $this->load->model("Department_model");
		  $this->load->model("Designation_model");
		  $this->load->model('Xin_model');
     }
	 
	//chart page //
	public function chart() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_orgchart!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_org_chart_title').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_org_chart_title');
		$data['path_url'] = 'organization_chart';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('96',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/orgchart/orgchart", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	
	
} 
?>