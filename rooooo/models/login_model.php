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