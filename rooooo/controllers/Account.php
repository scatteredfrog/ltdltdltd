<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
           $this->load->view('top');
    }

    public function index() {

    }
    
    public function getAccount() {
        $account = $this->getUserAccount($this->session->userdata('userID'));
        $account['dogs'] = $this->getRegisteredDogs($this->session->userdata('eMail'));
        $this->load->view('account', $account);
        $this->load->view('error_modal');
    }
    
    public function getUserAccount($userID) {
        $this->load->model('account_model');
        $account_deets = $this->account_model->retrieveAccount($userID);
        return $account_deets;
    }
    
    public function saveAccountChanges() {
        $changes = array(
            'username' => $this->input->post('username', TRUE),
            'eMail' => $this->input->post('email', TRUE),
            'language' => $this->input->post('language', TRUE),
            'ql_num' => $this->input->post('ql_num', TRUE),
            'ql_ord' => $this->input->post('ql_ord', TRUE)
        );
        $this->load->model('account_model');
        $success = $this->account_model->updateAccount($changes);
        if ($success) {
            $this->session->set_userdata('language', $changes['language']);
            $this->session->set_userdata('ql_num', $changes['ql_num']);
            $this->session->set_userdata('ql_ord', $changes['ql_ord']);
        }
        echo $success;
        exit();
    }
    
    public function getRegisteredDogs($email) {
        $this->load->model('log_model');
        $dogs = $this->log_model->retrieveDogNames($email,true);
        $expDogs= explode('~', $dogs);
        $regDogs = array();
        if (is_countable($expDogs) && count($expDogs) > 0) {
            foreach ($expDogs as $dog => $deets) {
                if (!empty($dog)) {
                    $tempDog = explode('^', $deets);
                    $tempBreed = explode('*', $tempDog[1]);
                    $regDogs[$dog]['name'] = $tempBreed[0];
                    $regDogs[$dog]['breed'] = $tempBreed[1];
                }
            }
        }
        return $regDogs;
    }
    
    public function forgotPassword() {
        $retArray = array('success' => false);
        $email = $this->input->post('email', TRUE);
        $is_valid = email_valid($email);

        if (!$is_valid) {
            $retArray['message'] = 'That is not a valid e-mail address.';
        } else {
            $this->load->helper('genmail');
            $retArray['success'] = true;
            $retArray['message'] = 'Thanks! A temporary password has been e-mailed to you that ';
            $retArray['message'] .= 'will be valid for one hour.';
            $genMail = array();
            $genMail['to'] = $email;
            $genMail['subject'] = 'Reset your Log the Dog password!';
            $rndpw = $this->_randomPassword();
            $this->load->model('account_model');
            $acctinfo = $this->account_model->retrieveId($email);
            $link = base_url() . 'account/user_reset?flirzel=' . $acctinfo['id'] . '&kwerp=' . $rndpw;
            $genMail['message'] = 'We have received your request to reset your password. Please ';
            $genMail['message'] .= 'click on the following link:<br />&nbsp;<br />';
            $genMail['message'] .= '<a href="' . $link . '">' . $link . '</a><br />&nbsp;<br />';
            $genMail['message'] .= "If the link doesn't work, then copy the following line ";
            $genMail['message'] .= "and paste it into your web browser's address bar:<br />&nbsp;<br />";
            $genMail['message'] .= $link;
            gen_mail($genMail);

            $exp = date('Y-m-d H:i:s', time() + 3600);
            $pass = password_hash($rndpw, PASSWORD_BCRYPT);
            $retArray['create_temp'] = $this->account_model->create_temp($acctinfo['id'], $pass, $exp);
        }
        echo json_encode($retArray);
        exit();
    }
    
    public function user_reset() {
        $this->load->helper('validation');
        $retArray = array('success' => false);
        $expired = false;
        $userID = $this->input->get('flirzel');
        $password = $this->input->get('kwerp');
        $this->load->model('account_model');
        
        $creds = $this->account_model->retrieveTempPassword($userID);

        if ($creds['success']) {
        $m = '<div class="container"><div class="row-fluid text-center"><h3>';
            $start_time = new DateTime($creds['exp']);
            $now = new DateTime();
            $time_elapsed = $now->diff($start_time);
            
            // if it's more than an hour old, it's considered expired.
            if ($time_elapsed->h > 0) {
                if ($time_elapsed->h > 1 || $time_elapsed->m > 0 || $time_elapsed->s > 0) {
                    $expired = true;
                }
            }
            
            if (!$expired) {
                // encrypt the password from query string, compare it to pre-crypted password
                $compare_this = blow_me($password, $creds['password']);
                if ($compare_this === $creds['password']) {
                    $retArray['success'] = true;
                    $retArray['id'] = $userID;
                    $retArray['email'] = $creds['email'];
                    $retArray['username'] = $creds['username'];
                    $m .= 'Please choose a new password:';
                } else {
                    $m = 'Your temporary password is incorrect.';
                    $m .= ' You may try the "Forgot your password?" option on ';
                    $m .= 'the home page again.';
                }
            } else {
                $m = 'Sorry, your temporary password has expired.';
            }

        }
        
        $retArray['message'] = $m . '</h3></div></div>';
        $this->load->view('password_reset', $retArray);
        $this->load->view('error_modal');
    }
    
    public function doResetPassword() {
        $retArray = array(
            'success' => false,
            'error_message' => ''
        );
        
        $success = true;
        $invalid = false;
        $reset_pw = $this->input->post('reset_pw', TRUE);
        $reset_conf = $this->input->post('reset_conf', TRUE);
        $username = $this->input->post('username', TRUE);
        $email = $this->input->post('email', TRUE);
        
        $is_valid = valid_password($reset_pw, $email, $username);
        if (!$is_valid['valid']) {
            $retArray['success'] = false;
            $retArray['error_message'] = $is_valid['error'];
            $success = false;
            $invalid = true;
        }
        
        if ($reset_pw !== $reset_conf) {
            $invalid = true;
            $retArray['error_message'] .= 'Please ensure your password is the same in both fields.<br />&nbsp;<br />';
            $success = false;
        }
        
        if ($success) {
            $new_pass = password_hash($reset_pw, PASSWORD_BCRYPT);
            $this->load->model('account_model');
            $change = $this->account_model->updatePassword($email, $new_pass);
            $retArray['success'] = $change['success'];
        }

        if ($retArray['success']) {
            $retArray['message'] = 'You will be redirected to the home page and may log in there.';
        }
        
        echo json_encode($retArray);
        exit();
    }
    /**
     * Generate random 8-character password matching criteria
     * @return string
     */
    private function _randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}