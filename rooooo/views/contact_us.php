<?php
    echo link_tag(base_url().'css/formValidation.css');
    echo '<script src="'.base_url().'js/base.js"></script>';
    echo '<script src="'.base_url().'js/helper.js"></script>';
    echo '<script src="'.base_url().'js/home.js"></script>';
    echo '<script src="'.base_url().'js/home.js"></script>';
    echo '<script src="'.base_url().'js/home.js"></script>';
?>
<div id="cactus" class="container">
    <form class="form-inline">
        <div class="row">
            <h1>Contact Us</h1>
        </div>
        <div class="row">
            <div class="col-xs-2 bottom5 top5">
                Your name:
            </div>
            <div class="col-xs-10 bottom5 top5">
                <input type="text" class="col-xs-2 rpad3" id="cu_first_name" name="cu_first_name" placeholder="First Name" />
                <span class="col-xs-1"></span>
                <input type="text" class="col-xs-2 rpad3" id="cu_last_name" name="cu_last_name" placeholder="Last Name" />
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
    </form>
</div>