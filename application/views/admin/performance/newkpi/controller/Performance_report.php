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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Performance_report extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
		//load the model
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Performance_report_model");
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
		$data['title'] = $this->lang->line('kpi_report');
		$data['breadcrumbs'] = $this->lang->line('kpi_report');
		$data['path_url'] = 'performance_report';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('121',$role_resources_ids)) {
		$data['subview'] = $this->load->view("admin/performance/performance_report", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load		
		} else {
			redirect('admin/dashboard');
		}
    }

    public function download_kpi ()
    {
    	$quarter = $this->input->post('kpi_quarter_name');
    	$year = $this->input->post('kpi_year');

    	if ($quarter == 'All') {
    		$this->download_all_kpi($year);
    		die();
    	}

    	$all_employees = $this->Xin_model->all_active_employees();    	
    	
    	$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Legend');
        $sheet->setCellValue('A1', 'Status Legend:');
        $sheet->setCellValue('A2', '1 - Ongoing');
        $sheet->setCellValue('A3', '2 - Improvement');
        $sheet->setCellValue('A4', '3 - Achieved');
        $sheet->setCellValue('A5', '4 - Excellent');

        $highestRow = $sheet->getHighestRow();
		
        foreach ($all_employees as $key => $value) {

        	$worksheet = $spreadsheet->createSheet();
			$worksheet->setTitle("$value->first_name $value->last_name");
			$worksheet->setCellValue('A1', 'VARIABLE');
			$worksheet->setCellValue('A2', 'KPI');
			$worksheet->setCellValue('B2', 'TARGETED DATE');
			$worksheet->setCellValue('C2', 'RESULT');
			$worksheet->setCellValue('D2', 'STATUS');
			$worksheet->setCellValue('E2', 'FEEDBACK');
			$worksheet->setCellValue('F2', 'LAST UPDATED');

			$variable = $this->Performance_report_model->get_variable_statistic($value->user_id, $quarter, $year);

			foreach ($variable->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $k+3, $v->variable_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $k+3, $this->Xin_model->set_date_time_format($v->updated_at));
			}

			$hr1 = $highestRow + 4;
			$hr2 = $highestRow + 5;
			$hr3 = $highestRow + 3;
			$worksheet->setCellValue("A$hr1", 'INCIDENTAL');
			$worksheet->setCellValue("A$hr2", 'KPI');
			$worksheet->setCellValue("B$hr2", 'TARGETED DATE');
			$worksheet->setCellValue("C$hr2", 'RESULT');
			$worksheet->setCellValue("D$hr2", 'STATUS');
			$worksheet->setCellValue("E$hr2", 'FEEDBACK');
			$worksheet->setCellValue("F$hr2", 'LAST UPDATED');

			$incidental = $this->Performance_report_model->get_incidental_statistic($value->user_id, $quarter, $year);

			foreach ($incidental->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $hr3+$k+3, $v->incidental_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $hr3+$k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $hr3+$k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $hr3+$k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $hr3+$k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $hr3+$k+3, $this->Xin_model->set_date_time_format($v->updated_at));
			}

        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Performance_report($quarter".'_'."$year)";
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); // download file
    }

    public function download_all_kpi ($year)
    {
    	$all_employees = $this->Xin_model->all_active_employees();    	
    	
    	$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Legend');
        $sheet->setCellValue('A1', 'Status Legend:');
        $sheet->setCellValue('A2', '1 - Ongoing');
        $sheet->setCellValue('A3', '2 - Improvement');
        $sheet->setCellValue('A4', '3 - Achieved');
        $sheet->setCellValue('A5', '4 - Excellent');

        $highestRow = $sheet->getHighestRow();
		
        foreach ($all_employees as $key => $value) {

        	$worksheet = $spreadsheet->createSheet();
			$worksheet->setTitle("$value->first_name $value->last_name");
			$worksheet->setCellValue('A1', 'VARIABLE');
			$worksheet->setCellValue('A2', 'KPI');
			$worksheet->setCellValue('B2', 'TARGETED DATE');
			$worksheet->setCellValue('C2', 'RESULT');
			$worksheet->setCellValue('D2', 'STATUS');
			$worksheet->setCellValue('E2', 'FEEDBACK');
			$worksheet->setCellValue('F2', 'LAST UPDATED');

			$variable = $this->Performance_report_model->get_all_variable($value->user_id, $year);

			foreach ($variable->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $k+3, $v->variable_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $k+3, $this->Xin_model->set_date_time_format($v->updated_at));
			}

			$hr1 = $highestRow + 4;
			$hr2 = $highestRow + 5;
			$hr3 = $highestRow + 3;
			$worksheet->setCellValue("A$hr1", 'INCIDENTAL');
			$worksheet->setCellValue("A$hr2", 'KPI');
			$worksheet->setCellValue("B$hr2", 'TARGETED DATE');
			$worksheet->setCellValue("C$hr2", 'RESULT');
			$worksheet->setCellValue("D$hr2", 'STATUS');
			$worksheet->setCellValue("E$hr2", 'FEEDBACK');
			$worksheet->setCellValue("F$hr2", 'LAST UPDATED');

			$incidental = $this->Performance_report_model->get_all_incidental($value->user_id, $year);

			foreach ($incidental->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $hr3+$k+3, $v->incidental_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $hr3+$k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $hr3+$k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $hr3+$k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $hr3+$k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $hr3+$k+3, $this->Xin_model->set_date_time_format($v->updated_at));
			}

        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Performance_report(All)";
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); // download file
    }
}
