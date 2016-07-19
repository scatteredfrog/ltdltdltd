<?php
    class Log_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function addDog($dog) {
            $success = false;
            
            $insert = array(
                'dogName' => $dog['name'],
                'gender' => $dog['gender'],
                'spayneuter' => $dog['neutered'],
                'breed' => $dog['breed'],
                'dogWeight' => $dog['weight'],
                'dogHeight' => $dog['height'],
                'dogLength' => $dog['length'],
                'dogColor' => $dog['color'],
                'dogFeatures' => $dog['features'],
                'dogBirthdate' => $dog['birth_date'],
                'dogAltName' => $dog['alt_name'],
                'dogFear' => $dog['fears'],
                'dogAfflictions' => $dog['afflictions'],
                'chipped' => $dog['chipped'],
                'chip_brand' => $dog['chip_brand'],
                'chip_id' => $dog['chip_id'],
                'commands' => $dog['commands']
            );
            
            if ($this->db->insert('LTDtbDog', $insert)) {
                $success = true;
                $insert_id = $this->db->insert_id();
                $insert['dogID'] = $insert_id;
                // Add to session
                $_SESSION['dogs'][] = $insert;
            }
            
            $retArray = array(
                'success' => $success,
                'insert_id' => $insert_id
            );
            
            return $retArray;

        }
        
        public function addCaretaker($caretakers, $insert_id) {
            $success = false;
            
            foreach($caretakers as $k => $v) {
                $insert = array(
                    'dogID' => $insert_id,
                    'caretakerName' => $caretakers[$k]['name'],
                    'caretakerEmail' => $caretakers[$k]['email'],
                );

                if ($this->db->insert('LTDtbCaretaker', $insert)) {
                    $success = true;
                }
            }
        }
        
        public function retrieveCaretakerDog($email, $dog_name) {
            $dogs_registered = (int)0;
            $dog_ids = array();

            // Get the IDs of all dogs with that name
            $this->db->select('dogID');
            $query = $this->db->get_where('LTDtbDog', array('dogName' => $dog_name));
            if ($query->num_rows() > 0) {
                foreach($query->result() as $row) {
                    $dog_ids[] = $row->dogID;
                }
                $dog_count = count($dog_ids);
                // Check each dog match with caretaker
                for ($x = 0; $x < $dog_count; $x++) {
                    $this->db->select('dogID');
                    $query = $this->db->get_where('LTDtbCaretaker', array('caretakerEmail' => $email, 'dogID' => $dog_ids[$x]));
                    if ($query->num_rows() > 0) {
                        $dogs_registered++;
                    }
                }
            }
            
            return $dogs_registered;
        }
    }
