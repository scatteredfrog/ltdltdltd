<?= link_tag(base_url().'css/main_menu.css'); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
        <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox">
            <img src="/assets/images/menu_feed.png" class="img-responsive" />
            <div class="menuText">Log a Meal</div>
        </div>
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
        <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox">
            <img src="/assets/images/menu_treat.png" class="img-responsive" />
            <div class="menuText">Log a Treat</div>
        </div>
        <a class="menuAnchor" href="/log/register_dog">
            <div class="col-xs-4 col-lg-2 col-md-3 col-sm-4 menuBox" data-toggle="tooltip" data-placement="right" title="Register a dog to your account">
                <img src="/assets/images/menu_registry.png" class="img-responsive" />
                <div class="menuText"><span class="hidden-xs">Dog </span>Registry</div>
            </div>
        </a>
        <div class="col-xs-2 col-lg-4 col-md-3 col-sm-2"></div>
    </div>
</div>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>