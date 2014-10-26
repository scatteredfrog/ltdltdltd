<?php
    class Login_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }
    
        function checkLoginData($email,$password) {
            $this->db->select('userID,firstName,lastName,eMail,password,language');
            $query = $this->db->get_where('LTDtbUser',array('eMail' => $email));
            if ($query->num_rows() > 0) {
                $this->session->unset_userdata('nsu');
                foreach ($query->result() as $row) {
                    $query_result['userID'] = $row->userID;
                    $query_result['firstName'] = $row->firstName;
                    $query_result['lastName'] = $row->lastName;
                    $query_result['eMail'] = $row->eMail;
                    $query_result['language'] = $row->language;
                    $query_result['password'] = $row->password;
                }
            } else {
                // user does not exist
                $query_result['error'] = true;
                $this->session->set_userdata('nsu',true);
            }
            
            if (isset($query_result['password']) && $query_result['password'] !== $password) {
                // incorrect password
                $this->session->unset_userdata('nsu');
                $query_result['error'] = true;
            } else {
                $query_result['logged_in'] = true;
                $this->session->set_userdata($query_result);
            }
            
            return $query_result;
        }
    }