<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $user_first = $this->session->userdata('firstName');
            if (empty($user_first)) {
                $this->session->set_userdata('firstName','Guest');
            }
            $this->load->helper('html');
            $this->load->helper('url');
            $this->load->view('top');
        }
        
	public function index() {
            $this->load->helper('form');
            $this->load->view('welcome_message');
            $this->load->view('error_modal');
            $cookie = json_decode($this->input->cookie('ltd-login',TRUE),1);
            if ($cookie && $this->session->userdata('loggedOut'!= true)) {
                $email = $cookie['1I1T1TLI11II'];
                $password = $cookie['I11T1TLI11IT'];
                $this->load->model('login_model');
                $this->login_model->checkLoginData($email,md5($password));
            }
	}
        
        public function main_menu() {
            $this->load->view('mainmenu');
        }
        
        //session dump
        public function habbityhabbityhoohoohoo() {
            $all_stuff = $this->session->all_userdata();
            echo "<pre>";
            echo print_r($all_stuff,1);
            echo "</pre>";
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */