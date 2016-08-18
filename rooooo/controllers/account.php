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
            'language' => $this->input->post('language', TRUE)
        );
        error_log("Account: " . print_r($changes,1));
        $this->load->model('account_model');
        $success = $this->account_model->updateAccount($changes);
        echo $success;
        exit();
    }
    
    public function getRegisteredDogs($email) {
        $this->load->model('log_model');
        $dogs = $this->log_model->retrieveDogNames($email,true);
        $expDogs= explode('~', $dogs);
        $regDogs = array();
        foreach ($expDogs as $dog => $deets) {
            $tempDog = explode('^', $deets);
            $tempBreed = explode('*', $tempDog[1]);
            $regDogs[$dog]['name'] = $tempBreed[0];
            $regDogs[$dog]['breed'] = $tempBreed[1];
        }
        return $regDogs;
    }
}