<?php
    class Login_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }
    
        public function doesUserExist($email) {
            $user_exists = true;
            $this->db->select('eMail');
            $query = $this->db->get_where('LTDtbUser', array('eMail' => $email));
            if ($query->num_rows() < 1) { // user does not exist
                $user_exists = false;
            }
            return $user_exists;
        }
        
        public function retrieveDauber() {
            $this->db->select('*');
            $query = $this->db->get_where('LTDtbUser', array('username' => 'dauber'));
            foreach ($query->result() as $row) {
                $the_date = $row->joined;
            }
            $today = date('Y-m-d h:i:s');
            error_log("Joined: " . print_r($the_date,1));
            error_log("Today: " . print_r($today,1));
            error_log("Joined < today? ". print_r($the_date < $today,1));
            error_log("Joined > today? ". print_r($the_date > $today,1));
            return;
        }
        
        public function checkForGmail($gmail) {
            $user_exists = true;
            $this->db->select('gmail');
            $query = $this->db->get_where('LTDtbUser', array('gmail' => $gmail));
            if ($query->num_rows() < 1) { // gmail address does not exist
                $user_exists = false;
            }
            return $user_exists;            
        }
        
        public function addAccount($account) {
            $success = false;
            $today = date('Y-m-d H:i:s');
            $names = explode(' ', $account['username']);
            
            $insert = array(
                'username' => $account['username'],
                'firstName' => $names[0],
                'eMail' => $account['email'],
                'password' => $account['password'],
                'gmail' => $account['gmail'],
                'language' => (int) 0,
                'joined' => $today,
                'last_logged_in' => $today
            );
            if ($this->db->insert('LTDtbUser', $insert)) {
                $success = true;
            }
            
            return $success;
        }
        
        public function checkLoginData($email,$password) {
            $this->db->select('userID,username,firstName,lastName,eMail,password,language');
            $query = $this->db->get_where('LTDtbUser',array('eMail' => $email));
            if ($query->num_rows() > 0) {
                $this->session->unset_userdata('nsu');
                foreach ($query->result() as $row) {
                    $query_result['userID'] = $row->userID;
                    $query_result['username'] = $row->username;
                    $query_result['firstName'] = $row->firstName;
                    $query_result['lastName'] = $row->lastName;
                    $query_result['eMail'] = $row->eMail;
                    $query_result['language'] = $row->language;
                    $query_result['password'] = $row->password;
                }
            } else {
                // user does not exist
                unset($query_result);
                $query_result['error'] = true;
                $query_result['success'] = false;
                $this->session->set_userdata('nsu',true);
            }
            
            if (isset($query_result['password']) && $query_result['password'] !== $password && !$query_result['error']) {
                // incorrect password
                $this->session->unset_userdata('nsu');
                unset($query_result);
                $query_result['success'] = false;
                $query_result['error'] = true;
            } else if (!isset($query_result['error']) || !$query_result['error']) {
                $query_result['logged_in'] = true;
                $query_result['success'] = true;
                $this->session->unset_userdata('nsu');
                $this->session->set_userdata($query_result);
            }
            
            return $query_result;
        }
    }