<?php
    echo link_tag(base_url().'css/formValidation.css');
    echo link_tag(base_url().'css/main.css');
    echo '<script src="'.base_url().'js/home.js"></script>';
    $this->load->view('ruthie_graphic');
?>
<div id="cactus" class="container">
    <?php
        $form_attribs = array(
            'class' => 'form-inline',
            'id' => 'ltd_contact_form'
        );
        echo form_open('',$form_attribs);
    ?>
        <div id="cactus" class="container">
        <div class="row">
            <h1>Contact Us</h1>
        </div>
        <div class="row">
            <div class="col-xs-2 bottom5 top5">
                Your name:
            </div>
            <div class="col-xs-10 bottom5 top5">
                <input type="text" class="col-xs-5" id="cu_name" name="cu_name" placeholder="Name" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 bottom5 top5">
                Your e-mail address:
            </div>
            <div class="col-xs-10 bottom5 top5">
                <input class="col-xs-5" type="email" id="cu_email" name="cu_email" placeholder="someone@somewhere.com" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 bottom5 top5">
                Comments:
            </div>
            <div class="col-xs-10 bottom5 top5">
                <textarea class="col-xs-5" id="cu_comments" name="cu_comments"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 bottom5 top5">
            </div>
            <div class="col-xs-10 bottom5 top5">
                <input type="button" value="Submit" onclick="submitContact();"/>
            </div>
        </div>
    <?= form_close(); ?>
</div>