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

class Performance_variable extends MY_Controller {
	
	public function __construct() 
	{
        Parent::__construct();
		//load the model
		$this->load->model('Xin_model');
		$this->load->model('Performance_variable_model');
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
		$data['path_url'] = 'performance_variable';

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

    public function add_variable_kpi ()
    {
    	if($this->input->post('add_type')=='kpi_variable') {
    		$Return = array('result'=>'', 'error'=>'');
    		if($this->input->post('kpi_variable')==='') {
        		$Return['error'] = $this->lang->line('xin_error_kpi_variable_field');
        	}

            if (empty($this->input->post('variable_targeted_date'))) {
                $Return['error'] = $this->lang->line('xin_error_kpi_targeted_date_field');
            }

        	if($Return['error']!='') {
	       		$this->output($Return);
	    	}

	    	//add to db goes here
	    	$data = array(
				'user_id' => $this->input->post('_user'),
				'variable_kpi' => $this->input->post('kpi_variable'),
                'targeted_date' => $this->input->post('variable_targeted_date'),
                'status' => 1,
                'quarter' => $this->input->post('variable_quarter_name'),
                'year_created' => $this->input->post('variable_year'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
			);
    		$result = $this->Performance_variable_model->add($data);

    		if ($result == TRUE) {
    			$Return['result'] = $this->lang->line('xin_success_kpi_variable_added');
    		}

	    	$this->output($Return);
			exit;	
    	}
    }

    public function variable_list ()
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
            $variable = $this->Performance_variable_model->get_kpi_variable($user_id);
        } else {
            $variable = $this->Performance_variable_model->get_kpi_variable($session['user_id']);
        }
		
		$data = array();

        foreach($variable->result() as $r) {
            $created_at = $this->Xin_model->set_date_time_format($r->created_at);
            $updated_at = $this->Xin_model->set_date_time_format($r->updated_at);

            if ($r->user_id != $session['user_id']) {
                $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-variable-data" data-variable_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
            } else {
                //$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-variable-data" data-variable_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
                $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-variable-data" data-variable_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete-variable" data-toggle="modal" data-target=".delete-modal-variable" data-record-id="'. $r->id . '"><i class="fa fa-trash-o"></i></button></span>';
            }

            if ($session['user_id'] == $r->user_id) {
                $kpi_status = ucfirst($r->approve_status);
            }

            if ($r->approve_status == 'pending' && $session['user_id'] != $r->user_id) {
                $kpi_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('kpi_approve').'"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light approve-variable" data-toggle="modal" data-target=".approve-modal-variable-kpi" data-kpi_id="'. $r->id . '" data-record-id="'. $r->id . '"><i class="fa fa-check"></i></button></span>';
            } else {
                $kpi_status = ucfirst($r->approve_status);
            }

		    $data[] = array(
                $action,
				$r->variable_kpi,
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
			 "recordsTotal" => $variable->num_rows(),
			 "recordsFiltered" => $variable->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
    }

    public function delete_variable() {
        if($this->input->post('type')=='delete') {
            // Define return | here result is used to return user data and error for error message 
            $Return = array('result'=>'', 'error'=>'');
            $id = $this->uri->segment(4);
            $result = $this->Performance_variable_model->delete_variable_record($id);
            if(isset($id)) {
                $Return['result'] = $this->lang->line('kpi_variable_deleted_successful');
            } else {
                $Return['error'] = $this->lang->line('xin_error_msg');
            }
            $this->output($Return);
        }
    }

    // get record of variable
    public function read_variable_record()
    {
        $data['title'] = $this->Xin_model->site_title();
        $variable_id = $this->input->get('variable_id');
        $result = $this->Performance_variable_model->read_variable_information($variable_id);
        
        $data = array(
                'variable_id' => $result[0]->id,
                'user_id' => $result[0]->user_id,
                'variable_kpi' => $result[0]->variable_kpi,
                'variable_targeted_date' => $result[0]->targeted_date,
                'result' => $result[0]->result,
                'status' => $result[0]->status,
                'feedback' => $result[0]->feedback,
                'approve_status' => $result[0]->approve_status,
                );
        $session = $this->session->userdata('username');
        if(!empty($session)){ 
            $this->load->view('admin/performance/dialog_variable', $data);
        } else {
            redirect('admin/');
        }
    }

    // Validate and add info in database
    public function edit_variable() {
    
        if($this->input->post('edit_type')=='variable') {
            
        $id = $this->uri->segment(4);   
        $Return = array('result'=>'', 'error'=>''); 
            
        /* Server side PHP input validation */      
        if($this->input->post('variable_kpi')==='') {
            $Return['error'] = $this->lang->line('xin_error_kpi_variable_field');
        }
                
        if($Return['error']!=''){
            $this->output($Return);
        }
    
        $data = array(
        'variable_kpi' => $this->input->post('variable_kpi'),
        'targeted_date' => $this->input->post('variable_targeted_date'),
        'result' => $this->input->post('result'),
        'status' => $this->input->post('status'),
        'feedback' => $this->input->post('feedback'),
        'updated_at' => date('Y-m-d H:i:s')
        );

        $result = $this->Performance_variable_model->update_variable_record($data,$id);
                
        if ($result == TRUE) {
            $Return['result'] = $this->lang->line('xin_success_kpi_variable_updated');
        } else {
            $Return['error'] = $this->lang->line('xin_error_msg');
        }
        $this->output($Return);
        exit;
        }
    }

    public function approve_variable() {
        if($this->input->post('type')=='approve') {
            // Define return | here result is used to return user data and error for error message 
            $Return = array('result'=>'', 'error'=>'');
            $id = $this->uri->segment(4);
            $result = $this->Performance_variable_model->approve_variable($id);
            if(isset($id)) {
                $Return['result'] = $this->lang->line('kpi_approve_variable_success');
            } else {
                $Return['error'] = $this->lang->line('xin_error_msg');
            }
            $this->output($Return);
        }
    }

    public function variable_quarter_list ()
    {
        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');
        // if(!empty($session)){ 
        //  $this->load->view("admin/performance_kpi", $data);
        // } else {
        //  redirect('');
        // }
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
                
        $user_id = $this->uri->segment(4);
        $quarter = $this->uri->segment(5);
        $year = $this->uri->segment(6);

        $variable = $this->Performance_variable_model->get_variable_quarterly($user_id, $quarter, $year);
        
        $data = array();

        foreach($variable->result() as $r) {
            $created_at = $this->Xin_model->set_date_time_format($r->created_at);
            $updated_at = $this->Xin_model->set_date_time_format($r->updated_at);
            if ($r->user_id != $session['user_id']) {
                $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-variable-data" data-variable_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
            } else {
                $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-variable-data" data-variable_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
                //$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-variable-data" data-variable_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete-variable" data-toggle="modal" data-target=".delete-modal-variable" data-record-id="'. $r->id . '"><i class="fa fa-trash-o"></i></button></span>';
            }

            if ($session['user_id'] == $r->user_id) {
                $kpi_status = ucfirst($r->approve_status);
            }

            if ($r->approve_status == 'pending' && $session['user_id'] != $r->user_id) {
                $kpi_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('kpi_approve').'"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light approve-variable" data-toggle="modal" data-target=".approve-modal-variable-kpi" data-kpi_id="'. $r->id . '" data-record-id="'. $r->id . '"><i class="fa fa-check"></i></button></span>';
            } else {
                $kpi_status = ucfirst($r->approve_status);
            }

            $data[] = array(
                $action,
                $r->variable_kpi,
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
             "recordsTotal" => $variable->num_rows(),
             "recordsFiltered" => $variable->num_rows(),
             "data" => $data
        );
      echo json_encode($output);
      exit();
    }

    public function variable_statistic () 
    {
        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');
        // if(!empty($session)){ 
        //  $this->load->view("admin/performance_kpi", $data);
        // } else {
        //  redirect('');
        // }
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $user_id = $this->uri->segment(4);
        $quarter = $this->uri->segment(5);
        $year = $this->uri->segment(6);

        $variable = $this->Performance_variable_model->get_variable_statistic($user_id, $quarter, $year);
        
        $ongoing = 0;
        $improvement = 0;
        $achieved = 0;
        $excellent = 0;

        $data = [];

        foreach($variable->result() as $r) {
            ($r->status == 1)?$ongoing++:'';
            ($r->status == 2)?$improvement++:'';
            ($r->status == 3)?$achieved++:'';
            ($r->status == 4)?$excellent++:''; 
        }

        array_push($data, ["<strong>1 Ongoing</strong>", $ongoing]);
        array_push($data, ["<strong>2 Improvement</strong>", $improvement]);
        array_push($data, ["<strong>3 Achieved</strong>", $achieved]);
        array_push($data, ["<strong>4 Excellent</strong>", $excellent]);

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $variable->num_rows(),
            "recordsFiltered" => $variable->num_rows(),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function get_all_variable_statistic ()
    {
        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');
        // if(!empty($session)){ 
        //  $this->load->view("admin/performance_kpi", $data);
        // } else {
        //  redirect('');
        // }
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $user_id = $this->uri->segment(4);

        $variable = $this->Performance_variable_model->get_all_variable_statistic($user_id);
        
        $ongoing = 0;
        $improvement = 0;
        $achieved = 0;
        $excellent = 0;

        $data = [];

        foreach($variable->result() as $r) {
            ($r->status == 1)?$ongoing++:'';
            ($r->status == 2)?$improvement++:'';
            ($r->status == 3)?$achieved++:'';
            ($r->status == 4)?$excellent++:''; 
        }

        array_push($data, ["<strong>1 Ongoing</strong>", $ongoing]);
        array_push($data, ["<strong>2 Improvement</strong>", $improvement]);
        array_push($data, ["<strong>3 Achieved</strong>", $achieved]);
        array_push($data, ["<strong>4 Excellent</strong>", $excellent]);

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $variable->num_rows(),
            "recordsFiltered" => $variable->num_rows(),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
}
