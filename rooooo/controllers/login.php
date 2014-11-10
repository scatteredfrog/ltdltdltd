<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
        public function __construct() {
            parent::__construct();
//            $this->load->helper('form');
        }

        public function index() {
            
        }
        
        public function log_in() {
            $this->load->helper('form');
            $this->load->model('login_model');
            $email = $this->input->post('email',TRUE);
            $password = md5($this->input->post('password',TRUE));
            $login_attempt = $this->login_model->checkLoginData($email,$password);
            echo json_encode($login_attempt);
        }
        
        public function log_out() {
            $this->session->sess_destroy();
            $this->session->set_userdata('firstName','Guest');
            if ($this->session->userdata('firstName') === 'Guest') {
                echo true;
            } else {
                echo false;
            }
        }
}
