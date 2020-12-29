<?php
    echo '<div style="position: relative; left: 7px;">';
    echo form_open('/home/beagle',array('name' => 'testerform'));
    echo '<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">';
    $solve = mt_rand(0,1);
    
    if ($solve === 1) {
        echo ' What color is the car in this picture?<br />';        
        echo img('/img/KickAssParkingSpace.jpg');
        echo '<br /><input type="hidden" name="solve" id="solve" value="1" />';
        echo ' <input name="solution" id="solution" type="text" /></span><br />';
        echo ' <input name="submit" id="submit" type="submit" value="Submit Answer" />';
    } else if ($solve === 0) {
        $number_one = mt_rand(0, 999);
        $number_two = mt_rand(0 ,999);

        $oper = mt_rand(0, 3);
        $op = '';

        switch ($oper) {
            case 0:
                $op = ' + ';
                break;
            case 1:
                $op = ' - ';
                break;
            case 2:
                $op = ' x ';
                break;
            case 3:
                $op = ' &divide; ';
                break;
            default:
                $op = ' + ';
                break;
        }

        echo ' Solve this math problem: <br />';
        echo '<br /><input type="hidden" name="solve" id="solve" value="0" />';
        echo ' <span style="font-weight: bold;">' . $number_one . $op . $number_two . ' = ';
        echo ' <input name="solution" id="solution" type="text" /></span><br />';
        echo ' <input name="submit" id="submit" type="submit" value="Submit Answer" />';
    }
    echo form_close();
    echo '</div>';