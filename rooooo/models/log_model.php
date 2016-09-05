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

        public function retrieveLatestTreat($dogID) {
            $retArray = array();
            $this->db->select('treatDate,treatNotes');
            $this->db->from('LTDtbTreat');
            $this->db->where(array('dogID' => $dogID));
            $this->db->order_by('treatDate', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $retArray['datetime'] = $row->treatDate;
                $retArray['notes'] = $row->treatNotes;
            }
            return $retArray;
        }

        public function retrieveActivityDeets($activity, $id, $justAction = false) {
            $retArray = array();
            $table = 'LTDtb' . ucfirst($activity);
            if (($activity === 'treat') || ($activity === 'med')) {
                if ($justAction) {
                    $select = $activity . 'Type';
                } else {
                    $select = $activity . 'Date,' . $activity . 'Type,' . $activity . 'Notes';
                }
            } else if ($activity === 'walk') {
                if ($justAction) {
                    $select = 'action';
                } else {
                    $select = 'walkDate,action,walkNotes';
                }
            } else { // right now, just meal
                $select = $activity . 'Date,' . $activity . 'Notes';
            }
            
            $this->db->select($select);
            $this->db->from($table);
            $this->db->where(array($activity . 'ID' => $id));
            $query = $this->db->get();
            foreach($query->result() as $row) {
                if (!$justAction) {
                    $datetime = explode(' ',$row->$activity . 'Date');
                    $retArray['date'] = $datetime[0];
                    $retArray['time'] = $datetime[1];
                }
                if (($activity === 'treat') || ($activity === 'med')) {
                    $aEv = $activity . 'Type';
                    $retArray['type'] = $row->$aEv;
                } else if ($activity === 'walk') {
                    $retArray['action'] = $row->action;
                }
                if (!$justAction) {
                    $retArray['notes'] = $row->$activity . 'Notes';
                }
            }
            return $retArray;
        }

        public function retrieveLatestData($dogID) {
            $getArray = array();
            $retArray = array();
            $sql = "SELECT mealID lid, mealDate ldate, mealNotes lnotes, 'meal' as type FROM LTDtbMeal WHERE dogID=? ";
            $sql .= "UNION ALL ";
            $sql .= "SELECT medID lid, medDate ldate, medNotes lnotes, 'med' as type FROM LTDtbMed WHERE dogID=? ";
            $sql .= "UNION ALL ";
            $sql .= "SELECT treatID lid, treatDate ldate, treatNotes lnotes, 'treat' as type FROM LTDtbTreat WHERE dogID=? ";
            $sql .= "UNION ALL ";
            $sql .= "SELECT walkID lid, walkDate ldate, walkNotes lnotes, 'walk' as type FROM LTDtbWalk WHERE dogID=? ";
            $sql .= "ORDER BY lDate ";
            if (!$this->session->userdata('ql_ord')) {
                $sql .= ' DESC ';
            }
            $sql .= "LIMIT " . $this->session->userdata('ql_num');
            
            $query = $this->db->query($sql, array($dogID, $dogID, $dogID, $dogID));

            if ($query->num_rows() > 0) {
                $x = 0;
                foreach ($query->result() as $row) {
                    $datetime = explode(' ',$row->ldate);
                    $getArray[$x]['activity'] = $row->type;
                    $getArray[$x]['date'] = $datetime[0];
                    $getArray[$x]['time'] = $datetime[1];
                    if ($row->type === 'walk') {
                        $action = $this->retrieveActivityDeets('walk', $row->lid, true);
                        $getArray[$x]['type'] = $action['action'];
                    } else if (($row->type === 'med') || ($row->type === 'treat')) {
                        $type = $this->retrieveActivityDeets($row->type, $row->lid, true);
                        $getArray[$x]['type'] = $type['type'];
                    }
                    $getArray[$x]['notes'] = $row->lnotes;
                    $x++;
                }

                $tempDate = $getArray[0]['date'];
                $gc = count($getArray);
                for ($i = 0; $i < $gc; $i++) {
                    if ($getArray[$i]['date'] !== $tempDate) {
                        $tempDate = $getArray[$i]['date'];
                    }
                    if (isset($retArray[$tempDate][$getArray[$i]['time']]['action'])) {
                        $retArray[$tempDate][$getArray[$i]['time']]['action'] = $getArray[$i]['action'];
                    }
                    $retArray[$tempDate][$getArray[$i]['time']]['activity'] = $getArray[$i]['activity'];
                    if (isset($retArray[$tempDate][$getArray[$i]['time']]['type'])) {
                        $retArray[$tempDate][$getArray[$i]['time']]['type'] = $getArray[$i]['type'];
                    }
                    $retArray[$tempDate][$getArray[$i]['time']]['notes'] = $getArray[$i]['notes'];
                }
            } else {
                $retArray['none'] = true;
            }
            return $retArray;

        }
        
        public function retrieveLatestMed($dogID) {
            $retArray = array();
            $this->db->select('medDate,medNotes');
            $this->db->from('LTDtbMed');
            $this->db->where(array('dogID' => $dogID));
            $this->db->order_by('medDate', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $retArray['datetime'] = $row->medDate;
                $retArray['notes'] = $row->medNotes;
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

        public function addMed($medData) {
            $success = false;
            $retArray = array();
            $insert = array (
                'dogID' => $medData['dogID'],
                'medDate' => $medData['medDate'],
                'medNotes' => $medData['medNotes'],
                'userID' => $medData['userID'],
            );
            
            if ($this->db->insert('LTDtbMed', $insert)) {
                $success = true;
            }
            
            $retArray['success'] = $success;
            return $retArray;
        }

        public function addTreat($treatData) {
            $success = false;
            $retArray = array();
            $insert = array (
                'dogID' => $treatData['dogID'],
                'treatDate' => $treatData['treatDate'],
                'treatType' => $treatData['treatType'],
                'treatNotes' => $treatData['treatNotes'],
                'userID' => $treatData['userID'],
            );
            
            if ($this->db->insert('LTDtbTreat', $insert)) {
                $success = true;
            }
            
            $retArray['success'] = $success;
            return $retArray;
        }

    }
