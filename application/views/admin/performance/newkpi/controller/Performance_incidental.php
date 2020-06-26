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

class Performance_incidental extends MY_Controller {
	
	public function __construct() 
	{
        Parent::__construct();
		//load the model
		$this->load->model('Xin_model');
		$this->load->model('Performance_incidental_model');
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
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_performance!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_performance_kpi');
		$data['breadcrumbs'] = $this->lang->line('left_performance_kpi');
		$data['path_url'] = 'performance_incidental';

		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('119',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/performance/performance_appraisal_kpi", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
    }

    public function add_incidental_kpi ()
    {
    	if($this->input->post('add_type')=='kpi_incidental') {
    		$Return = array('result'=>'', 'error'=>'');
    		if($this->input->post('kpi_incidental')==='') {
        		$Return['error'] = $this->lang->line('xin_error_kpi_incidental_field');
        	}

        	if($Return['error']!=''){
	       		$this->output($Return);
	    	}

	    	//add to db goes here
	    	$data = array(
				'user_id' => $this->input->post('_user'),
				'incidental_kpi' => $this->input->post('kpi_incidental'),
                'targeted_date' => $this->input->post('incidental_targeted_date'),
				'status' => 1,
				'quarter' => $this->input->post('incidental_quarter_name'),
				'year_created' => $this->input->post('incidental_year'),
				'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
			);
    		$result = $this->Performance_incidental_model->add($data);

    		if ($result == TRUE) {
    			$Return['result'] = $this->lang->line('xin_success_kpi_incidental_added');
    		}

	    	$this->output($Return);
			exit;	
    	}
    }

    public function incidental_list ()
    {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		// if(!empty($session)){ 
		// 	$this->load->view("admin/performance_kpi", $data);
		// } else {
		// 	redirect('');
		// }
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$user_id = $this->uri->segment(4);


        if (isset($user_id)) {
            $incidental = $this->Performance_incidental_model->get_kpi_incidental($user_id);
        } else {
            $incidental = $this->Performance_incidental_model->get_kpi_incidental($session['user_id']);
        }
		
		$data = array();

        foreach($incidental->result() as $r) {
        	$created_at = $this->Xin_model->set_date_time_format($r->created_at);
            $updated_at = $this->Xin_model->set_date_time_format($r->updated_at);
        	if ($r->user_id != $session['user_id']) {
        		$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-incidental-data" data-incidental_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
        	} else {
        		//$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-incidental-data" data-incidental_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
                $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-incidental-data" data-incidental_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete-incidental" data-toggle="modal" data-target=".delete-modal-incidental" data-record-id="'. $r->id . '"><i class="fa fa-trash-o"></i></button></span>';
        	}
		   	$data[] = array(
		   		$action,
				$r->incidental_kpi,
                $r->targeted_date,
				$r->result,
				$r->status,
				$r->feedback,
				$created_at,
                $updated_at
		   	);
	  	}

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $incidental->num_rows(),
			 "recordsFiltered" => $incidental->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
    }

    public function delete_incidental() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Performance_incidental_model->delete_incidental_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('kpi_incidental_deleted_successful');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}

	// get record of incidental
	public function read_incidental_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$incidental_id = $this->input->get('incidental_id');
		$result = $this->Performance_incidental_model->read_incidental_information($incidental_id);
		
		$data = array(
				'incidental_id' => $result[0]->id,
				'user_id' => $result[0]->user_id,
				'incidental_kpi' => $result[0]->incidental_kpi,
                'incidental_targeted_date' => $result[0]->targeted_date,
				'result' => $result[0]->result,
				'status' => $result[0]->status,
				'feedback' => $result[0]->feedback
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/performance/dialog_incidental', $data);
		} else {
			redirect('admin/');
		}
	}

	// Validate and add info in database
	public function edit_incidental() {
	
		if($this->input->post('edit_type')=='incidental') {
			
		$id = $this->uri->segment(4);	
		$Return = array('result'=>'', 'error'=>'');	
			
		/* Server side PHP input validation */		
		if($this->input->post('incidental_kpi')==='') {
			$Return['error'] = $this->lang->line('xin_error_kpi_incidental_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'incidental_kpi' => $this->input->post('incidental_kpi'),
        'targeted_date' => $this->input->post('incidental_targeted_date'),
		'result' => $this->input->post('result'),
		'status' => $this->input->post('status'),
		'feedback' => $this->input->post('feedback'),
		'updated_at' => date('Y-m-d H:i:s')
		);

		$result = $this->Performance_incidental_model->update_incidental_record($data,$id);
				
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_kpi_incidental_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	public function incidental_quarter_list ()
    {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		// if(!empty($session)){ 
		// 	$this->load->view("admin/performance_kpi", $data);
		// } else {
		// 	redirect('');
		// }
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$user_id = $this->uri->segment(4);
        $quarter = $this->uri->segment(5);
        $year = $this->uri->segment(6);

        $incidental = $this->Performance_incidental_model->get_incidental_quarterly($user_id, $quarter, $year);
		
		$data = array();

        foreach($incidental->result() as $r) {
        	$created_at = $this->Xin_model->set_date_time_format($r->created_at);
            $updated_at = $this->Xin_model->set_date_time_format($r->updated_at);
        	if ($r->user_id != $session['user_id']) {
        		$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-incidental-data" data-incidental_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
        	} else {
        		$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-incidental-data" data-incidental_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
                //$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-incidental-data" data-incidental_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete-incidental" data-toggle="modal" data-target=".delete-modal-incidental" data-record-id="'. $r->id . '"><i class="fa fa-trash-o"></i></button></span>';
        	}
		   	$data[] = array(
		   		$action,
				$r->incidental_kpi,
                $r->targeted_date,
				$r->result,
				$r->status,
				$r->feedback,
				$created_at,
                $updated_at
		   	);
	  	}

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $incidental->num_rows(),
			 "recordsFiltered" => $incidental->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
    }
}


