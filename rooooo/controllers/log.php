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
        if (isset($_SESSION['dogs'])) {
            $this->load->view('edit_registry');
        }
        $this->load->view('registry');
        $this->load->view('error_modal');
    }
    
    public function getQuickLook() {
        $dogOptions = $this->_getDogOptions(true);
        echo json_encode($dogOptions);
        exit();
    }
    
    public function getDogNames($user) {
        if (empty($user)) {
            return array('success' => false);
        }
        
        $this->load->model('log_model');
        $dog_names = $this->log_model->retrieveDogNames($user, false);
        return $dog_names;
    }

    // Load the "Log a Walk" page
    public function walk() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }
        
        $dogOptions = $this->_getDogOptions();
        
        $data = array('dogs' =>$dogOptions);
        $this->load->helper('form');
        $this->load->view('log_a_walk', $data);
        $this->load->view('error_modal');
    }

    // Load the "Log a Meal" page
    public function meal() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }
        
        $dogOptions = $this->_getDogOptions();
        
        $data = array('dogs' =>$dogOptions);
        $this->load->helper('form');
        $this->load->view('log_a_meal', $data);
        $this->load->view('error_modal');
    }
    
    // Load the "Log a Medicine" page
    public function med() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }
        
        $dogOptions = $this->_getDogOptions();
        
        $data = array('dogs' =>$dogOptions);
        $this->load->helper('form');
        $this->load->view('log_a_med', $data);
        $this->load->view('error_modal');
    }

    // Load the "Log a Treat" page
    public function treat() {
        if (!$this->session->userdata('logged_in')) {
            header('Location: /');
        }
        
        $dogOptions = $this->_getDogOptions();
        
        $data = array('dogs' =>$dogOptions);
        $this->load->helper('form');
        $this->load->view('log_a_treat', $data);
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
            'confirm' => $this->input->post('confirm'),
            'update' => $this->input->post('update')
        );

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
            if ($dog['update']) {
                $dog['dog_id'] = $this->input->post('dog_id', TRUE);
                $dog_added = $this->log_model->updateDog($dog);
                if ($dog_added) {
                    // update the dogs in the session
                    foreach ($_SESSION['dogs'] as $k => $v) {
                        if ($v['dogID'] === $dog['dog_id']) {
                            $_SESSION['dogs'][$k]['dogName'] = $dog['name'];
                            $_SESSION['dogs'][$k]['gender'] = $dog['gender'];
                            $_SESSION['dogs'][$k]['spayneuter'] = $dog['neutered'];
                            $_SESSION['dogs'][$k]['breed'] = $dog['breed'];
                            $_SESSION['dogs'][$k]['dogWeight'] = $dog['weight'];
                            $_SESSION['dogs'][$k]['dogLength'] = $dog['length'];
                            $_SESSION['dogs'][$k]['dogHeight'] = $dog['height'];
                            $_SESSION['dogs'][$k]['dogColor'] = $dog['color'];
                            $_SESSION['dogs'][$k]['dogFeatures'] = $dog['features'];
                            $_SESSION['dogs'][$k]['dogAltName'] = $dog['alt_name'];
                            $_SESSION['dogs'][$k]['dogBirthdate'] = $dog['birth_date'];
                            $_SESSION['dogs'][$k]['dogFear'] = $dog['fears'];
                            $_SESSION['dogs'][$k]['dogAfflictions'] = $dog['afflictions'];
                            $_SESSION['dogs'][$k]['chipped'] = $dog['chipped'];
                            $_SESSION['dogs'][$k]['chip_brand'] = $dog['chip_brand'];
                            $_SESSION['dogs'][$k]['chip_id'] = $dog['chip_id'];
                            $_SESSION['dogs'][$k]['commands'] = $dog['commands'];
                            break;
                        } else {
                            continue;
                        }
                    }
                }
            } else {
                $dog_added = $this->log_model->addDog($dog);
            }
            if ($dog_added['success'] && !$dog['update']) {
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
    
    public function getDogInfo() {
        $resp = array();
        $resp['success'] = false;
        $dogID = $this->input->post('dogID', TRUE);
        $activity = $this->input->post('activity', TRUE);
        if ($dogID) {
            $this->load->model('login_model');
            $dogInfo = $this->login_model->fetchDog($dogID);
            if (is_array($dogInfo)) {
                $resp['dog'] = $dogInfo;
                switch ($activity) {
                    case 'walk' :
                        $resp['dog']['latest_walk'] = $this->getLatestWalk($dogID);
                        break;
                    case 'meal' :
                        $resp['dog']['latest_meal'] = $this->getLatestMeal($dogID);
                        break;
                    case 'treat' :
                        $resp['dog']['latest_treat'] = $this->getLatestTreat($dogID);
                        break;
                    case 'med' :
                        $resp['dog']['latest_med'] = $this->getLatestMed($dogID);
                        break;
                    case 'quick_look' :
                        $resp['dog']['latest_quick_look'] = 'not yet there';
                        $this->load->model('log_model');
                        $resp['dog']['quick_look'] = $this->log_model->retrieveLatestData($dogID);
                        if (isset($resp['dog']['quick_look']['none']) && $resp['dog']['quick_look']['none']) {
                            $resp['html'] = "We don't have any logged data for this dog. Sorry!";
                        } else {
                            // generate the HTML
                            $resp['html'] = '<form>';
                            foreach ($resp['dog']['quick_look'] as $k => $v) {
                                $renderDate = $k;
                                if (date('Y-m-d') === $renderDate) {
                                    $renderDate = 'Today';
                                } else {
                                    $date_parts = explode('-', $k);
                                    $date_parts[1] = ltrim($date_parts[1], '0');
                                    $date_parts[2] = ltrim($date_parts[2], '0');
                                    $renderDate = $this->_months[$date_parts[1]];
                                    $renderDate .= ' ' . $date_parts[2];
                                }
                                $renderDate .= ':';
                                $resp['html'] .= '<fieldset><legend>' . $renderDate . '</legend>';
                                foreach ($v as $vk => $vv) {
                                    $time_parts = explode(':', $vk);
                                    // parse 24-hour format down to 12
                                    $light = 'am';
                                    if ($time_parts[0] === '00') {
                                        $hour = 12;
                                        if ($time_parts[1] === '00') {
                                            $light = ' midnight';
                                        }
                                    } else {
                                        $hour = (int)$time_parts[0];
                                        if ($hour > 11) {
                                            if ($hour === '12' && $time_parts[1] === '00') {
                                                $light = ' noon';
                                            } else {
                                                if ($hour > 12) {
                                                    $hour -= 12;
                                                }
                                                $light = 'pm';
                                            }
                                        }
                                    }
                                    switch ($vv['activity']) {
                                        case 'walk':
                                            $v_activity = 'Went for a walk ';
                                            break;
                                        case 'med':
                                            $v_activity = 'Took some medicine ';
                                            break;
                                        case 'treat':
                                            $v_activity = 'Had a treat ';
                                            break;
                                        case 'meal':
                                            $v_activity = 'Ate ';
                                    }
                                    if (!empty($vv['notes'])) {
                                        $v_activity .= '(' . $vv['notes'] . ')';
                                    }

                                    $resp['html'] .= $hour . ':' . $time_parts[1] . $light . ': ' . $v_activity . '<br />';
                                }
                                $resp['html'] .= '</fieldset>';
                            }
                            $resp['html'] .= '</form>';
                        }
                        break;
                }
                $resp['success'] = true;
            }
        }
        
        echo json_encode($resp);
        exit();
    }
    
    public function getLatestWalk($dogID) {
        $this->load->model('log_model');
        $walkInfo = $this->log_model->retrieveLatestWalk($dogID);
        if ($walkInfo['action'] > -1) {
            $now = time();
            $walkdate = strtotime($walkInfo['datetime']);
            $tempdatetime = new DateTime($walkInfo['datetime']);
            $timediff = (int)floor(($now - $walkdate) / 86400);
            if ($timediff === 0) {
                $walkInfo['date'] = 'today';
            } else if ($timediff === 1) {
                $walkInfo['date'] = 'yesterday'; 
            } else if ($timediff > 2 && $timediff < 7) {
                $walkInfo['date'] = date_format($tempdatetime,'l');
            } else {
                $walkInfo['date'] = date_format($tempdatetime,'F j');
            }
            $walkInfo['time'] = date_format($tempdatetime,'g:i a');
        }
        return $walkInfo;
    }

    public function getLatestMeal($dogID) {
        $this->load->model('log_model');
        $mealInfo = $this->log_model->retrieveLatestMeal($dogID);
        if (isset($mealInfo['datetime'])) {
            $now = time();
            $mealdate = strtotime($mealInfo['datetime']);
            $tempdatetime = new DateTime($mealInfo['datetime']);
            $timediff = (int)floor(($now - $mealdate) / 86400);
            if ($timediff === 0) {
                $mealInfo['date'] = 'today';
            } else if ($timediff === 1) {
                $mealInfo['date'] = 'yesterday'; 
            } else if ($timediff > 2 && $timediff < 7) {
                $mealInfo['date'] = date_format($tempdatetime,'l');
            } else {
                $mealInfo['date'] = date_format($tempdatetime,'F j');
            }
            $mealInfo['time'] = date_format($tempdatetime,'g:i a');
        }
        return $mealInfo;
    }
    
    public function getLatestTreat($dogID) {
        $this->load->model('log_model');
        $treatInfo = $this->log_model->retrieveLatestTreat($dogID);
        if (isset($treatInfo['datetime'])) {
            $now = time();
            $treatdate = strtotime($treatInfo['datetime']);
            $tempdatetime = new DateTime($treatInfo['datetime']);
            $timediff = (int)floor(($now - $treatdate) / 86400);
            if ($timediff === 0) {
                $treatInfo['date'] = 'today';
            } else if ($timediff === 1) {
                $treatInfo['date'] = 'yesterday'; 
            } else if ($timediff > 2 && $timediff < 7) {
                $treatInfo['date'] = date_format($tempdatetime,'l');
            } else {
                $treatInfo['date'] = date_format($tempdatetime,'F j');
            }
            $treatInfo['time'] = date_format($tempdatetime,'g:i a');
        }
        return $treatInfo;
    }

    public function getLatestMed($dogID) {
        $this->load->model('log_model');
        $medInfo = $this->log_model->retrieveLatestMed($dogID);
        if (isset($medInfo['datetime'])) {
            $now = time();
            $meddate = strtotime($medInfo['datetime']);
            $tempdatetime = new DateTime($medInfo['datetime']);
            $timediff = (int)floor(($now - $meddate) / 86400);
            if ($timediff === 0) {
                $medInfo['date'] = 'today';
            } else if ($timediff === 1) {
                $medInfo['date'] = 'yesterday'; 
            } else if ($timediff > 2 && $timediff < 7) {
                $medInfo['date'] = date_format($tempdatetime,'l');
            } else {
                $medInfo['date'] = date_format($tempdatetime,'F j');
            }
            $medInfo['time'] = date_format($tempdatetime,'g:i a');
        }
        return $medInfo;
    }
    
    public function logMeal() {
        // TODO: validation (date, missing data, etc.)
        $meal_data = array();
        $meal_data['dogID'] = $this->input->post('dogID');
        $meal_data['mealDate'] = $this->input->post('mealDate');
        $meal_data['mealNotes'] = $this->input->post('mealNotes');
        $meal_data['userID'] = $this->input->post('userID');
        $this->load->model('log_model');
        $success = $this->log_model->addMeal($meal_data);
        echo json_encode($success);
        exit();
    }
    
    public function logMed() {
        // TODO: validation (date, missing data, etc.)
        $med_data = array();
        $med_data['dogID'] = $this->input->post('dogID');
        $med_data['medDate'] = $this->input->post('medDate');
        $med_data['medNotes'] = $this->input->post('medNotes');
        $med_data['userID'] = $this->input->post('userID');
        $this->load->model('log_model');
        $success = $this->log_model->addMed($med_data);
        echo json_encode($success);
        exit();
    }
    
    public function logTreat() {
        // TODO: validation (date, missing data, etc.)
        $treat_data = array();
        $treat_data['dogID'] = $this->input->post('dogID');
        $treat_data['treatDate'] = $this->input->post('treatDate');
        $treat_data['treatNotes'] = $this->input->post('treatNotes');
        $treat_data['treatType'] = $this->input->post('treatType');
        $treat_data['userID'] = $this->input->post('userID');
        $this->load->model('log_model');
        $success = $this->log_model->addTreat($treat_data);
        echo json_encode($success);
        exit();
    }
    
    public function logWalk() {
        // TODO: validation (date, missing data, etc.)
        $walk_data = array();
        $walk_data['dogID'] = $this->input->post('dogID');
        $walk_data['walkDate'] = $this->input->post('walkDate');
        $walk_data['action'] = $this->input->post('action');
        $walk_data['walkNotes'] = $this->input->post('walkNotes');
        $walk_data['userID'] = $this->input->post('userID');
        $this->load->model('log_model');
        $success = $this->log_model->addWalk($walk_data);
        echo json_encode($success);
        exit();
    }
    
    // turns dog names and IDs into select options
    private function _getDogOptions($is_quick = false) {
        $currentUser = $this->session->userdata('eMail');
        $retrievedDogs = $this->getDogNames($currentUser);
        $currentDogs = empty($retrievedDogs) ? NULL : explode('~',$retrievedDogs);
        $dogOptions = '';
        
        if (count($currentDogs) > 1) {
            $dogOptions .= '<select id="dog_selector">';
            foreach ($currentDogs as $d) {
                $dog = explode('^', $d);
                $id = $dog[0];
                $name = $dog[1];

                $dogOptions .= '<option value="' . $id . '">' . $name . '</option>';
            }
            $dogOptions .= '</select>';
            $dogOptions .= '<input type="button" id="select_this_dog" value="';
            $dogOptions .= $is_quick ? 'Get a quick look at this dog' : 'Log this dog';
            $dogOptions .= '" />';
        } else if (count($currentDogs) === 1) {
            $dog = explode('^', $currentDogs[0]);
            $id = $dog[0];
            $name = $dog[1];
            $dogOptions .= '<input id="dog_selector" type="hidden" value="' . $id. '" />        ';
            $dogOptions .= '<script>getDogDeets("' . $id . '");</script>';
        } else { // redirect to main menu if there are no dogs; show modal first
            $dogOptions .= '<script>';
            $dogOptions .= '$(document).ready(function() {';
            $dogOptions .= '$("#ltd_error_modal_header_text").html("Cannot log a walk");';
            $dogOptions .= '$("#ltd_error_modal_text").html("There are no dogs registered to your account.");';
            $dogOptions .= "$('#ltd_error_modal').modal('show');";
            $dogOptions .= "$('#ltd_error_modal_ok').on('click',function() {";
            $dogOptions .= " location.href='/';";
            $dogOptions .= "});";
            $dogOptions .= "});</script>";
        }
        
        return $dogOptions;
    }
    
    public function popDogDeets() {
        $idx = $this->input->post('idx', TRUE);
        echo json_encode($_SESSION['dogs'][$idx]);
        exit();
    }
    
    public function getCaretakers() {
        $dog_id = $this->input->post('dog_id', TRUE);
        $this->load->model('log_model');
        $caretakers = $this->log_model->retrieveCaretakers($dog_id);
        echo json_encode($caretakers);
        exit();
    }
    
    public function removeCaretaker() {
        $id = $this->input->post('id', TRUE);
        $this->load->model('log_model');
        $success = $this->log_model->deleteCaretaker($id);
        echo json_encode($success);
        exit();
    }
    
    public function editCaretaker() {
        $ct = array(
            'id' => $this->input->post('id', TRUE),
            'caretakerName' => $this->input->post('caretakerName', TRUE),
            'caretakerEmail' => $this->input->post('caretakerEmail', TRUE)
        );
        $this->load->model('log_model');
        $success = $this->log_model->updateCaretaker($ct);
        echo json_encode($success);
        exit();
    }
    
    function newCaretaker() {
        $ct = array(
            'dogID' => $this->input->post('dogID', TRUE),
            'caretakerName' => $this->input->post('caretakerName', TRUE),
            'caretakerEmail' => $this->input->post('caretakerEmail', TRUE)
        );
        $this->load->model('log_model');
        $success = $this->log_model->insertCaretaker($ct);
        echo json_encode($success);
        exit();
    }
}
