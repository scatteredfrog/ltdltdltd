<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Controller {

    private $_months = array(
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    );

    public function __construct() {
        parent::__construct();
        $this->load->view('top');
    }

    public function index() {
    }


    public function register_dog() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }
        $this->load->helper('form');
        $this->load->view('registry');
        $this->load->view('error_modal');
    }

    public function register_a_dog() {
        $success = true;
        $error = '';
        $this->load->model('log_model');

        switch ($this->input->post('dog_gender')) {
            case 'm':
                $gender = 2;
                break;
            case 'f':
                $gender = (int)1;
                break;
            default:
                $gender = 0;
                break;
        }
        $month = (int)$this->input->post('dog_bmonth');
        $date = (int)$this->input->post('dog_bdate');
        $year = (int)$this->input->post('dog_byear');
        $birth_date = '';
        
        // only record a birth date if we have a month and one other param, or a year
        if ($month) {
            if ($date) {
                switch ($month) {
                    case '4':
                    case '6':
                    case '9':
                    case '11':
                        if ($date == 31) {
                            $success = false;
                            $error .= 'That month only has 30 days.';
                        }
                        break;
                    case '2':
                        if ($year) {
                            // is it leap year?
                            if (($year % 4 == 0) && ($year % 400 != 0)) {
                                if ($date > 29) {
                                    $success = false;
                                    $error .= 'February that year only had 29 days.';
                                }
                            } else {
                                if ($date > 28) {
                                    $success = false;
                                    $error .= 'February that year only had 28 days.';
                                }
                            }
                        }
                        break;
                }
                $birth_date = $this->_months[$month] . ' ' . $date;
                if ($year) {
                    // PUT DATE VALIDATION HERE
                    $birth_date .= ', ' . $year;
                } else {
                    $birth_date .= ' (year unknown)';
                }
            } else {
                if ($year) {
                    $birth_date = 'Approx. ' . $this->_months[$month] . ' ' . $year;
                }
            }
        } else if ($year) {
            $birth_date = 'Approx. ' . $year;
        }

        $dog = array(
            'name' => $this->input->post('dog_name'),
            'weight' => $this->input->post('dog_weight'),
            'height' => $this->input->post('dog_height'),
            'length' => $this->input->post('dog_length'),
            'neutered' => $this->input->post('neutered'),
            'breed' => $this->input->post('breed'),
            'gender' => $gender,
            'color' => $this->input->post('dog_color'),
            'features' => $this->input->post('dog_features'),
            'alt_name' => $this->input->post('dog_altName'),
            'afflictions' => $this->input->post('dog_afflictions'),
            'fears' => $this->input->post('dog_fears'),
            'commands' => $this->input->post('commands'),
            'chipped' => $this->input->post('chipped'),
            'chip_brand' => $this->input->post('chip_brand'),
            'chip_id' => $this->input->post('chip_id'),
            'birth_date' => $birth_date,
            'confirm' => $this->input->post('confirm')
        );

        error_log("Dog params: " . print_r($dog,1));
        if (strlen($dog['name']) < 1) {
            $error = 'Make sure the dog has a name!<br />&nbsp;<br />' . $error;
            $success = false;
        }

        // Check to see if this dog is already registered
        if ($success && !$dog['confirm']) {
            $is_reg = $this->log_model->retrieveCaretakerDog($this->session->userdata('eMail'), $dog['name']);
            if ($is_reg > 0) {
                $success = false;
                $error .= 'You already have ' . $is_reg . ' dog';
                if ($is_reg > 1) {
                    $error .= 's';
                }
                $error .= ' named ' . $dog['name'] . ' registered to your account. Do you want ';
                $error .= 'to add this dog anyway?';
                $retArray['success'] = $success;
                $retArray['error'] = $error;
                echo json_encode($retArray);
                exit();
            }
        }
        
        // Make sure logged-in user is automatically added as a caretaker
        $caretakerstring = $this->session->userdata('username') . '^' .$this->session->userdata('eMail');
        if (strlen($this->input->post('caretakers')) > 0) {
            $caretakerstring .= '~' . $this->input->post('caretakers');
        }
        $caretakers = explode('~',$caretakerstring);
        foreach($caretakers as $k => $v) {
            $ct = explode('^', $v);
            $caretakers[$k] = array(
                'name' => $ct[0],
                'email' => $ct[1]
            );
        }

        if ($success) {
            $dog_added = $this->log_model->addDog($dog);

            if ($dog_added['success']) {
                if (count($caretakers > 0)) {
                    $ct_added = $this->log_model->addCaretaker($caretakers, $dog_added['insert_id']);
                }
            }
        }
        
        $retArray['success'] = $success;
        if (strlen($error) > 0) {
            $retArray['error'] = $error;
        }
        echo json_encode($retArray);
        exit();
    }
}
