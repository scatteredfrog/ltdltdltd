<?php
    class Edit_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }
        
        // fields: mealID, dogID, mealDate, mealNotes, userID
        public function retrieveMeals($dogID, $reversed) {
            $meals = array();
            $this->db->select('mealID,mealDate,mealNotes');
            $this->db->where(array('dogID' => $dogID));
            $query = $this->db->get('LTDtbMeal');
            if ($query->num_rows() > 0) {
                $x = 0;
                foreach ($query->result() as $row) {
                    $meals[$x]['mealID'] = $row->mealID;
                    
                    // parse date and time
                    list($date, $time) = explode(' ', $row->mealDate);
                    list($year, $month, $day) = explode('-', $date);
                    list($hour, $minute, $second) = explode(':', $time);
                    
                    if ($hour > 11) {
                        $ampm = 'pm';
                        if ($hour > 12) {
                            $hour -= 12;
                        }
                    } else {
                        $ampm = 'am';
                    }
                    if ($hour < 10 && strlen($hour) < 2) {
                        $hour = '0' . $hour;
                    }
                    $meals[$x]['date'] = $month . '/' . $day . '/' . $year;
                    $meals[$x]['time'] = $hour . ':' . $minute . ' ' . $ampm;
                    $meals[$x]['seconds'] = $second;
                    $meals[$x]['mealNotes'] = $row->mealNotes;
                    $x++;
                }
            }
            
            if ($reversed) {
                $meals = array_reverse($meals);
            }
            return $meals;
        }

        /**
         * retrieveTreatNames($dogID)
         *
         * Get the names of the treats associated with a specific dog
         * @param $dogID
         * @return array
         */
        public function retrieveTreatNames($dogID): array {
            $dogTreats = [];
            $this->db->select('id,treatName');
            $this->db->where(array('dogId' => $dogID));
            $dogTreatQuery = $this->db->get('LTDtbTreats');
            if ($dogTreatQuery->num_rows() > 0) {
                $dtx = 0;
                foreach($dogTreatQuery->result() as $dtRow) {
                    if (!empty($dtRow->id)) {
                        $dogTreats[$dtx]['id'] = $dtRow->id;
                        $dogTreats[$dtx]['treatName'] = $dtRow->treatName;
                    }
                    $dtx++;
                }
            }
            return $dogTreats;
        }

        /**
         * retrieveMedNames($dogID)
         *
         * Get the names of the medications associated with a specific dog
         * @param $dogID
         * @return array
         */
        public function retrieveMedNames($dogID): array {
            $dogMeds = [];
            $this->db->select('id,medName');
            $this->db->where(array('dogID' => $dogID));
            $dogMedQuery = $this->db->get('LTDtbMedicine');
            if ($dogMedQuery->num_rows() > 0) {
                $dx = 0;
                foreach ($dogMedQuery->result() as $dogRow) {
                    if (!empty($dogRow->id)) {
                        $dogMeds[$dx]['id'] = $dogRow->id;
                        $dogMeds[$dx]['medName'] = $dogRow->medName;
                    }
                    $dx++;
                }
            }

            return $dogMeds;
        }

        // fields: medID, dogID, medDate, medType, medNotes, userID
        public function retrieveMeds($dogID, $reversed): array {
            $meds = [];
            $this->db->select('medID,medDate,medNotes,medType');
            $this->db->where(array('dogID' => $dogID));
            $query = $this->db->get('LTDtbMed');
            if ($query->num_rows() > 0) {
                $x = 0;
                foreach ($query->result() as $row) {
                    if (!empty($row->medType)) {
                        $this->db->select('medName');
                        $this->db->where(array('id' => $row->medType));
                        $subquery = $this->db->get('LTDtbMedicine');
                        if ($subquery->num_rows() > 0) {
                            foreach ($subquery->result() as $subrow) {
                                $meds[$x]['medType'] = $subrow->medName;
                                $meds[$x]['medTypeID'] = $row->medType;
                                break;
                            }
                        }
                    }
                    $meds[$x]['medID'] = $row->medID;

                    // parse date and time
                    list($date, $time) = explode(' ', $row->medDate);
                    list($year, $month, $day) = explode('-', $date);
                    list($hour, $minute, $second) = explode(':', $time);

                    if ($hour > 11) {
                        $ampm = 'pm';
                        if ($hour > 12) {
                            $hour -= 12;
                        }
                    } else {
                        $ampm = 'am';
                    }
                    if ($hour < 10 && strlen($hour) < 2) {
                        $hour = '0' . $hour;
                    }
                    $meds[$x]['date'] = $month . '/' . $day . '/' . $year;
                    $meds[$x]['time'] = $hour . ':' . $minute . ' ' . $ampm;
                    $meds[$x]['seconds'] = $second;
                    $meds[$x]['medNotes'] = $row->medNotes;
                    $x++;
                }
            }

            if ($reversed) {
                $meds = array_reverse($meds);
            }

            return $meds;
        }

        // fields: treatID, dogID, treatDate, treatType, treatNotes, userID
        public function retrieveTreats($dogID, $reversed): array {
            // First, get the names of treats from the database
            $treats = $treatNames = [];
            $this->db->select('id,treatName');
            $this->db->where(array('dogId' => $dogID));
            $tnQuery = $this->db->get('LTDtbTreats');
            if ($tnQuery->num_rows() > 0) {
                $tnx = 0;
                foreach ($tnQuery->result() as $tnRow) {
                    $treatNames[$tnx]['treatID'] = $tnRow->id;
                    $treatNames[$tnx]['treatName'] = $tnRow->treatName;
                    $tnx++;
                }
            }

            // Now, get the treats logged
            $this->db->select('treatID,treatDate,treatType,treatNotes');
            $this->db->where(array('dogID' => $dogID));
            $query = $this->db->get('LTDtbTreat');
            if ($query->num_rows() > 0) {
                $x = 0;
                foreach ($query->result() as $row) {
                    $treats[$x]['treatID'] = $row->treatID;

                    // parse date and time
                    list($date, $time) = explode(' ', $row->treatDate);
                    list($year, $month, $day) = explode('-', $date);
                    list($hour, $minute, $second) = explode(':', $time);

                    if ($hour > 11) {
                        $ampm = 'pm';
                        if ($hour > 12) {
                            $hour -= 12;
                        }
                    } else {
                        $ampm = 'am';
                    }
                    if ($hour < 10 && strlen($hour) < 2) {
                        $hour = '0' . $hour;
                    }
                    $treats[$x]['date'] = $month . '/' . $day . '/' . $year;
                    $treats[$x]['time'] = $hour . ':' . $minute . ' ' . $ampm;
                    $treats[$x]['seconds'] = $second;
                    $treats[$x]['treatType'] = $row->treatType;
                    if (!empty($treats[$x]['treatType']) && is_numeric($treats[$x]['treatType'])) {
                        foreach ($treatNames as $tK) {
                            if ($tK['treatID'] == $treats[$x]['treatType']) {
                                $treats[$x]['treatName'] = $tK['treatName'];
                                break;
                            }
                        }
                    }
                    $treats[$x]['treatNotes'] = $row->treatNotes;
                    $x++;
                }
            }

            if ($reversed) {
                $treats = array_reverse($treats);
            }
            return $treats;
        }

        // fields: walkID, dogID, walkDate, action, walkNotes, userID
        public function retrieveWalks($dogID, $reversed): array {
            $walks = array();
            $this->db->select('walkID,walkDate, action, walkNotes');
            $this->db->where(array('dogID' => $dogID));
            $query = $this->db->get('LTDtbWalk');
            if ($query->num_rows() > 0) {
                $x = 0;
                foreach ($query->result() as $row) {
                    $walks[$x]['walkID'] = $row->walkID;
                    
                    // parse date and time
                    list($date, $time) = explode(' ', $row->walkDate);
                    list($year, $month, $day) = explode('-', $date);
                    list($hour, $minute, $second) = explode(':', $time);
                    
                    if ($hour > 11) {
                        $ampm = 'pm';
                        if ($hour > 12) {
                            $hour -= 12;
                        }
                    } else {
                        $ampm = 'am';
                    }
                    if ($hour < 10 && strlen($hour) < 2) {
                        $hour = '0' . $hour;
                    }
                    $walks[$x]['date'] = $month . '/' . $day . '/' . $year;
                    $walks[$x]['time'] = $hour . ':' . $minute . ' ' . $ampm;
                    $walks[$x]['seconds'] = $second;
                    $walks[$x]['action'] = ($row->action != null) ? $row->action : '';
                    $walks[$x]['walkNotes'] = $row->walkNotes;
                    $x++;
                }
            }
            
            if ($reversed) {
                $walks = array_reverse($walks);
            }
            return $walks;
        }
        
        public function deleteMeal($id): array {
            $retArray['success'] = $this->db->delete('LTDtbMeal', array('mealID' => $id));
            return $retArray;
        }

        public function deleteMed($id): array {
            $retArray['success'] = $this->db->delete('LTDtbMed', array('medID' => $id));
            return $retArray;
        }

        public function deleteWalk($id): array {
            $retArray['success'] = $this->db->delete('LTDtbWalk', array('walkID' => $id));
            return $retArray;
        }
        
        public function updateMeal($mealData): array {
            $mealID = $mealData['mealID'];
            unset($mealData['mealID']);
            $this->db->where('mealID', $mealID);
            $retArray['success'] = $this->db->update('LTDtbMeal', $mealData);
            return $retArray;
        }

        public function updateMed($medData): array {
            $medID = $medData['medID'];
            unset($medData['medID']);
            unset($medData['medOther'], $medData['otherDosage'], $medData['withMeal'], $medData['otherNotes']);

            $this->db->where('medID', $medID);
            $medRetArray['success'] = $this->db->update('LTDtbMed', $medData);
            return $medRetArray;
        }

        public function updateTreat($treatData): array {
            $treatID = $treatData['treatID'];
            unset($treatData['treatID']);
            $this->db->where('treatID', $treatID);
            $treatRetArray['success'] = $this->db->update('LTDtbTreat', $treatData);
            return $treatRetArray;
        }

        public function updateWalk($walkData): array {
            $walkID = $walkData['walkID'];
            unset($walkData['walkID']);
            if (isset($walkData['activity']) && $walkData['activity'] == '') {
                $walkData['activity'] = null;
            }
            $this->db->where('walkID', $walkID);
            $retArray['success'] = $this->db->update('LTDtbWalk', $walkData);
            return $retArray;
        }

        
    }
