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
    }