<?= link_tag(base_url().'css/main_menu.css'); ?>
<script src="/js/home.js"></script>
<?= form_open() ?>
<div class="container landscapeOnly">
    <div class="row">
        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3"></div>
        <a class="menuAnchor" href="/log/meal">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 menuBox">
                <img src="/assets/images/menu_feed.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Log a </span>Meal</div>
            </div>
        </a>
        <a class="menuAnchor" href="/log/walk">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 menuBox" id="walk_box">
                <img src="/assets/images/menu_dogwalk.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Log a </span>Walk</div>
            </div>
        </a>
        <a class="menuAnchor" href="/log/treat">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 menuBox" id="treat_box">
                <img src="/assets/images/menu_treat.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Log a </span>Treat</div>
            </div>
        </a>
        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3"></div>
    </div>
    <div class="row">
        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3"></div>
        <a class="menuAnchor" href="/log/register_dog">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 menuBox" id="register_box" data-toggle="tooltip" data-placement="right" title="Register a dog to your account">
                <img src="/assets/images/menu_registry.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs hidden-sm hidden-md">Dog </span>Registry</div>
            </div>
        </a>
        <a class="menuAnchor" href="/log/med">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 menuBox" id="med_box">
                <img src="/assets/images/menu_meds.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs hidden-md hidden-sm">Log a </span>Medicine</div>
            </div>
        </a>
        <a class="menuAnchor" onclick="quickLook();">
            <div class="col-xs-2 col-lg-2 col-md-2 col-sm-2 menuBox" id="quick_box">
                <img src="/assets/images/menu_kwik.png" class="img-responsive" />
                <div class="menuText hidden-xs">Quick Look</div>
                <div class="menuText hidden-sm hidden-md hidden-lg">Quick</div>
            </div>
        </a>
        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3"></div>
    </div>
</div>
<div class="container phoneOnly">
    <div class="row">
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
        <a class="menuAnchor" href="/log/meal">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox">
                <img src="/assets/images/menu_feed.png" class="img-responsive" />
                <div class="menuText">Log a Meal</div>
            </div>
        </a>
        <a class="menuAnchor" href="/log/walk">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox">
                <img src="/assets/images/menu_dogwalk.png" class="img-responsive" />
                <div class="menuText">Log a Walk</div>
            </div>
        </a>
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
        <a class="menuAnchor" href="/log/treat">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox">
                <img src="/assets/images/menu_treat.png" class="img-responsive" />
                <div class="menuText">Log a Treat</div>
            </div>
        </a>
        <a class="menuAnchor" href="/log/register_dog">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox" data-toggle="tooltip" data-placement="right" title="Register a dog to your account">
                <img src="/assets/images/menu_registry.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Dog </span>Registry</div>
            </div>
        </a>
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
        <a class="menuAnchor" href="/log/med">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox">
                <img src="/assets/images/menu_meds.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Log a </span>Medicine</div>
            </div>
        </a>
        <a class="menuAnchor" onclick="quickLook();">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox">
                <img src="/assets/images/menu_kwik.png" class="img-responsive" />
                <div class="menuText">Quick Look</div>
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
<?= form_close() ?>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>