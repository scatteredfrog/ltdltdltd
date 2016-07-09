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
    }
