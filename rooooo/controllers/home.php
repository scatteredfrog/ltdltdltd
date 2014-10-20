<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
            $this->load->helper('form');
            $this->load->helper('html');
            $this->load->helper('url');
            $this->load->view('top');
            $this->load->view('welcome_message');
            $this->load->view('error_modal');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */