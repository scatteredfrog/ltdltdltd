<?php echo form_open();  ?>
<fieldset class="container">
    <legend class="h1">
        Your Details
    </legend>
    <div class="row">
        <div class="col-xs-12 col-lg-6 bottom5 top5">
            <span class="bold">User name:</span><br />
            <input type="text" onchange="hideYay();" class="col-lg-6 col-xs-10" id="username" name="username" value="<?php echo $username; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-6 bottom5 top5">
            <span class="bold">E-mail address:</span><br />
            <input type="text" onchange="hideYay();" class="col-xs-10 col-lg-6  " id="email" name="email" value="<?php echo $eMail; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5">
            <span class="bold">Language preference:</span><br />
            <input type="radio" name="language" value="0" onchange="hideYay();" 
                <?php if ($language == 0) { ?> checked="checked"<?php } ?> /> professional (log when my dog 'urinates' and 'defecates')<br />
            <input type="radio" name="language" value="1" onchange="hideYay();" 
                <?php if ($language == 1) { ?>
                   checked="checked"
                <?php } ?>
            /> numeric (log when my dog 'does #1' and '#2')<br />
            <input type="radio" name="language" value="2" onchange="hideYay();" 
                <?php if ($language == 2) { ?>
                   checked="checked"
                <?php } ?>
            /> slang (log when my dog 'pees' and 'poops')<br />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5">
            <span class="bold">"Quick Look" preference:</span><br />
            I want Quick Look to show me the last
            <input id="ql_num" type="number" value ="<?php echo $this->session->userdata('ql_num') ?>" max="100" min="1" /> activities logged in 
            <select id="ql_ord">
                <option value="0" <?php if (!$this->session->userdata('ql_ord')) { echo 'selected'; }?>>descending</option>
                <option value="1" <?php if ($this->session->userdata('ql_ord')) { echo 'selected'; } ?>>ascending</option>
            </select> order.
        </div>
    </div>
</fieldset>
<fieldset class="container top5">
    <legend class="h1">Your Registered Dogs</legend>
    <div id="dog_list_container" class="container col-lg-6">
    <?php
        $x = 0;
        foreach($dogs as $dog) {
            echo '<div class="row bdr-bot dog-row';
            if ($x % 2 !== 0) {
                echo ' oddReg';
            }
            echo '">';                                 // START ROW
            echo '<div class="col-lg-7 bottom5">';     // START DOG INFO
            echo $dog['name'] . ' ';
            if (!empty($dog['breed'])) {
                echo '(' . $dog['breed'] . ')';
            }
            echo '</div>';                              // END DOG INFO
            echo '<div class="col-lg-5"><input class="thinButt pull-right" type="button" value="UNREGISTER" />';
            echo '<input class="thinButt pull-right" type="button" value="EDIT"></div>';
            echo '</div>';                              // END ROW
            $x++;
        }
    ?>
    </div>
</fieldset>
<fieldset class="container">
    <div class="row">
        <br />
        <div class="col-xs-6 bottom5 top5">
            <input type="button" value="Save Changes" onclick="saveAccountChanges();" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bottom5 top5 text-center yay-update">
            Your information has been updated!
        </div>
    </div>
</fieldset>
<?php
    echo form_close();
    for ($x = 0; $x < 5; $x++) {
        echo '&nbsp;<br />';
    }
    echo form_close();
?>
