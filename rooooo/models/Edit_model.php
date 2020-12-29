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
        
        // fields: walkID, dogID, walkDate, action, walkNotes, userID
        public function retrieveWalks($dogID, $reversed) {
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
                    $walks[$x]['action'] = $row->action;
                    $walks[$x]['walkNotes'] = $row->walkNotes;
                    $x++;
                }
            }
            
            if ($reversed) {
                $walks = array_reverse($walks);
            }
            return $walks;
        }
        
        public function deleteMeal($id) {
            $retArray['success'] = $this->db->delete('LTDtbMeal', array('mealID' => $id));
            return $retArray;
        }

        public function deleteWalk($id) {
            $retArray['success'] = $this->db->delete('LTDtbWalk', array('walkID' => $id));
            return $retArray;
        }
        
        public function updateMeal($mealData) {
            $mealID = $mealData['mealID'];
            unset($mealData['mealID']);
            $this->db->where('mealID', $mealID);
            $retArray['success'] = $this->db->update('LTDtbMeal', $mealData);
            return $retArray;
        }
        
        public function updateWalk($walkData) {
            $walkID = $walkData['walkID'];
            unset($walkData['walkID']);
            $this->db->where('walkID', $walkID);
            $retArray['success'] = $this->db->update('LTDtbWalk', $walkData);
            return $retArray;
        }

        
    }
