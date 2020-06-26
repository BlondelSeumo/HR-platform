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

class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Xin_model');
		$this->load->model("Job_post_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Xin_recruitment_model");
	}
	
	public function index()
	{		
		$data['title'] = $this->Xin_model->site_title().' | Log in';
		$data['subview'] = $this->load->view("frontend/login", $data, TRUE);
		$this->load->view('frontend/layout/job_layout_main', $data); //page load
	}
}