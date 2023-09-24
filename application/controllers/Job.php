<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job extends CI_Controller
{
	public function deletaLog()
    {
        $this->load->model('Job_model');
        $response = $this->Job_model->deletaLogs();
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }


}
