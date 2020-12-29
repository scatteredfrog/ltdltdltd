<?php echo link_tag(base_url().'css/main_menu.css'); ?>
<script src="/js/home.js"></script>
<?php echo form_open(); ?>
<!--_______________________________ NOT PHONE ________________________________-->
<div class="container landscapeOnly">
    <div class="row">
        <div class="col-xs-4 col-lg-4 col-md-4 col-sm-4"></div>
        <a class="menuAnchor" href="/edit/edit_meal">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 blueBox">
                <img src="/assets/images/menu_feed.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Edit </span>Meals</div>
            </div>
        </a>
        <a class="menuAnchor" href="/edit/edit_walk">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 blueBox">
                <img src="/assets/images/menu_dogwalk.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Edit </span>Walks</div>
            </div>
        </a>
        <div class="col-xs-4 col-lg-4 col-md-4 col-sm-4"></div>
    </div>
    <div class="row">
        <div class="col-xs-4 col-lg-4 col-md-4 col-sm-4"></div>
        <a class="menuAnchor" href="/edit/edit_treat">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 blueBox">
                <img src="/assets/images/menu_treat.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Edit </span>Treats</div>
            </div>
        </a>
        <a class="menuAnchor" href="/edit/edit_med">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 blueBox">
                <img src="/assets/images/menu_meds.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs hidden-md hidden-sm">Edit </span>Medicine</div>
            </div>
        </a>
        <div class="col-xs-4 col-lg-4 col-md-4 col-sm-4"></div>
    </div>
</div>
<!--________________________ PHONE __________________________-->
<div class="container phoneOnly">
    <div class="row">
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
        <a class="menuAnchor" href="/edit/edit_meal">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 blueBox">
                <img src="/assets/images/menu_feed.png" class="img-responsive" />
                <div class="menuText">Edit Meals</div>
            </div>
        </a>
        <a class="menuAnchor" href="/edit/edit_walk">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 blueBox">
                <img src="/assets/images/menu_dogwalk.png" class="img-responsive" />
                <div class="menuText">Edit Walks</div>
            </div>
        </a>
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
        <a class="menuAnchor" href="/edit/edit_treat">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 blueBox">
                <img src="/assets/images/menu_treat.png" class="img-responsive" />
                <div class="menuText">Edit Treats</div>
            </div>
        </a>
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
        <a class="menuAnchor" href="/edit/edit_med">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 blueBox">
                <img src="/assets/images/menu_meds.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Edit </span>Medicine</div>
            </div>
        </a>
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
    </div>
</div>

<div id="ql_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id='ql_modal_header_text' class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <h4 id='ql_modal_subheader'></h4>
                <p id='ql_modal_text'></p>
            </div>
            <div class="modal-footer">
                <button id='ql_modal_ok' class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>