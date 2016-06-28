<?php
    echo link_tag(base_url().'css/formValidation.css');
    echo link_tag(base_url().'css/main.css');
    echo '<script src="'.base_url().'js/home.js"></script>';
    $this->load->view('ruthie_graphic');
?>
<div id="new_user" class="container">
    <?php
        $form_attribs = array(
            'class' => 'form-inline',
            'id' => 'ltd_new_user_form'
        );
        echo form_open('',$form_attribs);
    ?>
        <div id="create_account" class="container">
        <div class="row">
            <h1>Create Account</h1>
        </div>
        <div class="row">
            <div class="col-xs-12 bottom5 top5">
                Your name:<br />
                <input type="text" class="col-xs-10" id="user_name" name="user_name" placeholder="Name" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 bottom5 top5">
                Your e-mail address:<br />
                <input class="col-xs-10" type="email" id="user_email" name="user_email" placeholder="someone@somewhere.com" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 bottom5 top5">
                Please enter your e-mail again:<br />
                <input class="col-xs-10" type="email" id="user_remail" name="user_remail" placeholder="someone@somewhere.com" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 bottom5 top5">
                Choose a password: 
                <span class="hidden-xs hidden-sm fine-print">
                    (Your password must be at least 8 characters and contain at least one lower-case 
                    letter, one upper-case letter, and one number.)
                </span><br />
                <input class="col-xs-10" type="password" id="user_password" name="user_password" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 bottom5 top5">
                Please type your password again:<br />
                <input class="col-xs-10" type="password" id="re_pass" name="re_pass" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 bottom5 top5">
            </div>
            <div class="col-xs-8 bottom5 top5">
                <input type="button" value="Create Account" onclick="submitCreate();"/>
            </div>
        </div>
    <?= form_close(); ?>
</div>