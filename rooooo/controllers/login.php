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
            $remember_me = $this->input->post('remember',TRUE);
            $login_attempt = $this->login_model->checkLoginData($email,$password);
            if ($login_attempt['success']) {
                if ($remember_me) {
                    $cookie = array(
                        'name' => 'ltd-login',
                        'value' => json_encode(array('1I1T1TLI11II' => $email, 'I11T1TLI11IT' => $this->input->post('password',TRUE))),
                        'expire' => '328500',
                        'secure' => FALSE,
                        'domain' => '.logthedog.com'
                    );
                    $this->input->set_cookie($cookie);
                }
            }
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
