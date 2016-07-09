<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
        public function __construct() {
            parent::__construct();
//            $this->load->helper('form');
        }

        public function index() {
            
        }
        
        public function dauber_check() {
            $this->load->model('login_model');
            $this->login_model->retrieveDauber();
            return;
        }
        
        public function create_account() {
            $sp = '<br />&nbsp;<br />';
            $this->load->model('login_model');
            $user_email = $this->input->post('user_email', TRUE);
            $user_remail = $this->input->post('user_remail', TRUE);
            $user_password = $this->input->post('user_password', TRUE);
            $user_name = $this->input->post('user_name', TRUE);
            $user_repass = $this->input->post('user_repass', TRUE);
            $gmail = '';
            $g_exists = false;
            $account = array();
            $retArray = array();
            $success = true;
            $invalid = false; // flag to reduce redundant error messaging
            $error = '';
            
            // Do we have a name?
            if (strlen($user_name) < 2) {
                $success = false;
                $error .= 'Please provide your name.';
                if (strlen($user_name) === 1) {
                    $error .= ' (Seriously? Just one character?!)';
                }
                $error .= $sp;
            }
            
            // Is this a plausible e-mail address?
            if (!email_valid($user_email)) {
                $success = false;
                $invalid = true;
                $error .= 'Please provide a valid e-mail address.' . $sp;
            }
            
            // Does the e-mail address match the confirmation?
            if (!$invalid && $user_email !== $user_remail) {
                $success = false;
                $error .= 'Please ensure your e-mail address is the same in both e-mail fields.' . $sp;
            }
            
            // Does the password meet the criteria?
            $valid_password = valid_password($user_password, $user_email, $user_name);
            
            if (!$valid_password['valid']) {
                $success = false;
                $invalid = true;
                $error .= $valid_password['error'];
            } else {
                $invalid = false;
            }
            
            // Does the password match the confirmation?
            if (!$invalid && $user_password !== $user_repass) {
                $success = false;
                $error .= 'Please ensure your password is the same in both password fields.' . $sp;
            }
            
            // Is this e-mail address already tied to an account?
            if ($this->login_model->doesUserExist($user_email) && $success) {
                // user was found; do NOT create account
                $success = false;
                $error .= 'We already have that e-mail in our user base.';
            } else {
                // user was not found; create account
                
                // Is it a Gmail user? If so, check for alias
                if (stristr($user_email, 'gmail.com')) {
                    $gmail_parts = explode('@', $user_email);
                    $g_user = str_replace('.','', $gmail_parts[0]);
                    $g_user = str_replace('+','', $g_user);
                    $gmail = $g_user . '@gmail.com';
                    $g_exists = $this->login_model->checkForGmail($gmail);
                }
                
                // Return messsage saying it's an existing Gmail alias
                if ($g_exists) {
                    $error = 'It appears that your e-mail address is ';
                    $error .= 'an alias of a Gmail address that is already ';
                    $error .= 'registered. Should we create an accont with ';
                    $error .= 'this e-mail address anyway?';
                    $success = false;
                }
                
                if ($success) { // no Gmail alias found; continue to create acct
                    $password = $this->blow_me($user_password);
                    $account['username'] = $user_name;
                    $account['email'] = $user_email;
                    $account['password'] = $password;
                    $account['gmail'] = $gmail;
                    if (!$this->login_model->addAccount($account)) {
                        $success = false;
                        $error .= 'There was a problem creating your account. ';
                        $error .= 'We don\'t know what happened, but it was ';
                        $error .= 'most likely our fault. We\'re terribly ';
                        $error .= 'sorry, and we\'ll look into the problem as ';
                        $error .= 'soon as possible.';
                    }
                }
            }
            
            // Return stuff
            $retArray['success'] = $success;
            if ($success) {
                $retArray['creds'] = array(
                    'email' => $user_email,
                    'password' => $user_password
                );
            }
            
            if (strlen($error) > 0) {
                $retArray['error'] = $error;
            }
            echo json_encode($retArray);
        }
        
        public function log_in() {
            $this->load->helper('form');
            $this->load->model('login_model');
            $email = $this->input->post('email',TRUE);
            $password = $this->blow_me($this->input->post('password', TRUE));
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
                $this->login_model->retrieveDogs($this->session->userdata('eMail'));
            }
            echo json_encode($login_attempt);
        }
        
        public function log_out() {
            $this->session->sess_destroy();
            $this->session->set_userdata('loggedOut',true);
            $this->session->set_userdata('firstName','Friend');
            if ($this->session->userdata('firstName') === 'Friend') {
                echo true;
            } else {
                echo false;
            }
        }
        
        private function blow_me($password) {
            return crypt($password, '$2y$09$fudgicleforthrillhouse$');
        }
}
