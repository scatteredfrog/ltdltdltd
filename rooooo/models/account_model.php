<?php
    class Account_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }
        
        public function retrieveAccount($userID) {
            $account = array();
            $this->db->select('username,eMail,language');
            $query = $this->db->get_where('LTDtbUser',array('userID' => $userID));
            foreach($query->result() as $row) {
                $account['username'] = $row->username;
                $account['eMail'] = $row->eMail;
                $account['language'] = $row->language;
            }
            return $account;
        }
        
        public function updateAccount($acct) {
            $this->db->where('userID', $this->session->userdata('userID'));
            $success = $this->db->update('LTDtbUser', $acct);
            return $success;
        }
        
        public function retrieveId($email) {
            $retArray = array('success' => false);

            $this->db->select('userID');
            $query = $this->db->get_where('LTDtbUser', array('eMail' => $email));
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $retArray['id'] = $row->userID;
                }
                $retArray['success'] = true;
            }
            return $retArray;
        }
        
        // store temporary password and 1-hour expiration date
        public function create_temp($id, $pass, $exp) {
            $retArray = array('success' => false);
            $update_data = array(
                'temp_password' => $pass,
                'temp_exp' => $exp
            );
            $this->db->where('userID', $id);
            $retArray['success'] = $this->db->update('LTDtbUser', $update_data);
            return $retArray;
        }
        
        
        public function retrieveTempPassword($id) {
            $retArray = array('success' => false);

            $this->db->select('username, eMail, temp_password, temp_exp');
            $query = $this->db->get_where('LTDtbUser', array('userID' => $id));
            if ($query->num_rows() > 0) {
                $retArray['success'] = true;
                foreach ($query->result() as $row) {
                    $retArray['password'] = $row->temp_password;
                    $retArray['exp'] = $row->temp_exp;
                    $retArray['username'] = $row->username; // need for PW validation
                    $retArray['email'] = $row->eMail; // need for PW validation
                }
            }
            return $retArray;
        }
        
        public function updatePassword($email, $pass) {
            $retArray = array('success' => false);
            
            $this->db->where('eMail', $email);
            $retArray['success'] = $this->db->update('LTDtbUser', array('password' => $pass));
            return $retArray;
        }
    }