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

class Employer extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Xin_model');
		$this->load->model("Job_post_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Xin_recruitment_model");
	}
	// post new job
	public function post_a_job() {		
		$data['title'] = $this->Xin_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_post_new", $data, TRUE);
		$this->load->view('frontend/layout/job_layout_main', $data); //page load
	}
	// manage jobs
	public function manage_jobs() {		
		$data['title'] = $this->Xin_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_manage_jobs", $data, TRUE);
		$this->load->view('frontend/layout/job_layout_main', $data); //page load
	}
	// candidates resumes
	public function candidates_resumes() {		
		$data['title'] = $this->Xin_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_resume", $data, TRUE);
		$this->load->view('frontend/layout/job_layout_main', $data); //page load
	}
	// change password
	public function change_password() {		
		$data['title'] = $this->Xin_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_change_password", $data, TRUE);
		$this->load->view('frontend/layout/job_layout_main', $data); //page load
	}
}