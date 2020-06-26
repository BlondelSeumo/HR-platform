<?php
$session = $this->session->userdata('client_username');
$system = $this->Xin_model->read_setting_info(1);
$layout = $this->Xin_model->system_layout();
$company_info = $this->Xin_model->read_company_setting_info(1);
$user_info = $this->Clients_model->read_client_info($session['client_id']);
?>
<?php $this->load->view('client/components/htmlheader');?>
<?php echo $subview;?>
<?php $this->load->view('client/components/htmlfooter');?>
          