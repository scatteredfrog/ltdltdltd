<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->view('top');
    }

    public function index() {
        $this->load->view('edit_menu');
    }
    
    public function edit_meal() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }

        $dogOptions = $this->getDogOptions('Meals');
        $data = array('dogs' => $dogOptions);
        $this->load->helper('form');
        $this->load->view('edit_a_meal', $data);
        $this->load->view('error_modal');
        $this->load->view('edit_meal_modal');
    }
    
    public function edit_walk() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }

        $dogOptions = $this->getDogOptions('Walks');
        $data = array('dogs' => $dogOptions);
        $this->load->helper('form');
        $this->load->view('edit_a_walk', $data);
        $this->load->view('error_modal');
        $this->load->view('edit_walk_modal');
    }
    
    public function removeMeal() {
        $this->load->model('edit_model');
        $mealID = $this->input->post('mealID', TRUE);
        $success = $this->edit_model->deleteMeal($mealID);
        echo json_encode($success);
        exit();
    }

    public function removeWalk() {
        $this->load->model('edit_model');
        $walkID = $this->input->post('walkID', TRUE);
        $success = $this->edit_model->deleteWalk($walkID);
        echo json_encode($success);
        exit();
    }
    
    public function getDogOptions($func) {
        $this->load->model('log_model');
        $email = $this->session->userdata('eMail');
        $dogNames = $this->log_model->retrieveDogNames($email);
        $html = '';
        if (count($dogNames) > 0) {
            $dogs = explode('~', $dogNames);
            $html .= '<div class="text-center"><select id="dog_names" onchange="edit' . $func . '();">';
            $html .= '<option value="no">(Select a dog)</option>';
            foreach ($dogs as $k) {
                list($id, $name) = explode('^', $k);
                $html .= '<option value="' . $id . '">' . $name . '</option>';
            }
            $html .= '</select>';
            $html .= '<input type="button" onclick="edit' . $func . '();" value="Choose Dog" /></div>';
        }
        return $html;
    }
    
    public function getMeals() {
        $dog_id = $this->input->post('dog_id', TRUE);
        $reverse = $this->input->post('reverse', TRUE);
        $retArray = array();
        $this->load->model('edit_model');
        $retArray = $this->edit_model->retrieveMeals($dog_id, $reverse);
        echo json_encode($retArray);
        exit();
    }
    
    public function getWalks() {
        $dog_id = $this->input->post('dog_id', TRUE);
        $reverse = $this->input->post('reverse', TRUE);
        $retArray = array();
        $this->load->model('edit_model');
        $retArray = $this->edit_model->retrieveWalks($dog_id, $reverse);
        echo json_encode($retArray);
        exit();
    }
    
    public function editMeal() {
        $editArray = array(
            'mealID' => $this->input->post('meal_id', TRUE),
            'mealDate' => $this->input->post('meal_date', TRUE),
            'mealNotes' => $this->input->post('meal_notes', TRUE),
        );
        $this->load->model('edit_model');
        $retArray = $this->edit_model->updateMeal($editArray);
        echo json_encode($retArray);
        exit();
    }
    
    public function editWalk() {
        $editArray = array(
            'walkID' => $this->input->post('walk_id', TRUE),
            'walkDate' => $this->input->post('walk_date', TRUE),
            'action' => $this->input->post('activity', TRUE),
            'walkNotes' => $this->input->post('walk_notes', TRUE),
        );
        $this->load->model('edit_model');
        $retArray = $this->edit_model->updateWalk($editArray);
        echo json_encode($retArray);
        exit();
    }
    
}