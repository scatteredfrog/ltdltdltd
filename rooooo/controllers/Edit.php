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

    public function edit_med() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }

        $medDogOptions = $this->getDogOptions('Meds');
        $medData = array('dogs' => $medDogOptions);
        $this->load->helper('form');
        $this->load->view('edit_a_med', $medData);
        $this->load->view('error_modal');
        $this->load->view('edit_med_modal');
        $this->load->view('add_med_modal');
    }

    public function edit_treat() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }

        $treatDogOptions = $this->getDogOptions('Treats');
        $treatData = array ('dogs' => $treatDogOptions);
        $this->load->helper('form');
        $this->load->view('edit_a_treat', $treatData);
        $this->load->view('error_modal');
        $this->load->view('edit_treat_modal');

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

    public function removeMed() {
        $this->load->model('edit_model');
        $medID = $this->input->post('medID', TRUE);
        $success = $this->edit_model->deleteMed($medID);
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
        if (!empty($dogNames)) {
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

    public function getMeds() {
        $dog_id = $this->input->post('dog_id', TRUE);
        $reverse = $this->input->post('reverse', TRUE);
        $this->load->model('edit_model');
        $medRetArray = $this->edit_model->retrieveMeds($dog_id, $reverse);
        echo json_encode($medRetArray);
        exit();
    }

    public function getTreats() {
        $dog_id = $this->input->post('dog_id', TRUE);
        $reverse = $this->input->post('reverse', TRUE);
        $this->load->model('edit_model');
        $treatRetArray = $this->edit_model->retrieveTreats($dog_id, $reverse);
        echo json_encode($treatRetArray);
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

    public function getDogTreats() {
        $dogID = $this->input->post('dog_id', TRUE);
        $this->load->model('edit_model');
        $dogTreatRetArray = $this->edit_model->retrieveTreatNames($dogID);
        echo json_encode($dogTreatRetArray);
        exit();
    }

    public function getDogMeds() {
        $dogID = $this->input->post('dog_id', TRUE);

        $this->load->model('edit_model');
        $dogMedRetArray = $this->edit_model->retrieveMedNames($dogID);
        echo json_encode($dogMedRetArray);
        exit();
    }

    /**
     * Send updated med info.
     *
     * TODO: refactor so this thing isn't called "editMed" if possible.
     */
    public function editMed(): void {
        $medEditArray = array(
            'medID' => $this->input->post('med_id', TRUE),
            'medDate' => $this->input->post('med_date', TRUE),
            'medNotes' => $this->input->post('med_notes', TRUE),
            'medType' => $this->input->post('med_type', TRUE),
            'dogID' => $this->input->post('dog_id', TRUE),
            'medOther' => $this->input->post('med_other', TRUE),
            'otherDosage' => $this->input->post('other_dosage', TRUE),
            'withMeal' => $this->input->post('with_meal', TRUE),
            'otherNotes' => $this->input->post('other_notes', TRUE)
        );
        $this->load->model('edit_model');

        $medRetArray = $this->edit_model->updateMed($medEditArray);
        echo json_encode($medRetArray);
        exit();
    }

    /**
     * Send updated treat info.
     *
     * TODO: refactor so this thing isn't called "editTreat" if possible.
     */
    public function editTreat(): void {
        $treatEditArray = array(
            'treatID' => $this->input->post('treat_id', TRUE),
            'treatDate' => $this->input->post('treat_date', TRUE),
            'treatNotes' => $this->input->post('treat_notes', TRUE),
            'treatType' => $this->input->post('treat_type', TRUE)
        );

        // If someone's submitting a new treat, let's handle that sucker.
        if (!empty($this->input->post('other_treat'))) {
            $newTreatArray['treatName'] = $this->input->post('other_treat');
            $newTreatArray['dogId'] = $this->input->post('dog_id');
            if (!empty($this->input->post('other_treat_notes'))) {
                $newTreatArray['notes'] = $this->input->post('other_treat_notes');
            }
            $this->load->model('log_model');
            $newTreatRet = $this->log_model->insertTreat($newTreatArray);
            $treatEditArray['treatType'] = $newTreatRet['success'];
        }

        $this->load->model('edit_model');
        $treatRetArray = $this->edit_model->updateTreat($treatEditArray);
        echo json_encode($treatRetArray);
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