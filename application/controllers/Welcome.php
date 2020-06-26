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

class Welcome extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->model('Employees_model');
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment=='true'){
			$data['title'] = 'HOME';
			$data['path_url'] = 'job_home';
			$data['all_jobs'] = $this->Recruitment_model->get_all_jobs_last_desc();
			$data['all_featured_jobs'] = $this->Recruitment_model->get_featured_jobs_last_desc();
			$data['all_job_categories'] = $this->Recruitment_model->all_job_categories();
			$data['subview'] = $this->load->view("frontend/hrsale/home-2", $data, TRUE);
			$this->load->view('frontend/hrsale/job_layout/job_layout', $data); //page load
		} else {
			$data['title'] = $this->Xin_model->site_title().' | Log in';
			$theme = $this->Xin_model->read_theme_info(1);
			if($theme[0]->login_page_options == 'login_page_1'):
				$this->load->view('admin/auth/login-1', $data);
			elseif($theme[0]->login_page_options == 'login_page_2'):
				$this->load->view('admin/auth/login-2', $data);
			elseif($theme[0]->login_page_options == 'login_page_3'):
				$this->load->view('admin/auth/login-3', $data);
			elseif($theme[0]->login_page_options == 'login_page_4'):
				$this->load->view('admin/auth/login-4', $data);
			elseif($theme[0]->login_page_options == 'login_page_5'):
				$this->load->view('admin/auth/login-5', $data);				
			else:
				$this->load->view('admin/auth/login-1', $data);	
			endif;
			
		}
     }
}
