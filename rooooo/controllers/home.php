<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $user_first = $this->session->userdata('firstName');
            if (empty($user_first)) {
                $this->session->set_userdata('firstName','Friend');
            }
            $this->load->view('top');
        }
        
	public function index() {
            $this->load->helper('form');
            if ($this->session->userdata('logged_in') == '1') {
                $this->load->view('mainmenu');
            } else {
                $this->load->view('welcome_message');
                $cookie = json_decode($this->input->cookie('ltd-login',TRUE),1);
                if ($cookie && $this->session->userdata('loggedOut'!= true)) {
                    $email = $cookie['1I1T1TLI11II'];
                    $password = $cookie['I11T1TLI11IT'];
                    $this->load->model('login_model');
                    $this->login_model->checkLoginData($email,md5($password));
                }
            }
            $this->load->view('error_modal');
	}
        
        public function main_menu() {
            $this->load->view('mainmenu');
        }
        
        public function create_account() {
            $this->load->helper('form');
            $this->load->view('new_user');
            $this->load->view('error_modal');
        }
        
        public function contact_us() {
            $this->load->helper('form');
            $this->load->view('contact_us');
            $this->load->view('error_modal');
        }
        
        public function sendContact() {
            $name = $this->input->post('name', TRUE);
            $email = $this->input->post('email', TRUE);
            $comment = $this->input->post('comment', TRUE);
            $errors = '';
            $success = true;
            
            // server-side validation
            if (strlen($name) < 2) {
                $success = false;
                $errors .= 'Please provide a valid name.<br />&nbsp;<br />';
            }
            
            if (!email_valid($email)) {
                $success = false;
                $errors .= 'Please provide a valid e-mail address.<br />&nbsp;<br />';
            }
            
            if (strlen($comment) < 10) {
                $success = false;
                $errors .= 'We need helpful comments -- at least ten characters!';
            }
            
            // send mail
            $this->load->library('email');
            $e_fig['charset'] = 'iso-8859-1';
            $e_fig['mailtype'] = 'text';
            $e_fig['crlf'] = '\r\n';
            $e_fig['newline'] = '\r\n';
            $this->email->initialize($e_fig);
            $this->email->from('webmaster@logthedog.com');
            $this->email->to('webmaster@logthedog.com');
            $this->email->subject('Log The Dog contact');
            $message = 'Message from ' . $name . ' (' . $email . ')' . PHP_EOL;
            $message .= $comment . PHP_EOL . ' ' . PHP_EOL;
            $message .= 'Browser (user agent): ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
            $message .= 'User\'s IP address: ' . $_SERVER['REMOTE_ADDR'];
            $this->email->message($message);
            $result = $this->email->send();
            
            if (!$result) {
                // LOG THIS
                $success = false;
                $errors .= 'There was a problem with the submission. Not your fault, ';
                $errors .= 'but ours. We apologize. We may not have gotten your information.';
            }
            
            $retArray = array('success' => $success, 'errors' => $errors, 'result' => $result);
            echo json_encode($retArray);
            exit();
        }
        
        //session dump
        public function habbityhabbityhoohoohoo() {
            $all_stuff = $this->session->all_userdata();
            echo "<pre>";
            echo print_r($all_stuff,1);
            echo "</pre><hr>PHP NATIVE SESSION:<pre>";
            echo print_r($_SESSION,1);
            echo "</pre>";
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */