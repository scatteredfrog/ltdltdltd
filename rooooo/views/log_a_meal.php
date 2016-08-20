<?
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
        <span id="gender_meal"></span> <span id="when_meal_was"></span>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Date of this meal:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="meal_date_container">
            <input id='meal_date' type="text" />
            <input id="user_id" type="hidden" value="<?= $this->session->userdata('userID') ?>"/>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Time of this meal:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="meal_notes_container">
            <input id="meal_time" type="text" /> &nbsp;
            <input id="meal_seconds" type="hidden" />
            <select class="top5" id="meal_ampm">
                <option value='am'>am</option>
                <option value='pm'>pm</option>
            </select>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Additional info:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="meal_time_container">
            <textarea id="meal_notes" rows="2" cols="36"></textarea>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <input id="meal_submit" type="button" value="Submit Meal" onclick="submitMeal();" />
        </div>
        <div class="col-xs-6"></div>
    </div>
</div>
<?
    echo form_close();
?>
