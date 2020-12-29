<?php
    echo link_tag(base_url().'css/walk.css');
    echo link_tag(base_url().'css/jquery.datepick.css');
    echo '<script src="' . base_url() . 'js/jquery.plugin.js"></script>';
    echo '<script src="' . base_url() . 'js/jquery.datepick.min.js"></script>';
    $form_attribs = array(
        'class' => 'form-inline',
        'id' => 'log_form',
    );
    echo form_open('',$form_attribs);
    echo $dogs;
?>

<div id="doggie_data" class="container">
    <div class="row">
        <h3><span class="dogName"></span>'s Details</h3>
    </div>
    <div class="row bottom5">
        <span id="gender_potty"></span> <span id="when_potty_was"></span>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Date of this potty:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="potty_date_container">
            <input id="potty_date" type="text" />
            <input id="user_id" type="hidden" value="<?php echo $this->session->userdata('userID'); ?>"/>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Time of this potty:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="potty_time_container">
            <input id="potty_time" type="text" /> &nbsp;
            <input id="potty_seconds" type="hidden" />
            <select class="top5" id="potty_ampm">
                <option value='am'>am</option>
                <option value='pm'>pm</option>
            </select>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            <span class="dogName"></span> did the following:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="potty_actions">
            <input id="num1" type="checkbox" /> <?php echo PEED; ?> <br />
            <input id="num2" type="checkbox" /> <?php echo POOPED; ?> <br />
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Additional info:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="potty_notes_container">
            <textarea id="walk_notes" rows="2" cols="36"></textarea>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <input class="pull-right" id="potty_submit" type="button" value="Submit Potty" onclick="submitPotty();" />
        </div>
        <div class="col-lg-6"></div>
    </div>
</div>
<?php
for ($x = 0; $x < 5; $x++) {
    echo '&nbsp;<br />';
}
echo form_close();
?>
