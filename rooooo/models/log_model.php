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
        
        // Retrieve all dogs assigned to a care taker, return names and IDs
        /** 
         * 
         * @param string $caretaker
         * @param boolean $is_account
         * @return string
         */
        public function retrieveDogNames($caretaker, $is_account) {
            $select_stuff = 'c.dogID, d.dogName';
            if ($is_account) {
                $select_stuff .= ', d.breed';
            }
            $this->db->select($select_stuff);
            $this->db->from('LTDtbCaretaker c, LTDtbDog d');
            $this->db->where('c.dogID = d.dogID');
            $this->db->where(array('c.caretakerEmail' => $caretaker));
            $query = $this->db->get();
            $dogInfo = '';
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    if (strlen($dogInfo) > 0) {
                        $dogInfo .= '~';
                    }
                    $dogInfo .= $row->dogID .= '^';
                    $dogInfo .= $row->dogName;
                    if ($is_account) {
                        $dogInfo .= '*' . $row->breed;
                    }
                }
            }
            return $dogInfo;
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
        
        public function retrieveLatestWalk($dogID) {
            $retArray = array();
            $retArray['action'] = -1;
            // action: 1 = #1, 2 = #2, 3 = both, 0 = neither
            $this->db->select('walkDate,action,walkNotes');
            $this->db->from('LTDtbWalk');
            $this->db->where(array('dogID' => $dogID));
            $this->db->order_by('walkDate', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $retArray['datetime'] = $row->walkDate;
                $retArray['action'] = $row->action;
                $retArray['notes'] = $row->walkNotes;
            }
            return $retArray;
        }
        
        public function retrieveLatestMeal($dogID) {
            $retArray = array();
            $this->db->select('mealDate,mealNotes');
            $this->db->from('LTDtbMeal');
            $this->db->where(array('dogID' => $dogID));
            $this->db->order_by('mealDate', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $retArray['datetime'] = $row->mealDate;
                $retArray['notes'] = $row->mealNotes;
            }
            return $retArray;
        }

        public function addWalk($walkData) {
            $success = false;
            $retArray = array();
            $insert = array (
                'dogID' => $walkData['dogID'],
                'walkDate' => $walkData['walkDate'],
                'action' => $walkData['action'],
                'walkNotes' => $walkData['walkNotes'],
                'userID' => $walkData['userID'],
            );
            
            if ($this->db->insert('LTDtbWalk', $insert)) {
                $success = true;
            }
            
            $retArray['success'] = $success;
            return $retArray;
        }

        public function addMeal($mealData) {
            $success = false;
            $retArray = array();
            $insert = array (
                'dogID' => $mealData['dogID'],
                'mealDate' => $mealData['mealDate'],
                'mealNotes' => $mealData['mealNotes'],
                'userID' => $mealData['userID'],
            );
            
            if ($this->db->insert('LTDtbMeal', $insert)) {
                $success = true;
            }
            
            $retArray['success'] = $success;
            return $retArray;
        }
    }
