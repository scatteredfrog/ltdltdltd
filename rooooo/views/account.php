<?= form_open(); ?>
<fieldset class="container">
    <legend class="h1">
        Your Details
    </legend>
    <div class="row">
        <div class="col-xs-12 col-lg-6 bottom5 top5">
            User name:<br />
            <input type="text" onchange="hideYay();" class="col-lg-6 col-xs-10" id="username" name="username" value="<?= $username ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-6 bottom5 top5">
            E-mail address:<br />
            <input type="text" onchange="hideYay();" class="col-xs-10 col-lg-6  " id="email" name="email" value="<?= $eMail ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5">
            Language preference:<br />
            <input type="radio" name="language" value="0" onchange="hideYay();" 
                <? if ($language == 0): ?> checked="checked"<? endif ?> /> professional (log when my dog 'urinates' and 'defecates')<br />
            <input type="radio" name="language" value="1" onchange="hideYay();" 
                <? if ($language == 1): ?>
                   checked="checked"
                <? endif ?>
            /> numeric (log when my dog 'does #1' and '#2')<br />
            <input type="radio" name="language" value="2" onchange="hideYay();" 
                <? if ($language == 2): ?>
                   checked="checked"
                <? endif ?>
            /> slang (log when my dog 'pees' and 'poops')<br />
        </div>
    </div>
</fieldset>
<fieldset class="container top5">
    <legend class="h1">Your Registered Dogs</legend>
    <div id="dog_list_container" class="container col-lg-6">
    <?
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
<?= form_close(); ?>
