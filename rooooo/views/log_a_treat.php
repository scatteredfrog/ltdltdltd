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
        <span id="gender_treat"></span> <span id="when_treat_was"></span>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Date of this treat:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="treat_date_container">
            <input id='treat_date' type="text" />
            <input id="user_id" type="hidden" value="<?= $this->session->userdata('userID') ?>"/>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Time of this treat:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="treat_time_container">
            <input id="treat_time" type="text" /> &nbsp;
            <input id="treat_seconds" type="hidden" />
            <select class="top5" id="treat_ampm">
                <option value='am'>am</option>
                <option value='pm'>pm</option>
            </select>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="cox-xs-12">
            Type of treat:
        </div>
        <div class="col-xs-6 bdr-bot bottom5 top5" id="treat_type_container">
            <input id="treat_type" type="text" placeholder="(optional)" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 top5">
            Additional info:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 bdr-bot bottom5 top5" id="treat_notes_container">
            <textarea id="treat_notes" rows="2" cols="36"></textarea>
        </div>
        <div class="col-xs-6"></div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <input id="treat_submit" type="button" value="Submit Treat" onclick="submitTreat();" />
        </div>
        <div class="col-xs-6"></div>
    </div>
</div>
<?
    echo form_close();
?>
