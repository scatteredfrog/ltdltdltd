<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beagle extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->helper('html');
            $this->load->helper('url');
            $this->load->view('top');
        }
        
	public function index() {
	}
        
        public function contact() {
            $this->load->helper('form');
            $this->load->view('contact_us');
        }
}

/* End of file beagle.php */
/* Location: ./application/controllers/beagle.php */