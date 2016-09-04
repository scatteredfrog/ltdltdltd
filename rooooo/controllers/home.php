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
            error_log(print_r(base_url(),1));
            $cookie = json_decode($this->input->cookie('ok-computer',TRUE),1);
            // REMOVE COOKIE CONDITIONAL WHEN DONE TESTING.
            // Keep the code withn the conditional, though.
            if ($cookie && ($cookie['T1I1T1TLI11TT'] === "it's okay"))    {
                if ($this->session->userdata('logged_in') == '1') {
                    $this->load->view('mainmenu');
                } else {
                    $this->load->view('welcome_message');
                }
            } else {
                $this->load->view('tester');
            }
            $this->load->view('error_modal');
	}

        public function continue_start() {
            if ($this->session->userdata('logged_in') == '1') {
                $this->load->view('mainmenu');
            } else {
                $this->load->view('welcome_message');
                $this->load->view('error_modal');
            }
        }
        
        public function beagle() {
            $solve = $_POST['solve'];
            $solution = $_POST['solution'];
            $result = 'wrong';
            switch($solve) {
                case '0':
                    if ($solution === '987.4') {
                        $result = 'right';
                    }
                    break;
                case '1':
                    if ($solution === 'ornge') {
                        $result = 'right';
                    }
            }

            if ($result === 'right') {
                $cookie = array(
                    'name' => 'ok-computer',
                    'value' => json_encode(array('T1I1T1TLI11TT' => "it's okay")),
                    'expire' => '2590000',
                    'secure' => FALSE,
                    'domain' => '.logthedog.com'
                );
                $this->input->set_cookie($cookie);

                $this->continue_start();
            } else {
                $sn = mt_rand(0,5);
                $site = 'http://www.google.com';
                
                switch ($sn) {
                    case 0:
                        $site = 'http://www.piefactorypodcast.com';
                        break;
                    case 1:
                        $site = 'http://www.beagles-on-the-web.com';
                        break;
                    case 2:
                        $site = 'http://www.brewbeagles.org';
                        break;
                    case 3:
                        $site = 'http://www.paws.org';
                        break;
                    case 4:
                        $site = 'http://www.menwholooklikekennyrogers.com';
                        break;
                }
                header('Location: ' . $site);
            }
        }
        
        public function main_menu() {
            $this->load->view('mainmenu');
            $this->load->view('error_modal');
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